@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد نقش ادمین</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('adminUser.index') }}"> کاربران ادمین</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد نقش ادمین</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد نقش ادمین
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('adminUser.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('adminUser.roles.store', $admin) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-section col="5" id="admin-name" label="نام کاربر" text="{{ $admin->fullName }}"/>
                            <x-panel-section col="5" id="admin-email" label="ایمیل کاربر"
                                             text="{{ $admin->email }}"/>

                            <section class="col-12 border-bottom mb-3"></section>

                            <x-panel-multi-selection col="12" label="نقش ها" name="roles"
                                                     :message="$message" :items="$roles"
                                                     :related="$admin"/>
                            <x-panel-button col="12" title="ثبت" />
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    <script>
        const roles = $('#roles');
        roles.select2({
            placeholder: 'لطفا نقش ها را وارد نمایید',
            multiple: true,
            tags: true
        })
    </script>

@endsection
