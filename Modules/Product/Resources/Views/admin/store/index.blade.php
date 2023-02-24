@extends('Panel::layouts.master')

@section('head-tag')
    <title>انبار</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> انبار</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        انبار
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        <a href="#" class="btn btn-info btn-sm disabled">ایجاد انبار جدید</a>
                        <x-panel-a-tag route="{{ route('product.store.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('product.store.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            @php $route = 'product.store.index' @endphp
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="نام کالا"
                                                  property="id"/>
                            </th>
                            <th>تصویر کالا</th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="تعداد قابل فروش"
                                                  property="marketable_number"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="تعداد فروخته شده"
                                                  property="sold_number"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$route" title="تعداد رزرو شده"
                                                  property="frozen_number"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <img
                                        src="{{ $product->imagePath() }}"
                                        alt="" width="100" height="50">
                                </td>
                                <td>{{ $product->getFaMarketableNumber() }}</td>
                                <td>{{ $product->getFaFrozenNumber() }}</td>
                                <td>{{ $product->getFaSoldNumber() }}</td>
                                <td class="width-22-rem text-center">
                                    @can($PERMISSION::PERMISSION_WAREHOUSE_ADD)
                                        <x-panel-a-tag route="{{ route('product.store.add-to-store', $product->id) }}"
                                                       title="افزودن موجودی"
                                                       icon="plus" color="outline-primary"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_WAREHOUSE_MODIFY)
                                        <x-panel-a-tag route="{{ route('product.store.edit', $product->id) }}"
                                                       title="ویرایش موجودی"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection
