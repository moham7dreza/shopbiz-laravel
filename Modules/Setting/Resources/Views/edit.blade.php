@extends('Panel::layouts.master')

@section('head-tag')
    <title>تنظیمات</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="#"> تنظیمات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش تنظیمات</li>
        </ol>
    </nav>


    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش تنظیمات</>
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('setting.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('setting.update', $setting->id) }}" method="post"
                          enctype="multipart/form-data" id="form">
                        @csrf
                        {{ method_field('put') }}
                        <section class="row">

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="name">عنوان سایت</label>
                                    <input type="text" class="form-control form-control-sm" name="title" id="name"
                                           value="{{ old('title', $setting->title) }}">
                                </div>
                                @error('title')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="name">توضیحات سایت</label>
                                    <input type="text" class="form-control form-control-sm" name="description" id="name"
                                           value="{{ old('description', $setting->description) }}">
                                </div>
                                @error('description')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="name">کلمات کلیدی سایت</label>
                                    <input type="text" class="form-control form-control-sm" name="keywords" id="name"
                                           value="{{ old('keywords', $setting->keywords) }}">
                                </div>
                                @error('keywords')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="author">مالک</label>
                                    <input type="text" class="form-control form-control-sm" name="author" id="author"
                                           value="{{ old('author', $setting->author ?? 'تعریف نشده') }}">
                                </div>
                                @error('author')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="image">لوگو</label>
                                    <input type="file" class="form-control form-control-sm" name="logo" id="image">
                                </div>
                                @error('logo')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>


                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="icon">آیکون</label>
                                    <input type="file" class="form-control form-control-sm" name="icon" id="icon">
                                </div>
                                @error('icon')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">شماره تماس</label>
                                    <input type="text" class="form-control form-control-sm" name="mobile" id="mobile"
                                           value="{{ old('mobile', $setting->getMobile()) }}">
                                </div>
                                @error('mobile')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="office_telephone">شماره دفتر</label>
                                    <input type="text" class="form-control form-control-sm" name="office_telephone"
                                           id="office_telephone"
                                           value="{{ old('office_telephone', $setting->getOfficePhone()) }}">
                                </div>
                                @error('office_telephone')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="email">ایمیل</label>
                                    <input type="text" class="form-control form-control-sm" name="email" id="email"
                                           value="{{ old('email', $setting->getEmail()) }}">
                                </div>
                                @error('email')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="instagram">اینستاگرام</label>
                                    <input type="text" class="form-control form-control-sm" name="instagram"
                                           id="instagram"
                                           value="{{ old('instagram', $setting->getInstagram()) }}">
                                </div>
                                @error('instagram')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="telegram">تلگرام</label>
                                    <input type="text" class="form-control form-control-sm" name="telegram"
                                           id="telegram"
                                           value="{{ old('telegram', $setting->getTelegram()) }}">
                                </div>
                                @error('telegram')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="whatsapp">واتس اپ</label>
                                    <input type="text" class="form-control form-control-sm" name="whatsapp"
                                           id="whatsapp"
                                           value="{{ old('whatsapp', $setting->getWhatsApp()) }}">
                                </div>
                                @error('whatsapp')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="youtube">یوتیوب</label>
                                    <input type="text" class="form-control form-control-sm" name="youtube" id="youtube"
                                           value="{{ old('youtube', $setting->getYoutube()) }}">
                                </div>
                                @error('youtube')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="address">آدرس</label>
                                    <textarea name="address" id="address" class="form-control form-control-sm"
                                              rows="6">{{ old('address', $setting->getCentralOfficeAddress()) }}</textarea>
                                </div>
                                @error('address')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-md-6">
                                <div class="form-group">
                                    <label for="postal_code">کد پستی</label>
                                    <input type="text" class="form-control form-control-sm" name="postal_code"
                                           id="postal_code"
                                           value="{{ old('postal_code', $setting->postal_code) }}">
                                </div>
                                @error('postal_code')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>

                            <section class="col-12">
                                <div class="form-group">
                                    <label for="bank_account">اطلاعات بانکی</label>
                                    <textarea name="bank_account" id="bank_account" class="form-control form-control-sm"
                                              rows="6">{{ old('bank_account', $setting->getBankAccount()) }}</textarea>
                                </div>
                                @error('bank_account')
                                <span class="alert alert-danger -p-1 mb-3 d-block font-size-80" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                                @enderror
                            </section>

                            <section class="col-12 my-3">
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

    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>

    <script>
        CKEDITOR.replace('bank_account');
        CKEDITOR.replace('address');
    </script>
@endsection
