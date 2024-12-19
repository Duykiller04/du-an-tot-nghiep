@extends('admin.layouts.master')

@section('title')
    Thông tin dụng cụ
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Thông tin dụng cụ</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dụng cụ</a></li>
                            <li class="breadcrumb-item active">Thông tin dụng cụ</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thông tin dụng cụ</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th class="ps-0" scope="row">Mã dụng cụ:</th>
                                <td class="text-muted">{{ $medicine->medicine_code }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Tên dụng cụ:</th>
                                <td class="text-muted">{{ $medicine->name }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0" scope="row">Danh mục:</th>
                                <td class="text-muted">{{ $medicine->category->name }}</td>
                            </tr>

                            <tr>
                                <th class="ps-0" scope="row">Ảnh dụng cụ:</th>
                                <td class="text-muted">
                                    @if ($medicine->image)
                                        <a data-fancybox data-src="{{ asset(\Illuminate\Support\Facades\Storage::url($medicine->image)) }}" data-caption="Ảnh dụng cụ" >
                                            <img src="{{ asset(\Illuminate\Support\Facades\Storage::url($medicine->image)) }}" width="200" height="150" alt="" />
                                        </a>
                                    @else
                                        <img src="{{ asset('theme/admin/assets/images/no-img-avatar.png') }}" width="200" height="150" alt="" />
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4 class="card-title">Chi tiết lô</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Số lô</th>
                                <th>Kho</th>
                                <th>Nhà cung cấp</th>
                                <th>Số đăng ký</th>
                                <th>Xuất xứ</th>
                                <th>Quy cách đóng gói</th>
                                <th>Giá nhập</th>
                                <th>Giá bán</th>
                                <th>Giá bán theo đơn vị nhỏ nhất</th>
                                <th>Số lượng</th>
                                <th>Nhiệt độ</th>
                                <th>Độ ẩm</th>
                                <th>Ngày nhập lô</th>
                                <th>Ngày hết hạn</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicine->batches as $batch)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $batch->storage->name }}</td>
                                    <td>{{ $batch->supplier->name }}</td>
                                    <td>{{ $batch->registration_number }}</td>
                                    <td>{{ $batch->origin }}</td>
                                    <td>{{ $batch->packaging_specification }}</td>
                                    <td>{{ number_format($batch->price_import, 0, ',', '.') }} VND</td>
                                    <td>{{ number_format($batch->price_sale, 0, ',', '.') }} VND</td>
                                    <td>{{ number_format($batch->price_in_smallest_unit, 0, ',', '.') }} VND</td>
                                    <td>{{ $batch->inventory->quantity }} ({{ $batch->inventory->unit->name }})</td>
                                    <td>{{ $medicine->temperature }}</td>
                                    <td>{{ $medicine->moisture }}</td>
                                    <td>{{ \Carbon\Carbon::parse($batch->created_at)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($batch->expiration_date)->format('d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex gap-2">
                        <a href="{{ route('admin.medicalInstruments.index') }}" class="btn btn-success">Quay lại</a>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>

    </div>
@endsection
