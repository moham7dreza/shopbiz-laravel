@if(!empty($repo->bottomBanner()))
    @php
        $bottomBanner = $repo->bottomBanner();
    @endphp
    <!-- start ads section -->
    <section class="mb-3">
        <section class="container-xxl">
            <!-- one column -->
            <section class="row py-4">
                <section class="col-12">
                    <a href="{{ urldecode($bottomBanner->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ $bottomBanner->image() }}"
                             alt="{{ $bottomBanner->title }}" title="{{ $bottomBanner->title }}" data-bs-toggle="tooltip" data-bs-placement="top">
                    </a>
                </section>
            </section>

        </section>
    </section>
    <!-- end ads section -->

@endif
