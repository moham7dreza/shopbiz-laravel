@extends('Panel::layouts.master')

@section('head-tag')
    <title>منو</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> منو</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        منو
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <section class="d-flex">
                        @can($PERMISSION::PERMISSION_MENU_CREATE)
                            <a href="{{ route('menu.create') }}" class="btn btn-info btn-sm">ایجاد منوی جدید</a>
                        @endcan
                        <x-panel-a-tag route="{{ route('menu.index') }}" text="حذف فیلتر"
                                       color="outline-danger"/>
                    </section>

                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('menu.index') }}"/>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <x-panel-sort-btn route="menu.index" title="نام منو"/>
                            </th>
                            <th>
                                <x-panel-sort-btn route="menu.index" title="منوی والد" property="parent_id"/>
                            </th>
                            <th>
                                <x-panel-sort-btn route="menu.index" title="لینک منو" property="url" class="text-left"/>
                            </th>
                            <th>
                                <x-panel-sort-btn route="menu.index" title="وضعیت" property="status" class="text-center"/>
                            </th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($menus as $key => $menu)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $menu->name }}</td>
                                <td>{{ $menu->getParentName() }}</td>
                                <td class="text-left dir-ltr">{{ $menu->url }}</td>
                                <td class="text-center">
                                    @can($PERMISSION::PERMISSION_MENU_STATUS)
                                        <x-panel-checkbox class="rounded" route="menu.status" method="changeStatus"
                                                          name="منو" :model="$menu" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_MENU_EDIT)
                                        <x-panel-a-tag route="{{ route('menu.edit', $menu->id) }}"
                                                       title="ویرایش آیتم"
                                                       icon="edit" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_MENU_DELETE)
                                        <x-panel-delete-form route="{{ route('menu.destroy', $menu->id) }}"
                                                             title="حذف آیتم"/>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $menus->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
