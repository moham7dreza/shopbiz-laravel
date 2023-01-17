<section class="col-md-3">
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
            <p class="text-muted">قیمت کالاها ({{ $cartItem->faItemsCount() }})</p>
            <p class="text-muted" id="total_product_price">
                {{ $cartItem->faPrice($totalProductPrice) }}
            </p>
        </section>

        @if ($totalDiscount != 0)
            <section class="d-flex justify-content-between align-items-center">
                <p class="text-muted">تخفیف کالاها</p>
                <p class="text-danger fw-bolder"
                   id="total_discount">{{ $cartItem->faPrice($totalDiscount) }}
                </p>
            </section>
        @endif
        <section class="border-bottom mb-3"></section>
        <section class="d-flex justify-content-between align-items-center">
            <p class="text-muted">جمع سبد خرید</p>
            <p class="fw-bolder" id="total_price">
                {{ $cartItem->faPrice($totalProductPrice - $totalDiscount) }}</p>
        </section>

        <p class="my-3">
            <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای
            ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب
            کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
            پرداخت
            این سفارش صورت میگیرد.
        </p>

        <form action="{{ route('customer.sales-process.choose-address-and-delivery') }}"
              method="post" id="myForm">
            @csrf
        </form>


        <section class="">
            <button type="button"
                    onclick="document.getElementById('myForm').submit();"
                    class="btn btn-danger d-block w-100">پرداخت و تکمیل فرآیند خرید
            </button>
        </section>

    </section>
</section>
