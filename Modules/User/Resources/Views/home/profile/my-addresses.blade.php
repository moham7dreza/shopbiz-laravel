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
                                    <span>آدرس های من</span>
                                </h2>

                            </section>
                        </section>
                        <!-- end content header -->


                        <section class="address-select">

                            @include('Address::partials.user-addresses')

                            @include('Address::partials.add-address')

                        </section>

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection


@section('script')
    @include('Share::ajax-functions.home.address')
@endsection
