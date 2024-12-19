<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithTitle;

class CustomerExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
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
        return Customer::all();
    }

    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT', // Thêm STT vào tiêu đề
            'Tên khách hàng',
            'Số điện thoại',
            'Địa chỉ',
            'Email',
            'Tuổi',
            'Cân nặng',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($customer): array
    {
        static $counter = 1; // Khởi tạo bộ đếm STT

        return [
            $counter++, // STT tự động tăng
            $customer->name,
            $customer->phone,
            $customer->address,
            $customer->email,
            $customer->age,
            $customer->weight,
        ];
    }


    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:I' . (Customer::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }
    public function title(): string
    {
        return $this->title;
    }
}
