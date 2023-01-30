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
                                @php
                                    $hasFavorited = auth()->user()->hasFavorited($offerProduct);
                                @endphp
                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section> --}}
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.product.add-to-favorite', $offerProduct) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                <section class="product-add-to-cart">
                                                    @php
                                                        $defaultSelectedColor = !empty($offerProduct->colors[0]) ? $offerProduct->colors[0]->id : null;
                                                        $defaultSelectedGuarantee = !empty($offerProduct->guarantees[0]) ? $offerProduct->guarantees[0]->id : null;
                                                        $productIsInCart = in_array($offerProduct->id, $repo->userCartItemsProductIds());
                                                    @endphp
                                                    <form
                                                        action="{{ route('customer.sales-process.add-to-cart', $offerProduct) }}"
                                                        method="post" data-bs-toggle="tooltip"
                                                        data-bs-placement="left"
                                                        title="{{ $productIsInCart ? 'کالا در حال حاظر در سبد خرید شما موجود است' : 'افزودن به سبد خرید' }}">
                                                        @csrf
                                                        <input type="hidden" name="color_id" value="{{ $defaultSelectedColor }}">
                                                        <input type="hidden" name="guarantee_id" value="{{ $defaultSelectedGuarantee }}">
                                                        <input type="hidden" name="number" value="1">
                                                        <button type="submit"
                                                                class="btn btn-light btn-sm add-to-cart-btn {{ $productIsInCart ? 'text-danger' : '' }}">
                                                            <i class="fa fa-cart-plus"></i>
                                                        </button>
                                                    </form>
                                                </section>
                                                @if ($hasFavorited)
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $offerProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-bookmark text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $offerProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-bookmark"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                            <a class="product-link"
                                               href="{{ $offerProduct->path() }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ $offerProduct->imagePath() }}"
                                                         alt="{{ $offerProduct->name }}">
                                                </section>
                                                <section class="product-colors"></section>
                                                <section class="product-name">
                                                    <h3>{{ $offerProduct->limitedName() }}</h3></section>
                                                <section class="product-price-wrapper">
                                                    <section class="product-discount">
                                                        {{-- <span class="product-old-price">6,895,000 </span> --}}
                                                        {{-- <span class="product-discount-amount">10%</span> --}}
                                                    </section>
                                                    <section
                                                        class="product-price">{{ $offerProduct->getFaPrice() }}
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
