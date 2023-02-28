@extends('Panel::layouts.master')

@section('head-tag')
    <title>عملیات اکسلی</title>
@endsection

@section('content')
    @php $ROLE = \Modules\ACL\Entities\Role::class @endphp
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route($ROLE::ROUTE_INDEX) }}"> نقش ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> عملیات اکسلی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        عملیات اکسلی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route($ROLE::ROUTE_INDEX) }}" class="btn btn-info btn-sm">بازگشت</a>
                    @can($PERMISSION::PERMISSION_ROLE_EXCEL_EXPORT)
                        <x-panel-a-tag route="{{ route('role.excel.export') }}" text="خروجی فایل اکسل از داده ها"
                                       color="outline-primary" icon="file-export"/>
                    @endcan
                </section>

                <section>
                    @can($PERMISSION::PERMISSION_ROLE_EXCEL_IMPORT)
                        <form action="{{ route('role.excel.import') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <section class="row">
                                @php $message = $message ?? null @endphp
                                <x-panel-input col="12" type="file" name="file" label="فایل"
                                               :message="$message"/>
                                <x-panel-button group="fa" icon="file-import" class="d-inline" col="12"
                                                title="بارگذاری داده ها"/>
                            </section>
                        </form>
                    @endcan
                </section>

            </section>
        </section>
    </section>

@endsection
