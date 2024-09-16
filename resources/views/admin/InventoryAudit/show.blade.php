@extends('admin.layouts.master')

@section('title')
    Chi Tiết Phiếu Kiểm
@endsection

@section('content')
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Chi Tiết Phiếu Kiểm</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Quản lý</a></li>
                            <li class="breadcrumb-item active">Chi Tiết Phiếu Kiểm</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @session('msg')
                <div class="alert alert-success">{{ session('msg') }}</div>
            @endsession

            <div class="col-xl-9">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title flex-grow-1 mb-0">Phiếu Kiểm #{{ $inventoryAudit->id }}</h5>
                            <div class="flex-shrink-0">
                                <a href="{{ route('admin.inventoryaudit.index') }}" class="btn btn-primary">Quay Lại</a>
                                {{-- <a href="{{ route('admin.inventoryaudits.print', $inventoryAudit->id) }}" class="btn btn-success">In Phiếu</a> --}}
                            </div>
                        </div>
                        <div class="mt-3">
                            <p>Ngày kiểm tra: {{ \Carbon\Carbon::parse($inventoryAudit->check_date)->format('d/m/Y H:i:s') }}</p>
                            <p>Người thực hiện: {{ $inventoryAudit->checked_by }}</p>
                            <p>Ghi chú: {{ $inventoryAudit->remarks }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table-card">
                            <table class="table table-nowrap align-middle table-borderless mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">Mã thuốc</th>
                                        <th scope="col">Tên thuốc</th>
                                        <th scope="col">Ảnh thuốc</th>
                                        <th scope="col">Số lượng dự kiến</th>
                                        <th scope="col">Số lượng thực tế</th>
                                        <th scope="col">Chênh lệch</th>
                                        <th scope="col">Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventoryAudit->details as $detail)
                                    <tr>
                                        <td>{{ $detail->medicine->medicine_code }}</td>
                                        <td>{{ $detail->medicine->registration_number }}</td>
                                        <td>
                                            <img src="{{ Storage::url($detail->medicine->image) }}" alt="{{ $detail->medicine->name }}" class="img-fluid" style="width: 50px; height: 50px;">
                                        </td>
                                        <td>{{ $detail->expected_quantity }}</td>
                                        <td>{{ $detail->actual_quantity }}</td>
                                        <td>{{ $detail->difference }}</td>
                                        <td>{{ $detail->remarks }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="border-top border-top-dashed">
                                        <td colspan="3"></td>
                                        <td colspan="2" class="fw-medium p-0">
                                            <table class="table table-borderless mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td>Tổng số lượng dự kiến:</td>
                                                        <td class="text-end">{{ $totalExpectedQuantity }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tổng số lượng thực tế:</td>
                                                        <td class="text-end">{{ $totalActualQuantity }}</td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed">
                                                        <th scope="row">Chênh lệch tổng:</th>
                                                        <th class="text-end">{{ $totalActualQuantity - $totalExpectedQuantity }}</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->

            <div class="col-xl-3">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <h5 class="card-title flex-grow-1 mb-0">Thông tin phiếu kiểm</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0 vstack gap-3">
                            <li>ID Phiếu Kiểm: {{ $inventoryAudit->id }}</li>
                            <li><i class="ri-calendar-line me-2 align-middle text-muted fs-16"></i>{{ \Carbon\Carbon::parse($inventoryAudit->created_at)->format('d/m/Y') }}</li>
                            <li><i class="ri-user-line me-2 align-middle text-muted fs-16"></i>{{ $inventoryAudit->checked_by }}</li>
                        </ul>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

    </div><!-- container-fluid -->
@endsection
