@extends('Panel::layouts.master')

@section('head-tag')
    <title>بنر ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">بنر ها</li>
        </ol>
    </nav>



    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        بنر ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('banner.create') }}" class="btn btn-info btn-sm">ایجاد بنر </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('banner.index') }}" class="d-flex">
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
                            <th>عنوان بنر</th>
                            <th>آدرس</th>
                            <th>تصویر</th>
                            <th>وضعیت</th>
                            <th>مکان</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($banners as $key => $banner)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $banner->limitedTitle() }}</td>
                                <td>{{ $banner->url }}</td>
                                <td>
                                    <img src="{{ $banner->image() }}" alt="" width="100" height="50">
                                </td>
                                <td>
                                    <label>
                                        <input id="{{ $banner->id }}" onchange="changeStatus({{ $banner->id }}, 'بنر')"
                                               data-url="{{ route('banner.status', $banner->id) }}" type="checkbox"
                                               @if ($banner->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>

                                <td>
                                    {{ $banner->textPosition() }}
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('banner.edit', $banner->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('banner.destroy', $banner->id) }}"
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
                    <section class="border-top pt-3">{{ $banners->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
