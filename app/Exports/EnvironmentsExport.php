<?php

namespace App\Exports;

use App\Models\Environment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCharts;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Layout;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
//, WithCharts
class EnvironmentsExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Environment::select('id', 'time', 'temperature', 'real_temperature', 'huminity', 'real_humidity')
            ->get()
            ->map(function ($item) {
                $item->time = \Carbon\Carbon::parse($item->time)->format('H:i:s d-m-Y');
                return $item;
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Thời gian',
            'Nhiệt độ môi trường (°C)',
            'Nhiệt độ trong kho (°C)',
            'Độ ẩm môi trường (%)',
            'Độ ẩm trong kho (%)',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Định dạng phần tiêu đề (heading)
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => 'FFFF00', // Màu vàng
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Áp dụng đường viền cho tất cả các ô chứa dữ liệu
        $sheet->getStyle('A1:F' . (Environment::count() + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Tự động điều chỉnh độ rộng cột dựa trên nội dung
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);

        return $sheet;
    }
    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DATETIME, // Định dạng cột thời gian (cột B)
        ];
    }
    // public function charts()
    // {
    //     $rowCount = Environment::count() + 1;

    //     // Nhãn cho trục X (thời gian)
    //     $labels = [
    //         new DataSeriesValues('String', 'Worksheet!$B$2:$B$' . $rowCount),
    //     ];

    //     // Dữ liệu cho các đường biểu đồ
    //     $temperatureValues = new DataSeriesValues('Number', 'Worksheet!$C$2:$C$' . $rowCount);
    //     $realTemperatureValues = new DataSeriesValues('Number', 'Worksheet!$D$2:$D$' . $rowCount);
    //     $humidityValues = new DataSeriesValues('Number', 'Worksheet!$E$2:$E$' . $rowCount);
    //     $realHumidityValues = new DataSeriesValues('Number', 'Worksheet!$F$2:$F$' . $rowCount);

    //     // Series cho biểu đồ
    //     $series = new DataSeries(
    //         DataSeries::TYPE_LINECHART, // Loại biểu đồ
    //         DataSeries::GROUPING_STANDARD, // Nhóm dữ liệu
    //         range(0, 3), // Thứ tự các series
    //         [
    //             new DataSeriesValues('String', 'Worksheet!$C$1', null, 1, [], 'Nhiệt độ môi trường'),
    //             new DataSeriesValues('String', 'Worksheet!$D$1', null, 1, [], 'Nhiệt độ trong kho'),
    //             new DataSeriesValues('String', 'Worksheet!$E$1', null, 1, [], 'Độ ẩm môi trường'),
    //             new DataSeriesValues('String', 'Worksheet!$F$1', null, 1, [], 'Độ ẩm trong kho')
    //         ], // Chú giải cho từng đường
    //         $labels, // Trục X (thời gian)
    //         [$temperatureValues, $realTemperatureValues, $humidityValues, $realHumidityValues] // Dữ liệu của từng series
    //     );

    //     // Khu vực vẽ biểu đồ
    //     $plotArea = new PlotArea(null, [$series]);

    //     // Chú giải (Legend) cho biểu đồ
    //     $legend = new Legend(Legend::POSITION_RIGHT, null, true);

    //     // Tiêu đề cho biểu đồ
    //     $title = new Title('Nhiệt độ và Độ ẩm theo Thời gian');

    //     // Tạo biểu đồ
    //     $chart = new Chart(
    //         'environment_chart', // Tên biểu đồ
    //         $title, // Tiêu đề biểu đồ
    //         $legend, // Chú giải
    //         $plotArea, // Khu vực dữ liệu
    //         true, // Đường kẻ
    //         0, // Bóng đổ
    //         null, // Tiêu đề trục X
    //         null  // Tiêu đề trục Y
    //     );

    //     // Vị trí của biểu đồ trên sheet
    //     $chart->setTopLeftPosition('H2');
    //     $chart->setBottomRightPosition('P20');

    //     return $chart;
    // }


    public function columnWidths(): array
    {
        // Để các cột tự động điều chỉnh, có thể bỏ qua hàm này hoặc chỉ định độ rộng cụ thể nếu cần
        return [];
    }
}
