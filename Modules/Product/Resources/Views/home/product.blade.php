@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    @include('Product::home.partials.product-cart')

    @include('Product::home.partials.description')

    <x-home-product-lazy-load-with-reactions title="کالاهای مرتبط با سبد خرید شما" :products="$relatedProducts"
                                             :productIds="$userCartItemsProductIds"
                                             class="py-4 bg-blue-light"
                                             viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=mostVisitedProducts') }}"/>
@endsection

@section('script')

    @include('Product::home.partials.product-scripts')
@endsection
