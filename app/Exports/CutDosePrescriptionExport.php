<?php

namespace App\Exports;

use App\Models\CutDosePrescription;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithTitle;

class CutDosePrescriptionExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $title;
    // Constructor nhận tên sheet
    public function __construct($title)
    {
        $this->title = $title;
    }
    public function collection()
    {
        return CutDosePrescription::with('cutDosePrescriptionDetails')->get();
    }
    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Tên đơn thuốc',
            'Miêu tả Bệnh',
            'Tênh bệnh mắc phải',
            'Tên bác sĩ',
            'Tên thuốc',
            'Id đơn thuốc cắt liều',
            'Tên đơn vị',
        ];
    }
    // Ánh xạ dữ liệu của từng hàng
    public function map($CutDosePrescription): array
    {
        $data = [];
        // Dùng biến $loopIndex để theo dõi vị trí của phần tử
        $loopIndex = 1;

        // Lặp qua từng chi tiết đơn thuốc (prescriptionDetails)
        foreach ($CutDosePrescription->cutDosePrescriptionDetails as $detail) {
            $data[] = [
                $loopIndex++,   // STT dựa trên vòng lặp
                $CutDosePrescription->name,
                $CutDosePrescription->description,
                $CutDosePrescription->disease->disease_name,
                $CutDosePrescription->name_doctor,
                $detail->medicine->name,
                $detail->cut_dose_prescription_id,
                $detail->unit->name,   
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
        $sheet->getStyle('A2:' . chr(64 + $columnsCount) . (CutDosePrescription::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    public function title(): string
    {
        return $this->title;
    }
}
