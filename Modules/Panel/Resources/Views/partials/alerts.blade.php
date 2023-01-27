<!-- common discount alert --->
<section class="row">
    <section class="col-12">
        @php
            $discount = $panelRepo->activeCommonDiscount();
            $copans = $panelRepo->activeCopanDiscounts()->get();
            if (count($copans) == 1){
                $copan = $copans[0];
            }
        @endphp
        @if(!is_null($discount))
            <div class="alert alert-primary" role="alert">
                یک تخفیف عمومی <strong>{{ $discount->getFaPercentage() }}</strong> با عنوان
                <strong>{{ $discount->title }}</strong> با حداکثر تخفیف
                <strong>{{ $discount->getFaDiscountCeiling() }}</strong>برای سبد خرید با حداقل مبلغ
                <strong>{{ $discount->minimalOrderAmountFaPrice() }}</strong>تا
                تاریخ
                <strong>{{ $discount->getFaEndDate() }}</strong> فعال است. برای<a
                    href="{{ route('commonDiscount.edit', $discount) }}"
                    class="alert-link"> ویرایش </a>کلیک کن.
                @if(count($copans) > 0)
                    @if(count($copans) == 1)
                        فقط یک کپن تخفیف با عنوان کد<strong>{{ $copan->code }}</strong> با تخفیف
                        <strong>{{ convertEnglishToPersian($copan->amount) . ' ' . $copan->amount_type == 0 ? 'درصدی' : 'تومانی' }}</strong>
                        تا تاریخ <strong>{{ $copan->getFaEndDate() }}</strong> فعال است. برای<a
                            href="{{ route('copanDiscount.edit', $copan) }}"
                            class="alert-link"> ویرایش </a>کلیک کن.
                    @else
                        به تعداد <strong>{{ convertEnglishToPersian($copansCount) }}</strong>عدد کپن تخفیف فعال وجود
                        دارد.
                    @endif
                @else
                    هیچ <strong>کپن تخفیفی</strong> فعال نیست. برای افزودن <a
                        href="{{ route('copanDiscount.create') }}"
                        class="alert-link">تخفیف</a> کلیک کن.
                @endif
            </div>
        @else
            <div class="alert alert-primary" role="alert">
                هیچ <strong>تخفیف عمومی</strong> فعال نیست. برای افزودن <a
                    href="{{ route('commonDiscount.create') }}"
                    class="alert-link">تخفیف</a> کلیک کن.
                @if(count($copans) > 0)
                    @if(count($copans) == 1)
                        فقط <strong>یک</strong> کپن تخفیف با عنوان کد <strong>{{ $copan->code }}</strong>
                        با تخفیف <strong>{{ $copan->getFaAmount() }}</strong>
                        برای <strong>{{ $copan->type == 0 ? 'همه' : $copan->getUserAssignedCopan() }}</strong>
                        تا تاریخ <strong>{{ $copan->getFaEndDate() }}</strong> فعال است. برای<a
                            href="{{ route('copanDiscount.edit', $copan) }}"
                            class="alert-link"> ویرایش </a>کلیک کن.
                    @else
                        به تعداد <strong>{{ convertEnglishToPersian($copansCount) }}</strong>عدد کپن تخفیف فعال وجود
                        دارد.
                    @endif
                @else
                    هیچ <strong>کپن تخفیفی</strong> فعال نیست. برای افزودن <a
                        href="{{ route('copanDiscount.create') }}"
                        class="alert-link">تخفیف</a> کلیک کن.
                @endif
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
