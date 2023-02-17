@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ های برند</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('brand.index') }}"> برندها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> تگ های برند</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تگ های برند
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                    <a href="{{ route('brand.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('brand.tags.sync', $brand->id) }}" method="POST" id="form">
                        @csrf
                        @method('put')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-section col="5" id="brand-en-name" label="نام اضلی برند" text="{{ $brand->original_name }}"/>
                            <x-panel-section col="5" id="brand-fa-name" label="نام فارسی برند"
                                             text="{{ $brand->persian_name }}"/>
                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-multi-selection col="12" label="تگ ها" name="tags"
                                                     :message="$message" :items="$tags"
                                                     :related="$brand"/>
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
