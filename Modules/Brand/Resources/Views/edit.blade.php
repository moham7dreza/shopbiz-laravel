@extends('Panel::layouts.master')

@section('head-tag')
    <title>برند</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">برند</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد برند</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد برند
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('brand.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('brand.update', $brand->id) }}" method="post" id="form"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام اصلی برند</label>
                                    <input type="text" class="form-control form-control-sm" name="original_name"
                                           value="{{ old('original_name', $brand->original_name) }}">
                                </div>
                                @error('original_name')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام فارسی برند</label>
                                    <input type="text" class="form-control form-control-sm" name="persian_name"
                                           value="{{ old('persian_name', $brand->persian_name) }}">
                                </div>
                                @error('persian_name')
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
                                        <option value="0" @if (old('status', $brand->status) == 0) selected @endif>
                                            غیرفعال
                                        </option>
                                        <option value="1" @if (old('status', $brand->status) == 1) selected @endif>
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


                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="">تصویر برند</label>
                                    <input type="file" class="form-control form-control-sm" name="logo">
                                </div>
                                @error('logo')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

{{--                            <section class="row">--}}
{{--                                @php--}}
{{--                                    $number = 1;--}}
{{--                                @endphp--}}
{{--                                @foreach ($brand->logo['indexArray'] as $key => $value )--}}
{{--                                    <section class="col-md-{{ 6 / $number }}">--}}
{{--                                        <div class="form-check">--}}
{{--                                            <input type="radio" class="form-check-input" name="currentImage"--}}
{{--                                                   value="{{ $key }}" id="{{ $number }}"--}}
{{--                                                   @if($brand->logo['currentImage'] == $key) checked @endif>--}}
{{--                                            <label for="{{ $number }}" class="form-check-label mx-2">--}}
{{--                                                <img src="{{ asset($value) }}" class="w-100" alt="">--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </section>--}}
{{--                                    @php--}}
{{--                                        $number++;--}}
{{--                                    @endphp--}}
{{--                                @endforeach--}}

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



@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>

@endsection


