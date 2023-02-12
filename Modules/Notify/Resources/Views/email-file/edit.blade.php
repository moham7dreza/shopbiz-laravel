@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش فایل اطلائیه ایمیلی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('email.index', $file->email->id) }}"> اطلائیه
                    ایمیلی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('email-file.index', $file->email->id) }}"> فایل های
                    اطلائیه ایمیلی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش فایل اطلائیه ایمیلی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش فایل اطلائیه ایمیلی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('email-file.index', $file->email->id) }}"
                       class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('email-file.update', $file->id) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" type="file" name="file" label="فایل"
                                           :message="$message" method="edit" :model="$file"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" method="edit"
                                                :model="$file"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
