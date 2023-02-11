@extends('Panel::layouts.master')

@section('head-tag')
    <title>مشتریان</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">بخش کاربران</a></li>
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
                        <form action="{{ route('customerUser.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text" placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
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
                        @foreach ($users as $key => $user)

                            <tr>
                                <th>{{ $user->getFaId() }}</th>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getFaMobileNumber() }}</td>
                                <td>{{ $user->first_name }}</td>
                                <td>{{ $user->last_name }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $user->id }}-active" onchange="changeActive({{ $user->id }}, 'مشتری')"
                                               data-url="{{ route('customerUser.activation', $user->id) }}"
                                               type="checkbox" @if ($user->activation === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td>
                                    <label>
                                        <input id="{{ $user->id }}" onchange="changeStatus({{ $user->id }}, 'مشتری')"
                                               data-url="{{ route('customerUser.status', $user->id) }}" type="checkbox"
                                               @if ($user->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('customerUser.edit', $user->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('customerUser.destroy', $user->id) }}"
                                          method="post">
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
