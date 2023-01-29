@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسته بندی های فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">دسته بندی ها</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسته بندی های فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3  pb-2">
                    <a href="{{ route('attribute.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('attribute.category-update', $attribute->id) }}" method="post">
                        @csrf
                        @method('put')
                        <section class="row">

                            <section class="col-12">
                                <section class="row border-top mt-3 py-3">

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
                                            <label for="select_categories">دسته بندی ها</label>
                                            <select multiple class="form-control form-control-sm" id="select_categories"
                                                    name="categories[]">

                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                            @foreach ($attribute->categories as $attribute_category)
                                                                @if($attribute_category->id === $category->id)
                                                                    selected
                                                        @endif
                                                        @endforeach
                                                    >
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('categories')
                                        <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                        @enderror
                                    </section>

                                    <section class="col-12 border-top">
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
        var select_categories = $('#select_categories');
        select_categories.select2({
            placeholder: 'لطفا دسته بندی ها را وارد نمایید',
            multiple: true,
            tags: true
        })
    </script>

@endsection
