@extends('admin.layouts.master')

@section('title')
    Nhập mới kho thuốc
@endsection

@section('content')
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
    <form action="{{ route('admin.importorder.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thông tin </h4>
                    </div><!-- end card header -->
                    <div class="card-body ">
                        <div class="live-preview">
                            <div class=" row mb-3 border p-3 rounded">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="user_name" class="form-label">Người nhập kho:</label>
                                        <input type="text" id="user_name" class="form-control"
                                            value="{{ Auth::user()->name }}" disabled>
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        {{-- @error('user_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror --}}
                                    </div>

                                    <div class="mb-3">
                                        <label for="storage_id" class="form-label">Kho thuốc:</label>
                                        <select id="storage_id" name="storage_id" class="form-select">
                                            <option value="">Chọn kho thuốc</option>
                                            @foreach ($storages as $storage)
                                                <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="storage_id" class="form-label">Nhà cung cấp:</label>
                                        <select id="supplier" name="supplier_id" class="form-select">
                                            @foreach ($suppliers as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('supplier_id')
                                            <span class="d-block text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="price_paid" class="form-label">Số tiền đã trả:</label>
                                        <input type="number" id="price_paid" name="price_paid" class="form-control">
                                        @error('price_paid')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="still_in_debt" class="form-label">Còn nợ:</label>
                                        <input type="number" id="still_in_debt" name="still_in_debt" class="form-control">
                                        @error('still_in_debt')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái:</label>
                                        <input type="text" id="" name="status" class="form-control">
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="note" class="form-label">Ghi chú:</label>
                                        <textarea id="note" name="note" class="form-control"></textarea>
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
        </div>

        <div class="row" style="max-height: 500px; overflow-y: auto;">
            <div class="col-lg-12 custom-spacing">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Chi tiết thuốc</h4>
                    </div>
                    <div id="order-details">

                    </div>
                    <!-- Nút để thêm chi tiết thuốc -->
                    <div>
                        <button type="button" id="add-detail" class="btn btn-primary mt-3 m-3">
                            <p class="mt-1 mb-0">Thêm chi tiết thuốc</p>
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

    <script src="{{ asset('js/total-calculator.js') }}"></script>
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

        ClassicEditor.create(document.querySelector('#treatment_direction'))
            .catch(error => {
                console.error(error);
            });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lấy ngày hiện tại theo định dạng YYYY-MM-DD
            const today = new Date().toISOString().split('T')[0];

            // Đếm số chi tiết thuốc
            let detailCounter = 0;

            // Đếm số đơn vị trong từng chi tiết thuốc
            let unitCounters = {};

            // Lấy container chứa chi tiết thuốc
            const orderDetailsContainer = document.getElementById('order-details');

            // Hàm tạo HTML cho đơn vị mới
            function createUnitInput(detailIndex, unitIndex) {
                return `
            <div class="row productNew mt-3 unit-row" data-unit-index="${unitIndex}">
                <div class="row mb-3 form-item mt-3">
                    <div class="col-5">
                        <label class="form-label" for="details[${detailIndex}][units][${unitIndex}][quantity]">Số lượng</label>
                        <input type="number" class="form-control" name="details[${detailIndex}][units][${unitIndex}][quantity]" oninput="calculateDetailTotal(${detailIndex})" data-unit-factor="1">
                    </div>
                    <div class="col-5">
                        <label for="">Đơn vị</label>
                        <select name="details[${detailIndex}][units][${unitIndex}][unit]" class="form-control unit-selector">
                            <option value="">Chọn đơn vị</option>
                            @foreach ($units as $donvi)
                                <option value="{{ $donvi->id }}" data-unit-factor="{{ $donvi->factor }}">{{ $donvi->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-2 d-flex align-items-end">
                    ${unitIndex === 0 ? '' : '<button type="button" class="btn btn-danger remove-unit" data-unit-index="${unitIndex}" style="font-size: 0.8rem; padding: 0.5rem 0.8rem;">Xóa</button>'}
                  </div>
                </div>
            </div>
    `;
            }

            // Xử lý khi nhấn nút "Thêm chi tiết thuốc"
            document.getElementById('add-detail').addEventListener('click', function() {
                detailCounter++;

                // Tạo khối chi tiết thuốc mới
                const newDetail = `
                <div class="mb-3 border p-3 rounded detail-row" data-detail-index="${detailCounter}" style="background-color: #d5d5d5">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-outline-success btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseDetails${detailCounter}" aria-expanded="false" aria-controls="collapseDetails${detailCounter}">
                            <p class="mt-1 mb-0">Thêm tên thuốc</p>
                        </button>
                        <button type="button" class="btn btn-danger remove-detail" data-detail-index="${detailCounter}">Xóa chi tiết</button>
                    </div>
                    <div class="collapse mt-2" id="collapseDetails${detailCounter}">
                        <div class="row">
                            <div class="col-6">
                                <label for="details[${detailCounter}][type_product]" class="form-label">Loại sản phẩm:</label>
                                <select name="details[${detailCounter}][type_product]" class="form-select" onchange="toggleInputs(${detailCounter})">
                                    <option value="0">Thuốc</option>
                                    <option value="1">Dụng cụ</option>
                                </select>

                                <label for="details[${detailCounter}][name]" class="form-label">Tên thuốc:</label>
                                <input type="text" name="details[${detailCounter}][name]" class="form-control">

                                <label for="details[${detailCounter}][category_id]" class="form-label">Danh mục thuốc:</label>
                                <select name="details[${detailCounter}][category_id]" class="form-select">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>

                                <label for="details[${detailCounter}][medicine_code]" class="form-label">Mã thuốc:</label>
                                <input type="text" name="details[${detailCounter}][medicine_code]" class="form-control">
                                <div class="text-danger" id="medicine-code-error-${detailCounter}"></div>


                                <div class="m-2">
                                         <label class="form-label">Đơn vị:</label>
                                        <div class="mb-3 units" data-detail-index="${detailCounter}">
                                            ${createUnitInput(detailCounter, 0)}
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-primary add-unit" data-detail-index="${detailCounter}">Thêm đơn vị</button>
                                        </div>
                                </div>


                                <label for="details[${detailCounter}][price_import]" class="form-label">Giá nhập:</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="details[${detailCounter}][price_import]" class="form-control import-price" step="0.01" oninput="calculateDetailTotal(${detailCounter})" placeholder="Nhập giá nhập" required>
                                    <span class="input-group-text">VND</span>
                                </div>
                                <div class="text-danger" id="import-price-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][price_sale]" class="form-label">Giá bán:</label>
                                <input type="number" name="details[${detailCounter}][price_sale]" class="form-control price-sale" step="0.01">
                                <div class="text-danger" id="price-sale-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][total]" class="form-label">Tổng:</label>
                                <div class="input-group mb-3">
                                    <input type="number" name="details[${detailCounter}][total]" class="form-control total" placeholder="Tổng số tiền" readonly>
                                    <span class="input-group-text">VND</span>
                                </div>
                                <div class="text-danger" id="total-error-${detailCounter}"></div>
                            </div>

                            <div class="col-6">
                                <label for="details[${detailCounter}][registration_number]" class="form-label">Số đăng ký:</label>
                                <input type="text" name="details[${detailCounter}][registration_number]" class="form-control">
                                <div class="text-danger" id="registration-number-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][origin]" class="form-label">Xuất xứ:</label>
                                <input type="text" name="details[${detailCounter}][origin]" class="form-control">
                                <div class="text-danger" id="origin-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][packaging_specification]" class="form-label">Quy cách đóng gói:</label>
                                <input type="text" name="details[${detailCounter}][packaging_specification]" class="form-control">
                                <div class="text-danger" id="packaging-specification-error-${detailCounter}"></div>

                                <div id="additionalInputs">
                                    <div class="product-info">
                                        <label for="details[${detailCounter}][active_ingredient]" class="form-label">Hoạt chất:</label>
                                        <input type="text" name="details[${detailCounter}][active_ingredient]" class="form-control">
                                        <div class="text-danger" id="active-ingredient-error-${detailCounter}"></div>
                                    </div>

                                    <div class="product-info">
                                        <label for="details[${detailCounter}][concentration]" class="form-label">Hàm lượng:</label>
                                        <input type="text" name="details[${detailCounter}][concentration]" class="form-control">
                                        <div class="text-danger" id="concentration-error-${detailCounter}"></div>
                                    </div>

                                    <div class="product-info">
                                        <label for="details[${detailCounter}][dosage]" class="form-label">Liều lượng:</label>
                                        <input type="text" name="details[${detailCounter}][dosage]" class="form-control">
                                        <div class="text-danger" id="dosage-error-${detailCounter}"></div>
                                    </div>

                                    <div class="product-info">
                                        <label for="details[${detailCounter}][administration_route]" class="form-label">Đường dùng:</label>
                                        <input type="text" name="details[${detailCounter}][administration_route]" class="form-control">
                                        <div class="text-danger" id="administration-route-error-${detailCounter}"></div>
                                    </div
                                </div>

                                <label for="details[${detailCounter}][temperature]" class="form-label">Nhiệt độ bảo quản:</label>
                                <input type="number" name="details[${detailCounter}][temperature]" class="form-control">
                                <div class="text-danger" id="temperature-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][moisture]" class="form-label">Độ ẩm bảo quản:</label>
                                <input type="number" name="details[${detailCounter}][moisture]" class="form-control">
                                <div class="text-danger" id="moisture-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][expiration_date]" class="form-label">Ngày hết hạn:</label>
                                <input type="date" name="details[${detailCounter}][expiration_date]" class="form-control">
                                <div class="text-danger" id="expiration-date-error-${detailCounter}"></div>

                                <label for="details[${detailCounter}][image]" class="form-label">Hình ảnh:</label>
                                <input type="file" name="details[${detailCounter}][image]" class="form-control">
                                <div class="text-danger" id="image-error-${detailCounter}"></div>
                            </div>
                       </div>
                    </div>
                </div>`;

                // Thêm khối chi tiết thuốc mới vào container
                orderDetailsContainer.insertAdjacentHTML('beforeend', newDetail);
                unitCounters[detailCounter] = 1;
            });

            // Xử lý khi nhấn nút "Thêm đơn vị"
            orderDetailsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('add-unit')) {
                    const detailIndex = event.target.getAttribute('data-detail-index');
                    const unitsContainer = orderDetailsContainer.querySelector(
                        `.units[data-detail-index="${detailIndex}"]`);

                    const unitIndex = unitCounters[detailIndex];
                    unitsContainer.insertAdjacentHTML('beforeend', createUnitInput(detailIndex, unitIndex));
                    unitCounters[detailIndex]++;
                }
            });

            // Xử lý khi nhấn nút "Xóa chi tiết thuốc"
            orderDetailsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-detail')) {
                    const detailIndex = event.target.getAttribute('data-detail-index');
                    const detailRow = orderDetailsContainer.querySelector(
                        `.detail-row[data-detail-index="${detailIndex}"]`);
                    if (detailRow) detailRow.remove();
                }
            });

            // Xử lý khi nhấn nút "Xóa đơn vị"
            orderDetailsContainer.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-unit')) {
                    const unitRow = event.target.closest('.unit-row');
                    if (unitRow) unitRow.remove();
                }
            });

            // Hàm tính tổng từng chi tiết thuốc dựa trên số lượng của đơn vị cha
            window.calculateDetailTotal = function(detailIndex) {
                // Lấy đơn vị cha (đơn vị đầu tiên)
                const parentUnit = document.querySelector(`.unit-row[data-unit-index="0"]`);
                const priceImport = parseFloat(document.querySelector(
                    `input[name="details[${detailIndex}][price_import]"]`).value) || 0;

                // Lấy số lượng từ đơn vị cha
                const quantity = parseFloat(parentUnit.querySelector('input[name*="[quantity]"]').value) || 0;

                // Tính tổng cho chi tiết
                const total = quantity * priceImport;

                // Cập nhật giá tổng vào trường tổng của chi tiết thuốc
                const totalField = document.querySelector(`input[name="details[${detailIndex}][total]"]`);
                if (totalField) {
                    totalField.value = total.toFixed(2); // Đặt giá trị tổng với hai chữ số thập phân
                }
            }
        });
    </script>

    <script>
        function toggleInputs(detailIndex) {
            const typeProductSelect = document.querySelector(`select[name="details[${detailIndex}][type_product]"]`);
            const productInfoElements = document.querySelectorAll(`#additionalInputs .product-info`);

            if (typeProductSelect.value === '0') { // Khi chọn "Thuốc"
                productInfoElements.forEach(info => {
                    info.style.display = 'block'; // Hiện thị tất cả các input và label
                });
            } else if (typeProductSelect.value === '1') { // Khi chọn "Dụng cụ"
                productInfoElements.forEach(info => {
                    info.style.display = 'none'; // Ẩn tất cả các input và label
                });
            } else {
                productInfoElements.forEach(info => {
                    info.style.display = 'none'; // Ẩn nếu không chọn loại
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const typeProductSelect = document.querySelector(
                `select[name="details[${detailCounter}][type_product]"]`);
            toggleInputs(detailCounter); // Gọi hàm để khởi tạo trạng thái
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
