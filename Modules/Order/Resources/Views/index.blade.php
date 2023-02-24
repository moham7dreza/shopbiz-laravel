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
            <li class="breadcrumb-item font-size-16"><a href="#"> سفارشات</a></li>
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
                        <a href="#" class="btn btn-info btn-sm disabled">ایجاد سفارش </a>
                        <x-panel-a-tag route="{{ route($route) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($route) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="کد سفارش" property="id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="مجموع مبلغ سفارش (بدون تخفیف)"
                                                  property="order_final_amount"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="مجموع تمامی مبلغ تخفیفات"
                                                  property="order_discount_amount"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="مبلغ تخفیف همه محصولات"
                                                  property="order_total_products_discount_amount"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="مبلغ نهایی" property="order_final_amount"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت پرداخت" property="payment_status"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="شیوه پرداخت" property="payment_type"/>
                            </th>
                            <th>بانک</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت ارسال" property="delivery_status"/>
                            </th>
                            <th>شیوه ارسال</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت سفارش" property="order_status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $order->getFaId() }}</td>
                                <td>{{ $order->getFaOrderFinalAmountPrice() }}</td>
                                <td>{{ $order->getFaOrderDiscountAmountPrice() }}</td>
                                <td>{{ $order->getFaOrderTotalProductsDiscountAmountPrice() }}</td>
                                <td>{{ $order->getFaOrderFinalPrice() }}</td>
                                <td>{{ $order->paymentStatusValue() }}</td>
                                <td>{{ $order->paymentTypeValue() }}</td>
                                <td>{{ $order->getPaymentGateway() }}</td>
                                <td>{{ $order->deliveryStatusValue() }}</td>
                                <td>{{ $order->getDeliveryMethodName() }}</td>
                                <td>{{ $order->orderStatusValue() }}</td>
                                <td class="width-8-rem text-left">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-success btn-sm btn-block dorpdown-toggle"
                                           role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <i class="fa fa-tools"></i> عملیات
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @can($PERMISSION::PERMISSION_ORDER_SHOW)
                                                <a href="{{ route('order.show', $order->id) }}"
                                                   class="dropdown-item text-right"><i
                                                        class="fa fa-images text-success"></i> مشاهده
                                                    فاکتور</a>
                                            @endcan
                                            @can($PERMISSION::PERMISSION_ORDER_CHANGE_SEND_STATUS)
                                                <a href="{{ route('order.changeSendStatus', $order->id) }}"
                                                   class="dropdown-item text-right"><i
                                                        class="fa fa-list-ul text-warning"></i> تغییر
                                                    وضعیت ارسال</a>
                                            @endcan
                                            @can($PERMISSION::PERMISSION_ORDER_CHANGE_STATUS)
                                                <a href="{{ route('order.changeOrderStatus', $order->id) }}"
                                                   class="dropdown-item text-right"><i
                                                        class="fa fa-edit text-primary"></i> تغییر وضعیت
                                                    سفارش</a>
                                            @endcan
                                            @can($PERMISSION::PERMISSION_ORDER_CANCEL)
                                                <a href="{{ route('order.cancelOrder', $order->id) }}"
                                                   class="dropdown-item text-right"><i
                                                        class="fa fa-window-close text-danger"></i> باطل
                                                    کردن سفارش</a>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $orders->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
