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
        $catalogues = Category::query()->with('children')->orderBy('id', 'desc')->whereNull('parent_id')->get();
        if (request()->ajax()) {
            $query = Category::with('children')->orderBy('id', 'desc')->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('details-control', function () {
                    return '';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.catalogues.edit', $row->id);
                    $deleteUrl = route('admin.catalogues.destroy', $row->id);

                    return '
                        <button class="btn btn-warning edit-btn" data-id="' . $row->id . '" data-name="' . $row->name . '" data-parent-id="' . ($row->parent_id ?? 0) . '" data-is-active="' . $row->is_active . '">Sửa</button>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="ms-2">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
                        </form>
                    ';
                })
                ->addColumn('children', function ($row) {
                    $children = $row->children;
                    foreach ($children as $child) {
                        $child->edit_url = route('admin.catalogues.edit', $child->id);
                        $child->delete_url = route('admin.catalogues.destroy', $child->id);
                    }
                    return $children;  // Trả về danh mục con để xử lý trong JavaScript
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.catalogue.index', compact('catalogues'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $parentId = $request->input('parent_idEdit') === '0' ? null : $request->input('parent_id');
        $isActive = $request->input('is_activeEdit') === '1' ? 1 : 0;

        $category = Category::find($id);
        $category->name = $request->input('nameEdit');
        $category->parent_id = $parentId;
        $category->is_active = $isActive;
        $category->save();

        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được sửa thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $catalogue = Category::findOrFail($id);

        // Cập nhật danh mục con cấp đầu
        Category::where('parent_id', $catalogue->id)->update(['parent_id' => null]);

        // Chuyển các sản phẩm của danh mục bị xóa sang danh mục có id là 1
        //Medicine::where('catalogue_id', $catalogue->id)->update(['catalogue_id' => 1]);


        DB::table('categories')->where('id', $id)->delete();
        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được xóa thành công (Những loại thuốc đã xóa sẽ được chuyển qua danh mục: Không xác định)');
    }
    public function getRestore()
    {
        $data = Category::onlyTrashed()->get();
        return view('admin.catalogue.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
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
