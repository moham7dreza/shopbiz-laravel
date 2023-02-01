@extends('Panel::layouts.master')

@section('head-tag')
    <title>پست ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">پست ها</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پست ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('post.create') }}" class="btn btn-info btn-sm">ایجاد پست </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('post.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text" placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان پست</th>
                            <th>دسته</th>
                            <th>تصویر</th>
                            <th>تاریخ انتشار</th>
                            <th>تعداد بازدید</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th>امکان درج کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($posts as $key => $post)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $post->limitedTitle() }}</td>
                                <td>{{ $post->textCategoryName() }}</td>
                                <td>
                                    <img class="admin-table-image" src="{{ $post->imagePath() }}" alt="">
                                </td>
                                <td>{{ $post->publishFaDate() }}</td>
                                <td>{{ $post->getFaViewsCount() }}</td>
                                <td>
                                    @if(empty($post->tags()->get()->toArray()))
                                        <span class="text-danger">برای این پست هیچ تگی تعریف نشده است</span>
                                    @else
                                        @foreach($post->tags as $tag)
                                            {{ $tag->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <label>
                                        <input id="{{ $post->id }}" onchange="changeStatus({{ $post->id }}, 'پست')"
                                               data-url="{{ route('post.status', $post->id) }}" type="checkbox"
                                               @if ($post->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>

                                <td>
                                    <label>
                                        <input id="{{ $post->id }}-commentable" onchange="commentable({{ $post->id }}, 'پست')"
                                               data-url="{{ route('post.commentable', $post->id) }}" type="checkbox"
                                               @if ($post->commentable === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('post.tags-from', $post->id) }}"
                                       class="btn btn-info btn-sm"><i class="fa fa-tag"></i></a>

                                    {{-- @can('update', $post) --}}
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    {{-- @elsecan('create', Modules\Post\Entities\Post\Post::class) --}}
                                    {{-- @else --}}
                                    {{--                                    <a disabled="disabled" class="btn btn-danger btn-sm disabled"><i--}}
                                    {{--                                            class="fa fa-edit"></i> دسترسی ندارید</a>--}}
                                    {{-- @endcan --}}
                                    {{-- @cannot('update', $post)
                                        <h1>برو بیرون</h1>
                                    @endcannot --}}
                                    {{-- @if(Auth::user()->can('upate', $post))
                                    @endif --}}
                                    {{-- @canany(['update', 'create', 'delete'], $post)
                                    @elsecanany(['view'])

                                    @endcanany --}}
                                    <form class="d-inline" action="{{ route('post.destroy', $post->id) }}"
                                          method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $posts->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')
    @include('Share::ajax-functions.status')
    @include('Share::ajax-functions.commentable')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
