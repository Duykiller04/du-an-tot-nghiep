@extends('admin.layouts.master')

@section('title')
    Chi tiết nhà cung cấp: {{ $supplier->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết nhà cung cấp</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nhà cung cấp</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Chi tiết
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Chi tiết nhà cung cấp: {{ $supplier->name }}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="live-preview">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">Mã số thuế:</th>
                                                    <td class="text-muted">{{ $supplier->tax_code }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Tên nhà cung cấp:</th>
                                                    <td class="text-muted">{{ $supplier->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Email:</th>
                                                    <td class="text-muted">{{ $supplier->email }}</td>
                                                </tr>
                    
                                                <tr>
                                                    <th class="ps-0" scope="row">Số điện thoại:</th>
                                                    <td class="text-muted">{{ $supplier->phone }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Địa chỉ:</th>
                                                    <td class="text-muted">{{ $supplier->address }}</td>
                                                </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
@endsection
