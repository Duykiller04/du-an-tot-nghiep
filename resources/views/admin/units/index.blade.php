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
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Thời gian tạo</th>
                                <th>Thời gian cập nhật</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.units.show', $item) }}"
                                                class="btn btn-info mb-3">Xem</a>
                                            <a href="{{ route('admin.units.edit', $item) }}"
                                                class="btn btn-warning mb-3 ms-3 me-3">Sửa</a>
                                            <form action="{{ route('admin.units.destroy', $item) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Chắc chắn không?')" type="submit"
                                                    class="btn btn-danger">Xóa</button>
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
        <!--end col-->
    </div>
@endsection

@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" />
@endsection

@section('js')
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
        // new DataTable("#example", {
        //     order: [
        //         [0, 'desc']
        //     ]
        // });

        $(document).ready(function() {
            var table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Loại bỏ cột cuối cùng
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Loại bỏ cột cuối cùng
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Loại bỏ cột cuối cùng
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible:not(:last-child)' // Loại bỏ cột cuối cùng
                        }
                    },
                    'print'
                ],
                order: [
                    [0, 'desc']
                ]
            });

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var minDate = $('#minDate').val();
                    var maxDate = $('#maxDate').val();

                    // Convert to Date objects for comparison
                    var minDateObj = minDate ? new Date(minDate + 'T00:00:00') : null;
                    var maxDateObj = maxDate ? new Date(maxDate + 'T23:59:59') : null;

                    // Giả sử cột thời gian tạo là cột số 7 (chỉ số 7)
                    var createdAt = data[2] || ''; // Cột thời gian tạo
                    var createdAtDate = new Date(createdAt);

                    // So sánh ngày
                    if (
                        (minDateObj === null && maxDateObj === null) ||
                        (minDateObj === null && createdAtDate <= maxDateObj) ||
                        (minDateObj <= createdAtDate && maxDateObj === null) ||
                        (minDateObj <= createdAtDate && createdAtDate <= maxDateObj)
                    ) {
                        return true;
                    }
                    return false;
                }
            );

            $('#minDate, #maxDate').on('change', function() {
                table.draw();
            });

            // Tạo filter tìm kiếm văn bản
            $('#searchText').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
@endsection
