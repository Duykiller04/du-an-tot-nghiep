<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InventoryAuditTemplateExport implements WithHeadings, WithMapping
{
    /**
     * Return the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tiêu đề phiếu kiểm',
            'Kho',
            'Ngày kiểm',
            'Người kiểm',
            'Ghi chú',
            'Loại thuốc',
            'Số lượng mong muốn',
            'Số lượng thực tế',
            'Chênh lệch',
            'Ghi chú chi tiết',
        ];
    }

    /**
     * Return an empty row for users to fill in data.
     *
     * @param mixed $row
     * @return array
     */
    public function map($row): array
    {
        return [
            '',  // Tiêu đề phiếu kiểm
            '',  // Kho
            '',  // Ngày kiểm
            '',  // Người kiểm
            '',  // Ghi chú
            '',  // Loại thuốc
            '',  // Số lượng mong muốn
            '',  // Số lượng thực tế
            '',  // Chênh lệch
            '',  // Ghi chú chi tiết
        ];
    }
}
