@extends('Panel::layouts.master')

@section('head-tag')
    <title>ادمین تیکت</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ادمین تیکت</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ادمین تیکت
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a class="btn btn-info btn-sm disabled">ایجاد ادمین تیکت </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('ticket-admin.index') }}" class="d-flex">
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
                            <th>نام ادمین</th>
                            <th>ایمیل ادمین</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($admins as $key => $admin)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $admin->fullName }}</td>
                                <td>{{ $admin->email }}</td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('ticket-admin.set', $admin->id) }}"
                                       class="btn btn-{{ $admin->ticketCssStatus() }} btn-sm"><i
                                            class="fa fa-{{ $admin->ticketIconStatus() }}"></i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $admins->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
