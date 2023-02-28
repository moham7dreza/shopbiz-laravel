@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')
    <section class="" id="printable">

        <!-- start cart -->
        <section class="mb-4">
            <section class="container-xxl">
                <section class="row">
                    <section class="col">
                        <!-- start content header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>مشخصات سفارش</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>

                        <section class="row mt-4">
                            <section class="col-md-8 mb-3">
                                <section class="content-wrapper bg-white p-3 rounded-2">
                                    @foreach ($order->orderItems as $orderItem)
                                        <section class="cart-item d-md-flex py-3">
                                            @php $product = $orderItem->singleProduct @endphp
                                            <section class="cart-img align-self-start flex-shrink-1">
                                                <a href="{{ $product->path() }}">
                                                    <img src="{{ $product->imagePath() }}"
                                                         alt="{{ $product->name }}"
                                                         `title="{{ $product->getTagLessIntroduction() }}"
                                                         data-bs-toggle="tooltip"
                                                         data-bs-placement="top" `>
                                                </a>
                                            </section>
                                            <section class="align-self-start w-100">
                                                <section class="d-flex">
                                                    <p class="fw-bold me-3">{{ $product->name }}</p>
                                                    <section class="product-rate">
                                                        <span class="text-muted">(</span>
                                                        <span><i class="fa fa-star text-yellow" title="محبوبیت"
                                                                 data-bs-toggle="tooltip"
                                                                 data-bs-placement="top"></i></span>
                                                        <strong
                                                            class="text-muted">{{ $product->getFaProductRating() }}</strong>
                                                        <span class="text-muted">)</span>
                                                    </section>
                                                </section>
                                                <p>
                                                    @if (!empty($orderItem->color))
                                                        @php $color = $orderItem->color @endphp
                                                        <span style="background-color: {{ $color->getColorCode() }};"
                                                              class="cart-product-selected-color me-1"
                                                              title="افزایش قیمت : {{ $color->getFaPriceIncrease() }}"
                                                              data-bs-toggle="tooltip"
                                                              data-bs-placement="top">
                                                </span>
                                                        <span title="رنگ"
                                                              data-bs-toggle="tooltip"
                                                              data-bs-placement="top">{{ $color->getColorName() }}</span>
                                                    @else
                                                        <span>رنگ منتخب وجود ندارد</span>
                                                    @endif
                                                </p>
                                                <p>
                                                    @if (!empty($orderItem->guarantee))
                                                        @php $guarantee = $orderItem->guarantee @endphp
                                                        <i class="fa fa-shield-alt cart-product-selected-warranty me-1"
                                                           title="افزایش قیمت : {{ $guarantee->getFaPriceIncrease() }}"
                                                           data-bs-toggle="tooltip"
                                                           data-bs-placement="top"></i>
                                                        <span title="گارانتی"
                                                              data-bs-toggle="tooltip"
                                                              data-bs-placement="top">{{ $guarantee->getFaFullName() }}</span>
                                                    @else
                                                        <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                        <span title="گارانتی"
                                                              data-bs-toggle="tooltip"
                                                              data-bs-placement="top"> گارانتی ندارد</span>
                                                    @endif
                                                </p>

                                            </section>
                                            <section class="align-self-end flex-shrink-1">
                                                @if ($product->activeAmazingSales())
                                                    <section class="cart-item-discount text-danger text-nowrap mb-1">
                                                        تخفیف :
                                                        {{ $product->getFaProductDiscountPrice() }}</section>
                                                @endif
                                                <section class="text-nowrap fw-bold">
                                                    {{ $product->getFaPrice() }}
                                                </section>
                                            </section>
                                        </section>
                                    @endforeach
                                </section>

                            </section>
                            <section class="col-md-4">
                                <section class="content-wrapper bg-blue-light p-3 rounded-2 cart-total-price">
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>کد سفارش</p>
                                        <p class="fw-bolder">{{ $order->getFaId() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>مبلغ نهایی</p>
                                        <p class="fw-bolder">{{ $order->getFaOrderFinalPrice() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>مبلغ تخفیف همه محصولات</p>
                                        <p class="fw-bolder">{{ $order->getFaOrderTotalProductsDiscountAmountPrice() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>حمل و نقل</p>
                                        <p class="fw-bolder">{{ $order->getFaDeliveryMethod() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>وضعیت ارسال</p>
                                        <p class="fw-bolder">{{ $order->deliveryStatusValue() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>نوع پرداخت</p>
                                        <p class="fw-bolder">{{ $order->paymentTypeValue() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>تاریخ پرداخت</p>
                                        <p class="fw-bolder">{{ $order->getFaPayDate() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>وضعیت سفارش</p>
                                        <p class="fw-bolder">{{ $order->orderStatusValue() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>پرینت</p>
                                        <a href="" class="btn btn-outline-dark btn-sm mb-2" id="print" title="چاپ اطلاعات"
                                           data-bs-toggle="tooltip" data-bs-placement="top">
                                            <i class="fa fa-print"></i>
                                            چاپ
                                        </a>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex align-items-center justify-content-between">
                                        <p>پرینت</p>
                                        <a href="{{ route('order.received.pdf', $order) }}}" class="btn btn-outline-dark btn-sm mb-2" title="چاپ اطلاعات"
                                           data-bs-toggle="tooltip" data-bs-placement="top">
                                            <i class="fa fa-print"></i>
                                            چاپ
                                        </a>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>

            </section>
        </section>
        <!-- end cart -->

        <!-- start cart -->
        <section class="mb-4">
            <section class="container-xxl">
                <section class="row">
                    <section class="col">
                        <!-- start content header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>آدرس صورتحساب</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>

                        <section class="row mt-4">
                            <section class="col-md-12 mb-3">
                                <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p>نام کاربر</p>
                                        <p>{{ $order->getCustomerName() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p>آدرس کاربر</p>
                                        <p>{{ $order->address->generateFullAddress() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p>کد پستی</p>
                                        <p>{{ $order->getFaCustomerPostalCode() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p>شماره موبایل</p>
                                        <p>{{ $order->user->getFaMobileNumber() }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p>پست الکترونیک</p>
                                        <p>{{ $order->user->email }}</p>
                                    </section>
                                    <section class="border-bottom mb-3"></section>
                                </section>
                            </section>
                        </section>
                    </section>
                </section>

            </section>
        </section>
        <!-- end cart -->
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
