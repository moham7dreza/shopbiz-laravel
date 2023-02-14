@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش بنر</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('banner.index') }}"> بنر</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش بنر</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش بنر
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('banner.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('banner.update', $banner->id) }}" method="POST"
                          enctype="multipart/form-data" id="form">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="title" label="عنوان بنر" :message="$message"
                                           method="edit" :model="$banner"/>

                            <x-panel-input col="10" type="file" name="image" label="تصویر بنر"
                                           :message="$message" method="edit" :model="$banner" :showImage="true"/>

                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" method="edit"
                                                :model="$banner"/>

                            <x-panel-input col="10" name="url" label="آدرس URL" class="dir-ltr text-left"
                                           :message="$message" method="edit" :model="$banner"/>

                            <x-panel-select-box col="10" name="position" label="موقعیت بنر"
                                                :message="$message" :arr="$positions" method="edit"
                                                :model="$banner"/>

                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
