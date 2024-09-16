@extends('admin.layouts.master')

@section('title')
Danh sách dụng cụ
@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách dụng cụ</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách dụng cụ</a></li>
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
                                <h5 class="card-title mb-0">Danh sách dụng cụ</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a href="{{ route('admin.medicalInstruments.create') }}" type="button"
                                    class="btn btn-success add-btn">
                                    <i class="ri-add-line align-bottom me-1"></i> Thêm mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

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
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Danh mục</th>
                                <th>Nhà cung cấp</th>
                                <th>Tên dụng cụ</th>
                                <th>Ảnh</th>
                                <th>Giá nhập</th>
                                <th>Giá bán</th>
                                <th>Số lượng</th>
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
            var table = $('#example').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.medicalInstruments.index') }}',
                    data: function(d) {
                        d.startDate = $('#minDate').val();
                        d.endDate = $('#maxDate').val();
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'category.name', name: 'category.name' },
                    { data: 'suppliers', render: function (data, type, row) {
                        return data.map(supplier => `<p>${supplier.name}</p>`).join('');
                    }},
                    { data: 'name' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'price_import' },
                    { data: 'price_sale' },
                    { data: 'inventory.quantity', name: 'inventory.quantity' },
                    { data: 'created_at' },
                    { data: 'updated_at' },
                    { data: 'action', orderable: false, searchable: false }
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 10; // Ẩn cột "Action"
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 10; // Ẩn cột "Action"
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 10; // Ẩn cột "Action"
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                return idx !== 10; // Ẩn cột "Action"
                            }
                        }
                    },
                    'print'
                ]
            });

            $('#minDate, #maxDate').on('change', function() {
                table.draw();
            });
        });
    </script>

@endsection
