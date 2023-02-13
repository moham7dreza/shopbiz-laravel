@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ های محصول</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
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
                        @method('put')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-section col="5" id="product-name" label="نام محصول" text="{{ $product->name }}"/>
                            <x-panel-section col="5" id="product-intro" label="توضیح محصول"
                                             text="{!! strip_tags($product->introduction) !!}"/>
                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-multi-selection col="12" label="تگ ها" name="tags"
                                                     :message="$message" :items="$tags"
                                                     :related="$product"/>
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
        const tags = $('#tags');
        tags.select2({
            placeholder: 'لطفا تگ ها را وارد نمایید',
            multiple: true,
            tags: false
        })
    </script>
@endsection
