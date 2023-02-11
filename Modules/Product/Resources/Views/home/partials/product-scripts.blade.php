@include('Share::functions.home.product-bill')
@include('Share::functions.home.to-fa-number')
@include('Share::ajax-functions.home.product-add-to-favorite')
@include('Share::ajax-functions.home.product-like')
@include('Share::ajax-functions.home.product-review')
@include('Share::toast-functions.swal')
@include('Share::toast-functions.login-toast')
<script>
    $(document).ready(function () {
        bill();
        //input color
        $('input[name="color"]').change(function () {
            bill();
        })
        //guarantee
        $('select[name="guarantee"]').change(function () {
            bill();
        })
        //number
        $('.cart-number').click(function () {
            bill();
        });
    });
</script>

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
