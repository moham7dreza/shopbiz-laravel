@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ های محصول</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">محصول</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> تگ های محصول</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تگ های محصول
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                    <a href="{{ route('product.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.tags.sync', $product->id) }}" method="POST" id="form">
                        @csrf
                        {{ method_field('put') }}
                        <section class="row">

                            <section class="col-12">
                                <section class="row border-top mt-3 py-3">

                                    <section class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="">نام محصول</label>
                                            <section>{{ $product->name }}</section>
                                        </div>
                                    </section>

                                    <section class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="">توضیح محصول</label>
                                            <section>{!! $product->introduction !!}</section>
                                        </div>
                                    </section>

                                    <section class="col-12 border-top"></section>

                                    <section class="col-12 mt-4">
                                        <div class="form-group">
                                            <label for="select_tags">تگ ها</label>
                                            <select multiple class="form-control form-control-sm" id="select_tags"
                                                    name="tags[]">

                                                @foreach ($tags as $tag)
                                                    <option value="{{ $tag->id }}"
                                                            @foreach ($product->tags as $product_tag)
                                                                @if($product_tag->id == $tag->id)
                                                                    selected
                                                                @endif
                                                        @endforeach>
                                                        {{ $tag->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('tags')
                                        <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                        @enderror
                                    </section>

                                    <section class="col-12">
                                        <button class="btn btn-primary btn-sm mt-md-4">ثبت</button>
                                    </section>

                                </section>
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
        var select_tags = $('#select_tags');
        select_tags.select2({
            placeholder: 'لطفا تگ ها را وارد نمایید',
            multiple: true,
            tags: false
        })
    </script>

@endsection
