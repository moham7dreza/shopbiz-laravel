@extends('Panel::layouts.master')

@section('head-tag')
    <title>افزایش موجودی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.store.index') }}"> انباری</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> افزایش موجودی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        افزایش موجودی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('product.store.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.store.store', $product->id) }}" method="POST">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="receiver" label="نام تحویل گیرنده" :message="$message"/>
                            <x-panel-input col="10" name="deliverer" label="نام تحویل دهنده" :message="$message"/>
                            <x-panel-input col="10" name="marketable_number" label="تعداد" class="dir-ltr text-left" :message="$message"/>
                            <x-panel-text-area col="10" name="description" label="توضیحات" rows="12"
                                               :message="$message"/>
                            <x-panel-button col="12" title="ثبت"/>
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
