<!-- start ads section -->
<section class="">
    <section class="container-xxl">
        <!-- four column-->
        <section class="row py-4">
            @foreach ($repo->fourColumnBanners() as $colBanner)
                <section class="col">
                    <a href="{{ urldecode($colBanner->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ $colBanner->imagePath() }}"
                             alt="{{ $colBanner->title }}">
                    </a>
                </section>
            @endforeach
        </section>
    </section>
</section>
<!-- end ads section -->
