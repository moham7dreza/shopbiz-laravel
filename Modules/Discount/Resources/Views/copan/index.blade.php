@extends('Panel::layouts.master')

@section('head-tag')
    <title>کوپن تخفیف</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">کوپن تخفیف</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کوپن تخفیف
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('copanDiscount.create') }}" class="btn btn-info btn-sm">ایجاد کوپن تخفیف</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>کد تخفیف</th>
                            <th>میزان تخفیف</th>
                            <th>نوع تخفیف</th>
                            <th>سقف تخفیف</th>
                            <th>نوع کوپن</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($copans as $copan)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $copan->code }}</th>
                                <th>{{ $copan->amount }}</th>
                                <th>{{ $copan->amount_type == 0 ? 'درصدی' : 'عددی' }}</th>
                                <th>{{ $copan->discount_ceiling ?? '-' }} </th>
                                <th>{{ $copan->type == 0 ? 'عمومی' : 'خصوصی' }}</th>
                                <td>{{ jalaliDate($copan->start_date) }}</td>
                                <td>{{ jalaliDate($copan->end_date) }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $copan->id }}" onchange="changeStatus({{ $copan->id }})"
                                               data-url="{{ route('copanDiscount.status', $copan->id) }}"
                                               type="checkbox"
                                               @if ($copan->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('copanDiscount.edit', $copan->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('copanDiscount.destroy', $copan->id) }}"
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
                    <section class="border-top pt-3">{{ $copans->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')
    <script type="text/javascript">

        function changeStatus(id) {
            var element = $("#" + id)
            var url = element.attr('data-url')
            var elementValue = !element.prop('checked');

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    if (response.status) {
                        if (response.checked) {
                            element.prop('checked', true);
                            successToast('کوپن تخفیف با موفقیت فعال شد')
                        } else {
                            element.prop('checked', false);
                            successToast('کوپن تخفیف با موفقیت غیر فعال شد')
                        }
                    } else {
                        element.prop('checked', elementValue);
                        errorToast('هنگام ویرایش مشکلی بوجود امده است')
                    }
                },
                error: function () {
                    element.prop('checked', elementValue);
                    errorToast('ارتباط برقرار نشد')
                }
            });

            function successToast(message) {

                var successToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(successToastTag);
                $('.toast').toast('show').delay(5500).queue(function () {
                    $(this).remove();
                })
            }

            function errorToast(message) {

                var errorToastTag = '<section class="toast" data-delay="5000">\n' +
                    '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                    '<strong class="ml-auto">' + message + '</strong>\n' +
                    '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                    '<span aria-hidden="true">&times;</span>\n' +
                    '</button>\n' +
                    '</section>\n' +
                    '</section>';

                $('.toast-wrapper').append(errorToastTag);
                $('.toast').toast('show').delay(5500).queue(function () {
                    $(this).remove();
                })
            }
        }
    </script>
    @include('Panel::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
