<script type="text/javascript">
    function changeActive(id, name) {
        var element = $("#" + id)
        var url = element.attr('data-url')
        var elementValue = !element.prop('checked');

        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (response.activation) {
                    if (response.checked) {
                        element.prop('checked', true);
                        swal('فعال سازی ' + name + ' با موفقیت انجام شد ', 'success')
                    } else {
                        element.prop('checked', false);
                        swal('غیر فعال سازی ' + name + ' با موفقیت انجام شد ', 'warning')
                    }
                } else {
                    element.prop('checked', elementValue);
                    swal('هنگام ویرایش مشکلی بوجود امده است', 'error')
                }
            },
            error: function () {
                element.prop('checked', elementValue);
                swal('ارتباط برقرار نشد', 'error')
            }
        });
    }

</script>
@include('Share::toast-functions.swal')
