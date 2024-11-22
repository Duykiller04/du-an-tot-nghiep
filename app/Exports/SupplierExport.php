<?php

namespace App\Exports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Concerns\WithTitle;

class SupplierExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $title;

    // Constructor nhận tên sheet
    public function __construct($title)
    {
        $this->title = $title;
    }

    // Lấy toàn bộ dữ liệu từ bảng Supplier
    public function collection()
    {
        return Supplier::all();
    }

    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Mã số Thuế',
            'Tên nhà cung cấp',
            'Địa chỉ',
            'Số điện thoại',
            'Email',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($supplier): array
    {
        return [
            $supplier->id,
            $supplier->tax_code,
            $supplier->name,
            $supplier->address,
            $supplier->phone,
            $supplier->email,
        ];
    }

    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:F' . (Supplier::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    // Trả về tên sheet (tên bảng)
    public function title(): string
    {
        return $this->title;
    }
}
