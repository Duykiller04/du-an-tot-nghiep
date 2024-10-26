@extends('admin.layouts.master')

@section('title')
    Sửa đơn thuốc cắt liều
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Sửa đơn thuốc cắt liều</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Đơn thuốc</a></li>
                            <li class="breadcrumb-item active">Sửa đơn thuốc cắt liều</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form id="edit-cut-dose-order-form" method="POST"
            action="{{ route('admin.cutDoseOrders.update', $cutDoseOrder->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin khách hàng</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Tên khách hàng <span
                                        class="text-danger">(*)</span></label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    id="customer_name" name="customer_name"
                                    value="{{ old('customer_name', $cutDoseOrder->customer_name) }}">
                                @error('customer_name')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="age" class="form-label">Tuổi <span class="text-danger">(*)</span></label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror" id="age"
                                    name="age" value="{{ old('age', $cutDoseOrder->age) }}">
                                @error('age')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Điện thoại <span
                                        class="text-danger">(*)</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $cutDoseOrder->phone) }}">
                                @error('phone')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ <span
                                        class="text-danger">(*)</span></label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address', $cutDoseOrder->address) }}">
                                @error('address')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Cân nặng <span
                                        class="text-danger">(*)</span></label>
                                <input type="number" class="form-control @error('weight') is-invalid @enderror"
                                    id="weight" name="weight" value="{{ old('weight', $cutDoseOrder->weight) }}">
                                @error('weight')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Giới tính <span
                                        class="text-danger">(*)</span></label>
                                <select name="gender" id="gender"
                                    class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Chọn giới tính</option>
                                    <option value="0"
                                        {{ old('gender', $cutDoseOrder->gender) == '0' ? 'selected' : '' }}>Nam</option>
                                    <option value="1"
                                        {{ old('gender', $cutDoseOrder->gender) == '1' ? 'selected' : '' }}>Nữ</option>
                                </select>
                                @error('gender')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bệnh</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="disease_id" class="form-label">Bệnh</label>
                                <input type="text" class="form-control"
                                    value="{{ $diseases[$cutDoseOrder->disease_id] ?? 'Chưa xác định' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="sale_date" class="form-label">Ngày bán</label>
                                <input type="date" class="form-control" id="sale_date" name="sale_date"
                                    value="{{ $cutDoseOrder->created_at->format('Y-m-d') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-5">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Trạng thái</h5>
                        </div>
                        <div class="card-body">
                            <label class="form-label">Trạng thái</label>
                            <div class="form-check form-switch form-switch-lg">
                                <input class="form-check-input" type="checkbox" id="customSwitchsizelg" name="status" 
                                    value="1" {{ $cutDoseOrder->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="status">{{ $cutDoseOrder->status ? 'Bán' : 'Hủy' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Thông tin thuốc và dụng cụ</h5>
                        </div>
                        <div class="card-body">
                            <div id="medicine-container">
                                @foreach ($cutDoseOrder->cutDoseOrderDetails as $i => $detail)
                                    <div class="medicine-row mb-3" data-index="{{ $i }}">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label class="form-label">Thuốc</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $detail->medicine->name }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Đơn vị</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $detail->unit->name }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Số lượng</label>
                                                <input type="number" class="form-control"
                                                    value="{{ $detail->quantity }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Liều lượng</label>
                                                <input type="text" class="form-control" value="{{ $detail->dosage }}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('admin.cutDoseOrders.index') }}" class="btn btn-secondary">Hủy</a>
                <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </div>
@endsection
