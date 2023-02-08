<!-- start brand part-->
<section class="brand-part mb-4 py-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start content header -->
                <section class="content-header">
                    <section class="d-flex align-items-center">
                        <h2 class="content-header-title">
                            <span>برندهای ویژه</span>
                        </h2>
                    </section>
                </section>
                <!-- start content header -->
                <section class="brands-wrapper py-4">
                    <section class="brands dark-owl-nav owl-carousel owl-theme">
                        @foreach ($repo->brands() as $brand)

                            <section class="item">
                                <section class="brand-item">
                                    <a href="{{ $brand->path() }}">
                                        <img class="rounded-2"
                                             src="{{ $brand->logo() }}" alt="{{ $brand->persian_name . '_' . $brand->original_name }}"
                                             title="{{ $brand->persian_name . '_' . $brand->original_name }}"
                                             data-bs-toggle="tooltip"
                                             data-bs-placement="top">
                                    </a>
                                </section>
                            </section>

                        @endforeach

                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end brand part-->
