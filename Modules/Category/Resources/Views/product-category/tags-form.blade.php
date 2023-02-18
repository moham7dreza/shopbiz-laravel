@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ های دسته بندی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('productCategory.index') }}"> دسته بندی کالاها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> تگ های دسته بندی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تگ های دسته بندی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                    <a href="{{ route('productCategory.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('productCategory.tags.sync', $productCategory->id) }}" method="POST" id="form">
                        @csrf
                        @method('put')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-section col="5" id="productCategory-name" label="نام دسته بندی" text="{{ $productCategory->name }}"/>
                            <x-panel-section col="5" id="productCategory-description" label="توضیحات"
                                             text="{!! $productCategory->getTagLessDescription() !!}"/>
                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-multi-selection col="12" label="تگ ها" name="tags"
                                                     :message="$message" :items="$tags"
                                                     :related="$productCategory"/>
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
