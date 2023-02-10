@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('attribute.index') }}"> فرم کالا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش فرم کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('attribute.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('attribute.update', $attribute->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <section class="row">
                            <x-panel-input col="10" name="name" label="نام فرم" message="{{ $message ?? null }}"
                                           method="edit" :model="$attribute"/>
                            <x-panel-input col="10" name="unit" label="واحد اندازه گیری"
                                           message="{{ $message ?? null }}" method="edit" :model="$attribute"/>
                            <x-panel-status col="10" name="status" label="وضعیت" message="{{ $message ?? null }}"
                                            method="edit" :model="$attribute"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
