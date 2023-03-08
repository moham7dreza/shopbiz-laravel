@extends('Panel::layouts.master')

@section('head-tag')
    <title>فرم کالا</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    @php $index_route = 'attribute.index' @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> فرم کالا</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فرم کالا
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_ATTRIBUTE_CREATE)
                            <a href="{{ route('attribute.create') }}" class="btn btn-info btn-sm">ایجاد فرم جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route($index_route) }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route($index_route) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="نام فرم"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="واحد اندازه گیری" property="unit"/>
                            </th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="واحد اندازه گیری لاتین" property="unit_en"/>
                            </th>
                            <th>دسته بندی ها</th>
                            <th>
                                <x-panel-sort-btn :route="$index_route" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($attributes as $attribute)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $attribute->name }}</td>
                                <td>{{ $attribute->unit }}</td>
                                <td>{{ $attribute->unit_en }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_CATEGORIES)
                                        <x-panel-tags :model="$attribute" related="categories" name="فرم کالا"
                                                      title="دسته بندی"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_STATUS)
                                        <x-panel-checkbox class="rounded" route="attribute.status" method="changeStatus"
                                                          name="فرم کالا" :model="$attribute" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-22-rem text-left">
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_CATEGORIES)
                                        <x-panel-a-tag route="{{ route('attribute.category-form', $attribute->id) }}"
                                                       title="تعریف دسته بندی" icon="list-ul" color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_VALUES)
                                        <x-panel-a-tag route="{{ route('attributeValue.index', $attribute->id) }}"
                                                       title="مقادیر فرم کالا" icon="weight" color="outline-warning"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_EDIT)
                                        <x-panel-a-tag route="{{ route('attribute.edit', $attribute->id) }}"
                                                       title="ویرایش آیتم" icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_ATTRIBUTE_DELETE)
                                        <x-panel-delete-form route="{{ route('attribute.destroy', $attribute->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $attributes->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
