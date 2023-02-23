@extends('Panel::layouts.master')

@section('head-tag')
    <title>برند</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> برند ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        برند ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_BRAND_CREATE)
                            <a href="{{ route('brand.create') }}" class="btn btn-info btn-sm">ایجاد برند </a>
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
                                <x-panel-sort-btn :route="$redirectRoute" title="نام فارسی برند" property="persian_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$redirectRoute" title="نام اصلی برند" property="original_name"/>
                            </th>
                            <th>لوگو</th>
                            <th>تگ ها</th>
                            <th>
                                <x-panel-sort-btn :route="$redirectRoute" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($brands as $brand)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $brand->persian_name }}</td>
                                <td>{{ $brand->original_name }}</td>
                                <td>
                                    <img src="{{ $brand->logo() }}" alt="" width="100" height="50">
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_BRAND_TAGS)
                                        <x-panel-tags :model="$brand" related="tags" name="برند"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_BRAND_STATUS)
                                        <x-panel-checkbox class="rounded" route="brand.status" method="changeStatus"
                                                          name="برند" :model="$brand" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_BRAND_TAGS)
                                        <x-panel-a-tag route="{{ route('brand.tags-from', $brand->id) }}"
                                                       title="افزودن تگ"
                                                       icon="tag" color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_BRAND_EDIT)
                                        <x-panel-a-tag route="{{ route('brand.edit', $brand->id) }}" title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_BRAND_DELETE)
                                        <x-panel-delete-form route="{{ route('brand.destroy', $brand->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $brands->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
