@extends('Panel::layouts.master')

@section('head-tag')
    <title>برند</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">برند ها</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        برند ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('brand.create') }}" class="btn btn-info btn-sm">ایجاد برند </a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام فارسی برند</th>
                            <th>نام اصلی برند</th>
                            <th>لوگو</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($brands as $brand)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $brand->persian_name }}</td>
                                <td>{{ $brand->original_name }}</td>
                                <td>
                                    <img src="{{ $brand->logo() }}" alt="" width="100" height="50">
                                </td>
                                <td>
                                    <label>
                                        <input id="{{ $brand->id }}" onchange="changeStatus({{ $brand->id }}, 'برند')"
                                               data-url="{{ route('brand.status', $brand->id) }}"
                                               type="checkbox"
                                               @if ($brand->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('brand.edit', $brand->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('brand.destroy', $brand->id) }}"
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
                    <section class="border-top pt-3">{{ $brands->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
