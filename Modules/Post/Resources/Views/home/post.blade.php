@extends('Home::layouts.master-one-col')

@section('head-tag')
    <!-- Meta Description -->
    <meta name="description" content="{!! $post->tagLessSummary() !!}">
    <!-- Meta Keyword -->
    <meta name="keywords" content="{{ $post->tags }}">

    <title>{{ $post->name }}</title>
@endsection

@section('content')

    @include('Post::home.partials.post-cart')

    @include('Post::home.partials.related-posts')

    @include('Post::home.partials.description')

@endsection

@section('script')

    @include('Post::home.partials.post-scripts')
@endsection
