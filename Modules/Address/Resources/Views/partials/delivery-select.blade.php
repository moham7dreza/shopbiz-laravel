<section class="content-wrapper bg-white p-3 rounded-2 mb-4">
    <!-- start content header -->
    <section class="content-header mb-3">
        <section class="d-flex justify-content-between align-items-center">
            <h2 class="content-header-title content-header-title-small">
                انتخاب نحوه ارسال
            </h2>
            <section class="content-header-link">
                <!--<a href="#">مشاهده همه</a>-->
            </section>
        </section>
    </section>
    <section class="delivery-select ">

        <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                 role="alert">
            <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
            <section>
                نحوه ارسال کالا را انتخاب کنید. هنگام انتخاب لطفا مدت زمان ارسال را در نظر
                بگیرید.
            </section>
        </section>

        @foreach ($deliveryMethods as $deliveryMethod)
            <input type="radio" form="myForm" name="delivery_id"
                   value="{{ $deliveryMethod->id }}" id="d-{{ $deliveryMethod->id }}"/>
            <label for="d-{{ $deliveryMethod->id }}"
                   class="col-12 col-md-4 delivery-wrapper mb-2 pt-2">
                <section class="mb-2">
                    <i class="fa fa-shipping-fast mx-1"></i>
                    {{ $deliveryMethod->name }}
                </section>
                <section class="mb-2">
                    <i class="fa fa-calendar-alt mx-1"></i>
                    {{ $deliveryMethod->explainDeliveryTime() }}
                </section>
            </label>
        @endforeach
    </section>
</section>
