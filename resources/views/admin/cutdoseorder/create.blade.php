@extends('admin.layouts.master')

@section('title')
    Thêm đơn thuốc cắt liều
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thêm đơn thuốc cắt liều</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc</a></li>
                            <li class="breadcrumb-item active">Thêm đơn thuốc cắt liều</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        {{-- @if ($errors->any())
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif --}}

        <form id="create-disease-form" method="POST" action="{{ route('admin.cutDoseOrders.store') }}"
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
                                    <label for="customer_name" class="form-label">Tên khách hàng <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                        id="customer_name" name="customer_name" value="{{ old('customer_name') }}">
                                    @error('customer_name')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="age">Tuổi <span
                                            class="text-danger">(*)</span></label>
                                    <input type="number" class="form-control @error('age') is-invalid @enderror"
                                        id="age" name="age" value="{{ old('age') }}">
                                    @error('age')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Điện thoại <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="address" class="form-label">Địa chỉ <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="weight">Cân nặng <span
                                            class="text-danger">(*)</span></label>
                                    <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                        id="weight" name="weight" value="{{ old('weight') }}">
                                    @error('weight')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Giới tính <span
                                            class="text-danger">(*)</span></label>
                                    <select name="gender" id="gender"
                                        class="form-select @error('gender') is-invalid @enderror">
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
                                    <label for="disease_id" class="form-label">Bệnh</label>
                                    <select name="disease_id" id="disease_id"
                                        class="form-select select2 @error('disease_id') is-invalid @enderror">
                                        <option value="">Chọn bệnh</option>
                                        @foreach ($diseases as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ old('disease_id') == $id ? 'selected' : '' }}>{{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('disease_id')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="sale_date">Ngày bán</label>
                                    <input type="date" class="form-control @error('sale_date') is-invalid @enderror"
                                        id="sale_date" name="sale_date"
                                        value="{{ old('sale_date', now()->format('Y-m-d')) }}" readonly>
                                    @error('sale_date')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
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
                            <h5 class="card-title mb-0">Thông tin thuốc và dụng cụ</h5>
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
                <a href="{{ route('admin.cutDoseOrders.index') }}">
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
@endsection
