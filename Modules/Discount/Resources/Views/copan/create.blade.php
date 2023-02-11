@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد کوپن تخفیف</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('copanDiscount.index') }}"> کوپن تخفیف</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد کوپن تخفیف</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد کوپن تخفیف
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('copanDiscount.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('copanDiscount.store') }}" method="POST">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="code" label="کد کوپن" :message="$message"/>

                            @php $types = \Modules\Discount\Entities\Copan::$copanTypesWithValues @endphp
                            <x-panel-select-box col="5" name="type" label="نوع کوپن"
                                                :message="$message" :arr="$types"/>

                            @php $amountTypes = \Modules\Discount\Entities\Copan::$amountTypesWithValues @endphp
                            <x-panel-select-box col="5" name="amount_type" label="نوع تخفیف"
                                                :message="$message" :arr="$amountTypes"/>

                            <x-panel-select-box col="10" name="user_id" label="کاربران" disabled
                                                :message="$message" :collection="$users"
                                                property="fullName" option="کاربر را انتخاب کنید"/>
                            <x-panel-input col="10" name="amount" label="میزان تخفیف" :message="$message"/>
                            <x-panel-input col="10" name="discount_ceiling" label="حداکثر تخفیف" :message="$message"/>
                            <x-panel-input col="5" name="start_date" label="تاریخ شروع" :date="true" class="d-none"
                                           :message="$message"/>
                            <x-panel-input col="5" name="end_date" label="تاریخ شروع" :date="true" class="d-none"
                                           :message="$message"/>
                            <x-panel-status col="10" name="status" label="وضعیت" :message="$message"/>
                            <x-panel-button col="12" title="ثبت"/>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>


    <script>
        $(document).ready(function () {
            $('#start_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField: '#start_date'
            }),
                $('#end_date_view').persianDatepicker({
                    format: 'YYYY/MM/DD',
                    altField: '#end_date'
                })
        });
    </script>


    <script>
        $("#type").change(function () {
            if ($('#type').find(':selected').val() === '1') {
                $('#user_id').removeAttr('disabled');
            } else {
                $('#user_id').attr('disabled', 'disabled');
            }
        });
    </script>

    <script>
        const user_id = $('#user_id');
        user_id.select2({
            placeholder: 'لطفا کاربر را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
