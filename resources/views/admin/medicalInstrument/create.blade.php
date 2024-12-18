@extends('admin.layouts.master')

@section('title')
    Thêm dụng cụ
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thêm dụng cụ</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dụng cụ</a></li>
                            <li class="breadcrumb-item active">Thêm dụng cụ</li>
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

        <form id="create-disease-form" method="POST" action="{{ route('admin.medicalInstruments.store') }}"
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
                                <label class="form-label" for="name">Mã dụng cụ <span
                                        class="text-danger">(*)</span></label>
                                <input type="text"
                                    class="form-control @error('medicine.medicine_code') is-invalid @enderror"
                                    id="name" name="medicine[medicine_code]"
                                    value="{{ old('medicine.medicine_code') }}">
                                @error('medicine.medicine_code')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Số đăng ký <span
                                        class="text-danger">(*)</span></label>
                                <input type="number"
                                    class="form-control @error('batch.registration_number') is-invalid @enderror"
                                    id="name" name="batch[registration_number]"
                                    value="{{ old('batch.registration_number') }}">
                                @error('batch.registration_number')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Tên dụng cụ <span
                                        class="text-danger">(*)</span></label>
                                <input type="text" class="form-control @error('medicine.name') is-invalid @enderror"
                                    id="name" name="medicine[name]" value="{{ old('medicine.name') }}">
                                @error('medicine.name')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Giá nhập <span
                                        class="text-danger">(*)</span></label>
                                <input type="number" class="form-control @error('batch.price_import') is-invalid @enderror"
                                    id="name" name="batch[price_import]" value="{{ old('batch.price_import') }}">
                                @error('batch.price_import')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Giá bán <span
                                        class="text-danger">(*)</span></label>
                                <input type="number" class="form-control @error('batch.price_sale') is-invalid @enderror"
                                    id="name" name="batch[price_sale]" value="{{ old('batch.price_sale') }}">
                                @error('batch.price_sale')
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
                                            <label class="form-label" for="name">Số lượng <span
                                                    class="text-danger">(*)</span></label>
                                            <input type="number" class="form-control" name="so_luong[]"
                                                value="{{ old('so_luong.0') }}">
                                        </div>

                                        <div class="col-5">
                                            <label for="">Đơn vị <span class="text-danger">(*)</span></label>
                                            <select name="don_vi[]" class="form-control">
                                                <option value="" {{ old('don_vi.0') == null ? 'selected' : '' }}>Chọn
                                                    đơn vị</option>
                                                @foreach ($donvis as $donvi)
                                                    <option value="{{ $donvi->id }}"
                                                        {{ old('don_vi.0') == $donvi->id ? 'selected' : '' }}>
                                                        {{ $donvi->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="packaging_specification">Quy cách đóng gói <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text"
                                        class="form-control @error('batch.packaging_specification') is-invalid @enderror"
                                        id="packaging_specification" name="batch[packaging_specification]"
                                        value="{{ old('batch.packaging_specification') }}" readonly>
                                    @error('batch.packaging_specification')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const btnAdd = document.querySelector('#addProductNew');
                                    const productNew = document.querySelector('.productNew');
                                    const packagingInput = document.querySelector('#packaging_specification');

                                    const donvis = @json($donvis);
                                    const oldQuantities = @json(old('so_luong', []));
                                    const oldUnits = @json(old('don_vi', []));
                                    const errors = @json($errors->toArray());

                                    const unitsByParent = donvis.reduce((acc, donvi) => {
                                        if (!acc[donvi.parent_id]) acc[donvi.parent_id] = [];
                                        acc[donvi.parent_id].push(donvi);
                                        return acc;
                                    }, {});

                                    function renderChildUnits(parentId, selectElement) {
                                        selectElement.innerHTML = '<option value="">Chọn đơn vị</option>';
                                        if (unitsByParent[parentId]) {
                                            unitsByParent[parentId].forEach(donvi => {
                                                const option = document.createElement('option');
                                                option.value = donvi.id;
                                                option.textContent = donvi.name;
                                                selectElement.appendChild(option);
                                            });
                                        }
                                    }

                                    function updatePackagingSpecification() {
                                        const formItems = productNew.querySelectorAll('.form-item');
                                        let quantities = [];
                                        let units = [];

                                        formItems.forEach((item) => {
                                            const quantityInput = item.querySelector('input[name="so_luong[]"]');
                                            const unitSelect = item.querySelector('select[name="don_vi[]"]');

                                            const quantity = quantityInput ? quantityInput.value.trim() : '';
                                            const unit = unitSelect && unitSelect.value ?
                                                unitSelect.options[unitSelect.selectedIndex]?.textContent.trim() :
                                                null;

                                            if (quantity && unit) {
                                                quantities.push(quantity);
                                                units.push(unit);
                                            }
                                        });

                                        let packaging = [];
                                        let flag = false;
                                        for (let i = 0; i < quantities.length; i++) {
                                            if (i === 0) {
                                                // Luôn hiển thị giá trị gốc là "1 thùng"
                                                packaging.push(`1 ${units[i]}`);
                                            } else {
                                                if (flag == false) {
                                                    packaging.push(`1 ${units[i - 1]} có ${quantities[i]} ${units[i]}`);
                                                    flag = true;
                                                    continue;
                                                }
                                                packaging.push(`- 1 ${units[i - 1]} có ${quantities[i]} ${units[i]}`);
                                            }
                                        }

                                        // Xóa phần "1 thùng" ở các cấp sâu hơn
                                        if (packaging.length > 1) {
                                            packaging.shift(); // Xóa "1 thùng" khỏi kết quả
                                        }

                                        packagingInput.value = packaging.join(' ');
                                    }


                                    productNew.addEventListener('input', function(event) {
                                        if (event.target.name === 'so_luong[]' || event.target.name === 'don_vi[]') {
                                            updatePackagingSpecification();
                                        }
                                    });

                                    btnAdd.addEventListener('click', function() {
                                        const allSelects = productNew.querySelectorAll('select[name="don_vi[]"]');
                                        const lastSelect = allSelects[allSelects.length - 1];
                                        const lastSelectedUnit = lastSelect ? lastSelect.value : null;

                                        if (lastSelectedUnit) {
                                            const childUnits = unitsByParent[lastSelectedUnit] || [];
                                            if (childUnits.length > 0) {
                                                const newFieldHTML = `
                                                <div class="row mb-3 form-item mt-3">
                                                    <div class="col-5">
                                                        <label for="">Số lượng <span class="text-danger">(*)</span></label>
                                                        <input type="number" name="so_luong[]" class="form-control" min="1">
                                                    </div>
                                                    <div class="col-5">
                                                        <label for="">Đơn vị <span class="text-danger">(*)</span></label>
                                                        <select name="don_vi[]" class="form-control">
                                                            <option value="">Chọn đơn vị</option>
                                                            ${childUnits.map(donvi => `<option value="${donvi.id}">${donvi.name}</option>`).join('')}
                                                        </select>
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-danger btn-delete" type="button" style="margin-top: 25px">Xóa</button>
                                                    </div>
                                                </div>
                                            `;
                                                productNew.insertAdjacentHTML('beforeend', newFieldHTML);
                                                updatePackagingSpecification();
                                            } else {
                                                alert('Hết đơn vị con, không thể thêm trường mới!');
                                            }
                                        } else {
                                            alert('Vui lòng chọn đơn vị trước khi thêm trường mới!');
                                        }
                                    });

                                    productNew.addEventListener('click', function(event) {
                                        if (event.target.classList.contains('btn-delete')) {
                                            event.target.closest('.form-item').remove();
                                            updatePackagingSpecification();
                                        }
                                    });

                                    productNew.addEventListener('change', function(event) {
                                        if (event.target.name === 'don_vi[]') {
                                            const selectedParentId = event.target.value;
                                            const allSelects = productNew.querySelectorAll('select[name="don_vi[]"]');
                                            const currentSelectIndex = Array.from(allSelects).indexOf(event.target);

                                            for (let i = currentSelectIndex + 1; i < allSelects.length; i++) {
                                                allSelects[i].innerHTML = '<option value="">Chọn đơn vị</option>';
                                                allSelects[i].value = '';
                                            }

                                            if (currentSelectIndex < allSelects.length - 1) {
                                                const nextSelect = allSelects[currentSelectIndex + 1];
                                                renderChildUnits(selectedParentId, nextSelect);
                                            }
                                            updatePackagingSpecification();
                                        }
                                    });

                                    oldQuantities.forEach((quantity, index) => {
                                        if (index > 0) btnAdd.click();
                                        const inputs = productNew.querySelectorAll('input[name="so_luong[]"]');
                                        const selects = productNew.querySelectorAll('select[name="don_vi[]"]');

                                        if (inputs[index]) inputs[index].value = quantity;
                                        if (selects[index]) selects[index].value = oldUnits[index] || '';

                                        if (errors[`so_luong.${index}`]) showError(inputs[index], errors[`so_luong.${index}`][0]);
                                        if (errors[`don_vi.${index}`]) showError(selects[index], errors[`don_vi.${index}`][0]);
                                    });

                                    updatePackagingSpecification();
                                });
                            </script>

                        </div>
                    </div>
                </div>

                <!-- Cột bên phải -->
                <div class="col-lg-4">

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Nhà cung cấp <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select id="supplier" name="supplier_id"
                                class="js-example-basic-single @error('supplier_id') is-invalid @enderror">
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}" @if (old('supplier_id') == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Danh mục dụng cụ <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select @error('medicine.category_id') is-invalid @enderror"
                                id="medicine[category_id]" name="medicine[category_id]">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" @if (old('medicine.category_id') == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medicine.category_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Kho lưu trữ <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select @error('storage_id') is-invalid @enderror" id="storage_id"
                                name="storage_id">
                                <option value="">-- Chọn kho lưu trữ --</option>
                                @foreach ($storages as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old('storage_id') == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('storage_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Card cho Ảnh dụng cụ -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ảnh dụng cụ</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <div class="avatar-upload text-center">
                                <div class="position-relative">
                                    <div class="avatar-preview">
                                        <div id="imagePreview" class="bg-cover bg-center"
                                            style="width: 150px; height:150px; background-size: contain; background-repeat: no-repeat; background-image: url({{ asset('theme/admin/assets/images/no-img-avatar.png') }});">
                                        </div>
                                    </div>
                                    <div class="change-btn mt-2">
                                        <input type='file' class="form-control d-none" id="imageUpload"
                                            name="image" accept=".png, .jpg, .jpeg">
                                        <label for="imageUpload" class="btn btn-primary light btn">Chọn
                                            ảnh</label>
                                    </div>
                                    @error('image')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Xuất xứ <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control @error('batch.origin') is-invalid @enderror"
                                id="origin" name="batch[origin]" value="{{ old('batch.origin') }}">
                            @error('batch.origin')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Nhiệt độ - Độ ẩm</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="temperature">Nhiệt độ (Độ C)</label>
                            <input type="number"
                                class="form-control @error('medicine.temperature') is-invalid @enderror" id="temperature"
                                name="medicine[temperature]" value="{{ old('medicine.temperature') }}">
                            @error('medicine.temperature')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="moisture">Độ ẩm (%)</label>
                            <input type="number" class="form-control @error('medicine.moisture') is-invalid @enderror"
                                id="moisture" name="medicine[moisture]" value="{{ old('medicine.moisture') }}">
                            @error('medicine.moisture')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ngày hết hạn <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <input type="date"
                                class="form-control @error('batch.expiration_date') is-invalid @enderror"
                                id="expiration_date" name="batch[expiration_date]"
                                value="{{ old('batch.expiration_date') }}" min="{{ now()->format('Y-m-d') }}">
                            @error('batch.expiration_date')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12 custom-spacing ">
                <div class="card">
                    <div class="text-end m-3">
                        <a href="{{ route('admin.medicalInstruments.index') }}">
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
    <script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

    {{-- select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").on('change', function() {
            readURL(this);
        });
    </script>
@endsection
