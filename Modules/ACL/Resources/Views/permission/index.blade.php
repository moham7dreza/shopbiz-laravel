@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسترسی ها</title>
@endsection

@section('content')

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
                    <a href="{{ route('permission.create') }}" class="btn btn-info btn-sm">ایجاد دسترسی جدید</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('permission.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام دسترسی</th>
                            <th>نام نقش ها</th>
                            <th>توضیحات دسترسی</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $key => $permission)
                            <tr>
                                <th>{{ $permission->id }}</th>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @if(empty($permission->roles()->get()->toArray()))
                                        <span class="text-danger">برای این دسترسی هیچ نقشی تعریف نشده است</span>
                                    @else
                                        @foreach($permission->roles as $role)
                                            {{ $role->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $permission->getLimitedDescription() }}</td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="permission.status" method="changeStatus"
                                                      name="دسترسی" :model="$permission" property="status"/>
                                </td>
                                <td class="width-12-rem text-left">
                                    <x-panel-a-tag route="{{ route('permission.edit', $permission->id) }}"
                                                   title="ویرایش آیتم" icon="edit" color="info"/>
                                    <x-panel-delete-form route="{{ route('permission.destroy', $permission->id) }}"
                                                         title="حذف آیتم"/>
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
