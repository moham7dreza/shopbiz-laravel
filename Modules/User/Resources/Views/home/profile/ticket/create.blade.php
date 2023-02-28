@extends('Home::layouts.master-one-col')

@section('head-tag')
    <title>افزودن تیکت جدید</title>
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                @include('Home::layouts.partials.profile-sidebar')
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start content header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>افزودن تیکت </span>
                                </h2>
                                <section class="content-header-link m-2">
                                    <x-panel-a-tag route="{{ route('customer.profile.my-tickets') }}"
                                                   title="بازگشت"
                                                   icon="reply" color="outline-danger"/>
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="order-wrapper">
                            <section class="mt-2">
                                <p class="p-2 fw-bold"><i class="fa fa-check text-lightblue mx-2"></i>قبل از مطرح کردن
                                    هرگونه سوال ، بخش <a href="{{ route('customer.pages.faq') }}"
                                                         class="text-decoration-none" title="کلیک کنید"
                                                         data-bs-placement="top" data-bs-toggle="tooltip">سوالات
                                        متداول</a> را مطالعه نمایید.</p>
                            </section>
                            <section class="">
                                <form action="{{ route('customer.profile.my-tickets.store') }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <section class="row">
                                        @php $message = $message ?? null @endphp
                                        <x-panel-input col="12" name="subject" label="عنوان" :message="$message"/>
                                        <x-panel-select-box col="6" name="category_id" label="انتخاب دسته"
                                                            dadClass="my-2"
                                                            :message="$message" :collection="$ticketCategories"
                                                            property="name" option="دسته را انتخاب کنید"/>
                                        <x-panel-select-box col="6" class="my-5" name="priority_id"
                                                            label="انتخاب اولویت" dadClass="my-2"
                                                            :message="$message" :collection="$ticketPriorities"
                                                            property="name" option="اولویت را انتخاب کنید"/>
                                        <x-panel-text-area col="12" name="description" label="متن" rows="12"
                                                           dadClass="mb-2"
                                                           :message="$message"/>
                                        <x-panel-input col="12" type="file" name="file" label="فایل"
                                                       :message="$message"/>
                                        <x-panel-button col="12" title="ثبت" loc="home" align="end"/>

                                    </section>
                                </form>
                            </section>

                        </section>

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>

    <script>
        const category_id = $('#category_id');
        category_id.select2({
            placeholder: 'لطفا دسته بندی را وارد نمایید',
            multiple: false,
            tags: false
        })
    </script>

    <script>
        const priority_id = $('#priority_id');
        priority_id.select2({
            placeholder: 'لطفا دسته بندی را وارد نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
