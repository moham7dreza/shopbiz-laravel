@if(count($repo->productsWithActiveAmazingSales()) > 0)
    <!-- start product lazy load -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start content header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>محصولات فروش ویژه</span>
                                </h2>
                                <section class="content-header-link">
                                    <a href="{{ route('customer.market.query-products', 'inputQuery=productsWithActiveAmazingSales') }}">مشاهده
                                        همه</a>
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->
                        <section class="lazyload-wrapper">
                            <section class="lazyload light-owl-nav owl-carousel owl-theme">
                                @foreach($repo->productsWithActiveAmazingSales() as $amazingSale)
                                    @php
                                        $activeAmazingSaleProduct = $amazingSale->product;
                                        $productNewPrice = $activeAmazingSaleProduct->price - ($activeAmazingSaleProduct->price * $amazingSale->percentage / 100);
                                    @endphp
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $activeAmazingSaleProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه از علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endguest
                                                @auth
                                                    <section class="product-add-to-cart"><a href="#"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-placement="left"
                                                                                            title="افزودن به سبد خرید"><i
                                                                class="fa fa-cart-plus"></i></a></section>
                                                    @if ($activeAmazingSaleProduct->user->contains(auth()->user()->id))
                                                        <section class="product-add-to-favorite">
                                                            <button
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $activeAmazingSaleProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                                <i class="fa fa-heart text-danger"></i>
                                                            </button>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <button
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $activeAmazingSaleProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                                <i class="fa fa-heart"></i>
                                                            </button>
                                                        </section>
                                                    @endif
                                                @endauth

                                                <a class="product-link"
                                                   href="{{ route('customer.market.product', $activeAmazingSaleProduct) }}">
                                                    <section class="product-image">
                                                        <img class=""
                                                             src="{{ asset($activeAmazingSaleProduct->image['indexArray']['large']) }}"
                                                             alt="{{ $activeAmazingSaleProduct->name }}">
                                                    </section>
                                                    <section class="product-colors"></section>
                                                    <section class="product-name">
                                                        <h3>{{ Str::limit($activeAmazingSaleProduct->name) }}</h3>
                                                    </section>
                                                    <section class="product-price-wrapper">
                                                        <section class="product-discount">
                                                            <span class="product-old-price">{{ priceFormat($activeAmazingSaleProduct->price) }} تومان</span>
                                                            <span
                                                                class="product-discount-amount">% {{ convertEnglishToPersian($amazingSale->percentage) }}</span>
                                                        </section>
                                                        <section
                                                            class="product-price">{{ priceFormat($productNewPrice) }}
                                                            تومان
                                                        </section>
                                                    </section>
                                                    <section class="product-colors">
                                                        @foreach ($activeAmazingSaleProduct->colors()->get() as $color)
                                                            <section class="product-colors-item"
                                                                     style="background-color: {{ $color->color }};"></section>
                                                        @endforeach
                                                    </section>
                                                </a>
                                            </section>
                                        </section>
                                    </section>
                                @endforeach
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
@endif

<!-- start ads section -->
<section class="">
    <section class="container-xxl">
        <!-- four column-->
        <section class="row py-4">
            @foreach ($repo->fourColumnBanners() as $colBanner)
                <section class="col">
                    <a href="{{ urldecode($colBanner->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ asset($colBanner->image) }}"
                             alt="{{ $colBanner->title }}">
                    </a>
                </section>
            @endforeach
        </section>
    </section>
</section>
<!-- end ads section -->

