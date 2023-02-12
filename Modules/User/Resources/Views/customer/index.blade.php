@extends('Panel::layouts.master')

@section('head-tag')
    <title>مشتریان</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> مشتریان</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        مشتریان
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('customerUser.create') }}" class="btn btn-info btn-sm">ایجاد مشتری جدید</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('customerUser.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>کد کاربر</th>
                            <th>ایمیل</th>
                            <th>شماره موبایل</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>فعال سازی</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th>{{ $user->getFaId() }}</th>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getFaMobileNumber() }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="customerUser.activation"
                                                      method="changeActive" uniqueId="active"
                                                      name="مشتری" :model="$user" property="activation"/>
                                </td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="customerUser.status" method="changeStatus"
                                                      name="مشتری" :model="$user" property="status"/>
                                </td>
                                <td class="width-16-rem text-left">
                                    <x-panel-a-tag route="{{ route('customerUser.edit', $user->id) }}"
                                                   title="ویرایش آیتم"
                                                   icon="edit" color="outline-info"/>
                                    <x-panel-delete-form route="{{ route('customerUser.destroy', $user->id) }}"
                                                         title="حذف آیتم"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $users->links() }}</section>
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
