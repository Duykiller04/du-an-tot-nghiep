@extends('admin.layouts.master')

@section('title')
    Danh sách kho
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách kho</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Danh sách kho</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Danh sách
                            </li>
                        </ol>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Danh sách kho</h5>
                        <!-- Button to trigger modal -->
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createStorageModal">Thêm mới kho</button>
                    </div>

                    <!-- Modal thêm mới kho -->
                    <div class="modal fade" id="createStorageModal" tabindex="-1" aria-labelledby="createStorageLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createStorageLabel">Thêm mới kho</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.storage.store') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <!-- Tên kho -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Tên kho <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}">
                                            <div class="invalid-feedback">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Địa chỉ -->
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Địa chỉ <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="location" id="location"
                                                class="form-control @error('location') is-invalid @enderror"
                                                value="{{ old('location') }}">
                                            <div class="invalid-feedback">
                                                @error('location')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Modal footer with Save and Close buttons -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal sửa kho -->
                    <div class="modal fade" id="editStorageModal" tabindex="-1" aria-labelledby="editStorageModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editStorageModalLabel">Chỉnh sửa kho</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form id="editStorageForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="edit_storage_id" name="id">
                                    <!-- Hidden input để lưu trữ ID kho -->


                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="edit-name" class="form-label">Tên kho</label>
                                            <input type="text" name="name" id="edit-name" class="form-control">
                                            @error('name')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-location" class="form-label">Địa chỉ</label>
                                            <input type="text" name="location" id="edit-location" class="form-control">
                                            @error('location')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    @if ($errors->any())
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                var myModal = new bootstrap.Modal(document.getElementById('createStorageModal'));
                                myModal.show();
                            });
                        </script>
                    @endif

                    <div class="card-body">
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
                            <table id="storageDataTable"
                                class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên kho</th>
                                        <th>Địa chỉ</th>
                                        <th>Thời gian tạo</th>
                                        <th>Tổng thuốc</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dữ liệu kho sẽ được load tại đây -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
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
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
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
            // Khởi tạo DataTable
            var table = $('#storageDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.storage.index') }}',
                    data: function(d) {
                        d.startDate = $('#start-date').val(); // Lấy giá trị từ trường ngày bắt đầu
                        d.endDate = $('#end-date').val(); // Lấy giá trị từ trường ngày kết thúc
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'location'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'medicines_count'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                dom: 'Bfrtip', // Hiển thị nút xuất
                buttons: [{
                        extend: 'excel',
                        text: 'Xuất Excel',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Không xuất cột cuối
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Xuất CSV',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Không xuất cột cuối
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Xuất PDF',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Không xuất cột cuối
                        }
                    },
                    {
                        extend: 'print',
                        text: 'In',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Không xuất cột cuối
                        }
                    }
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
                }
            });

            // Xử lý sự kiện khi nút lọc được nhấn
            $('#filter-btn').click(function() {
                table.draw();
            });

            // Hiện modal nếu có lỗi
            @if ($errors->has('nameEdit'))
                $('#editStorageModal').modal('show');
            @endif
            @if ($errors->has('nameCreate'))
                $('#createStorageModal').modal('show');
            @endif

            // Hiện modal tạo mới
            $('#createStorageBtn').on('click', function() {
                $('#createStorageModal').modal('show');
            });

            // Xử lý sự kiện khi nhấn nút sửa
            $('#storageDataTable tbody').on('click', '.btn-warning', function() {
                var row = $(this).closest('tr');
                var data = table.row(row).data();

                // Điền dữ liệu vào các trường của modal sửa
                $('#edit_storage_id').val(data.id);
                $('#edit-name').val(data.name);
                $('#edit-location').val(data.location);

                // Cập nhật URL cho form sửa
                $('#editStorageForm').attr('action', '{{ route('admin.storage.update', ':id') }}'.replace(
                    ':id', data.id));

                // Hiện modal sửa
                $('#editStorageModal').modal('show');
            });

            // Cập nhật URL cho form sửa khi modal hiện
            $('#editStorageModal').on('show.bs.modal', function() {
                var id = $('#edit_storage_id').val() ?? '';
                $('#editStorageForm').attr({
                    'action': '{{ route('admin.storage.update', ':id') }}'.replace(':id', id),
                    'method': 'POST'
                });
            });
        });
    </script>
@endsection
