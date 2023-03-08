@extends('Panel::layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    @php $index_route = 'role.index'; @endphp
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
                            <a href="{{ route('role.create') }}" class="btn btn-info btn-sm">ایجاد نقش جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route($index_route) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                        @can($PERMISSION::PERMISSION_ROLE_EXCEL_FORM)
                            <x-panel-a-tag route="{{ route('role.excel-form') }}" title="علیات اکسلی"
                                           color="outline-primary" icon="file-excel"/>
                        @endcan
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($index_route) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="نام نقش"/>
                            </th>
                            <th>دسترسی ها</th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="تاریخ ایجاد"
                                                  property="created_at"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="وضعیت" property="status"/>
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
                                <td>{{ $role->getFaCreatedDate(true) }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ROLE_STATUS)
                                        <x-panel-checkbox class="rounded" route="role.status"
                                                          method="changeStatus"
                                                          name="نقش" :model="$role" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-22-rem text-left">
                                    @can($PERMISSION::PERMISSION_ROLE_PERMISSIONS)
                                        <x-panel-a-tag route="{{ route('role.permission-form', $role->id) }}"
                                                       title="سطوح دسترسی نقش" icon="user-graduate"
                                                       color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ROLE_EDIT)
                                        <x-panel-a-tag route="{{ route('role.edit', $role->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ROLE_DELETE)
                                        <x-panel-delete-form route="{{ route('role.destroy', $role->id) }}"
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
