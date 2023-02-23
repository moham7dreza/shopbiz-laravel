@extends('Panel::layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    @php $ROLE = \Modules\ACL\Entities\Role::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> نقش ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نقش ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_ROLE_CREATE)
                            <a href="{{ route($ROLE::ROUTE_CREATE) }}" class="btn btn-info btn-sm">ایجاد نقش جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route($ROLE::ROUTE_INDEX) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($ROLE::ROUTE_INDEX) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$ROLE::ROUTE_INDEX" title="نام نقش"/>
                            </th>
                            <th>دسترسی ها</th>
                            <th>
                                <x-panel-sort-btn :route="$ROLE::ROUTE_INDEX" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $key => $role)
                            <tr>
                                <th>{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ROLE_PERMISSIONS)
                                        <x-panel-tags :model="$role" related="permissions" name="نقش"
                                                      title="سطح دسترسی"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ROLE_STATUS)
                                        <x-panel-checkbox class="rounded" :route="$ROLE::ROUTE_STATUS" method="changeStatus"
                                                          name="نقش" :model="$role" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-22-rem text-left">
                                    @can($PERMISSION::PERMISSION_ROLE_PERMISSIONS)
                                        <x-panel-a-tag route="{{ route($ROLE::ROUTE_PERMISSIONS_FORM, $role->id) }}"
                                                       title="سطوح دسترسی نقش" icon="user-graduate"
                                                       color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ROLE_EDIT)
                                        <x-panel-a-tag route="{{ route($ROLE::ROUTE_EDIT, $role->id) }}" title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ROLE_DELETE)
                                        <x-panel-delete-form route="{{ route($ROLE::ROUTE_DELETE, $role->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $roles->links() }}</section>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
