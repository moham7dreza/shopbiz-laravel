@extends('Panel::layouts.master')

@section('head-tag')
    <title>اطلاعیه ایمیلی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> اطلاعیه ایمیلی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        اطلاعیه ایمیلی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('email.create') }}" class="btn btn-info btn-sm">ایجاد اطلاعیه
                        ایمیلی</a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('email.index') }}" class="d-flex">
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
                            <th>عنوان اطلاعیه</th>
                            <th>متن ایمیل</th>
                            <th>تاریخ ارسال</th>
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
                                    <label>
                                        <input id="{{ $email->id }}" onchange="changeStatus({{ $email->id }}, 'ایمیل')"
                                               data-url="{{ route('email.status', $email->id) }}"
                                               type="checkbox" @if ($email->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('email-file.index', $email) }}"
                                       class="btn btn-warning btn-sm"><i class="fa fa-file"></i></a>
                                    <a href="{{ route('email.edit', $email->id) }}"
                                       class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('email.destroy', $email->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>
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

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
