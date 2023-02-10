@extends('Panel::layouts.master')

@section('head-tag')
    <title> ویرایش روش ارسال</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('delivery.index') }}"> روش های ارسال</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش روش ارسال</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش روش ارسال
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('delivery.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('delivery.update', $delivery->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <section class="row">

                            <x-panel-input col="10" name="name" label="نام روش ارسال"
                                           message="{{ $message ?? null }}" method="edit" :model="$delivery"/>
                            <x-panel-input col="10" name="amount" label="هزینه روش ارسال"
                                           message="{{ $message ?? null }}" method="edit" :model="$delivery"/>
                            <x-panel-input col="10" name="delivery_time" label="زمان ارسال"
                                           message="{{ $message ?? null }}" method="edit" :model="$delivery"/>
                            <x-panel-input col="10" name="delivery_time_unit" label="واحد زمان ارسال"
                                           message="{{ $message ?? null }}" method="edit" :model="$delivery"/>
                            <x-panel-status col="10" name="status" label="وضعیت" message="{{ $message ?? null }}"/>
                            <x-panel-button col="12" title="ثبت"/>

                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
