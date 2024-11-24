@extends('admin.layouts.master')

@section('title')
    Danh sách người dùng
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách người dùng</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Tables</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Danh sách người dùng
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title mb-0">
                            Danh sách người dùng
                        </h5>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="start-date">Ngày bắt đầu:</label>
                                <input type="date" id="start-date" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label for="end-date">Ngày kết thúc:</label>
                                <div class="d-flex">
                                    <input type="date" id="end-date" class="form-control me-2" />
                                    <button id="filter-btn" class="btn btn-primary">Lọc</button>
                                </div>
                            </div>
                        </div>
                        <table id="userDataTable"
                            class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Ảnh</th>
                                    <th>Email</th>
                                    <th>Vai trò</th>
                                    <th>Ngày tạo</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dữ liệu người dùng sẽ được load tại đây -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
    </div>
@endsection

@section('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#userDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.users.index') }}',
                    data: function(d) {
                        d.startDate = $('#start-date').val();
                        d.endDate = $('#end-date').val();
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false

                    },
                    {
                        data: 'email'
                    },

                    {
                        data: 'type',
                        render: function(data, type, row) {
                            if (data === 'admin') {
                                return '<span class="badge bg-primary">Quản trị viên</span>';
                            } else if (data === 'staff') {
                                return '<span class="badge bg-success">Nhân Viên</span>';
                            } else {
                                return '<span class="badge bg-secondary">Không có</span>';
                            }
                        }
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Bfrtip',
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
                buttons: [{
                        extend: 'excel',
                        text: 'Xuất Excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 2 && idx !==
                                7; // Ví dụ: Nếu cột `action` là cột số 7
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Xuất CSV',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 2 && idx !==
                                7; // Ví dụ: Nếu cột `action` là cột số 7
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Xuất PDF',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 2 && idx !==
                                7; // Ví dụ: Nếu cột `action` là cột số 7
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'In',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 2 && idx !==
                                7; // Ví dụ: Nếu cột `action` là cột số 7
                            }
                        }
                    }
                ]

            });

            $('#filter-btn').click(function() {
                table.draw();
            });

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();

                let form = $(this).closest('.delete-form');
                Swal.fire({
                    title: "Bạn có chắc muốn xóa không?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Xóa!",
                    cancelButtonText: "Hủy",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
