@extends('Panel::layouts.master')

@section('head-tag')
    <title>پرداخت ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> پرداخت ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پرداخت ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="#" class="btn btn-info btn-sm disabled">پرداخت جدید</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('payment.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>کد تراکنش</th>
                            <th>بانک</th>
                            <th>پرداخت کننده</th>
                            <th>وضعیت پرداخت</th>
                            <th>نوع پرداخت</th>
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
                                    <x-panel-a-tag route="{{ route('payment.show', $payment->id) }}"
                                                   title="نمایش جزئیات پرداخت"
                                                   icon="eye" color="outline-info"/>
                                    <x-panel-a-tag route="{{ route('payment.canceled', $payment->id) }}"
                                                   title="باطل کردن پرداخت"
                                                   icon="times" color="outline-warning"/>
                                    <x-panel-a-tag route="{{ route('payment.returned', $payment->id) }}"
                                                   title="بازگرداندن پرداخت"
                                                   icon="reply" color="outline-danger"/>
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
