@extends('Panel::.layouts.master')

@section('head-tag')
    <title>ویرایش موجودی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.store.index') }}"> انباری</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش موجودی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش موجودی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('product.store.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('product.store.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="marketable_number" label="تعداد قابل فروش" :message="$message"
                                           method="edit" :model="$product"/>
                            <x-panel-input col="10" name="sold_number" label="تعداد فروخته شده" :message="$message"
                                           method="edit" :model="$product"/>
                            <x-panel-input col="10" name="frozen_number" label="تعداد رزرو شده" :message="$message"
                                           method="edit" :model="$product"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
