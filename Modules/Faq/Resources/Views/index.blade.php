@extends('Panel::layouts.master')

@section('head-tag')
    <title>سوالات متداول</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> سوالات متداول</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        سوالات متداول
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('faq.create') }}" class="btn btn-info btn-sm">ایجاد سوال جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>پرسش</th>
                            <th>خلاصه پاسخ</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($faqs as $key => $faq)

                            <tr>
                                <th>{{ $key += 1 }}</th>
                                <td>{{ $faq->limitedQuestion() }}</td>
                                <td>{!! $faq->limitedAnswer() !!}</td>
                                <td>
                                    <label>
                                        <input id="{{ $faq->id }}" onchange="changeStatus({{ $faq->id }}, 'پرسش')"
                                               data-url="{{ route('faq.status', $faq->id) }}" type="checkbox"
                                               @if ($faq->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('faq.edit', $faq->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('faq.destroy', $faq->id) }}" method="post">
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
                    <section class="border-top pt-3">{{ $faqs->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')
    <script type="text/javascript">
        @include('Panel::functions.status')
        @include('Panel::functions.toasts')
    </script>
    @include('Panel::alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection
