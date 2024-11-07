<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::query()->with('children')->orderByDesc('id')->whereNull('parent_id')->get();
        if (request()->ajax()) {
            $query = Unit::with('children')->orderBy('id', 'desc')->get();

            return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d/m/Y') : '';
            })
            ->addColumn('updated_at', function ($row) {
                return $row->updated_at ? $row->updated_at->format('d/m/Y') : '';
            })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.units.edit', $row->id);
                    $deleteUrl = route('admin.units.destroy', $row->id);

                    return '
                        <button class="btn btn-warning edit-btn" data-id="' . $row->id . '" data-name="' . $row->name . '" data-parent-id="' . ($row->parent_id ?? 0) . '">Sửa</button>
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

        return view('admin.unit.index', compact('units'));
    }

    public function create()
    {
        //
    }

    public function store(StoreUnitRequest $request)
    {
        $parentId = $request->input('parent_idCreate') === 0 ? null : $request->input('parent_idCreate');

        Unit::create([
            'name' => $request->nameCreate,
            'parent_id' => $parentId
        ]);

        return redirect()->route('admin.units.index')->with('success', 'Đơn vị đã được thêm thành công');
    }

    public function edit(string $id)
    {
       //
    }

    public function update(UpdateUnitRequest $request, string $id)
    {
        $parenId = $request->input('parent_idEdit') === 0 ? null : $request->input('parent_idEdit');

        $unit = Unit::findOrFail($id);
        $unit->update([
            'name' => $request->nameEdit,
            'parent_id' => $parenId
        ]);

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
    public function getRestore()
    {
        $data = Unit::onlyTrashed()->get();
        return view('admin.unit.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $unitIds = $request->input('ids');
            if ($unitIds) {
                Unit::onlyTrashed()->whereIn('id', $unitIds)->restore();
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
