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
    // public function index(Request $request)
    // {
    //     $query = Category::query();
    
    //     // Lọc theo ngày
    //     if ($request->has('startDate') && $request->has('endDate')) {
    //         $startDate = $request->get('startDate');
    //         $endDate = $request->get('endDate');
    
    //         if ($startDate && $endDate) {
    //             $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
    //             $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
    
    //             // Sử dụng whereBetween để lọc dữ liệu theo ngày
    //             $query->whereBetween('created_at', [$startDate, $endDate]);
    //         }
    //     }
    
    //     // Xử lý request Ajax
    //     if ($request->ajax()) {
    //         $categories = $query->select(['id', 'name', 'parent_id', 'created_at'])->get(); // Thêm $query vào đây để sử dụng bộ lọc
    
    //         $sortedCategories = $this->buildCategoryTree($categories);
    
    //         $data = collect($sortedCategories)->map(function ($category, $index) {
    //             return [
    //                 'DT_RowIndex' => $index + 1,
    //                 'id' => $category->id,
    //                 'name' => $category->name,
    //                 'created_at' => $category->created_at,
    //                 'action' => '<a href="#" class="btn btn-sm btn-primary">Edit</a>',
    //             ];
    //         });
    
    //         return response()->json(['data' => $data]);
    //     }
    
    //     $catalogues = Category::all(); // Lấy tất cả danh mục
    //     return view('admin.catalogue.index', compact('catalogues')); // Truyền vào view
    // }
    

// Hàm xây dựng cây danh mục
// private function buildCategoryTree($categories, $parentId = null, $prefix = '')
// {
//     // dd($categories->toArray());
//     $tree = [];
//     foreach ($categories as $category) {
//         if ($category->parent_id == $parentId) {
//             $category->name = $prefix . $category->name;
//             $tree[] = $category;
//             $tree = array_merge($tree, $this->buildCategoryTree($categories, $category->id, $prefix . '- '));
//         }
//     }
//     return $tree;
// }
//     private function buildCategoryTree($categories, $parentId = null, $prefix = '')
// {
//     // dd($categories->toArray());
//     $tree = [];
//     foreach ($categories as $category) {
//         if ($category->parent_id == $parentId) {
//             $category->name = $prefix . $category->name;
//             $tree[] = $category;
//             $tree = array_merge($tree, $this->buildCategoryTree($categories, $category->id, $prefix . '- '));
//         }
//     }
//     return $tree;
// }



public function index()
    {
        $catalogues = Category::query()
        ->with('children')
        ->whereNull('parent_id')
        ->orderBy('id', 'asc')
        ->get();
        
        if (request()->ajax()) {
            $query = Category::with('children')->orderBy('id', 'desc');

            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');
                
                if ($startDate && $endDate) {
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();
    
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('details-control', function () {
                    return '';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d/m/Y') : '';
                })
                ->addColumn('name', function ($row  ) {
                    // Xây dựng cây danh mục và chỉ lấy phần tử đầu tiên (category gốc)
                    $categories = Category::select(['id', 'name', 'parent_id', 'created_at'])->get();
                    $tree = $this->buildCategoryTree($categories);
                    // dd($tree);   
                    $index = array_search($row->id, array_column($tree, 'id'));
                    return $tree[$index]->name ?? '';
                })
                // ->addColumn('name', function ($row) {
                //     // Lấy tất cả danh mục
                //     $categories = Category::select(['id', 'name', 'parent_id', 'created_at'])->get();
                    
                //     // Xây dựng cây danh mục
                //     $tree = $this->buildCategoryTree($categories);
                    
                //     // Tìm danh mục cha tương ứng với ID của row
                //     $index = $this->findCategoryInTree($tree, $row->id);
                    
                //     // Trả về tên danh mục cha
                //     return $index !== null ? $tree[$index]->name : ''; 
                // })
                
                
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.catalogues.edit', $row->id);
                    $deleteUrl = route('admin.catalogues.destroy', $row->id);

                    return '
                        <button class="btn btn-warning edit-btn" data-id="' . $row->id . '" data-name="' . $row->name . '" data-parent-id="' . ($row->parent_id ?? 0) . '" data-is-active="' . $row->is_active . '">Sửa</button>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
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

    private function buildCategoryTree($categories, $parentId = null, $prefix = '')
{
    // dd($categories->toArray());
    $tree = [];
    foreach ($categories as $category) {
        if ($category->parent_id == $parentId) {
            $category->name = $prefix . $category->name;
            $tree[] = $category;
            $tree = array_merge($tree, $this->buildCategoryTree($categories, $category->id, $prefix . '- '));
        }
    }
    return $tree;
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

        Category::where('parent_id', $catalogue->id)->update(['parent_id' => null]);

        $catalogue->delete();

        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được xóa thành công');
    }
    public function getRestore()
    {
        $data = Category::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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
