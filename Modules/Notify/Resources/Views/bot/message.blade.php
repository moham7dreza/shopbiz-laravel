@extends('Panel::layouts.master')

@section('head-tag')
    <title>ربات</title>
@endsection

@section('content')

    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> اطلاع رسانی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ربات</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ارسال پیام به ربات
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <button class="btn btn-info btn-sm" disabled>ربات</button>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section>
                    <form action="{{ route('telegram.bot.send.message') }}" method="POST">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="chat_id" label="آی دی ربات"
                                           :message="$message"/>

                            <x-panel-text-area col="10" name="text" label="محتوی پیام" rows="12"
                                               :message="$message"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('text');
    </script>
@endsection
