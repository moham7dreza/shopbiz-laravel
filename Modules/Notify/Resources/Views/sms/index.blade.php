@extends('Panel::layouts.master')

@section('head-tag')
    <title>اطلائیه پیامکی</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> اطلائیه پیامکی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        اطلائیه پیامکی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_SMS_NOTIFY_CREATE)
                            <a href="{{ route('sms.create') }}" class="btn btn-info btn-sm">ایجاد اطلائیه
                                پیامکی</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('sms.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('sms.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان اطلائیه</th>
                            <th>متن پیامک</th>
                            <th>تاریخ ارسال</th>
                            <th>ارسال شده</th>
                            <th><x-panel-sort-btn route="permission.index" title="وضعیت" property="status"/>
</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sms as $key => $single_sms)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $single_sms->getLimitedTitle() }}</td>
                                <td>{!! $single_sms->getLimitedBody(100) !!}</td>
                                <td>{{ $single_sms->getFaPublishDateWithTime() }}</td>
                                <td>
                                    @if($single_sms->sentStatus())
                                        <span class="text-success font-size-16 mr-4"><i class="fa fa-check"></i></span>
                                    @else
                                        <span class="text-danger font-size-16 mr-4"><i class="fa fa-times"></i></span>
                                    @endif
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_SMS_NOTIFY_STATUS)
                                        <x-panel-checkbox class="rounded" route="sms.status" method="changeStatus"
                                                          name="پیامک" :model="$single_sms" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_SMS_NOTIFY_EDIT)
                                        <x-panel-a-tag route="{{ route('sms.edit', $single_sms->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_SMS_NOTIFY_DELETE)
                                        <x-panel-delete-form route="{{ route('sms.destroy', $single_sms->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $sms->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
