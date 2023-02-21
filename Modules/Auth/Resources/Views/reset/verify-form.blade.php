@extends('Home::layouts.master-simple')

@section('content')

    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">

        <section class="d-flex flex-column mb-5">

            <form action="{{ route('auth.reset-password') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <section class="login-wrapper">
                    <section class="login-logo">
                        <a href="{{ route('customer.home') }}">
                            <img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="">
                        </a>
                    </section>
                    <section class="login-title text-center">ایجاد کلمه عبور جدید</section>
                    <section class="border-bottom mt-3"></section>

                    <x-share-error />

                    <section class="row font-size-80 mt-3">
                        @php $message = $message ?? null @endphp
                        <x-panel-input col="12" name="email" type="email" class="p-2 font-size-90 login-input"
                                       label="ایمیل" method="edit" :old="$email"
                                       placeholder="پست الکترونیک" dadClass="mt-2"
                                       :message="$message"/>
                        <x-panel-input col="12" type="password" name="password" class="p-2 font-size-90 login-input" dadClass="mt-2"
                                       label="کلمه عبور" placeholder="شامل حروف بزرگ و کوچک، اعداد و نماد"
                                       :message="$message"/>
                        <x-panel-input col="12" type="password" name="password_confirmation" class="p-2 font-size-90 login-input"
                                       dadClass="mt-2" label="تکرار کلمه عبور"
                                       placeholder="کلمه عبور خود را دوباره وارد کنید"
                                       :message="$message"/>
                    </section>

                    <section class="login-btn d-grid g-2 mt-3">
                        <button class="btn btn-danger">تغییر کلمه عبور</button>
                    </section>

                </section>
            </form>

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
