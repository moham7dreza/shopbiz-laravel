@extends('Panel::layouts.master')

@section('head-tag')
    <title>{{ $title }}</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> پرداخت ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> {{ $title }}</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        {{ $title }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a href="#" class="btn btn-info btn-sm disabled">پرداخت جدید</a>
                        <x-panel-a-tag route="{{ route($route) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($route) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="کد تراکنش" property="id"/>
                            </th>
                            <th>بانک</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="پرداخت کننده" property="user_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت پرداخت" property="status"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نوع پرداخت" property="type"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($payments as $payment)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $payment->getFaTransactionId() }}</td>
                                <td>{{ $payment->getPaymentGateway() }}</td>
                                <td>{{ $payment->getCustomerName() }}</td>
                                <td>{{ $payment->paymentStatusValue() }}</td>
                                <td>{{ $payment->paymentTypeValue() }}</td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_PAYMENT_SHOW)
                                        <x-panel-a-tag route="{{ route('payment.show', $payment->id) }}"
                                                       title="نمایش جزئیات پرداخت"
                                                       icon="eye" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PAYMENT_CANCEL)
                                        <x-panel-a-tag route="{{ route('payment.canceled', $payment->id) }}"
                                                       title="باطل کردن پرداخت"
                                                       icon="times" color="outline-warning"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PAYMENT_RETURN)
                                        <x-panel-a-tag route="{{ route('payment.returned', $payment->id) }}"
                                                       title="بازگرداندن پرداخت"
                                                       icon="reply" color="outline-danger"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $payments->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
