@extends('Panel::layouts.master')

@section('head-tag')
    <title>داشبورد دوم</title>
@endsection

@section('content')

    @can('permission admin panel')

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
