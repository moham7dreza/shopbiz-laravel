@if($products->count() > 0)
    <!-- start product lazy load -->
    <section class="{{ $class == '' ? 'mb-3' : $class }}">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    @if($class === '')
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            @endif
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
                                        <section class="item full-width-el">
                                            <section class="lazyload-item-wrapper">
                                                <section class="product full-width-el">

                                                    <!-- product add to cart button -->
                                                    <section class="product-add-to-cart">
                                                        @php
                                                            $defaultSelectedColor = !empty($product->colors->first()) ? $product->colors->first()->id : null;
                                                            $defaultSelectedGuarantee = !empty($product->guarantees->first()) ? $product->guarantees->first()->id : null;
                                                            $productIsInCart = in_array($product->id, $productIds);
                                                        @endphp
                                                        <form
                                                            action="{{ route('customer.sales-process.add-to-cart', $product) }}"
                                                            method="post" data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            @auth
                                                                title="{{ $productIsInCart ? 'کالا در حال حاظر در سبد خرید شما موجود است' : 'افزودن به سبد خرید' }}"
                                                            @endauth
                                                            @guest
                                                                title="برای افزودن کالا به سبد خرید وارد حساب کاربری خود شوید"
                                                            @endguest>
                                                            @csrf
                                                            <input type="hidden" name="color"
                                                                   value="{{ $defaultSelectedColor }}">
                                                            <input type="hidden" name="guarantee"
                                                                   value="{{ $defaultSelectedGuarantee }}">
                                                            <input type="hidden" name="number" value="1">
                                                            <button type="submit"
                                                                    class="btn btn-light btn-sm add-to-cart-btn text-muted">
                                                                <i class="fa fa-cart-plus {{ $productIsInCart ? 'text-lightcoral' : '' }}"></i>
                                                            </button>
                                                        </form>
                                                    </section>
                                                    <!-- end product add to cart button -->


                                                    <!-- product add to favorite button -->
                                                    @php $hasFavorited = auth()->check() && auth()->user()->hasFavorited($product); @endphp
                                                    <section class="product-add-to-favorite">
                                                        <button
                                                            class="btn btn-light btn-sm text-decoration-none text-muted"
                                                            data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            @auth
                                                                title="{{ $hasFavorited ? 'حذف از علاقه مندی' : 'اضافه به علاقه مندی' }}"
                                                            @endauth
                                                            @guest
                                                                title="برای افزودن به لیست علاقه مندی وارد حساب کاربری خود شوید"
                                                            @endguest>
                                                            <i class="fa fa-bookmark {{ $hasFavorited ? 'text-lightblue' : '' }}"></i>
                                                        </button>
                                                    </section>
                                                    <!-- end product add to favorite button -->

                                                    <!-- start product link card -->
                                                    <a class="product-link"
                                                       href="{{ $product->path() }}">
                                                        <section class="product-image">
                                                            <img class=""
                                                                 src="{{ $product->imagePath() }}"
                                                                 alt="{{ $product->name }}"
                                                                 title="{{ $product->getLimitedIntroduction(50) }}"
                                                                 data-bs-toggle="tooltip"
                                                                 data-bs-placement="top">
                                                        </section>
                                                        <section class="product-colors"></section>
                                                        <section class="product-name">
                                                            <h3>{{ $product->getLimitedName() }}</h3></section>

                                                        <!-- product rate stars -->
                                                        @include('Share::components.home.partials.calc-stars-count-from-rate')
                                                        <!-- end product rate stars -->

                                                        <!-- product price -->
                                                        <section class="product-price-wrapper mb-4">
                                                            <!-- product has discount -->
                                                            @if($product->activeAmazingSales())
                                                                <section class="product-discount"
                                                                         title="{{ 'تخفیف : ' . $product->getFaProductDiscountPrice() }}"
                                                                         data-bs-toggle="tooltip"
                                                                         data-bs-placement="top">
                                                            <span
                                                                class="product-old-price">{{ $product->getFaActualPrice() }}</span>
                                                                    <span
                                                                        class="product-discount-amount">{{ $product->getFaAmazingSalesPercentage() }}</span>
                                                                </section>
                                                                <section class="product-price"
                                                                         title="{{ $product->getFaFinalReadingPrice() }}"
                                                                         data-bs-toggle="tooltip"
                                                                         data-bs-placement="top">
                                                                    {{ $product->getFaFinalPrice() }}
                                                                </section>
                                                            @else
                                                                <section
                                                                    class="product-price"
                                                                    title="{{ $product->getFaPriceRead() }}"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-placement="top">{{ $product->getFaPrice() }}
                                                                </section>
                                                            @endif
                                                        </section>
                                                        <!-- end product price -->

                                                        <!-- product colors -->
                                                        <section class="product-colors">
                                                            @foreach ($product->colors()->get() as $color)
                                                                <section class="product-colors-item"
                                                                         style="background-color: {{ $color->getColorCode() }};"
                                                                         title="{{ $color->getColorName() }}"
                                                                         data-bs-toggle="tooltip"
                                                                         data-bs-placement="top"></section>
                                                            @endforeach
                                                        </section>

                                                        <!-- product metas -->
                                                        <section class="product-metas dir-ltr">
                                                            @if($product->activeAmazingSales())
                                                                @php $value = $product->values()->selected()->first() @endphp
                                                                @if(isset($value))
                                                                    <span
                                                                        class="product-metas-item alert bg-green-light"
                                                                        title="{{ $value->generateFaFullInformation() }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top">{{ $value->generateEnValue() }}</span>
                                                                @endif
                                                            @else
                                                                @foreach($product->values()->selected()->get() as $value)
                                                                    <span
                                                                        class="product-metas-item alert bg-green-light"
                                                                        title="{{ $value->generateFaFullInformation() }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="top">{{ $value->generateEnValue() }}</span>
                                                                @endforeach
                                                            @endif
                                                        </section>
                                                    </a>
                                                    <!-- start product link card -->

                                                </section>
                                            </section>
                                        </section>
                                    @endforeach

                                </section>
                            </section>
                            @if($class == '')
                        </section>
                    @endif
                </section>
            </section>
        </section>
    </section>
    <!-- end product lazy load -->
@endif
