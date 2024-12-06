@extends('admin.layouts.master')

@section('title')
    Bảng điều khiển
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col">

                <div class="h-100">
                    <div class="row mb-3 pb-1">
                        <div class="col-12">
                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                <div class="flex-grow-1">
                                    <h4 class="fs-16 mb-1">Xin chào, {{ Auth::user()->name }}!</h4>
                                    <p class="text-muted mb-0">Đây là những thông số của của hàng của bạn nhé!.</p>
                                </div>
                                <div class="mt-3 mt-lg-0">
                                    <form action="javascript:void(0);">
                                        <div class="row g-3 mb-0 align-items-center">
                                            <div class="col-sm-auto">
                                                <div class="input-group" style="width: 300px;">
                                                    <input type="text" id="dateRangePicker" class="form-control"
                                                        name="date_range" placeholder="Lọc ngày tháng"
                                                        style="background-color: #fff;">
                                                    <div class="input-group-text bg-primary border-primary text-white"
                                                        id="icon-calendar">
                                                        <i class="ri-calendar-2-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-auto">
                                                <a href="{{ route('admin.medicines.create') }}" type="button"
                                                    class="btn btn-soft-success"><i
                                                        class="ri-add-circle-line align-middle me-1"></i> Thêm
                                                    Thuốc</a>
                                            </div>
                                            <!--end col-->

                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>

                            </div><!-- end card header -->
                        </div>


                        <!--end col-->
                    </div>


                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Tổng Doanh
                                                Thu</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span id="totalRevenue">0</span>
                                                <!-- Phần tử có ID "totalRevenue" để hiển thị tổng doanh thu -->
                                            </h4>

                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="bx bx-dollar-circle text-success"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>



                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng đơn thuốc
                                                bán ra</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span class="counter-value" id="totalOrders" data-target="0">0</span> Đơn
                                            </h4>
{{-- 
                                            <a href="" class="text-decoration-underline">Danh sách đơn thuốc thông
                                                thường</a><br>
                                            <a href="" class="text-decoration-underline">Danh sách đơn thuốc cắt
                                                liều</a> --}}

                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-info-subtle rounded fs-3">
                                                <i class="bx bx-shopping-bag text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->



                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng số khách
                                                hàng</p>
                                        </div>
                                        {{-- <div class="flex-shrink-0">
                                        <h5 class="text-success fs-14 mb-0">
                                            <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +29.08 %
                                        </h5>
                                    </div> --}}
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span id="totalCustomers" class="counter-value">0</span> Người
                                            </h4>
                                            <a href="{{ route('admin.customers.index') }}"
                                                class="text-decoration-underline">Xem danh sách</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                <i class="bx bx-user-circle text-warning"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-3 col-md-6">
                            <!-- card -->
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Tổng lợi
                                                nhuận</p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-muted fs-14 mb-0">
                                                +0.00 %
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">$<span class="counter-value"
                                                    data-target="165.89">0</span>k </h4>
                                            <a href="" class="text-decoration-underline">Xem chi tiết</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="bx bx-wallet text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Thông số thua nhập cửa hàng</h4>
                                    <div>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            ALL
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            1M
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            6M
                                        </button>
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            1Y
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-light-subtle">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value"
                                                        data-target="7585">0</span></h5>
                                                <p class="text-muted mb-0">Đơn thuốc</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1">$<span class="counter-value"
                                                        data-target="22.89">0</span>k</h5>
                                                <p class="text-muted mb-0">Thu nhập</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="367">0</span>
                                                </h5>
                                                <p class="text-muted mb-0">Hoàn trả</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                <h5 class="mb-1 text-success"><span class="counter-value"
                                                        data-target="18.92">0</span>%</h5>
                                                <p class="text-muted mb-0">Tỉ lệ tư vấn</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body p-0 pb-2">
                                    <div class="w-100">
                                        <div id="customer_impression_charts"
                                            data-colors='["--vz-primary", "--vz-success", "--vz-danger"]'
                                            class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-4">
                            <!-- card -->
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Bản đồ nhà cung cấp</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            Xuất báo cáo
                                        </button>
                                    </div>
                                </div><!-- end card header -->

                                <!-- card body -->
                                <div class="card-body">

                                    <div id="sales-by-locations"
                                        data-colors='["--vz-light", "--vz-success", "--vz-primary"]' style="height: 269px"
                                        dir="ltr"></div>

                                    <div class="px-2 py-2 mt-1" id="dashboard-suppliers"></div>
                                </div>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top 5 Hãng thuốc bán chạy nhất</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold text-uppercase fs-12">Sắp xếp theo:
                                                </span><span class="text-muted">Hôm nay<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Hôm nay</a>
                                                <a class="dropdown-item" href="#">Hôm qua</a>
                                                <a class="dropdown-item" href="#">7 ngày trước</a>
                                                <a class="dropdown-item" href="#">7 ngày sau</a>
                                                <a class="dropdown-item" href="#">Tháng này</a>
                                                <a class="dropdown-item" href="#">Tháng trước</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0 text-center"
                                            id="suppliersTable">
                                            <thead>
                                                <tr>
                                                    <th>Tên Nhà Cung Cấp</th>
                                                    <th>Ngày Tham Gia</th>
                                                    <th>Tổng Đơn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Dữ liệu sẽ được thêm vào đây -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Những thuốc bán chạy nhất</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">Báo cáo<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Tải xuống báo cáo</a>
                                                <a class="dropdown-item" href="#">Export</a>
                                                <a class="dropdown-item" href="#">Import</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-centered table-hover align-middle table-nowrap mb-0 text-center"
                                            id="medicinesTable">
                                            <thead>
                                                <tr>
                                                    <th>Tên thuốc </th>
                                                    <th>Ngày nhập</th>
                                                    <th>Tổng Đơn</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Dữ liệu sẽ được thêm vào đây -->
                                            </tbody>
                                        </table><!-- end table -->
                                    </div>
                                </div> <!-- .card-body-->
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Thông kê có bao nhiêu thuốc thuốc 1 danh mục
                                    </h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">Báo cáo<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('admin.catalogues.index') }}">Xem
                                                    chi tiết</a>
                                                <a class="dropdown-item" href="#">Tải xuống</a>
                                                <a class="dropdown-item" href="#">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div id="store-visits-source"></div>
                                    <div class="row text-center mt-3" id="category-legend"></div>
                                    <!-- Nơi hiển thị danh mục -->
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                        <div class="col-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Thống kê thuốc, dụng cụ theo kho</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted">Báo cáo<i
                                                        class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{ route('admin.catalogues.index') }}">Xem
                                                    chi tiết</a>
                                                <a class="dropdown-item" href="#">Tải xuống</a>
                                                <a class="dropdown-item" href="#">Export</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
                                        <canvas id="myPieChart" style="width: 100%; height: 100%;"></canvas>
                                    </div>

                                    <div class="d-flex justify-content-center align-items-center gap-1">
                                        <p>Tổng số lượng thuốc trong tất cả các kho:</p>
                                        <p id="totalMedicinesCount"></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> <!-- end row-->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Đơn hàng gần đây</h4>
                                </div><!-- end card header -->

                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table
                                            class="table table-borderless table-centered align-middle table-nowrap mb-0 text-center"
                                            style="min-height: 300px">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">STT</th>
                                                    <th scope="col">Khách hàng</th>
                                                    <th scope="col">Bệnh</th>
                                                    <th scope="col">Tổng tiền</th>
                                                    <th scope="col">Người kê đơn</th>
                                                </tr>
                                            </thead>
                                            <tbody id="recentOrders">

                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div>
                                </div>
                            </div> <!-- .card-->
                        </div> <!-- .col-->
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection

