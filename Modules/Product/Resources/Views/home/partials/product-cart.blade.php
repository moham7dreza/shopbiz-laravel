<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">

            <x-share-error/>

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

                    <!-- end image gallery -->
                    @include('Product::home.partials.product-images')
                    <!-- start product info -->
                    @include('Product::home.partials.product-info')
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
                                    <p class="text-muted">تخفیف کالا (<span class="text-danger font-weight-bold mx-1">{{ $amazingSale->getFaPercentage() }}</span>)
                                    </p>
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
                                @if($product->marketable_number < 10 && $product->marketable_number > 0)
                                    <span
                                        class="text-danger mb-2">تنها <strong>{{ convertEnglishToPersian($product->marketable_number) }}</strong> عدد در انبار باقی مانده</span>
                                    <button id="next-level" class="btn btn-danger d-block w-100"
                                            onclick="document.getElementById('add_to_cart').submit();">افزودن به سبد
                                        خرید
                                    </button>
                                @elseif($product->marketable_number == 0)
                                    <button id="next-level" class="btn btn-secondary disabled d-block">محصول نا موجود
                                        میباشد
                                    </button>
                                @else
                                    <button id="next-level" class="btn btn-danger d-block w-100"
                                            onclick="document.getElementById('add_to_cart').submit();">افزودن به سبد
                                        خرید
                                    </button>
                                @endif
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->
