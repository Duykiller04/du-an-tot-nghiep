@extends('admin.layouts.master')

@section('title')
    Danh sách thuốc
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách thuốc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách thuốc</a></li>
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

                <div class="card" id="diseaseList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách thuốc</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.medicines.create') }}" type="button"
                                        class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="buttons-datatables_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
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
                                <table id="example"
                                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    style="width: 100%;" aria-describedby="buttons-datatables_info">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã thuốc</th>
                                            <th>Tên thuốc</th>
                                            <th>Ảnh thuốc</th>
                                            <th>Danh mục</th>
                                            <th>Thời gian tạo</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
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
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: '{{ route('admin.medicines.index') }}',
                        data: function(d) {
                            d.startDate = $('#start-date').val();
                            d.endDate = $('#end-date').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'medicine_code'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'image',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'category.name'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'action',
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
                                    return idx !==
                                        11; // Ví dụ: Nếu cột `action` là cột số 8
                                }
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'Xuất CSV',
                            exportOptions: {
                                columns: function(idx, data, node) {
                                    // Loại bỏ cột `action` khi xuất
                                    return idx !==
                                        11; // Ví dụ: Nếu cột `action` là cột số 12
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'Xuất PDF',
                            exportOptions: {
                                columns: function(idx, data, node) {
                                    // Loại bỏ cột `action` khi xuất
                                    return idx !==
                                        11; // Ví dụ: Nếu cột `action` là cột số 12
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: 'In',
                            exportOptions: {
                                columns: function(idx, data, node) {
                                    // Loại bỏ cột `action` khi xuất
                                    return idx !==
                                        11; // Ví dụ: Nếu cột `action` là cột số 12
                                }
                            }
                        }
                    ]
                });

                $('#filter-btn').click(function() {
                    table.draw();
                });
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
