@extends('admin.layouts.master')

@section('title')
    Chi tiết đơn vị tính: {{ $unit->name }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Chi tiết đơn vị tính</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Đơn vị tính</a>
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
                    <h4 class="card-title mb-0 flex-grow-1">Chi tiết đơn vị tính: {{ $unit->name }}</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="live-preview">
                            <div class="row gy-4">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên đơn vị tính</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $unit->name) }}" disabled>
                                </div>
                                <a href="{{ route('admin.units.index') }}" class="btn btn-primary mt-3">Quay lại danh sách</a>
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
