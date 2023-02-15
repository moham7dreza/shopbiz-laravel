<section class="address-add-wrapper">
    <button class="address-add-button" type="button" data-bs-toggle="modal"
            data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس
        جدید
    </button>
    <!-- start add address Modal -->
    <section class="modal fade" id="add-address" tabindex="-1"
             aria-labelledby="add-address-label" aria-hidden="true">
        <section class="modal-dialog">
            <section class="modal-content">
                <section class="modal-header">
                    <h5 class="modal-title" id="add-address-label"><i
                            class="fa fa-plus"></i> ایجاد آدرس جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </section>
                <section class="modal-body">
                    <form class="row" method="post" id="add-address-form"
                          action="{{ route('customer.sales-process.add-address') }}">
                        @csrf
                        @php $selected_province = null; @endphp
                        <section class="col-6 mb-2">
                            <label for="province"
                                   class="form-label mb-1">استان</label>
                            <select name="province_id"
                                    class="form-select form-select-sm"
                                    id="province">
                                <option selected>استان را انتخاب کنید</option>
                                @foreach ($provinces as $province)
                                    <option value="{{ $province->id }}"
                                            data-url="{{ route('customer.sales-process.get-cities', $province->id) }}"
                                        {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                    @php
                                        if (old('province_id') == $province->id) {
                                                $selected_province = $province;
                                            }
                                    @endphp
                                @endforeach

                            </select>
                        </section>

                        <section class="col-6 mb-2">
                            <label for="city" class="form-label mb-1">شهر</label>
                            <select name="city_id"
                                    class="form-select form-select-sm"
                                    id="city">
                                @if(!is_null($selected_province))
                                    @foreach($selected_province->cities as $city)
                                        <option
                                            {{ $city->id == old('city_id') ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                @else
                                    <option selected>شهر را انتخاب کنید</option>
                                @endif
                            </select>
                        </section>

                        @php $message = $message ?? null @endphp
                        <x-panel-text-area col="12" name="address" label="نشانی" rows="4" placeholder="نشانی" class="mb-2"
                                           :message="$message"/>
                        <x-panel-input col="6" name="postal_code" label="کد پستی" placeholder="کد پستی"
                                       :message="$message"/>
                        <x-panel-input col="3" name="no" label="پلاک" placeholder="پلاک"
                                       :message="$message"/>
                        <x-panel-input col="3" name="unit" label="واحد" placeholder="واحد"
                                       :message="$message"/>

                        <section class="border-bottom mt-2 mb-3"></section>

                        <section class="col-12 mb-2">
                            <section class="form-check">
                                <input class="form-check-input" name="receiver"
                                       type="checkbox" id="receiver" {{ old('receiver') == 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="receiver">
                                    گیرنده سفارش خودم نیستم (اطلاعات زیر تکمیل شود)
                                </label>
                            </section>
                        </section>
                        <x-panel-input col="6" name="recipient_first_name" label="نام گیرنده" placeholder="نام گیرنده"
                                       :message="$message"/>
                        <x-panel-input col="6" name="recipient_last_name" label="نام خانوادگی گیرنده"
                                       placeholder="نام خانوادگی گیرنده"
                                       :message="$message"/>
                        <x-panel-input col="12" name="mobile" label="شماره موبایل" placeholder="شماره موبایل"
                                       :message="$message"/>
                    </form>
                </section>
                <section class="modal-footer py-1">
                    <button type="submit" class="btn btn-sm btn-primary"
                            onclick="document.getElementById('add-address-form').submit();">ثبت
                        آدرس
                    </button>
                    <button type="button" class="btn btn-sm btn-danger"
                            data-bs-dismiss="modal">بستن
                    </button>
                </section>

            </section>
        </section>
    </section>
    <!-- end add address Modal -->
</section>
