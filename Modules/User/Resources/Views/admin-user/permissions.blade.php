@extends('Panel::layouts.master')

@section('head-tag')
    <title>ایجاد سطح دسترسی ادمین</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-16"><a href="#">کاربران ادمین</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ایجاد سطح دسترسی ادمین</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد سطح دسترسی ادمین
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('adminUser.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('adminUser.permissions.store', $admin) }}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <section class="row">


                            <section class="col-12">
                                <div class="form-group">
                                    <label for="select_roles">سطح دسترسی ها</label>
                                    <select multiple class="form-control form-control-sm" id="select_roles"
                                            name="permissions[]">

                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}"
                                                    @foreach ($admin->permissions as $user_permission)
                                                        @if($user_permission->id === $permission->id)
                                                            selected
                                                @endif
                                                @endforeach>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                @error('permissions')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>


                            <section class="col-12">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>
                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection

@section('script')

    <script>
        var select_roles = $('#select_roles');
        select_roles.select2({
            placeholder: 'لطفا دسترسی ها را وارد نمایید',
            multiple: true,
            tags: true
        })
    </script>

@endsection
