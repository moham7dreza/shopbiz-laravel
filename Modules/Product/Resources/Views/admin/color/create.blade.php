@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد رنگ</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">کالا </a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد رنگ</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد رنگ
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                </section>

                <section>
                    <form action="{{ route('product.color.store', $product->id) }}" method="post">
                        @csrf
                        <section class="row">


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="color_name">نام رنگ</label>
                                    <input type="text" name="color_name" value="{{ old('color_name') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('color_name')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="color">رنگ</label>
                                    <input type="color" name="color" value="{{ old('color') }}"
                                           class="form-control form-control-sm form-control-color">
                                </div>
                                @error('color')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="price_increase">افزایش قیمت</label>
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

                            <section class="col-12 col-md-6">
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


                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">تعداد قابل فروش</label>
                                    <input type="text" name="marketable_number"
                                           value="{{ old('marketable_number') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('marketable_number')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">تعداد فروخته شده</label>
                                    <input type="text" name="sold_number"
                                           value="{{ old('sold_number') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('sold_number')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">تعداد رزرو شده</label>
                                    <input type="text" name="frozen_number"
                                           value="{{ old('frozen_number') }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('frozen_number')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                        </section>

                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
