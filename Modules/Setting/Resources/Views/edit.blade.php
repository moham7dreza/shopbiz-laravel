@extends('Panel::layouts.master')

@section('head-tag')
    <title>تنظیمات</title>
@endsection

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-16"><a href="{{ route('panel.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-16"><a href="{{ route('setting.index') }}"> تنظیمات</a></li>
            <li class="breadcrumb-item font-size-16 active" aria-current="page"> ویرایش تنظیمات</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش تنظیمات
                    </h5>
                </section>

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('setting.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>

                <section>
                    <form action="{{ route('setting.update', $setting->id) }}" method="post"
                          enctype="multipart/form-data" id="form">
                        @csrf
                        @method('put')
                        <section class="row">
                            @php $message = $message ?? null @endphp
                            <x-panel-input col="10" name="title" label="عنوان سایت"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="description" label="توضیحات سایت"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="keywords" label="کلمات کلیدی سایت"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="author" label="مالک سایت"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="5" type="file" name="logo" label="لوگو"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="5" type="file" name="icon" label="آیکون"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="mobile" label="شماره تماس" :old="$setting->getMobile()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="office_telephone" label="شماره دفتر"
                                           :old="$setting->getOfficePhone()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="email" label="ایمیل" :old="$setting->getEmail()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="instagram" label="اینستاگرام" :old="$setting->getInstagram()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="telegram" label="تلگرام" :old="$setting->getTelegram()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="whatsapp" label="واتس اپ" :old="$setting->getWhatsApp()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="youtube" label="یوتیوب" :old="$setting->getYoutube()"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-text-area col="10" name="address" label="آدرس" rows="12"
                                               :old="$setting->getCentralOfficeAddress()"
                                               :message="$message" method="edit" :model="$setting"/>
                            <x-panel-input col="10" name="postal_code" label="کد پستی"
                                           :message="$message" method="edit" :model="$setting"/>
                            <x-panel-text-area col="10" name="bank_account" label="اطلاعات بانکی" rows="12"
                                               :old="$setting->getBankAccount()"
                                               :message="$message" method="edit" :model="$setting"/>
                            <x-panel-button col="12" title="ثبت"/>
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
