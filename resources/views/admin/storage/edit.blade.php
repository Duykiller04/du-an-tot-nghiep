@extends('admin.layouts.master')

@section('title')
Cập nhật kho thuốc
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Cập nhật kho thuốc</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Kho thuốc</a></li>
                    <li class="breadcrumb-item active">Thêm mới</li>
                </ol>
            </div>

        </div>
    </div>
</div>

<form action="{{ route('admin.storage.update',$storage) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Thông tin</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="mt-3">
                                <label for="name" class="form-label">Tên kho</label>
                                <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" id="name" value="{{$storage->name}}">
                                <div class="invalid-feedback">
                                    @error('name')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>


                            <div class="mt-3">
                                <label for="location" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control @error('location')is-invalid @enderror" name="location" id="text" value="{{$storage->location}}">
                                <div class="invalid-feedback">
                                    @error('location')
                                    {{$message}}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    <!--end col-->
    </div>


    <div class="row">

        <!--end col-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <button class="btn btn-primary" type="submit">Save</button>
                </div><!-- end card header -->
            </div>
        </div>
        <!--end col-->
    </div>
</form>
@endsection