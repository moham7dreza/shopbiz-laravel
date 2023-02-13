@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد پست</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('post.index') }}"> پست</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد پست</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد پست
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('post.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data"
                          id="form">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="title" label="عنوان پست" :message="$message"/>
                            <x-panel-select-box col="10" name="category_id" label="انتخاب دسته"
                                                :message="$message" :collection="$postCategories"
                                                property="name" option="دسته را انتخاب کنید"/>
                            <x-panel-input col="10" name="time_to_read" label="زمان مطالعه" :message="$message"
                                           placeholder="بر حسب دقیقه ..."/>
                            <x-panel-input col="10" name="keywords" type="hidden" label="کلمات کلیدی"
                                           :message="$message" :select2="true"/>
                            <x-panel-input col="10" type="file" name="image" label="تصویر"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-select-box col="10" name="commentable" label="امکان درج کامنت"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-input col="10" name="published_at" label="تاریخ انتشار" :date="true" class="d-none"
                                           :message="$message"/>
                            <x-panel-text-area col="10" name="summary" label="خلاصه پست" rows="12"
                                               :message="$message"/>
                            <x-panel-text-area col="10" name="body" label="متن پست" rows="12"
                                               :message="$message"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        CKEDITOR.replace('body');
        CKEDITOR.replace('summary');
    </script>

    <script>
        $(document).ready(function () {
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#published_at'
            })
        });
    </script>

    <script>
        const category_id = $('#category_id');
        category_id.select2({
            placeholder: 'لطفا دسته بندی را وارد نمایید',
            multiple: false,
            tags: false
        })
    </script>
    @include('Share::functions.panel.tags', ['id' => 'keywords'])
@endsection
