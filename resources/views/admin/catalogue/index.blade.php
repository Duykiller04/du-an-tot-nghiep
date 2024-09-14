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
                                    <a href="{{ route('admin.catalogues.create') }}" class="btn btn-success add-btn"
                                        id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Thêm danh mục</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="mb-4 me-3">
                                            <label for="minDate">Ngày tạo từ:</label>
                                            <input type="date" id="minDate" class="form-control">
                                        </div>
                                        <div class="mb-4 ms-3">
                                            <label for="maxDate">Ngày tạo đến:</label>
                                            <input type="date" id="maxDate" class="form-control">
                                        </div>
                                    </div>
                                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th> <!-- Cột để click mở rộng -->
                                                <th>ID</th>
                                                <th>Tên danh mục</th>
                                                <th>Thời gian tạo</th>
                                                <th>Thời gian cập nhật</th>
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
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.catalogues.index') }}',  // Đảm bảo rằng route này trả về cả dữ liệu children
            columns: [
                {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: '<i class="bx bx-sort-down"></i>',
                    width: '20px'
                },
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'updated_at', name: 'updated_at' },
                { data: 'action', orderable: false, searchable: false }
            ],
            order: [[1, 'desc']],
        });

        $('#example tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // Nếu đang mở, đóng lại
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Nếu đang đóng, mở rộng để hiển thị các danh mục con
                var rowData = row.data();
                var children = rowData.children;

                // Phân tích chuỗi JSON thành đối tượng JavaScript nếu cần
                if (typeof children === 'string') {
                    try {
                        children = JSON.parse(children);
                    } catch (e) {
                        console.error('Error parsing children JSON:', e);
                        children = [];
                    }
                }

                // Kiểm tra xem children có phải là mảng không
                if (Array.isArray(children)) {
                    if (children.length > 0) {
                        var html = '<table class="table"><tr><th></th><th>ID</th><th>Tên danh mục con</th><th>Thời gian tạo</th><th>Thời gian cập nhật</th><th>Thao tác</th></tr>';
                        children.forEach(function(child) {
                            html += '<tr><td></td><td>' + child.id + '</td><td>' + child.name + '</td><td>' + child.created_at + '</td><td>' + child.updated_at + '</td>';
                            html += '<td><a href="' + child.edit_url + '" class="btn btn-sm btn-warning">Sửa</a>';
                            html += '<form action="' + child.delete_url + '" method="post" style="display:inline;" class="ms-2">' +
                                '<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">' +
                                '<input type="hidden" name="_method" value="DELETE">' +
                                '<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')">Xóa</button>' +
                                '</form></td></tr>';
                        });
                        html += '</table>';
                        row.child(html).show();
                        tr.addClass('shown');
                    } else {
                        // Nếu danh mục con là mảng nhưng không có phần tử
                        row.child('<div>Không có danh mục con</div>').show();
                        tr.addClass('shown');
                    }
                } else {
                    // Nếu children không phải là mảng
                    row.child('<div>Không có danh mục con</div>').show();
                    tr.addClass('shown');
                }
            }
        });
    });

</script>

@endsection
