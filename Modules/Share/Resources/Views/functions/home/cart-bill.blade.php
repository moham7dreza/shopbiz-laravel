<script type="text/javascript">
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
    }
</script>
