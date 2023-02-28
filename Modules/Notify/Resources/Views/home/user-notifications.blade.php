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
                                <span>اعلان های شما</span>
                            </h2>
                            <section class="content-header-link m-2">

                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="order-wrapper m-1 p-4">
                            <section class="row">
                                @foreach($notifications as $notif)
                                    <section class="col-md-3 my-2">
                                        <section class="card">
                                            <section
                                                class="card-header bg-blue-light d-flex justify-content-between align-items-center">
                                                <small
                                                    class="font-weight-bold">{{ jalaliDate($notif->created_at, "%A, %d %B %Y _ H:i:s") }}</small>
                                            </section>
                                            <section class="card-body">
                                                <p class="card-text">
                                                    {{ $notif->data['message'] }}
                                                </p>
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
    <!-- end body -->
@endsection
