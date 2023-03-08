@extends('Panel::layouts.master')

@section('head-tag')
    <title>داشبورد سوم</title>
@endsection

@section('content')

    @can('permission admin panel')

        @can('permission panel alerts')
            @include('Panel::partials.alerts')
        @endcan

        @can('permission panel sales charts')
            @include('Panel::partials.sales-charts')
        @endcan

    @endcan
@endsection

@section('script')
    @include('Panel::partials.chart-js-scripts')
@endsection
