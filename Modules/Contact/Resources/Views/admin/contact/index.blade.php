@extends('Panel::layouts.master')

@section('head-tag')
    <title>ارتباط با ما</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ارتباط با ما</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ارتباط با ما
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a href="#" class="btn btn-info btn-sm disabled">ایجاد ارتباط با ما </a>
                        <x-panel-a-tag route="{{ route('contact.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('contact.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'contact.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام" property="first_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام خانوادگی" property="last_name"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="ایمیل" property="email"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="موبایل" property="phone"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت تایید" property="approved"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت فرم" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($contacts as $contact)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $contact->first_name }}</td>
                                <td>{{ $contact->last_name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->getFaPhone() }}</td>
                                <td>{{ $contact->getFaApprovedText() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_CONTACT_STATUS)
                                        <x-panel-checkbox class="rounded" route="contact.status"
                                                          method="changeStatus"
                                                          name="فرم" :model="$contact" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_CONTACT_SHOW)
                                        <x-panel-a-tag route="{{ route('contact.show', $contact->id) }}"
                                                       title="نمایش فرم"
                                                       icon="eye" color="outline-primary"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_CONTACT_APPROVED)
                                        <x-panel-a-tag route="{{ route('contact.approved', $contact->id) }}"
                                                       title="{{ $contact->getFaChangeApprovedText() }}"
                                                       icon="{{ $contact->getApprovedIcon() }}"
                                                       color="outline-{{ $contact->getApprovedColor() }}"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $contacts->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection
@section('script')

    @include('Share::ajax-functions.panel.status')

@endsection
