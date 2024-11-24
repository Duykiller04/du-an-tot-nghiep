<!-- index.blade.php -->

@extends('admin.layouts.master')

@section('title')
    Danh sách danh mục
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row mt-3">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh mục sản phẩm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh mục sản phẩm</a></li>
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

        <!-- Create Category Modal -->
        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCategoryModalLabel">Thêm mới danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('admin.catalogues.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="project-title-input">Tên danh mục <span class="text-danger">(*)</span></label>
                                <input type="text" name="nameCreate" class="form-control" id="project-title-input"
                                    placeholder="Nhập tên danh mục" value="{{ old('name') }}">
                                @error('nameCreate')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Danh mục cha</label>
                                <select name="parent_idCreate" class="form-select">
                                    <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>Không</option>
                                    @foreach ($catalogues as $item)
                                        @php($indent = '')
                                        @include('admin.catalogue.catalogue_nested', ['catalog' => $item])
                                    @endforeach
                                </select>
                                @error('parent_idCreate')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Trạng thái <span class="text-danger">(*)</span></label>
                                <select name="is_activeCreate" class="form-select" data-choices data-choices-search-false
                                    id="">
                                    <option value="1" selected>Hoạt động</option>
                                    <option value="0">Bản nháp</option>
                                </select>
                                @error('is_activeCreate')
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

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
            aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Sửa danh mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_category_id" name="category_id">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="edit_name">Tên danh mục <span class="text-danger">(*)</span></label>
                                <input type="text" name="nameEdit" class="form-control" id="edit_name"
                                    placeholder="Nhập tên danh mục">
                                @error('nameEdit')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Danh mục cha</label>
                                <select name="parent_idEdit" class="form-select">
                                    <option value="0" {{ old('parent_id') == 0 ? 'selected' : '' }}>Không</option>
                                    @foreach ($catalogues as $item)
                                        @php($indent = '')
                                        @include('admin.catalogue.catalogue_nested', ['catalog' => $item])
                                    @endforeach
                                </select>
                                @error('parent_idEdit')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="edit_choices_status_input" class="form-label">Trạng thái <span class="text-danger">(*)</span></label>
                                <select name="is_activeEdit" class="form-select" data-choices data-choices-search-false
                                    id="edit_choices_status_input">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Bản nháp</option>
                                </select>
                                @error('is_activeEdit')
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
                <div class="card" id="customerList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách danh mục</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                            class="ri-delete-bin-2-line"></i></button>
                                    <button class="btn btn-primary mb-3" id="createCategoryBtn">Thêm mới danh mục</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Lọc
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Lọc</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-4">
                                                        <label for="start-date">Ngày tạo từ:</label>
                                                        <input type="date" id="start-date" class="form-control">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="end-date">Ngày tạo đến:</label>
                                                        <input type="date" id="end-date" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Đóng</button>
                                                    <button type="button" class="btn btn-primary"
                                                        id="filter-btn" data-bs-dismiss="modal">Lọc</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <table id="example"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th> <!-- Cột để click mở rộng -->
                                                <th>STT</th>
                                                <th>Tên danh mục</th>
                                                <th>Ngày tạo</th>
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
                $('#editCategoryModal').modal('show');
            @endif
            @if ($errors->has('nameCreate'))
                $('#createCategoryModal').modal('show');
            @endif
            $('#createCategoryBtn').on('click', function() {
                $('#createCategoryModal').modal('show'); // Show the modal
            });
            $('#example tbody').on('click', '.btn-warning', function() {
                var row = $(this).closest('tr');
                var data = $('#example').DataTable().row(row).data();

                // Điền dữ liệu vào các trường của modal sửa
                $('#edit_category_id').val(data.id);
                $('#edit_name').val(data.name);
                $('select#edit_choices_status_input').val(data.is_active); // Đảm bảo đúng ID của modal sửa
                $('select[name="parent_idEdit"]').val(data.parent_id !== null ? data.parent_id : '0');

                // Hiện modal sửa
                $('#editCategoryModal').modal('show');
            });

            $('#editCategoryModal').on('show.bs.modal', function() {
                var id = $('#edit_category_id').val() ?? '';

                $('#editForm').attr({
                    'action': '{{ route('admin.catalogues.update', ':id') }}'.replace(':id', id),
                    'method': 'POST'
                });

            });

            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax:{
                    url: '{{ route('admin.catalogues.index') }}',
                    data: function(d) {
                        d.startDate = $('#start-date').val();
                        d.endDate = $('#end-date').val();
                    }
                }, 
                columns: [{
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: '<i class="bx bx-sort-down"></i>',
                        width: '20px'
                    },
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
                order: [
                    [1, 'desc']
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

            $('#filter-btn').click(function() {
                    table.draw();
                });

            $('#example tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    var rowData = row.data();
                    var categoryId = rowData.id;

                    $.ajax({
                        url: '{{ route('admin.catalogues.getChildren') }}',
                        method: 'GET',
                        data: {
                            id: categoryId
                        },
                        success: function(children) {
                            // Nếu children là chuỗi JSON, hãy phân tích nó
                            if (typeof children === 'string') {
                                children = JSON.parse(children);
                            }

                            if (children.length > 0) {
                                var html =
                                    '<table class="table"><tr><th>ID</th><th>Tên danh mục con</th><th>Thời gian tạo</th><th>Thời gian cập nhật</th><th>Thao tác</th></tr>';
                                children.forEach(function(child) {
                                    html += '<tr><td>' + child.id + '</td><td>' + child
                                        .name + '</td><td>' + child.created_at +
                                        '</td><td>' + child.updated_at + '</td>';
                                    html += '<td><a href="' + child.edit_url +
                                        '" class="btn btn-sm btn-warning">Sửa</a></td></tr>';
                                });
                                html += '</table>';
                                row.child(html).show();
                                tr.addClass('shown');
                            } else {
                                row.child('<div>Không có danh mục con</div>').show();
                                tr.addClass('shown');
                            }
                        },
                        error: function() {
                            row.child('<div>Lỗi khi tải danh mục con.</div>').show();
                            tr.addClass('shown');
                        }
                    });

                }
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

