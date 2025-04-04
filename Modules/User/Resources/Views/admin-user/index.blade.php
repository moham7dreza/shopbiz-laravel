@extends('Panel::layouts.master')

@section('head-tag')
    <title>کاربران ادمین</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> کاربران ادمین</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کاربران ادمین
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_ADMIN_USER_CREATE)
                            <a href="{{ route('adminUser.create') }}" class="btn btn-info btn-sm">ایجاد ادمین جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('adminUser.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('adminUser.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'adminUser.index' @endphp
                            <th>
                                <x-panel-sort-btn :route="$route" title="کد کاربر" property="id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="ایمیل" property="email"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="شماره موبایل" property="mobile"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام" property="first_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام خانوادگی" property="last_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="فعال سازی" property="activation"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت" property="status"/>
                            </th>
                            <th>نقش</th>
                            <th>سطوح دسترسی</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($adminUsers as $admin)
                            <tr>
                                <th>{{ $admin->getFaId() }}</th>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->getFaMobileNumber() }}</td>
                                <td>{{ $admin->first_name }}</td>
                                <td>{{ $admin->last_name }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_ACTIVATION)
                                        <x-panel-checkbox class="rounded" route="adminUser.activation"
                                                          method="changeActive" uniqueId="active"
                                                          name="ادمین" :model="$admin" property="activation"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_STATUS)
                                        <x-panel-checkbox class="rounded" route="adminUser.status"
                                                          method="changeStatus"
                                                          name="ادمین" :model="$admin" property="status"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_ROLES)
                                        <x-panel-tags :model="$admin" related="roles" name="ادمین"
                                                      route="role.permission-form"
                                                      {{--                                                      toolTip="تعداد سطوح دسترسی نقش : {{ $role->permissions->count() ?? 0 }}"--}}
                                                      title="نقش"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_PERMISSIONS)
                                        <x-panel-tags :model="$admin" related="permissions" name="ادمین"
                                                      title="سطوح دسترسی"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_CHANGE_USER_TYPE)
                                        <x-panel-a-tag route="{{ route('change.user.type', $admin->id) }}"
                                                       title="تغییر نوع کاربری"
                                                       icon="times" color="outline-secondary"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_PERMISSIONS)
                                        <x-panel-a-tag route="{{ route('adminUser.permissions', $admin->id) }}"
                                                       title="سطوح دسترسی کاربر"
                                                       icon="user-check" color="outline-warning"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_ROLES)
                                        <x-panel-a-tag route="{{ route('adminUser.roles', $admin->id) }}"
                                                       title="نقش های کاربر"
                                                       icon="user-shield" color="outline-primary"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_EDIT)
                                        <x-panel-a-tag route="{{ route('adminUser.edit', $admin->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ADMIN_USER_DELETE)
                                        <x-panel-delete-form route="{{ route('adminUser.destroy', $admin->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $adminUsers->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::ajax-functions.panel.activation')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
