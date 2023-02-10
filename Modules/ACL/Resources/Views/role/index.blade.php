@extends('Panel::layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> نقش ها</li>
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
                    <a href="{{ route('role.create') }}" class="btn btn-info btn-sm">ایجاد نقش جدید</a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('role.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text" placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام نقش</th>
                            <th>دسترسی ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $key => $role)

                            <tr>
                                <th>{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if(empty($role->permissions()->get()->toArray()))
                                        <span class="text-danger">برای این نقش هیچ سطح دسترسی تعریف نشده است</span>
                                    @else
                                        @foreach($role->permissions as $permission)
                                            {{ $permission->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="role.status" method="changeStatus" name="نقش" :model="$role" property="status" />
                                </td>
                                <td class="width-22-rem text-left">
                                    <x-panel-a-tag route="{{ route('role.permission-form', $role->id) }}" title="سطوح دسترسی نقش" icon="user-graduate" color="success" />
                                    <x-panel-a-tag route="{{ route('role.edit', $role->id) }}" title="ویرایش آیتم" icon="edit" color="info" />
                                    <x-panel-delete-form route="{{ route('role.destroy', $role->id) }}" title="حذف آیتم" />
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
    @include('Share::ajax-functions.status')
    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
