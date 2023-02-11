@extends('Panel::layouts.master')

@section('head-tag')
    <title>برند</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('brand.index') }}"> برند</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد برند</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد برند
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('brand.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('brand.store') }}" method="post" id="form"
                          enctype="multipart/form-data">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="original_name" label="نام اصلی برند"
                                           :message="$message"/>
                            <x-panel-input col="10" name="persian_name" label="نام فارسی برند"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" />
                            <x-panel-input col="10" type="file" name="logo" label="تصویر برند"
                                           :message="$message"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
