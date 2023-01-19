@extends('Panel::layouts.master')

@section('head-tag')
    <title>ویرایش نقش</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#">نقش ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش نقش</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش نقش
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('role.update', $role->id) }}" method="post">
                        @method('put')
                        @csrf
                        <section class="row">

                            <section class="col-12 col-md-10">
                                <div class="form-group">
                                    <label for="">عنوان نقش</label>
                                    <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('name')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-10">
                                <div class="form-group">
                                    <label for="">توضیح نقش</label>
                                    <input type="text" name="description"
                                           value="{{ old('description', $role->description) }}"
                                           class="form-control form-control-sm">
                                </div>
                                @error('description')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-10">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" class="form-control form-control-sm" id="status">
                                        <option value="0" @if (old('status', $role->status) == 0) selected @endif>
                                            غیرفعال
                                        </option>
                                        <option value="1" @if (old('status', $role->status) == 1) selected @endif>
                                            فعال
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-12">
                                <button class="btn btn-primary btn-sm mt-md-4">ثبت</button>
                            </section>

                            <section class="col-12">
                                <section class="row border-top mt-3 py-3">

                                </section>
                            </section>

                        </section>
                    </form>
                </section>

            </section>
        </section>
    </section>

@endsection
