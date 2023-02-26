@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">

                <section class="col-md-12">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start content header -->
                        <section class="content-header my-2">
                            <h2 class="content-header-title">
                                <span>{{ \Artesaos\SEOTools\Facades\SEOMeta::getTitle() }}</span>
                            </h2>
                            <section class="content-header-link m-2">

                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="order-wrapper m-1">
                            <div class="border border-light rounded-3 my-2 ms-4">
                                @foreach ($faqs as $faq)

                                    <section class="card m-4">
                                        <section
                                            class="card-header bg-blue-light d-flex justify-content-between align-items-center">
                                            <div> {{ $faq->question }}</div>
                                            <small
                                                class="font-weight-bold"></small>
                                        </section>
                                        <section class="card-body">
                                            <p class="card-text">
                                                {!! $faq->answer !!}
                                            </p>
                                        </section>
                                    </section>
                                @endforeach
                            </div>
                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
