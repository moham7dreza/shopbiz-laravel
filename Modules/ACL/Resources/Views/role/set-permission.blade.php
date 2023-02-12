@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسترسی های نقش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('role.index') }}"> نقش ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> دسترسی نقش</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسترسی نقش
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3  pb-2">
                    <a href="{{ route('role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('role.permission-update', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                        <section class="row">

                            <section class="col-12">
                                <section class="row border-top mt-3 py-3">
                                    @php $message = $message ?? null @endphp
                                    <x-panel-section col="5" id="role-name" label="نام نقش" text="{{ $role->name }}"/>
                                    <x-panel-section col="5" id="role-brief" label="توضیح نقش"
                                                     text="{{ $role->description }}"/>

                                    <section class="col-12 border-bottom mb-3"></section>

                                    <x-panel-multi-selection col="12" label="سطوح دسترسی" name="permissions"
                                                             :message="$message" :items="$permissions"
                                                             :related="$role"/>
                                    <x-panel-button col="12" title="ثبت" />
                                </section>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')

    <script>
        const permissions = $('#permissions');
        permissions.select2({
            placeholder: 'لطفا دسترسی ها را وارد نمایید',
            multiple: true,
            tags: false
        })
    </script>

@endsection
