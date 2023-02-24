@extends('Home::layouts.master-simple')

@section('head-tag')

@endsection

@section('content')

    <section class="vh-100 d-flex justify-content-center align-items-start captcha">

        <section class="d-flex flex-column align-items-center mx-5 gap-4">
            <h1>
                در حال بررسی مرورگر، پیش از انتقال به سایت هستیم ...
            </h1>
            <p>
                برای دسترسی به وب‌سایت موردنظر، گزینه زیر را تایید کنید.
            </p>
            <section>
                {!! NoCaptcha::display() !!}
            </section>
        </section>
    </section>

@endsection

@section('script')
{{--    {!! NoCaptcha::renderJs('fa') !!}--}}
{!! NoCaptcha::renderJs('fa', false, 'recaptchaCallback') !!}

@endsection
