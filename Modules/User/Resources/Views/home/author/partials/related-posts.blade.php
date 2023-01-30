<!-- start product lazy load -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>کالاهای مرتبط</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- start content header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">

                            @foreach ($relatedPosts as $relatedPost)
                                @php
                                    $hasFavorited = auth()->user()->hasFavorited($relatedPost);
                                    $hasLiked = auth()->user()->hasLiked($relatedPost);
                                @endphp
                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.post.add-to-favorite', $relatedPost) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            @auth
                                                @if ($hasFavorited)
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.post.add-to-favorite', $relatedPost) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="حذف از علاقه مندی">
                                                            <i class="fa fa-heart text-danger"></i>
                                                        </button>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <button class="btn btn-light btn-sm text-decoration-none"
                                                                data-url="{{ route('customer.post.add-to-favorite', $relatedPost) }}"
                                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                                title="اضافه به علاقه مندی">
                                                            <i class="fa fa-heart"></i>
                                                        </button>
                                                    </section>
                                                @endif
                                            @endauth
                                            <a class="product-link"
                                               href="{{ $relatedPost->path() }}">
                                                <section class="product-image">
                                                    <img class=""
                                                         src="{{ $relatedPost->imagePath() }}"
                                                         alt="{{$relatedPost->name }}">
                                                </section>
                                                <section class="product-name">
                                                    <h3>{{ $relatedPost->limitedTitle() }}</h3></section>
                                                <section class="product-price-wrapper">
                                                    <section
                                                        class="product-price">{{ $relatedPost->time_to_read }}
                                                    </section>
                                                </section>
                                            </a>
                                        </section>
                                    </section>
                                </section>
                            @endforeach


                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end product lazy load -->
