@extends('Panel::layouts.master')

@section('head-tag')
    <title>نظرات</title>
@endsection

@section('content')
    @php $PERMISSION = \Modules\ACL\Entities\Permission::class @endphp
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}"> خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#"> بخش محتوی</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> نظرات</li>
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
                        <x-panel-search-form route="{{ route('postComment.index') }}"/>
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
                            <th>پست</th>
                            <th>وضعیت تایید</th>
                            <th>وضعیت کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($postComments as $key => $comment)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $comment->getLimitedBody() }}</td>
                                <td>{{ $comment->getParentBody() }}</td>
                                <td>{{ $comment->getFaAuthorId() }}</td>
                                <td>{{ $comment->getAuthorName()  }}</td>
                                <td>{{ $comment->getFaCommentableId() }}</td>
                                <td>{{ $comment->getCommentableName() }}</td>
                                <td>{{ $comment->getFaApproved() }} </td>
                                <td>
                                    @can($PERMISSION::PERMISSION_POST_COMMENT_STATUS)
                                        <x-panel-checkbox class="rounded" route="postComment.status"
                                                          method="changeStatus"
                                                          name="نظر" :model="$comment" property="status"/>
                                    @endcan
                                </td>
                                <td class="width-16-rem text-left">
                                    @can($PERMISSION::PERMISSION_POST_COMMENT_SHOW)
                                        <x-panel-a-tag route="{{ route('postComment.show', $comment->id) }}"
                                                       title="نمایش نظر"
                                                       icon="eye" color="outline-info"/>
                                    @endcan
                                    @can($PERMISSION::PERMISSION_POST_COMMENT_APPROVE)
                                        @if($comment->approved == 1)
                                            <x-panel-a-tag route="{{ route('postComment.approved', $comment->id) }}"
                                                           title="عدم تایید نظر"
                                                           icon="clock" color="outline-warning"/>
                                        @else
                                            <x-panel-a-tag route="{{ route('postComment.approved', $comment->id) }}"
                                                           title="تایید نظر"
                                                           icon="check" color="outline-success"/>
                                        @endif
                                    @endcan
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <section class="border-top pt-3">{{ $postComments->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.panel.status')

@endsection

