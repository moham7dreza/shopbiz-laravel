<script type="text/javascript">
    function marketable(id, name) {
        var element = $("#" + id + '-marketable')
        var url = element.attr('data-url')
        var elementValue = !element.prop('checked');

        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (response.marketable) {
                    if (response.checked) {
                        element.prop('checked', true);
                        successToast('امکان فروش ' + name + ' با موفقیت فعال شد ')
                    } else {
                        element.prop('checked', false);
                        warningToast('امکان فروش ' + name + ' با موفقیت غیر فعال شد ')
                    }
                } else {
                    element.prop('checked', elementValue);
                    errorToast('هنگام ویرایش مشکلی بوجود امده است')
                }
            },
            error: function () {
                element.prop('checked', elementValue);
                errorToast('ارتباط برقرار نشد')
            }
        });
    }

</script>
