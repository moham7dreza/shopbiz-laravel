@extends('Panel::layouts.master')

@section('head-tag')
    <title>فایل های اطلائیه ایمیلی</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('email.index') }}"> اطلائیه ایمیلی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> فایل های اطلائیه ایمیلی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فایل اطلائیه ایمیلی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_EMAIL_NOTIFY_FILE_CREATE)
                            <a href="{{ route('email-file.create', $email->id) }}" class="btn btn-info btn-sm">ایجاد
                                فایل اطلائیه ایمیلی</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('email-file.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('email-file.index', $email->id) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان ایمیل</th>
                            <th>سایز فایل</th>
                            <th>نوع فایل</th>
                            <th><x-panel-sort-btn route="permission.index" title="وضعیت" property="status"/>
</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($files as $key => $file)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $email->getLimitedSubject() }}</td>
                                <td>{{ $file->getFaFileSize() }}</td>
                                <td>{{ $file->file_type }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_EMAIL_NOTIFY_FILE_STATUS)
                                        <x-panel-checkbox class="rounded" route="email-file.status"
                                                          method="changeStatus"
                                                          name="فایل" :model="$file" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_EMAIL_NOTIFY_FILE_EDIT)
                                        <x-panel-a-tag route="{{ route('email-file.edit', $file->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_EMAIL_NOTIFY_FILE_DELETE)
                                        <x-panel-delete-form route="{{ route('email-file.destroy', $file->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $files->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
