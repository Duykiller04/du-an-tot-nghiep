@extends('admin.layouts.master')

@section('title')
Thêm Ca Làm Việc
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Thêm mới Ca Làm Việc</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Ca Làm Việc</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Thêm mới
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('admin.workshifts.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Thêm mới</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="form-group mb-3">
                            <label for="user_id">Người dùng</label>
                            <select class="form-control" id="user_id" name="user_id">
                                <!-- Giả sử bạn đã truyền danh sách người dùng từ controller -->
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">Tên Ca Làm Việc</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="target">Mục Tiêu</label>
                            <input type="number" class="form-control" id="target" name="target" value="{{ old('target') }}">
                            @error('target')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="is_applied" name="is_applied" value="1" {{ old('is_applied') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_applied">Đã Áp Dụng</label>
                            </div>
                            @error('is_applied')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="start_time">Thời Gian Bắt Đầu</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time') }}">
                            @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="end_time">Thời Gian Kết Thúc</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time') }}">
                            @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div><!-- end card header -->
            </div>
        </div>
        <!--end col-->
    </div>
</form>
@endsection

@section('style-libs')
<!-- Plugins css -->
<link href="{{ asset('theme/admin/assets/libs/dropzone/dropzone.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('script-libs')
<!-- ckeditor -->
<script src="{{ asset('theme/admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

<script>
    ClassicEditor.create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
