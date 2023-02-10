@extends('Panel::layouts.master')

@section('head-tag')
    <title>مقدار فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('attributeValue.index', $attribute->id) }}">
                    مقدار فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش مقدار فرم کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش مقدار فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('attributeValue.index', $attribute->id) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form
                        action="{{ route('attributeValue.update', ['attribute' => $attribute->id , 'value' => $value->id] ) }}"
                        method="POST">
                        @csrf
                        @method('put')
                        <section class="row">
                            <x-panel-section col="5" id="attribute-name" label="نام فرم کالا"
                                             text="{{ $attribute->name }}"/>
                            <x-panel-section col="5" id="attribute-unit" label="واحد" text="{{ $attribute->unit }}"/>

                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-select-box col="6" name="product_id" label="انتخاب محصول"
                                                message="{{ $message ?? null }}" :collection="$products" method="edit"
                                                :model="$value" property="name" />

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">مقدار</label>
                                    <input type="text" name="value"
                                           value="{{ old('value', json_decode($value->value)->value ) }}"
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
                                    <input type="text" name="price_increase"
                                           value="{{ old('price_increase', json_decode($value->value)->price_increase ) }}"
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

                            <x-panel-status col="10" name="type" label="نوع" message="{{ $message ?? null }}" method="edit" :model="$value" />
                            <x-panel-button col="12" title="ثبت" />
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')
    <script>
        const product_id = $('#product_id');
        product_id.select2({
            placeholder: 'لطفا محصول را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
