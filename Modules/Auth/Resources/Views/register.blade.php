@extends('Home::layouts.master-simple')

@section('content')

    <section class="vh-100 d-flex justify-content-center align-items-center pb-5">
        <section class="d-flex flex-column mb-5">
            <form action="{{ route('auth.register') }}" method="post">
                @csrf
                <section class="login-wrapper">
                    <section class="login-logo">
                        <a href="{{ route('customer.home') }}">
                            <img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="">
                        </a>
                    </section>
                    <section class="login-title text-center">ثبت نام</section>
                    <section class="border-bottom mt-3"></section>
                    <section class="row font-size-80 mt-3">
                        @php $message = $message ?? null @endphp
                        <x-panel-input col="6" name="first_name" label="نام" class="login-input"
                                       :message="$message"/>
                        <x-panel-input col="6" name="last_name" label="نام خانوادگی" class="login-input"
                                       :message="$message"/>
                        <x-panel-input col="12" name="email" type="email" class="p-2 font-size-90 login-input" label="ایمیل"
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
                        <button class="btn btn-danger">ورود به آمازون</button>
                    </section>
                    <section class="login-terms-and-conditions d-flex align-items-center">
                        <label for="rules"></label>
                        <input type="checkbox" name="rules" id="rules"
                               class="mx-1 rounded" {{ old('rules') == 'on' ? 'checked' : '' }}>
                        <a href="{{ route('customer.pages.privacy-policy') }}"
                           class="text-decoration-none mx-1 font-weight-bold" title="برای مطالعه قوانین کلیک کنید"
                           data-bs-toggle="tooltip"
                           data-bs-placement="top"> شرایط و قوانین </a>را خوانده
                        ام
                        و پذیرفته ام
                    </section>
                    @error('rules')
                    <span class="alert alert-danger -p-1 my-3 d-block font-size-80" role="alert">
                <strong>
                    {{ $message }}
                </strong>
            </span>
                    @enderror
                </section>
            </form>

            <section class="d-flex flex-column mb-5">
                <section class="mt-3 text-center font-size-80 register">
                    <span class="text-dark text-muted mx-1">حساب کاربری دارید؟</span>
                    <a href="{{ route('auth.login') }}" class="text-decoration-none font-weight-bold">
                        وارد شوید
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
