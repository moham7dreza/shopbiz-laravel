@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسترسی ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسترسی ها</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسترسی ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('permission.create') }}" class="btn btn-info btn-sm">ایجاد دسترسی جدید</a>
                    <div class="max-width-16-rem">
                        <form action="{{ route('permission.index') }}" class="d-flex">
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
                            <th>نام دسترسی</th>
                            <th>نام نقش ها</th>
                            <th>توضیحات دسترسی</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($permissions as $key => $permission)

                            <tr>
                                <th>{{ $permission->id }}</th>
                                <td>{{ $permission->name }}</td>
                                <td>
                                    @if(empty($permission->roles()->get()->toArray()))
                                        <span class="text-danger">برای این دسترسی هیچ نقشی تعریف نشده است</span>
                                    @else
                                        @foreach($permission->roles as $role)
                                            {{ $role->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $permission->getLimitedDescription() }}</td>
                                <td>
                                    <label>
                                        <input id="{{ $permission->id }}" onchange="changeStatus({{ $permission->id }}, 'دسترسی')"
                                               data-url="{{ route('permission.status', $permission->id) }}"
                                               type="checkbox"
                                               @if ($permission->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-12-rem text-left">
                                    <a href="{{ route('permission.edit', $permission->id) }}"
                                       class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                    <form class="d-inline"
                                          action="{{ route('permission.destroy', $permission->id) }}"
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
                    <section class="border-top pt-3">{{ $permissions->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection


@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
