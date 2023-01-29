@extends('Panel::layouts.master')

@section('head-tag')
    <title>مقدار فرم کالا</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> مقدار فرم کالا</li>
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
                    <a href="{{ route('attributeValue.create', $attribute->id) }}"
                       class="btn btn-info btn-sm">ایجاد مقدار فرم کالا جدید</a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('attributeValue.index', $attribute) }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text" placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام فرم</th>
                            <th>نام محصول</th>
                            <th>نام دسته بندی</th>
                            <th>مقدار</th>
                            <th>افزایش قیمت</th>
                            <th>نوع</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($values as $value)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $attribute->name }}</td>
                                <td>{{ $value->textProductName() }}</td>
                                <td>{{ $value->textCategoryName() }}</td>
                                <td>{{ $value->getValue() }}</td>
                                <td>{{ $value->getFaPrice() }}</td>
                                <td>{{ $value->getTextType() }}</td>
                                <td class="width-22-rem text-left">
                                    <a href="{{ route('attributeValue.edit', ['attribute' => $attribute->id , 'value' => $value->id] ) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('attributeValue.destroy', ['attribute' => $attribute->id , 'value' => $value->id] ) }}"
                                          method="post">
                                        @csrf
                                        {{ method_field('delete') }}
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>
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

