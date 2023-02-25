@extends('Home::layouts.master-one-col')

@section('head-tag')
    <title>تیکت های شما</title>
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                @include('Home::layouts.partials.profile-sidebar')

                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start content header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تاریخچه تیکت </span>
                                </h2>
                                <section class="content-header-link m-2">
                                    <x-panel-a-tag route="{{ route('customer.profile.my-tickets') }}"
                                                   title="بازگشت"
                                                   icon="reply" color="outline-danger"/>
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="order-wrapper mt-4">

                            <section class="card mb-3">
                                <section
                                    class="card-header bg-blue-light d-flex justify-content-between align-items-center">
                                    <div> {{ $ticket->getUserName() }}</div>
                                    <small class="font-weight-bold">{{ $ticket->getFaCreatedDate(true) }}</small>
                                </section>
                                <section class="card-body font-size-90">
                                    <h6 class="card-title">موضوع : <span
                                            class="font-weight-bold">{{ $ticket->subject }}</span>
                                    </h6>
                                    <p class="card-text p-3">
                                        {!! $ticket->description !!}
                                    </p>
                                </section>
                            </section>
                            @if(count($ticket->children) > 0)
                                <div class="border rounded-3 my-2 ms-4">
                                    @foreach ($ticket->children as $child)

                                        <section class="card m-4">
                                            <section
                                                class="card-header bg-blue-light d-flex justify-content-between align-items-center">
                                                <div> {{ $child->getUserName() }}</div>
                                                <small
                                                    class="font-weight-bold">{{ $child->getFaCreatedDate(true) }}</small>
                                            </section>
                                            <section class="card-body">
                                                <p class="card-text">
                                                    {!! $child->description !!}
                                                </p>
                                            </section>
                                        </section>
                                    @endforeach
                                </div>
                            @endif

                            @if($ticket->isTicketParent())
                                <section class="my-3">
                                    <form action="{{ route('customer.profile.my-tickets.answer', $ticket->id) }}"
                                          method="post">
                                        @csrf
                                        <section class="row">
                                            @php $message = $message ?? null @endphp
                                            <x-panel-text-area col="12" name="description" label="پاسخ" rows="8"
                                                               :message="$message"/>
                                            <x-panel-button col="12" title="ثبت"/>
                                        </section>
                                    </form>
                                </section>
                            @endif
                        </section>
                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
