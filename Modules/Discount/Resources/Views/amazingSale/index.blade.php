@extends('Panel::layouts.master')

@section('head-tag')
    <title>فروش شگفت انگیز</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">فروش شگفت انگیز</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فروش شگفت انگیز
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('amazingSale.create') }}" class="btn btn-info btn-sm">افزودن کالا به لیست
                        شگفت انگیز</a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('amazingSale.index') }}" class="d-flex">
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
                            <th>نام کالا</th>
                            <th>درصد تخفیف</th>
                            <th>تاریخ شروع</th>
                            <th>تاریخ پایان</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($amazingSales as $amazingSale)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <th>{{ $amazingSale->getProductName() }}</th>
                                <th>{{ $amazingSale->getFaPercentage() }}</th>
                                <td>{{ $amazingSale->getFaStartDate() }}</td>
                                <td>{{ $amazingSale->getFaEndDate() }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $amazingSale->id }}" onchange="changeStatus({{ $amazingSale->id }}, 'تخفیف شگفت انگیز')"
                                               data-url="{{ route('amazingSale.status', $amazingSale->id) }}"
                                               type="checkbox"
                                               @if ($amazingSale->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-16-rem text-left">
                                    <a href="{{ route('amazingSale.edit', $amazingSale->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('amazingSale.destroy', $amazingSale->id) }}"
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
                    <section class="border-top pt-3">{{ $amazingSales->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')
    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
