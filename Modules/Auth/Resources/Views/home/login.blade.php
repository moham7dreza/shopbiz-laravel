@extends('Home::layouts.master-simple')

@section('content')

    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <form action="{{ route('auth.login') }}" method="post" class="mb-28">
            @csrf
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <a href="{{ route('customer.home') }}">
                        <img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="">
                    </a>
                </section>
                <section class="login-title text-center">ورود به حساب کاربری</section>
                <section class="login-info ms-2">ایمیل</section>
                <section class="login-input-text">
                    <input type="text" name="email" value="{{ old('email') }}">
                    @error('email')
                    <span class="alert alert-danger -p-1 my-3 d-block font-size-80" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
                    @enderror
                </section>
                <section class="login-info ms-2">رمز عبور</section>
                <section class="login-input-text">
                    <input type="password" name="password" value="{{ old('password') }}" autocomplete="on">
                    @error('password')
                    <span class="alert alert-danger -p-1 my-3 d-block font-size-80" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
                    @enderror
                </section>
                <section class="login-btn d-grid g-2">
                    <button class="btn btn-danger">ورود به آمازون</button>
                </section>
                <section class="login-terms-and-conditions d-flex align-items-center">
                    <input type="checkbox" name="rules" class="mx-1" {{ old('rules') == 'on' ? 'checked' : '' }}>
                    <a href="#" class="text-decoration-none"> شرایط و قوانین </a>را خوانده ام و پذیرفته ام
                </section>
                @error('rules')
                <span class="alert alert-danger -p-1 my-3 d-block font-size-80" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
                @enderror
                <section class="border-bottom mt-3"></section>
                <section class="mt-3 text-center">
                    <a href="{{ route('customer.home') }}" class="text-decoration-none text-danger font-size-80">برگشت
                        به فروشگاه</a>
                </section>
            </section>
        </form>
    </section>

@endsection
