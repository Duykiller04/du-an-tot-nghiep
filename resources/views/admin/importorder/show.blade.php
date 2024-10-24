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
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="ps-0" scope="row">Tên kho:</th>
                            <td class="text-muted">{{ $importOrder->storage->name }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Người kiểm kho:</th>
                            <td class="text-muted">{{ $importOrder->user->name}}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Nhà cung cấp:</th>
                            <td class="text-muted">{{ $importOrder->supplier->name }}</td>
                        </tr>

                        <tr>
                            <th class="ps-0" scope="row">Ngày nhập:</th>
                            <td class="text-muted">{{$importOrder->date_added  }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Tổng tiền:</th>
                            <td class="text-muted">{{ number_format($importOrder->total, 2) }}</td>
                        </tr>


                        <tr>
                            <th class="ps-0" scope="row">Số tiền trả :</th>
                            <td class="text-muted">{{ number_format($importOrder->price_paid, 2)}}</td>
                        </tr>

                        <tr>
                            <th class="ps-0" scope="row">Còn nợ :</th>
                            <td class="text-muted">{{number_format($importOrder->still_in_debt, 2)  }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Ghi chú :</th>
                            <td class="text-muted">{{$importOrder->note  }}</td>
                        </tr>
                        <tr>
                            <th class="ps-0" scope="row">Trạng thái :</th>
                            <td class="text-muted">{{ $importOrder->status  }}</td>
                        </tr>
                </tbody>
            </table>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex gap-2">
                    <a href="{{ route('admin.importorder.index') }}" class="btn btn-success">Quay lại</a>
                </div><!-- end card header -->
            </div>
        </div>
        <!--end col-->
    </div>
@endsection
