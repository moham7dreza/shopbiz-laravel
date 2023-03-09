@extends('Panel::layouts.master')

@section('head-tag')
    <title>گفتوگو</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> گفتوگو</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        گفتوگو
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a href="#" class="btn btn-info btn-sm disabled">ایجاد گفتوگو </a>
                        <x-panel-a-tag route="{{ route('chat.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                        <x-panel-a-tag route="{{ route('chat-admin.index') }}"
                                       title="ادمین های گفتوگو" text="ادمین ها"
                                       icon="user-secret" color="outline-primary"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('chat.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'chat.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="پیام" property="message"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="ایمیل" property="email"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="موبایل" property="phone"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="ارجاع شده از" property="reference_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="گفتوگوی مرجع" property="parent_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($chats as $chat)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $chat->getLimitedMessage() }}</td>
                                <td>{{ $chat->email ?? '-' }}</td>
                                <td>{{ $chat->getFaPhone() }}</td>
                                <td>{{ $chat->getReferenceName() }}</td>
                                <td>{{ $chat->getParentTitle() }}</td>
                                <td>
{{--                                    @can($PERMISSION::PERMISSION_CONTACT_STATUS)--}}
                                        <x-panel-checkbox class="rounded" route="chat.status"
                                                          method="changeStatus"
                                                          name="گفتوگو" :model="$chat" property="status"/>
{{--                                    @endcan--}}
                                </td>
                                <td class="width-16-rem text-left">
{{--                                    @can($PERMISSION::PERMISSION_CONTACT_SHOW)--}}
                                        <x-panel-a-tag route="{{ route('chat.show', $chat->id) }}"
                                                       title="نمایش گفتوگو"
                                                       icon="eye" color="outline-primary"/>
{{--                                    @endcan--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $chats->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

@endsection
