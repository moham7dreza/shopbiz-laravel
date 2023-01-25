@include('Panel::functions.toasts')
@include('Product::home.functions.product-bill')
@include('Product::home.functions.to-fa-number')
@include('Product::home.functions.add-to-favorite')
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
