@extends('Panel::layouts.master')

@section('head-tag')
    <title>قرار ملاقات</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> قرار ملاقات</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        قرار ملاقات
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a href="#" class="btn btn-info btn-sm disabled">ایجاد قرار ملاقات </a>
                        <x-panel-a-tag route="{{ route('appointment.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('appointment.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'appointment.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="عنوان" property="subject"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام" property="first_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام خانوادگی" property="last_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="ایمیل" property="email"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="موبایل" property="phone"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="زمان ملاقات" property="meet_date"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت تایید" property="approved"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت فرم" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($appointments as $appointment)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $appointment->getLimitedSubject() }}</td>
                                <td>{{ $appointment->first_name }}</td>
                                <td>{{ $appointment->last_name }}</td>
                                <td>{{ $appointment->email }}</td>
                                <td>{{ $appointment->getFaPhone() }}</td>
                                <td>{{ $appointment->getFaMeetTime() }}</td>
                                <td>{{ $appointment->getFaApprovedText() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_APPOINTMENT_STATUS)
                                        <x-panel-checkbox class="rounded" route="appointment.status"
                                                          method="changeStatus"
                                                          name="ملاقات" :model="$appointment" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_APPOINTMENT_SHOW)
                                        <x-panel-a-tag route="{{ route('appointment.show', $appointment->id) }}"
                                                       title="نمایش ملاقات"
                                                       icon="eye" color="outline-primary"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_APPOINTMENT_APPROVED)
                                        <x-panel-a-tag route="{{ route('appointment.approved', $appointment->id) }}"
                                                       title="{{ $appointment->getFaChangeApprovedText() }}"
                                                       icon="{{ $appointment->getApprovedIcon() }}"
                                                       color="outline-{{ $appointment->getApprovedColor() }}"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $appointments->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection
@section('script')

    @include('Share::ajax-functions.panel.status')

@endsection
