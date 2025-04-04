@extends('Panel::layouts.master')

@section('head-tag')
    <title>اولویت</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> اولویت</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        اولویت
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_TICKET_PRIORITY_CREATE)
                            <a href="{{ route('ticketPriority.create') }}" class="btn btn-info btn-sm">ایجاد اولویت</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('ticketPriority.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('ticketPriority.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'ticketPriority.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام اولویت"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($ticketPriorities as $key => $ticketPriority)
                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $ticketPriority->name }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_TICKET_PRIORITY_STATUS)
                                        <x-panel-checkbox class="rounded" route="ticketPriority.status"
                                                          method="changeStatus"
                                                          name="اولویت" :model="$ticketPriority" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_TICKET_PRIORITY_EDIT)
                                        <x-panel-a-tag route="{{ route('ticketPriority.edit', $ticketPriority->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_TICKET_PRIORITY_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('ticketPriority.destroy', $ticketPriority->id) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $ticketPriorities->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')
    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
