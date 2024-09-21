@extends('admin.layouts.master')

@section('title')
    Thêm thuốc
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thêm Thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Thuốc</a></li>
                            <li class="breadcrumb-item active">Thêm Thuốc</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @if ($errors->any())
            {{-- @dd($errors->toArray()) --}}
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif

        <form id="create-disease-form" method="POST" action="{{ route('admin.medicines.store') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Cột chính bên trái -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin chung</h5>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label" for="name">Mã thuốc</label>
                                <input type="text"
                                    class="form-control @error('medicine.medicine_code') is-invalid @enderror"
                                    id="name" name="medicine[medicine_code]"
                                    value="{{ old('medicine.medicine_code') }}">
                                @error('medicine.medicine_code')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Số đăng ký</label>
                                <input type="number"
                                    class="form-control @error('medicine.registration_number') is-invalid @enderror"
                                    id="name" name="medicine[registration_number]"
                                    value="{{ old('medicine.registration_number') }}">
                                @error('medicine.registration_number')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Tên thuốc</label>
                                <input type="text" class="form-control @error('medicine.name') is-invalid @enderror"
                                    id="name" name="medicine[name]" value="{{ old('medicine.name') }}">
                                @error('medicine.name')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Giá nhập</label>
                                <input type="number"
                                    class="form-control @error('medicine.price_import') is-invalid @enderror" id="name"
                                    name="medicine[price_import]" value="{{ old('medicine.price_import') }}">
                                @error('medicine.price_import')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Giá bán</label>
                                <input type="number"
                                    class="form-control @error('medicine.price_sale') is-invalid @enderror" id="name"
                                    name="medicine[price_sale]" value="{{ old('medicine.price_sale') }}">
                                @error('medicine.price_sale')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>



                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Đơn vị</h5>
                        </div>
                        <div class="card-body">

                            <div class="d-flex justify-content-end">
                                <button id="addProductNew" type="button" class="btn btn-primary">Thêm đơn vị</button>
                            </div>

                            <div class="mb-3">
                                <div class="row productNew mt-3">

                                    <div class="row mb-3 form-item mt-3">
                                        <div class="col-5">
                                            <label class="form-label" for="name">Số lượng</label>
                                            <input type="number"
                                                class="form-control @error('so_luong') is-invalid @enderror" id="name"
                                                name="so_luong[]">
                                            @error('so_luong.0')
                                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-5">
                                            <label for="">Đơn vị</label>
                                            <select name="don_vi[]" id="" class="form-control">
                                                @foreach ($donvis as $donvi)
                                                    <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3 form-item mt-3">
                                        <div class="col-5">
                                            <label for="">Số lượng</label>
                                            <input type="number" name="so_luong[]" id="" class="form-control">
                                            @error('so_luong.1')
                                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-5">
                                            <label for="">Đơn vị</label>
                                            <select name="don_vi[]" id="" class="form-control">
                                                @foreach ($donvis as $donvi)
                                                    <option value="{{ $donvi->id }}">{{ $donvi->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="packaging_specification">Quy cách đóng gói</label>
                                    <input type="text"
                                        class="form-control @error('medicine.packaging_specification') is-invalid @enderror"
                                        id="packaging_specification" name="medicine[packaging_specification]"
                                        value="{{ old('medicine.packaging_specification') }}">
                                    @error('medicine.packaging_specification')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const btnAdd = document.querySelector('#addProductNew');
                                    const productNew = document.querySelector('.productNew');

                                    const donvis = @json($donvis);

                                    btnAdd.addEventListener('click', function() {
                                        const newFieldHTML = `
                                <div class="row mb-3 form-item mt-3">
                                    <div class="col-5">
                                        <label for="">Số lượng</label>
                                        <input type="number" name="so_luong[]" class="form-control">
                                    </div>
                                    <div class="col-5">
                                        <label for="">Đơn vị</label>
                                        <select name="don_vi[]" class="form-control">
                                            ${donvis.map(donvi => `<option value="${donvi.id}">${donvi.name}</option>`).join('')}
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button class="btn btn-danger btn-delete" type="button" style="margin-top: 25px">Xóa</button>
                                    </div>
                                </div>
                                `;

                                        productNew.insertAdjacentHTML('beforeend', newFieldHTML);
                                    });

                                    function handleDeleteClick(event) {
                                        if (event.target.classList.contains('btn-delete')) {
                                            const formItem = event.target.closest('.form-item');
                                            if (formItem) {
                                                formItem.remove();
                                            }
                                        }
                                    }

                                    productNew.addEventListener('click', handleDeleteClick);
                                });
                            </script>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin phụ</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="administration_route">Đường dùng</label>
                                <input type="text"
                                    class="form-control @error('medicine.administration_route') is-invalid @enderror"
                                    id="administration_route" name="medicine[administration_route]"
                                    value="{{ old('medicine.administration_route') }}">
                                @error('medicine.administration_route')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="active_ingredient">Hoạt chất</label>
                                <textarea class="form-control" id="active_ingredient" name="medicine[active_ingredient]">{{ old('medicine.active_ingredient') }}</textarea>
                                @error('medicine.active_ingredient')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="concentration">Hàm lượng</label>
                                <textarea class="form-control" id="concentration" name="medicine[concentration]">{{ old('medicine.concentration') }}</textarea>
                                @error('medicine.concentration')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="dosage">Liều dùng</label>
                                <textarea class="form-control" id="dosage" name="medicine[dosage]">{{ old('medicine.dosage') }}</textarea>
                                @error('medicine.dosage')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cột bên phải -->
                <div class="col-lg-4">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Nhà cung cấp</h5>
                        </div>
                        <div class="card-body">
                            <select id="supplier" name="supplier_id[]" class="js-example-basic-multiple"
                                multiple="multiple">
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('supplier_id.*')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Danh mục thuốc</h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select" id="medicine[category_id]" name="medicine[category_id]">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('medicine.category_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Kho lưu trữ</h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select" id="storage_id" name="storage_id">
                                <option value="">-- Chọn kho lưu trữ --</option>
                                @foreach ($storages as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('storage_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Card cho Ảnh thuốc -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ảnh thuốc</h5>
                        </div>
                        <div class="card-body">
                            <input type="file" class="form-control" id="image" name="image"
                                accept="image/png, image/gif, image/jpeg, image/jpg">
                            @error('image')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Xuất xứ</h5>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control @error('medicine.origin') is-invalid @enderror"
                                id="origin" name="medicine[origin]" value="{{ old('medicine.origin') }}">
                            @error('medicine.origin')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ngày hết hạn</h5>
                        </div>
                        <div class="card-body">
                            <input type="date"
                                class="form-control @error('medicine.expiration_date') is-invalid @enderror"
                                id="expiration_date" name="medicine[expiration_date]">
                            @error('medicine.expiration_date')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- Nút Lưu bệnh -->
            <div class="text-end mb-3">
                <a href="{{ route('admin.medicines.index') }}"><button type="button" class="btn btn-primary w-sm">Quay
                        lại</button></a>
                <button type="submit" class="btn btn-success w-sm">Thêm mới</button>
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
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    {{-- select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        ClassicEditor.create(document.querySelector('#symptom'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor.create(document.querySelector('#dosage'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor.create(document.querySelector('#active_ingredient'))
            .catch(error => {
                console.error(error);
            });

        ClassicEditor.create(document.querySelector('#concentration'))
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        $(document).ready(function() {
            $("#supplier").select2({
                allowClear: true,
                dropdownAutoWidth: true
            });
            $('.js-example-basic-single').select2({
                dropdownAutoWidth: true
            });
        });
    </script>
@endsection
