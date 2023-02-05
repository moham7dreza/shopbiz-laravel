<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            @if ($errors->any())
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger list-style-none">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <section class="col">
                <!-- start content header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>{{ $product->name }}</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <!-- start image gallery -->
                    <section class="col-md-4">
                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                            <section class="product-gallery">
                                @php
                                    $hasFavorited = auth()->user()->hasFavorited($product);
                                    $hasLiked = auth()->user()->hasLiked($product);

                                    $imageGalley = $product->images()->get();
                                    $images = collect();
                                    $images->push($product->image);
                                    foreach ($imageGalley as $image) {
                                        $images->push($image->image);
                                    }

                                @endphp
                                <section class="product-gallery-selected-image mb-3">
                                    <img src="{{ asset($images->first()['indexArray']['medium']) }}" alt="">
                                </section>
                                <section class="product-gallery-thumbs">
                                    @foreach ($images as $key => $image)

                                        <img class="product-gallery-thumb"
                                             src="{{ asset($image['indexArray']['medium']) }}"
                                             alt="{{ asset($image['indexArray']['medium']) . '-' . ($key + 1) }}"
                                             data-input="{{ asset($image['indexArray']['medium']) }}">

                                    @endforeach

                                </section>
                            </section>
                        </section>
                    </section>
                    <!-- end image gallery -->

                    <!-- start product info -->
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

                                    @php
                                        $colors = $product->colors()->get();
                                    @endphp

                                    @if($colors->count() != 0)
                                        <p><span>رنگ انتخاب شده : <span class="font-weight-bold"
                                                                        id="selected_color_name"> {{ $colors->first()->color_name }}</span></span>
                                        </p>
                                        <p>
                                            @foreach ($colors as $key => $color)
                                                <label for="{{ 'color_' . $color->id }}"
                                                       style="background-color: {{ $color->color ?? '#ffffff' }};"
                                                       class="product-info-colors me-1" data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom"
                                                       title="{{ $color->color_name }}">

                                                </label>
                                                <input class="d-none" type="radio" name="color"
                                                       id="{{ 'color_' . $color->id }}" value="{{ $color->id }}"
                                                       data-color-name="{{ $color->color_name }}"
                                                       data-color-price={{ $color->price_increase }} @if($key == 0) checked @endif>
                                            @endforeach
                                        </p>
                                    @endif

                                    @php
                                        $guarantees = $product->guarantees()->get();
                                    @endphp
                                    @if($guarantees->count() != 0)
                                        <p class="font-weight-bold"><i
                                                class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                            گارانتی :
                                            <select name="guarantee" id="guarantee" class="guarantee p-1">
                                                @foreach ($guarantees as $key => $guarantee)
                                                    <option value="{{ $guarantee->id }}"
                                                            data-guarantee-price={{ $guarantee->price_increase }}  @if($key == 0) selected @endif>{{ $guarantee->name }}</option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif


                                    <p class="font-weight-bold">
                                        @if($product->marketable_number > 0)
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span>
                                        @else
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا ناموجود</span>
                                        @endif
                                    </p>

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
                                    <section
                                        class="d-flex align-items-center justify-content-between mx-2 my-3 flex-row-reverse product-reactions">
                                        <section class="d-flex align-items-center reactions">
                                            @guest
                                                <section class="product-add-to-favorite position-relative"
                                                         style="top: 0">
                                                    <button type="button"
                                                            class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if ($hasFavorited)
                                                    <section class="product-add-to-favorite position-relative"
                                                             style="top: 0">
                                                        <button type="button"
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-bookmark text-info"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite position-relative"
                                                             style="top: 0">
                                                        <button type="button"
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.add-to-favorite', $product) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-bookmark"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                                @if ($hasLiked)
                                                    <section class="product-like position-relative"
                                                             style="top: 0">
                                                        <button type="button"
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.like', $product) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="لایک نکردن">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-like position-relative"
                                                             style="top: 0">
                                                        <button type="button"
                                                                class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.product.like', $product) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="لایک کردن">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                                <section class="product-add-to-favorite position-relative"
                                                         style="top: 0">
                                                    <button type="button"
                                                            onclick="document.getElementById('comment-add-button').click();"
                                                            class="btn btn-light btn-sm text-decoration-none"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="افزودن نظر">
                                                        <i class="fa fa-comment"></i>
                                                    </button>
                                                </section>
                                            @endauth
                                        </section>
                                        @php
                                            //                                            $review = $product->reviews()->where('user_id', auth()->id())->first();
                                                                                        $review = \Modules\Share\Entities\Review::query()->where([
                                                                                          ['user_id', auth()->id()],
                                                                                          ['reviewable_id', $product->id],
                                                                                          ['reviewable_type', get_class($product)]
                                                                                          ])->pluck('rate')->first();
                                        @endphp
                                        <section class="d-flex align-items-start flex-column reviews w-50">
                                            <section class="d-flex align-items-center">
                                                <i class="fa fa-ticket-alt"></i>
                                                <span class="font-weight-bold mx-2"> نظر سنجی : </span>
                                            </section>
                                            <section class="d-flex mx-4 mt-3 align-items-center gap-2">
                                                <span><i class="fa fa-pen"></i></span>
                                                <section class="d-flex">
                                                    <button class="btn {{ $review > 4 ? 'text-greenyellow' : 'text-gray' }}"
                                                            type="button" id="rate_very_good" title="عالی"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-url="{{ route('customer.product.review', [$product, 'rate=5']) }}">
                                                        <i class="fa fa-star"></i></button>
                                                    <button class="btn {{ $review > 3 ? 'text-greenyellow' : 'text-gray' }}"
                                                            type="button" id="rate_good" title="خوب"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-url="{{ route('customer.product.review', [$product, 'rate=4']) }}">
                                                        <i class="fa fa-star"></i></button>
                                                    <button class="btn {{ $review > 2 ? 'text-greenyellow' : 'text-gray' }}"
                                                            type="button" id="rate_normal" title="متوسط"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-url="{{ route('customer.product.review', [$product, 'rate=3']) }}">
                                                        <i class="fa fa-star"></i></button>
                                                    <button class="btn {{ $review > 1 ? 'text-greenyellow' : 'text-gray' }}"
                                                            type="button" id="rate_low" title="نه خوب"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-url="{{ route('customer.product.review', [$product, 'rate=2']) }}">
                                                        <i class="fa fa-star"></i></button>
                                                    <button class="btn {{ $review > 0 ? 'text-greenyellow' : 'text-gray' }}"
                                                            type="button" id="rate_very_low" title="بد"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            data-url="{{ route('customer.product.review', [$product, 'rate=1']) }}">
                                                        <i class="fa fa-star"></i></button>
                                                </section>
                                            </section>
                                        </section>
                                    </section>
                                    <section class="border-top my-2"></section>
                                    <p class="mb-3 mt-3">
                                        <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی
                                        نشده است. برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید
                                        و سپس نحوه ارسال را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این
                                        مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این سفارش صورت میگیرد. پس از
                                        ثبت سفارش کالا بر اساس نحوه ارسال که شما انتخاب کرده اید کالا برای شما
                                        در مدت زمان مذکور ارسال می گردد.
                                    </p>
                            </section>
                        </section>

                    </section>
                    <!-- end product info -->

                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">قیمت کالا</p>
                                @if($product->marketable_number > 0)
                                    <p class="text-muted"><span id="product_price"
                                                                data-product-original-price={{ $product->price }}>{{ priceFormat($product->price) }}</span>
                                        <span class="small">تومان</span></p>
                                @else
                                    <p class="text-danger fw-bolder">
                                        {{ convertEnglishToPersian(0) }} <span class="small"> تومان</span>
                                    </p>
                                @endif
                            </section>


                            @php
                                $amazingSale = $product->activeAmazingSales();
                            @endphp
                            @if(!empty($amazingSale) && $product->marketable_number > 0)
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالا</p>
                                    <p class="text-danger fw-bolder" id="product-discount-price"
                                       data-product-discount-price="{{ ($product->price * ($amazingSale->percentage / 100) ) }}">
                                        {{ priceFormat($product->price * ($amazingSale->percentage / 100)) }}<span
                                            class="small"> تومان</span>
                                    </p>
                                </section>
                            @else
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالا</p>
                                    <p class="text-danger fw-bolder">
                                        {{ convertEnglishToPersian(0) }} <span class="small"> تومان</span>
                                    </p>
                                </section>
                            @endif

                            <section class="border-bottom mb-3"></section>

                            @if($product->marketable_number > 0)
                                <section class="d-flex justify-content-between">
                                    <span>جمع کل</span>
                                    <p class="fw-bolder">
                                        <span id="final-price"></span>
                                        <span class="small">تومان</span>
                                    </p>
                                </section>
                            @else
                                <section class="d-flex justify-content-end align-items-center">
                                    <p class="text-danger fw-bolder">
                                        {{ convertEnglishToPersian(0) }} <span class="small"> تومان</span>
                                    </p>
                                </section>
                            @endif

                            <section class="d-flex flex-column gap-2">
                                @if($product->marketable_number > 0)
                                    <span class="text-danger mb-2">تنها <strong>{{ convertEnglishToPersian($product->marketable_number) }}</strong> عدد در انبار باقی مانده</span>
                                    <button id="next-level" class="btn btn-danger d-block w-100"
                                            onclick="document.getElementById('add_to_cart').submit();">افزودن به سبد
                                        خرید
                                    </button>
                                @else
                                    <button id="next-level" class="btn btn-secondary disabled d-block">محصول نا موجود
                                        میباشد
                                    </button>
                                @endif
                            </section>
                            </form>

                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->
