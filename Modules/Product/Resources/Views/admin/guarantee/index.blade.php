@extends('Panel::layouts.master')

@section('head-tag')
    <title>گارانتی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> گارانتی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        گارانتی
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('product.guarantee.create', $product->id) }}" class="btn btn-info btn-sm">ایجاد
                        گارانتی جدید </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('product.guarantee.index', $product) }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text" placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کالا</th>
                            <th>گارانتی کالا</th>
                            <th>افزایش قیمت</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($guarantees as $guarantee)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $product->name }}</td>
                                <td>
                                    {{ $guarantee->name }}
                                </td>
                                <td>
                                    {{ $guarantee->getFaPriceIncrease() }}
                                </td>
                                <td>
                                    <label>
                                        <input id="{{ $guarantee->id }}" onchange="changeStatus({{ $guarantee->id }}, 'گارانتی')"
                                               data-url="{{ route('product.guarantee.status', $guarantee->id) }}" type="checkbox"
                                               @if ($guarantee->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>


                                <td class="width-16-rem text-center">
                                    <form class="d-inline"
                                          action="{{ route('product.guarantee.destroy', ['product' => $product->id , 'guarantee' => $guarantee->id] ) }}"
                                          method="post">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm delete" type="submit"><i
                                                class="fa fa-trash-alt"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $guarantees->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    @include('Share::ajax-functions.panel.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
