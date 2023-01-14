@extends('Home::layouts.master-two-col')
@section('head-tag')
    <title>
        محصولات دسته بندی {{ $productCategory->name }}
    </title>
@endsection
@php
    $user = auth()->user();
@endphp
@section('content')
    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
        <section class="filters mb-3">
            <span class="d-inline-block border p-1 rounded bg-light">نتیجه جستجو برای : <span
                    class="badge bg-info text-dark">"کتاب اثر مرک"</span></span>
            <span class="d-inline-block border p-1 rounded bg-light">برند : <span
                    class="badge bg-info text-dark">"کتاب"</span></span>
            <span class="d-inline-block border p-1 rounded bg-light">دسته : <span
                    class="badge bg-info text-dark">"کتاب"</span></span>
            <span class="d-inline-block border p-1 rounded bg-light">قیمت از : <span class="badge bg-info text-dark">25,000 تومان</span></span>
            <span class="d-inline-block border p-1 rounded bg-light">قیمت تا : <span class="badge bg-info text-dark">360,000 تومان</span></span>

        </section>
        <section class="sort ">
            <span>مرتب سازی بر اساس : </span>
            <button class="btn btn-info btn-sm px-1 py-0" type="button">جدیدترین</button>
            <button class="btn btn-light btn-sm px-1 py-0" type="button">محبوب ترین</button>
            <button class="btn btn-light btn-sm px-1 py-0" type="button">گران ترین</button>
            <button class="btn btn-light btn-sm px-1 py-0" type="button">ارزان ترین</button>
            <button class="btn btn-light btn-sm px-1 py-0" type="button">پربازدیدترین</button>
            <button class="btn btn-light btn-sm px-1 py-0" type="button">پرفروش ترین</button>
        </section>


        <section class="main-product-wrapper row my-4">

            @foreach($products as $product)
                @php
                    if ($product->activeAmazingSales()){
                        $productNewPrice = $product->price - ($product->price * $product->activeAmazingSales()->percentage / 100);
                    }else{
                        $productNewPrice = $product->price;
                    }
                @endphp
                <section class="col-md-3 p-0">
                    <section class="product">
                        @guest
                            <section class="product-add-to-favorite">
                                <button class="btn btn-light btn-sm text-decoration-none"
                                        data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="اضافه از علاقه مندی">
                                    <i class="fa fa-heart"></i>
                                </button>
                            </section>
                        @endguest
                        @auth
                            <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                                                    data-bs-placement="left" title="افزودن به سبد خرید"><i
                                        class="fa fa-cart-plus"></i></a></section>
                            @if ($product->user->contains(auth()->user()->id))
                                <section class="product-add-to-favorite">
                                    <button class="btn btn-light btn-sm text-decoration-none"
                                            data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از علاقه مندی">
                                        <i class="fa fa-heart text-danger"></i>
                                    </button>
                                </section>
                            @else
                                <section class="product-add-to-favorite">
                                    <button class="btn btn-light btn-sm text-decoration-none"
                                            data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                            title="اضافه به علاقه مندی">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </section>
                            @endif
                        @endauth
                        <a class="product-link" href="{{ route('customer.market.product', $product) }}">
                            <section class="product-image">
                                <img class="" src="{{ asset($product->image['indexArray']['medium']) }}"
                                     alt="{{ $product->name }}">
                            </section>
                            <section class="product-colors"></section>
                            <section class="product-name"><h3>{{ Str::limit($product->name, 30) }}</h3></section>
                            <section class="product-price-wrapper">
                                @if($product->activeAmazingSales())
                                    <section class="product-discount">
                                        <span class="product-old-price">{{ priceFormat($product->price) }} تومان</span>
                                        <span
                                            class="product-discount-amount">% {{ convertEnglishToPersian($product->activeAmazingSales()->percentage) }}</span>
                                    </section>
                                @endif
                                <section class="product-price">{{ priceFormat($productNewPrice) }} تومان</section>
                            </section>
                            <section class="product-colors">
                                @foreach ($product->colors()->get() as $color)
                                    <section class="product-colors-item"
                                             style="background-color: {{ $color->color }};"></section>
                                @endforeach
                            </section>
                        </a>
                    </section>
                </section>
            @endforeach

            <section class="pt-3">{{ $products->links() }}</section>

            @if(count($products) > 20)
                <section class="col-12">
                    <section class="my-4 d-flex justify-content-center">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </section>
                </section>
            @endif
        </section>

    </section>
@endsection
