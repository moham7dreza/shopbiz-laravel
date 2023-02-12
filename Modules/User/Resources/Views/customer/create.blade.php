@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد کاربر مشتری</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('customerUser.index') }}"> مشتریان</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد کاربر مشتری</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد کاربر مشتری
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('customerUser.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('customerUser.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="first_name" label="نام"
                                           :message="$message"/>
                            <x-panel-input col="10" name="last_name" label="نام خانوادگی"
                                           :message="$message"/>
                            <x-panel-input col="10" name="email" type="email" label="ایمیل"
                                           :message="$message"/>
                            <x-panel-input col="10" name="mobile" label=" شماره موبایل"
                                           :message="$message"/>
                            <x-panel-input col="10" type="password" name="password" label="کلمه عبور"
                                           :message="$message"/>
                            <x-panel-input col="10" type="password" name="password_confirmation" label="تکرار کلمه عبور"
                                           :message="$message"/>
                            <x-panel-input col="10" type="file" name="profile_photo_path" label="تصویر"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="activation" label="وضعیت فعالسازی"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>
            </section>
        </section>
@endsection
