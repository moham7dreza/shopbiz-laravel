<aside id="sidebar" class="sidebar col-md-3">
    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
        <!-- start sidebar nav-->
        <section class="sidebar-nav mt-2 px-3">
            @foreach($categories as $category)
                <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title">{{ $category->name }}<i
                                        class="fa fa-angle-left"></i></span>
                    <section class="sidebar-nav-sub-wrapper">
                        @foreach($category->children as $subCategory)
                            @if($subCategory->status == 1)
                                <section class="sidebar-nav-sub-item">

                                        <span class="sidebar-nav-sub-item-title">
                                            <a href="{{ route('customer.market.category.products', $subCategory) }}">{{ $subCategory->name }}</a>
                                            <i class="fa fa-angle-left"></i></span>
                                    <section class="sidebar-nav-sub-sub-wrapper">
                                        @if(count($subCategory->children) > 0)
                                            @foreach($subCategory->children as $child)
                                                @if($child->status == 1)
                                                    <section class="sidebar-nav-sub-sub-item"><a
                                                            href="{{ route('customer.market.category.products', $child) }}">{{ $child->name }}</a>
                                                    </section>
                                                @endif
                                            @endforeach
                                        @endif
                                    </section>
                                </section>
                            @endif
                        @endforeach
                    </section>
                </section>
            @endforeach
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
            <form action="{{ route('customer.market.category.products', [$productCategory]) }}" class="d-flex">
                <input name="category_products_search" class="sidebar-input-text" type="text" placeholder="جستجو بر اساس نام، برند ...">
                <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
            </form>
        </section>
    </section>
    <form action="{{ route('customer.market.category.products', [$productCategory]) }}">
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
                            <input name="brands[]" class="form-check-input" type="checkbox" value="{{ $brand->id }}" id="{{ $brand->id }}">
                            <label class="form-check-label d-flex justify-content-between" for="{{ $brand->id }}">
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
                                <input name="attrs[]" class="form-check-input" type="checkbox" value="{{ $value->id }}" id="{{ $value->id }}">
                                <label class="form-check-label" for="{{ $value->id }}">
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
                <section class="p-1"><input name="price_from" type="text" placeholder="قیمت از ..."></section>
                <section class="p-1"><input name="price_to" type="text" placeholder="قیمت تا ..."></section>
            </section>
        </section>


        <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
            <section class="sidebar-filter-btn d-grid gap-2">
                <button class="btn btn-danger" type="submit">اعمال فیلتر</button>
            </section>
        </section>
    </form>


</aside>
