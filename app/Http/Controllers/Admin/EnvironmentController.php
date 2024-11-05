<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Environment;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Exports\EnvironmentsExport;
use App\Models\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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
        $storage = Storage::all();
        $location = $this->getMachineLocation(); 
        $weatherData = $this->getWeatherData($location);

        return view('admin.environments.index', [
            'environments' => $environments,
            'weatherData' => $weatherData,
            'storages' => $storage
        ]);
    }

    private function getMachineLocation()
    {
        return 'Hà Nội'; 
    }

    private function getWeatherData($location)
    {
        $apiKey = 'd3eb768e20a191025c902daa66b1203d'; 
        $encodedLocation = urlencode($location); 
        $url = "http://api.openweathermap.org/data/2.5/weather?q={$encodedLocation}&appid={$apiKey}&units=metric";
        
        // Gửi yêu cầu và lấy dữ liệu
        $response = file_get_contents($url);
        
        if ($response === FALSE) {
            // Xử lý lỗi khi không thể truy cập API
            return [
                'main' => [
                    'temp' => 'N/A',
                    'humidity' => 'N/A',
                ],
                'message' => 'Không thể truy cập dữ liệu thời tiết.'
            ];
        }
        
        return json_decode($response, true);
    }
    

    public function export()
    {
        return Excel::download(new EnvironmentsExport, 'environments.xlsx');
    }
    public function create()
    {
        $storage = Storage::all();
        $location = $this->getMachineLocation(); 
        $weatherData = $this->getWeatherData($location);
        //dd($weatherData);
        return view('admin.environments.add',['weatherData' => $weatherData,'storages' =>$storage]);
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'real_temperature' => 'required|numeric|min:-50',
            'real_humidity' => 'required|numeric|between:10,100',
            'storage_id' => 'required'
        ], [
            'storage_id.required' => 'Bạn phải chọn kho.',
            'real_temperature.required' => 'Nhiệt độ thực tế phải được nhập.',
            'real_temperature.numeric' => 'Nhiệt độ thực tế phải là số.',
            'real_temperature.min' => 'Nhiệt độ thực tế không được thấp hơn -50°C.',
            'real_humidity.required' => 'Độ ẩm thực tế phải được nhập.',
            'real_humidity.numeric' => 'Độ ẩm thực tế phải là số.',
            'real_humidity.between' => 'Độ ẩm thực tế phải nằm trong khoảng 10% đến 100%.',
        ]);
    
        // Kiểm tra nếu có lỗi
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        // // Gọi API để lấy dữ liệu thời tiết
        // $temperature = $this->weatherService->getTemperature($validated['latitude'], $validated['longitude']);
        // $humidity = $this->weatherService->getHumidity($validated['latitude'], $validated['longitude']);
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh');
        // Tạo bản ghi mới
        Environment::create([
            'storage_id' => $request->storage_id,
            'time' => $currentTime,
            'temperature' => $request->temperature,
            'huminity' => $request->huminity,
            'real_temperature' => $request->real_temperature,
            'real_humidity' => $request->real_humidity,
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
        //dd($request);
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'real_temperature' => 'required|numeric|min:-50',
            'real_humidity' => 'required|numeric|between:10,100',
            'storage_id' => 'required'
        ], [
            'storage_id.required' => 'Bạn phải chọn kho.',
            'real_temperature.required' => 'Nhiệt độ thực tế phải được nhập.',
            'real_temperature.numeric' => 'Nhiệt độ thực tế phải là số.',
            'real_temperature.min' => 'Nhiệt độ thực tế không được thấp hơn -50°C.',
            'real_humidity.required' => 'Độ ẩm thực tế phải được nhập.',
            'real_humidity.numeric' => 'Độ ẩm thực tế phải là số.',
            'real_humidity.between' => 'Độ ẩm thực tế phải nằm trong khoảng 10% đến 100%.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $environment = Environment::findOrFail($id);
        $environment->update([
            'real_temperature' => $request->real_temperature,
            'real_humidity' => $request->real_humidity,
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
