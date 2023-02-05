@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    @php
        $productIds = $repo->userCartItemsProductIds();
    @endphp

    @include('Home::partials.banners.slide-show-and-top-banners')

    @include('Share::wrapper.product-lazy-load', [
        'title' => 'محصولات فروش ویژه',
        'products' => $repo->productsWithActiveAmazingSales(),
        'productIds' => $productIds,
        'viewAllRoute' => route('customer.market.query-products', 'inputQuery=productsWithActiveAmazingSales')
    ])

    @include('Home::partials.banners.four-col-banners')

    @include('Share::wrapper.product-lazy-load-with-reactions-and-counters', [
        'title' => 'پربازدیدترین محصولات',
        'products' => $repo->mostVisitedProducts(),
        'productIds' => $productIds,
        'viewAllRoute' => route('customer.market.query-products', 'inputQuery=mostVisitedProducts')
    ])

    @include('Home::partials.banners.middle-banners')

    @include('Share::wrapper.product-lazy-load', [
        'title' => 'محصولات پیشنهادی',
        'products' => $repo->offerProducts(),
        'productIds' => $productIds,
        'viewAllRoute' => route('customer.market.query-products', 'inputQuery=offerProducts')
    ])

    @include('Home::partials.banners.bottom-banner')

    @include('Share::wrapper.product-lazy-load', [
        'title' => 'جدیدترین محصولات',
        'products' => $repo->newestProducts(),
        'productIds' => $productIds,
        'viewAllRoute' => route('customer.market.query-products', 'inputQuery=newestProducts')
    ])

    @include('Share::wrapper.product-lazy-load', [
        'title' => 'محبوب ترین کالاها',
        'products' => $repo->popularProducts(),
        'productIds' => $productIds,
        'viewAllRoute' => route('customer.market.query-products', 'inputQuery=popularProducts')
    ])

    @include('Home::partials.vip-posts')

    @include('Home::partials.brands')
    {{--    @include('Home::partials.banners.brand-banner')--}}

@endsection

@section('script')

    @include('Share::ajax-functions.product-add-to-favorite')
    @include('Share::ajax-functions.post-add-to-favorite')
    @include('Share::ajax-functions.product-like')
    @include('Share::ajax-functions.post-like')
{{--    @include('Home::partials.calc-rate')--}}
    @include('Share::toast-functions.swal')
    @include('Share::toast-functions.login-toast')
@endsection
