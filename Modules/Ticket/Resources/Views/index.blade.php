@extends('Panel::layouts.master')

@section('head-tag')
    <title>{{ $title }}</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش تیکت</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> {{ $title }}</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        {{ $title }}
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a href="#" class="btn btn-info btn-sm disabled">ایجاد تیکت </a>
                        <x-panel-a-tag route="{{ route($route) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($route) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نویسنده تیکت" property="user_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="عنوان تیکت" property="subject"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="دسته تیکت" property="category_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="اولویت تیکت" property="priority_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="ارجاع شده از" property="reference_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="تیکت مرجع" property="ticket_id"/>
                            </th>
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
                                    @can($PERMISSION::PERMISSION_TICKET_SHOW)
                                        <x-panel-a-tag route="{{ route('ticket.show', $ticket->id) }}"
                                                       title="نمایش تیکت"
                                                       icon="eye" color="outline-primary"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_TICKET_CHANGE)
                                        <x-panel-a-tag route="{{ route('ticket.change', $ticket->id) }}"
                                                       title="{{ $ticket->getTextStatus() }}"
                                                       icon="{{ $ticket->iconStatus() }}"
                                                       color="outline-{{ $ticket->cssStatus() }}"/>
                                    @endcan
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
