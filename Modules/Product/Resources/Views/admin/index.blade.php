@extends('Panel::layouts.master')

@section('head-tag')
    <title>کالاها</title>
@endsection

@section('content')

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
                    <a href="{{ route('product.create') }}" class="btn btn-info btn-sm">ایجاد کالای
                        جدید </a>
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
                                    @if(empty($product->tags()->get()->toArray()))
                                        <span class="text-danger">برای این کالا هیچ تگی تعریف نشده است</span>
                                    @else
                                        @foreach($product->tags as $tag)
                                            {{ $tag->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="product.status" method="changeStatus"
                                                      name="کالا" :model="$product" property="status"/>
                                </td>

                                <td>
                                    <x-panel-checkbox class="rounded" route="product.marketable" method="marketable"
                                                      uniqueId="marketable"
                                                      name="پست" :model="$product" property="marketable"/>
                                </td>

                                <td class="width-8-rem text-left">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-success btn-sm btn-block dorpdown-toggle"
                                           role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <i class="fa fa-tools"></i> عملیات
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @if($product->selected())
                                                <a href="{{ route('product.selected', $product->id) }}"
                                                   class="dropdown-item text-right"><i
                                                        class="fa fa-times text-danger"></i> حذف از محصولات پیشنهادی</a>
                                            @else
                                                <a href="{{ route('product.selected', $product->id) }}"
                                                   class="dropdown-item text-right"><i
                                                        class="fa fa-shopping-cart text-success"></i> افزودن به محصولات
                                                    پیشنهادی </a>
                                            @endif

                                            <a href="{{ route('product.gallery.index', $product->id) }}"
                                               class="dropdown-item text-right">
                                                <i class="fa fa-images text-warning"></i> گالری</a>
                                            <a href="{{ route('product.color.index', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-images"></i> مدیریت رنگ
                                                ها</a>
                                            <a href="{{ route('product.guarantee.index', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-shield-alt text-info"></i> گارانتی</a>
                                            <a href="{{ route('product.tags-from', $product->id) }}"
                                               class="dropdown-item text-right"><i
                                                    class="fa fa-tags text-primary"></i> تگ ها</a>
                                            <a href="{{ route('product.edit', $product->id) }}"
                                               class="dropdown-item text-right"><i class="fa fa-edit"></i> ویرایش</a>
                                            <form class="d-inline"
                                                  action="{{ route('product.destroy', $product->id) }}"
                                                  method="post">
                                                @csrf
                                                @method('Delete')
                                                <button type="submit" class="dropdown-item text-right"><i
                                                        class="fa fa-window-close"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </div>
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
