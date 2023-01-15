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
        })
    })

    function bill() {
        if ($('input[name="color"]:checked').length != 0) {
            var selected_color = $('input[name="color"]:checked');
            $("#selected_color_name").html(selected_color.attr('data-color-name'));
        }

        //price computing
        var selected_color_price = 0;
        var selected_guarantee_price = 0;
        var number = 1;
        var product_discount_price = 0;
        var product_original_price = parseFloat($('#product_price').attr('data-product-original-price'));

        if ($('input[name="color"]:checked').length != 0) {
            selected_color_price = parseFloat(selected_color.attr('data-color-price'));
        }

        if ($('#guarantee option:selected').length != 0) {
            selected_guarantee_price = parseFloat($('#guarantee option:selected').attr('data-guarantee-price'));
        }

        if ($('#number').val() > 0) {
            number = parseFloat($('#number').val());
        }

        if ($('#product-discount-price').length != 0) {
            product_discount_price = parseFloat($('#product-discount-price').attr('data-product-discount-price'));
        }

        //final price
        var product_price = product_original_price + selected_color_price + selected_guarantee_price;
        var final_price = number * (product_price - product_discount_price);
        $('#product-price').html(toFarsiNumber(product_price));
        $('#final-price').html(toFarsiNumber(final_price));
    }

    function toFarsiNumber(number) {
        const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        // add comma
        number = new Intl.NumberFormat().format(number);
        //convert to persian
        return number.toString().replace(/\d/g, x => farsiDigits[x]);
    }

</script>


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
