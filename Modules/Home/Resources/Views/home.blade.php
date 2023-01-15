@extends('Home::layouts.master-one-col')


@section('content')

    @include('Home::partials.slide-show')
    @include('Home::partials.content')
{{--    @include('Home.partials.toast')--}}
@endsection

@section('script')
    @include('Home::partials.scripts')
@endsection
