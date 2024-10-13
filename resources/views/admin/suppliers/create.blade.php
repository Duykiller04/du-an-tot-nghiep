@extends('admin.layouts.master')

@section('title')
    Thêm mới tác giả
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới nhà cung cấp</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nhà cung cấp</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Thêm mới
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Thêm mới</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="col-6">
                                    <div>
                                        <label for="tax_code" class="form-label">Mã số thuế (<span class="text-danger">*</span>)</label>
                                        <input type="text" class="form-control" id="tax_code" name="tax_code">
                                        @error('tax_code')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="name" class="form-label">Tên nhà cung cấp (<span class="text-danger">*</span>)</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="email" class="form-label">Email (<span class="text-danger">*</span>)</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-6">
                                    <div>
                                        <label for="phone" class="form-label">Số điện thoại (<span class="text-danger">*</span>)</label>
                                        <input type="text" class="form-control" id="phone" name="phone">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="address" class="form-label">Địa chỉ (<span class="text-danger">*</span>)</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <button type="submit" class="btn btn-primary me-2">Thêm mới</button>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-success">Quay lại</a>
                    </div><!-- end card header -->
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
@endsection
