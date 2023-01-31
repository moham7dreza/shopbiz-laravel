@extends('Panel::layouts.master')

@section('head-tag')
    <title>نظرات</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#"> خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> نظرات</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نظرات
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="#" class="btn btn-info btn-sm disabled">ایجاد نظر </a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('productComment.index') }}" class="d-flex">
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
                            <th>نظر</th>
                            <th>پاسخ به</th>
                            <th>کد کاربر</th>
                            <th>نویسنده نظر</th>
                            <th>کد پست</th>
                            <th>محصول</th>
                            <th>وضعیت تایید</th>
                            <th>وضعیت کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($productComments as $key => $comment)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $comment->limitedBody() }}</td>
                                <td>{{ $comment->textParentBody() }}</td>
                                <td>{{ $comment->authorId() }}</td>
                                <td>{{ $comment->textAuthorName()  }}</td>
                                <td>{{ $comment->commentableId() }}</td>
                                <td>{{ $comment->getCommentableName() }}</td>
                                <td>{{ $comment->textApprove() }} </td>
                                <td>
                                    <label>
                                        <input id="{{ $comment->id }}" onchange="changeStatus({{ $comment->id }}, 'نظر')"
                                               data-url="{{ route('productComment.status', $comment->id) }}"
                                               type="checkbox" @if ($comment->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('productComment.show', $comment->id) }}"
                                       class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>

                                    @if($comment->approved == 1)
                                        <a href="{{ route('productComment.approved', $comment->id)}} "
                                           class="btn btn-warning btn-sm" type="submit"><i class="fa fa-clock"></i></a>
                                    @else
                                        <a href="{{ route('productComment.approved', $comment->id)}}"
                                           class="btn btn-success btn-sm text-white" type="submit"><i
                                                class="fa fa-check"></i></a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $productComments->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.status')

@endsection

