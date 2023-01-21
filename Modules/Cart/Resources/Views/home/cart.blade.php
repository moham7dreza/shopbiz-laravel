@extends('Home::layouts.master-one-col')

@section('head-tag')
    <!-- Meta Description -->
    <meta name="description" content="سبد خرید کاربر">
    <!-- Meta Keyword -->
    <meta name="keywords" content="سبد خرید">

    <title>سبد خرید شما</title>
@endsection


@section('content')

    @include('Cart::home.partials.cart-items')

    @include('Cart::home.partials.related-products')

@endsection


@section('script')

    @include('Cart::home.partials.scripts')
@endsection
