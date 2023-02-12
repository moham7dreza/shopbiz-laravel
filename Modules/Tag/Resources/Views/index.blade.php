@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش مشترک</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> تگ ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تگ ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('tag.create') }}" class="btn btn-info btn-sm">ایجاد تگ </a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('tag.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان تگ</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $key => $tag)
                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->type ?? '-' }}</td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="tag.status" method="changeStatus"
                                                      name="تگ" :model="$tag" property="status"/>
                                </td>
                                <td class="width-16-rem text-left   ">
                                    <x-panel-a-tag route="{{ route('tag.edit', $tag->id) }}"
                                                   title="ویرایش آیتم"
                                                   icon="edit" color="outline-info"/>
                                    <x-panel-delete-form route="{{ route('tag.destroy', $tag->id) }}"
                                                         title="حذف آیتم"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
                {{ $tags->links() }}
            </section>
        </section>
    </section>

@endsection
@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
