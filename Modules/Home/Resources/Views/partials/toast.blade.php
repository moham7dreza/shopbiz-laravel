<section class="position-fixed p-4 flex-row-reverse"
         style="z-index: 909999999; right: 0; top: 3rem; width: 26rem; max-width: 80%;">
    <div class="toast" data-delay="7000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">فروشگاه</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <strong class="ml-auto">
                برای افزودن کالا به لیست علاقه مندی ها باید ابتدا وارد حساب کاربری خود شوید
                <br>
                <a href="{{ route('auth.login-register-form') }}" class="text-dark">
                    ثبت نام / ورود
                </a>
            </strong>
        </div>
    </div>
</section>
