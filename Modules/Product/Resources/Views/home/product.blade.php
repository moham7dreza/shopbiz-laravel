@extends('Home::layouts.master-one-col')

@section('head-tag')
    <!-- Meta Description -->
    <meta name="description" content="{!! $product->tagLessIntro() !!}">
    <!-- Meta Keyword -->
    <meta name="keywords" content="{{ $product->tags }}">

    <title>{{ $product->name }}</title>
@endsection

@section('content')

    @include('Product::home.partials.product-cart')

    @include('Product::home.partials.related-products')

    @include('Product::home.partials.description')

@endsection

@section('script')

    @include('Product::home.partials.product-scripts')
@endsection
