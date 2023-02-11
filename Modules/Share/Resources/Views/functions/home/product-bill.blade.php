<script type="text/javascript">
    function bill() {
        if ($('input[name="color"]:checked').length !== 0) {
            var selected_color = $('input[name="color"]:checked');
            $("#selected_color_name").html(selected_color.attr('data-color-name'));
        }

        //price computing
        var selected_color_price = 0;
        var selected_guarantee_price = 0;
        var number = 1;
        var product_discount_price = 0;
        var product_original_price = parseFloat($('#product_price').attr('data-product-original-price'));

        if ($('input[name="color"]:checked').length !== 0) {
            selected_color_price = parseFloat(selected_color.attr('data-color-price'));
        }

        if ($('#guarantee option:selected').length !== 0) {
            selected_guarantee_price = parseFloat($('#guarantee option:selected').attr('data-guarantee-price'));
        }

        if ($('#number').val() > 0) {
            number = parseFloat($('#number').val());
        }

        if ($('#product-discount-price').length !== 0) {
            product_discount_price = parseFloat($('#product-discount-price').attr('data-product-discount-price'));
        }

        //final price
        var product_price = product_original_price + selected_color_price + selected_guarantee_price;
        var final_price = number * (product_price - product_discount_price);
        $('#product_price').html(toFarsiNumber(product_price));
        $('#final-price').html(toFarsiNumber(final_price));
    }
</script>
