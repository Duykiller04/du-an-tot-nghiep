<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Environment;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Exports\EnvironmentsExport;
use Maatwebsite\Excel\Facades\Excel;

class EnvironmentController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $environments = Environment::all();
        return view('admin.environments.index', compact('environments'));
    }
    public function export()
    {
        return Excel::download(new EnvironmentsExport, 'environments.xlsx');
    }
    public function create()
    {
        return view('admin.environments.add');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validated = $request->validate([

            'real_temperature' => 'required|numeric',
            'real_humidity' => 'required|numeric',
            'time' => 'required|date',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ], [
            'real_temperature.required' => 'Nhiệt độ thực tế phải được nhập.',
            'real_temperature.numeric' => 'Nhiệt độ thực tế phải là số.',
            'real_humidity.numeric' => 'Độ ẩm thực tế phải là số.',
            'real_humidity.required' => 'Độ ẩm thực tế phải được nhập.',
            'time.required' => 'Thời gian là bắt buộc.',
            'time.date' => 'Thời gian không hợp lệ.',
            'latitude.required' => 'Vĩ độ là bắt buộc.',
            'longitude.required' => 'Kinh độ là bắt buộc.',
        ]);

        // Gọi API để lấy dữ liệu thời tiết
        $temperature = $this->weatherService->getTemperature($validated['latitude'], $validated['longitude']);
        $humidity = $this->weatherService->getHumidity($validated['latitude'], $validated['longitude']);

        // Tạo bản ghi mới
        Environment::create([
            'storage_id' => 1,
            'time' => $validated['time'],
            'temperature' => $temperature,
            'huminity' => $humidity,
            'real_temperature' => $validated['real_temperature'],
            'real_humidity' => $validated['real_humidity'],
        ]);

        return redirect()->route('admin.environments.index')->with('success', 'Môi trường đã được thêm thành công.');
    }

    public function edit($id)
    {
        $environment = Environment::findOrFail($id);
        //dd($environment->huminity);
        return view('admin.environments.edit', compact('environment'));
    }

    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu
        $validated = $request->validate([

            'real_temperature' => 'required|numeric',
            'real_humidity' => 'required|numeric',

        ], [
            'real_temperature.required' => 'Nhiệt độ thực tế phải được nhập.',
            'real_temperature.numeric' => 'Nhiệt độ thực tế phải là số.',
            'real_humidity.numeric' => 'Độ ẩm thực tế phải là số.',
            'real_humidity.required' => 'Độ ẩm thực tế phải được nhập.',
        ]);

        $environment = Environment::findOrFail($id);
        $environment->update([

            'real_temperature' => $validated['real_temperature'],
            'real_humidity' => $validated['real_humidity'],
        ]);

        return redirect()->route('admin.environments.index')->with('success', 'Môi trường đã được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $environment = Environment::findOrFail($id);
        $environment->delete();

        return redirect()->route('admin.environments.index')->with('success', 'Môi trường đã được xóa thành công.');
    }
}
