<?php

namespace App\Exports;

use App\Models\Disease;
use App\Models\ImportOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithTitle;

class DiseasesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
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
        return Disease::all();
    }


    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Tên bệnh',
            'Triệu chứng',
            'Hướng điều trị',
            'Mức độ nguy hiểm',
            'Ngày xác nhận',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($DiseasesExport): array
    {
        return [
            $DiseasesExport->id,
            $DiseasesExport->disease_name,
            $DiseasesExport->symptom,
            $DiseasesExport->treatment_direction,
            $DiseasesExport->danger_level,
            $DiseasesExport->verify_date,
        ];
    }

    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);



        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:I' . (Disease::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    public function title(): string
    {
        return $this->title;
    }
}
