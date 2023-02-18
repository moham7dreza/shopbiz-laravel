@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسته بندی</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> دسته بندی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسته بندی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_CREATE)
                        <a href="{{ route('productCategory.create') }}" class="btn btn-info btn-sm">ایجاد دسته بندی</a>
                    @endcan
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('productCategory.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام دسته بندی</th>
                            <th>دسته والد</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th>نمایش در منو</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($productCategories as $productCategory)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $productCategory->name }}</td>
                                <td>{{ $productCategory->getParentName() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_TAGS)
                                        <x-panel-tags :model="$productCategory" related="tags" name="دسته بندی"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_STATUS)
                                        <x-panel-checkbox class="rounded" route="productCategory.status"
                                                          method="changeStatus"
                                                          name="دسته بندی" :model="$productCategory" property="status"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_SHOW_IN_MENU)
                                        <x-panel-checkbox class="rounded" route="productCategory.showInMenu"
                                                          uniqueId="show"
                                                          method="changeShowInMenu"
                                                          name="دسته بندی" :model="$productCategory"
                                                          property="show_in_menu"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_TAGS)
                                        <x-panel-a-tag route="{{ route('productCategory.tags-from', $productCategory->id) }}"
                                                       title="افزودن تگ"
                                                       icon="tag" color="outline-success"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_EDIT)
                                        <x-panel-a-tag route="{{ route('productCategory.edit', $productCategory->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_PRODUCT_CATEGORY_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('productCategory.destroy', $productCategory->id) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $productCategories->links() }}</section>
                </section>

            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')
    @include('Share::ajax-functions.panel.show-in-menu')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