<!-- start product lazy load -->
<section class="mb-3">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>پربازدیدترین کالاها</span>
                            </h2>
                            <section class="content-header-link">
                                <a href="{{ route('customer.market.query-products', 'inputQuery=mostVisitedProducts') }}">مشاهده
                                    همه</a>
                            </section>
                        </section>
                    </section>
                    <!-- start content header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">

                            @foreach ($repo->mostVisitedProducts() as $mostVisitedProduct)

                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section> --}}
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $mostVisitedProduct) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه از علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if ($mostVisitedProduct->user->contains(auth()->user()->id))
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $mostVisitedProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $mostVisitedProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth

                                            <a class="product-link"
                                               href="{{ route('customer.market.product', $mostVisitedProduct) }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ asset($mostVisitedProduct->image['indexArray']['medium']) }}"
                                                         alt="{{ $mostVisitedProduct->name }}">
                                                </section>
                                                <section class="product-colors"></section>
                                                <section class="product-name">
                                                    <h3>{{ Str::limit($mostVisitedProduct->name, 10) }}</h3>
                                                </section>
                                                <section class="product-price-wrapper">
                                                    <section class="product-discount">
                                                        {{-- <span class="product-old-price">6,895,000 </span> --}}
                                                        {{-- <span class="product-discount-amount">10%</span> --}}
                                                    </section>
                                                    <section
                                                        class="product-price">{{ priceFormat($mostVisitedProduct->price) }}
                                                        تومان
                                                    </section>
                                                </section>
                                                <section class="product-colors">
                                                    @foreach ($mostVisitedProduct->colors()->get() as $color)
                                                        <section class="product-colors-item"
                                                                 style="background-color: {{ $color->color }};"></section>
                                                    @endforeach
                                                </section>
                                            </a>
                                        </section>
                                    </section>
                                </section>
                            @endforeach

                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end product lazy load -->


<!-- start ads section -->
<section class="mb-3">
    <section class="container-xxl">
        <!-- two column-->
        <section class="row py-4">
            @foreach ($repo->middleBanners() as $middleBanner)
                <section class="col-12 col-md-6 mt-2 mt-md-0">
                    <a href="{{ urldecode($middleBanner->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ asset($middleBanner->image) }}"
                             alt="{{ $middleBanner->title }}">
                    </a>
                </section>
            @endforeach

        </section>

    </section>
</section>
<!-- end ads section -->


<!-- start product lazy load -->
<section class="mb-3">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>پیشنهاد آمازون به شما</span>
                            </h2>
                            <section class="content-header-link">
                                <a href="{{ route('customer.market.query-products', 'inputQuery=offerProducts') }}">مشاهده
                                    همه</a>
                            </section>
                        </section>
                    </section>
                    <!-- start content header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">

                            @foreach ($repo->offerProducts() as $offerProduct)

                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section> --}}
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $offerProduct) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه از علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if ($offerProduct->user->contains(auth()->user()->id))
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $offerProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $offerProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                            <a class="product-link"
                                               href="{{ route('customer.market.product', $offerProduct) }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ asset($offerProduct->image['indexArray']['medium']) }}"
                                                         alt="{{ $offerProduct->name }}">
                                                </section>
                                                <section class="product-colors"></section>
                                                <section class="product-name">
                                                    <h3>{{ Str::limit($offerProduct->name, 10) }}</h3></section>
                                                <section class="product-price-wrapper">
                                                    <section class="product-discount">
                                                        {{-- <span class="product-old-price">6,895,000 </span> --}}
                                                        {{-- <span class="product-discount-amount">10%</span> --}}
                                                    </section>
                                                    <section
                                                        class="product-price">{{ priceFormat($offerProduct->price) }}
                                                        تومان
                                                    </section>
                                                </section>
                                                <section class="product-colors">
                                                    @foreach ($offerProduct->colors()->get() as $color)
                                                        <section class="product-colors-item"
                                                                 style="background-color: {{ $color->color }};"></section>
                                                    @endforeach
                                                </section>
                                            </a>
                                        </section>
                                    </section>
                                </section>
                            @endforeach

                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end product lazy load -->


@if(!empty($repo->bottomBanner()))
    <!-- start ads section -->
    <section class="mb-3">
        <section class="container-xxl">
            <!-- one column -->
            <section class="row py-4">
                <section class="col">
                    <a href="{{ urldecode($repo->bottomBanner()->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ asset($repo->bottomBanner()->image) }}"
                             alt="{{ $repo->bottomBanner()->title }}">
                    </a>
                </section>
            </section>

        </section>
    </section>
    <!-- end ads section -->

