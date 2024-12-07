<!-- index.blade.php -->

@extends('admin.layouts.trash')

@section('title')
    Danh sách đơn thuốc thường đã xóa
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">


                <div class="card-body">
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="storages" role="tabpanel">
                            <div class="profile-timeline">
                                <div class="accordion accordion-flush" id="storagesExample">
                                    <!-- start page title -->
                                    <h4>Đơn thuốc thường đã xóa</h4>
                                    <!-- end page title -->
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0">



                                            @if (session('success'))
                                                <div class="alert alert-success mb-3">
                                                    {{ session('success') }}
                                                </div>
                                            @endif

                                            <thead class="table-light">
                                                <form action="{{ route('admin.restore.prescriptions') }}" method="POST">
                                                    @csrf
                                                    <table id="example"
                                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="select-all"></th>
                                                                <th>Mã đơn thuốc thông thường</th>
                                                                <th>Tên khách hàng</th>
                                                                <th>Giới tính</th>
                                                                <th>Tuổi</th>
                                                                <th>Điện thoại</th>
                                                                <th>Loại bán</th>
                                                                <th>Địa chỉ</th>
                                                                <th>Email</th>
                                                                <th>Cân nặng</th>
                                                                <th>Tổng đơn</th>
                                                                <th>Ngày xóa</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($data as $item)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="ids[]"
                                                                            value="{{ $item->id }}">
                                                                    </td>
                                                                    <td>{{ $item->id }}</td>
                                                                    <td>{{ $item->customer_name }}</td>
                                                                    <td>{{ $item->gender }}</td>
                                                                    <td>{{ $item->age }}</td>
                                                                    <td>{{ $item->phone }}</td>
                                                                    <td>{{ $item->type_sell }}</td>
                                                                    <td>{{ $item->address }}</td>
                                                                    <td>{{ $item->email }}</td>
                                                                    <td>{{ $item->weight }}</td>
                                                                    <td>{{ $item->total_price }}</td>
                                                                    <td>{{ $item->deleted_at->format('d-m-Y') }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <button type="submit" class="btn btn-primary">Khôi phục</button>
                                                </form>
                                            </thead>
                                        </table>
                                        <!-- end table -->
                                    </div>
                                </div>
                                <!--end accordion-->
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->

            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
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
    {{-- <script>
    new DataTable("#example", {
        order: [
            [0, 'desc']
        ]
    });
</script> --}}
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[name="ids[]"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }, this);
        });
    </script>
@endsection
