@extends('auth.layouts.master')

@section('title')
    Đăng ký
@endsection

@section('content')
    <div class="col-lg-6">
        <div class="p-lg-5 p-4">
            <div>
                <h5 class="text-primary">Register Account</h5>
                <p class="text-muted">Get your Free Velzon account now.</p>
            </div>

            <div class="mt-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="col-form-label text-md-end">{{ __('Name') }}<span
                                class="text-danger">*</span></label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" autocomplete="name" autofocus
                            placeholder="Enter Name">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}<span
                                class="text-danger">*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Enter Email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="col-form-label text-md-end">{{ __('Password') }}<span
                                class="text-danger">*</span></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" autocomplete="new-password" placeholder="Enter Password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password-confirm" class="col-form-label text-md-end">{{ __('Confirm Password') }}<span
                                class="text-danger">*</span></label>


                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            autocomplete="new-password" placeholder="Enter Password Confirm">

                    </div>

                    <div class="mt-4">
                        <button class="btn btn-success w-100" type="submit">{{ __('Register') }}</button>
                    </div>
                </form>
            </div>

            <div class="mt-5 text-center">
                <p class="mb-0">Already have an account ?
                    <a href="{{ route('login') }}"
                        class="fw-semibold text-primary text-decoration-underline">{{ __('Login') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection
@section('script-libs')
    <!-- validation init -->
    <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>
    <!-- password create init -->
    <script src="{{ asset('assets/js/pages/passowrd-create.init.js') }}"></script>
@endsection
