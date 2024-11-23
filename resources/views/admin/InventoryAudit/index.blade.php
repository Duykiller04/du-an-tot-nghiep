<!-- index.blade.php -->

@extends('admin.layouts.master')

@section('title')
    Danh sách kiểm kho
@endsection

@section('title')
    Danh sách Phiếu Kiểm Kho
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Phiếu Kiểm Kho</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kiểm kho</a></li>
                            <li class="breadcrumb-item active">Danh sách Phiếu Kiểm Kho</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="inventoryAuditList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Lịch Sử Phiếu Kiểm Kho</h5>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.inventoryaudit.downloadTemplate') }}" class="btn btn-info w-sm">Tải xuống mẫu</a>
                                    <a href="{{ route('admin.inventoryaudit.create') }}" class="btn btn-success add-btn"
                                        id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Tạo phiếu kiểm kho</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form method="GET" action="{{ route('admin.inventoryaudit.index') }}">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6">
                                    <div>
                                        <input type="date" class="form-control" name="date" id="date-picker"
                                            value="{{ request('date') }}" placeholder="Chọn Ngày">
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-4 col-sm-4">
                                    <div>
                                        <select class="form-control" name="storage_id" id="storage">
                                            <option value="all" selected>Chọn Kho</option>
                                            @foreach ($storages as $storage)
                                                <option value="{{ $storage->id }}">{{ $storage->location }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-2 col-sm-4">
                                    <div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="ri-equalizer-fill me-1 align-bottom"></i>
                                            Lọc
                                        </button>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </form>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table id="inventoryAuditTable"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tiêu đề</th>
                                                <th>Kho</th>
                                                <th>Người kiểm</th>
                                                <th>Ngày kiểm</th>
                                                <th>Ghi chú</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($inventoryAudits as $index=>$audit)
                                                <tr>
                                                    <td>#{{ $index+1 }}</td>
                                                    <td>{{ $audit->title }}</td>
                                                    <td>{{ $audit->storage->location }}</td>
                                                    <td>{{ $audit->checked_by }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($audit->check_date)->format('d-m-Y') }}</td>
                                                    <td>{{ $audit->remarks }}</td>
                                                    <td>
                                                        <ul class="list-unstyled d-flex gap-2">
                                                            <li><a href="{{ route('admin.inventoryaudit.show', $audit->id) }}"
                                                                    class="btn btn-info">
                                                                    Chi tiết</a></li>
                                                            
                                                            <li>
                                                                <form action="{{route('admin.inventoryaudit.destroy',$audit->id)}}" method="POST" style="display:inline;" class="delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger btn-delete" data-id="{{$audit->id}}">Xóa</button>
                                                                </form>
                                                                
                                                            </li>
                                                          
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach

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

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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

    <script src="{{ asset('theme/admin/assets/js/pages/datatables.init.js') }}"></script>

@endsection
@section('js')
    <!-- Các tệp JavaScript khác -->

    <script>
        $(document).ready(function() {
            $('#inventoryAuditTable').DataTable({
                // Các tùy chọn cấu hình cho DataTables
               responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
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
                // Thêm các cấu hình khác nếu cần
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

