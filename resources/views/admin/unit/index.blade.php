@extends('admin.layouts.master')

@section('title')
    Danh sách đơn vị
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách đơn vị</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn vị</a></li>
                            <li class="breadcrumb-item active">Danh sách</li>
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
        <!-- Create unut Modal -->
        <div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryModalLabel">Thêm mới đơn vị</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.units.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="project-title-input">Tên đơn vị (<span
                                    class="text-danger">*</span>)</label>
                                <input type="text" name="nameCreate" class="form-control" id="project-title-input"
                                    placeholder="Nhập tên đơn vị" value="{{ old('name') }}">
                                @error('nameCreate')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Đơn vị cha</label>
                                <select name="parent_idCreate" class="form-select">
                                    <option value="" {{ old('parent_id') == 0 ? 'selected' : '' }}>Không</option>
                                    @foreach ($units as $item)
                                        @php($indent = '')
                                        @include('admin.unit.unit_nested', ['unit' => $item])
                                    @endforeach
                                </select>
                                @error('parent_idCreate')
                                    <div class="text-danger mt-2">{{ $message }}</div>
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
        <!-- Edit unit Modal -->
        <div class="modal fade" id="editUnitModal" tabindex="-1" aria-labelledby="editUnitModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Sửa đơn vị</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_unit_id" name="unit_id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="edit_name">Tên đơn vị (<span
                                    class="text-danger">*</span>)</label>
                                <input type="text" name="nameEdit" class="form-control" id="edit_name"
                                    placeholder="Nhập tên đơn vị">
                                @error('nameEdit')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Đơn vị cha</label>
                                <select name="parent_idEdit" class="form-select" id="">
                                    <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>Không</option>
                                    @foreach ($units as $item)
                                        @php($indent = '')
                                        @include('admin.unit.unit_nested', ['unit' => $item])
                                    @endforeach
                                </select>
                                @error('parent_idEdit')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="unitList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách đơn vị</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                    <button class="btn btn-primary mb-3" id="createUnitBtn">Thêm đơn vị</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="example"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tên đơn vị</th>
                                                <th>Thời gian tạo</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
            @if ($errors->has('nameEdit'))
                $('#editUnitModal').modal('show');
            @endif
            @if ($errors->has('nameCreate'))
                $('#createUnitModal').modal('show');
            @endif
            $('#createUnitBtn').on('click', function() {
                $('#createUnitModal').modal('show'); // Show the modal
            });
          
            $('#example tbody').on('click', '.btn-warning', function() {
                var row = $(this).closest('tr');
                var data = $('#example').DataTable().row(row).data();
                console.log(data);
                
                // Điền dữ liệu vào các trường của modal sửa
                $('#edit_unit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('select[name="parent_idEdit"]').val(data.parent_id !== null ? data.parent_id : '0');

                // Hiện modal sửa
                $('#editUnitModal').modal('show');
            });

            $('#editUnitModal').on('show.bs.modal', function() {
                var id = $('#edit_unit_id').val() ?? '';

                $('#editForm').attr({
                    'action': '{{ route('admin.units.update', ':id') }}'.replace(':id', id),
                    'method': 'POST'
                });

            });
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                columns: [
                    
                    {
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
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
                },
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        text: 'Sao chép',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 4; // Ẩn cột "Thao tác"
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Xuất CSV',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 4; // Ẩn cột "Thao tác"
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Xuất Excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 4; // Ẩn cột "Thao tác"
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Xuất PDF',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 4; // Ẩn cột "Thao tác"
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'In',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 4; // Ẩn cột "Thao tác"
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
