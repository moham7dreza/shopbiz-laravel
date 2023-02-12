@extends('Panel::layouts.master')

@section('head-tag')
    <title>نمایش پرداخت</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('payment.index') }}"> پرداخت</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> نمایش پرداخت</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش پرداخت
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('payment.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section class="card mb-3">
                    <section class="card-header text-white bg-custom-yellow">
                        {{ $payment->getCustomerName() }} - {{ $payment->getFaCustomerId()  }}
                    </section>
                    <section class="card-body">
                        <h5 class="card-title"> مبلغ : {{ $payment->getFaPaymentAmountPrice() }}</h5>
                        <p class="card-text"> بانک : {{ $payment->getPaymentGateway() }}</p>
                        <p class="card-text"> شماره پرداخت : {{ $payment->getFaTransactionId() }}</p>
                        <p class="card-text"> تاریخ پرداخت : {{ $payment->getFaPayDate() }}</p>
                        <p class="card-text"> دریافت کننده : {{ $payment->getCashReceiverName() }}</p>
                    </section>
                </section>

            </section>
        </section>
    </section>

@endsection
