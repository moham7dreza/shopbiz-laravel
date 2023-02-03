<script type="text/javascript">
    $('.reviews button').click(function () {
        var url = $(this).attr('data-url');
        var element = $(this);
        $.ajax({
            url: url,
            success: function (result) {
                if (result.status === 1) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_normal').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_good').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal();
                } else if (result.status === 2) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_good').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal();
                } else if (result.status === 3) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_good').removeClass('text-greenyellow').addClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal();
                } else if (result.status === 4) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_good').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_very_good').removeClass('text-greenyellow').addClass('text-gray');
                    swal();
                } else if (result.status === 5) {
                    $('#rate_very_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_low').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_normal').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_good').addClass('text-greenyellow').removeClass('text-gray');
                    $('#rate_very_good').addClass('text-greenyellow').removeClass('text-gray');
                    swal();
                }
                else {
                    loginToast()
                }
            }
        })
    })

    function swal()
    {
        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'رای شما با موفقیت ثبت شد',
            width: 500,
            padding: '3em',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            showConfirmButton: false,
            timer: 1500
        })
    }
</script>
@include('Share::toast-functions.info-toast')
@include('Share::toast-functions.warning-toast')
@include('Share::toast-functions.login-toast')
