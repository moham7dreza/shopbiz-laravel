@extends('Home::layouts.master-profile')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                @include('Home::layouts.partials.profile-sidebar')
                <main id="main-body" class="main-body col-md-9">
                    <x-share-error/>
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start content header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>اطلاعات حساب</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="d-flex justify-content-end my-4">
                            <a class="btn btn-link btn-sm text-info text-decoration-none mx-1" data-bs-toggle="modal"
                               data-bs-target="#edit-profile"><i class="fa fa-edit px-1"></i>ویرایش حساب</a>
                        </section>

                        <section class="row">
                            <section class="col-6 border-bottom mb-2 py-2">
                                <section class="field-title">نام</section>
                                <section
                                    class="field-value overflow-auto">{{ auth()->user()->first_name ?? '-' }}</section>
                            </section>

                            <section class="col-6 border-bottom my-2 py-2">
                                <section class="field-title">نام خانوادگی</section>
                                <section
                                    class="field-value overflow-auto">{{ auth()->user()->last_name ?? '-' }}</section>
                            </section>

                            <section class="col-6 border-bottom my-2 py-2">
                                <section class="field-title">شماره تلفن همراه</section>
                                <section
                                    class="field-value overflow-auto">{{ auth()->user()->getFaMobileNumber() ?? '-' }}</section>
                            </section>
                            <section class="d-flex justify-content-between col-6 border-bottom my-2 py-2">
                                <section class="">
                                    <section class="field-title">ایمیل</section>
                                    <section
                                        class="field-value overflow-auto">{{ auth()->user()->email ?? '-' }}</section>
                                </section>
                                @if(is_null(auth()->user()->email_verified_at))
                                    <section>
                                        <a href="{{ route('auth.verify.email.should') }}"
                                           class="btn btn-outline-success btn-sm"
                                           title="برای انجام خرید و پرداخت باید ایمیل خود را تایید کنید"
                                           data-bs-toggle="tooltip" data-bs-placement="top">تایید ایمیل</a>
                                    </section>
                                @endif
                            </section>


                            <section class="col-6 my-2 py-2">
                                <section class="field-title">کد ملی</section>
                                <section
                                    class="field-value overflow-auto">{{ auth()->user()->getFaNationalCode() ?? '-' }}
                                </section>
                            </section>
                        </section>

                        <section class="modal fade high-z-index" id="edit-profile" tabindex="-1"
                                 aria-labelledby="edit-profile-label"
                                 aria-hidden="true">
                            <section class="modal-dialog">
                                <section class="modal-content">
                                    <section class="modal-header">
                                        <h5 class="modal-title" id="edit-profile-label"><i class="fa fa-plus"></i>
                                            ویرایش
                                            حساب </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </section>
                                    <section class="modal-body">
                                        <form class="row" method="post" id="update-profile-form"
                                              action="{{ route('customer.profile.profile.update') }}">
                                            @csrf
                                            @method('PUT')

                                            <section class="col-6 mb-2">
                                                <label for="first_name" class="form-label mb-1">نام
                                                    گیرنده</label>
                                                <input
                                                    value="{{ auth()->user()->first_name ?? '-' }}"
                                                    type="text" name="first_name" class="form-control form-control-sm"
                                                    id="first_name" placeholder="نام">
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="last_name" class="form-label mb-1">نام
                                                    خانوادگی گیرنده</label>
                                                <input
                                                    value="{{ auth()->user()->last_name ?? '-' }}"
                                                    type="text" name="last_name" class="form-control form-control-sm"
                                                    id="last_name" placeholder="نام خانوادگی ">
                                            </section>

                                            <section class="col-6 mb-2">
                                                <label for="national_code" class="form-label mb-1">کد ملی
                                                </label>
                                                <input
                                                    value="{{ auth()->user()->national_code ?? '-' }}"
                                                    type="text" name="national_code"
                                                    class="form-control form-control-sm"
                                                    id="national_code" placeholder="کد ملی">
                                            </section>
                                        </form>
                                    </section>
                                    <section class="modal-footer py-1">
                                        <button type="submit" class="btn btn-sm btn-primary"
                                                onclick="document.getElementById('update-profile-form').submit();">
                                            ویرایش
                                            حساب
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-dismiss="modal">بستن
                                        </button>
                                    </section>
                                </section>
                            </section>
                        </section>
                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
