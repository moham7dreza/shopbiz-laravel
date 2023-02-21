<section class="col-md-5">
    <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
        <!-- start content header -->
        <section class="content-header mb-3">
            <section class="d-flex justify-content-between align-items-center">
                <h2 class="content-header-title content-header-title-small">
                    {{ $product->name }}
                </h2>
                <section class="content-header-link">
                    <!--<a href="#">مشاهده همه</a>-->
                </section>
            </section>
        </section>
        <section class="product-info">
            <form id="add_to_cart"
                  action="{{ route('customer.sales-process.add-to-cart', $product) }}" method="post"
                  class="product-info">
                @csrf

                <!-- product colors -->
                @php $productColors = $product->colors()->get(); @endphp
                @if($productColors->count() != 0)
                    <p>
                                            <span>رنگ انتخاب شده : <span class="font-weight-bold"
                                                                         id="selected_color_name">{{ $productColors->first()->getColorName() }}</span>
                                            </span>
                    </p>
                    <p>
                        @foreach ($productColors as $key => $productColor)
                            <label for="{{ 'color_' . $productColor->id }}"
                                   style="background-color: {{ $productColor->getColorCode() ?? '#ffffff' }};"
                                   class="product-info-colors me-1" data-bs-toggle="tooltip"
                                   data-bs-placement="top"
                                   title="{{ $productColor->getColorName() }}">
                            </label>
                            <input class="d-none" type="radio" name="color"
                                   id="{{ 'color_' . $productColor->id }}" value="{{ $productColor->id }}"
                                   data-color-name="{{ $productColor->getColorName() }}"
                                   data-color-price={{ $productColor->price_increase }} @if($key == 0) checked @endif>
                        @endforeach
                    </p>
                @endif
                <!-- end product colors -->

                <!-- product guarantees -->
                @php $productGuarantees = $product->guarantees()->get(); @endphp
                @if($productGuarantees->count() != 0)
                    <p class="font-weight-bold"><i
                            class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                        <label for="guarantee">گارانتی :</label>
                        <select name="guarantee"
                                id="guarantee"
                                class="guarantee p-1">
                            @foreach ($productGuarantees as $key => $productGuarantee)
                                <option value="{{ $productGuarantee->id }}"
                                        data-guarantee-price={{ $productGuarantee->price_increase }}
                                        @if($key == 0) selected @endif>{{ $productGuarantee->getFaFullName() }}
                                </option>
                            @endforeach
                        </select>
                    </p>
                @endif
                <!-- end product guarantees -->

                <!-- product has marketable number -->
                <p class="font-weight-bold">
                    @if($product->marketable_number > 0)
                        <i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                        <span>کالا موجود در انبار</span>
                    @else
                        <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا ناموجود</span>
                    @endif
                </p>
                <!-- end product has marketable number -->

                <!-- product numbers -->
                <section>
                    <section class="cart-product-number d-inline-block">
                        <button class="cart-number cart-number-down" type="button">-
                        </button>
                        @php
                            $count = $product->marketable_number;
                        @endphp
                        <input type="number" id="number" name="number" min="1"
                               @if($count < 5) max="{{ $count }}" @else max="5" @endif
                               step="1" value="1" readonly="readonly">
                        <button class="cart-number cart-number-up" type="button">+</button>
                    </section>
                </section>
                <!-- end product numbers -->

                <!-- product tags -->
                @if($product->tags()->count() > 0)
                    <section class="d-flex flex-column mt-4 tags">
                        <section class="d-flex gap-2">
                            <i class="fa fa-tags"></i>
                            <span class="font-weight-bold"> برچسب ها :</span>
                        </section>
                        <section class="d-flex flex-wrap align-items-center gap-1 mt-2">
                            @foreach($product->tags as $tag)
                                <a href="{{ route('customer.market.products.offers', 'tag='.$tag->name) }}"
                                   class="product-tags">{{ $tag->name }}</a>
                            @endforeach
                        </section>
                    </section>
                @endif
                <!-- end product tags -->

                <!-- product reactions -->
                <section
                    class="d-flex align-items-center justify-content-between mx-2 my-3 flex-row-reverse product-reactions">

                    <section class="d-flex align-items-center reactions">

                        <!-- product favorite button -->
                        @php $hasFavorited = auth()->check() && auth()->user()->hasFavorited($product); @endphp
                        <section class="product-add-to-favorite position-relative"
                                 style="top: 0">
                            <button type="button"
                                    class="btn btn-light btn-sm text-decoration-none text-muted"
                                    data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    @auth
                                        title="{{ $hasFavorited ? 'حذف از علاقه مندی' : 'اضافه به علاقه مندی' }}"
                                    @endauth
                                    @guest
                                        title="برای افزودن به لیست علاقه مندی وارد حساب کاربری خود شوید"
                                @endguest
                            >
                                <i class="fa fa-bookmark {{ $hasFavorited ? 'text-info' : '' }}"></i>
                            </button>
                        </section>
                        <!-- end product favorite button -->

                        <!-- product like button -->
                        @php  $hasLiked = auth()->check() && auth()->user()->hasLiked($product); @endphp
                        <section class="product-like position-relative"
                                 style="top: 0">
                            <button type="button"
                                    class="btn btn-light btn-sm text-decoration-none text-muted"
                                    data-url="{{ route('customer.product.like', $product) }}"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    @auth
                                        title="{{ $hasLiked ? 'لایکش نکن' : 'لایکش کن' }}"
                                    @endauth
                                    @guest
                                        title="برای لایک کردن وارد حساب کاربری خود شوید"
                                @endguest
                            >
                                <i class="fa fa-heart {{ $hasLiked ? 'text-danger' : '' }}"></i>
                            </button>
                        </section>
                        <!-- end product like button -->

                        <!-- add comment button -->
                        <section class="product-add-to-favorite position-relative"
                                 style="top: 0">
                            <button type="button"
                                    onclick="document.getElementById('comment-add-button').click();"
                                    class="btn btn-light btn-sm text-decoration-none"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="افزودن نظر">
                                <i class="fa fa-comment text-muted"></i>
                            </button>
                        </section>
                        <!-- end add comment button -->
                    </section>

                    <!-- product review -->
                    <section class="d-flex align-items-start flex-column reviews w-50">
                        <section class="d-flex align-items-center">
                            <i class="fa fa-ticket-alt"></i>
                            <span class="font-weight-bold mx-2"> نظر سنجی : </span>
                        </section>
                        <section class="d-flex mx-4 mt-3 align-items-center gap-2">
                                                <span><i class="fa fa-pen" title="لطفا در نظر سنجی کالا شرکت کنید"
                                                         data-bs-toggle="tooltip"
                                                         data-bs-placement="top"></i></span>
                            <section class="d-flex"
                                     @guest
                                         data-bs-toggle="tooltip" data-bs-placement="bottom"
                                     title="برای ثبت نظر وارد حساب کاربری خود شوید"
                                @endguest
                            >
                                <button
                                    class="btn {{ $review > 4 ? 'text-greenyellow' : 'text-gray' }}"
                                    type="button" id="rate_very_good" title="عالی"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-url="{{ route('customer.product.review', [$product, 'rate=5']) }}">
                                    <i class="fa fa-star"></i></button>
                                <button
                                    class="btn {{ $review > 3 ? 'text-greenyellow' : 'text-gray' }}"
                                    type="button" id="rate_good" title="خوب"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-url="{{ route('customer.product.review', [$product, 'rate=4']) }}">
                                    <i class="fa fa-star"></i></button>
                                <button
                                    class="btn {{ $review > 2 ? 'text-greenyellow' : 'text-gray' }}"
                                    type="button" id="rate_normal" title="متوسط"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-url="{{ route('customer.product.review', [$product, 'rate=3']) }}">
                                    <i class="fa fa-star"></i></button>
                                <button
                                    class="btn {{ $review > 1 ? 'text-greenyellow' : 'text-gray' }}"
                                    type="button" id="rate_low" title="نه خوب"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-url="{{ route('customer.product.review', [$product, 'rate=2']) }}">
                                    <i class="fa fa-star"></i></button>
                                <button
                                    class="btn {{ $review > 0 ? 'text-greenyellow' : 'text-gray' }}"
                                    type="button" id="rate_very_low" title="بد"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-url="{{ route('customer.product.review', [$product, 'rate=1']) }}">
                                    <i class="fa fa-star"></i></button>
                            </section>
                        </section>
                    </section>
                    <!-- end product review -->
                </section>
                <!-- end product reactions -->

                <section class="border-top my-2"></section>
                <p class="mb-3 mt-3">
                    <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی
                    نشده است. برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید
                    و سپس نحوه ارسال را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این
                    مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این سفارش صورت میگیرد. پس از
                    ثبت سفارش کالا بر اساس نحوه ارسال که شما انتخاب کرده اید کالا برای شما
                    در مدت زمان مذکور ارسال می گردد.
                </p>
            </form>
        </section>
    </section>

</section>
