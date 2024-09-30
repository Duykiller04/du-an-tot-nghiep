@extends('admin.layouts.master')

@section('title')
    Danh sách ca làm
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"> Danh sách ca làm</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Danh sách ca làm</a></li>
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

                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">Danh sách ca làm</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.workshifts.create') }}" type="button"
                                        class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> Thêm
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
                        <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên ca làm</th>
                                    <th>Tên nhân viên</th>
                                    <th>KPI</th>
                                    <td>Trạng thái KPI</td>
                                    <td>Thời gian bắt đầu ca làm</td>
                                    <th>Thời gian kết thúc ca làm</th>  
                                    <th>Ngày tạo</th>
                                    <th>Ngày sửa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($workshifts as $item)
                                    <tr>
                                        <td>
                                            {{ $item->id }}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->user->name }}
                                        </td>
                                        <td>
                                            {{ $item->target }}
                                        </td>
                                        <td>
                                            {{ $item->is_applied ? 'Có' : 'Không' }}
                                        </td>
                                        <td>
                                            {{ $item->start_time }}
                                        </td>
                                        <td>
                                            {{ $item->end_time }}
                                        </td>
                                        <td>
                                            {{ $item->created_at }}
                                        </td>
                                        <td>
                                            {{ $item->updated_at }}
                                        </td>
                                        
                                        <td class="d-flex">
                                            <a class="btn btn-info"
                                                href="{{ route('admin.workshifts.show', $item->id) }}">Xem</a>
                                            <a class="btn btn-warning ms-2"
                                                href="{{ route('admin.workshifts.edit', $item->id) }}">Sửa</a>
                                            <form action="{{ route('admin.workshifts.destroy', $item->id) }}" method="POST"
                                                class="ms-2">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger "
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa không')"
                                                    type="submit">Xóa</button>
                                            </form>
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
        <!--end row-->

    </div>
    <!-- container-fluid -->
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
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
                    var createdAt = data[8] || ''; // Cột thời gian tạo
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

            $('#minDate, #maxDate').change(function() {
                table.draw();
            });
        });
    </script>
@endsection