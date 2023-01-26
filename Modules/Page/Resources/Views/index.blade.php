@extends('Panel::layouts.master')

@section('head-tag')
    <title>پیج ساز</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوا</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> پیج ساز</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پیج ساز
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('page.create') }}" class="btn btn-info btn-sm">ایجاد پیج جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان</th>
                            <th>تگ ها</th>
                            <th>اسلاگ</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $page->limitedTitle() }}</td>
                                <td>{{ $page->tags }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $page->id }}" onchange="changeStatus({{ $page->id }}, 'پیج ساز')"
                                               data-url="{{ route('page.status', $page->id) }}" type="checkbox"
                                               @if ($page->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('page.edit', $page->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('page.destroy', $page->id) }}"
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
                    <section class="border-top pt-3">{{ $pages->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
