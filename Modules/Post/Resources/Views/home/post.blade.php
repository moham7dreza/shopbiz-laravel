@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')

    @include('Post::home.partials.post-cart')

    @include('Post::home.partials.related-posts')

    @include('Post::home.partials.description')

@endsection

@section('script')

    @include('Post::home.partials.post-scripts')
@endsection
