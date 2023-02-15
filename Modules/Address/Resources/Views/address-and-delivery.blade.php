@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')
    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تکمیل اطلاعات ارسال کالا (آدرس گیرنده، مشخصات گیرنده، نحوه ارسال) </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">

                        <x-share-error />

                        <section class="col-md-9">
                            @include('Address::partials.address-select')

                            @include('Address::partials.delivery-select')
                        </section>

                        <section class="col-md-3">
                            <form action="{{ route('customer.sales-process.choose-address-and-delivery') }}"
                                  method="post" id="myForm">
                                @csrf
                            </form>
                            <x-home-cart-price :cartItems="$cartItems" formId="myForm"
                                               buttonText="پرداخت و تکمیل فرآیند خرید"/>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->

@endsection

@section('script')
    @include('Share::ajax-functions.home.address')
@endsection
