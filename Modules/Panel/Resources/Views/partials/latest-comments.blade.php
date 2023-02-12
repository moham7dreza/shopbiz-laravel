<!-- All comments --->
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    نظرات
                </h5>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 pb-2">
                    <p>
                        تمامی کامنت های اخیر ایجاد شده
                    </p>
                    <div class="max-width-16-rem">
                        <x-panel-search-form route="{{ route('panel.home') }}"/>
                    </div>
                </section>
            </section>
            <section class="body-content">
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نظر</th>
                            <th>پاسخ به</th>
                            <th>نویسنده نظر</th>
                            <th>نام</th>
                            <th>وضعیت تایید</th>
                            <th>وضعیت کامنت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($panelRepo->latestComments() as $key => $comment)

                            <tr>
                                <th>{{ $key + 1 }}</th>
                                <td>{{ $comment->getLimitedBody() }}</td>
                                <td>{{ $comment->getParentBody() }}</td>
                                <td>{{ $comment->getAuthorName()  }}</td>
                                <td>{{ $comment->getCommentableName() }}</td>
                                <td>{{ $comment->getFaApproved() }} </td>
                                <td>{{ $comment->textStatus() }} </td>

                                <td class="width-8-rem text-left">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-success btn-sm btn-block dorpdown-toggle"
                                           role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <i class="fa fa-tools"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">

                                            <a href="#"
                                               class="dropdown-item text-right"><i class="fa fa-eye"></i> نمایش
                                            </a>

                                            <a href="{{ $comment->commentAdminPath() }}"
                                               class="dropdown-item text-right"><i class="fa fa-edit"></i>
                                                ویرایش </a>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    {{ $panelRepo->latestComments()->links() }}
                </section>
            </section>
        </section>
    </section>
</section>
