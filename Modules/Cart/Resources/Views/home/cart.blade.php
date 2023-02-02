@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection


@section('content')

    @include('Cart::home.partials.cart-items')

    @include('Cart::home.partials.related-products')

@endsection


@section('script')

    @include('Cart::home.partials.scripts')
@endsection
