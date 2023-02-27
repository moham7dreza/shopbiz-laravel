@extends('Panel::layouts.master')

@section('head-tag')
    <title>نمایش فرم</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('contact.index') }}"> ارتباط با ما</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> نمایش فرم</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش فرم
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('contact.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section class="card mb-3">
                    <section
                        class="card-header text-white bg-custom-pink d-flex justify-content-between align-items-center">
                        <div> {{ $contact->first_name . ' ' . $contact->last_name }}</div>
                        <small class="font-weight-bold text-dark">{{ $contact->getFaCreatedDate(true) }}</small>
                    </section>
                    <section class="card-body">
                        <h6 class="card-title">موضوع : <span
                                class="font-weight-bold">{{ $contact->subject ?? '-' }}</span>
                        </h6>
                        <p class="card-text">
                            {!! $contact->message !!}
                        </p>
                    </section>
                </section>

                <section>
                    <form action="{{ route('contact.answer', $contact->id) }}" method="post">
                        @csrf
                        <section class="row">
                            <section class="col-12">
                                @php $message = $message ?? null @endphp
                                <x-panel-text-area col="12" name="answer" label="پاسخ" rows="12"
                                                   :message="$message"/>
                                <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('answer');
    </script>

@endsection
