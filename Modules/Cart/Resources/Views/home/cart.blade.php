@extends('Home::layouts.master-one-col')

@section('head-tag')
    <title>سبد خرید شما</title>
@endsection


@section('content')

    @include('Cart::home.partials.cart-items')

    @include('Cart::home.partials.related-products')

@endsection


@section('script')

    @include('Cart::home.partials.scripts')
@endsection
