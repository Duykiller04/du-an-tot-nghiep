<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        $catalogues = Category::query()
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('id', 'asc')
            ->get();
        if (request()->ajax()) {
            $categories = Category::query()
                ->orderBy('parent_id', 'asc')
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();

            function buildTree(array $categories, $parentId = null)
            {
                $tree = [];
                foreach ($categories as $category) {
                    if ($category['parent_id'] == $parentId) {
                        $children = buildTree($categories, $category['id']);
                        if ($children) {
                            $category['children'] = $children;
                        }
                        $tree[] = $category;
                    }
                }
                return $tree;
            }
            function flattenTree(array $tree, $depth = 0)
            {
                $flat = [];
                foreach ($tree as $node) {
                    $node['depth'] = $depth;
                    $flat[] = $node;
                    if (isset($node['children'])) {
                        $flat = array_merge($flat, flattenTree($node['children'], $depth + 1));
                        unset($node['children']);
                    }
                }
                return $flat;
            }

            $categoryTree = buildTree($categories);
            $sortedCategories = collect(flattenTree($categoryTree));

            return DataTables::of($sortedCategories)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    $indentation = str_repeat('-', $row['depth']);
                    return $indentation . e($row['name']);
                })
                ->addColumn('created_at', function ($row) {
                    return isset($row['created_at']) ? \Carbon\Carbon::parse($row['created_at'])->format('d/m/Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.catalogues.edit', $row['id']);
                    $deleteUrl = route('admin.catalogues.destroy', $row['id']);

                    return '
                        <button class="btn btn-warning edit-btn" 
                            data-id="' . $row['id'] . '" 
                            data-name="' . $row['name'] . '" 
                            data-parent-id="' . ($row['parent_id'] ?? 0) . '" 
                            data-is-active="' . ($row['is_active'] ?? 0) . '">Sửa</button>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-delete" data-id="' . $row['id'] . '">Xóa</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.catalogue.index', compact('catalogues'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $parentId = $request->input('parent_idCreate') === '0' ? null : $request->input('parent_idCreate');
        $isActive = $request->input('is_activeCreate') === '1' ? 1 : 0;

        // Lưu vào cơ sở dữ liệu
        Category::create([
            'name' => $request->input('nameCreate'),
            'parent_id' => $parentId,
            'is_active' => $isActive,
        ]);

        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được thêm thành công');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request)
    {
        try {

            $parentIdEdit = (int)$request->parent_idEdit;
            $parentId = $parentIdEdit == 0 ? null : $parentIdEdit;
            $isActive = $request->is_activeEdit === '1' ? 1 : 0;

            $category = Category::findOrFail($request->category_id);

            $name = str_replace('-', '', $request->nameEdit);
            $category->update([
                'name' => $name,
                'parent_id' => $parentId,
                'is_active' => $isActive
            ]);

            return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được sửa thành công');
        } catch (\Exception $exception) {
            Log::error('Lỗi xảy ra: ' . $exception->getMessage());
            return redirect()->route('admin.catalogues.index')->with('error', 'Cập nhật danh mục thất bại.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $catalogue = Category::findOrFail($id);

        // Kiểm tra xem có thuốc thuộc danh mục này không
        $hasMedicines = $catalogue->medicines()->exists();

        if ($hasMedicines) {
            return redirect()->route('admin.catalogues.index')
                ->with('error', 'Không thể xóa danh mục vì có thuốc đang thuộc danh mục này.');
        }
        
        Category::where('parent_id', $catalogue->id)->update(['parent_id' => null]);

        $catalogue->delete();

        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được xóa thành công');
    }
    public function getRestore()
    {
        $data = Category::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(5);
        return view('admin.catalogue.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        try {
            $categoryIds = $request->input('ids');
            if ($categoryIds) {
                Category::onlyTrashed()->whereIn('id', $categoryIds)->restore();
                return back()->with('success', 'Khôi phục bản ghi thành công.');
            } else {
                return back()->with('error', 'Không bản ghi nào cần khôi phục.');
            }
        } catch (\Exception $exception) {
            Log::error('Lỗi xảy ra: ' . $exception->getMessage());
            return back()->with('error', 'Khôi phục bản ghi thất bại.');
        }
    }
}
