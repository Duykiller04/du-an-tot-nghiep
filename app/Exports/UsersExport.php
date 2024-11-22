<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
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
        return User::all();
    }

    // Tiêu đề bảng
    public function headings(): array
    {
        return [
            'STT',
            'Tên người dùng',
            'Số điện thoại',
            'Địa chỉ',
            'Ngày sinh',
            'Hình ảnh',
            'Mô tả',
            'Email',
            'Mật khẩu',
            'Loại',
        ];
    }

    // Ánh xạ dữ liệu của từng hàng
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->phone,
            $user->address,
            $user->birth,
            $user->image,
            $user->description,
            $user->email,
            $user->password,
            $user->type,
        ];
    }

    // Định dạng các cột trong bảng
    public function styles($sheet)
    {
        // Đặt tên bảng (row 1) làm in đậm và căn giữa
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Định dạng toàn bộ dữ liệu từ hàng thứ 2 trở đi
        $sheet->getStyle('A2:I' . (User::count() + 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    // Trả về tên sheet (tên bảng)
    public function title(): string
    {
        return $this->title;
    }
}
