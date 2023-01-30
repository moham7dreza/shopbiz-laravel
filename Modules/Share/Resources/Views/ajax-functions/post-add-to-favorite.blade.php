<script type="text/javascript">
    $('.post-favorite-btn button').click(function () {
        var url = $(this).attr('data-url');
        var element = $(this);
        $.ajax({
            url: url,
            success: function (result) {
                if (result.status === 1) {
                    $(element).children().first().addClass('text-danger');
                    $(element).attr('data-original-title', 'حذف از علاقه مندی ها');
                    $(element).attr('data-bs-original-title', 'حذف از علاقه مندی ها');
                    infoToast('آیتم به علاقه مندی شما اضافه شد.')
                } else if (result.status === 2) {
                    $(element).children().first().removeClass('text-danger')
                    $(element).attr('data-original-title', 'افزودن از علاقه مندی ها');
                    $(element).attr('data-bs-original-title', 'افزودن از علاقه مندی ها');
                    warningToast('آیتم از علاقه مندی شما حذف شد.')
                } else if (result.status === 3) {
                    loginToast()
                }
            }
        })
    })
</script>
@include('Share::toast-functions.info-toast')
@include('Share::toast-functions.warning-toast')
@include('Share::toast-functions.login-toast')
