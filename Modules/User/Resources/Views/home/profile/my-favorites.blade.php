@extends('Home::layouts.master-profile')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection


@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <section class="row">


                @include('Home::layouts.partials.profile-sidebar')


                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start content header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>لیست علاقه های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->
                        <section class="d-flex gap-2">
                            <i class="fa fa-shopping-cart mx-1"></i><h6> کالاها </h6>
                        </section>
                        @forelse ($products as $product)
                            <section class="cart-item d-flex py-3">
                                <section class="cart-img align-self-start flex-shrink-1"><img
                                        src="{{ $product->imagePath() }}" alt="{{ $product->name }}"></section>
                                <section class="d-flex flex-column justify-content-around">
                                    <section class="align-self-start w-100">
                                        <p>{!! $product->name !!}</p>
                                    </section>
                                    <section class="w-100">
                                        <p>{!! $product->introduction !!}</p>
                                    </section>
                                    <section class="align-self-end w-100">
                                        <section>
                                            <a class="text-decoration-none cart-delete"
                                               href="{{ route('customer.profile.my-favorites.product-delete', $product) }}"><i
                                                    class="fa fa-trash-alt"></i> حذف از لیست علاقه ها</a>
                                        </section>
                                    </section>
                                </section>
                                <section class="w-25"></section>
                                <section class="align-self-end flex-shrink-1">
                                    <section class="text-nowrap fw-bold">{{ $product->getFaPrice() }}
                                    </section>
                                </section>
                            </section>
                        @empty
                            <section class="order-item">
                                <section class="d-flex justify-content-between">
                                    <p>محصولی یافت نشد</p>
                                </section>
                            </section>
                        @endforelse
                        <section class="d-flex gap-2 mt-2">
                            <i class="fa fa-blog mx-1"></i><h6> پست ها </h6>
                        </section>
                        @forelse ($posts as $post)
                            <section class="cart-item d-flex py-3">
                                <section class="cart-img align-self-start flex-shrink-1"><img
                                        src="{{ $post->imagePath() }}" alt="{{ $post->title }}" title="{{ $post->title }}"></section>
                                <section class="d-flex flex-column justify-content-between">
                                    <section class="align-self-start w-100">
                                        <p>{!! $post->title !!}</p>
                                    </section>
                                    <section class="w-100">
                                        <p>{!! $post->summary !!}</p>
                                    </section>
                                    <section class="align-self-end w-100">
                                        <section>
                                            <a class="text-decoration-none cart-delete"
                                               href="{{ route('customer.profile.my-favorites.post-delete', $post) }}"><i
                                                    class="fa fa-trash-alt"></i> حذف از لیست علاقه ها</a>
                                        </section>
                                    </section>
                                </section>
                                <section class="w-25"></section>
                                <section class="align-self-end flex-shrink-1">
                                    <section class="text-nowrap fw-bold">زمان انتشار : {{ $post->getFaPublishDate() }}
                                    </section>
                                </section>
                            </section>
                        @empty
                            <section class="order-item">
                                <section class="d-flex justify-content-between">
                                    <p>پستی یافت نشد</p>
                                </section>
                            </section>
                        @endforelse


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
