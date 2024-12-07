<?php

namespace App\Exports;

use App\Models\CutDoseOrder;
use App\Models\ImportOrder;
use App\Models\Prescription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Concerns\WithTitle;

class PrescriptionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $title;

    // Constructor nhận tên sheet
    public function __construct($title)
    {
        $this->title = $title;
    }

    // Lấy toàn bộ dữ liệu từ bảng CutDoseOrder
    public function collection()
    {
        return Prescription::with('prescriptionDetails')->get();
    }

    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Tổng cộng',
            'Tuổi',
            'Loại bán',
            'Tên khách hàng',
            'Số điện thoại',
            'Địa chỉ',
            'Email',
            'Cân nặng',
            'Giới tính',
            'Trạng thái',
            'Id ca làm việc',
            'ID thuốc',
            'ID đơn vị',
            'ID đơn thuốc',
            'Số lượng',
            'Giá hiện tại',
            'Liều lượng',
        ];
    }

    public function map($Prescription): array
    {
        $data = [];
        $index = 1;

        // Lặp qua từng chi tiết đơn thuốc (prescriptionDetails)
        foreach ($Prescription->prescriptionDetails as $detail) {
            $data[] = [
                $index++,                               // STT
                $Prescription->total_price,                  // Tổng tiền
                $Prescription->age,                    // Tuổi
                $Prescription->type_sell,              // Loại bán
                $Prescription->customer_name,          // Tên khách hàng
                $Prescription->phone,                  // Số điện thoại
                $Prescription->address,                // Địa chỉ
                $Prescription->email,                  // Email
                $Prescription->weight,                 // Cân nặng
                $Prescription->gender == 0 ? 'Nam' : 'Nữ',   // Giới tính (sửa ở đây)
                $Prescription->status,                 // Trạng thái
                $Prescription->shift_id,               // ID ca làm việc
                optional($detail->medicine)->name,     // Tên thuốc (nếu có quan hệ medicine)
                optional($detail->unit)->name,         // Tên đơn vị (nếu có quan hệ unit)
                $detail->prescription_id,              // ID đơn thuốc trong chi tiết
                $detail->quantity,                     // Số lượng
                $detail->current_price,                // Giá hiện tại
                $detail->dosage,                       // Liều lượng
            ];
        }

        return $data;
    }


    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:R1')->getFont()->setBold(true);
        $sheet->getStyle('A1:R1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:R' . (Prescription::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    // Trả về tên sheet (tên bảng)
    public function title(): string
    {
        return $this->title;
    }
}
