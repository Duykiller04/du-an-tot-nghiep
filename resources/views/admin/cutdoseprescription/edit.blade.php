@extends('admin.layouts.master')

@section('title')
    Cập nhật đơn thuốc mẫu
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Cập nhật đơn thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc mẫu</a></li>
                            <li class="breadcrumb-item active">Cập nhật đơn thuốc mẫu</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        {{-- @if ($errors->any())
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif --}}

        <form id="create-disease-form" method="POST"
            action="{{ route('admin.cutDosePrescriptions.update', $cutDosePrescription) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Cột chính bên trái -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin chung</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="medicine_id" class="form-label">Bệnh (<span
                                        class="text-danger">*</span>)</label>
                                <select name="disease_id" id="disease_id" class="form-select select2">
                                    <option value="">Chọn bệnh</option>
                                    @foreach ($diseases as $id => $name)
                                        <option value="{{ $id }}"
                                            @if ($cutDosePrescription->id == $id) selected @endif>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('disease_id')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name_hospital">Tên bệnh viện (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control @error('name_hospital') is-invalid @enderror"
                                    id="name_hospital" name="name_hospital"
                                    value="{{ $cutDosePrescription->name_hospital }}">
                                @error('name_hospital')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name_doctor">Tên bác sĩ (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control @error('name_doctor') is-invalid @enderror"
                                    id="name_doctor" name="name_doctor" value="{{ $cutDosePrescription->name_doctor }}">
                                @error('name_doctor')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="age">Tuổi (<span class="text-danger">*</span>)</label>
                                <input type="number" class="form-control" id="age" name="age"
                                    value="{{ $cutDosePrescription->age }}">
                                @error('age')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone_doctor">Số điện thoại (<span
                                        class="text-danger">*</span>)</label>
                                <input type="number" class="form-control @error('phone_doctor') is-invalid @enderror"
                                    id="phone_doctor" name="phone_doctor" value="{{ $cutDosePrescription->phone_doctor }}">
                                @error('phone_doctor')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cột bên phải -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin thuốc và dụng cụ</h5>
                        </div>
                        <div class="card-body">
                            <div id="medicine-list-container">
                                <!-- Thông tin chi tiết thuốc -->
                                @foreach ($cutDosePrescription->cutDosePrescriptionDetails as $index => $item)
                                    <input type="hidden" name="medicines[{{ $index }}][id]"
                                        value="{{ $item->id }}">
                                    <div class="row mb-3 medicine-row" id="medicine-{{ $item->id }}">
                                        <div class="col-md-3">
                                            <label for="medicine_id" class="form-label">Thuốc</label>
                                            <select name="medicines[{{ $index }}][medicine_id]"
                                                class="form-select select2">
                                                <option value="">Chọn thuốc</option>
                                                @foreach ($medicines as $id => $name)
                                                    <option value="{{ $id }}"
                                                        @if ($item->medicine_id == $id) selected @endif>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="unit_id" class="form-label">Đơn vị</label>
                                            <select name="medicines[{{ $index }}][unit_id]"
                                                class="form-select select2">
                                                <option value="">Chọn đơn vị</option>
                                                @foreach ($units as $id => $name)
                                                    <option value="{{ $id }}"
                                                        @if ($item->unit_id == $id) selected @endif>
                                                        {{ $name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="quantity" class="form-label">Số lượng</label>
                                            <input type="number" name="medicines[{{ $index }}][quantity]"
                                                class="form-control" value="{{ $item->quantity }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="current_price" class="form-label">Giá</label>
                                            <input type="number" name="medicines[{{ $index }}][current_price]"
                                                class="form-control" value="{{ $item->current_price }}">
                                        </div>

                                        <div class="col-md-2">
                                            <label for="dosage" class="form-label">Liều lượng</label>
                                            <input type="text" name="medicines[{{ $index }}][dosage]"
                                                class="form-control" value="{{ $item->dosage }}">
                                        </div>
                                        @php
                                            $count = count($cutDosePrescription->cutDosePrescriptionDetails);
                                        @endphp
                                        @if ($count > 1)
                                        <div class="col-md-1  d-flex align-items-end">
                                            <button type="button" class="btn btn-danger delete-medicine" data-id="{{ $item->id }}">Xóa</button>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <!-- Nút thêm thuốc -->
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

    <!-- Nút Lưu bệnh -->
    <div class="text-end mb-3">
        <a href="{{ route('admin.cutDosePrescriptions.index') }}"><button type="button"
                class="btn btn-primary w-sm">Quay
                lại</button></a>
        <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
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
    <script src="{{ asset('library/cut-dose-prescriptions-edit.js') }}"></script>
    <script>
        const medicines = @json($medicines);
        const units = @json($units);
    </script>
@endsection
