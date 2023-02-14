@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <x-share-error/>

            <section class="row">
                <section class="col">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تکمیل اطلاعات حساب کاربری</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9">
                            <form id="profile_completion"
                                  action="{{ route('customer.sales-process.profile-completion-update') }}" method="post"
                                  class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                @csrf

                                <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                         role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <section>
                                        اطلاعات حساب کاربری خود را (فقط یک بار، برای همیشه) وارد کنید. از این پس کالاها
                                        برای شخصی با این مشخصات ارسال می شود.
                                    </section>
                                </section>

                                <section class="row pb-3">
                                    @php
                                        $message = $message ?? null;
                                        $user = auth()->user();
                                    @endphp
                                    @if(empty($user->first_name))
                                        <x-panel-input col="6" name="first_name" label="نام"
                                                       :message="$message"/>
                                    @endif

                                    @if(empty($user->last_name))
                                        <x-panel-input col="6" name="last_name" label="نام خانوادگی"
                                                       :message="$message"/>
                                    @endif

                                    @if(empty($user->mobile))
                                        <x-panel-input col="6" name="mobile" label="موبایل"
                                                       :message="$message"/>
                                    @endif

                                    @if(empty($user->national_code))
                                        <x-panel-input col="6" name="national_code" label="کد ملی"
                                                       :message="$message"/>
                                    @endif

                                    @if(empty($user->email))
                                        <x-panel-input col="6" name="email" label="ایمیل (اختیاری)"
                                                       :message="$message"/>
                                    @endif
                                </section>
                            </form>

                        </section>
                        <section class="col-md-3">
                            <x-home-cart-price :cartItems="$cartItems" formId="profile_completion"
                                               buttonText="ثبت اطلاعات کاربری"/>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->
@endsection
