@extends('admin.layouts.master')

@section('title')
    Danh sách khách hàng
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách khách hàng</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách khách hàng</a></li>
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

                <div class="modal fade" id="createCustomerModal" tabindex="-1" aria-labelledby="createCustomerModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createCustomerModal">Thêm mới danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('admin.customers.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="nameCreate">Tên khách hàng</label>
                                            <input type="text" name="nameCreate" class="form-control" id="nameCreate"
                                                placeholder="Nhập tên khách hàng" value="{{ old('nameCreate') }}">
                                            @error('nameCreate')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="phoneCreate">Số điện thoại</label>
                                            <input type="text" name="phoneCreate" class="form-control" id="phoneCreate"
                                                placeholder="Nhập số điện thoại" value="{{ old('phoneCreate') }}">
                                            @error('phoneCreate')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="addressCreate">Địa chỉ</label>
                                            <input type="text" name="addressCreate" class="form-control"
                                                id="addressCreate" placeholder="Nhập địa chỉ khách hàng"
                                                value="{{ old('addressCreate') }}">
                                            @error('addressCreate')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="emailCreate">Email</label>
                                            <input type="text" name="emailCreate" class="form-control" id="emailCreate"
                                                placeholder="Nhập email khách hàng" value="{{ old('emailCreate') }}">
                                            @error('emailCreate')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="ageCreate">Tuổi</label>
                                            <input type="number" name="ageCreate" class="form-control" id="ageCreate"
                                                placeholder="Nhập tuổi khách hàng" value="{{ old('ageCreate') }}">
                                            @error('ageCreate')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="weightCreate">Cân nặng</label>
                                            <input type="number" name="weightCreate" class="form-control" id="weightCreate"
                                                placeholder="Nhập cân nặng khách hàng" value="{{ old('weightCreate') }}">
                                            @error('weightCreate')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCustomerModalLabel">Sửa danh mục</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data" id="editForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="edit_customer_id" name="customer_id">
                                <div class="modal-body">
                                    <div class="row"> <!-- Bắt đầu hàng -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="edit_name">Tên khách hàng</label>
                                            <input type="text" name="nameEdit" class="form-control" id="edit_name"
                                                placeholder="Nhập tên khách hàng">
                                            @error('nameEdit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="edit_phone">Số điện thoại</label>
                                            <input type="text" name="phoneEdit" class="form-control" id="edit_phone"
                                                placeholder="Nhập số điện thoại">
                                            @error('phoneEdit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="edit_address">Địa chỉ</label>
                                            <input type="text" name="addressEdit" class="form-control"
                                                id="edit_address" placeholder="Nhập địa chỉ khách hàng">
                                            @error('addressEdit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="edit_email">Email</label>
                                            <input type="text" name="emailEdit" class="form-control" id="edit_email"
                                                placeholder="Nhập email khách hàng">
                                            @error('emailEdit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="edit_age">Tuổi</label>
                                            <input type="number" name="ageEdit" class="form-control" id="edit_age"
                                                placeholder="Nhập tuổi khách hàng">
                                            @error('ageEdit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="edit_weight">Cân nặng</label>
                                            <input type="number" name="weightEdit" class="form-control"
                                                id="edit_weight" placeholder="Nhập cân nặng khách hàng">
                                            @error('weightEdit')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Sửa</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>





                <div class="card" id="diseaseList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách khách hàng</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button type="button" id="createCustomerBtn" class="btn btn-primary">
                                        Thêm mới khách hàng
                                    </button>
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
                                <!-- Lọc theo ngày -->

                                <table id="example"
                                    class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                    style="width: 100%;" aria-describedby="buttons-datatables_info">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên khách hàng</th>
                                            <th>Số điện thoại</th>
                                            <th>Địa chỉ</th>
                                            <th>Email</th>
                                            <th>Tuổi</th>
                                            <th>Cân nặng</th>
                                            <th>Thời gian tạo</th>
                                            <th>Thời gian cập cập nhập</th>
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
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>


    <script>
        $(document).ready(function() {

            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.customers.index') }}',
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
                        data: 'phone'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'age'
                    },
                    {
                        data: 'weight'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
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
                                return idx !==
                                    12; // Ví dụ: Nếu cột `action` là cột số 12
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
                                    12; // Ví dụ: Nếu cột `action` là cột số 12
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
                                    12; // Ví dụ: Nếu cột `action` là cột số 12
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
                                    12; // Ví dụ: Nếu cột `action` là cột số 12
                            }
                        }
                    }
                ]

            });
            // table.on('xhr', function(e, settings, json) {
            //     console.log("Dữ liệu nhận được:", json); // Hiển thị dữ liệu sau khi tải
            // });
            $('#filter-btn').click(function() {
                table.draw();
            });


            @if ($errors->has('nameCreate'))
                $('#createCustomerModal').modal('show');
            @endif
            @if ($errors->has('phoneCreate'))
                $('#createCustomerModal').modal('show');
            @endif
            @if ($errors->has('addressCreate'))
                $('#createCustomerModal').modal('show');
            @endif
            @if ($errors->has('emailCreate'))
                $('#createCustomerModal').modal('show');
            @endif
            @if ($errors->has('ageCreate'))
                $('#createCustomerModal').modal('show');
            @endif
            @if ($errors->has('weightCreate'))
                $('#createCustomerModal').modal('show');
            @endif
            @if ($errors->has('nameEdit'))
                $('#editCustomerModal').modal('show');
            @endif
            @if ($errors->has('phoneEdit'))
                $('#editCustomerModal').modal('show');
            @endif
            @if ($errors->has('addressEdit'))
                $('#editCustomerModal').modal('show');
            @endif
            @if ($errors->has('emailEdit'))
                $('#editCustomerModal').modal('show');
            @endif
            @if ($errors->has('ageEdit'))
                $('#editCustomerModal').modal('show');
            @endif
            @if ($errors->has('weightEdit'))
                $('#editCustomerModal').modal('show');
            @endif


            $('#createCustomerBtn').on('click', function() {
                $('#createCustomerModal').modal('show');
            });

            $('#example tbody').on('click', '.btn-edit', function() {
                // console.log("Button clicked");
                var row = $(this);
                // console.log(row);
                var data = $('#example').DataTable().row(row).data();
                // console.log(data);
                $('#edit_customer_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_phone').val(data.phone);
                $('#edit_address').val(data.address);
                $('#edit_email').val(data.email);
                $('#edit_age').val(data.age);
                $('#edit_weight').val(data.weight);

                $('#editCustomerModal').modal('show');

            });

            $('#editCustomerModal').on('show.bs.modal', function() {
                var id = $('#edit_customer_id').val() ?? '';

                $('#editForm').attr({
                    'action': '{{ route('admin.customers.update', ':id') }}'.replace(':id', id),
                    'method': 'POST'
                });

            });

            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();

                let form = $(this).closest('.delete-form');
                Swal.fire({
                    title: "Bạn có chắc muốn xóa không?",
                    text: "Bạn sẽ không thể khôi phục lại!",
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

    <!-- JS CỦA LOC VS XUẤT excel VÀ CÁC FILE -->
@endsection
