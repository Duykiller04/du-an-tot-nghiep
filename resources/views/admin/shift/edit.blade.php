@extends('admin.layouts.master')

@section('title')
    Chi tiết ca làm
@endsection

@section('content')
    <div class="container-fluid">
        <!-- Start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Chi tiết ca làm</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.shifts.index') }}">Ca làm</a></li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>
            </div>
        </div>
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
        <!-- End page title -->
        <div class="row mb-4">
            <div class="col-lg-6 d-flex justify-content-between">
                @if ($shift->status == 'kế hoạch')
                    <div>
                        <form action="{{ route('admin.shifts.updateStatus', ['shift' => $shift->id, 'status' => 'đang mở']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-primary">Xác nhận mở ca</button>
                        </form>
                        <form action="{{ route('admin.shifts.updateStatus', ['shift' => $shift->id, 'status' => 'đã hủy']) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger">Hủy ca</button>
                        </form>
                    </div>
                @elseif ($shift->status == 'đang mở')
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#closeShiftModal">Đóng ca</button>
                @elseif ($shift->status == 'đã hủy')
                    <form action="{{ route('admin.shifts.updateStatus', ['shift' => $shift->id, 'status' => 'kế hoạch']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-info">Trở về kế hoạch</button>
                    </form>
                @endif
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
                <ul class="nav nav-pills bg-gray custom-status-nav">
                    <li class="nav-item">
                        <span class="nav-link {{ $shift->status == 'kế hoạch' ? 'active' : '' }}">
                            Kế hoạch
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link {{ $shift->status == 'đang mở' ? 'active' : '' }}">
                            Đang mở
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link {{ $shift->status == 'đã chốt' ? 'active' : '' }}">
                            Đã chốt
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link {{ $shift->status == 'đã hủy' ? 'active' : '' }}">
                            Đã hủy
                        </span>
                    </li>
                </ul>
                
            </div>

        </div>
       

       

        <!-- Modal xác nhận đóng ca -->
        <div class="modal fade" id="closeShiftModal" tabindex="-1" aria-labelledby="closeShiftModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận đóng ca</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc chắn muốn đóng ca này?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <form action="{{ route('admin.shifts.updateStatus', ['shift' => $shift->id, 'status' => 'đã chốt']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Đóng ca</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let shiftId = {{ $shift->id }};
        </script>
        @vite('resources/js/updateRevenue.js')
        <!-- Form chỉnh sửa ca làm -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-3">
                    <div class=" text-center mt-4 mb-4">
                        <h2 class="mb-4">Tổng doanh thu ca</h2>
                        <div class="d-flex justify-content-center align-items-center gap-4">
                            <div class="d-flex align-items-center">
                                <span id="total-revenue" class="text-success" style="font-size: 24px; font-weight: bold;">{{ number_format($shift->revenue_summary) }} VND</span>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.shifts.update', $shift->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="shift_name">Tên ca làm<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('shift_name') is-invalid @enderror" id="shift_name" name="shift_name" value="{{ old('shift_name', $shift->shift_name) }}">
                                @error('shift_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Chọn thời gian bắt đầu và kết thúc trên cùng một dòng -->
                            <div class="row">
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="start_time">Giờ bắt đầu<span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror" id="start_time" name="start_time" value="{{ old('start_time', date('Y-m-d\TH:i', strtotime($shift->start_time))) }}">
                                    @error('start_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-6 mb-3">
                                    <label class="form-label" for="end_time">Giờ kết thúc<span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror" id="end_time" name="end_time" value="{{ old('end_time', date('Y-m-d\TH:i', strtotime($shift->end_time))) }}">
                                    @error('end_time')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div id="details-container">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="select-all">
                                    <label class="form-check-label" for="select-all">Chọn tất cả</label>
                                </div>
                                @foreach ($users as $user)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="details[][user_id]" id="user_{{ $user->id }}" value="{{ $user->id }}" {{ in_array($user->id, $checkedUsers) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user_{{ $user->id }}">{{ $user->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            {{-- <div>
                                <button id="btn-add-detail" type="button" class="btn btn-primary">Thêm nhân viên +</button>
                            </div> --}}

                            <div class="text-end mb-4">
                                <a href="{{ route('admin.shifts.index') }}" class="btn btn-warning w-sm">Quay lại</a>
                                <button type="submit" class="btn btn-success w-sm">Lưu</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Danh sách hóa đơn của ca làm -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-3">
                <h5>Danh sách hóa đơn</h5>
                @if($orders->isEmpty() && $prescriptions->isEmpty())
                    <div class="alert alert-warning">Không có hóa đơn nào trong ca làm này.</div>
                @else
                    <ul class="nav nav-tabs" id="orderTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="normal-orders-tab" data-bs-toggle="tab" href="#normal-orders" role="tab" aria-controls="normal-orders" aria-selected="true">Đơn thuốc thông thường</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="special-orders-tab" data-bs-toggle="tab" href="#special-orders" role="tab" aria-controls="special-orders" aria-selected="false">Đơn thuốc cắt liều</a>
                        </li>
                    </ul>
                    <div class="tab-content mt-3" id="orderTabContent">
                        <!-- Tab Đơn thuốc thông thường -->
                        <div class="tab-pane fade show active" id="normal-orders" role="tabpanel" aria-labelledby="normal-orders-tab">
                            <div class="card p-3 bg-light">
                                <table class="table table-hover table-bordered border-dark">
                                    <thead class="table-striped">
                                        <tr>
                                            <th>Mã hóa đơn</th>
                                            <th>Ngày tạo</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ number_format($order->total_price) }} VND</td>
                                                <td>{{ ucfirst($order->status) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Tab Đơn thuốc cắt liều -->
                        <div class="tab-pane fade" id="special-orders" role="tabpanel" aria-labelledby="special-orders-tab">
                            <div class="card p-3 bg-light">
                                <table class="table table-hover table-bordered">
                                    <thead class="table">
                                        <tr>
                                            <th>Mã hóa đơn</th>
                                            <th>Ngày tạo</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prescriptions as $prescription)
                                            <tr>
                                                <td>{{ $prescription->id }}</td>
                                                <td>{{ $prescription->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ number_format($prescription->total) }} VND</td>
                                                <td>{{ ucfirst($prescription->status) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                @endif
            </div>
            </div>
        </div>

        
    </div>
    @section('js')
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#select-all)');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
        
    // Function to update the order list and total revenue
    // function updateOrdersAndRevenue() {
    //     $.ajax({
    //         url: '{{ route('admin.shifts.getOrders', $shift->id) }}', // Route to get updated orders
    //         method: 'GET',
    //         success: function(response) {
    //             // Update orders table
    //             $('#normal-orders tbody').empty();
    //             $('#special-orders tbody').empty();

    //             // Normal Orders
    //             response.orders.forEach(order => {
    //                 $('#normal-orders tbody').append(`
    //                     <tr>
    //                         <td>${order.id}</td>
    //                         <td>${new Date(order.created_at).toLocaleString()}</td>
    //                         <td>${new Intl.NumberFormat().format(order.total)} VND</td>
    //                         <td>${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</td>
    //                     </tr>
    //                 `);
    //             });

    //             // Special Orders
    //             response.prescriptions.forEach(prescription => {
    //                 $('#special-orders tbody').append(`
    //                     <tr>
    //                         <td>${prescription.id}</td>
    //                         <td>${new Date(prescription.created_at).toLocaleString()}</td>
    //                         <td>${new Intl.NumberFormat().format(prescription.total)} VND</td>
    //                         <td>${prescription.status.charAt(0).toUpperCase() + prescription.status.slice(1)}</td>
    //                     </tr>
    //                 `);
    //             });

    //             // Update total revenue
    //             $('#total-revenue').text(`${new Intl.NumberFormat().format(response.totalRevenue)} VND`);
    //         },
    //         error: function(error) {
    //             console.log('Error fetching updated orders:', error);
    //         }
    //     });
    // }

    // // Initial call to update the data
    // setInterval(updateOrdersAndRevenue, 5000); // Update every 5 seconds

    // // Manually trigger on page load
    // updateOrdersAndRevenue();
</script>
@endsection

@endsection
