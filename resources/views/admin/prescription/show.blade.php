@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn thuốc')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết đơn thuốc</h4>

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
        <div class="card-header">
            <h4 class="card-title">Thông tin đơn thuốc</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label><strong>ID:</strong></label>
                <span>{{ $prescription->id }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Tên khách hàng:</strong></label>
                <span>{{ $prescription->name_customer }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Giới tính:</strong></label>
                <span>{{ $prescription->gender == 0 ? 'Nam' : 'Nữ' }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Tuổi:</strong></label>
                <span>{{ $prescription->age }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Điện thoại:</strong></label>
                <span>{{ $prescription->phone }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Địa chỉ:</strong></label>
                <span>{{ $prescription->address }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Email:</strong></label>
                <span>{{ $prescription->email }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Cân nặng:</strong></label>
                <span>{{ $prescription->weight }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Tổng:</strong></label>
                <span>{{ number_format($prescription->total, 2) }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Thời gian tạo:</strong></label>
                <span>{{ $prescription->created_at }}</span>
            </div>
            <div class="mb-3">
                <label><strong>Thời gian cập nhật:</strong></label>
                <span>{{ $prescription->updated_at }}</span>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">Chi tiết đơn thuốc</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên thuốc</th>
                        <th>Đơn vị</th>
                        <th>Số lượng</th>
                        <th>Giá bán</th>
                        <th>Liều lượng</th>
                    </tr>
                </thead>
                <tbody>
                    @if($prescription->prescriptionDetails && $prescription->prescriptionDetails->count())
                        @foreach ($prescription->prescriptionDetails as $detail)
                            <tr>
                                <td>{{ $detail->id }}</td>
                                <td>{{ $detail->medicine->name }}</td>
                                <td>{{ $detail->unit->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->current_price, 0) }} VNĐ</td>
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

    <div class="text-end m-3">
        <a href="{{ route('admin.prescriptions.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
@endsection
