@extends('Panel::layouts.master')

@section('head-tag')
    <title>بنر ها</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> بنر ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        بنر ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_BANNER_CREATE)
                            <a href="{{ route('banner.create') }}" class="btn btn-info btn-sm">ایجاد بنر </a>
                        @endcan
                        <x-panel-a-tag route="{{ route($redirectRoute) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($redirectRoute) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$redirectRoute" title="عنوان بنر" property="title"/>
                            </th>
                            <th>تصویر</th>
                            <th>
                                <x-panel-sort-btn :route="$redirectRoute" title="آدرس" property="url" class="text-left"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$redirectRoute" title="وضعیت" property="status"
                                                  class="text-center"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$redirectRoute" title="مکان" property="position"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($banners as $key => $banner)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $banner->getLimitedTitle() }}</td>
                                <td>
                                    <img src="{{ $banner->image() }}" alt="" width="100" height="50">
                                </td>
                                <td class="text-left dir-ltr">{{ $banner->url }}</td>
                                <td class="text-center">
                                    @can($PERMISSION::PERMISSION_BANNER_STATUS)
                                        <x-panel-checkbox class="rounded" route="banner.status" method="changeStatus"
                                                          name="بنر" :model="$banner" property="status"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_BANNER_LOCATION_SHOW)
                                        {{ $banner->getFaPosition() }}
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_BANNER_EDIT)
                                        <x-panel-a-tag route="{{ route('banner.edit', $banner->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_BANNER_DELETE)
                                        <x-panel-delete-form route="{{ route('banner.destroy', $banner->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $banners->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
