@extends('Panel::layouts.master')

@section('head-tag')
    <title>منو</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('menu.index') }}"> منو</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد منو</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد منو
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('menu.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('menu.store') }}" method="post">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="name" label="عنوان منو"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="parent_id" label="منو والد"
                                                :message="$message" :collection="$menus"
                                                property="name" option="منوی اصلی"/>
                            <x-panel-input col="10" name="url" label="آدرس URL" class="dir-ltr text-left"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')
    <script>
        const parent_id = $('#parent_id');
        parent_id.select2({
            // placeholder: 'لطفا منو را وارد نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
