@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد بنر</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('banner.index') }}"> بنر</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد بنر</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد بنر
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('banner.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data"
                          id="form">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="6" name="title" label="عنوان بنر" :message="$message"/>

                            <x-panel-input col="6" type="file" name="image" label="تصویر بنر"
                                           :message="$message"/>

                            <x-panel-status col="6" name="status" label="وضعیت بنر" :message="$message"/>

                            <x-panel-input col="6" name="url" label="آدرس URL" class="dir-ltr"
                                           :message="$message"/>

                            <x-panel-select-box col="6" name="position" label="موقعیت بنر"
                                                :message="$message" :arr="$positions"/>

                            <x-panel-button col="12" title="ثبت"/>

                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')
    <script>
        var position = $('#position');
        position.select2({
            // placeholder: 'لطفا منو را وارد نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
