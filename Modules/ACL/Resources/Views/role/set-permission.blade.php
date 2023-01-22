@extends('Panel::layouts.master')

@section('head-tag')
    <title>دسترسی های نقش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">نقش ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> دسترسی نقش</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسترسی نقش
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3  pb-2">
                    <a href="{{ route('role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('role.permission-update', $role->id) }}" method="post">
                        @csrf
                        @method('put')
                        <section class="row">

                            <section class="col-12">
                                <section class="row border-top mt-3 py-3">

                                    <section class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="">نام نقش</label>
                                            <section>{{ $role->name }}</section>
                                        </div>
                                    </section>

                                    <section class="col-12 col-md-5">
                                        <div class="form-group">
                                            <label for="">توضیح نقش</label>
                                            <section>{{ $role->description }}</section>
                                        </div>
                                    </section>
                                    <section class="col-12 border-bottom mb-3"></section>


                                    <section class="col-12">
                                        <div class="form-group">
                                            <label for="select_roles">سطح دسترسی ها</label>
                                            <select multiple class="form-control form-control-sm" id="select_roles"
                                                    name="permissions[]">

                                                @foreach ($permissions as $permission)
                                                    <option value="{{ $permission->id }}"
                                                            @foreach ($role->permissions as $role_permission)
                                                                @if($role_permission->id === $permission->id)
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


{{--                                    @php--}}
{{--                                        $rolePermissionsArray = $role->permissions->pluck('id')->toArray();--}}
{{--                                    @endphp--}}
{{--                                    @foreach ($permissions as $key => $permission)--}}

{{--                                        <section class="col-md-6">--}}
{{--                                            <div class="form-check">--}}
{{--                                                <input type="checkbox" class="form-check-input" name="permissions[]"--}}
{{--                                                       value="{{ $permission->id }}" id="{{ $permission->id }}"--}}
{{--                                                       @if(in_array($permission->id, $rolePermissionsArray)) checked @endif/>--}}
{{--                                                <label for="{{ $permission->id }}"--}}
{{--                                                       class="form-check-label mr-4 mt-1">{{ $permission->description }}</label>--}}
{{--                                            </div>--}}
{{--                                            <div class="mt-2">--}}
{{--                                                @error('permissions.' . $key)--}}
{{--                                                <span class="alert_required bg-danger text-white p-1 rounded"--}}
{{--                                                      role="alert">--}}
{{--                                            <strong>--}}
{{--                                                {{ $message }}--}}
{{--                                            </strong>--}}
{{--                                        </span>--}}
{{--                                                @enderror--}}
{{--                                            </div>--}}
{{--                                        </section>--}}

{{--                                    @endforeach--}}


                                    <section class="col-12 border-top">
                                        <button class="btn btn-primary btn-sm mt-md-4">ثبت</button>
                                    </section>

                                </section>
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
