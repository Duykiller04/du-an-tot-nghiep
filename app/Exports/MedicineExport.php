<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Concerns\WithTitle;


class MedicineExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    protected $title;

    // Constructor nhận tên sheet
    public function __construct($title)
    {
        $this->title = $title;
    }

    public function collection()
    {
      
        return Medicine::all();
    }

    public function headings(): array
    {
        return [
            'STT',
            'Tên danh mục',
            'Mã thuốc',
            'Tên thuốc',
            'Hoạt chất',
            'Hàm lượng',
            'Liều dùng',
            'Đường dùng (đường uống, đường tiêm)',
            'Loại',
            'Nhiệt độ',
            'Độ ẩm',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($medicine): array
    {
        return [
            $medicine->id,
            $medicine->category->name,
            $medicine->medicine_code,
            $medicine->name,
            $medicine->active_ingredient,
            $medicine->concentration,
            $medicine->dosage,
            $medicine->administration_route,
            $medicine->type_product == 0 ? 'Thuốc' : 'dụng cu',
            $medicine->temperature,
            $medicine->moisture,
        ];
    }

    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:T1')->getFont()->setBold(true); // Cập nhật phạm vi cột tới 20 cột
        $sheet->getStyle('A1:T1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:T' . (Medicine::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    // Trả về tên sheet (tên bảng)
    public function title(): string
    {
        return $this->title;
    }
}


