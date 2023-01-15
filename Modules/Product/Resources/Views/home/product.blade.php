@extends('Home::layouts.master-one-col')

@section('head-tag')
    <title>{{ $product->name }}</title>
@endsection

@section('content')

    @include('Product::home.partials.product-cart')

    @include('Product::home.partials.related-products')

    @include('Product::home.partials.description')

    {{--@include('Product::home.partials.toast')--}}

@endsection

@section('script')

    @include('Product::home.partials.product-scripts')
@endsection
