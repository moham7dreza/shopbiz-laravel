@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسته بندی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('productCategory.index') }}"> دسته بندی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد دسته بندی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد دسته بندی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('productCategory.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('productCategory.store') }}" method="post"
                          enctype="multipart/form-data" id="form">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="name" label="نام دسته"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="parent_id" label="دسته والد"
                                                :message="$message" :collection="$categories"
                                                property="name" option="دسته ی اصلی"/>
                            <x-panel-text-area col="10" name="description" label="توضیحات" rows="12"
                                               :message="$message"/>
                            <x-panel-input col="10" type="file" name="image" label="تصویر"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-select-box col="10" name="show_in_menu" label="نمایش در منو"
                                                :message="$message" :hasDefaultStatus="true"/>
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
    <script>
        CKEDITOR.replace('description');
    </script>

    <script>
        const parent_id = $('#parent_id');
        parent_id.select2({
            // placeholder: 'لطفا دسته بندی را وارد نمایید',
            multiple: false,
            tags: false
        })
    </script>

@endsection

