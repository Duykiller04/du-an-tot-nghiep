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
                                <label class="form-label" for="name">Mã thuốc <span
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
                                    class="form-control @error('medicine.registration_number') is-invalid @enderror"
                                    id="name" name="medicine[registration_number]"
                                    value="{{ old('medicine.registration_number') }}">
                                @error('medicine.registration_number')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Tên thuốc <span
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
                                <input type="number"
                                    class="form-control @error('medicine.price_import') is-invalid @enderror" id="name"
                                    name="medicine[price_import]" value="{{ old('medicine.price_import') }}">
                                @error('medicine.price_import')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Giá bán <span
                                        class="text-danger">(*)</span></label>
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
                                        class="form-control @error('medicine.packaging_specification') is-invalid @enderror"
                                        id="packaging_specification" name="medicine[packaging_specification]"
                                        value="{{ old('medicine.packaging_specification') }}" readonly>
                                    @error('medicine.packaging_specification')
                                        <span class="d-block text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const btnAdd = document.querySelector('#addProductNew');
                                    const productNew = document.querySelector('.productNew');

                                    const donvis = @json($donvis);
                                    const oldQuantities = @json(old('so_luong', []));
                                    const oldUnits = @json(old('don_vi', []));
                                    const errors = @json($errors->toArray()); // Lấy danh sách lỗi từ Laravel

                                    const unitsByParent = donvis.reduce((acc, donvi) => {
                                        if (!acc[donvi.parent_id]) {
                                            acc[donvi.parent_id] = [];
                                        }
                                        acc[donvi.parent_id].push(donvi);
                                        return acc;
                                    }, {});

                                    function renderChildUnits(parentId, selectElement) {
                                        selectElement.innerHTML = '<option value="">Chọn đơn vị</option>'; // Reset các option
                                        if (unitsByParent[parentId]) {
                                            unitsByParent[parentId].forEach(donvi => {
                                                const option = document.createElement('option');
                                                option.value = donvi.id;
                                                option.textContent = donvi.name;
                                                selectElement.appendChild(option);
                                            });
                                        }
                                    }

                                    function showError(element, message) {
                                        const errorElement = document.createElement('p');
                                        errorElement.classList.add('text-danger'); // Thêm class để hiển thị lỗi
                                        errorElement.textContent = message;
                                        element.parentElement.appendChild(errorElement); // Gắn lỗi ngay dưới input
                                    }

                                    function validateFields() {
                                        const formItems = productNew.querySelectorAll('.form-item');
                                        let isValid = true;

                                        formItems.forEach((item, index) => {
                                            const quantityInput = item.querySelector('input[name="so_luong[]"]');
                                            const unitSelect = item.querySelector('select[name="don_vi[]"]');

                                            // Xóa lỗi cũ
                                            const oldErrors = item.querySelectorAll('.text-danger');
                                            oldErrors.forEach(error => error.remove());

                                            // Kiểm tra số lượng
                                            if (!quantityInput.value || parseFloat(quantityInput.value) <= 0) {
                                                showError(quantityInput, `Số lượng ở dòng ${index + 1} phải lớn hơn 0.`);
                                                isValid = false;
                                            }

                                            // Kiểm tra đơn vị
                                            if (!unitSelect.value) {
                                                showError(unitSelect, `Vui lòng chọn đơn vị ở dòng ${index + 1}.`);
                                                isValid = false;
                                            }
                                        });

                                        return isValid;
                                    }

                                    btnAdd.addEventListener('click', function () {
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
                                                            <input type="number" name="so_luong[]" class="form-control">
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
                                            } else {
                                                alert('Hết đơn vị con, không thể thêm trường mới!');
                                            }
                                        } else {
                                            alert('Vui lòng chọn đơn vị trước khi thêm trường mới!');
                                        }
                                    });

                                    productNew.addEventListener('click', function (event) {
                                        if (event.target.classList.contains('btn-delete')) {
                                            const formItem = event.target.closest('.form-item');
                                            if (formItem) {
                                                const allFormItems = Array.from(productNew.querySelectorAll('.form-item'));
                                                const currentIndex = allFormItems.indexOf(formItem);

                                                // Xóa tất cả các trường từ vị trí hiện tại
                                                for (let i = allFormItems.length - 1; i >= currentIndex; i--) {
                                                    allFormItems[i].remove();
                                                }
                                            }
                                        }
                                    });

                                    productNew.addEventListener('change', function (event) {
                                        if (event.target.name === 'don_vi[]') {
                                            const selectedParentId = event.target.value;
                                            const allSelects = productNew.querySelectorAll('select[name="don_vi[]"]');
                                            const currentSelectIndex = Array.from(allSelects).indexOf(event.target);

                                            // Reset các trường sau trường hiện tại
                                            for (let i = currentSelectIndex + 1; i < allSelects.length; i++) {
                                                allSelects[i].innerHTML = '<option value="">Chọn đơn vị</option>';
                                                allSelects[i].value = '';
                                            }

                                            // Render các đơn vị con
                                            if (currentSelectIndex < allSelects.length - 1) {
                                                const nextSelect = allSelects[currentSelectIndex + 1];
                                                renderChildUnits(selectedParentId, nextSelect);
                                            }
                                            updatePackagingSpecification();
                                        }
                                    });

                                    // Khôi phục giá trị và lỗi từ session
                                    oldQuantities.forEach((quantity, index) => {
                                        if (index > 0) {
                                            btnAdd.click();
                                        }
                                        const inputs = productNew.querySelectorAll('input[name="so_luong[]"]');
                                        const selects = productNew.querySelectorAll('select[name="don_vi[]"]');

                                        if (inputs[index]) inputs[index].value = quantity;
                                        if (selects[index]) selects[index].value = oldUnits[index] || '';

                                        if (errors[`so_luong.${index}`]) {
                                            showError(inputs[index], errors[`so_luong.${index}`][0]);
                                        }

                                        if (errors[`don_vi.${index}`]) {
                                            showError(selects[index], errors[`don_vi.${index}`][0]);
                                        }
                                    });

                                    function updatePackagingSpecification() {
                                        const formItems = productNew.querySelectorAll('.form-item');
                                        const packagingInput = document.querySelector('#packaging_specification');

                                        let packaging = []; // Mảng lưu các đơn vị cha và con

                                        formItems.forEach(item => {
                                            const unitSelect = item.querySelector('select[name="don_vi[]"]');
                                            
                                            if (unitSelect && unitSelect.value) {
                                                const selectedUnit = unitSelect.options[unitSelect.selectedIndex];
                                                const selectedUnitText = selectedUnit.textContent.trim(); // Loại bỏ khoảng trắng thừa

                                                if (selectedUnitText) {
                                                    packaging.push(selectedUnitText); // Lưu tên đơn vị đã chọn vào mảng
                                                }
                                            }
                                        });

                                        // Ghép các đơn vị với dấu "-" nếu có hơn 1 đơn vị, và loại bỏ khoảng trắng thừa
                                        packagingInput.value = packaging.join('-').trim();
                                    }
                                    updatePackagingSpecification();
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
                            <h5 class="card-title mb-0">Nhà cung cấp <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select id="supplier" name="supplier_id[]"
                                class="js-example-basic-multiple @error('supplier_id') is-invalid @enderror"
                                multiple="multiple">
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}" @if (in_array($item->id, old('supplier_id', []))) selected @endif>
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
                            <h5 class="card-title mb-0">Danh mục thuốc <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select @error('medicine.category_id') is-invalid @enderror"
                                id="medicine[category_id]" name="medicine[category_id]">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old('medicine.category_id') == $item->id) selected @endif>
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

                    <!-- Card cho Ảnh thuốc -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ảnh thuốc</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center">
                            <div class="avatar-upload text-center">
                                <div class="position-relative">
                                    <div class="avatar-preview">
                                        <div id="imagePreview" class="bg-cover bg-center" style="width: 150px; height:150px; background-size: contain; background-repeat: no-repeat; background-image: url({{ asset('theme/admin/assets/images/no-img-avatar.png') }});">
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
                            <input type="text" class="form-control @error('medicine.origin') is-invalid @enderror"
                                id="origin" name="medicine[origin]" value="{{ old('medicine.origin') }}">
                            @error('medicine.origin')
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
                                class="form-control @error('medicine.expiration_date') is-invalid @enderror"
                                id="expiration_date" name="medicine[expiration_date]"
                                value="{{ old('medicine.expiration_date') }}" min="{{ now()->format('Y-m-d') }}">
                            @error('medicine.expiration_date')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-12 custom-spacing ">
                <div class="card">
                    <div class="text-end m-3">
                        <a href="{{ route('admin.medicines.index') }}">
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
