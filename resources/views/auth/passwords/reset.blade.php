@extends('auth.layouts.master')

@section('title')
    Đặt lại mật khẩu
@endsection

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <h5 class="text-primary">Create new password</h5>
            <p class="text-muted">Your new password must be different from previous used password.</p>

            <div class="p-2">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                        
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Enter Password Confirm">
                        
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-success w-100" type="submit">{{ __('Reset Password') }}</button>
                    </div>

                </form>
            </div>

            <div class="mt-5 text-center">
                <p class="mb-0">Wait, I remember my password... <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Click here </a> </p>
            </div>
        </div>
    </div>
@endsection
@section('script-libs')
    <script src="assets/js/pages/passowrd-create.init.js"></script>
@endsection
