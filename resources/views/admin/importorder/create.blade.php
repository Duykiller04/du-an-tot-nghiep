@extends('admin.layouts.master')

@section('title')
    Nhập mới kho thuốc
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Nhập mới kho thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Kho thuốc</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Thêm mới
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            {{-- @dd($errors->toArray()) --}}
            <div class="alert alert-danger">Đã có lỗi nhập liệu. Vui lòng kiểm tra lại!</div>
        @endif
        <form action="{{ route('admin.importorder.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Thông tin </h4>
                        </div><!-- end card header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">Người nhập kho</label>
                                        <input type="text" id="user_name" class="form-control"
                                            value="{{ Auth::user()->name }}" disabled>
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="date_of_import">Ngày nhập kho</label>
                                        <input type="date" class="form-control @error('date_of_import') is-invalid @enderror"
                                            id="date_of_import" name="date_of_import"
                                            value="{{ old('date_of_import', now()->format('Y-m-d')) }}" readonly>
                                        @error('date_of_import')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea id="note" name="note" class="form-control" style="height: 200px">{{ old('note') }}</textarea>
                                        @error('note')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="max-height: 500px; overflow-y: auto;">
                <div class="col-lg-12 custom-spacing">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Chi tiết sản phẩm</h4>
                        </div>
                        <div id="order-details">
                            
                        </div>
                        <!-- Nút để thêm chi tiết sản phẩm -->
                        <div>
                            <button type="button" id="add-detail" class="btn btn-primary mt-3 m-3">
                                <p class="mt-1 mb-0">Thêm sản phẩm</p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 custom-spacing ">
                <div class="card">
                    <div class="text-end m-3">
                        <a href="{{ route('admin.importorder.index') }}">
                            <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                        </a>
                        <button type="submit" class="btn btn-success w-sm">Nhập mới</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('js/total-calculator.js') }}"></script>
@endsection

