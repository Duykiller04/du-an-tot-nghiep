@extends('admin.layouts.master')

@section('title')
    Thêm người dùng
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Thêm mới người dùng</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Người dùng</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Thêm mới
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin người dùng</span></h5>
                    </div>
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name">Tên người dùng <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div>
                                <label for="password" class="form-label">Vai trò <span class="text-danger">*</span></label>
                                <select name="type" id="" class="form-select">
                                    <option value="admin" selected>Quản trị viên</option>
                                    <option value="staff">Nhân viên</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu<span class="text-danger">*</span></label>
                            <input type="password" class="form-control " id="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="mt-4">Xác nhận mật khẩu<span
                                    class="text-danger">*</span></label>
                            <input class="form-control" type="password" name="password_confirmation" id=" password">
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ảnh thuốc</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div class="avatar-upload text-center">
                            <div class="position-relative">
                                <div class="avatar-preview">
                                    <!-- Hiển thị ảnh mặc định hoặc ảnh đã được tải lên trước đó -->
                                    <div id="imagePreview" class="bg-cover bg-center"
                                        style="width: 150px; height:150px; background-size: contain; background-repeat: no-repeat; 
                                               background-image: url({{ old('image') ? asset('storage/' . old('image')) : asset('theme/admin/assets/images/no-img-avatar.png') }});">
                                    </div>
                                </div>
                                <div class="change-btn mt-2">
                                    <!-- Input file ẩn -->
                                    <input type="file" class="form-control d-none" id="imageUpload" name="image"
                                        accept=".png, .jpg, .jpeg" onchange="previewImage(event)">
                                    <!-- Nút chọn ảnh -->
                                    <label for="imageUpload" class="btn btn-primary light btn">Chọn ảnh</label>
                                </div>
                                @error('image')
                                    <span class="d-block text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin chi tiết</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control " id="email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control   " id="address" name="address"
                                value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="birth">Ngày sinh</label>
                            <input type="date" class="form-control " id="birth" name="birth"
                                value="{{ old('birth') }}">
                            @error('birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
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
                    <div class="text-end m-3">
                        <a href="{{ route('admin.users.index') }}">
                            <button type="button" class="btn btn-primary w-sm">Quay lại</button>
                        </a>
                        <button type="submit" class="btn btn-success w-sm">Nhập mới</button>
                    </div>
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


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").on('change', function() {
            readURL(this);
        });
    </script>
@endsection
