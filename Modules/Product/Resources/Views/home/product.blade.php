@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    @include('Product::home.partials.product-cart')

    @include('Product::home.partials.description')

{{--    @include('Product::home.partials.related-products')--}}

    @include('Share::wrapper.product-lazy-load-with-reactions-and-counters', [
                'class' => 'py-4 bg-blue-light',
        'title' => 'کالاهای مرتبط',
        'products' => $relatedProducts,
        'productIds' => $userCartItemsProductIds,
        'viewAllRoute' => route('customer.market.query-products', 'inputQuery=mostVisitedProducts')
    ])

@endsection

@section('script')

    @include('Product::home.partials.product-scripts')
@endsection
