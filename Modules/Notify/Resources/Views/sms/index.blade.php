@extends('Panel::layouts.master')

@section('head-tag')
    <title>اطلاعیه پیامکی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> اطلاعیه پیامکی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        اطلاعیه پیامکی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('sms.create') }}" class="btn btn-info btn-sm">ایجاد اطلاعیه
                        پیامکی</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان اطلاعیه</th>
                            <th>متن پیامک</th>
                            <th>تاریخ ارسال</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($sms as $key => $single_sms)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $single_sms->limitedTitle() }}</td>
                                <td>{{ $single_sms->limitedBody() }}</td>
                                <td>{{ $single_sms->publishFaDate() }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $single_sms->id }}" onchange="changeStatus({{ $single_sms->id }}, 'پیامک')"
                                               data-url="{{ route('sms.status', $single_sms->id) }}"
                                               type="checkbox" @if ($single_sms->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('sms.edit', $single_sms->id) }}"
                                       class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('sms.destroy', $single_sms->id) }}"
                                          method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>
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

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
