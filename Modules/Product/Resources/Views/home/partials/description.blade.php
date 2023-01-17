<!-- start description, features and comments -->
<section class="mb-4">
    <section class="container-xxl" >
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section id="introduction-features-comments" class="introduction-features-comments">
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span class="me-2"><a class="text-decoration-none text-dark" href="#introduction">معرفی</a></span>
                                    <span class="me-2"><a class="text-decoration-none text-dark" href="#features">ویژگی ها</a></span>
                                    <span class="me-2"><a class="text-decoration-none text-dark" href="#comments">دیدگاه ها</a></span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                    </section>
                    <!-- start content header -->

                    <section class="py-4">

                        <!-- start content header -->
                        <section id="introduction" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    معرفی
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="product-introduction mb-4">
                            {!! $product->introduction !!}
                        </section>

                        <!-- start content header -->
                        <section id="features" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    ویژگی ها
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="product-features mb-4 table-responsive">
                            <table class="table table-bordered border-white">
                                @foreach ($product->values()->get() as $value)
                                    <tr>
                                        <td>{{ $value->attribute()->first()->name }}</td>
                                        <td>{{ json_decode($value->value)->value }} {{ $value->attribute()->first()->unit }}</td>
                                    </tr>
                                @endforeach

                                @foreach ($product->metas()->get() as $meta)
                                    <tr>
                                        <td>{{ $meta->meta_key }}</td>
                                        <td>{{ $meta->meta_value }}</td>
                                    </tr>
                                @endforeach


                            </table>
                        </section>

                        <!-- start content header -->
                        <section id="comments" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    دیدگاه ها
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="product-comments mb-4">

                            <section class="comment-add-wrapper">
                                <button class="comment-add-button" type="button" data-bs-toggle="modal" data-bs-target="#add-comment" ><i class="fa fa-plus"></i> افزودن دیدگاه</button>
                                <!-- start add comment Modal -->
                                <section class="modal fade" id="add-comment" tabindex="-1" aria-labelledby="add-comment-label" aria-hidden="true">
                                    <section class="modal-dialog">
                                        <section class="modal-content">
                                            <section class="modal-header">
                                                <h5 class="modal-title" id="add-comment-label"><i class="fa fa-plus"></i> افزودن دیدگاه</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </section>
                                            @guest
                                                <section class="modal-body">
                                                    <p>کاربر گرامی لطفا برای ثبت نظر ابتدا وارد حساب کاربری خود شوید </p>
                                                    <p>لینک ثبت نام و یا ورود
                                                        <a href="{{ route('auth.login-register-form') }}">کلیک کنید</a>
                                                    </p>
                                                </section>
                                            @endguest
                                            @auth

                                                <section class="modal-body">
                                                    <form class="row" action="{{ route('customer.market.add-comment', $product) }}" method="post">
                                                        @csrf
                                                        {{-- <section class="col-6 mb-2">
                                                            <label for="first_name" class="form-label mb-1">نام</label>
                                                            <input type="text" class="form-control form-control-sm" id="first_name" placeholder="نام ...">
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="last_name" class="form-label mb-1">نام خانوادگی</label>
                                                            <input type="text" class="form-control form-control-sm" id="last_name" placeholder="نام خانوادگی ...">
                                                        </section> --}}

                                                        <section class="col-12 mb-2">
                                                            <label for="comment" class="form-label mb-1">دیدگاه شما</label>
                                                            <textarea class="form-control form-control-sm" id="comment" placeholder="دیدگاه شما ..." rows="4" name="body"></textarea>
                                                        </section>

                                                </section>
                                                <section class="modal-footer py-1">
                                                    <button type="submit" class="btn btn-sm btn-primary">ثبت دیدگاه</button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">بستن</button>
                                                </section>
                                                </form>
                                            @endauth
                                        </section>
                                    </section>
                                </section>
                            </section>

                            @foreach ($product->activeComments() as $activeComment)
                                <section class="product-comment">
                                    <section class="product-comment-header d-flex justify-content-start">
                                        <section class="product-comment-date">{{ jalaliDate($activeComment->created_at) }}</section>
                                        @php
                                            $author = $activeComment->user()->first();
                                        @endphp
                                        <section class="product-comment-title">
                                            @if(empty($author->first_name) && empty($author->last_name))
                                                ناشناس
                                            @else
                                                {{ $author->first_name . ' ' . $author->last_name }}
                                            @endif
                                        </section>
                                    </section>
                                    <section class="product-comment-body @if($activeComment->answers()->count() > 0) border-bottom  @endif">
                                        {!! $activeComment->body !!}
                                    </section>


                                    @foreach ($activeComment->answers()->get() as $commentAnswer)
                                        <section class="product-comment">
                                            <section class="product-comment-header d-flex justify-content-start">
                                                <section class="product-comment-date">{{ jalaliDate($commentAnswer->created_at) }}</section>
                                                @php
                                                    $author = $commentAnswer->user()->first();
                                                @endphp
                                                <section class="product-comment-title">
                                                    @if(empty($author->first_name) && empty($author->last_name))
                                                        ناشناس
                                                    @else
                                                        {{ $author->first_name . ' ' . $author->last_name }}
                                                    @endif
                                                </section>
                                            </section>
                                            <section class="product-comment-body @if($commentAnswer->answers()->count() > 0) border-bottom @endif">
                                                {!! $commentAnswer->body !!}
                                            </section>
                                        </section>
                                    @endforeach


                                </section>
                            @endforeach



                        </section>
                    </section>

                </section>
            </section>
        </section>
    </section>
</section>
<!-- end description, features and comments -->
