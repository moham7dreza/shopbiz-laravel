@extends('Panel::layouts.master')

@section('head-tag')
    <title>پیج ساز</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوا</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> پیج ساز</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پیج ساز
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('page.create') }}" class="btn btn-info btn-sm">ایجاد پیج جدید</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('page.index') }}" />
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>تگ ها</th>
                            <th>اسلاگ</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $page->getLimitedTitle() }}</td>
                                <td>{{ $page->tags }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="page.status" method="changeStatus"
                                                      name="دسترسی" :model="$page" property="status"/>
                                </td>
                                <td class="width-16-rem text-left">
                                    <x-panel-a-tag route="{{ route('page.edit', $page->id) }}"
                                                   title="ویرایش آیتم"
                                                   icon="edit" color="info"/>
                                    <x-panel-delete-form route="{{ route('page.destroy', $page->id) }}"
                                                         title="حذف آیتم"/>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $pages->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
