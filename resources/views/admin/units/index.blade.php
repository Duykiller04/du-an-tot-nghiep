@extends('admin.layouts.master')
@section('title')
    Danh sách thể đơn vị tính
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Datatables</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Tables</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Datatables
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
                        Danh sách
                    </h5>
                    <a href="{{ route('admin.units.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
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
                    <table id="unitDataTable" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Thời gian tạo</th>
                                <th>Thời gian cập nhật</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
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
            var table = $('#unitDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.units.index') }}',
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
                buttons: [{
                        extend: 'excel',
                        text: 'Export Excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 4; // Ví dụ: Nếu cột `action` là cột số 4
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'Export CSV',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 4; // Ví dụ: Nếu cột `action` là cột số 4
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'Export PDF',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 4; // Ví dụ: Nếu cột `action` là cột số 4
                            }
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                // Loại bỏ cột `action` khi xuất
                                return idx !== 4; // Ví dụ: Nếu cột `action` là cột số 4
                            }
                        }
                    }
                ]
            });

            $('#filter-btn').click(function() {
                table.draw();
            });
        });
    </script>
@endsection
