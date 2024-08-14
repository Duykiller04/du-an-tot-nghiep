@extends('auth.layouts.master')

@section('title')
    Đăng nhập
@endsection

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <div>
                <h5 class="text-primary">Welcome Back !</h5>
                <p class="text-muted">Sign in to continue to Velzon.</p>
            </div>

            <div class="mt-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" autocomplete="email" autofocus
                            placeholder="Enter Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <div class="float-end">

                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-muted" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif


                        </div>
                        <label class="form-label" for="password-input">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="current-password" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>

                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-success w-100" type="submit">{{ __('Login') }}</button>
                    </div>

                    {{-- <div class="mt-4 text-center">
                        <div class="signin-other-title">
                            <h5 class="fs-13 mb-4 title">Sign In with</h5>
                        </div>

                        <div>
                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i
                                    class="ri-facebook-fill fs-16"></i></button>
                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i
                                    class="ri-google-fill fs-16"></i></button>
                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i
                                    class="ri-github-fill fs-16"></i></button>
                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i
                                    class="ri-twitter-fill fs-16"></i></button>
                        </div>
                    </div> --}}

                </form>
            </div>


            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>

            <div class="mt-5 text-center">
                <p class="mb-0">Don't have an account ? <a href="{{ route('register') }}"
                        class="fw-semibold text-primary text-decoration-underline">{{ __('Register') }}</a> </p>
            </div>
        </div>
    </div>
@endsection
@section('script-libs')
    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
@endsection
