<script>
    $('.product-add-to-favorite button').click(function () {
        var url = $(this).attr('data-url');
        var element = $(this);
        $.ajax({
            url: url,
            success: function (result) {
                if (result.status == 1) {
                    $(element).children().first().addClass('text-danger');
                    $(element).attr('data-original-title', 'حذف از علاقه مندی ها');
                    $(element).attr('data-bs-original-title', 'حذف از علاقه مندی ها');
                } else if (result.status == 2) {
                    $(element).children().first().removeClass('text-danger')
                    $(element).attr('data-original-title', 'افزودن از علاقه مندی ها');
                    $(element).attr('data-bs-original-title', 'افزودن از علاقه مندی ها');
                } else if (result.status == 3) {
                    $('.toast').toast('show');
                }
            }
        })
    })
</script>
