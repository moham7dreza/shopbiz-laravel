@extends('Panel::layouts.master')

@section('head-tag')
    <title>نمایش تیکت</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('ticket.index') }}"> تیکت ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> نمایش تیکت</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش تیکت
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('ticket.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section class="card mb-3">
                    <section class="card-header text-white bg-custom-pink">
                        {{ $ticket->getUserName() }} - {{ $ticket->getFaId() }}
                    </section>
                    <section class="card-body">
                        <h5 class="card-title">موضوع : {{ $ticket->subject }}
                        </h5>
                        <p class="card-text">
                            {{ $ticket->description }}
                        </p>
                    </section>
                </section>

                <section>
                    <form action="{{ route('ticket.answer', $ticket->id) }}" method="post">
                        @csrf
                        <section class="row">
                            <section class="col-12">
                                @php $message = $message ?? null @endphp
                                <x-panel-text-area col="12" name="description" label="پاسخ تیکت" rows="12"
                                                   :message="$message"/>
                                <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>
@endsection
