@extends('Panel::layouts.master')

@section('head-tag')
    <title>سوالات متداول</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> سوالات متداول</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        سوالات متداول
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    @can($PERMISSION::PERMISSION_FAQ_CREATE)
                        <a href="{{ route('faq.create') }}" class="btn btn-info btn-sm">ایجاد سوال جدید</a>
                    @endcan
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('faq.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>پرسش</th>
                            <th>خلاصه پاسخ</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($faqs as $key => $faq)
                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $faq->getLimitedQuestion() }}</td>
                                <td>{!! $faq->getLimitedAnswer() !!}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_FAQ_TAGS)
                                        <x-panel-tags :model="$faq" related="tags" name="سوال"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_FAQ_STATUS)
                                        <x-panel-checkbox class="rounded" route="faq.status" method="changeStatus"
                                                          name="سوال" :model="$faq" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_FAQ_TAGS)
                                        <x-panel-a-tag route="{{ route('faq.tags-from', $faq->id) }}"
                                                       title="افزودن تگ"
                                                       icon="tag" color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_FAQ_EDIT)
                                        <x-panel-a-tag route="{{ route('faq.edit', $faq->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_FAQ_DELETE)
                                        <x-panel-delete-form route="{{ route('faq.destroy', $faq->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $faqs->links() }}</section>
                </section>
            </section>
        </section>
    </section>
@endsection


@section('script')
    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
