<!-- start slideshow -->
<section class="container-xxl my-4">
    <section class="row">
        <section class="col-md-12 pe-md-1">
            <section id="slideshow" class="owl-carousel owl-theme">

                @foreach ($repo->slideShowImages() as $slideShowImage)

                    <section class="item">
                        <a class="w-100 d-block h-auto text-decoration-none"
                           href="{{ urldecode($slideShowImage->url) }}">
                            <img class="w-100 rounded-2 d-block h-auto" src="{{ $slideShowImage->image() }}"
                                 alt="{{ $slideShowImage->title }}" title="{{ $slideShowImage->title }}" data-bs-toggle="tooltip" data-bs-placement="right">
                        </a>
                    </section>

                @endforeach

            </section>
        </section>
    </section>
</section>
<!-- end slideshow -->
