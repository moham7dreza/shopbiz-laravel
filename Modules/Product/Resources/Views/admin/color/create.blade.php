@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد رنگ</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.color.index', $product->id) }}"> رنگ های کالا</a></li>
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
                    <a href="{{ route('product.color.index', $product->id) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.color.store', $product->id) }}" method="post">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="color_name" label="نام رنگ" :message="$message"/>
                            <x-panel-input col="10" name="color" type="color" label="رنگ" :message="$message"/>
                            <x-panel-input col="10" name="price_increase" label="افزایش قیمت" :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-input col="10" name="marketable_number" label="تعداد قابل فروش" :message="$message"/>
                            <x-panel-input col="10" name="sold_number" label="تعداد فروخته شده" :message="$message"/>
                            <x-panel-input col="10" name="frozen_number" label="تعداد رزرو شده" :message="$message"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
