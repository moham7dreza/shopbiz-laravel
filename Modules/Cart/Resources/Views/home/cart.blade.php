@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection


@section('content')

    @if(session()->has('products'))
        <ul class="list-style-none">
            @foreach(session()->get('products') as $product)
                @if($product->marketable_number == 0)
                    <li class="alert alert-danger list-style-none font-size-80">
                        موجودی محصول <strong>{{ $product->name }}</strong> به <strong>اتمام</strong> رسید.
                    </li>
                @else
                    <li class="alert alert-danger list-style-none font-size-80">
                        از محصول <strong>{{ $product->name }}</strong> فقط به تعداد
                        <strong>{{ convertEnglishToPersian($product->marketable_number) }}</strong> عدد موجود است.
                    </li>
                @endif
            @endforeach
        </ul>
    @endif

    @include('Cart::home.partials.cart-items')

    <x-home-product-lazy-load-with-reactions title="کالاهای مرتبط با سبد خرید شما" :products="$relatedProducts"
                                             :productIds="$cartItems->pluck('product_id')->toArray()"
                                             class="py-4 bg-blue-light"
                                             viewAllRoute="{{ route('customer.market.query-products', 'inputQuery=mostVisitedProducts') }}"/>
@endsection


@section('script')

    @include('Cart::home.partials.scripts')

@endsection
