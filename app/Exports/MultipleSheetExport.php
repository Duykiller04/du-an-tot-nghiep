<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleSheetExport implements WithMultipleSheets
{
    protected $tablesToExport;

    public function __construct(array $tablesToExport)
    {
        $this->tablesToExport = $tablesToExport;
    }

    public function sheets(): array
    {
        $sheets = [];

        if (in_array('users', $this->tablesToExport)) {
            $sheets[] = new UsersExport('Người dùng'); // Tên sheet là "Người dùng"
        }

        if (in_array('customer', $this->tablesToExport)) {
            $sheets[] = new CustomerExport('Khách hàng'); // Tên sheet là "Khách hàng"
        }

        if (in_array('suppliers', $this->tablesToExport)) {
            $sheets[] = new SupplierExport('Nhà cung cấp'); // Tên sheet là "Nhà cung cấp"
        }

        if (in_array('medicine', $this->tablesToExport)) {
            $sheets[] = new MedicineExport(' bảng Thuốc, dụng cụ'); // Tên sheet là "Thuốc"
        }

        if (in_array('batch', $this->tablesToExport)) {
            $sheets[] = new BatchExport('Lô thuốc'); // Tên sheet là "Lô"
        }

        if (in_array('DiseasesExport', $this->tablesToExport)) {
            $sheets[] = new DiseasesExport('Các loại Bệnh'); // Tên sheet là "Bệnh"
        }
        if (in_array('CutDosePrescription', $this->tablesToExport)) {
            $sheets[] = new CutDosePrescriptionExport('Đơn thuốc Mẫu'); // Tên sheet là "Đơn thuốc cắt liều"
        }

        if (in_array('CutDoseOrder', $this->tablesToExport)) {
            $sheets[] = new CutDoseOrderExport('Đơn hàng cắt liều'); // Tên sheet là "Đơn hàng cắt liều"
        }

        if (in_array('Prescription', $this->tablesToExport)) {
            $sheets[] = new PrescriptionExport('Đơn thuốc thông thường'); // Tên sheet là "Đơn thuốc"
        }

        if (in_array('storage', $this->tablesToExport)) {
            $sheets[] = new StorageExport('Kho thuốc'); // Tên sheet là "Đơn thuốc"
        }

        if (in_array('importorder', $this->tablesToExport)) {
            $sheets[] = new ImportOrderExport('Nhập kho thuốc'); // Tên sheet là "Nhập thuốc vào kho"
        }

        if (in_array('InventoryAudit', $this->tablesToExport)) {
            $sheets[] = new InventoryAuditExport('Kiểm kê kho'); // Tên sheet là "Kiểm kê kho"
        }
        return $sheets;
    }
}
