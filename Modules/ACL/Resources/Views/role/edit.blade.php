@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش نقش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('role.index') }}"> نقش ها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش نقش</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش نقش
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('role.update', $role->id) }}" method="post">
                        @method('put')
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="name" label="عنوان نقش" :message="$message" method="edit" :model="$role" />
                            <x-panel-input col="10" name="description" label="توضیحات نقش" :message="$message" method="edit" :model="$role" />
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" method="edit" :model="$role" />
                            <x-panel-button col="12" title="ثبت" />
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
