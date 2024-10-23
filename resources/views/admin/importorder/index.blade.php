@extends('admin.layouts.master')

@section('title')
    Phiếu nhập
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"> Danh sách Phiếu nhập</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách Phiếu nhập</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách Phiếu nhập</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.importorder.create') }}" class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label for="minDate">Ngày bắt đầu:</label>
                                    <input type="date" id="minDate" class="form-control" />
                                </div>
                                <div class="col-6">
                                    <label for="maxDate">Ngày kết thúc:</label>
                                    <div class="d-flex">
                                        <input type="date" id="maxDate" class="form-control me-2" />
                                        <button id="filter-btn" class="btn btn-primary">Lọc</button>
                                    </div>
                                </div>
                            </div>
                            <table id="importOrdersTable"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th> <!-- Thêm trường ID -->
                                        <th>Tên Kho</th>
                                        <th>Người kiểm tra</th>
                                        <th>Nhà cung cấp</th>
                                        <th>Ngày nhập</th>
                                        <th>Tổng tiền</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
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
@endsection

@section('script-libs')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


    <script>
        $(document).ready(function() {
            var table = $('#importOrdersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.importorder.index') }}',
                    data: function(d) {
                        d.startDate = $('#minDate').val(); // Lấy giá trị từ trường ngày bắt đầu
                        d.endDate = $('#maxDate').val(); // Lấy giá trị từ trường ngày kết thúc
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    }, // Thêm cột ID
                    {
                        data: 'storage.name',
                        name: 'storage.name'
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'supplier.name',
                        name: 'supplier.name'
                    },
                    {
                        data: 'date_added',
                        name: 'date_added'
                    },
                    {
                        data: 'total',
                        name: 'total'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        title: 'Import Orders',
                        className: 'btn btn-success',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Xuất luôn cột ID
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Import Orders',
                        className: 'btn btn-info',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Xuất luôn cột ID
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Import Orders',
                        className: 'btn btn-danger',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Xuất luôn cột ID
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Import Orders',
                        className: 'btn btn-warning',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5] // Xuất luôn cột ID
                        }
                    }
                ]
            });

            // Khi thay đổi giá trị trong các trường ngày, vẽ lại bảng
            $('#minDate, #maxDate').change(function() {
                table.draw();
            });

            // Khi nhấn nút lọc, vẽ lại bảng
            $('#filter-btn').click(function() {
                table.draw();
            });
        });
    </script>
@endsection
