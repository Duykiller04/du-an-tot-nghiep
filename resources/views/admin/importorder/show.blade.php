@extends('admin.layouts.master')

@section('title', 'Chi tiết đơn hàng nhập kho')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết đơn hàng nhập kho</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Kho thuốc</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.importorder.index') }}">Danh sách đơn hàng</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Chi tiết
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Thông tin đơn hàng</h4>
        </div>
        <div class="card-body">

            <div class="mb-3">
                <label for="user_id" class="form-label"><strong>Người dùng:</strong></label>
                <input type="user_id" name="user_id" id="user_id" class="form-control"
                    value="{{ $importOrder->user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="storage_id" class="form-label"><strong>Kho:</strong></label>
                <input type="storage_id" name="storage_id" id="storage_id" class="form-control"
                    value="{{ $importOrder->storage->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="supplier_id" class="form-label"><strong>Nhà cung cấp:</strong></label>
                <input type="supplier_id" name="supplier_id" id="supplier_id" class="form-control"
                    value="{{ $importOrder->supplier->name }}" readonly>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label"><strong>Tổng:</strong></label>
                <input type="total" name="total" id="total" class="form-control"
                    value="{{ number_format($importOrder->total, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="price_paid" class="form-label"><strong>Số tiền đã trả:</strong></label>
                <input type="price_paid" name="price_paid" id="price_paid" class="form-control"
                    value="{{ number_format($importOrder->price_paid, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="still_in_debt" class="form-label"><strong>Còn nợ:</strong></label>
                <input type="still_in_debt" name="still_in_debt" id="still_in_debt" class="form-control"
                    value="{{ number_format($importOrder->still_in_debt, 2) }}" readonly>
            </div>

            <div class="mb-3">
                <label for="date_added" class="form-label"><strong>Ngày thêm:</strong></label>
                <input type="date_added" name="date_added" id="date_added" class="form-control"
                    value="{{ $importOrder->date_added }}" readonly>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label"><strong>Ghi chú:</strong></label>
                <input type="note" name="note" id="note" class="form-control" value="{{ $importOrder->note }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label"><strong>Trạng thái:</strong></label>
                <input type="status" name="status" id="statu" class="form-control" value="{{ $importOrder->status }}"
                    readonly>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title">Chi tiết đơn hàng</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên thuốc</th>
                        <th>Đơn vị</th>
                        <th>Số lượng</th>
                        <th>Giá nhập</th>
                        <th>Tổng</th>
                        <th>Ngày nhập</th>
                        <th>Ngày hết hạn</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($importOrder->details as $detail)
                        <tr>
                            <td>{{ $detail->medicine->name }}</td>
                            <td>{{ $detail->unit->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>{{ number_format($detail->import_price, 2) }}</td>
                            <td>{{ number_format($detail->total, 2) }}</td>
                            <td>{{ $detail->date_added }}</td>
                            <td>{{ $detail->expiration_date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-end m-3">
        <a href="{{ route('admin.importorder.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
@endsection
