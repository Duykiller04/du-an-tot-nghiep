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
                    <h4 class="mb-sm-0">Thêm đơn thuốc mẫu</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc mẫu</a></li>
                            <li class="breadcrumb-item active">Thêm đơn thuốc mẫu</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        {{-- @if ($errors->any())
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif --}}

        <form id="create-disease-form" method="POST" action="{{ route('admin.cutDosePrescriptions.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Cột chính bên trái -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin chung</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name">Tên đơn thuốc (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Mô tả đơn thuốc</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                    rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="medicine_id" class="form-label">Bệnh (<span
                                        class="text-danger">*</span>)</label>
                                <select name="disease_id" id="disease_id" class="form-select select2">
                                    <option value="">Chọn bệnh</option>
                                    @foreach ($diseases as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ old('disease_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('disease_id')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name_doctor">Tên bác sĩ (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control @error('name_doctor') is-invalid @enderror"
                                    id="name_doctor" name="name_doctor" value="{{ Auth::user()->name }}">
                                @error('name_doctor')
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
                            <!-- Thông tin chi tiết thuốc -->
                            <div id="medicine-container">
                                <div class="row mb-3 medicine-row">
                                    <div class="col-4">
                                        <label for="medicine_id" class="form-label">Thuốc</label>
                                        <select name="medicines[0][medicine_id]" class="form-select select2">
                                            <option value="">Chọn thuốc</option>
                                            @foreach ($medicines as $id => $name)
                                                <option value="{{ $id }}"
                                                    {{ old('medicines.0.medicine_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- <div class="col-3">
                                        <label for="quantity" class="form-label" id="unitLabel-0">Số lượng</label>
                                        <input type="number" name="medicines[0][quantity]"
                                            value="{{ old('medicines.0.quantity') ?? 0 }}" class="form-control">
                                    </div>

                                    <div class="col-4">
                                        <label for="dosage" class="form-label">Liều lượng</label>
                                        <input type="text" name="medicines[0][dosage]"
                                            value="{{ old('medicines.0.dosage') }}" class="form-control">
                                    </div> --}}
                                </div>
                            </div>

                            <!-- Nút thêm thuốc -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-success" id="add-medicine">
                                    <i class="bx bx-plus-medical me-2"></i> Thêm thuốc
                                </button>
                            </div>
                        </div>
                        <!-- Nút Lưu bệnh -->
                        <div class="text-end mb-3 me-2">
                            <a href="{{ route('admin.cutDosePrescriptions.index') }}"><button type="button"
                                    class="btn btn-primary w-sm">Quay
                                    lại</button></a>
                            <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
                        </div>
                    </div>
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
    <script src="{{ asset('library/cut-dose-prescriptions.js') }}"></script>
    <script>
        const medicines = @json($medicines);
        const oldData = @json(old('medicines', []));
    </script>
@endsection
