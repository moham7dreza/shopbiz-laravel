@extends('Panel::layouts.master')

@section('head-tag')
    <title>تیکت</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> تیکت</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تیکت
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="#" class="btn btn-info btn-sm disabled">ایجاد تیکت </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('ticket.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text" placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نویسنده تیکت</th>
                            <th>عنوان تیکت</th>
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
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $ticket->getUserName() }}</td>
                                <td>{{ $ticket->getLimitedSubject() }}</td>
                                <td>{{ $ticket->getCategoryName() }}</td>
                                <td>{{ $ticket->getPriorityName() }}</td>
                                <td>{{ $ticket->getReferenceName() }}</td>
                                <td>{{ $ticket->getParentTitle() }}</td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('ticket.show', $ticket->id) }}" class="btn btn-info btn-sm"><i
                                            class="fa fa-eye"></i></a>
                                    <a href="{{ route('ticket.change', $ticket->id) }}"
                                       class="btn btn-{{ $ticket->cssStatus() }} btn-sm"><i
                                            class="fa fa-{{ $ticket->iconStatus() }}"></i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $tickets->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
