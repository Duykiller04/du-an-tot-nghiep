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
    // Lấy toàn bộ dữ liệu từ bảng 
    public function collection()
    {
        return CutDoseOrder::with('cutDoseOrderDetails')->get();
    }
    public function headings(): array
    {
        return [
            'STT',
            'Người bán',                                      // Đặt Seller lên đầu tiên
            'Tên bệnh mắc phải',
            'ID khách hàng',
            'Tên khách hàng',
            'Cân nặng',
            'Tuổi',
            'Giới tính',
            'Số điện thoại',
            'Địa chỉ',
            'Id ca làm việc',
            'Tổng giá',
            'Liều lượng',
            'Id đơn thuốc cắt liều',
            'Đơn vị',
            'Số lượng',
            'Lô thuốc'
        ];
    }
    // Ánh xạ dữ liệu của từng hàng
    public function map($cutDoseOrder): array
    {
        $data = [];

        // Kiểm tra xem có bất kỳ chi tiết đơn thuốc nào không
        if ($cutDoseOrder->cutDoseOrderDetails->isEmpty()) {
            return $data;  // Nếu không có chi tiết đơn thuốc, trả về mảng rỗng
        }

        // Duyệt qua từng chi tiết của đơn thuốc với chỉ số vòng lặp
        foreach ($cutDoseOrder->cutDoseOrderDetails as $key => $detail) {
            $data[] = [
                $key + 1,                                   // STT: Dựa vào chỉ số vòng lặp (bắt đầu từ 1)
                $cutDoseOrder->seller,                     // Seller lên đầu tiên
                $cutDoseOrder->disease->disease_name,      // Tên bệnh mắc phải
                $cutDoseOrder->customer_id,                // ID khách hàng
                $cutDoseOrder->customer_name,              // Tên khách hàng
                $cutDoseOrder->weight,                     // Cân nặng
                $cutDoseOrder->age,                        // Tuổi
                $cutDoseOrder->gender == 0 ? 'Nam' : 'Nữ', // Giới tính (Nam nếu 0, Nữ nếu 1)
                $cutDoseOrder->phone,                      // Số điện thoại
                $cutDoseOrder->address,                    // Địa chỉ
                $cutDoseOrder->shift_id,                   // ID ca làm việc
                $cutDoseOrder->total_price,                // Tổng giá
                $cutDoseOrder->dosage,                     // Liều lượng
                $detail->cut_dose_order_id,                // ID đơn thuốc cắt liều
                optional($detail->unit)->name,             // Đơn vị
                $detail->quantity,                         // Số lượng
                $detail->batch_id,                         // Lô thuốc
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
