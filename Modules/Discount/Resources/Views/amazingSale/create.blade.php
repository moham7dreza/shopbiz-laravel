@extends('Panel::layouts.master')

@section('head-tag')
    <title>افزودن به فروش شگفت انگیز</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('amazingSale.index') }}"> فروش شگفت انگیز</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> افزودن به فروش شگفت انگیز</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        افزودن به فروش شگفت انگیز
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('amazingSale.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('amazingSale.store') }}" method="POST">
                        @csrf
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-select-box col="5" name="product_id" label="انتخاب محصول"
                                                :message="$message" :collection="$products"
                                                property="name" option="کالا را انتخاب کنید"/>
                            <x-panel-input col="5" name="percentage" label="درصد تخفیف" :message="$message"/>
                            <x-panel-input col="5" name="start_date" label="تاریخ شروع" :date="true" class="d-none"
                                           :message="$message"/>
                            <x-panel-input col="5" name="end_date" label="تاریخ شروع" :date="true" class="d-none"
                                           :message="$message"/>
                            <x-panel-select-box col="10" name="status" label="وضعیت"
                                                :message="$message" :hasDefaultStatus="true" />
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
        const product_id = $('#product_id');
        product_id.select2({
            placeholder: 'لطفا کالا را انتخاب نمایید',
            multiple: false,
            tags: false
        })
    </script>
@endsection
