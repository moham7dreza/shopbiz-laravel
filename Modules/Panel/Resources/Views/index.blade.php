@extends('Panel::layouts.master')

@section('head-tag')
    <title>داشبورد اصلی</title>
@endsection

@section('content')

    @can('permission admin panel')

        @can('permission panel counter cards')
            @include('Panel::partials.counter-cards')
        @endcan

        @can('permission panel alerts')
            @include('Panel::partials.alerts')
        @endcan

        @can('permission panel sales charts')
            @include('Panel::partials.sales-charts')
        @endcan

        @can('permission panel activity log')
            @include('Panel::partials.activity-log')
        @endcan

        @can('permission panel latest comments')
            @include('Panel::partials.latest-comments')
        @endcan

        @can('permission panel users log')
            @include('Panel::partials.users')
        @endcan

    @endcan
@endsection

@section('script')
    @include('Panel::partials.chart-js-scripts')
@endsection
