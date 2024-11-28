@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn thuốc cắt liều')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết đơn thuốc cắt liều</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Đơn thuốc</a>
                        </li>
                        <li class="breadcrumb-item active">Chi tiết</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4 class="card-title">Thông tin đơn thuốc cắt liều</h4>
            <a href="{{ route('admin.cutDoseOrders.index') }}">
                <button type="button" class="btn btn-primary w-sm">Quay lại</button>
            </a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label><strong>Tên khách hàng:</strong></label>
                <span>{{ $cutDoseOrder->customer_name }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Giới tính:</strong></label>
                <span>{{ $cutDoseOrder->gender == 0 ? 'Nam' : 'Nữ' }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Tuổi:</strong></label>
                <span>{{ $cutDoseOrder->age }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Điện thoại:</strong></label>
                <span>{{ $cutDoseOrder->phone }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Địa chỉ:</strong></label>
                <span>{{ $cutDoseOrder->address }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Cân nặng:</strong></label>
                <span>{{ $cutDoseOrder->weight }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Thời gian tạo:</strong></label>
                <span>{{ $cutDoseOrder->created_at }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Thời gian cập nhật:</strong></label>
                <span>{{ $cutDoseOrder->updated_at }}</span>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">Chi tiết đơn thuốc cắt liều</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên thuốc</th>
                        <th>Đơn vị</th>
                        <th>Số lượng</th>
                        <th>Giá bán</th>
                        <th>Liều lượng</th>
                    </tr>
                </thead>
                <tbody>
                    @if($cutDoseOrder->cutDoseOrderDetails && $cutDoseOrder->cutDoseOrderDetails->count())
                        @foreach ($cutDoseOrder->cutDoseOrderDetails as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->medicine->name }}</td>
                                <td>{{ $detail->unit->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->current_price) }} VNĐ</td>
                                <td>{{ $detail->dosage }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">Không có chi tiết đơn thuốc nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
