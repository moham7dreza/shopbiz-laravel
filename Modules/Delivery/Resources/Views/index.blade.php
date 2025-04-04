@extends('Panel::layouts.master')

@section('head-tag')
    <title>روش های ارسال</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> روش های ارسال</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        روش های ارسال
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_DELIVERY_METHOD_CREATE)
                            <a href="{{ route('delivery.create') }}" class="btn btn-info btn-sm">ایجاد روش ارسال
                                جدید </a>
                        @endcan
                        <x-panel-a-tag route="{{ route('delivery.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('delivery.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn route="delivery.index" title="نام روش ارسال"/>
                            </th>
                            <th>
                                <x-panel-sort-btn route="delivery.index" title="هزینه ارسال" property="amount"/>
                            </th>
                            <th>
                                <x-panel-sort-btn route="delivery.index" title="زمان ارسال" property="delivery_time"/>
                            </th>
                            <th>
                                <x-panel-sort-btn route="delivery.index" title="وضعیت" property="status"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($delivery_methods as $delivery_method)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $delivery_method->name }}</td>
                                <td>{{ $delivery_method->getFaAmount() }}</td>
                                <td>{{ $delivery_method->getFaDeliveryTime() }}</td>
                                <td>
                                    @can($PERMISSION::PERMISSION_DELIVERY_METHOD_STATUS)
                                        <x-panel-checkbox class="rounded" route="delivery.status" method="changeStatus"
                                                          name="روش ارسال" :model="$delivery_method" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_DELIVERY_METHOD_EDIT)
                                        <x-panel-a-tag route="{{ route('delivery.edit', $delivery_method->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_DELIVERY_METHOD_DELETE)
                                        <x-panel-delete-form
                                            route="{{ route('delivery.destroy', $delivery_method->id) }}"
                                            title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $delivery_methods->links() }}</section>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
