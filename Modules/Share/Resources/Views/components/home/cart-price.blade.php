<section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
    @php
        $totalProductPrice = 0;
        $totalDiscount = 0;
    @endphp

    @foreach ($cartItems as $cartItem)
        @php
            $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
            $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
        @endphp
    @endforeach

    <section class="d-flex justify-content-between align-items-center">
        <p class="text-muted">قیمت کالاها ({{ convertEnglishToPersian($cartItems->count()) }})</p>
        <p class="text-muted"><span
                id="total_product_price">{{ priceFormat($totalProductPrice) }}</span> تومان
        </p>
    </section>

    @if ($totalDiscount != 0)
        <section class="d-flex justify-content-between align-items-center">
            <p class="text-muted">تخفیف کالاها</p>
            <p class="text-danger fw-bolder"><span
                    id="total_discount">{{ priceFormat($totalDiscount) }}</span> تومان</p>
        </section>
    @endif

    <section class="border-bottom mb-3"></section>

    @if (!is_null($commonDiscount))
        <section class="d-flex justify-content-between align-items-center">
            <p class="text-muted">میزان تخفیف عمومی</p>
            <p class="text-danger fw-bolder"><span
                    id="common_discount">{{ $commonDiscount->getFaPercentage() }}</span>
            </p>
        </section>

        <section class="d-flex justify-content-between align-items-center">
            <p class="text-muted">میزان حداکثر تخفیف عمومی</p>
            <p class="text-danger fw-bolder"><span>{{ $commonDiscount->getFaDiscountCeiling() }}</span>
            </p>
        </section>

        <section class="d-flex justify-content-between align-items-center">
            <p class="text-muted">حداقل موجودی سبد خرید</p>
            <p class="text-danger fw-bolder"><span>{{ $commonDiscount->getFaMinimalOrderAmountPrice() }}</span>
            </p>
        </section>
    @else
        <section>
            <p class="text-muted text-danger">هیج تخفیف عمومی فعال وجود ندارد</p>
        </section>
    @endif

    @if (!is_null($copanDiscount))
        <section class="border-bottom mb-3"></section>
        <section class="d-flex justify-content-between align-items-center">
            <p class="text-muted">میزان تخفیف کوپن</p>
            <p class="text-danger fw-bolder"><span
                    id="copan_discount">{{ $copanDiscount->getFaAmount() }}</span>
            </p>
        </section>
        @if($copanDiscount->isTypePercentage())
            <section class="d-flex justify-content-between align-items-center">
                <p class="text-muted">میزان حداکثر تخفیف</p>
                <p class="text-danger fw-bolder"><span>{{ $copanDiscount->getFaDiscountCeiling() }}</span>
                </p>
            </section>
        @endif
    @endif

    <section class="border-bottom mb-3"></section>
    @php $finalAmount = is_null($finalAmount) ? ($totalProductPrice - $totalDiscount) : $finalAmount; @endphp
    <section class="d-flex justify-content-between align-items-center">
        <p class="text-muted">جمع سبد خرید</p>
        <p class="fw-bolder"><span
                id="total_price">{{ priceFormat($finalAmount) }}</span>
            تومان</p>
    </section>

    <p class="my-3">
        <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای
        ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب
        کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
        پرداخت
        این سفارش صورت میگیرد.
    </p>

    <section class="">
        <button type="button"
                onclick="document.getElementById('{{ $formId }}').submit();"
                class="btn btn-danger d-block w-100">{{ $buttonText }}
        </button>
    </section>

</section>
