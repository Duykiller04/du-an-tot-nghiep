@extends('admin.layouts.master')

@section('title')
    Danh sách nhà cung cấp
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách nhà cung cấp</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách loại bệnh</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Create supplier Modal -->
        <div class="modal fade" id="createSupplierModal" tabindex="-1" aria-labelledby="createSupplierModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createSupplierModalLabel">Thêm mới nhà cung cấp</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.suppliers.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tax_code" class="form-label">Mã số thuế (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="tax_code" name="tax_code"
                                    value="{{ old('tax_code') }}">
                                @error('tax_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên nhà cung cấp (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email (<span class="text-danger">*</span>)</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
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

        <!-- Edit supplier Modal -->
        <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editSupplierModalLabel">Cập nhật nhà cung cấp</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_supplier_id" name="supplier_id" value="{{ old('supplier_id') }}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tax_code" class="form-label">Mã số thuế (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="tax_code_edit" name="tax_code_edit" value="{{ old('tax_code_edit') }}">
                                @error('tax_code_edit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên nhà cung cấp (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="name_edit" name="name_edit" value="{{ old('name_edit') }}">
                                @error('name_edit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email (<span
                                        class="text-danger">*</span>)</label>
                                <input type="email" class="form-control" id="email_edit" name="email_edit" value="{{ old('email_edit') }}">
                                @error('email_edit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="phone_edit" name="phone_edit" value="{{ old('phone_edit') }}">
                                @error('phone_edit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ (<span
                                        class="text-danger">*</span>)</label>
                                <input type="text" class="form-control" id="address_edit" name="address_edit" value="{{ old('address_edit') }}">
                                @error('address_edit')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
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
                                <h5 class="card-title mb-0">Danh sách nhà cung cấp</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button class="btn btn-primary mb-3" id="createSupplierBtn">Thêm mới nhà cung cấp</button>
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

                            <table id="supplierDataTable"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width: 100%;" aria-describedby="buttons-datatables_info">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Mã số thuế</th>
                                        <th>Tên nhà cung cấp</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Địa chỉ</th>
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(document).ready(function() {
                // edit validation
                @if ($errors->has('tax_code_edit'))
                    $('#editSupplierModal').modal('show');
                @elseif ($errors->has('name_edit'))
                    $('#editSupplierModal').modal('show');
                @elseif ($errors->has('email_edit'))
                    $('#editSupplierModal').modal('show');
                @elseif ($errors->has('phone_edit'))
                    $('#editSupplierModal').modal('show');
                @elseif ($errors->has('address_edit'))
                    $('#editSupplierModal').modal('show');
                @endif
                //create validation
                @if ($errors->has('tax_code'))
                    $('#createSupplierModal').modal('show');
                @elseif ($errors->has('name'))
                    $('#createSupplierModal').modal('show');
                @elseif ($errors->has('email'))
                    $('#createSupplierModal').modal('show');
                @elseif ($errors->has('phone'))
                    $('#createSupplierModal').modal('show');
                @elseif ($errors->has('address'))
                    $('#createSupplierModal').modal('show');
                @endif

                //show create modal
                $('#createSupplierBtn').on('click', function() {
                    $('#createSupplierModal').modal('show'); // Show the modal
                });

                // show edit modal
                $('#supplierDataTable tbody').on('click', '.btn-warning', function() {
                    var supplierId = $(this).data('id');
                    var taxCode = $(this).data('tax_code');
                    var name = $(this).data('name');
                    var email = $(this).data('email');
                    var phone = $(this).data('phone');
                    var address = $(this).data('address');
                    console.log(supplierId);
                    
                    // Điền dữ liệu vào các trường của modal sửa
                    $('#edit_supplier_id').val(supplierId);
                    $('#tax_code_edit').val(taxCode);
                    $('#name_edit').val(name);
                    $('#email_edit').val(email);
                    $('#phone_edit').val(phone);
                    $('#address_edit').val(address);


                    // Hiện modal sửa
                    $('#editSupplierModal').modal('show');
                });

                $('#editSupplierModal').on('show.bs.modal', function() {
                    var id = $('#edit_supplier_id').val() ?? '';

                    $('#editForm').attr({
                        'action': '{{ route('admin.suppliers.update', ':id') }}'.replace(
                            ':id', id),
                        'method': 'POST'
                    });

                });
                var table = $('#supplierDataTable').DataTable({
                    processing: true,
                    serverSide: true,

                    ajax: {
                        url: '{{ route('admin.suppliers.index') }}',
                        data: function(d) {
                            d.startDate = $('#start-date').val();
                            d.endDate = $('#end-date').val();
                        }
                    },
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: 'tax_code'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'address'
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
                                    return idx !== 8; // Ví dụ: Nếu cột `action` là cột số 8
                                }
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'Xuất CSV',
                            exportOptions: {
                                columns: function(idx, data, node) {
                                    // Loại bỏ cột `action` khi xuất
                                    return idx !== 8; // Ví dụ: Nếu cột `action` là cột số 8
                                }
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'Xuất PDF',
                            exportOptions: {
                                columns: function(idx, data, node) {
                                    // Loại bỏ cột `action` khi xuất
                                    return idx !== 8; // Ví dụ: Nếu cột `action` là cột số 8
                                }
                            }
                        },
                        {
                            extend: 'print',
                            text: 'In',
                            exportOptions: {
                                columns: function(idx, data, node) {
                                    // Loại bỏ cột `action` khi xuất
                                    return idx !== 8; // Ví dụ: Nếu cột `action` là cột số 8
                                }
                            }
                        }
                    ]

                });

                $('#filter-btn').click(function() {
                    table.draw();
                });
            });
        });
    </script>
@endsection
