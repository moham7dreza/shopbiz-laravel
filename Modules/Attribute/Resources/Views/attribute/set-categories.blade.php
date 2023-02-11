@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسته بندی های فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('attribute.index') }}"> فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسته بندی ها</li>
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
                                    @php $message = $message ?? null @endphp
                                    <x-panel-section col="5" id="attribute-name" label="نام فرم کالا" text="{{ $attribute->name }}"/>
                                    <x-panel-section col="5" id="attribute-unit" label="واحد" text="{{ $attribute->unit }}"/>

                                    <section class="col-12 border-bottom mb-3"></section>
                                    <x-panel-multi-selection col="12" label="دسته بندی ها" name="categories"
                                                             :message="$message" :items="$categories"
                                                             :related="$attribute"/>
                                    <x-panel-button col="12" title="ثبت" />
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
        const categories = $('#categories');
        categories.select2({
            placeholder: 'لطفا دسته بندی ها را وارد نمایید',
            multiple: true,
            tags: false
        })
    </script>

@endsection
