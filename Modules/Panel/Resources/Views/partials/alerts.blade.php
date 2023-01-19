<!-- common discount alert --->
<section class="row">
    <section class="col-12">
        @php
            $discount = $panelRepo->activeCommonDiscount();
        @endphp
        @if(!is_null($discount))
            <div class="alert alert-primary" role="alert">
                یک تخفیف عمومی <strong>{{ $discount->getFaPercentage() }}</strong> با عنوان
                <strong>{{ $discount->title }}</strong> با حداکثر تخفیف
                <strong>{{ $discount->getFaDiscountCeiling() }}</strong>برای سبد خرید با حداقل مبلغ <strong>{{ $discount->minimalOrderAmountFaPrice() }}</strong>تا
                تاریخ
                <strong>{{ $discount->getFaEndDate() }}</strong> فعال است. برای<a
                    href="{{ route('commonDiscount.edit', $discount) }}"
                    class="alert-link"> ویرایش </a>کلیک کن.
            </div>
        @else
            <div class="alert alert-primary" role="alert">
                هیچ تخفیف عمومی فعال نیست. برای افزودن <a
                    href="{{ route('commonDiscount.create') }}"
                    class="alert-link">تخفیف</a> کلیک کن.
            </div>
        @endif

    </section>
</section>

<!-- last weekly sales -->
<section class="row">
    <section class="col-12">
        <div class="alert alert-info" role="alert">
            کل فروش هفته جاری <strong>{{ $panelRepo->lastWeeklySalesAmount() }} تومان</strong> و کل فروش ماه جاری
            <strong>{{ $panelRepo->lastMonthlySalesAmount() }} تومان</strong> است. برای مشاهده<a
                @if(!is_null($panelRepo->lastOrder())) href="{{ route('order.show', $panelRepo->lastOrder()->id) }}"
                @else href="#" @endif
                class="alert-link"> جزئیات </a>آخرین سفارش کلیک کن.
        </div>
    </section>
</section>