@endif

<!-- start product lazy load -->
<section class="mb-3">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>جدیدترین محصولات</span>
                            </h2>
                            <section class="content-header-link">
                                <a href="{{ route('customer.market.query-products', 'inputQuery=newestProducts') }}">مشاهده
                                    همه</a>
                            </section>
                        </section>
                    </section>
                    <!-- end content header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">

                            @foreach ($repo->newestProducts() as $offerProduct)

                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section> --}}
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $offerProduct) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه از علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                <section class="product-add-to-cart"><a href="#"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="left"
                                                                                        title="افزودن به سبد خرید"><i
                                                            class="fa fa-cart-plus"></i></a></section>
                                                @if ($offerProduct->user->contains(auth()->user()->id))
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $offerProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $offerProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                            <a class="product-link"
                                               href="{{ route('customer.market.product', $offerProduct) }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ asset($offerProduct->image['indexArray']['medium']) }}"
                                                         alt="{{ $offerProduct->name }}">
                                                </section>
                                                <section class="product-colors"></section>
                                                <section class="product-name">
                                                    <h3>{{ Str::limit($offerProduct->name, 30) }}</h3></section>
                                                <section class="product-price-wrapper">
                                                    <section class="product-discount">
                                                        {{-- <span class="product-old-price">6,895,000 </span> --}}
                                                        {{-- <span class="product-discount-amount">10%</span> --}}
                                                    </section>
                                                    <section
                                                        class="product-price">{{ priceFormat($offerProduct->price) }}
                                                        تومان
                                                    </section>
                                                </section>
                                                <section class="product-colors">
                                                    @foreach ($offerProduct->colors()->get() as $color)
                                                        <section class="product-colors-item"
                                                                 style="background-color: {{ $color->color }};"></section>
                                                    @endforeach
                                                </section>
                                            </a>
                                        </section>
                                    </section>
                                </section>
                            @endforeach

                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end product lazy load -->

<!-- start ads section -->
<section class="mb-3">
    <section class="container-xxl">
        <!-- two column-->
        <section class="row py-4">
            @foreach ($repo->bottomMiddleBanners() as $middleBanner)
                <section class="col-12 col-md-6 mt-2 mt-md-0">
                    <a href="{{ urldecode($middleBanner->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ asset($middleBanner->image) }}"
                             alt="{{ $middleBanner->title }}">
                    </a>
                </section>
            @endforeach

        </section>

    </section>
</section>
<!-- end ads section -->

<!-- start brand part-->
<section class="brand-part mb-4 py-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start content header -->
                <section class="content-header">
                    <section class="d-flex align-items-center">
                        <h2 class="content-header-title">
                            <span>برندهای ویژه</span>
                        </h2>
                    </section>
                </section>
                <!-- start content header -->
                <section class="brands-wrapper py-4">
                    <section class="brands dark-owl-nav owl-carousel owl-theme">
                        @foreach ($repo->brands() as $brand)

                            <section class="item">
                                <section class="brand-item">
                                    <a href="#">
                                        <img class="rounded-2"
                                             src="{{ asset($brand->logo['indexArray']['medium']) }}" alt="">
                                    </a>
                                </section>
                            </section>

                        @endforeach

                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end brand part-->


@if(!empty($repo->brandsBanner()))
    <!-- start ads section -->
    <section class="mb-3">
        <section class="container-xxl">
            <!-- one column -->
            <section class="row py-4">
                <section class="col">
                    <a href="{{ urldecode($repo->brandsBanner()->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ asset($repo->brandsBanner()->image) }}"
                             alt="{{ $repo->brandsBanner()->title }}">
                    </a>
                </section>
            </section>

        </section>
    </section>
    <!-- end ads section -->

@endif
