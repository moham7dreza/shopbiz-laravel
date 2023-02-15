<section class="content-wrapper bg-white p-3 rounded-2 mb-4">
    <!-- start content header -->
    <section class="content-header mb-3">
        <section class="d-flex justify-content-between align-items-center">
            <h2 class="content-header-title content-header-title-small">
                انتخاب آدرس و مشخصات گیرنده
            </h2>
            <section class="content-header-link">
                <!--<a href="#">مشاهده همه</a>-->
            </section>
        </section>
    </section>

    <section class="address-alert alert alert-primary d-flex align-items-center p-2"
             role="alert">
        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
        <section>
            پس از ایجاد آدرس، آدرس را انتخاب کنید.
        </section>
    </section>


    <section class="address-select">

        @include('Address::partials.user-addresses')

        @include('Address::partials.add-address')

    </section>
</section>
