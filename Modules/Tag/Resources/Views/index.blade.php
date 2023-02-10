@extends('Panel::layouts.master')

@section('head-tag')
    <title>تگ ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">تگ ها</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تگ ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('tag.create') }}" class="btn btn-info btn-sm">ایجاد تگ </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('tag.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control form-control-sm form-text"
                                   placeholder="جستجو">
                            <button type="submit" class="btn btn-light btn-sm"><i class="fa fa-check"></i></button>
                        </form>
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان تگ</th>
                            <th>نوع</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $key => $tag)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $tag->name }}</td>
                                <td>{{ $tag->type ?? '-' }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $tag->id }}" onchange="changeStatus({{ $tag->id }}, 'تگ')"
                                               data-url="{{ route('tag.status', $tag->id) }}"
                                               type="checkbox" @if ($tag->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>

                                <td class="width-16-rem text-left   ">
                                    <a href="{{ route('tag.edit', $tag->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('tag.destroy', $tag->id) }}"
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
                </section>
                {{ $tags->links() }}
            </section>
        </section>
    </section>

@endsection
@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
