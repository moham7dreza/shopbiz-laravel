@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش دسترسی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('permission.index') }}"> دسترسی ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش دسترسی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد دسترسی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('permission.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('permission.update', $permission->id) }}" method="post">
                        @method('put')
                        @csrf
                        <section class="row">
                            <x-panel-input col="10" name="name" label="عنوان دسترسی" message="{{ $message ?? null }}" method="edit" :model="$permission" />
                            <x-panel-input col="10" name="description" label="توضیحات دسترسی" message="{{ $message ?? null }}" method="edit" :model="$permission" />
                            <x-panel-status col="10" name="status" label="وضعیت" message="{{ $message ?? null }}" method="edit" :model="$permission" />
                            <x-panel-button col="12" title="ثبت" />
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
