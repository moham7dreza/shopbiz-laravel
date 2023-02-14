@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش کالا</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
    @livewireStyles
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش کالا</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('product.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.update', $product->id) }}" method="post"
                          enctype="multipart/form-data" id="form">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="name" label="نام کالا" :message="$message" method="edit"
                                           :model="$product"/>
                            <x-panel-select-box col="10" name="category_id" label="انتخاب دسته"
                                                :message="$message" :collection="$productCategories"
                                                property="name" method="edit" :model="$product"/>
                            <x-panel-select-box col="10" name="brand_id" label="انتخاب برند"
                                                :message="$message" :collection="$brands"
                                                property="original_name" method="edit" :model="$product"/>
                            <x-panel-input col="10" type="file" name="image" label="تصویر"
                                           :message="$message" method="edit" :model="$product"/>
                            <x-panel-image-index :model="$product"/>
                            <x-panel-input col="10" name="weight" label="وزن" :message="$message" method="edit"
                                           :model="$product"/>
                            <x-panel-input col="10" name="length" label="طول" :message="$message" method="edit"
                                           :model="$product"/>
                            <x-panel-input col="10" name="width" label="عرض" :message="$message" method="edit"
                                           :model="$product"/>
                            <x-panel-input col="10" name="height" label="ارتفاع" :message="$message" method="edit"
                                           :model="$product"/>
                            <livewire:fa-price-input col="10" name="price" label="قیمت کالا" :message="$message" class="dir-ltr"
                                                     method="edit"
                                                     :obj="$product"/>
                            <x-panel-text-area col="10" name="introduction" label="توضیحات" rows="12"
                                               :message="$message" method="edit" :model="$product"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" method="edit"
                                                :model="$product"/>
                            <x-panel-select-box col="10" name="marketable" label="قابل فروش بودن"
                                                :message="$message" :hasDefaultStatus="true" method="edit"
                                                :model="$product"/>
                            <x-panel-input col="10" name="published_at" label="تاریخ انتشار" :date="true" class="d-none"
                                           :message="$message" method="edit" :model="$product"/>


                            <section class="col-12 border-top py-3 mb-3">
                                @foreach ($product->metas as $meta)

                                    <section class="row meta-product">

                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="meta_key[{{ $meta->id }}]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $meta->meta_key }}">
                                            </div>
                                            @error('meta_key.*')
                                            <span class="alert alert-danger -p-1 mb-3 d-block font-size-80"
                                                  role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                            @enderror
                                        </section>
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <input type="text" name="meta_value[]"
                                                       class="form-control form-control-sm"
                                                       value="{{ $meta->meta_value }}">
                                            </div>
                                            @error('meta_value.*')
                                            <span class="alert alert-danger -p-1 mb-3 d-block font-size-80"
                                                  role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                            @enderror
                                        </section>
                                    </section>
                                @endforeach
                            </section>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')
    @livewireScripts
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        CKEDITOR.replace('introduction');
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
            // placeholder: 'لطفا دسته بندی را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
    <script>
        const brand_id = $('#brand_id');
        brand_id.select2({
            // placeholder: 'لطفا برند را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