@section('style-libs')
    <!-- Plugins css -->
    <link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
    {{-- select2 --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
@endsection

@section('css')
    <style>
        .form-label.required::after {
            content: " *";
            color: red;
            font-weight: bold;
        }
    </style>
@endsection

@section('script-libs')
    {{-- select2 --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            let detailCounter = 0;
            let unitCounters = {};
            const orderDetailsContainer = document.getElementById('order-details');

            document.getElementById('add-detail').addEventListener('click', function() {
                detailCounter++;
                const newDetail = `
                    <div class="mb-3 border p-3 rounded detail-row" data-detail-index="${detailCounter}" style="background-color: #7c76761f">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDetails${detailCounter}" aria-expanded="false" aria-controls="collapseDetails${detailCounter}">
                                <p class="mt-1 mb-0">Chi tiết sản phẩm</p>
                            </button>
                            <button type="button" class="btn btn-danger remove-detail" data-detail-index="${detailCounter}">Xóa sản phẩm</button>
                        </div>
                        <div class="collapse mt-2" id="collapseDetails${detailCounter}">
                            <div class="row mt-3 mb-3">
                                <div class="mb-3 col-3">
                                    <label for="name-${detailCounter}" class="form-label">Sản phẩm<span class="text-danger">*</span></label>
                                    <select id="name-${detailCounter}" name="details[${detailCounter}][medicine_id]" class="form-select js-example-basic-single" style="width: 100%">
                                        <option value="">Chọn sản phẩm</option>
                                        @foreach ($medicines as $medicine)
                                            <option value="{{ $medicine->id }}"
                                                {{ old('details[${detailCounter}][medicine_id]') == $medicine->id ? 'selected' : '' }}>
                                                {{ $medicine->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="details[${detailCounter}][name_medicine]" id="name_medicine-${detailCounter}">
                                </div>

                                <div class="mb-3 col-2">
                                    <label for="supplier-${detailCounter}" class="form-label">Nhà cung cấp: <span
                                            class="text-danger">*</span></label>
                                    <select id="supplier-${detailCounter}" name="details[${detailCounter}][supplier_id]" class="form-select js-example-basic-single">
                                        <option value="">Chọn nhà cung cấp</option>
                                        @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('details[${detailCounter}][supplier_id]') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('details[${detailCounter}][supplier_id]')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-2">
                                    <label for="storage_id-${detailCounter}" class="form-label">Kho thuốc: <span
                                            class="text-danger">*</span></label>
                                    <select id="storage_id-${detailCounter}" name="details[${detailCounter}][storage_id]" class="form-select js-example-basic-single">
                                        <option value="">Chọn kho thuốc</option>
                                        @foreach ($storages as $storage)
                                            <option value="{{ $storage->id }}"
                                                {{ old('storage_id[${detailCounter}]') == $storage->id ? 'selected' : '' }}>
                                                {{ $storage->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('details[${detailCounter}][storage_id]')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-2">
                                    <label for="registration_number-${detailCounter}" class="form-label">Số đăng ký:<span class="text-danger">*</span></label>
                                    <input type="text" id="registration_number-${detailCounter}" name="details[${detailCounter}][registration_number]" class="form-control" placeholder="Số đăng ký">
                                    <div class="text-danger" id="registration-number-error-${detailCounter}"></div>
                                </div>

                                <div class="mb-3 col-2">
                                    <label for="origin-${detailCounter}" class="form-label">Xuất xứ</label>
                                    <input type="text" id="origin-${detailCounter}" name="details[${detailCounter}][origin]" class="form-control" placeholder="Xuất xứ">
                                    <div class="text-danger" id="origin-error-${detailCounter}"></div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="mb-3 col-3">
                                    <label class="form-label required" for="quantity-${detailCounter}">Số lượng</label>
                                    <input type="number" class="form-control" id="quantity-${detailCounter}" name="details[${detailCounter}][quantity]" placeholder="0">
                                    <input type="hidden" name="details[${detailCounter}][proportion]" id="proportion-${detailCounter}">
                                    <input type="hidden" name="details[${detailCounter}][largest_proportion]" id="largest_proportion-${detailCounter}">
                                    <input type="hidden" name="details[${detailCounter}][packaging_specification]" id="packaging_specification-${detailCounter}">
                                    <input type="hidden" name="details[${detailCounter}][unit_id]" id="unit_id-${detailCounter}">
                                    <input type="hidden" name="details[${detailCounter}][smallest_unit_id]" id="smallest_unit_id-${detailCounter}">
                                    <div class="text-danger" id="quantity-error-${detailCounter}"></div>
                                </div>
                                    
                                <div class="mb-3 col-2">
                                    <label for="price_import-${detailCounter}" class="form-label">Giá nhập:<span class="text-danger">*</span></label>
                                    <input type="number" id="price_import-${detailCounter}" name="details[${detailCounter}][price_import]" class="form-control import-price" step="0.01" oninput="calculateDetailTotal(${detailCounter})" placeholder="Nhập giá nhập">
                                    <div class="text-danger" id="import-price-error-${detailCounter}"></div>
                                </div>

                                <div class="mb-3 col-2">
                                    <label for="price_sale-${detailCounter}" class="form-label">Giá bán:<span class="text-danger">*</span></label>
                                    <input type="number" id="price_sale-${detailCounter}" name="details[${detailCounter}][price_sale]" class="form-control price-sale" step="0.01" placeholder="Nhập giá bán">
                                    <div class="text-danger" id="price-sale-error-${detailCounter}"></div>
                                </div>
                                
                                <div class="mb-3 col-2">
                                    <label for="expiration_date-${detailCounter}" class="form-label">Ngày hết hạn:<span class="text-danger">*</span></label>
                                    <input type="date" id="expiration_date-${detailCounter}" name="details[${detailCounter}][expiration_date]" class="form-control">
                                    <div class="text-danger" id="expiration-date-error-${detailCounter}"></div>
                                </div>

                                <div class="mb-3 col-2">
                                    <label for="total-error-${detailCounter}" class="form-label">Thành tiền:<span class="text-danger">*</span></label>
                                    <input type="number" name="details[${detailCounter}][total]" class="form-control total" placeholder="Thành tiền" readonly>
                                    <div class="text-danger" id="total-error-${detailCounter}"></div>
                                </div>

                            </div>
                        </div>
                    </div>`;

                orderDetailsContainer.insertAdjacentHTML('beforeend', newDetail);
                // Select2
                $(`#name-${detailCounter}, #supplier-${detailCounter}, #storage_id-${detailCounter}`).select2({
                    dropdownAutoWidth: true,
                    allowClear: false
                });
                unitCounters[detailCounter] = 1;
            });

            orderDetailsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-detail')) {
                    const detailIndex = event.target.getAttribute('data-detail-index');
                    const detailRow = orderDetailsContainer.querySelector(
                        `.detail-row[data-detail-index="${detailIndex}"]`);
                    if (detailRow) detailRow.remove();
                }
            });
        });
    </script>

    <script>
        function calculateDetailTotal(detailCounter) {
            var quantity = parseFloat($(`#quantity-${detailCounter}`).val()) || 0;
            var priceImport = parseFloat($(`#price_import-${detailCounter}`).val()) || 0;
            var total = quantity * priceImport;

            $(`input[name="details[${detailCounter}][total]"]`).val(
                Number.isInteger(total) ? total : total.toFixed(2)
            );
        }

        $(document).on('input', `.form-control`, function() {
            var inputId = $(this).attr('id');
            var detailCounter = inputId.split('-')[1];
            calculateDetailTotal(detailCounter);
        });

        $(document).on('input', `[id^="quantity-"]`, function() {
            var value = $(this).val().replace(/\./g, '');
            $(this).val(value);
        });

        $(document).on('change', `select[name^="details"][id^="name"]`, function() {
            var value = $(this).val();
            var detailCounter = $(this).attr('id').split('-')[1];
            if (value) {
                $.ajax({
                    url: '/api/get-largest-unit/' + value,
                    method: 'GET',
                    success: function(response) {
                        $(`label[for="quantity-${detailCounter}"]`).text(`Số lượng (${response.largestUnit.name})`);
                        $(`#proportion-${detailCounter}`).val(response.proportion);
                        $(`#largest_proportion-${detailCounter}`).val(response.largestProportion);
                        $(`#unit_id-${detailCounter}`).val(response.largestUnit.id);
                        $(`#smallest_unit_id-${detailCounter}`).val(response.smallestUnit.id);
                        $(`#name_medicine-${detailCounter}`).val(response.nameMedicine);
                        $(`#packaging_specification-${detailCounter}`).val(response.packagingSpecification);
                    }
                })
            }
        });

    </script>
@endsection
