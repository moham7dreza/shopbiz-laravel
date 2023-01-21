@extends('Home::layouts.master-profile')

@section('head-tag')

    <!-- Meta Description -->
    <meta name="description" content="لیست آدرس های کاربر">
    <!-- Meta Keyword -->
    <meta name="keywords" content="لیست آدرس های کاربر">

    <title>لیست آدرس های شما</title>
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
    <script>
        $(document).ready(function () {
            $('#province').change(function () {
                var element = $('#province option:selected');
                var url = element.attr('data-url');

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (response) {
                        if (response.status) {
                            let cities = response.cities;
                            $('#city').empty();
                            cities.map((city) => {
                                $('#city').append($('<option/>').val(city.id).text(city
                                    .name))
                            })
                        } else {
                            errorToast('خطا پیش آمده است')
                        }
                    },
                    error: function () {
                        errorToast('خطا پیش آمده است')
                    }
                })
            })


            // edit
            var addresses = {!! auth()->user()->addresses !!}
            // console.log(addresses);
            addresses.map(function (address) {
                var id = address.id;
                var target = `#province-${id}`;
                var selected = `${target} option:selected`
                $(target).change(function () {
                    var element = $(selected);
                    var url = element.attr('data-url');

                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (response) {
                            if (response.status) {
                                let cities = response.cities;
                                $(`#city-${id}`).empty();
                                cities.map((city) => {
                                    $(`#city-${id}`).append($('<option/>').val(
                                        city.id).text(city
                                        .name))
                                })
                            } else {
                                errorToast('خطا پیش آمده است')
                            }
                        },
                        error: function () {
                            errorToast('خطا پیش آمده است')
                        }
                    })
                })
            })

            @include('Panel::alerts.toast.functions.toasts')

        })
    </script>
@endsection
