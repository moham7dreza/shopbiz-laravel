@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد گارانتی</title>
    @livewireStyles
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.guarantee.index', $product->id) }}"> گارانتی کالا</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد گارانتی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد گارانتی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('product.guarantee.index', $product->id) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.guarantee.store', $product->id) }}" method="post">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-select-box col="10" name="guarantee_id" label="گارانتی"
                                                :message="$message" :collection="$guarantees"
                                                property="name" option="گارانتی را انتخاب کنید"/>
                            <x-panel-input col="10" name="duration" label="مدت زمان اعتبار گارانتی" :message="$message" placeholder="بر حسب ماه ..."/>
                            <livewire:fa-price-input col="10" name="price_increase" label="افزایش قیمت"
                                                     class="dir-ltr" :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    @livewireScripts

    <script>
        const guarantee_id = $('#guarantee_id');
        guarantee_id.select2({
            placeholder: 'لطفا رنگ را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
