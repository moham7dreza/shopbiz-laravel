@extends('Panel::layouts.master')

@section('head-tag')
    <title>گارانتی</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> گارانتی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        گارانتی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_GUARANTEE_CREATE)
                            <a href="{{ route('guarantee.create') }}" class="btn btn-info btn-sm">ایجاد
                                گارانتی جدید </a>
                        @endcan
                        <x-panel-a-tag route="{{ route('guarantee.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('guarantee.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            @php $route = 'guarantee.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="عنوان گارانتی"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="اعتبار پیشفرض گارانتی"
                                                  property="default_duration"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="آدرس URL وبسایت" property="website_link"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($guarantees as $guarantee)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $guarantee->name }}</td>
                                <td>{{ $guarantee->getFaDurationTime() }}</td>
                                <td>{{ $guarantee->website_link }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_GUARANTEE_STATUS)
                                        <x-panel-checkbox class="rounded" route="guarantee.status"
                                                          method="changeStatus"
                                                          name="گارانتی کالا" :model="$guarantee" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-center">
                                    @can($PERMISSION::PERMISSION_GUARANTEE_EDIT)
                                        <x-panel-a-tag
                                            route="{{ route('guarantee.edit', $guarantee->id) }}"
                                            title="ویرایش آیتم"
                                            icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_GUARANTEE_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('guarantee.destroy', $guarantee->id) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $guarantees->links() }}</section>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
