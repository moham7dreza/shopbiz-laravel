@extends('Panel::layouts.master')

@section('head-tag')
    <title>مدیریت رنگ های محصول</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> رنگ</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        رنگ
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_PRODUCT_COLOR_CREATE)
                            <a href="{{ route('product.color.create', $product->id) }}" class="btn btn-info btn-sm">ایجاد
                                رنگ جدید </a>
                        @endcan
                        <x-panel-a-tag route="{{ route('product.color.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('product.color.index', $product->id) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کالا</th>
                            <th>رنگ کالا</th>
                            <th>رنگ</th>
                            <th>افزایش قیمت</th>
                            <th>تعداد قابل فروش</th>
                            <th>تعداد فروخته شده</th>
                            <th>تعداد رزرو شده</th>
                            <th><x-panel-sort-btn route="permission.index" title="وضعیت" property="status"/>
</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($colors as $color)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>{{ $color->getColorName() }}</td>
                                <td>
                                    <span style="background-color: {{ $color->getColorCode() ?? '#ffffff' }};"
                                          class="colors"></span>
                                </td>
                                <td>{{ $color->getFaPriceIncrease() }}</td>
                                <td>{{ $color->getFaMarketableNumber() }}</td>
                                <td>{{ $color->getFaSoldNumber() }}</td>
                                <td>{{ $color->getFaFrozenNumber() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_COLOR_STATUS)
                                        <x-panel-checkbox class="rounded" route="product.color.status"
                                                          method="changeStatus"
                                                          name="رنگ کالا" :model="$color" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-12-rem text-center">
                                    @can($PERMISSION::PERMISSION_PRODUCT_COLOR_EDIT)
                                        <x-panel-a-tag
                                            route="{{ route('product.color.edit', ['product' => $product->id , 'color' => $color->id]) }}"
                                            title="ویرایش آیتم"
                                            icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PRODUCT_COLOR_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('product.color.destroy', ['product' => $product->id , 'color' => $color->id] ) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $colors->links() }}</section>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
