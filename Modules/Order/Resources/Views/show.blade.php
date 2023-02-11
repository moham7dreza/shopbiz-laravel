@extends('Panel::layouts.master')

@section('head-tag')
    <title>فاکتور سفارش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">بخش فروش</a></li>
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
                                <a href="" class="btn btn-dark btn-sm text-white" id="print">
                                    <i class="fa fa-print"></i>
                                    چاپ
                                </a>
                                <a href="{{ route('order.show.detail', $order->id) }}"
                                   class="btn btn-warning btn-sm">
                                    <i class="fa fa-book"></i>
                                    جزئیات
                                </a>
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>نام مشتری</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getCustomerName() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>آدرس</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getCustomerAddress() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>شهر</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getCustomerCity() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کد پستی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaCustomerPostalCode() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>پلاک</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaCustomerNo() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>واحد</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaCustomerUnit() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام گیرنده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getRecipientFName() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام خانوادگی گیرنده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getRecipientLName() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>موبایل</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaCustomerMobile() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نوع پرداخت</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->paymentTypeValue() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت پرداخت</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->paymentStatusValue() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderDeliveryAmountPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->deliveryStatusValue() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تاریخ ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderSendDate() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع مبلغ سفارش (بدون تخفیف)</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderFinalAmountPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع تمامی مبلغ تخفیفات</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderDiscountAmountPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ تخفیف همه محصولات</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderTotalProductsDiscountAmountPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ نهایی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderFinalPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>بانک</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getPaymentGateway() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کوپن استفاده شده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getCustomerUsedCopan() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف کد تخفیف</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderCopanDiscountAmountPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف عمومی استفاده شده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getUsedCommonDiscountTitle() }}
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>مبلغ تخفیف عمومی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->getFaOrderCommonDiscountAmountPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت سفارش</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderStatusValue() }}
                            </td>
                        </tr>

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
