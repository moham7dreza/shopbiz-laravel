<script>
    $(document).ready(function () {
        bill();

        $('.cart-number').click(function () {
            bill();
        })
    })


    function bill() {
        var total_product_price = 0;
        var total_discount = 0;
        var total_price = 0;

        $('.number').each(function () {
            var productPrice = parseFloat($(this).data('product-price'));
            var productDiscount = parseFloat($(this).data('product-discount'));
            var number = parseFloat($(this).val());

            total_product_price += productPrice * number;
            total_discount += productDiscount * number;
        })

        total_price = total_product_price - total_discount;

        $('#total_product_price').html(toFarsiNumber(total_product_price) + ' تومان');
        $('#total_discount').html(toFarsiNumber(total_discount) + ' تومان');
        $('#total_price').html(toFarsiNumber(total_price) + ' تومان');


        function toFarsiNumber(number) {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            // add comma
            number = new Intl.NumberFormat().format(number);
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }

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
