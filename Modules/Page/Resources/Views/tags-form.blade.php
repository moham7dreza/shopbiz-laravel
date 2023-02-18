@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ های پیج</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('page.index') }}"> پیج ساز</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> تگ های پیج</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تگ های پیج
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                    <a href="{{ route('page.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('page.tags.sync', $page->id) }}" method="POST" id="form">
                        @csrf
                        @method('put')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-section col="5" id="title" label="عنوان" text="{{ $page->title }}"/>
                            <x-panel-section col="5" id="body" label="پاسخ"
                                             text="{!! $page->getTagLessBody(200) !!}"/>
                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-multi-selection col="12" label="تگ ها" name="tags"
                                                     :message="$message" :items="$tags"
                                                     :related="$page"/>
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
