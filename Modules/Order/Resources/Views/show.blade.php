@extends('Panel::layouts.master')

@section('head-tag')
    <title>فاکتور سفارش</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('order.index') }}"> سفارشات</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> فاکتور</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فاکتور
                    </h5>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px" id="printable">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr class="table-primary">
                            <th>{{ $order->getFaId() }}</th>
                            <td class="width-24-rem text-left">
                                @can($PERMISSION::PERMISSION_ORDER_PRINT)
                                    <a href="" class="btn btn-dark btn-sm text-white" id="print">
                                        <i class="fa fa-print"></i>
                                        چاپ
                                    </a>
                                @endcan
                                @can($PERMISSION::PERMISSION_ORDER_SHOW_DETAIL)
                                    <a href="{{ route('order.show.detail', $order->id) }}"
                                       class="btn btn-warning btn-sm">
                                        <i class="fa fa-book"></i>
                                        جزئیات
                                    </a>
                                @endcan
                            </td>
                        </tr>

                        <x-panel-table-row th="نام مشتری" :td="$order->getCustomerName()"/>
                        <x-panel-table-row th="آدرس" :td="$order->getCustomerAddress()"/>
                        <x-panel-table-row th="شهر" :td="$order->getCustomerCity()"/>
                        <x-panel-table-row th="کد پستی" :td="$order->getFaCustomerPostalCode()"/>
                        <x-panel-table-row th="پلاک" :td="$order->getFaCustomerNo()"/>
                        <x-panel-table-row th="واحد" :td="$order->getFaCustomerUnit()"/>
                        <x-panel-table-row th="نام گیرنده" :td="$order->getRecipientFName()"/>
                        <x-panel-table-row th="نام خانوادگی گیرنده" :td="$order->getRecipientLName()"/>
                        <x-panel-table-row th="موبایل" :td="$order->getFaCustomerMobile()"/>
                        <x-panel-table-row th="نوع پرداخت" :td="$order->paymentTypeValue()"/>
                        <x-panel-table-row th="وضعیت پرداخت" :td="$order->paymentStatusValue()"/>
                        <x-panel-table-row th="مبلغ ارسال" :td="$order->getFaOrderDeliveryAmountPrice()"/>
                        <x-panel-table-row th="وضعیت ارسال" :td="$order->deliveryStatusValue()"/>
                        <x-panel-table-row th="تاریخ ارسال" :td="$order->getFaOrderSendDate()"/>
                        <x-panel-table-row th="مجموع مبلغ سفارش (بدون تخفیف)"
                                           :td="$order->getFaOrderFinalAmountPrice()"/>
                        <x-panel-table-row th="مجموع تمامی مبلغ تخفیفات"
                                           :td="$order->getFaOrderDiscountAmountPrice()"/>
                        <x-panel-table-row th="مبلغ تخفیف همه محصولات"
                                           :td="$order->getFaOrderTotalProductsDiscountAmountPrice()"/>
                        <x-panel-table-row th="مبلغ نهایی" :td="$order->getFaOrderFinalPrice()"/>
                        <x-panel-table-row th="بانک" :td="$order->getPaymentGateway()"/>
                        <x-panel-table-row th="کوپن استفاده شده" :td="$order->getCustomerUsedCopan()"/>
                        <x-panel-table-row th="مبلغ تخفیف دریافتی از کد تخفیف"
                                           :td="$order->getFaOrderCopanDiscountAmountPrice()"/>
                        <x-panel-table-row th="تخفیف عمومی استفاده شده"
                                           :td="$order->getUsedCommonDiscountTitle()"/>
                        <x-panel-table-row th="مبلغ تخفیف عمومی"
                                           :td="$order->getFaOrderCommonDiscountAmountPrice()"/>
                        <x-panel-table-row th="وضعیت سفارش" :td="$order->orderStatusValue()"/>
                        </tbody>
                    </table>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    <script>
        var printBtn = document.getElementById('print');
        printBtn.addEventListener('click', function () {
            printContent('printable');
        })

        function printContent(el) {
            var restorePage = $('body').html();
            var printContent = $('#' + el).clone();
            $('body').empty().html(printContent);
            window.print();
            $('body').html(restorePage);
        }
    </script>

@endsection
