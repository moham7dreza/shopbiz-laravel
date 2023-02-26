@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">

                <section class="col-md-12">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start content header -->
                        <section class="content-header my-2">
                            <h2 class="content-header-title">
                                <span>{{ \Artesaos\SEOTools\Facades\SEOMeta::getTitle() }}</span>
                            </h2>
                            <section class="content-header-link m-2">

                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="order-wrapper m-1">
                            <section class="row">
                                <section class="col-md-6 my-2 border border-secondary p-4">
                                    <form action="{{ route('customer.pages.contact-us.submit') }}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <section class="row">
                                            @php $message = $message ?? null @endphp
                                            <x-panel-input col="6" name="first_name" label="نام"
                                                           :message="$message"/>
                                            <x-panel-input col="6" name="last_name" label="نام خانوادگی"
                                                           :message="$message"/>
                                            <x-panel-input col="12" name="email" type="email" label="ایمیل"
                                                           :message="$message"/>
                                            <x-panel-input col="12" name="mobile" label=" شماره موبایل"
                                                           :message="$message"/>
                                            <x-panel-text-area col="12" name="description" label="پیام شما" rows="12"
                                                               dadClass="mb-2"
                                                               :message="$message"/>
                                            <x-panel-input col="12" type="file" name="file" label="فایل"
                                                           :message="$message"/>
                                            <x-panel-button col="12" title="ثبت"/>

                                        </section>
                                    </form>
                                </section>

                                <section class="col-md-6 my-2 p-5">
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>آدرس ایمیل</p>
                                        <p class="fw-bolder">{{ $setting->getEmail() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>شماره دفتر</p>
                                        <p class="fw-bolder">{{ $setting->getOfficePhone() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>آدرس دفتر مرکزی</p>
                                        <p class="fw-bolder">{!! $setting->getCentralOfficeAddress() !!}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>پیشنهادات و انتقادات</p>
                                        <p class="fw-bolder">{{ $setting->getMobile() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                </section>
                            </section>
                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
