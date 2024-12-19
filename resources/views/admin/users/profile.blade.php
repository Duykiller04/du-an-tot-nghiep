@extends('admin.layouts.master')

@section('title')
    Cập nhật tài khoản của bạn
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Cập nhật tài khoản của bạn</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Danh sách</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Cập nhật tài khoản của bạn
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('admin.updateProfile', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Thông tin</span></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Tên<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name"  placeholder="Nhập tên người dùng"
                                value="{{ old('name', $user->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Các ô nhập mật khẩu -->
                        <div class="form-group mb-3">
                            <label for="old_password">Mật khẩu cũ</label>
                            <input type="password" class="form-control" id="old_password" name="old_password">
                            @error('old_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="new_password">Mật khẩu mới</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="confirm_password">Nhập lại mật khẩu mới</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            @error('confirm_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ảnh</h5>
                    </div>
                    <div class="card-body d-flex justify-content-center">
                        <div class="avatar-upload text-center">
                            <div class="position-relative">
                                <div class="avatar-preview">
                                    <!-- Hiển thị ảnh hiện tại hoặc ảnh mặc định -->
                                    <div id="imagePreview" class="bg-cover bg-center"
                                        style="width: 150px; height:150px; background-size: contain; background-repeat: no-repeat; 
                               background-image: url({{ $user->image ? asset('storage/' . $user->image) : asset('theme/admin/assets/images/no-img-avatar.png') }});">
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
                            <label for="email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email"  placeholder="Nhập email người dùng"
                                value="{{ old('email', $user->email) }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Điện thoại<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone"  placeholder="Nhập số điện thoại người dùng"
                                value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address"  placeholder="Nhập địa chỉ người dùng"
                                value="{{ old('address', $user->address) }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="birth">Ngày sinh</label>
                            <input type="date" class="form-control" id="birth" name="birth"
                                value="{{ old('birth', $user->birth) }}" max="{{ date('Y-m-d') }}">
                            @error('birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description"  placeholder="Nhập mô tả người dùng">{{ old('description', $user->description) }}</textarea>
                        </div>


                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="text-end m-3">
                        <button type="submit" class="btn btn-success w-sm">Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @if (Auth::user()->type === 'staff' && Auth::id() != $user->id)
        <script>
            alert('Bạn không có quyền sửa tài khoản này.');
            window.location.href = "{{ route('admin.users.index') }}";
        </script>
    @endif
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


        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('imagePreview');
                preview.style.backgroundImage = `url(${reader.result})`;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
