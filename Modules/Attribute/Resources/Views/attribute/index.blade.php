@extends('Panel::layouts.master')

@section('head-tag')
    <title>فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> فرم کالا</li>
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
                    <a href="{{ route('attribute.create') }}" class="btn btn-info btn-sm">ایجاد فرم جدید</a>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('attribute.index') }}" />
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام فرم</th>
                            <th>واحد اندازه گیری</th>
                            <th>دسته بندی ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($attributes as $attribute)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $attribute->name }}</td>
                                <td>{{ $attribute->unit }}</td>
                                <td>
                                    @if(empty($attribute->categories()->get()->toArray()))
                                        <span class="text-danger">برای این فرم کالا هیچ دسته بندی تعریف نشده است</span>
                                    @else
                                        @foreach($attribute->categories as $category)
                                            {{ $category->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <x-panel-checkbox class="rounded" route="attribute.status" method="changeStatus" name="فرم کالا" :model="$attribute" property="status" />
                                </td>
                                <td class="width-22-rem text-left">
                                    <x-panel-a-tag route="{{ route('attribute.category-form', $attribute->id) }}" title="تعریف دسته بندی" icon="list-ul" color="success" />
                                    <x-panel-a-tag route="{{ route('attributeValue.index', $attribute->id) }}" title="مقادیر فرم کالا" icon="weight" color="warning" />
                                    <x-panel-a-tag route="{{ route('attribute.edit', $attribute->id) }}" title="ویرایش آیتم" icon="edit" color="info" />
                                    <x-panel-delete-form route="{{ route('attribute.destroy', $attribute->id) }}" title="حذف آیتم" />
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

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
