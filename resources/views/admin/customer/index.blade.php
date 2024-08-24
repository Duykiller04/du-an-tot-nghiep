@extends('admin.layouts.master')

@section('title')
Danh sách khách hàng
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Danh sách khách hàng</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Danh sách Khách hàng</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Danh sách
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title mb-0">Danh sách</h5>

                <a href="{{route('admin.customers.create')}}" class="btn btn-primary mb-3">Thêm mới</a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="buttons-datatables_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                        <!-- Gắn ID "buttons-datatables_wrapper-->

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

                        <!-- Lọc theo ngày -->
                        <table id="example" class="display table table-bordered dataTable no-footer" style="width: 100%;" aria-describedby="buttons-datatables_info">
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
                                    <th>Thao tác</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($listCustomer as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name}}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td>{{ $item->address}}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->age }}</td>
                                    <td>{{ $item->weight}}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{route('admin.customers.edit',$item)}}" class="btn btn-info mb-3">Edit</a>
                                            <form action="{{ route('admin.customers.destroy', $item) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Chắc chắn không?')" type="submit"
                                                    class="btn btn-danger mb-3">DELETE
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end row-->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear());
                </script>2024
                © Velzon.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design &amp; Develop by Themesbrand
                </div>
            </div>
        </div>
    </div>
</footer>
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
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'copy',
                    exportOptions: {
                        columns: function(idx, data, node) {
                            // Loại bỏ cột Action (cột 10)
                            return idx !== 9;
                        }
                    }
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: function(idx, data, node) {
                            // Loại bỏ cột Action (cột 10)
                            return idx !== 9;
                        }
                    }
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: function(idx, data, node) {
                            // Loại bỏ cột Action (cột 10)
                            return idx !== 9;
                        }
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: function(idx, data, node) {
                            // Loại bỏ cột Action (cột 10)
                            return idx !== 9;
                        }
                    }
                },
                'print'
            ],
            order: [
                [0, 'desc']
            ]
        });

        // Tạo filter cho ngày
        $('#minDate, #maxDate').on('change', function() {
            var minDate = $('#minDate').val();
            var maxDate = $('#maxDate').val();

            table.columns(7).search(minDate ? '^' + minDate : '', true, false).draw();
            table.columns(8).search(maxDate ? '^' + maxDate : '', true, false).draw();
        });
    });
</script>

<!-- JS CỦA LOC VS XUẤT excel VÀ CÁC FILE -->

@endsection