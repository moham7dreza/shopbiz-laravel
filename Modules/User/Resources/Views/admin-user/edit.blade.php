@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش کاربر ادمین</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('adminUser.index') }}"> کاربران ادمین</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش کاربر ادمین</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش کاربر ادمین
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('adminUser.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('adminUser.update', $adminUser->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="first_name" label="نام"
                                           :message="$message" method="edit" :model="$adminUser"/>
                            <x-panel-input col="10" name="last_name" label="نام خانوادگی"
                                           :message="$message" method="edit" :model="$adminUser"/>
                            <x-panel-input col="10" type="file" name="profile_photo_path" label="تصویر" :showImage="true"
                                           :message="$message" :model="$adminUser"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
