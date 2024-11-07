@extends('admin.layouts.master')

@section('title')
    Chi tiết kho
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Chi tiết kho: {{ $storage->name }}</h4>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.storage.index') }}">Danh sách kho</a></li>
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

        <div class="card p-3">
            <h5>Thông tin kho</h5>
            <p><strong>Tên kho:</strong> {{ $storage->name }}</p>
            <p><strong>Địa điểm:</strong> {{ $storage->location }}</p>
            <p><strong>Thời gian tạo:</strong> {{ $storage->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card p-3">
                    <h5>Danh sách thuốc và dụng cụ</h5>
                    @if($storage->medicines->isEmpty())
                        <div class="alert alert-warning">Không có thuốc hoặc dụng cụ nào trong kho này.</div>
                    @else
                        <ul class="nav nav-tabs" id="medicineTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="medicines-tab" data-bs-toggle="tab" href="#medicines" role="tab" aria-controls="medicines" aria-selected="true">Danh sách thuốc</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="supplies-tab" data-bs-toggle="tab" href="#supplies" role="tab" aria-controls="supplies" aria-selected="false">Danh sách dụng cụ</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="medicineTabContent">
                            <!-- Tab Danh sách thuốc -->
                            <div class="tab-pane fade show active" id="medicines" role="tabpanel" aria-labelledby="medicines-tab">
                                <div class="card p-3 bg-light">
                                    @if($storage->medicines->where('type_product', 0)->isEmpty())
                                        <div class="alert alert-warning">Không có thuốc nào trong kho này.</div>
                                    @else
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tên thuốc</th>
                                                    <th>Mã thuốc</th>
                                                    <th>Giá</th>
                                                    <th>Ngày hết hạn</th> <!-- New column for expiration date -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($storage->medicines as $medicine)
                                                    @if($medicine->type_product == 0)
                                                        <tr>
                                                            <td>{{ $medicine->name }}</td>
                                                            <td>{{ $medicine->medicine_code }}</td>
                                                            <td>{{ number_format($medicine->price_sale) }} VND</td>
                                                            <td>{{ $medicine->expiration_date ? $medicine->expiration_date->format('d/m/Y') : 'Chưa có' }}</td> <!-- Display expiration date -->
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
        
                            <!-- Tab Danh sách dụng cụ -->
                            <div class="tab-pane fade" id="supplies" role="tabpanel" aria-labelledby="supplies-tab">
                                <div class="card p-3 bg-light">
                                    @if($storage->medicines->where('type_product', 1)->isEmpty())
                                        <div class="alert alert-warning">Không có dụng cụ nào trong kho này.</div>
                                    @else
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Tên dụng cụ</th>
                                                    <th>Mã dụng cụ</th>
                                                    <th>Giá</th>
                                                    <th>Ngày hết hạn</th> <!-- New column for expiration date -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($storage->medicines as $medicine)
                                                    @if($medicine->type_product == 1)
                                                        <tr>
                                                            <td>{{ $medicine->name }}</td>
                                                            <td>{{ $medicine->medicine_code }}</td>
                                                            <td>{{ number_format($medicine->price_sale) }} VND</td>
                                                            <td>{{ $medicine->expiration_date ? $medicine->expiration_date->format('d/m/Y') : 'Chưa có' }}</td> <!-- Display expiration date -->
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="text-end">
            <a href="{{ route('admin.storage.index') }}" class="btn btn-warning">Quay lại</a>
        </div>
    </div>
@endsection
