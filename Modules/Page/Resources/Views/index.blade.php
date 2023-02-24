@extends('Panel::layouts.master')

@section('head-tag')
    <title>پیج ساز</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
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
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_FAQ_CREATE)
                            <a href="{{ route('page.create') }}" class="btn btn-info btn-sm">ایجاد پیج جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('page.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('page.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn route="page.index" title="عنوان" property="title"/>
                            </th>
                            <th>تگ ها</th>
                            <th>اسلاگ</th>
                            <th>
                                <x-panel-sort-btn route="page.index" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $page->getLimitedTitle() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PAGE_TAGS)
                                        <x-panel-tags :model="$page" related="tags" name="پیج"/>
                                    @endcan
                                </td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PAGE_STATUS)
                                        <x-panel-checkbox class="rounded" route="page.status" method="changeStatus"
                                                          name="پیج ساز" :model="$page" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_PAGE_TAGS)
                                        <x-panel-a-tag route="{{ route('page.tags-from', $page->id) }}"
                                                       title="افزودن تگ"
                                                       icon="tag" color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PAGE_EDIT)
                                        <x-panel-a-tag route="{{ route('page.edit', $page->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PAGE_DELETE)
                                        <x-panel-delete-form route="{{ route('page.destroy', $page->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
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
