@extends('Panel::layouts.master')

@section('head-tag')
    <title>فاکتور سفارش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> فاکتور</li>
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
                            <th>{{ $order->faOrderId() }}</th>
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
                                {{ $order->customerName() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>آدرس</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->textCustomerAddress() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>شهر</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->textCustomerCity() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کد پستی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->customerPostalCode() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>پلاک</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->customerNo() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>واحد</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->customerUnit() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام گیرنده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->recipientFName() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام خانوادگی گیرنده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->recipientLName() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>موبایل</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->customerFaMobile() }}
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
                                {{ $order->orderDeliveryAmountFaPrice() }}
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
                                {{ $order->orderSendDate() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع مبلغ سفارش (بدون تخفیف)</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderFinalAmountFaPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع تمامی مبلغ تخفیفات</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderDiscountAmountFaPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ تخفیف همه محصولات</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderTotalProductsDiscountAmountFaPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ نهایی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderFinalFaPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>بانک</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->paymentGateway() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کوپن استفاده شده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->customerUsedCopan() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف کد تخفیف</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderCopanDiscountAmountFaPrice() }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف عمومی استفاده شده</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->usedCommonDiscountTitle() }}
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>مبلغ تخفیف عمومی</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->orderCommonDiscountAmountFaPrice() }}
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
