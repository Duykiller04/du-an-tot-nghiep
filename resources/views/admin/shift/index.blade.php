@extends('admin.layouts.master')

@section('title')
    Danh sách ca làm việc
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Ca Làm Việc</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý ca</a></li>
                            <li class="breadcrumb-item active">Danh sách ca làm việc</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        @if(session('success'))
        <div class="alert alert-success">
                {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="shiftList">
                    <div class="card-header border-0">
                        <div class="row align-items-center gy-3">
                            <div class="col-sm">
                                <h5 class="card-title mb-0">Lịch Sử Ca Làm Việc</h5>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <a href="{{ route('admin.shifts.create') }}" class="btn btn-success add-btn"
                                        id="create-btn"><i class="ri-add-line align-bottom me-1"></i> Tạo ca làm việc mới</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border border-dashed border-end-0 border-start-0">
                        <form method="GET" action="{{ route('admin.shifts.index') }}">
                            <div class="row g-3">
                                <div class="col-xxl-3 col-sm-6">
                                    <div>
                                        <input type="text" class="form-control" name="date" data-provider="flatpickr"
                                            data-date-format="d-m-Y" data-range-date="true" id="demo-datepicker"
                                            placeholder="Chọn Ngày">
                                    </div>
                                </div>
                                <!--end col-->
                                {{-- <div class="col-xxl-4 col-sm-4">
                                    <div >
                                        <select class="form-select" name="status" id="status">
                                            
                                            <option value="all" selected>Chọn Trạng Thái Ca Làm</option>
                                            <option value="kế hoạch">Kế Hoạch</option>
                                            <option value="đang mở">Đang Mở</option>
                                            <option value="tạm dừng">Tạm Dừng</option>
                                            <option value="đã chốt">Đã Chốt</option>
                                            <option value="đã hủy">Đã Hủy</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-xxl-4 col-sm-4">
                                    <div>
                                        <select class="form-control" name="status" id="storage">
                                            <option value="all" selected>Chọn Trạng Thái Ca Làm</option>
                                            <option value="kế hoạch">Kế Hoạch</option>
                                            <option value="đang mở">Đang Mở</option>
                                            <option value="đã chốt">Đã Chốt</option>
                                            <option value="đã hủy">Đã Hủy</option>
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
                                    <table id="shiftTable"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Tên ca</th>
                                                <th>Bắt đầu</th>
                                                <th>Kết thúc</th>
                                                <th>Nhân viên</th>
                                                <th>Trạng thái</th>
                                                <th>Tổng thu</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shifts as $shift)
                                                <tr>
                                                    <td>#{{ $shift->id }}</td>
                                                    <td>{{ $shift->shift_name }}</td>
                                                    <td>{{ $shift->start_time }}</td>
                                                    <td>{{ $shift->end_time }}</td>
                                                    <td>
                                                        @foreach ($shift->users as $user)
                                                            {{ $user->name }}<br> <!-- Hiển thị tên nhân viên -->
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <span class="badge {{ $getStatusClass($shift->status) }}">
                                                            {{ ucfirst($shift->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $shift->revenue_summary ?? 'N/A' }}</td>
                                                    <td>
                                                        <ul class="list-unstyled d-flex gap-2">
                                                            <li><a href="{{ route('admin.shifts.edit', $shift->id) }}"
                                                                    class="btn btn-info">
                                                                    Xem & Điều chỉnh ca</a></li>
                                                            <li>
                                                                <form action="{{ route('admin.shifts.destroy', $shift->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa ca làm việc này?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Xóa</button>
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
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script>
        $(document).ready(function() {
            $('#shiftTable').DataTable({
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
            });
        });
    </script>
@endsection
