<!-- start slideshow -->
<section class="container-xxl my-4">
    <section class="row">
        <section class="col-md-8 pe-md-1 ">
            <section id="slideshow" class="owl-carousel owl-theme">

                @foreach ($repo->slideShowImages() as $slideShowImage)

                    <section class="item">
                        <a class="w-100 d-block h-auto text-decoration-none"
                           href="{{ urldecode($slideShowImage->url) }}">
                            <img class="w-100 rounded-2 d-block h-auto" src="{{ $slideShowImage->image() }}"
                                 alt="{{ $slideShowImage->title }}" title="{{ $slideShowImage->title }}" data-bs-toggle="tooltip" data-bs-placement="left">
                        </a>
                    </section>

                @endforeach

            </section>
        </section>
        <section class="col-md-4 ps-md-1 mt-2 mt-md-0">
            @foreach ($repo->topBanners() as $topBanner)
                <section class="mb-2">
                    <a href="{{ urldecode($slideShowImage->url) }}" class="d-block">
                        <img class="w-100 rounded-2" src="{{ $topBanner->image() }}"
                             alt="{{ $topBanner->title }}" title="{{ $topBanner->title }}" data-bs-toggle="tooltip" data-bs-placement="left">
                    </a>
                </section>
            @endforeach

        </section>
    </section>
</section>
<!-- end slideshow -->
