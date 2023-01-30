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
                                        $hasFavorited = auth()->user()->hasFavorited($activeAmazingSaleProduct);
                                    @endphp
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $activeAmazingSaleProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endguest
                                                @auth
                                                    <section class="product-add-to-cart">
                                                        @php
                                                            $defaultSelectedColor = !empty($activeAmazingSaleProduct->colors[0]) ? $activeAmazingSaleProduct->colors[0]->id : null;
                                                            $defaultSelectedGuarantee = !empty($activeAmazingSaleProduct->guarantees[0]) ? $activeAmazingSaleProduct->guarantees[0]->id : null;
                                                            $productIsInCart = in_array($activeAmazingSaleProduct->id, $repo->userCartItemsProductIds());
                                                        @endphp
                                                        <form
                                                            action="{{ route('customer.sales-process.add-to-cart', $activeAmazingSaleProduct) }}"
                                                            method="post" data-bs-toggle="tooltip"
                                                            data-bs-placement="left"
                                                            title="{{ $productIsInCart ? 'کالا در حال حاظر در سبد خرید شما موجود است' : 'افزودن به سبد خرید' }}">
                                                            @csrf
                                                            <input type="hidden" name="color_id"
                                                                   value="{{ $defaultSelectedColor }}">
                                                            <input type="hidden" name="guarantee_id"
                                                                   value="{{ $defaultSelectedGuarantee }}">
                                                            <input type="hidden" name="number" value="1">
                                                            <button type="submit"
                                                                    class="btn btn-light btn-sm add-to-cart-btn {{ $productIsInCart ? 'text-danger' : '' }}">
                                                                <i class="fa fa-cart-plus"></i>
                                                            </button>
                                                        </form>
                                                    </section>
                                                    @if ($hasFavorited)
                                                        <section class="product-add-to-favorite">
                                                            <button
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $activeAmazingSaleProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                                <i class="fa fa-bookmark text-danger"></i>
                                                            </button>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <button
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $activeAmazingSaleProduct) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                                <i class="fa fa-bookmark"></i>
                                                            </button>
                                                        </section>
                                                    @endif
                                                @endauth

                                                <a class="product-link"
                                                   href="{{ $activeAmazingSaleProduct->path() }}">
                                                    <section class="product-image">
                                                        <img class=""
                                                             src="{{ $amazingSale->productImagePath() }}"
                                                             alt="{{ $activeAmazingSaleProduct->name }}">
                                                    </section>
                                                    <section class="product-colors"></section>
                                                    <section class="product-name">
                                                        <h3>{{ $amazingSale->limitedProductName() }}</h3>
                                                    </section>
                                                    <section class="product-price-wrapper">
                                                        <section class="product-discount">
                                                            <span
                                                                class="product-old-price">{{ $amazingSale->productFaPrice() }}</span>
                                                            <span
                                                                class="product-discount-amount">{{ $amazingSale->getFaPercentage() }}</span>
                                                        </section>
                                                        <section
                                                            class="product-price">{{ $amazingSale->productFinalFaPrice() }}
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
