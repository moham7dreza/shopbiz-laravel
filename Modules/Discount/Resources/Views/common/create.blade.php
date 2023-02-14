@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد تخفیف عمومی</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
    @livewireStyles
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('commonDiscount.index') }}"> تخفیف عمومی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد تخفیف عمومی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد تخفیف عمومی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('commonDiscount.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('commonDiscount.store') }}" method="POST">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="percentage" label="درصد تخفیف" :message="$message"/>
                            <livewire:fa-price-input col="10" name="discount_ceiling" label="حداکثر تخفیف"
                                                     class="dir-ltr" :message="$message"/>
                            <livewire:fa-price-input col="10" name="minimal_order_amount" label="حداقل مبلغ خرید"
                                                     class="dir-ltr" :message="$message"/>
                            <x-panel-input col="10" name="title" label="عنوان مناسبت" :message="$message"/>
                            <x-panel-input col="5" name="start_date" label="تاریخ شروع" :date="true" class="d-none"
                                           :message="$message"/>
                            <x-panel-input col="5" name="end_date" label="تاریخ شروع" :date="true" class="d-none"
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
    @livewireScripts
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
@endsection
