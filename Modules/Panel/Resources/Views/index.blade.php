@extends('Panel::layouts.master')

@section('head-tag')
    <title>داشبورد اصلی</title>
@endsection

@section('content')
    @can('permission-super-admin')
        @include('Panel::partials.counter-cards')
        @include('Panel::partials.alerts')
        @include('Panel::partials.latest-comments')
        @include('Panel::partials.sales-charts')
    @endcan
@endsection

@section('script')
    @include('Panel::partials.chart-js-scripts')
@endsection
