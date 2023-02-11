@extends('Panel::layouts.master')

@section('head-tag')
    <title>کوپن تخفیف</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> کوپن تخفیف</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کوپن تخفیف
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('copanDiscount.create') }}" class="btn btn-info btn-sm">ایجاد کوپن تخفیف</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('copanDiscount.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>کد تخفیف</th>
                            <th>میزان تخفیف</th>
                            <th>نوع تخفیف</th>
                            <th>سقف تخفیف</th>
                            <th>نوع کوپن</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th>وضعیت</th>
                            <th>هم اکنون فعال است</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($copans as $copan)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $copan->code }}</th>
                                <th>{{ $copan->getFaAmount() }}</th>
                                <th>{{ $copan->getFaAmountType() }}</th>
                                <th>{{ $copan->getFaDiscountCeiling() }} </th>
                                <th>{{ $copan->getDiscountType() }}</th>
                                <td>{{ $copan->getFaStartDate() }}</td>
                                <td>{{ $copan->getFaEndDate() }}</td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="copanDiscount.status" method="changeStatus"
                                                      name="کپن تخفیف" :model="$copan" property="status"/>
                                </td>
                                <td>
                                    @if($copan->activated())
                                        <span class="text-success font-size-16 mr-4"><i class="fa fa-check"></i></span>
                                    @else
                                        <span class="text-danger font-size-16 mr-4"><i class="fa fa-times"></i></span>
                                    @endif
                                </td>
                                <td class="width-16-rem text-left">
                                    <x-panel-a-tag route="{{ route('copanDiscount.edit', $copan->id) }}"
                                                   title="ویرایش آیتم" icon="edit" color="info"/>
                                    <x-panel-delete-form
                                        route="{{ route('copanDiscount.destroy', $copan->id) }}"
                                        title="حذف آیتم"/>
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $copans->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')
    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
