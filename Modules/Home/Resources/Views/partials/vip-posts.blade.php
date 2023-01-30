<!-- start product lazy load -->
<section class="mb-3">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>جدیدترین پست ها</span>
                            </h2>
                            <section class="content-header-link">
                                <a href="#">مشاهده
                                    همه</a>
                            </section>
                        </section>
                    </section>
                    <!-- end content header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">

                            @foreach ($repo->posts() as $post)
                                @php
                                    $hasFavorited = auth()->user()->hasFavorited($post);
                                    $hasLiked = auth()->user()->hasLiked($post);
                                @endphp
                                <section class="item">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <button class="btn btn-light btn-sm text-decoration-none"
                                                            data-url="{{ route('customer.post.add-to-favorite', $post) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="اضافه به علاقه مندی">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </section>
                                            @endguest
                                            <section class="product-link">
                                                <a href="{{ route('customer.post.detail', $post) }}">
                                                    <section class="product-image">
                                                        <img class=""
                                                             src="{{ $post->imagePath() }}"
                                                             alt="{{$post->name }}">
                                                    </section>
                                                </a>
                                                <section class="d-flex flex-column">
                                                    <section class="product-name mb-0">
                                                        <h2>{{ $post->limitedTitle() }}</h2>
                                                    </section>
                                                    <section class="post-summary my-3">
                                                        <p>{!! $post->limitedSummary(100) !!}</p>
                                                    </section>
                                                    <section
                                                        class="d-flex justify-content-end align-items-center post-count my-2">
                                                        <span><i class="fa fa-eye mx-2"></i>{{ $post->getFaViewsCount() }}</span>
                                                        <span><i class="fa fa-comment mx-2"></i>{{ $post->allActivePostCommentsCount() }}</span>
                                                    </section>

                                                    <section
                                                        class="d-flex align-items-center justify-content-start gap-1 post-user border-top">
                                                        <span><i class="fa fa-user"></i></span>
                                                        <a href="{{ route('customer.author.bio', $post->author) }}"
                                                           class="author text-decoration-none text-dark pointer mt-2">
                                                            <span>{{ $post->textAuthorName() }}</span>
                                                        </a>
                                                    </section>

                                                    <section
                                                        class="d-flex align-items-center justify-content-end gap-2">
                                                        @auth
                                                            @if ($hasLiked)
                                                                <section class="post-like-btn">
                                                                    <button
                                                                        class="btn btn-light btn-sm text-decoration-none"
                                                                        data-url="{{ route('customer.post.like', $post) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        title="لایک نکردن">
                                                                        <i class="fa fa-heart text-danger"></i>
                                                                    </button>
                                                                </section>
                                                            @else
                                                                <section class="post-like-btn">
                                                                    <button
                                                                        class="btn btn-light btn-sm text-decoration-none"
                                                                        data-url="{{ route('customer.post.like', $post) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        title="لایک کردن">
                                                                        <i class="fa fa-heart"></i>
                                                                    </button>
                                                                </section>
                                                            @endif
                                                            @if ($hasFavorited)
                                                                <section class="post-favorite-btn">
                                                                    <button
                                                                        class="btn btn-light btn-sm text-decoration-none"
                                                                        data-url="{{ route('customer.post.add-to-favorite', $post) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        title="حذف از علاقه مندی">
                                                                        <i class="fa fa-bookmark text-danger"></i>
                                                                    </button>
                                                                </section>
                                                            @else
                                                                <section class="post-favorite-btn">
                                                                    <button
                                                                        class="btn btn-light btn-sm text-decoration-none"
                                                                        data-url="{{ route('customer.post.add-to-favorite', $post) }}"
                                                                        data-bs-toggle="tooltip"
                                                                        data-bs-placement="left"
                                                                        title="اضافه به علاقه مندی">
                                                                        <i class="fa fa-bookmark"></i>
                                                                    </button>
                                                                </section>
                                                            @endif
                                                        @endauth
                                                    </section>
                                                </section>
                                            </section>
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
