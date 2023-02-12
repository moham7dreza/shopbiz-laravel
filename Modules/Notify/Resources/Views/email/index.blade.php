@extends('Panel::layouts.master')

@section('head-tag')
    <title>اطلائیه ایمیلی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> اطلائیه ایمیلی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        اطلائیه ایمیلی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('email.create') }}" class="btn btn-info btn-sm">ایجاد اطلائیه
                        ایمیلی</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('email.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان اطلائیه</th>
                            <th>متن ایمیل</th>
                            <th>تاریخ ارسال</th>
                            <th>ارسال شده</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($emails as $key => $email)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $email->getLimitedSubject() }}</td>
                                <td>{!! $email->getLimitedBody() !!}</td>
                                <td>{{ $email->getFaPublishDateWithTime() }}</td>
                                <td>
                                    @if($email->sentStatus())
                                        <span class="text-success font-size-16 mr-4"><i class="fa fa-check"></i></span>
                                    @else
                                        <span class="text-danger font-size-16 mr-4"><i class="fa fa-times"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="email.status" method="changeStatus"
                                                      name="ایمیل" :model="$email" property="status"/>
                                </td>
                                <td class="width-16-rem text-left">
                                    <x-panel-a-tag route="{{ route('email-file.index', $email->id) }}"
                                                   title="افزودن ضمیمه"
                                                   icon="file" color="outline-warning"/>
                                    <x-panel-a-tag route="{{ route('email.edit', $email->id) }}"
                                                   title="ویرایش آیتم"
                                                   icon="edit" color="outline-info"/>
                                    <x-panel-delete-form route="{{ route('email.destroy', $email->id) }}"
                                                         title="حذف آیتم"/>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $emails->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
