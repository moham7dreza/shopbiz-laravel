@extends('Panel::layouts.master')

@section('head-tag')
<title>داشبورد اصلی</title>
@endsection

@section('content')
    @include('Panel::partials.counter-cards')
    @include('Panel::partials.alerts')
    @include('Panel::partials.latest-comments')
    @include('Panel::partials.sales-charts')
@endsection

@section('script')
    @include('Panel::partials.chart-js-scripts')
@endsection
