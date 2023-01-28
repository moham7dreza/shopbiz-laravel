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

                            @foreach ($repo->newestProducts() as $newProduct)

                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section> --}}
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $newProduct) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                <section class="product-add-to-cart">
                                                    @php
                                                        $defaultSelectedColor = !empty($newProduct->colors[0]) ? $newProduct->colors[0]->id : null;
                                                        $defaultSelectedGuarantee = !empty($newProduct->guarantees[0]) ? $newProduct->guarantees[0]->id : null;
                                                        $productIsInCart = in_array($newProduct->id, $repo->userCartItemsProductIds());
                                                    @endphp
                                                    <form
                                                        action="{{ route('customer.sales-process.add-to-cart', $newProduct) }}"
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
                                                @if ($newProduct->user->contains(auth()->id()))
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $newProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.market.add-to-favorite', $newProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                            <a class="product-link"
                                               href="{{ $newProduct->path() }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ $newProduct->imagePath() }}"
                                                         alt="{{ $newProduct->name }}">
                                                </section>
                                                <section class="product-colors"></section>
                                                <section class="product-name">
                                                    <h3>{{ $newProduct->limitedName() }}</h3></section>
                                                <section class="product-price-wrapper">
                                                    <section class="product-discount">
                                                        {{-- <span class="product-old-price">6,895,000 </span> --}}
                                                        {{-- <span class="product-discount-amount">10%</span> --}}
                                                    </section>
                                                    <section
                                                        class="product-price">{{ $newProduct->getFaPrice() }}
                                                    </section>
                                                </section>
                                                <section class="product-colors">
                                                    @foreach ($newProduct->colors()->get() as $color)
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
