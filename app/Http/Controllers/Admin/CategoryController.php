<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $catalogues = Category::with('children')->whereNull('parent_id')->orderBy('id','desc')->get();
        return view('admin.catalogue.index', compact('catalogues'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogues = Category::query()->with('children')->orderBy('id','desc')->whereNull('parent_id')->get();

        return view('admin.catalogue.add', compact('catalogues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:100',
            
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Trường tên phải là chuỗi.',
            'name.max' => 'Trường tên không được vượt quá 100 ký tự.',
            
        ]);
        $validate['parent_id'] = $request->input('parent_id') === '0' ? null : $request->input('parent_id');
        $validate['is_active'] = $request->input('is_active') === '1' ? 1 : 0;
       

        DB::table('categories')->insert([
            'name' => $validate['name'],
            'parent_id' => $validate['parent_id'],
            'is_active' => $validate['is_active'], // giá trị mặc định
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được thêm thành công');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $catalogue = DB::table('categories')->where('id', $id)->first();
        $catalogues = Category::query()->with('children')->orderBy('id','desc')->whereNull('parent_id')->whereNot('id',$id)->get();
        if (!$catalogue) {
            return redirect()->route('admin.catalogues.index')->with('error', 'Danh mục không tồn tại');
        }
        
        return view('admin.catalogue.edit', ['catalogue' => $catalogue, 'catalogues' => $catalogues]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Trường tên phải là chuỗi.',
            'name.max' => 'Trường tên không được vượt quá 100 ký tự.',
           
        ]);
        $validatedData['parent_id'] = $request->input('parent_id') === '0' ? null : $request->input('parent_id');
        $validatedData['is_active'] = $request->input('is_active') === '1' ? 1 : 0;

        

        DB::table('categories')->where('id', $id)->update([
            'name' => $validatedData['name'],
            'parent_id' => $validatedData['parent_id'],
            'is_active' =>  $validatedData['is_active'],
            'updated_at' => now()
        ]);
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


        DB::table('categories')->where('id',$id)->delete();
        return redirect()->route('admin.catalogues.index')->with('success', 'Danh mục đã được xóa thành công (Những loại thuốc đã xóa sẽ được chuyển qua danh mục: Không xác định)');
    }
}
