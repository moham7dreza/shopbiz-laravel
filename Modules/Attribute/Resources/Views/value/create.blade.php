@extends('Panel::layouts.master')

@section('head-tag')
    <title>مقدار فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد مقدار فرم کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد مقدار فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('attributeValue.index', $attribute->id) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('attributeValue.store', $attribute->id) }}" method="POST">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">نام فرم کالا</label>
                                    <section>{{ $attribute->name }}</section>
                                </div>
                            </section>

                            <section class="col-12 col-md-5">
                                <div class="form-group">
                                    <label for="">واحد</label>
                                    <section>{{ $attribute->unit }}</section>
                                </div>
                            </section>
                            <section class="col-12 border-bottom mb-3"></section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="product_id">انتخاب محصول</label>
                                    <select name="product_id" id="product_id" class="form-control form-control-sm">
                                        <option value=""> محصول را انتخاب کنید</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"
                                                    @if(old('product_id') == $product->id) selected @endif>{{ $product->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('product_id')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">مقدار</label>
                                    <input type="text" name="value" value="{{ old('value') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('value')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">افزایش قیمت</label>
                                    <input type="text" name="price_increase" value="{{ old('price_increase') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('price_increase')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12">
                                <div class="form-group">
                                    <label for="type">نوع</label>
                                    <select name="type" class="form-control form-control-sm" id="type">
                                        <option value="0" @if(old('type') == 0) selected @endif>ساده</option>
                                        <option value="1" @if(old('type') == 1) selected @endif>انتخابی</option>
                                    </select>
                                </div>
                                @error('type')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
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
    <script>
        var product_id = $('#product_id');
        product_id.select2({
            placeholder: 'لطفا محصول را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
