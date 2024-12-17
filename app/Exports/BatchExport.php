<?php

namespace App\Exports;

use App\Models\Batch;
use App\Models\ImportOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithTitle;

class BatchExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $title;

    // Constructor nhận tên sheet
    public function __construct($title)
    {
        $this->title = $title;
    }
    // Lấy toàn bộ dữ liệu từ bảng Users
    public function collection()
    {
        return Batch::all();
    }


    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Tên thuốc',
            'Nhà cung cấp',
            'Sô đăng ký',
            'Nguồn gốc',
            'Quy cách đóng gói',
            'Giá nhập',
            'Giá bán',
            'Giá bán theo đơn vị nhỏ nhất',
            'Ngày hết hạn',
            'Kho thuốc',
            'Trạng thái hết hạn',
        ];
    }

   
    public function map($batch): array
    {
        return [
            $batch->id,
            $batch->medicine->name,
            $batch->supplier->name,
            $batch->registration_number,
            $batch->origin,
            $batch->packaging_specification,
            $batch->price_import,
            $batch->price_sale,
            $batch->price_in_smallest_unit,
            $batch->expiration_date,
            $batch->storage->name,
            $batch->status_expiry == 0 ? 'Còn hạn' : 'Hết hạn',
        ];
    }

    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:I' . (Batch::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    public function title(): string
    {
        return $this->title;
    }
}
