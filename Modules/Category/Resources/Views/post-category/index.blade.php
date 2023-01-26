@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسته بندی</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسته بندی</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسته بندی
                    </h5>
                </section>

                @include('Panel::alerts.alert-section.success')

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('postCategory.create') }}" class="btn btn-info btn-sm">ایجاد دسته بندی</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام دسته بندی</th>
                            <th>توضیحات</th>
                            {{--                            <th>اسلاگ</th>--}}
                            <th>عکس</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($postCategories as $key => $postCategory)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $postCategory->name }}</td>
                                <td>{!! $postCategory->limitedDescription() !!}</td>
                                {{--                                <td>{{ $postCategory->slug }}</td>--}}
                                <td>
                                    <img
                                        src="{{ $postCategory->imagePath() }}"
                                        alt="" width="100" height="50">
                                </td>
                                <td>{{ $postCategory->tags }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $postCategory->id }}"
                                               onchange="changeStatus({{ $postCategory->id }}, 'دسته بندی')"
                                               data-url="{{ route('postCategory.status', $postCategory->id) }}"
                                               type="checkbox" @if ($postCategory->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('postCategory.edit', $postCategory->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('postCategory.destroy', $postCategory->id) }}"
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
                    <section class="border-top pt-3">{{ $postCategories->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection
@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
