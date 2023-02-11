@extends('Panel::layouts.master')

@section('head-tag')
    <title>نمایش نظر</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('productComment.index') }}"> نظرات</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> نمایش نظر</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش نظرها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('productComment.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section class="card mb-3">
                    <section class="card-header text-white bg-custom-yellow">
                        {{ $productComment->getAuthorName() }} - {{ $productComment->getFaAuthorId()  }}
                    </section>
                    <section class="card-body">
                        <h5 class="card-title">مشخصات کالا : {{ $productComment->getCommentableName() }}
                            - کد کالا : {{ $productComment->getFaCommentableId() }}</h5>
                        <p class="card-text border-top p-4">{{ $productComment->body }}</p>
                    </section>
                </section>

                @if(is_null($productComment->parent_id))
                    <section>
                        <form action="{{ route('productComment.answer', $productComment->id) }}" method="post">
                            @csrf
                            <section class="row">
                                @php $message = $message ?? null @endphp
                                <x-panel-text-area col="12" name="body" label="پاسخ ادمین" rows="12"
                                                   :message="$message"/>
                                <x-panel-button col="12" title="ثبت"/>
                            </section>
                        </form>
                    </section>
                @endif
            </section>
        </section>
    </section>

@endsection
