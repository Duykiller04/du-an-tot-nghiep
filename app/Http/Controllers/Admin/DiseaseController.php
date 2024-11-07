<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $diseases = Disease::all();

        if (request()->ajax()) {
            $query = Disease::query();
            // Lọc theo ngày tháng nếu có
            if (request()->has('startDate') && request()->has('endDate')) {
                $startDate = request()->get('startDate');
                $endDate = request()->get('endDate');

                // Kiểm tra định dạng ngày và lọc
                if ($startDate && $endDate) {
                    // Convert to datetime to include the full day
                    $startDate = \Carbon\Carbon::parse($startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($endDate)->endOfDay();

                    $query->whereBetween('created_at', [$startDate, $endDate]);
                }
            }
            return DataTables::of($query)
                ->addColumn('image', function ($row) {
                    $url = Storage::url($row->feature_img);
                    return '<img src="' . asset($url) . '" alt="image" width="50" height="50">';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.diseases.edit', $row->id);
                    $deleteUrl = route('admin.diseases.destroy', $row->id);

                    return '
                <a href="' . $editUrl . '" class="btn btn btn-warning">Sửa</a>
                <form action="' . $deleteUrl . '" method="post" style="display:inline;" class="delete-form">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="button" class="btn btn-danger btn-delete" data-id="' . $row->id . '">Xóa</button>
                </form>
                ';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('admin.diseases.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.diseases.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    protected function uploadImage($file)
    {
        $filename = time() . '-' . $file->getClientOriginalName();
        $path = $file->storeAs('diseases_feature_img', $filename, 'public');

        return $path;
    }
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validated = $request->validate([
            'disease_name' => 'required|string|max:255',
            'symptom' => 'required|string',
            'treatment_direction' => 'required|string',
            'feature_img' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'danger_level' => 'required|in:low,medium,high',
        ], [
            'disease_name.required' => 'Tên bệnh là bắt buộc.',
            'symptom.required' => 'Triệu chứng là bắt buộc.',
            'treatment_direction.required' => 'Hướng điều trị là bắt buộc.',
            'feature_img.image' => 'Ảnh đại diện phải là một ảnh.',
            'feature_img.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png, hoặc gif.',
            'danger_level.required' => 'Mức độ nguy hiểm là bắt buộc.',
            'danger_level.in' => 'Mức độ nguy hiểm không hợp lệ.',
        ]);

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('feature_img')) {
            $feature_img_path = $this->uploadImage($request->file('feature_img'));
        } else {
            $feature_img_path = null; // Hoặc thiết lập đường dẫn mặc định nếu cần
        }
        $currentTime = Carbon::now('Asia/Ho_Chi_Minh');
        // Tạo bản ghi bệnh mới
        Disease::create([
            'disease_name' => $validated['disease_name'],
            'symptom' => $validated['symptom'],
            'treatment_direction' => $validated['treatment_direction'],
            'feature_img' => $feature_img_path,
            'danger_level' => $validated['danger_level'],
            'verify_date' => $currentTime
        ]);

        // Chuyển hướng với thông báo thành công
        return redirect()->route('admin.diseases.index')->with('success', 'Bệnh đã được thêm thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $diseases = Disease::findOrFail($id);
        return view('admin.diseases.edit', compact('diseases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validated = $request->validate([
            'disease_name' => 'required|string|max:255',
            'symptom' => 'required|string',
            'treatment_direction' => 'required|string',
            'feature_img' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            'danger_level' => 'required|in:low,medium,high',
        ], [
            'disease_name.required' => 'Tên bệnh là bắt buộc.',
            'symptom.required' => 'Triệu chứng là bắt buộc.',
            'treatment_direction.required' => 'Hướng điều trị là bắt buộc.',
            'feature_img.image' => 'Ảnh đại diện phải là một ảnh.',
            'feature_img.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png, hoặc gif.',
            'danger_level.required' => 'Mức độ nguy hiểm là bắt buộc.',
            'danger_level.in' => 'Mức độ nguy hiểm không hợp lệ.',
        ]);

        // Tìm bệnh theo ID
        $disease = Disease::findOrFail($id);

        // Cập nhật thông tin bệnh
        $disease->disease_name = $validated['disease_name'];
        $disease->symptom = $validated['symptom'];
        $disease->treatment_direction = $validated['treatment_direction'];
        $disease->danger_level = $validated['danger_level'];

        // Xử lý ảnh đại diện
        if ($request->hasFile('feature_img')) {
            // Xóa ảnh cũ nếu có
            if ($disease->feature_img) {
                Storage::delete('public/' . $disease->feature_img);
            }

            // Xử lý ảnh mới
            $feature_img_path = $this->uploadImage($request->file('feature_img'));

            // Cập nhật đường dẫn ảnh mới vào cơ sở dữ liệu
            $disease->feature_img = $feature_img_path;
        }

        // Cập nhật ngày xác minh
        $disease->verify_date = now();

        // Lưu thay đổi vào cơ sở dữ liệu
        $disease->save();

        // Chuyển hướng với thông báo thành công
        return redirect()->route('admin.diseases.index')->with('success', 'Bệnh đã được cập nhật thành công.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $item = Disease::findOrFail($id);
        if ($item->feature_img && Storage::disk('public')->exists($item->feature_img)) {
            Storage::disk('public')->delete($item->feature_img);
        }
        $item->delete();
        return redirect()->route('admin.diseases.index')->with('success', 'Bệnh đã được xóa thành công.');
    }
    public function getRestore()
    {
        $data = Disease::onlyTrashed()->get();
        return view('admin.diseases.restore', compact('data'));
    }
    public function restore(Request $request)
    {
        // dd($request->all());
        try {
            $diseaseIds = $request->input('ids');
            if ($diseaseIds) {
                Disease::onlyTrashed()->whereIn('id', $diseaseIds)->restore();
                return back()->with('success', 'Khôi phục bản ghi thành công.');
            } else {
                return back()->with('error', 'Không bản ghi nào cần khôi phục.');
            }
        } catch (\Exception $exception) {
            Log::error('Lỗi xảy ra: ' . $exception->getMessage());
            return back()->with('error', 'Khôi phục bản ghi thất bại.');
        }
    }
}
