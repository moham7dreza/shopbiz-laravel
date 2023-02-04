@include('Share::ajax-functions.product-add-to-favorite')
@include('Share::toast-functions.swal')
@include('Share::toast-functions.login-toast')
<script>
    //start product introduction, features and comment
    $(document).ready(function () {
        var s = $("#introduction-features-comments");
        var pos = s.position();
        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();

            if (windowpos >= pos.top) {
                s.addClass("stick");
            } else {
                s.removeClass("stick");
            }
        });
    });
    //end product introduction, features and comment
</script>
