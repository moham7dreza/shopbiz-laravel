@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسترسی ها</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    @php $Router = \Modules\ACL\Enums\PermissionRoutesEnum::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> دسترسی ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسترسی ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_CREATE)
                            <a href="{{ route($Router::create->value) }}" class="btn btn-info btn-sm">ایجاد دسترسی
                                جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route($Router::index->value) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                        @can($PERMISSION::PERMISSION_EXCEL_FORM)
                            <x-panel-a-tag route="{{ route('permission.excel-form') }}" title="علیات اکسلی"
                                           color="outline-primary" icon="file-excel"/>
                        @endcan
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($Router::index->value) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$Router::index->value" title="نام دسترسی"/>
                            </th>
                            <th>نام نقش ها</th>
                            <th>توضیحات دسترسی</th>
                            <th>
                                <x-panel-sort-btn :route="$Router::index->value" title="تاریخ ایجاد" property="created_at"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$Router::index->value" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $key => $permission)
                            <tr>
                                <th>{{ $permission->id }}</th>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ROLES_SHOW)
                                        <x-panel-tags :model="$permission" related="roles" name="دسترسی"
                                                      title="نقش"/>
                                    @endcan
                                </td>
                                <td>{{ $permission->getLimitedDescription() }}</td>
                                <td>{{ $permission->getFaCreatedDate(true) }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_STATUS)
                                        <x-panel-checkbox class="rounded" :route="$Router::status->value"
                                                          method="changeStatus"
                                                          name="دسترسی" :model="$permission" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-12-rem text-left">
                                    @can($PERMISSION::PERMISSION_EDIT)
                                        <x-panel-a-tag route="{{ route($Router::edit->value, $permission->id) }}"
                                                       title="ویرایش آیتم" icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route($Router::destroy->value, $permission->id) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $permissions->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')
    @include('Share::ajax-functions.panel.status')
    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
