@extends('auth.layouts.master')

@section('title')
    Lấy lại mật khẩu
@endsection

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <h5 class="text-primary">Quên mật khẩu?</h5>
            <p class="text-muted">Đặt lại mật khẩu</p>

            <div class="mt-2 text-center">
                <lord-icon
                    src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop" colors="primary:#0ab39c" class="avatar-xl">
                </lord-icon>
            </div>

            <div class="alert border-0 alert-warning text-center mb-2 mx-2" role="alert">
                Nhập email của bạn và hướng dẫn sẽ được gửi đến bạn!
            </div>
            <div class="p-2">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="col-form-label text-md-end">Địa chỉ Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Nhập địa chỉ Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success w-100">
                            Gửi liên kết đặt lại mật khẩu
                        </button>
                    </div>
                </form><!-- end form -->
            </div>

            <div class="mt-5 text-center">
                <p class="mb-0">Đợi đã, tôi nhớ mật khẩu của mình... <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Đăng nhập </a> </p>
            </div>
        </div>
    </div>
@endsection
