@extends('Panel::layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> نقش ها</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نقش ها
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('role.create') }}" class="btn btn-info btn-sm">ایجاد نقش جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>نام نقش</th>
                            <th>دسترسی ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $key => $role)

                            <tr>
                                <th>{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @if(empty($role->permissions()->get()->toArray()))
                                        <span class="text-danger">برای این نقش هیچ سطح دسترسی تعریف نشده است</span>
                                    @else
                                        @foreach($role->permissions as $permission)
                                            {{ $permission->name }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <label>
                                        <input id="{{ $role->id }}" onchange="changeStatus({{ $role->id }}, 'نقش')"
                                               data-url="{{ route('role.status', $role->id) }}" type="checkbox"
                                               @if ($role->status === 1)
                                                   checked
                                            @endif>
                                    </label>
                                </td>
                                <td class="width-22-rem text-left">
                                    <a href="{{ route('role.permission-form', $role->id) }}"
                                       class="btn btn-success btn-sm"><i class="fa fa-user-graduate"></i></a>
                                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary btn-sm"><i
                                            class="fa fa-edit"></i></a>
                                    <form class="d-inline" action="{{ route('role.destroy', $role->id) }}"
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
                    <section class="border-top pt-3">{{ $roles->links() }}</section>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    @include('Share::ajax-functions.status')

    @include('Share::alerts.sweetalert.delete-confirm', ['className' => 'delete'])

@endsection
