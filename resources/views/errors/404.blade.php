@extends('Home::layouts.master-one-col')

@section('head-tag')
    <title>یافت نشد.</title>
@endsection

@section('content')
    <div class="main-wrap">
        <main class="position-relative">
            <div class="container">
                <div class="row mb-30">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <div class="content-404 text-center mb-30 d-flex flex-column align-items-center justify-content-around h-100">
                            <h1 class="mb-30">{{ convertEnglishToPersian(404) }}</h1>
                            <p>صفحه مورد نظر شما یافت نشد.</p>
                            <p class="text-muted">ممکن است آدرس را اشتباه تایپ کرده باشید یا از پیوند قدیمی استفاده کرده باشید :) </p>
                            <p>بازدید از <a class="text-decoration-none text-danger" href="{{ route('customer.home') }}">صفحه نخست</a> یا در مورد مشکل <a class="text-decoration-none text-danger" href="contact.html">با ما تماس بگیرید</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
