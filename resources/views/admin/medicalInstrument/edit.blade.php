@extends('admin.layouts.master')

@section('title')
    Sửa dụng cụ
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Sửa dụng cụ</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dụng cụ</a></li>
                            <li class="breadcrumb-item active">Sửa dụng cụ</li>
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

        <form id="create-disease-form" method="POST" action="{{ route('admin.medicalInstruments.update', $medicine->id) }}"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                                    id="name" name="medicine[medicine_code]" value="{{ $medicine->medicine_code }}">
                                @error('medicine.medicine_code')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="name">Số đăng ký <span
                                        class="text-danger">(*)</span></label>
                                <input type="number"
                                    class="form-control @error('medicine.registration_number') is-invalid @enderror"
                                    id="name" name="medicine[registration_number]"
                                    value="{{ $medicine->registration_number }}">
                                @error('medicine.registration_number')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label class="form-label" for="name">Tên dụng cụ <span
                                        class="text-danger">(*)</span></label>
                                <input type="text" class="form-control @error('medicine.name') is-invalid @enderror"
                                    id="name" name="medicine[name]" value="{{ $medicine->name }}">
                                @error('medicine.name')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label class="form-label" for="name">Giá nhập <span
                                        class="text-danger">(*)</span></label>
                                <input type="number"
                                    class="form-control @error('medicine.price_import') is-invalid @enderror" id="name"
                                    name="medicine[price_import]" value="{{ $medicine->price_import }}">
                                @error('medicine.price_import')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Giá bán <span
                                        class="text-danger">(*)</span></label>
                                <input type="number"
                                    class="form-control @error('medicine.price_sale') is-invalid @enderror" id="name"
                                    name="medicine[price_sale]" value="{{ $medicine->price_sale }}">
                                @error('medicine.price_sale')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div> --}}

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Đơn vị</h5>
                        </div>
                        <div class="card-body">

                            {{-- <div class="d-flex justify-content-end">
                                <button id="addProductNew" type="button" class="btn btn-primary">Thêm đơn vị</button>
                            </div> --}}

                            <div class="unit-conversion-list">
                                <div class="mb-3">
                                    <div class="row productNew mt-3">
                                        @php
                                            $oldQuantities = old(
                                                'so_luong',
                                                $medicine->unitConversions->pluck('proportion')->toArray(),
                                            );
                                            $oldUnits = old(
                                                'don_vi',
                                                $medicine->unitConversions->pluck('unit_id')->toArray(),
                                            );
                                        @endphp

                                        @foreach ($oldQuantities as $index => $quantity)
                                            <div class="row form-item unit-conversion-row"
                                                data-index="{{ $index }}">
                                                <div class="col-6 mt-3">
                                                    <label class="form-label" for="so_luong">Số lượng <span
                                                            class="text-danger">(*)</span></label>
                                                    <input type="number" class="form-control" name="so_luong[]"
                                                        value="{{ $quantity }}" disabled>
                                                </div>
                                                <div class="col-6 mt-3">
                                                    <label for="don_vi">Đơn vị <span
                                                            class="text-danger">(*)</span></label>
                                                    <select name="don_vi[]" class="form-control" disabled>
                                                        <option value="">Chọn đơn vị</option>
                                                        @foreach ($donvis as $donvi)
                                                            <option value="{{ $donvi['id'] }}"
                                                                data-parent-id="{{ $donvi['parent_id'] }}"
                                                                @if ($oldUnits[$index] == $donvi['id']) selected @endif>
                                                                {{ $donvi['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="col-2 mt-3">
                                                    <button class="btn btn-danger btn-delete" type="button"
                                                        style="margin-top: 25px" onclick="deleteUnit(this)">Xóa</button>
                                                </div> --}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="packaging_specification">Quy cách đóng gói <span
                                        class="text-danger">(*)</span></label>
                                <input type="text"
                                    class="form-control @error('medicine.packaging_specification') is-invalid @enderror"
                                    id="packaging_specification" name="medicine[packaging_specification]"
                                    value="{{ $packaging_specification }}" disabled>
                                @error('medicine.packaging_specification')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const btnAdd = document.querySelector('#addProductNew');
                                    const productNew = document.querySelector('.productNew');

                                    const donvis = @json($donvis); // Data for units
                                    const oldQuantities = @json(old('so_luong', [])); // Old quantities from session
                                    const oldUnits = @json(old('don_vi', [])); // Old units from session
                                    const errors = @json($errors->toArray()); // Errors from Laravel

                                    // Organize units by parent_id
                                    const unitsByParent = donvis.reduce((acc, donvi) => {
                                        if (!acc[donvi.parent_id]) {
                                            acc[donvi.parent_id] = [];
                                        }
                                        acc[donvi.parent_id].push(donvi);
                                        return acc;
                                    }, {});

                                    // Render child units for the select dropdown based on parent_id
                                    function renderChildUnits(parentId, selectElement) {
                                        selectElement.innerHTML = '<option value="">Chọn đơn vị</option>'; // Reset options
                                        if (unitsByParent[parentId]) {
                                            unitsByParent[parentId].forEach(donvi => {
                                                const option = document.createElement('option');
                                                option.value = donvi.id;
                                                option.textContent = donvi.name;
                                                selectElement.appendChild(option);
                                            });
                                        }
                                    }

                                    // Show error message
                                    function showError(element, message) {
                                        const errorElement = document.createElement('p');
                                        errorElement.classList.add('text-danger');
                                        errorElement.textContent = message;
                                        element.parentElement.appendChild(errorElement);
                                    }

                                    // Validate fields
                                    function validateFields() {
                                        const formItems = productNew.querySelectorAll('.form-item');
                                        let isValid = true;

                                        formItems.forEach((item, index) => {
                                            const quantityInput = item.querySelector('input[name="so_luong[]"]');
                                            const unitSelect = item.querySelector('select[name="don_vi[]"]');

                                            // Remove previous error messages
                                            const oldErrors = item.querySelectorAll('.text-danger');
                                            oldErrors.forEach(error => error.remove());

                                            // Validate quantity
                                            if (!quantityInput.value || parseFloat(quantityInput.value) <= 0) {
                                                showError(quantityInput, `Số lượng ở dòng ${index + 1} phải lớn hơn 0.`);
                                                isValid = false;
                                            }

                                            // Validate unit
                                            if (!unitSelect.value) {
                                                showError(unitSelect, `Vui lòng chọn đơn vị ở dòng ${index + 1}.`);
                                                isValid = false;
                                            }
                                        });

                                        return isValid;
                                    }

                                    // Add new unit row
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

                                    // Handle deleting unit row
                                    productNew.addEventListener('click', function(event) {
                                        if (event.target.classList.contains('btn-delete')) {
                                            const formItem = event.target.closest('.form-item');
                                            if (formItem) {
                                                const allFormItems = Array.from(productNew.querySelectorAll('.form-item'));
                                                const currentIndex = allFormItems.indexOf(formItem);

                                                // Delete all fields after the current index
                                                for (let i = allFormItems.length - 1; i >= currentIndex; i--) {
                                                    allFormItems[i].remove();
                                                }
                                            }
                                        }
                                    });

                                    // Handle change in unit select
                                    productNew.addEventListener('change', function(event) {
                                        if (event.target.name === 'don_vi[]') {
                                            const selectedParentId = event.target.value;
                                            const allSelects = productNew.querySelectorAll('select[name="don_vi[]"]');
                                            const currentSelectIndex = Array.from(allSelects).indexOf(event.target);

                                            // Reset all selects after the current one
                                            for (let i = currentSelectIndex + 1; i < allSelects.length; i++) {
                                                allSelects[i].innerHTML = '<option value="">Chọn đơn vị</option>';
                                                allSelects[i].value = '';
                                            }

                                            // Render child units
                                            if (currentSelectIndex < allSelects.length - 1) {
                                                const nextSelect = allSelects[currentSelectIndex + 1];
                                                renderChildUnits(selectedParentId, nextSelect);
                                            }
                                            updatePackagingSpecification();
                                        }
                                    });

                                    // Restore old values and errors from session
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

                                    // Update packaging specification input
                                    function updatePackagingSpecification() {
                                        const formItems = productNew.querySelectorAll('.form-item');
                                        const packagingInput = document.querySelector('#packaging_specification');

                                        let packaging = []; // Array to store selected units

                                        formItems.forEach(item => {
                                            const unitSelect = item.querySelector('select[name="don_vi[]"]');

                                            if (unitSelect && unitSelect.value) {
                                                const selectedUnit = unitSelect.options[unitSelect.selectedIndex];
                                                const selectedUnitText = selectedUnit.textContent.trim();

                                                if (selectedUnitText) {
                                                    packaging.push(selectedUnitText); // Add selected unit to array
                                                }
                                            }
                                        });

                                        // Join units with "-" if more than one unit, and remove extra spaces
                                        packagingInput.value = packaging.join('-').trim();
                                    }

                                    updatePackagingSpecification();
                                });
                            </script> --}}

                        </div>
                    </div>
                </div>

                <!-- Cột bên phải -->
                <div class="col-lg-4">

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Nhà cung cấp <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select id="supplier" name="supplier_id[]"
                                class="js-example-basic-multiple @error('supplier_id') is-invalid @enderror"
                                multiple="multiple">
                                @foreach ($suppliers as $item)
                                    <option value="{{ $item->id }}" @if (in_array($item->id, $medicine->suppliers->pluck('id')->toArray())) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}


                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Danh mục dụng cụ <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select @error('medicine.category_id') is-invalid @enderror"
                                id="medicine[category_id]" name="medicine[category_id]">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old('medicine.category_id', $medicine->category_id) == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medicine.category_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Kho lưu trữ <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <select class="form-select @error('storage_id') is-invalid @enderror" id="storage_id"
                                name="storage_id">
                                <option value="">-- Chọn kho lưu trữ --</option>
                                @foreach ($storages as $item)
                                    <option value="{{ $item->id }}"
                                        @if (old('storage_id', $medicine->storage_id) == $item->id) selected @endif>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('storage_id')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                    <!-- Card cho Ảnh dụng cụ -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ảnh dụng cụ</h5>
                        </div>
                        <div class="card-body d-flex justify-content-center mb-3">
                            <div class="avatar-upload text-center">
                                <div class="position-relative">
                                    <div class="avatar-preview">
                                        <div id="imagePreview" class="bg-cover bg-center"
                                            style="width: 150px; height:150px; background-size: contain; background-repeat: no-repeat; background-image: url({{ $medicine->image ? asset('storage/' . $medicine->image) : asset('theme/admin/assets/images/no-img-avatar.png') }});">
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
                    </div>

                    {{-- <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Xuất xứ <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <input type="text" class="form-control @error('medicine.origin') is-invalid @enderror"
                                id="origin" name="medicine[origin]" value="{{ $medicine->origin }}">
                            @error('medicine.origin')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Nhiệt độ - Độ ẩm</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="temperature">Nhiệt độ (Độ C)</label>
                            <input type="number"
                                class="form-control @error('medicine.temperature') is-invalid @enderror" id="temperature"
                                name="medicine[temperature]" value="{{ $medicine->temperature }}">
                            @error('medicine.temperature')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="card-body">
                            <label class="form-label" for="moisture">Độ ẩm (%)</label>
                            <input type="number" class="form-control @error('medicine.moisture') is-invalid @enderror"
                                id="moisture" name="medicine[moisture]" value="{{ $medicine->moisture }}">
                            @error('medicine.moisture')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ngày hết hạn <span class="text-danger">(*)</span></h5>
                        </div>
                        <div class="card-body">
                            <input type="date"
                                class="form-control @error('medicine.expiration_date') is-invalid @enderror"
                                id="expiration_date" name="medicine[expiration_date]"
                                value="{{ $medicine->expiration_date->format('Y-m-d') }}"
                                min="{{ now()->format('Y-m-d') }}">
                            @error('medicine.expiration_date')
                                <span class="d-block text-danger mt-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div> --}}

                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Chi tiết lô</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Số lô</th>
                                        <th>Kho</th>
                                        <th>Nhà cung cấp</th>
                                        <th>Số đăng ký</th>
                                        <th>Xuất xứ</th>
                                        <th>Quy cách đóng gói</th>
                                        <th>Giá nhập</th>
                                        <th>Giá bán</th>
                                        <th>Giá bán theo đơn vị nhỏ nhất <span class="text-danger">*</span></th>
                                        <th>Số lượng</th>
                                        <th>Ngày nhập lô</th>
                                        <th>Ngày hết hạn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicine->batches as $batch)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $batch->storage->name }}</td>
                                            <td>{{ $batch->supplier->name }}</td>
                                            <td>{{ $batch->registration_number }}</td>
                                            <td>{{ $batch->origin }}</td>
                                            <td>{{ $batch->packaging_specification }}</td>
                                            <td>{{ number_format($batch->price_import, 0, ',', '.') }} VNĐ</td>
                                            <td>{{ number_format($batch->price_sale, 0, ',', '.') }} VNĐ</td>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div class="d-flex align-items-center">
                                                        <input type="number" value="{{ old("batches.{$batch->id}.price_in_smallest_unit", $batch->price_in_smallest_unit) }}" name="batches[{{ $batch->id }}][price_in_smallest_unit]" style="width: 100px" class="@error("batches.{$batch->id}.price_in_smallest_unit") is-invalid @enderror form-control" step="any">
                                                        <p class="ms-2 mb-0">VNĐ</p>
                                                    </div>
                                                    <div class="">
                                                        @error("batches.{$batch->id}.price_in_smallest_unit")
                                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $batch->inventory->quantity }} ({{ $batch->inventory->unit->name }})</td>
                                            <td>{{ \Carbon\Carbon::parse($batch->created_at)->format('d-m-Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($batch->expiration_date)->format('d-m-Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 custom-spacing ">
                    <div class="card">
                        <div class="text-end m-3">
                            <a href="{{ route('admin.medicalInstruments.index') }}">
                                <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                            </a>
                            <button type="submit" class="btn btn-success w-sm">Sửa</button>
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
