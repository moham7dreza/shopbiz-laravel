@foreach ($addresses as $address)
    <input type="radio" form="myForm" name="address_id" value="{{ $address->id }}"
           id="a-{{ $address->id }}"/>
    <!--checked="checked"-->
    <label for="a-{{ $address->id }}" class="address-wrapper mb-2 p-2">
        <section class="mb-2">
            <i class="fa fa-map-marker-alt mx-1"></i>
            آدرس : {{ $address->province->name . '،  ' . $address->city->name . '،  ' . $address->address ?? '-' }}
        </section>
        <section class="mb-2">
            <i class="fa fa-user-tag mx-1"></i>
            گیرنده : {{ $address->recipient_first_name ?? '-' }}
            {{ $address->recipient_last_name ?? '-' }}
        </section>
        <section class="mb-2">
            <i class="fa fa-mobile-alt mx-1"></i>
            موبایل گیرنده : {{ $address->mobile ?? '-' }}
        </section>
        <a class="" data-bs-toggle="modal"
           data-bs-target="#edit-address-{{ $address->id }}"><i
                class="fa fa-edit"></i> ویرایش آدرس</a>
        <span class="address-selected">کالاها به این آدرس ارسال می شوند</span>
    </label>


    <!-- start edit address Modal -->
    <section class="modal fade high-z-index" id="edit-address-{{ $address->id }}" tabindex="-1"
             aria-labelledby="add-address-label" aria-hidden="true">
        <section class="modal-dialog">
            <section class="modal-content">
                <section class="modal-header">
                    <h5 class="modal-title" id="add-address-label"><i
                            class="fa fa-plus"></i> ویرایش آدرس </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </section>
                <section class="modal-body">
                    <form class="row" method="post" id="edit-address-form"
                          action="{{ route('customer.sales-process.update-address', $address->id) }}">
                        @csrf
                        @method('PUT')
                        <section class="col-6 mb-2">
                            <label for="province-{{ $address->id }}"
                                   class="form-label mb-1">استان</label>
                            <select name="province_id"
                                    class="form-select form-select-sm"
                                    id="province-{{ $address->id }}">
                                @foreach ($provinces as $province)
                                    <option
                                        {{ old('province_id', $address->province_id) == $province->id ? 'selected' : '' }} value="{{ $province->id }}"
                                        data-url="{{ route('customer.sales-process.get-cities', $province->id) }}">
                                        {{ $province->name }}</option>
                                @endforeach

                            </select>
                        </section>

                        <section class="col-6 mb-2">
                            <label for="city-{{ $address->id }}" class="form-label mb-1">شهر</label>
                            <select name="city_id"
                                    class="form-select form-select-sm"
                                    id="city-{{ $address->id }}">
                                @foreach($address->province->cities as $city)
                                    <option
                                        {{ old('city_id'. $address->city_id) == $city->id ? 'selected' : '' }} value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </section>
                        @php $message = $message ?? null @endphp
                        <x-panel-text-area col="12" name="address" label="نشانی" rows="4" placeholder="نشانی"
                                           class="mb-2"
                                           :message="$message" method="edit" :model="$address"/>
                        <x-panel-input col="6" name="postal_code" label="کد پستی" placeholder="کد پستی"
                                       :message="$message" method="edit" :model="$address"/>
                        <x-panel-input col="3" name="no" label="پلاک" placeholder="پلاک"
                                       :message="$message" method="edit" :model="$address"/>
                        <x-panel-input col="3" name="unit" label="واحد" placeholder="واحد"
                                       :message="$message" method="edit" :model="$address"/>

                        <section class="border-bottom mt-2 mb-3"></section>

                        <section class="col-12 mb-2">
                            <section class="form-check">
                                <input
                                    {{ old('recipient_first_name', $address->recipient_first_name) ? 'checked' : '' }} class="form-check-input"
                                    name="receiver"
                                    type="checkbox" id="receiver">
                                <label class="form-check-label" for="receiver">
                                    گیرنده سفارش خودم نیستم (اطلاعات زیر تکمیل شود)
                                </label>
                            </section>
                        </section>

                        <x-panel-input col="6" name="recipient_first_name" label="نام گیرنده" placeholder="نام گیرنده"
                                       :message="$message" method="edit" :model="$address"/>
                        <x-panel-input col="6" name="recipient_last_name" label="نام خانوادگی گیرنده"
                                       placeholder="نام خانوادگی گیرنده"
                                       :message="$message" method="edit" :model="$address"/>
                        <x-panel-input col="12" name="mobile" label="شماره موبایل" placeholder="شماره موبایل"
                                       :message="$message" method="edit" :model="$address"/>
                    </form>
                </section>
                <section class="modal-footer py-1">
                    <button type="submit" class="btn btn-sm btn-primary"
                            onclick="document.getElementById('edit-address-form').submit();">ثبت
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
@endforeach
