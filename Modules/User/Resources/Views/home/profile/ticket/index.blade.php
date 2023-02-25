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
                        <section class="content-header my-2">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تاریخچه تیکت ها</span>
                                </h2>
                                <section class="content-header-link m-2">
                                    <x-panel-a-tag route="{{ route('customer.profile.my-tickets.create') }}"
                                                   title="ارسال تیکت جدید"
                                                   icon="plus" color="outline-success"/>
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->

                        <section class="order-wrapper m-1">

                            <section class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نویسنده تیکت</th>
                                        <th>عنوان تیکت</th>
                                        <th>وضعیت تیکت</th>
                                        <th>دسته تیکت</th>
                                        <th>اولویت تیکت</th>
                                        <th>ارجاع شده از</th>
                                        <th>تیکت مرجع</th>
                                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach ($tickets as $ticket)
                                        <tr>
                                            <th>{{ convertEnglishToPersian($loop->iteration) }}</th>
                                            <td>{{ $ticket->getUserName() }}</td>
                                            <td>{{ $ticket->getLimitedSubject() }}</td>
                                            <td>{{ $ticket->isTicketOpen() ? 'باز' : 'بسته' }}</td>
                                            <td>{{ $ticket->getCategoryName() }}</td>
                                            <td>{{ $ticket->getPriorityName() }}</td>
                                            <td>{{ $ticket->getReferenceName() }}</td>
                                            <td>{{ $ticket->getParentTitle() }}</td>
                                            <td class="width-8-rem text-left">
                                                <x-panel-a-tag route="{{ route('customer.profile.my-tickets.show', $ticket->id) }}"
                                                               title="نمایش تیکت"
                                                               icon="eye" color="outline-primary"/>
                                                <x-panel-a-tag route="{{ route('customer.profile.my-tickets.change', $ticket->id) }}"
                                                               title="{{ $ticket->getTextStatus() }}"
                                                               icon="{{ $ticket->iconStatus() }}" color="outline-{{ $ticket->cssStatus() }}"/>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <section class="border-top pt-3">{{ $tickets->links() }}</section>
                            </section>

                        </section>

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
