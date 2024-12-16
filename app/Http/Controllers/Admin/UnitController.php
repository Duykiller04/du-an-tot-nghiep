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
        $units = Unit::query()
            ->with('children')
            ->whereNull('parent_id')
            ->orderBy('id', 'asc')
            ->get();
        if (request()->ajax()) {
            $units = Unit::query()
                ->orderBy('parent_id', 'asc')
                ->orderBy('id', 'asc')
                ->get()
                ->toArray();

            function buildTree(array $units, $parentId = null)
            {
                $tree = [];
                foreach ($units as $item) {
                    if ($item['parent_id'] == $parentId) {
                        $children = buildTree($units, $item['id']);
                        if ($children) {
                            $item['children'] = $children;
                        }
                        $tree[] = $item;
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


            $itemTree = buildTree($units);


            $sortedunits = collect(flattenTree($itemTree));

            return DataTables::of($sortedunits)
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

        $name = $request->nameEdit;
        $name = str_replace('-', '', $name);

        $parenId = $request->parent_idEdit === 0 ? null : $request->parent_idEdit;

        $unit = Unit::findOrFail($id);
        $unit->update([
            'name' => $name,
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
        $data = Unit::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
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
