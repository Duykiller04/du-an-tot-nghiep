<?php

namespace App\Exports;

use App\Models\ImportOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithTitle;

class ImportOrderExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
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
        return ImportOrder::with('details')->get();
    }


    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Người nhập kho',
            'Tổng cộng',
            'Ngày nhập kho',
            'Ghi chú',
            'Đơn vị',
            'ID chi tiết',
            'Id thuốc',
            'Tên thuốc',
            'Ngày nhập',
            'Số lượng',
            'Giá nhập',
            'Tổng tiền',
            'Hạn sử dụng',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($importorder): array
    {
        $data = [];
        $index = 1;
        foreach ($importorder->details as $detail) {
            $data[] = [
                $index++,                                     // STT
                $importorder->user->name,
                $importorder->total,
                $importorder->date_added,
                $importorder->note,
                $detail->import_order_id,
                $detail->unit->name,
                $detail->medicine_id,
                $detail->medication_name,
                $detail->date_added,
                $detail->quantity,
                $detail->import_price,
                $detail->total,
                $detail->expiration_date,                             
            ];
        }

        return $data;
    }

    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tất cả các cột trong hàng tiêu đề (A1 đến cột cuối) làm in đậm và căn giữa
        $columnsCount = count($this->headings()); // Số lượng cột trong tiêu đề
        $sheet->getStyle('A1:' . chr(64 + $columnsCount) . '1')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . chr(64 + $columnsCount) . '1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Áp dụng căn giữa dọc cho toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:' . chr(64 + $columnsCount) . (ImportOrder::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    public function title(): string
    {
        return $this->title;
    }
}
