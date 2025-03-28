@extends('Panel::layouts.master')

@section('head-tag')
    <title>فروش شگفت انگیز</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> فروش شگفت انگیز</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فروش شگفت انگیز
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_AMAZING_SALE_CREATE)
                            <a href="{{ route('amazingSale.create') }}" class="btn btn-info btn-sm">افزودن کالا به لیست
                                شگفت انگیز</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('amazingSale.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('amazingSale.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'amazingSale.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام کالا" property="product_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="درصد تخفیف" property="percentage"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="تاریخ شروع" property="start_date"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="تاریخ پایان" property="end_date"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="وضعیت" property="status"/>
                            </th>
                            <th>هم اکنون فعال است</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($amazingSales as $amazingSale)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $amazingSale->getProductName() }}</th>
                                <th>{{ $amazingSale->getFaPercentage() }}</th>
                                <td>{{ $amazingSale->getFaStartDate() }}</td>
                                <td>{{ $amazingSale->getFaEndDate() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_AMAZING_SALE_STATUS)
                                        <x-panel-checkbox class="rounded" route="amazingSale.status"
                                                          method="changeStatus"
                                                          name="تخفیف شگفت انگیز" :model="$amazingSale"
                                                          property="status"/>
                                    @endcan
                                </td>
                                <td>
                                    @if($amazingSale->activated())
                                        <span class="text-success font-size-16 mr-4"><i class="fa fa-check"></i></span>
                                    @else
                                        <span class="text-danger font-size-16 mr-4"><i class="fa fa-times"></i></span>
                                    @endif
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_AMAZING_SALE_EDIT)
                                        <x-panel-a-tag route="{{ route('amazingSale.edit', $amazingSale->id) }}"
                                                       title="ویرایش آیتم" icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_AMAZING_SALE_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('amazingSale.destroy', $amazingSale->id) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $amazingSales->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')
    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
