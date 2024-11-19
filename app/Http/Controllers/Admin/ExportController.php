<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MultipleSheetExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    // Hiển thị form xuất bảng
    public function showExportForm()
    {
        return view('admin.export.index'); // Trả về view export
    }

    // Xử lý xuất Excel
    public function export(Request $request)
    {
        // Lấy danh sách các bảng cần xuất từ request
        $tablesToExport = $request->input('tables', []);

        if (empty($tablesToExport)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một bảng để xuất.');
        }

        return Excel::download(new MultipleSheetExport($tablesToExport), 'danh_sach.xlsx');
    }
}
