@extends('Home::layouts.master-one-col')

@section('head-tag')
    {!! SEO::generate() !!}
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
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

                        <section class="order-wrapper m-5 border rounded-3">
                            <section class="row">
                                <section class="col-md-12 my-2 px-5 py-2">
                                    <form action="{{ route('customer.pages.make-appointment.submit') }}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <section class="row">
                                            @php $message = $message ?? null @endphp
                                            <x-panel-input col="6" name="first_name" label="نام"
                                                           :message="$message"/>
                                            <x-panel-input col="6" name="last_name" label="نام خانوادگی"
                                                           :message="$message"/>
                                            <x-panel-input col="6" name="email" type="email" label="ایمیل"
                                                           dadClass="my-2"
                                                           :message="$message"/>
                                            <x-panel-input col="6" name="phone" label=" شماره موبایل" dadClass="my-2"
                                                           :message="$message"/>
                                            <x-panel-input col="6" name="subject" label="عنوان ملاقات" dadClass="my-2"
                                                           :message="$message"/>
                                            <x-panel-input col="6" name="meet_date" label="انتخاب زمان ملاقات"
                                                           :date="true" class="d-none" dadClass="my-2"
                                                           :message="$message"/>
                                            <x-panel-text-area col="12" name="message" label="توضیحات" rows="12"
                                                               dadClass="mb-2"
                                                               :message="$message"/>
                                            <x-panel-input col="12" type="file" name="file" label="فایل"
                                                           :message="$message"/>
                                            <x-panel-button col="12" title="ثبت جلسه" align="end" loc="home"/>

                                        </section>
                                    </form>
                                </section>
                            </section>
                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('message');
    </script>

    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#meet_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#meet_date',
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                }
            })
        });
    </script>

@endsection
