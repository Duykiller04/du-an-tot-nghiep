<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Unit::with('children')->whereNull('parent_id')->orderBy('id', 'desc')->get();

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.units.edit', $row->id);
                    $deleteUrl = route('admin.units.destroy', $row->id);

                    return '
                        <a href="' . $editUrl . '" class="btn btn-warning">Sửa</a>
                        <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="ms-2">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>
                        </form>
                    ';
                })
                ->addColumn('children', function($row) {
                    $children = $row->children;
                    foreach ($children as $child) {
                        $child->edit_url = route('admin.units.edit', $child->id);
                        $child->delete_url = route('admin.units.destroy', $child->id);
                    }
                    return $children;  // Trả về danh mục con để xử lý trong JavaScript
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.unit.index');
    }

    public function create()
    {
        // Nếu bạn có cần lấy dữ liệu để chọn đơn vị cha hay không
        $units = Unit::whereNull('parent_id')->orderBy('id','desc')->get();

        return view('admin.unit.add', compact('units'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
        ], [
            'name.required' => 'Trường tên là bắt buộc.',
            'name.string' => 'Trường tên phải là chuỗi.',
            'name.max' => 'Trường tên không được vượt quá 100 ký tự.',
        ]);

        $validatedData['parent_id'] = $request->input('parent_id') === '0' ? null : $request->input('parent_id');

        Unit::create($validatedData);

        return redirect()->route('admin.units.index')->with('success', 'Đơn vị đã được thêm thành công');
    }

    public function edit(string $id)
    {
        $unit = Unit::find($id);
        if (!$unit) {
            return redirect()->route('admin.units.index')->with('error', 'Đơn vị không tồn tại');
        }

        $units = Unit::whereNull('parent_id')->where('id', '!=', $id)->orderBy('id','desc')->get();

        return view('admin.unit.edit', compact('unit', 'units'));
    }

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

        $unit = Unit::findOrFail($id);
        $unit->update($validatedData);

        return redirect()->route('admin.units.index')->with('success', 'Đơn vị đã được sửa thành công');
    }

    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);

        // Cập nhật các đơn vị con (nếu có) để không có cha
        Unit::where('parent_id', $unit->id)->update(['parent_id' => null]);

        $unit->delete();

        return redirect()->route('admin.units.index')->with('success', 'Đơn vị đã được xóa thành công');
    }
}
