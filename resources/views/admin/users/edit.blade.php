@extends('admin.layouts.master')

@section('title')
    Cập nhật người dùng
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Cập nhật người dùng</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Danh sách</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Cập nhật người dùng
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('admin.users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Cập nhật người dùng</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="form-group mb-3">
                        <label for="name">Tên người dùng</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}">

                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">Điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="address">Địa chỉ</label>
                        <input type="text" class="form-control   " id="address" name="address"
                            value="{{ old('address', $user->address) }}">
                        @error('address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="birth">Ngày sinh</label>
                        <input type="date" class="form-control " id="birth" name="birth"
                            value="{{ old('birth', $user->birth) }}">
                        @error('birth')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Ảnh</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img src="{{ \Storage::url($user->image) }}" alt="" width="100px">
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Mô tả</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description', $user->description) }}</textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control " id="email" name="email"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control " id="password" name="password" value=", $user->password" disabled>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Vai trò</label>
                        <select name="type" id="type" class="form-select">
                            <option value="admin" {{ $user->type == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ $user->type == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>
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
                    <button type="submit" class="btn btn-primary">Save</button>
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
    ClassicEditor.create(document.querySelector('#symptom'))
        .catch(error => {
            console.error(error);
        });

    ClassicEditor.create(document.querySelector('#treatment_direction'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection