@extends('Home::layouts.master-simple')

@section('content')

    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">

        <section class="d-flex flex-column mb-5">

            <section class="login-wrapper">
                <section class="login-title text-center">تایید ایمیل</section>
                <section class="login-logo">
                    <img src="{{ asset('customer-assets/images/mail_confirm.png') }}" alt="">
                </section>

                <p class="text-muted font-size-80 mb-3">
                    یک ایمیل به
                    <b>{{ auth()->user()->email }}</b>
                    ارسال شده است.
                </p>
                <p class="text-muted font-size-80 mb-3">
                    لطفا روی لینک موجود در ایمیل کلیک کنید.
                </p>
                <section class="border-bottom mt-3"></section>
                <form action="{{ route('verify.resend') }}" method="POST" id="resend-verify-email">@csrf</form>
                <section class="login-btn d-grid g-2 mt-4">
                    <button class="btn btn-danger"
                            onclick="event.preventDefault();document.getElementById('resend-verify-email').submit()">
                        ارسال دوباره لینک برای ایمیل
                    </button>
                </section>

            </section>

            <section class="d-flex flex-column">
                <section class="mt-3 text-center font-size-80 register">
                    <span class="text-dark text-muted mx-1">بازگشت به </span>
                    <a href="{{ route('auth.login-form') }}" class="text-decoration-none font-weight-bold">
                        صفحه ورود
                    </a>
                </section>
                <section class="mt-3 text-center go-home">
                    <a href="{{ route('customer.home') }}">برگشت
                        به فروشگاه</a>
                </section>
            </section>
        </section>
    </section>

@endsection
