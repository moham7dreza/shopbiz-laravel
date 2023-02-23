@extends('Panel::layouts.master')

@section('head-tag')
    <title>مقدار فرم کالا</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('attribute.index') }}"> فرم کالا</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> مقدار فرم کالا</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        مقدار فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_ATTRIBUTE_VALUE_CREATE)
                            <a href="{{ route('attributeValue.create', $attribute->id) }}"
                               class="btn btn-info btn-sm">ایجاد مقدار فرم کالا جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route($redirectRoute, $attribute->id) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($redirectRoute, $attribute->id) }}"/>
                    </div>
                </section>

                <section class="row mb-4">
                    <x-panel-section col="5" id="attribute-name" label="نام فرم" text="{{ $attribute->name }}"/>
                    <x-panel-section col="5" id="attribute-intro" label="واحد اندازه گیری"
                                     text="{{ $attribute->unit . ' - ' . $attribute->unit_en }}"/>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn property="product_id" :route="$redirectRoute"
                                                  :params="$attribute->id"
                                                  title="نام محصول"/>
                            </th>
                            <th>نام دسته بندی</th>
                            <th>مقدار</th>
                            <th>
                                <x-panel-sort-btn property="value" :route="$redirectRoute"
                                                  :params="$attribute->id"
                                                  title="افزایش قیمت"/>
                            </th>
                            <th>نوع</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($values as $value)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $value->getProductName() }}</td>
                                <td>{{ $value->getCategoryName() }}</td>
                                <td>{{ $value->getFaValue() . ' ' . $attribute->unit }}</td>
                                <td>{{ $value->getFaPriceIncreaseAmount() }}</td>
                                <td>{{ $value->getFaType() }}</td>
                                <td class="width-22-rem text-left">
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_VALUE_EDIT)
                                        <x-panel-a-tag
                                            route="{{ route('attributeValue.edit', ['attribute' => $attribute->id , 'value' => $value->id]) }}"
                                            title="ویرایش آیتم" icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_VALUE_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('attributeValue.destroy', ['attribute' => $attribute->id , 'value' => $value->id]) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </section>
                <section class="border-top pt-3">{{ $values->links() }}</section>
            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection

