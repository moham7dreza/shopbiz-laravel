@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش رنگ</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('color.index') }}">رنگ ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش رنگ</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش رنگ
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('color.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('color.update', $color->id) }}" method="post">
                        @csrf
                        @method('put')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="name" label="نام رنگ" :message="$message" method="edit"
                                           :model="$color"/>
                            <x-panel-input col="10" name="name_en" label="نام لاتین" :message="$message" method="edit"
                                           :model="$color"/>
                            <x-panel-input col="10" name="code" type="color" label="رنگ" :message="$message"
                                           method="edit" :model="$color"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" method="edit"
                                                :model="$color"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
