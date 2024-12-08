@extends('admin.layouts.master')

@section('title')
    Thêm đơn thuốc
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thêm đơn thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc</a></li>
                            <li class="breadcrumb-item active">Thêm đơn thuốc</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        {{-- @if ($errors->any())
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif --}}

        <form id="create-disease-form" method="POST" action="{{ route('admin.prescriptions.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Cột chính bên trái -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                        </div>
                        <div class="d-flex">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">Tên khách hàng <span class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="age">Tuổi <span class="text-danger">(*)</span></label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror"
                                        id="age" name="age" value="{{ old('age') }}">
                                    @error('age')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Điện thoại</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="weight">Cân nặng</label>
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        id="weight" name="weight" value="{{ old('weight') }}">
                                    @error('weight')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Giới tính <span class="text-danger">(*)</span></label>
                                    <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                        <option value="">Chọn giới tính</option>
                                        <option value="0" {{ old('gender') == '0' ? 'selected' : '' }}>Nam</option>
                                        <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                    @error('gender')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bệnh và ngày bán</h5>
                        </div>
                        <div class="d-flex">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="cutDosePrescription" class="form-label">Đơn thuốc mẫu</label>
                                    <select name="cutDosePrescription" id="cutDosePrescription" class="form-select select2 @error('cutDosePrescription') is-invalid @enderror">
                                        <option value="">Chọn tên đơn thuốc</option>
                                        @foreach ($cutDosePrescription as $prescription)
                                            <option value="{{ $prescription['id'] }}" {{ old('cutDosePrescription') == $prescription['id'] ? 'selected' : '' }}>
                                                {{ $prescription['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('cutDosePrescription')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="type_sell" class="form-label">Kiểu bán <span class="text-danger">(*)</span></label>
                                    <select name="type_sell" id="type_sell" class="form-select @error('type_sell') is-invalid @enderror">
                                        <option value="Bán lẻ">Bán lẻ</option>
                                        <option value="Bán giá nhập">Bán giá nhập</option>
                                        <option value="Trả lại nhà cung cấp">Trả lại nhà cung cấp</option>
                                        <option value="Xuất">Xuất</option>
                                        <option value="Hủy">Hủy</option>
                                    </select>
                                    @error('type_sell')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="sale_date">Ngày bán</label>
                                    <input type="date" class="form-control @error('sale_date') is-invalid @enderror"
                                        id="sale_date" name="sale_date" value="{{ old('sale_date', now()->format('Y-m-d')) }}" readonly>
                                    @error('sale_date')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="description">Mô tả đơn thuốc</label>
                                    <textarea name="description" id="description" cols="30" rows="13" class="form-control">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cột bên phải -->
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thuốc và dụng cụ</h5>
                        </div>
                        <div class="card-body">
                            <!-- Thông tin chi tiết thuốc -->
                            <div id="medicine-container">
                                @php
                                    $medicinesOld = old('medicines', []);
                                    $medicineCount = count($medicinesOld);
                                @endphp
                            
                                @for ($i = 0; $i < $medicineCount; $i++)
                                    <div class="row mb-3 medicine-row">
                                        <div class="col-md-2">
                                            <label for="medicine_id" class="form-label">Thuốc</label>
                                            <select name="medicines[{{ $i }}][medicine_id]" class="form-select select2">
                                                <option value="">Chọn thuốc</option>
                                                @foreach ($medicines as $id => $name)
                                                    <option value="{{ $id }}" {{ old("medicines.$i.medicine_id") == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error("medicines.$i.medicine_id")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="unit_id" class="form-label">Đơn vị</label>
                                            <select name="medicines[{{ $i }}][unit_id]" class="form-select select2">
                                                <option value="">Chọn đơn vị</option>
                                            </select>
                                            @error("medicines.$i.unit_id")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-1">
                                            <label for="quantity_storage" class="form-label">Tồn kho</label>
                                            <input type="number" name="medicines[{{ $i }}][quantity_storage]" class="form-control" value="{{ old("medicines.$i.quantity_storage") }}" disabled>
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="quantity" class="form-label">Số lượng bán</label>
                                            <input type="number" name="medicines[{{ $i }}][quantity]" class="form-control" min="1" value="{{ old("medicines.$i.quantity", 1) }}">
                                            @error("medicines.$i.quantity")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="dosage" class="form-label">Liều lượng</label>
                                            <input type="text" name="medicines[{{ $i }}][dosage]" class="form-control" value="{{ old("medicines.$i.dosage") }}">
                                            @error("medicines.$i.dosage")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="current_price" class="form-label">Thành tiền</label>
                                            <input type="number" name="medicines[{{ $i }}][current_price]" class="form-control" value="{{ old("medicines.$i.current_price") }}">
                                            @error("medicines.$i.current_price")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endfor
                            
                                @if ($medicineCount === 0) <!-- Nếu không có ô nào, thêm một ô mặc định -->
                                    <div class="row mb-3 medicine-row">
                                        <div class="col-md-2">
                                            <label for="medicine_id" class="form-label">Thuốc</label>
                                            <select name="medicines[0][medicine_id]" class="form-select select2">
                                                <option value="">Chọn thuốc</option>
                                                @foreach ($medicines as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error("medicines.0.medicine_id")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="unit_id" class="form-label">Đơn vị</label>
                                            <select name="medicines[0][unit_id]" class="form-select select2">
                                                <option value="">Chọn đơn vị</option>
                                            </select>
                                            @error("medicines.0.unit_id")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-1">
                                            <label for="quantity_storage" class="form-label">Tồn kho</label>
                                            <input type="number" name="medicines[0][quantity_storage]" class="form-control" value="" disabled>
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="quantity" class="form-label">Số lượng bán</label>
                                            <input type="number" name="medicines[0][quantity]" class="form-control" min="1" value="1">
                                            @error("medicines.0.quantity")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="dosage" class="form-label">Liều lượng</label>
                                            <input type="text" name="medicines[0][dosage]" class="form-control" value="">
                                            @error("medicines.0.dosage")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-md-2">
                                            <label for="current_price" class="form-label">Thành tiền</label>
                                            <input type="number" name="medicines[0][current_price]" class="form-control" value="">
                                            @error("medicines.0.current_price")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Nút thêm thuốc -->
                            <div class="mb-3">
                                <label for="current_price" class="form-label">Tổng tiền</label>
                                <input type="number" name="total_price" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="add-medicine">
                                    <i class="bx bx-plus-medical me-2"></i> Thêm thuốc
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <div class="col-lg-12 custom-spacing ">
        <div class="card">
            <div class="text-end m-3">
                <a href="{{ route('admin.prescriptions.index') }}">
                    <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                </a>
                <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
            </div>
        </div>
    </div>
    </form>
    </div>
@endsection

@section('style-libs')
    <!-- Plugins css -->
    <link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />

    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endsection

@section('script-libs')
    <!-- ckeditor -->
    {{-- <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script> --}}

    {{-- select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- main js --}}
    <script src="{{ asset('library/cut-dose-order.js') }}"></script>
    <script>
        const medicines = @json($medicines);
        const units = @json($units);
    </script>
    <script>
        $(document).ready(function() {
            $('#cutDosePrescription').change(function() {        
                var selectedPrescriptionId = $(this).val();
                let totalPrice = 0; // Biến để lưu tổng tiền

                // Nếu không chọn đơn thuốc, khôi phục lại phần thuốc mặc định
                if (!selectedPrescriptionId) {
                    $('#medicine-container').html(`
                <div class="row mb-3 medicine-row">
                    <div class="col-md-2">
                        <label for="medicine_id" class="form-label">Thuốc</label>
                        <select name="medicines[0][medicine_id]" class="form-select select2">
                            <option value="">Chọn thuốc</option>
                            @foreach ($medicines as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="unit_id" class="form-label">Đơn vị</label>
                        <select name="medicines[0][unit_id]" class="form-select select2">
                            <option value="">Chọn đơn vị</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label for="quantity_storage" class="form-label">Tồn kho</label>
                        <input type="number" name="medicines[0][quantity_storage]" class="form-control" disabled>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity" class="form-label">Số lượng bán</label>
                        <input type="number" name="medicines[0][quantity]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="dosage" class="form-label">Liều lượng</label>
                        <input type="text" name="medicines[0][dosage]" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="current_price" class="form-label">Thành tiền</label>
                        <input type="number" name="medicines[0][current_price]" class="form-control">
                    </div>
                </div>
            `);
                    $('input[name="total_price"]').val(0); // Reset tổng tiền về 0
                    return; // Dừng xử lý nếu không có đơn thuốc
                }

                // Gửi AJAX request để lấy thông tin thuốc
                $.ajax({
                    url: '/api/get-prescription-details',
                    method: 'GET',
                    data: {
                        id: selectedPrescriptionId
                    },
                    success: function(response) {
                        console.log(response); 
                        $('#medicine-container').empty(); // Xóa nội dung cũ
                        totalPrice = 0; // Reset tổng tiền
                        const description = document.getElementById('description');
                        description.value =  response.cutDosePrescription.description;

                        if (response.prescriptionDetails.length > 0) {
                            $.each(response.prescriptionDetails, function(index, detail) {
                                var medicineRow = `
                            <div class="row mb-3 medicine-row">
                                <div class="col-md-2">
                                    <label for="medicine_id_${index}" class="form-label">Thuốc</label>
                                    <select name="medicines[${index}][medicine_id]" class="form-select select2" disabled>
                                        <option value="">Chọn thuốc</option>
                                        <option value="${detail.medicine.id}" selected>${detail.medicine.name}</option>
                                        @foreach ($medicines as $id => $name)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="medicines[${index}][medicine_id]" value="${detail.medicine.id}">
                                </div>

                                <div class="col-md-2">
                                    <label for="unit_id_${index}" class="form-label">Đơn vị</label>
                                    <select name="medicines[${index}][unit_id]" class="form-select select2" disabled>
                                        <option value="">Chọn đơn vị</option>
                                        <option value="${detail.unit.id}" selected>${detail.unit.name}</option>
                                        @foreach ($units as $unitId => $unitName)
                                            <option value="{{ $unitId }}">{{ $unitName }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="medicines[${index}][unit_id]" value="${detail.unit.id}">
                                </div>

                                <div class="col-md-2">
                                    <label for="quantity_${index}" class="form-label">Số lượng bán</label>
                                    <input type="number" name="medicines[${index}][quantity]" class="form-control" value="${detail.quantity}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="dosage_${index}" class="form-label">Liều lượng</label>
                                    <input type="text" name="medicines[${index}][dosage]" class="form-control" value="${detail.dosage}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <label for="current_price_${index}" class="form-label">Thành tiền</label>
                                    <input type="number" name="medicines[${index}][current_price]" class="form-control" value="${detail.current_price}">
                                </div>
                            </div>
                        `;
                                $('#medicine-container').append(medicineRow);
                                totalPrice += detail.current_price * detail
                                    .quantity; // Tính tổng tiền
                            });
                        } else {
                            $('#medicine-container').append(
                                '<p>Không có thuốc nào trong đơn thuốc mẫu này.</p>'
                            );
                        }

                        // Cập nhật tổng tiền vào input
                        $('input[name="total_price"]').val(totalPrice);
                    },
                    error: function(error) {
                        console.error("Có lỗi xảy ra:", error);
                    }
                });
            });
        });
    </script>
@endsection
