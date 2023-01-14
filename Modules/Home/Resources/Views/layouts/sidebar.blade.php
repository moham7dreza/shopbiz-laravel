<aside id="sidebar" class="sidebar col-md-3">
    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
        <!-- start sidebar nav-->
        <section class="sidebar-nav">
            <section class="sidebar-nav-item">
                <span class="sidebar-nav-item-title">کالای دیجیتال <i class="fa fa-angle-left"></i></span>
                <section class="sidebar-nav-sub-wrapper">
                    <section class="sidebar-nav-sub-item">
                        <span class="sidebar-nav-sub-item-title"><a href="#">لوازم جانبی موبایل</a><i
                                class="fa fa-angle-left"></i></span>
                        <section class="sidebar-nav-sub-sub-wrapper">
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هندزفری</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هدست</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">اسپیکر موبایل</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">پاوربانک</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هندزفری بیسیم</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">قاب موبایل</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هولدر نگهدارنده</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">شارژر بیسیم</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">مونوپاد</a></section>
                        </section>
                    </section>
                    <section class="sidebar-nav-sub-item">
                        <span class="sidebar-nav-sub-item-title"><a href="#">لوازم جانبی موبایل</a><i
                                class="fa fa-angle-left"></i></span>
                        <section class="sidebar-nav-sub-sub-wrapper">
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هندزفری</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هدست</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">اسپیکر موبایل</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">پاوربانک</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هندزفری بیسیم</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">قاب موبایل</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">هولدر نگهدارنده</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">شارژر بیسیم</a></section>
                            <section class="sidebar-nav-sub-sub-item"><a href="#">مونوپاد</a></section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
        <!--end sidebar nav-->
    </section>

    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
        <section class="content-header mb-3">
            <section class="d-flex justify-content-between align-items-center">
                <h2 class="content-header-title content-header-title-small">
                    جستجو در نتایج
                </h2>
                <section class="content-header-link">
                    <!--<a href="#">مشاهده همه</a>-->
                </section>
            </section>
        </section>

        <section class="">
            <input class="sidebar-input-text" type="text" placeholder="جستجو بر اساس نام، برند ...">
        </section>
    </section>
    @if(!is_null($productCategory))
        <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
            <section class="content-header mb-3">
                <section class="d-flex justify-content-between align-items-center">
                    <h2 class="content-header-title content-header-title-small">
                        برند
                    </h2>
                    <section class="content-header-link">
                        <!--<a href="#">مشاهده همه</a>-->
                    </section>
                </section>
            </section>

            <section class="sidebar-brand-wrapper">
                @foreach($brands as $brand)
                    <section class="form-check sidebar-brand-item">
                        <input class="form-check-input" type="checkbox" value="1" id="1">
                        <label class="form-check-label d-flex justify-content-between" for="1">
                            <span>{{ $brand->persian_name }}</span>
                            <span>{{ $brand->original_name }}</span>
                        </label>
                    </section>
                @endforeach

            </section>
        </section>


        @foreach($productCategory->attributes as $attribute)
            <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                <section class="content-header mb-3">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title content-header-title-small">
                            {{ $attribute->name }}
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="sidebar-brand-wrapper">
                    @foreach($attribute->values as $value)
                        <section class="form-check sidebar-brand-item">
                            <input class="form-check-input" type="checkbox" value="1" id="1">
                            <label class="form-check-label" for="1">
                                <span>{{ json_decode($value->value, true)['value'] . ' ' . $attribute->unit }}</span>
                            </label>
                        </section>
                    @endforeach

                </section>
            </section>
        @endforeach
    @else
        <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
            <section class="content-header mb-3">
                <section class="d-flex justify-content-between align-items-center">
                    <h2 class="content-header-title content-header-title-small">
                        برند
                    </h2>
                    <section class="content-header-link">
                        <!--<a href="#">مشاهده همه</a>-->
                    </section>
                </section>
            </section>

            <section class="sidebar-brand-wrapper">
                @foreach($brands as $brand)
                    <section class="form-check sidebar-brand-item">
                        <input class="form-check-input" type="checkbox" value="1" id="1">
                        <label class="form-check-label d-flex justify-content-between" for="1">
                            <span>{{ $brand->persian_name }}</span>
                            <span>{{ $brand->original_name }}</span>
                        </label>
                    </section>
                @endforeach

            </section>
        </section>
    @endif

    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
        <section class="content-header mb-3">
            <section class="d-flex justify-content-between align-items-center">
                <h2 class="content-header-title content-header-title-small">
                    محدوده قیمت
                </h2>
                <section class="content-header-link">
                    <!--<a href="#">مشاهده همه</a>-->
                </section>
            </section>
        </section>
        <section class="sidebar-price-range d-flex justify-content-between">
            <section class="p-1"><input type="text" placeholder="قیمت از ..."></section>
            <section class="p-1"><input type="text" placeholder="قیمت تا ..."></section>
        </section>
    </section>


    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
        <section class="sidebar-filter-btn d-grid gap-2">
            <button class="btn btn-danger" type="button">اعمال فیلتر</button>
        </section>
    </section>

</aside>
