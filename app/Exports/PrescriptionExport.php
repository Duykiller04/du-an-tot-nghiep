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
            'Người bán',
            'Tổng cộng',
            'Tên khách hàng',
            'Ghi chú',
            'Liều lượng',
            'Tuổi',
            'Số điện thoại',
            'Địa chỉ',
            'Email',
            'Cân nặng',
            'Giới tính',
            'Trạng thái',
            'Id ca làm việc',
            'Id thuốc chi tiết ',
            'ID đơn vị',
            'Số lượng',
            'Giá hiện tại',
            'Lô thuốc',
           
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
                $Prescription->seller,                 // người bán
                $Prescription->total_price,            // Tổng tiền
                $Prescription->customer_name,          // Tên khách hàng
                $Prescription->note,                   //Ghi chú
                $Prescription->dosage,                 // Liều lượng
                $Prescription->age,                    // Tuổi
                $Prescription->phone,                  // Số điện thoại
                $Prescription->address,                // Địa chỉ
                $Prescription->email,                  // Email
                $Prescription->weight,                 // Cân nặng
                $Prescription->gender == 0 ? 'Nam' : 'Nữ',   // Giới tính (sửa ở đây)
                $Prescription->status,                 // Trạng thái
                $Prescription->shift_id,               // ID ca làm việc
                $detail->prescription_id,              // ID đơn thuốc trong chi tiết
                optional($detail->unit)->name,         // Tên đơn vị (nếu có quan hệ unit)
                $detail->quantity,                     // Số lượng
                $detail->current_price,                // Giá hiện tại
                $detail->batch_id,                // Giá hiện tại
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
