@if(!empty($repo->bottomBanner()))
    <!-- start ads section -->
    <section class="mb-3">
        <section class="container-xxl">
            <!-- one column -->
            <section class="row py-4">
                <section class="col">
                    <a href="{{ urldecode($repo->bottomBanner()->url) }}">
                        <img class="d-block rounded-2 w-100" src="{{ $repo->bottomBanner()->imagePath() }}"
                             alt="{{ $repo->bottomBanner()->title }}">
                    </a>
                </section>
            </section>

        </section>
    </section>
    <!-- end ads section -->

@endif
