<!-- start ads section -->
<section class="mb-3">
    <section class="container-xxl">
        <!-- two column-->
        <section class="row py-4">
            @foreach ($repo->bottomMiddleBanners() as $middleBanner)
                <section class="col-12 col-md-6 mt-2 mt-md-0">
                    <a href="{{ urldecode($middleBanner->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ $middleBanner->image() }}"
                             alt="{{ $middleBanner->title }}" title="{{ $middleBanner->title }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    </a>
                </section>
            @endforeach

        </section>

    </section>
</section>
<!-- end ads section -->
