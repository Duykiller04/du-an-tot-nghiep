@extends('admin.layouts.master')

@section('title')
    Danh sách môi trường
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách Môi Trường</h4>
        
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Môi Trường</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
        
                <!-- Tiêu đề và thông tin nhiệt độ, độ ẩm -->
                <div class="page-title-box text-center mt-4">
                    <h2 class="mb-4">Nhiệt độ và Độ ẩm hiện tại</h2>
                    <div class="d-flex justify-content-center align-items-center gap-4">
                        <div class="d-flex align-items-center">
                            <i class="ri-thermometer-line me-2 text-warning" style="font-size: 24px;"></i>
                            <span class="text-warning" style="font-size: 24px; font-weight: bold;">{{ $weatherData['main']['temp'] }}°C</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="ri-humidity-line me-2 text-primary" style="font-size: 24px;"></i>
                            <span class="text-primary" style="font-size: 24px; font-weight: bold;">{{ $weatherData['main']['humidity'] }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- end page title -->

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách môi trường</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.environments.export') }}" class="btn btn-primary">Xuất Excel</a>
                                    <a href="{{ route('admin.environments.create') }}" class="btn btn-success add-btn"
                                        id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Thêm môi trường</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Hiển thị nhiệt độ và độ ẩm từ API -->
                                    

                                    <table id="environments-table"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Thời gian</th>
                                                <th>Nhiệt độ môi trường</th>
                                                <th>Nhiệt độ trong kho</th>
                                                <th>Độ ẩm môi trường</th>
                                                <th>Độ ẩm trong kho</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($environments as $environment)
                                                <tr>
                                                    <td>{{ $environment->id }}</td>
                                                    <td>{{ $environment->time->format('H:i:s d-m-Y') }}</td>
                                                    <td>{{ $environment->temperature }}°C</td>
                                                    <td>{{ $environment->real_temperature }}°C</td>
                                                    <td>{{ $environment->huminity }}%</td>
                                                    <td>{{ $environment->real_humidity }}%</td>
                                                    <td>
                                                        <a href="{{ route('admin.environments.edit', $environment->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                                        <form action="{{ route('admin.environments.destroy', $environment->id) }}" method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa')">Xóa</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!-- container-fluid -->
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <!-- Feather Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#environments-table').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                buttons: [
                    'copy', 'excel', 'pdf', 'print'
                ],
                language: {
                    "sEmptyTable": "Không có dữ liệu trong bảng",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 mục",
                    "sInfoFiltered": "(đã lọc từ _MAX_ mục)",
                    "sLengthMenu": "Hiển thị _MENU_ mục",
                    "sLoadingRecords": "Đang tải...",
                    "sProcessing": "Đang xử lý...",
                    "sSearch": "Tìm kiếm:",
                    "sZeroRecords": "Không tìm thấy kết quả nào",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sLast": "Cuối",
                        "sNext": "Kế tiếp",
                        "sPrevious": "Trước"
                    },
                    "oAria": {
                        "sSortAscending": ": Sắp xếp tăng dần",
                        "sSortDescending": ": Sắp xếp giảm dần"
                    }
                },
            });
        });
    </script>
@endsection
