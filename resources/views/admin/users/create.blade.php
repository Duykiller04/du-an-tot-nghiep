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
                            Thêm mới người dùng
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
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nhập tên người dùng"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Mật khẩu<span class="text-danger">*</span></label>
                            <div class="position-relative">
                                <!-- Trường nhập mật khẩu -->
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu người dùng">
                                <!-- Biểu tượng mắt để hiển thị/ẩn mật khẩu -->
                                <i class="fas fa-eye" id="togglePassword"
                                    style="position: absolute; right: 10px; top: 10px; cursor: pointer;"></i>
                            </div>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="mt-4">Xác nhận mật khẩu<span
                                    class="text-danger">*</span></label>
                            <div class="position-relative">
                                <!-- Trường nhập xác nhận mật khẩu --> 
                                <input class="form-control" type="password" name="password_confirmation" placeholder="xác nhận lại mật khẩu người dùng"
                                    id="password_confirmation">
                                <!-- Biểu tượng mắt để hiển thị/ẩn mật khẩu xác nhận -->
                                <i class="fas fa-eye" id="togglePasswordConfirmation"
                                    style="position: absolute; right: 10px; top: 10px; cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ảnh</h5>
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
                                        accept=".png, .jpg, .jpeg">
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
                            <input type="email" class="form-control " id="email" name="email" placeholder="Nhập email người dùng"
                                value="{{ old('email') }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">Điện thoại <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Nhập số điện thoại người dùng"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Nhập địa chỉ người dùng"
                                value="{{ old('address') }}">
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="birth">Ngày sinh</label>
                            <input type="date" class="form-control" id="birth" name="birth" 
                                value="{{ old('birth') }}" max="{{ date('Y-m-d') }}">
                            @error('birth')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" placeholder="Nhập mô tả người dùng"  name="description">{{ old('description') }}</textarea>
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
    <!-- Nạp jQuery từ CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Thêm Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


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

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Cập nhật ảnh preview với background-image
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650); // Thêm hiệu ứng fadeIn để ảnh hiện ra mượt mà
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Khi người dùng chọn ảnh, gọi hàm readURL
        $("#imageUpload").on('change', function() {
            readURL(this);
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            const togglePasswordConfirmation = document.querySelector('#togglePasswordConfirmation');
            const passwordConfirmation = document.querySelector('#password_confirmation');

            // Khi nhấp vào biểu tượng mắt, chuyển đổi giữa type="password" và type="text"
            togglePassword.addEventListener('click', function() {
                // Kiểm tra trạng thái của input mật khẩu
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                // Thay đổi biểu tượng giữa "eye" và "eye-slash"
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            togglePasswordConfirmation.addEventListener('click', function() {
                // Kiểm tra trạng thái của input mật khẩu xác nhận
                const type = passwordConfirmation.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmation.setAttribute('type', type);
                // Thay đổi biểu tượng giữa "eye" và "eye-slash"
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endsection
