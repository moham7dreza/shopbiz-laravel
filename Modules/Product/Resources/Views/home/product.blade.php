@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    @include('Product::home.partials.product-cart')

    @include('Product::home.partials.related-products')

    @include('Product::home.partials.description')

@endsection

@section('script')

    @include('Product::home.partials.product-scripts')
@endsection
