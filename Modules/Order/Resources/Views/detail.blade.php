@extends('Panel::layouts.master')

@section('head-tag')
    <title>جزئیات سفارش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> جزئیات سفارش</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        جزئیات سفارش</>
                    </h5>
                </section>


                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام محصول</th>
                            <th>درصد فروش فوق العاده</th>
                            <th>مبلغ فروش فوق العاده</th>
                            <th>تعداد</th>
                            <th>جمع قیمت محصول</th>
                            <th>مبلغ نهایی</th>
                            <th>رنگ</th>
                            <th>گارانتی</th>
                            <th>ویژگی</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($order->orderItems as $item)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $item->getProductName() }}</td>
                                <td>{{ $item->getFaAmazingSalePercentage() }}</td>
                                <td>{{ $item->getFaOrderItemAmazingSaleDiscountAmountPrice() }} تومان</td>
                                <td>{{ $item->orderItemFaNumber() }} </td>
                                <td>{{ $item->getFaOrderItemFinalProductPrice() }}</td>
                                <td>{{ $item->getFaOrderItemFinalTotalPrice() }}</td>
                                <td>{{ $item->getOrderItemColorName() }}</td>
                                <td>{{ $item->getOrderItemGuaranteeName() }}</td>
                                <td>
                                    @forelse($item->orderItemAttributes as $attribute)
                                        {{ $attribute->generateAttributeDescription() }}
                                        <br/>
                                    @empty
                                        -
                                    @endforelse
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </section>

            </section>
        </section>
    </section>

@endsection
