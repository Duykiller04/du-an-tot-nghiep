<?php

namespace App\Exports;

use App\Models\CutDoseOrder;
use App\Models\ImportOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithTitle;

class CutDoseOrderExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
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
        return CutDoseOrder::with('cutDoseOrderDetails')->get();
    }


    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Tên bệnh mắc phải',
            'ID khách hàng',
            'Cân nặng',
            'Tuổi',
            'Giới tính',
            'Tên khách hàng',
            'Số điện thoại',
            'Địa chỉ',
            'Id ca làm việc',
            'Tổng giá',
            'Tên thuốc',
            'Id đơn thuốc cắt liều',
            'Đơn vị',
            'Số lượng',
            'Liều lượng',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($CutDoseOrder): array
    {
        $data = [];
        $index = 1;

        // Duyệt qua từng chi tiết của đơn thuốc
        foreach ($CutDoseOrder->cutDoseOrderDetails as $detail) {
            $data[] = [
                $index++,                                     // STT
                $CutDoseOrder->disease->disease_name,       // Tên bệnh
                $CutDoseOrder->customer_id,                  // ID khách hàng
                $CutDoseOrder->weight,                       // Cân nặng
                $CutDoseOrder->age,                          // Tuổi
                $CutDoseOrder->gender == 0 ? 'Nam' : 'Nữ',   // Giới tính (sửa ở đây)
                $CutDoseOrder->customer_name,                // Tên khách hàng
                $CutDoseOrder->phone,                        // Số điện thoại
                $CutDoseOrder->address,                      // Địa chỉ
                $CutDoseOrder->shift_id,                     // Id ca làm việc
                $CutDoseOrder->total_price,                  // Tổng giá
                $detail->medicine->name,           // Tên thuốc
                $detail->cut_dose_order_id,            // Id đơn thuốc cắt liều
                $detail->unit->name,               // Đơn vị
                $detail->quantity,                           // Số lượng
                $detail->dosage,                             // Liều lượng
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
        $sheet->getStyle('A2:' . chr(64 + $columnsCount) . (CutDoseOrder::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    public function title(): string
    {
        return $this->title;
    }
}
