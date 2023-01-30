<script type="text/javascript">
    $('.post-like-btn button').click(function () {
        var url = $(this).attr('data-url');
        var element = $(this);
        $.ajax({
            url: url,
            success: function (result) {
                if (result.status === 1) {
                    $(element).children().first().addClass('text-danger');
                    $(element).attr('data-original-title', 'لایک نکردن');
                    $(element).attr('data-bs-original-title', 'لایک نکردن');
                    infoToast('آیتم توسط شما لایک شد')
                } else if (result.status === 2) {
                    $(element).children().first().removeClass('text-danger')
                    $(element).attr('data-original-title', 'لایک کردن');
                    $(element).attr('data-bs-original-title', 'لایک کردن');
                    warningToast('آیتم توسط شما از لایک خارج شد')
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
