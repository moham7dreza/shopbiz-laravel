@if($products->count() > 0)
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
                                    <span>{{ $title }}</span>
                                </h2>
                                <section class="content-header-link">
                                    <a href="{{ $viewAllRoute }}">مشاهده همه</a>
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->
                        <section class="lazyload-wrapper">
                            <section class="lazyload light-owl-nav owl-carousel owl-theme">
                                @foreach ($products as $product)
                                    @php
                                        $hasFavorited = auth()->user()->hasFavorited($product);
                                    @endphp
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endguest
                                                @auth
                                                    <section class="product-add-to-cart">
                                                        @php
                                                            $defaultSelectedColor = !empty($product->colors[0]) ? $product->colors[0]->id : null;
                                                            $defaultSelectedGuarantee = !empty($product->guarantees[0]) ? $product->guarantees[0]->id : null;
                                                            $productIsInCart = in_array($product->id, $productIds);
                                                        @endphp
                                                        <form
                                                            action="{{ route('customer.sales-process.add-to-cart', $product) }}"
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
                                                                    data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    title="حذف از علاقه مندی">
                                                                <i class="fa fa-bookmark text-danger"></i>
                                                            </button>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <button class="btn btn-light btn-sm text-decoration-none"
                                                                    data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                                    title="اضافه به علاقه مندی">
                                                                <i class="fa fa-bookmark"></i>
                                                            </button>
                                                        </section>
                                                    @endif
                                                @endauth
                                                <a class="product-link"
                                                   href="{{ $product->path() }}">
                                                    <section class="product-image">
                                                        <img class=""
                                                             src="{{ $product->imagePath() }}"
                                                             alt="{{ $product->name }}"
                                                             title="{{ $product->limitedIntro(50) . ' (' . 'محبوبیت : ' . convertEnglishToPersian($product->rating) . ')' }}"
                                                             data-bs-toggle="tooltip"
                                                             data-bs-placement="right">
                                                    </section>
                                                    <section class="product-colors"></section>
                                                    <section class="product-name">
                                                        <h3>{{ $product->limitedName() }}</h3></section>
                                                    @include('Share::wrapper.partials.calc-stars-count-from-rate')
                                                    <section class="product-price-wrapper mb-4">
                                                        @if($product->activeAmazingSales())
                                                            <section class="product-discount">
                                                            <span
                                                                class="product-old-price">{{ $product->getActualFaPrice() }}</span>
                                                                <span
                                                                    class="product-discount-amount">{{ $product->getFaAmazingSalesPercentage() }}</span>
                                                            </section>
                                                            <section
                                                                class="product-price">{{ $product->getFinalFaPrice() }}
                                                            </section>
                                                        @else
                                                            <section
                                                                class="product-price">{{ $product->getFaPrice() }}
                                                            </section>
                                                        @endif
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
@endif
