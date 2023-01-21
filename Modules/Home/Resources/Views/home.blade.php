@extends('Home::layouts.master-one-col')

@section('head-tag')
    <!-- Meta Description -->
    <meta name="description" content="{{ $repo->siteSetting()->description }}">
    <!-- Meta Keyword -->
    <meta name="keywords" content="{{ $repo->siteSetting()->keywords }}">
@endsection

@section('content')

    @include('Home::partials.preloader')

    @include('Home::partials.slide-show-and-top-banners')

    @include('Home::partials.amazing-sales-products')

    @include('Home::partials.four-col-banners')

    @include('Home::partials.most-visited-products')

    @include('Home::partials.middle-banners')

    @include('Home::partials.offered-products')

    @include('Home::partials.bottom-banner')

    @include('Home::partials.newest-products')

    @include('Home::partials.brands')

    @include('Home::partials.brand-banner')

{{--    @include('Home.partials.toast')--}}
@endsection

@section('script')
    @include('Home::partials.scripts')
@endsection
