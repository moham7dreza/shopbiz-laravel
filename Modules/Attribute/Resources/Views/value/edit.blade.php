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
                            @php $message = $message ?? null @endphp
                            <x-panel-section col="5" id="attribute-name" label="نام فرم کالا"
                                             text="{{ $attribute->name }}"/>
                            <x-panel-section col="5" id="attribute-unit" label="واحد" text="{{ $attribute->unit }}"/>

                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-select-box col="6" name="product_id" label="انتخاب محصول"
                                                :message="$message" :collection="$products" method="edit"
                                                :model="$value" property="name"/>
                            <x-panel-input col="10" name="value" label="مقدار" :old="json_decode($value->value)->value"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="price_increase" label="افزایش قیمت"
                                           :old="json_decode($value->value)->price_increase"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-status col="10" name="type" label="نوع" :message="$message" method="edit"
                                            :model="$value"/>
                            <x-panel-button col="12" title="ثبت"/>
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
