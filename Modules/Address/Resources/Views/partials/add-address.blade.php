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
                    <form class="row" method="post"
                          action="{{ route('customer.sales-process.add-address') }}">
                        @csrf
                        @php
                            $selected_province = null;
                        @endphp
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
                                        {{ $province->name }}</option>
                                    @php
                                        if ( old('province_id') == $province->id)
                                            {
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
                        <section class="col-12 mb-2">
                            <label for="address"
                                   class="form-label mb-1">نشانی</label>
                            <textarea name="address"
                                      class="form-control form-control-sm"
                                      id="address" placeholder="نشانی">{{ old('address') }}</textarea>
                        </section>

                        <section class="col-6 mb-2">
                            <label for="postal_code" class="form-label mb-1">کد
                                پستی</label>
                            <input type="text" name="postal_code"
                                   class="form-control form-control-sm"
                                   id="postal_code"
                                   placeholder="کد پستی" value="{{ old('postal_code') }}">
                        </section>

                        <section class="col-3 mb-2">
                            <label for="no" class="form-label mb-1">پلاک</label>
                            <input type="text" name="no"
                                   class="form-control form-control-sm" id="no"
                                   placeholder="پلاک" value="{{ old('no') }}">
                        </section>

                        <section class="col-3 mb-2">
                            <label for="unit" class="form-label mb-1">واحد</label>
                            <input type="text" name="unit"
                                   class="form-control form-control-sm" id="unit"
                                   placeholder="واحد" value="{{ old('unit') }}">
                        </section>

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

                        <section class="col-6 mb-2">
                            <label for="first_name" class="form-label mb-1">نام
                                گیرنده</label>
                            <input type="text" name="recipient_first_name"
                                   class="form-control form-control-sm"
                                   id="first_name"
                                   placeholder="نام گیرنده" value="{{ old('recipient_first_name') }}">
                        </section>

                        <section class="col-6 mb-2">
                            <label for="last_name" class="form-label mb-1">نام
                                خانوادگی گیرنده</label>
                            <input type="text" name="recipient_last_name"
                                   class="form-control form-control-sm"
                                   id="last_name"
                                   placeholder="نام خانوادگی گیرنده" value="{{ old('recipient_last_name') }}">
                        </section>

                        <section class="col-6 mb-2">
                            <label for="mobile" class="form-label mb-1">شماره
                                موبایل</label>
                            <input type="text" name="mobile"
                                   class="form-control form-control-sm" id="mobile"
                                   placeholder="شماره موبایل" value="{{ old('mobile') }}">
                        </section>


                </section>
                <section class="modal-footer py-1">
                    <button type="submit" class="btn btn-sm btn-primary">ثبت
                        آدرس
                    </button>
                    <button type="button" class="btn btn-sm btn-danger"
                            data-bs-dismiss="modal">بستن
                    </button>
                </section>
                </form>

            </section>
        </section>
    </section>
    <!-- end add address Modal -->
</section>
