@extends('Home::layouts.master-one-col')

@section('head-tag')
    <!-- Meta Description -->
    <meta name="description" content="{{ $user->fullName }}">
    <!-- Meta Keyword -->
    <meta name="keywords" content="{{ $user->fullName }}">

    <title>{{ $user->fullName }}</title>
@endsection

@section('content')

    @include('User::home.author.partials.user-cart')

    @include('User::home.author.partials.related-posts')

    @include('User::home.author.partials.description')

@endsection

@section('script')

    @include('User::home.author.partials.scripts')
@endsection
