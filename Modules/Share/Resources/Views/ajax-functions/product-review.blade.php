<script type="text/javascript">
    $('.reviews button').click(function () {
        var url = $(this).attr('data-url');
        var element = $(this);
        $.ajax({
            url: url,
            success: function (result) {
                const text = 'رای شما با موفقیت ثبت شد';
                if (result.status === 1) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_normal').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_good').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal(text);
                } else if (result.status === 2) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_good').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal(text);
                } else if (result.status === 3) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_good').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal(text);
                } else if (result.status === 4) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_good').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal(text);
                } else if (result.status === 5) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_good').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_very_good').addClass('text-greenyellow').removeClass('text-gray');
                    swal(text);
                }
                else {
                    loginToast()
                }
            }
        })
    })
</script>
