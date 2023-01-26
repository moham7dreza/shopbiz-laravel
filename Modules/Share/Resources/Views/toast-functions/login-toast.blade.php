<script type="text/javascript">
    function loginToast() {

        var loginToastTag = '<div class="toast" data-delay="7000" role="alert" aria-live="assertive" aria-atomic="true">\n' +
            '<div class="toast-header">\n' +
            '<strong class="me-auto">فروشگاه</strong>\n' +
            '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n' +
            '</div>\n' +
            '<div class="toast-body">\n' +
            '<strong class="ml-auto">\n' +
            'برای افزودن کالا به لیست علاقه مندی ها باید ابتدا وارد حساب کاربری خود شوید\n' +
            '<br>\n' +
            '<a href="/login-register" class="text-dark">\n' +
            'ثبت نام / ورود\n' +
            '</a>\n' +
            '</strong>\n' +
            ' </div>\n' +
            '</section>\n';

        $('.login-toast-wrapper').append(loginToastTag);
        $('.toast').toast('show').delay(7000);
    }
</script>
