@extends('Panel::layouts.master')

@section('head-tag')
    <title>ادمین گفتوگو</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('chat.index') }}"> گفتوگو</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ادمین گفتوگو</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ادمین گفتوگو
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a class="btn btn-info btn-sm disabled">ایجاد ادمین گفتوگو </a>
                        <x-panel-a-tag route="{{ route('chat-admin.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('chat-admin.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'chat-admin.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام ادمین" property="id"/>
                            </th>
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
{{--                                    @can($PERMISSION::PERMISSION_ADMIN_TICKET_ADD)--}}
                                        <x-panel-a-tag route="{{ route('chat-admin.set', $admin->id) }}"
                                                       title="{{ $admin->ticketCssStatus() == 'success' ? 'اضافه به لیست ادمین ها' : 'حذف از لیست ادمین ها' }}"
                                                       icon="{{ $admin->ticketIconStatus() }}"
                                                       color="{{ $admin->ticketCssStatus() }}"/>
{{--                                    @endcan--}}
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
