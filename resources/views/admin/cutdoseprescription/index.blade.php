@extends('admin.layouts.master')

@section('title')
    Danh sách đơn thuốc mẫu
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách đơn thuốc mẫu</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Danh sách đơn thuốc mẫu</li>
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
                    <h5 class="card-title mb-0">Danh sách</h5>

                    <a href="{{ route('admin.cutDosePrescriptions.create') }}" class="btn btn-primary mb-3">Thêm mới</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">

                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Bệnh</th>
                                <th>Tên bệnh viện</th>
                                <th>Tên bác sĩ</th>
                                <th>Tuổi</th>
                                <th>Số điện thoại</th>
                                <th>Tổng tiền</th>
                                <th>Ngày thêm</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $stt = 1;
                            @endphp
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ $item->disease->disease_name }}</td>
                                    <td>{{ $item->name_hospital }}</td>
                                    <td>{{ $item->name_doctor }}</td>
                                    <td>{{ $item->age }}</td>
                                    <td>{{ $item->phone_doctor }}</td>
                                    <td>{{ number_format($item->total) }} VNĐ</td>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.cutDosePrescriptions.show', $item) }}"
                                                class="btn btn-warning mb-3">Xem</a>
                                            <a href="{{ route('admin.cutDosePrescriptions.edit', $item) }}"
                                                class="btn btn-info mb-3">Sửa</a>
                                            <form action="{{ route('admin.cutDosePrescriptions.destroy', $item) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Chắc chắn không?')" type="submit"
                                                    class="btn btn-danger mb-3 btn-delete">Xóa
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
        </div><!--end col-->
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

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
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
        });
    </script>
@endsection
