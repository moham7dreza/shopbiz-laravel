@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش فرم کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('attribute.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('attribute.update', $attribute->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام فرم</label>
                                    <input type="text" name="name" value="{{ old('name', $attribute->name) }}"
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
                                    <label for="">واحد اندازه گیری</label>
                                    <input type="text" name="unit" value="{{ old('unit', $attribute->unit) }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('unit')
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
                                        <option value="0" @if (old('status', $attribute->status) == 0) selected @endif>
                                            غیرفعال
                                        </option>
                                        <option value="1" @if (old('status', $attribute->status) == 1) selected @endif>
                                            فعال
                                        </option>
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
{{--                            <section class="col-12">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="">انتخاب دسته</label>--}}
{{--                                    <select name="category_id" class="form-control form-control-sm">--}}
{{--                                        <option value="">دسته را انتخاب کنید</option>--}}
{{--                                        @foreach ($productCategories as $productCategory)--}}
{{--                                            <option value="{{ $productCategory->id }}"--}}
{{--                                                    @if(old('category_id', $attribute->category_id) == $productCategory->id) selected @endif>{{ $productCategory->name }}</option>--}}
{{--                                        @endforeach--}}

{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                @error('category_id')--}}
{{--                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">--}}
{{--                                <strong>--}}
{{--                                    {{ $message }}--}}
{{--                                </strong>--}}
{{--                            </span>--}}
{{--                                @enderror--}}
{{--                            </section>--}}


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
