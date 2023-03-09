@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    @php $productIds = $repo->userCartItemsProductIds(); @endphp

    @include('Home::partials.banners.slide-show-and-top-banners')
{{--@include('Home::partials.product-lazy-load')--}}
    <x-home-product-lazy-load title="محصولات فروش ویژه" :products="$repo->productsWithActiveAmazingSales()"
                              :productIds="$productIds" class="py-4 bg-white"
                              viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=productsWithActiveAmazingSales') }}"/>

    @include('Home::partials.banners.four-col-banners')

    <x-home-product-lazy-load-with-reactions title="پربازدیدترین محصولات" :products="$repo->mostVisitedProducts()"
                              :productIds="$productIds" class="py-4 bg-blue-light"
                              viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=mostVisitedProducts') }}"/>

    @include('Home::partials.banners.middle-banners')

    <x-home-product-lazy-load title="محصولات پیشنهادی" :products="$repo->offerProducts()"
                              :productIds="$productIds"
                              viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=offerProducts') }}"/>

    @include('Home::partials.banners.bottom-banner')

    <x-home-product-lazy-load title="جدیدترین محصولات" :products="$repo->newestProducts()"
                              :productIds="$productIds" class="py-4 bg-white"
                              viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=newestProducts') }}"/>

    <x-home-product-lazy-load title="محبوب ترین کالاها" :products="$repo->popularProducts()"
                              :productIds="$productIds" class="py-4 bg-green-light"
                              viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=popularProducts') }}"/>

    @include('Home::partials.banners.slider-banner')

    @include('Home::partials.vip-posts')

    @include('Home::partials.brands')
    {{--    @include('Home::partials.banners.brand-banner')--}}
    @include('Home::partials.chat')
@endsection

@section('script')

    @include('Share::ajax-functions.home.product-add-to-favorite')
    @include('Share::ajax-functions.home.post-add-to-favorite')
    @include('Share::ajax-functions.home.product-like')
    @include('Share::ajax-functions.home.post-like')
    {{--    @include('Home::partials.calc-rate')--}}
    @include('Share::toast-functions.swal')
    @include('Share::toast-functions.login-toast')
@endsection
