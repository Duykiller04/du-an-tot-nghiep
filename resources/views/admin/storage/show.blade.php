@extends('admin.layouts.master')

@section('title', 'Danh sách thuốc trong kho')

@section('content')
    <div class="container-fluid">
        <!-- Tiêu đề -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách thuốc / dụng cụ trong kho: {{ $storage->name }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.storage.index') }}">Kho</a></li>
                            <li class="breadcrumb-item active">Danh sách thuốc</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin kho -->
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin kho</h4>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="ps-0" scope="row">Tên kho:</th>
                            <td class="text-muted">{{ $storage->name }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Vị trí:</th>
                            <td class="text-muted">{{ $storage->location }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Danh sách thuốc -->
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Danh sách thuốc/dụng cụ có trong kho</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên thuốc</th>
                                <th>Quy cách đóng gói</th>
                                <th>Giá nhập</th>
                                <th>Giá bán</th>
                                <th>Số lô</th>
                                <th>Số lượng</th>
                                <th>Đơn vị bán (đơn vị nhỏ nhất)</th>
                                <th>Ngày hết hạn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $index => $medicine)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $medicine->name }}</td>
                                    <td>{{ $medicine->batch_info->packaging_specification }}</td>
                                    <td>{{ number_format($medicine->batch_info->price_import, 0, ',', '.') }} ₫</td>
                                    <td>{{ number_format($medicine->batch_info->price_sale, 0, ',', '.') }} ₫</td>                                    
                                    <td>{{ $medicine->batch_info->registration_number ?? 'N/A' }}</td>
                                    <td>{{ $medicine->inventory_info->quantity ?? '0' }}</td>
                                    <td>{{ $medicine->inventory_info->unit->name ?? 'N/A' }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($medicine->batch_info->expiration_date ?? now())->format('d-m-Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quay lại -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <a href="{{ route('admin.storage.index') }}" class="btn btn-success">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
