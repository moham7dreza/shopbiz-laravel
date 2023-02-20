@if($products->count() > 0)
    <!-- start product lazy load -->
    <section class="{{ $class }}">
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
                            <!-- start content header -->
                            <section class="lazyload-wrapper">
                                <section class="lazyload light-owl-nav owl-carousel owl-theme">

                                    @foreach ($products as $product)
                                        <section class="item">
                                            <section class="lazyload-item-wrapper">
                                                <section class="product">
                                                    {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section> --}}
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
                                                                $hasFavorited = auth()->user()->hasFavorited($product);
                                                $hasLiked = auth()->user()->hasLiked($product);

                                                                    $defaultSelectedColor = !empty($product->colors->first()) ? $product->colors->first()->id : null;
                                                                    $defaultSelectedGuarantee = !empty($product->guarantees->first()) ? $product->guarantees->first()->id : null;
                                                                    $productIsInCart = in_array($product->id, $productIds);
                                                            @endphp
                                                            <form
                                                                action="{{ route('customer.sales-process.add-to-cart', $product) }}"
                                                                method="post" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
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
                                                    @endauth

                                                    <a class="product-link"
                                                       href="{{ $product->path() }}">
                                                        <section class="product-image">
                                                            <img class=""
                                                                 src="{{ ($product->imagePath()) }}"
                                                                 alt="{{ $product->name }}"
                                                                 title="{{ $product->getLimitedIntroduction(50) }}"
                                                                 data-bs-toggle="tooltip"
                                                                 data-bs-placement="top">
                                                        </section>
                                                        <section class="product-colors"></section>
                                                        <section class="product-name">
                                                            <h3>{{ $product->getLimitedName() }}</h3>
                                                        </section>
                                                        @include('Share::components.home.partials.calc-stars-count-from-rate')
                                                        <section class="product-price-wrapper">
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
                                                                         title="{{ $product->getFaPriceRead() }}"
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
                                                        <section class="product-colors">
                                                            @foreach ($product->colors()->get() as $color)
                                                                <section class="product-colors-item"
                                                                         style="background-color: {{ $color->getColorCode() }};"
                                                                         title="{{ $color->getColorName() }}"
                                                                         data-bs-toggle="tooltip"
                                                                         data-bs-placement="top"></section>
                                                            @endforeach
                                                        </section>
                                                        {{--                                                        <section class="product-metas dir-ltr">--}}
                                                        {{--                                                            @foreach($product->values()->selected()->get() as $value)--}}
                                                        {{--                                                                <span--}}
                                                        {{--                                                                    class="product-metas-item text-muted alert alert-light">{{ $value->generateEnValue() }}</span>--}}
                                                        {{--                                                            @endforeach--}}
                                                        {{--                                                        </section>--}}
                                                        @if($product->activeAmazingSales())
                                                            <section class="border-top mt-4"></section>
                                                        @else
                                                            <section class="border-top mt-1"></section>
                                                        @endif
                                                        <section
                                                            class="d-flex justify-content-start align-items-center post-count my-2">
                                                            <span title="تعداد بازدید"
                                                                  data-bs-toggle="tooltip"
                                                                  data-bs-placement="top"><i class="fa fa-eye mx-2"></i>{{ $product->getFaViewsCount() }}</span>
                                                            <span title="تعداد نظرات"
                                                                  data-bs-toggle="tooltip"
                                                                  data-bs-placement="top"><i
                                                                    class="fa fa-comment mx-2"></i>{{ $product->allActiveProductCommentsCount() }}</span>
                                                        </section>
                                                    </a>
                                                    @auth
                                                        <section
                                                            class="d-flex align-items-center justify-content-end gap-2 pb-2 px-1 product-actions">
                                                            @if ($hasFavorited)
                                                                <section class="post-favorite-btn">
                                                                    <button type="button"
                                                                            class="btn btn-light btn-sm text-decoration-none"
                                                                            data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="حذف از علاقه مندی">
                                                                        <i class="fa fa-bookmark text-info"></i>
                                                                    </button>
                                                                </section>
                                                            @else
                                                                <section class="post-favorite-btn">
                                                                    <button type="button"
                                                                            class="btn btn-light btn-sm text-decoration-none"
                                                                            data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="اضافه به علاقه مندی">
                                                                        <i class="fa fa-bookmark"></i>
                                                                    </button>
                                                                </section>
                                                            @endif
                                                            @if ($hasLiked)
                                                                <section class="post-like-btn">
                                                                    <button type="button"
                                                                            class="btn btn-light btn-sm text-decoration-none"
                                                                            data-url="{{ route('customer.product.like', $product) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="لایک نکردن">
                                                                        <i class="fa fa-heart text-danger"></i>
                                                                    </button>
                                                                </section>
                                                            @else
                                                                <section class="post-like-btn">
                                                                    <button type="button"
                                                                            class="btn btn-light btn-sm text-decoration-none"
                                                                            data-url="{{ route('customer.product.like', $product) }}"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="top"
                                                                            title="لایک کردن">
                                                                        <i class="fa fa-heart"></i>
                                                                    </button>
                                                                </section>
                                                            @endif
                                                        </section>
                                                    @endauth
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
