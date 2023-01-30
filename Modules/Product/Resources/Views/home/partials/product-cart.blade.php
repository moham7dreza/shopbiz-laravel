<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">

        @if(session('danger') && session('info'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @elseif(session('info'))
            <div class="alert alert-info">
                {{ session('info') }} - برای نمایش سبد خرید <a class="text-decoration-none text-info pointer"
                    href="{{ route('customer.sales-process.cart') }}">کلیک</a> کنید.
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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
                                        <p><span>رنگ انتخاب شده : <span
                                                    id="selected_color_name"> {{ $colors->first()->color_name }}</span></span>
                                        </p>
                                        <p>
                                            @foreach ($colors as $key => $color)

                                                <label for="{{ 'color_' . $color->id }}"
                                                       style="background-color: {{ $color->color ?? '#ffffff' }};"
                                                       class="product-info-colors me-1" data-bs-toggle="tooltip"
                                                       data-bs-placement="bottom"
                                                       title="{{ $color->color_name }}"></label>

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

                                        <p><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                            گارانتی :
                                            <select name="guarantee" id="guarantee" class="p-1">
                                                @foreach ($guarantees as $key => $guarantee)
                                                    <option value="{{ $guarantee->id }}"
                                                            data-guarantee-price={{ $guarantee->price_increase }}  @if($key == 0) selected @endif>{{ $guarantee->name }}</option>
                                                @endforeach

                                            </select>
                                        </p>

                                    @endif


                                    <p>
                                        @if($product->marketable_number > 0)
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span>
                                        @else
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا ناموجود</span>
                                        @endif
                                    </p>
                                    <p>

                                    @guest
                                        <section class="product-add-to-favorite position-relative" style="top: 0">
                                            <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                    data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="اضافه به علاقه مندی">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                        </section>
                                    @endguest
                                    @auth
                                        @if ($product->user->contains(auth()->user()->id))
                                            <section class="product-add-to-favorite position-relative" style="top: 0">
                                                <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                        data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="حذف از علاقه مندی">
                                                    <i class="fa fa-heart text-danger"></i>
                                                </button>
                                            </section>
                                        @else
                                            <section class="d-flex">
                                                <section class="product-add-to-favorite position-relative" style="top: 0">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                                <section class="product-add-to-favorite position-relative" style="top: 0">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-bookmark"></i>
                                                    </button>
                                                </section>
                                                <section class="product-add-to-favorite position-relative" style="top: 0">
                                                    <button type="button" class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.market.add-to-favorite', $product) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-comment"></i>
                                                    </button>
                                                </section>
                                            </section>

                                            @endif
                                            @endauth
                                            </p>
                                            <section>
                                                <section class="cart-product-number d-inline-block ">
                                                    <button class="cart-number cart-number-down" type="button">-
                                                    </button>
                                                    <input type="number" id="number" name="number" min="1" max="5"
                                                           step="1" value="1" readonly="readonly">
                                                    <button class="cart-number cart-number-up" type="button">+</button>
                                                </section>
                                            </section>
                                            <p class="mb-3 mt-5">
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
                                <p class="text-muted"><span id="product_price"
                                                            data-product-original-price={{ $product->price }}>{{ priceFormat($product->price) }}</span>
                                    <span class="small">تومان</span></p>
                            </section>


                            @php

                                $amazingSale = $product->activeAmazingSales();

                            @endphp
                            @if(!empty($amazingSale))
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالا</p>
                                    <p class="text-danger fw-bolder" id="product-discount-price"
                                       data-product-discount-price="{{ ($product->price * ($amazingSale->percentage / 100) ) }}">
                                        {{ priceFormat($product->price * ($amazingSale->percentage / 100)) }}<span
                                            class="small"> تومان</span>
                                    </p>
                                </section>
                            @endif

                            <section class="border-bottom mb-3"></section>

                            <section class="d-flex justify-content-end align-items-center">
                                <p class="fw-bolder"><span id="final-price"></span> <span class="small">تومان</span></p>
                            </section>

                            <section class="">
                                @if($product->marketable_number > 0)
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
