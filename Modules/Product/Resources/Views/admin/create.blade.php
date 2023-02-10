@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد کالا</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">کالا </a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('product.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data"
                          id="form">
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام کالا</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('name')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="category_id">انتخاب دسته</label>
                                    <select name="category_id" id="category_id" class="form-control form-control-sm">
                                        <option value="">دسته را انتخاب کنید</option>
                                        @foreach ($productCategories as $productCategory)
                                            <option value="{{ $productCategory->id }}"
                                                    @if(old('category_id') == $productCategory->id) selected @endif>{{ $productCategory->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('category_id')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="brand_id">انتخاب برند</label>
                                    <select name="brand_id" id="brand_id" class="form-control form-control-sm">
                                        <option value="">برند را انتخاب کنید</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                    @if(old('brand_id') == $brand->id) selected @endif>{{ $brand->original_name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('brand_id')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تصویر </label>
                                    <input type="file" name="image" class="form-control form-control-sm">
                                </div>
                                @error('image')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">وزن</label>
                                    <input type="text" name="weight" value="{{ old('weight') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('weight')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">طول</label>
                                    <input type="text" name="length" value="{{ old('length') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('length')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">عرض</label>
                                    <input type="text" name="width" value="{{ old('width') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('width')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ارتفاع</label>
                                    <input type="text" name="height" value="{{ old('height') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('height')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">قیمت کالا</label>
                                    <input type="text" name="price" value="{{ old('price') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('price')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">توضیحات</label>
                                    <textarea name="introduction" id="introduction" name="introduction"
                                              class="form-control form-control-sm"
                                              rows="6">{{ old('introduction') }}</textarea>
                                </div>
                                @error('introduction')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" class="form-control form-control-sm" id="status">
                                        <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                    </select>
                                </div>
                                @error('status')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="marketable">قابل فروش بودن</label>
                                    <select name="marketable" class="form-control form-control-sm"
                                            id="marketable">
                                        <option value="0" @if(old('marketable') == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if(old('marketable') == 1) selected @endif>فعال</option>
                                    </select>
                                </div>
                                @error('marketable')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تاریخ انتشار</label>
                                    <input type="text" name="published_at" id="published_at"
                                           class="form-control form-control-sm d-none">
                                    <input type="text" id="published_at_view" class="form-control form-control-sm">
                                </div>
                                @error('published_at')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 border-top border-bottom py-3 mb-3">

                                <section class="row meta-product">

                                    <section class="col-6 col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="meta_key[]" class="form-control form-control-sm"
                                                   placeholder="ویژگی ...">
                                        </div>
                                        @error('meta_key.*')
                                        <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                        @enderror
                                    </section>

                                    <section class="col-6 col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="meta_value[]" class="form-control form-control-sm"
                                                   placeholder="مقدار ...">
                                        </div>
                                        @error('meta_value.*')
                                        <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                        @enderror
                                    </section>

                                </section>

                                <section>
                                    <button type="button" id="btn-copy" class="btn btn-success btn-sm">افزودن</button>
                                </section>


                            </section>

                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>
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
        $(function () {
            $("#btn-copy").on('click', function () {
                var ele = $(this).parent().prev().clone(true);
                $(this).before(ele);
            })
        })
    </script>

    <script>
        var category_id = $('#category_id');
        category_id.select2({
            placeholder: 'لطفا دسته بندی را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>

    <script>
        var brand_id = $('#brand_id');
        brand_id.select2({
            placeholder: 'لطفا برند را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>

@endsection
