@extends('Panel::layouts.master')

@section('head-tag')
    <title>پست ها</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> پست ها</li>
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
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_POST_CREATE)
                            <a href="{{ route('post.create') }}" class="btn btn-info btn-sm">ایجاد پست </a>
                        @endcan
                        <x-panel-a-tag route="{{ route('post.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('post.index') }}"/>
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
                            <th>تعداد لایک</th>
                            <th>تگ ها</th>
                            <th><x-panel-sort-btn route="permission.index" title="وضعیت" property="status"/>
</th>
                            <th>امکان درج کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($posts as $key => $post)
                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $post->getLimitedTitle() }}</td>
                                <td>{{ $post->getCategoryName() }}</td>
                                <td>
                                    <img class="admin-table-image" src="{{ $post->imagePath() }}" alt="">
                                </td>
                                <td>{{ $post->getFaPublishDate() }}</td>
                                <td>{{ $post->getFaViewsCount() }}</td>
                                <td>{{ $post->getFaLikersCount() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_POST_TAGS)
                                        <x-panel-tags :model="$post" related="tags" name="پست"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_POST_STATUS)
                                        <x-panel-checkbox class="rounded" route="post.status" method="changeStatus"
                                                          name="پست" :model="$post" property="status"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_POST_COMMENTABLE)
                                        <x-panel-checkbox class="rounded" route="post.commentable" method="commentable"
                                                          uniqueId="commentable"
                                                          name="پست" :model="$post" property="commentable"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    {{-- @can('update', $post) --}}
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
                                    @can($PERMISSION::PERMISSION_POST_TAGS)
                                        <x-panel-a-tag route="{{ route('post.tags-from', $post->id) }}"
                                                       title="افزودن تگ"
                                                       icon="tag" color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_POST_EDIT)
                                        <x-panel-a-tag route="{{ route('post.edit', $post->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_POST_DELETE)
                                        <x-panel-delete-form route="{{ route('post.destroy', $post->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
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
    @include('Share::ajax-functions.panel.status')

    @include('Share::ajax-functions.panel.commentable')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