@section('style-libs')
    <!-- jsvectormap css -->
    <link href="{{ asset('theme/admin/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('script-libs')
    <!-- apexcharts -->
    <script src="{{ asset('theme/admin/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('theme/admin/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('theme/admin/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('theme/admin/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('library/order.js') }}"></script>
   
    <script src="{{asset('library/dashboard-topsupplier.js')}}"></script>

    <script src="{{asset('library/dashboard-topmedicines.js')}}"></script>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            // Gửi yêu cầu AJAX để lấy dữ liệu tổng số khách hàng
            flatpickr("#dateRangePicker", {
                mode: "range", // Chọn khoảng thời gian
                dateFormat: "Y-m-d",
                locale: "vi" // Ngôn ngữ Tiếng Việt (tùy chọn)
            });

            // Khi nhấn vào icon, cũng mở DatePicker
            document.getElementById('icon-calendar').addEventListener('click', function() {
                document.getElementById('dateRangePicker').focus(); // Kích hoạt input
            });
            $.ajax({
                url: "{{ route('dashboard-customers') }}",
                method: 'GET',
                success: function(response) {
                    $('#totalCustomers').text(response.totalCustomers);
                },
                error: function() {
                    alert('Lỗi khi lấy dữ liệu khách hàng');
                }
            });

            // Khởi tạo Date Range Picker
            flatpickr("#dateRangePicker", {
                mode: "range",
                dateFormat: "d/m/Y",
                locale: "vn",
                monthSelectorType: "static",
                onClose: function(selectedDates, dateStr, instance) {
                    document.getElementById('dateRangePicker').value = dateStr;
                }
            });

            // Gửi yêu cầu AJAX để lấy dữ liệu danh mục thuốc cho biểu đồ donut
            $.ajax({
                url: "{{ route('dashboard-categories') }}",
                method: "GET",
                success: function(data) {
                    const options = {
                        chart: {
                            type: 'donut',
                            height: 230,
                        },
                        series: data.map(item => item.count),
                        labels: data.map(item => item.name),
                        colors: ['#5A8DEE', '#f46a6a', '#34c38f', '#f7b84b', '#50a5f1'],
                        legend: {
                            show: false
                        },
                    };
                    const chart = new ApexCharts(document.querySelector("#store-visits-source"),
                        options);
                    chart.render();

                    // Tạo phần legend tùy chỉnh
                    let legendHTML = '<div class="row justify-content-center">';
                    data.forEach((item, index) => {
                        if (index % 4 === 0 && index !== 0) {
                            legendHTML += '</div><div class="row justify-content-center">';
                        }
                        legendHTML += `
                            <div class="col-3 text-center legend-item" data-index="${index}" style="cursor: pointer; font-size: 8px;">
                                <span style="color: ${options.colors[index]}; display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: ${options.colors[index]};"></span>
                                ${item.name}
                            </div>
                        `;
                    });
                    legendHTML += '</div>';
                    $('#category-legend').html(legendHTML);

                    // Sự kiện hover cho legend
                    $('.legend-item').on('mouseover', function() {
                        const index = $(this).data('index');
                        chart.toggleSeries(chart.w.globals.seriesNames[index]);
                    }).on('mouseleave', function() {
                        const index = $(this).data('index');
                        chart.toggleSeries(chart.w.globals.seriesNames[index]);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Có lỗi xảy ra khi lấy dữ liệu:", textStatus, errorThrown);
                }
            });

            // Gọi API để lấy dữ liệu tổng số lượng thuốc và vẽ biểu đồ tròn
            fetch('api/dashboard/storages')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Lỗi khi gọi API');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('totalMedicinesCount').innerText = data.total_medicines_count;

                    const labels = data.storages.map(storage => storage.storage_name);
                    const medicinesData = data.storages.map(storage => storage.medicines_count);

                    const ctx = document.getElementById('myPieChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: medicinesData,
                                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                                    '#9966FF'
                                ],
                                hoverBackgroundColor: ['#FF6384', '#36A2EB', '#FFCE56',
                                    '#4BC0C0', '#9966FF'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `${context.label}: ${context.raw} thuốc`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi khi tải dữ liệu.');
                });

            // Gửi yêu cầu API lấy dữ liệu tổng doanh thu
            fetch('api/dashboard/total-revenue')
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#totalRevenue').textContent = data.totalRevenue;
                })
                .catch(error => console.error('Lỗi:', error));

            $('#dateRangePicker').on('change', function() {
                var dateRangeValue = $(this).val();
                console.log("Khoảng thời gian đã chọn:", dateRangeValue);

                // Tách startDate và endDate từ giá trị của dateRangePicker
                var dates = dateRangeValue.match(
                    /(\d{2}\/\d{2}\/\d{4})/g); // Tìm tất cả các ngày trong chuỗi
                var startDate = dates ? dates[0] : null;
                var endDate = dates && dates[1] ? dates[1] : null;

                console.log("startDate:", startDate, "endDate:", endDate);

                // Nếu chỉ chọn 1 ngày, tự động gán endDate = startDate
                if (!endDate) {
                    endDate = startDate;
                }

                // Gửi yêu cầu AJAX
                $.ajax({
                    url: '/api/dashboard/filter',
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        startDate: startDate,
                        endDate: endDate,
                    },
                    success: function(response) {
                        console.log("Dữ liệu trả về:", response);

                        // Hiển thị tổng khách hàng
                        $('#totalCustomers').text(response.totalCustomers || 0);

                        // Hiển thị tổng đơn hoàng bán
                        $('#totalOrders').text(response.totalOrders || 0);

                        // Định dạng doanh thu với dấu phân cách và hiển thị 'VND'
                        var totalRevenue = response.totalRevenue || 0;
                        var formattedRevenue = totalRevenue
                            .toLocaleString(); // Định dạng số với dấu phân cách
                        $('#totalRevenue').text(formattedRevenue + " VND");
                    },
                    error: function(xhr, status, error) {
                        console.error("Lỗi khi gửi yêu cầu:", error);
                        console.error("Trạng thái:", status);
                        console.error("Phản hồi từ server:", xhr.responseText);
                        alert("Không thể tải dữ liệu. Vui lòng thử lại sau!");
                    },
                });

            });
            fetch('api/dashboard/total-orders') // Đảm bảo endpoint này trả về tổng số đơn thuốc
                .then(response => response.json())
                .then(data => {
                    const totalOrders = data.totalCount;
                    // console.log('Tổng số đơn thuốc:', totalOrders);
                    const counter = document.querySelector('.counter-value');
                    counter.textContent = totalOrders;

                    counter.setAttribute('data-target', totalOrders);
                })
                .catch(error => console.error('Lỗi khi tải dữ liệu:', error));
        });
    </script>
@endsection
