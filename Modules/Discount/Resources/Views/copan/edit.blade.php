@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش کوپن تخفیف</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">تخفیف</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش کوپن تخفیف</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش کوپن تخفیف
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('copanDiscount.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('copanDiscount.update', $copanDiscount->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <section class="row">

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">کد کوپن</label>
                                    <input type="text" name="code" value="{{ old('code', $copanDiscount->code) }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('code')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نوع کوپن</label>
                                    <select name="type" id="type" class="form-control form-control-sm">
                                        <option value="0" @if(old('type', $copanDiscount->type) == 0) selected @endif>عمومی
                                        </option>
                                        <option value="1" @if(old('type', $copanDiscount->type) == 1) selected @endif>خصوصی
                                        </option>
                                    </select>
                                </div>
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">کاربران</label>
                                    <select name="user_id" id="users"
                                            class="form-control form-control-sm" {{ $copanDiscount->type == 0 ? 'disabled' : ''}}>
                                        @foreach ($users as $user)

                                            <option @if(old('user_id', $copanDiscount->user_id) == $user->id) selected
                                                    @endif value="{{ $user->id }}">{{ $user->fullName }}</option>

                                        @endforeach

                                    </select>
                                </div>
                                @error('user_id')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نوع تخفیف</label>
                                    <select name="amount_type" id="amount_type" class="form-control form-control-sm">
                                        <option value="0"
                                                @if(old('amount_type', $copanDiscount->amount_type) == 0) selected @endif>درصدی
                                        </option>
                                        <option value="1"
                                                @if(old('amount_type', $copanDiscount->amount_type) == 1) selected @endif>عددی
                                        </option>
                                    </select>
                                </div>
                                @error('amount_type')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">میزان تخفیف</label>
                                    <input type="text" name="amount" value="{{ old('amount', $copanDiscount->amount) }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('amount')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">حداکثر تخفیف</label>
                                    <input type="text" name="discount_ceiling"
                                           value="{{ old('discount_ceiling', $copanDiscount->discount_ceiling) }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('discount_ceiling')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تاریخ شروع</label>
                                    <input type="text" name="start_date" id="start_date"
                                           class="form-control form-control-sm d-none">
                                    <input type="text" id="start_date_view" class="form-control form-control-sm">
                                </div>
                                @error('start_date')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تاریخ پایان</label>
                                    <input type="text" name="end_date" id="end_date"
                                           class="form-control form-control-sm d-none">
                                    <input type="text" id="end_date_view" class="form-control form-control-sm">
                                </div>
                                @error('end_date')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" id="" class="form-control form-control-sm" id="status">
                                        <option value="0" @if(old('status', $copanDiscount->status) == 0) selected @endif>
                                            غیرفعال
                                        </option>
                                        <option value="1" @if(old('status', $copanDiscount->status))
                                            == 1) selected
                                        @endif>فعال</option>
                                    </select>
                                </div>
                                @error('status')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>
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
                $('#users').removeAttr('disabled');
            } else {
                $('#users').attr('disabled', 'disabled');

            }

        });

    </script>

@endsection
