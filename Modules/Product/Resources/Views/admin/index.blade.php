@extends('Panel::layouts.master')

@section('head-tag')
    <title>کالاها</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> کالاها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کالاها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    @can($PERMISSION::PERMISSION_PRODUCT_CREATE)
                        <a href="{{ route('product.create') }}" class="btn btn-info btn-sm">ایجاد کالای
                            جدید </a>
                    @endcan
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('product.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کالا</th>
                            <th> تصویر کالا</th>
                            <th> قیمت</th>
                            <th>وزن</th>
                            <th>دسته</th>
                            <th>تعداد بازدید</th>
                            <th>تعداد لایک</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th>قابل فروش بودن</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $product->getLimitedName() }}</td>
                                <td>
                                    <img
                                        src="{{ $product->imagePath('small') }}" alt="">
                                </td>
                                <td>{{ $product->getFaPrice() }}</td>
                                <td>{{ $product->getFaWeight() }}</td>
                                <td>{{ $product->getCategoryName() }}</td>
                                @php
                                    $product->active_discount_percentage = $product->activeAmazingSales()->percentage ?? null;
                                    $product->popular = $product->rating >= 4 ? 1 : 0;
                                    $viewsCount = $product->getFaViewsCount();
                                    $product->views_count = convertPersianToEnglish($viewsCount);
                                    $likesCount = $product->getFaLikersCount();
                                    $product->likes_count = convertPersianToEnglish($likesCount);
                                    $product->save();
                                @endphp
                                <td>{{ $viewsCount }}</td>
                                <td>{{ $likesCount }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_TAGS)
                                        <x-panel-tags :model="$product" related="tags" name="کالا"/>
                                    @endcan
                                </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_STATUS)
                                        <x-panel-checkbox class="rounded" route="product.status" method="changeStatus"
                                                          name="کالا" :model="$product" property="status"/>
                                    @endcan
                                </td>

                                <td>
                                    @can($PERMISSION::PERMISSION_PRODUCT_MARKETABLE)
                                        <x-panel-checkbox class="rounded" route="product.marketable" method="marketable"
                                                          uniqueId="marketable"
                                                          name="پست" :model="$product" property="marketable"/>
                                    @endcan
                                </td>

                                <td class="width-12-rem text-left">
                                    @can($PERMISSION::PERMISSION_PRODUCT_SELECTED)
                                        @php $flag = $product->selected(); @endphp
                                        <x-panel-a-tag route="{{ route('product.selected', $product->id) }}"
                                                       title="{{ $flag ? 'حذف از محصولات پیشنهادی' : 'افزودن به محصولات پیشنهادی' }}"
                                                       icon="{{ $flag ? 'times' : 'shopping-cart' }}"
                                                       color="{{ $flag ? 'outline-danger' : 'outline-success' }}"
                                                       class="{{ $flag ? 'pad-03-07' : '' }}"/>
                                    @endcan
                                    <x-panel-dropdown text="عملیات" icon="tools">
                                        @can($PERMISSION::PERMISSION_PRODUCT_GALLERY)
                                            <a href="{{ route('product.gallery.index', $product->id) }}"
                                               class="dropdown-item text-right">
                                                <i class="fa fa-images text-warning"></i><span class="mx-2">گالری</span>
                                            </a>
                                        @endcan
                                        @can($PERMISSION::PERMISSION_PRODUCT_COLORS)
                                            <a href="{{ route('product.color.index', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-circle-notch text-greenyellow"></i><span
                                                    class="mx-2">رنگ</span>
                                            </a>
                                        @endcan
                                        @can($PERMISSION::PERMISSION_PRODUCT_GUARANTEES)
                                            <a href="{{ route('product.guarantee.index', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-shield-alt text-secondary"></i><span
                                                    class="mx-2">گارانتی</span></a>
                                        @endcan
                                        @can($PERMISSION::PERMISSION_PRODUCT_TAGS)
                                            <a href="{{ route('product.tags-from', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-tags text-primary"></i><span
                                                    class="mx-2">تگ</span></a>
                                        @endcan
                                        @can($PERMISSION::PERMISSION_PRODUCT_VALUES)
                                            <a href="{{ route('product.values-from', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-tags text-primary"></i><span
                                                    class="mx-2">متا</span></a>
                                        @endcan
                                        @can($PERMISSION::PERMISSION_PRODUCT_EDIT)
                                            <a href="{{ route('product.edit', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-edit text-info"></i><span
                                                    class="mx-2">ویرایش</span></a>
                                        @endcan
                                        @can($PERMISSION::PERMISSION_PRODUCT_DELETE)
                                            <form class="d-inline"
                                                  action="{{ route('product.destroy', $product->id) }}"
                                                  method="post">
                                                @csrf
                                                @method('Delete')
                                                <button type="submit" class="dropdown-item text-right"><i
                                                        class="fa fa-window-close text-danger"></i> <span
                                                        class="mx-2">حذف</span>
                                                </button>
                                            </form>
                                        @endcan
                                    </x-panel-dropdown>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $products->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    @include('Share::ajax-functions.panel.status')
    @include('Share::ajax-functions.panel.marketable')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
