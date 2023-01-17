<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start content header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>سبد خرید شما</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <section class="col-md-9 mb-3">
                        <form action="" id="cart_items" method="post"
                              class="content-wrapper bg-white p-3 rounded-2">
                            @csrf
                            @php
                                $totalProductPrice = 0;
                                $totalDiscount = 0;
                            @endphp

                            @foreach ($cartItems as $cartItem)
                                @php
                                    $totalProductPrice += $cartItem->cartItemProductPrice();
                                    $totalDiscount += $cartItem->cartItemProductDiscount();
                                @endphp

                                <section class="cart-item d-md-flex py-3">
                                    <section class="cart-img align-self-start flex-shrink-1">
                                        <img src="{{ $cartItem->productImage() }}"
                                             alt="">
                                    </section>
                                    <section class="align-self-start w-100">
                                        <p class="fw-bold">{{ $cartItem->productName() }}</p>
                                        <p>
                                            @if (!empty($cartItem->color))
                                                <span style="background-color: {{ $cartItem->color->color }};"
                                                      class="cart-product-selected-color me-1"></span> <span>
                                                        {{ $cartItem->colorName() }}</span>
                                            @else
                                                <span>رنگ منتخب وجود ندارد</span>
                                            @endif
                                        </p>
                                        <p>
                                            @if (!empty($cartItem->guarantee))
                                                <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                <span> {{ $cartItem->guaranteeName() }}</span>
                                            @else
                                                <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                <span> گارانتی ندارد</span>
                                            @endif
                                        </p>
                                        <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا
                                                    موجود در انبار</span></p>
                                        <section>
                                            <section class="cart-product-number d-inline-block ">
                                                <button class="cart-number cart-number-down" type="button">-
                                                </button>
                                                <input class="number" name="number[{{ $cartItem->id }}]"
                                                       data-product-price={{ $cartItem->cartItemProductPrice() }}
                                                        data-product-discount={{ $cartItem->cartItemProductDiscount() }}
                                                        type="number" min="1" max="5" step="1"
                                                       value="{{ $cartItem->number }}" readonly="readonly">
                                                <button class="cart-number cart-number-up" type="button">+</button>
                                            </section>
                                            <a class="text-decoration-none ms-4 cart-delete"
                                               href="{{ route('customer.sales-process.remove-from-cart', $cartItem) }}"><i
                                                    class="fa fa-trash-alt"></i> حذف از سبد</a>
                                        </section>
                                    </section>
                                    <section class="align-self-end flex-shrink-1">
                                        @if ($cartItem->hasActiveAmazingSale())
                                            <section class="cart-item-discount text-danger text-nowrap mb-1">تخفیف :
                                                {{ $cartItem->productDiscount() }}</section>
                                        @endif
                                        <section class="text-nowrap fw-bold">
                                            {{ $cartItem->faProductPrice() }}
                                        </section>
                                    </section>
                                </section>
                            @endforeach


                        </form>

                    </section>
                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">قیمت کالاها ({{ $cartItem->faItemsCount() }})</p>
                                <p class="text-muted" id="total_product_price">
                                    {{ $cartItem->faPrice($totalProductPrice) }}
                                </p>
                            </section>

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">تخفیف کالاها</p>
                                <p class="text-danger fw-bolder"
                                   id="total_discount">{{ $cartItem->faPrice($totalDiscount) }}
                                </p>
                            </section>
                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">جمع سبد خرید</p>
                                <p class="fw-bolder" id="total_price">
                                    {{ $cartItem->faPrice($totalProductPrice - $totalDiscount) }}</p>
                            </section>

                            <p class="my-3">
                                <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای
                                ثبت
                                سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب
                                کنید.
                                نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت
                                این
                                سفارش صورت میگیرد.
                            </p>


                            <section class="">
                                <button onclick="document.getElementById('cart_items').submit();"
                                        class="btn btn-danger d-block">
                                    انتخاب آدرس و روش ارسال کالا
{{--                                    تکمیل فرآیند خرید--}}
                                </button>
                            </section>

                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->
