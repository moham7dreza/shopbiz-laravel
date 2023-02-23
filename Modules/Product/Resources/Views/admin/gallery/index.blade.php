@extends('Panel::layouts.master')

@section('head-tag')
    <title>گالری</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('product.index') }}"> کالاها</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> گالری</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        گالری
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_PRODUCT_GALLERY_CREATE)
                            <a href="{{ route('product.gallery.create', $product->id) }}" class="btn btn-info btn-sm">ایجاد
                                عکس جدید </a>
                        @endcan
                        <x-panel-a-tag route="{{ route('product.gallery.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('product.gallery.index', $product->id) }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کالا</th>
                            <th> تصویر کالا</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($images as $image)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <img src="{{ $image->getImagePath() }}"
                                         alt="" width="100" height="50">
                                </td>
                                <td class="width-12-rem text-center">
                                    @can($PERMISSION::PERMISSION_PRODUCT_GALLERY_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('product.gallery.destroy', ['product' => $product->id , 'gallery' => $image->id]) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $images->links() }}</section>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
