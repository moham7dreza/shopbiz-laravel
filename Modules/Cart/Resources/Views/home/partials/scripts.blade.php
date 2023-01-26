@include('Share::functions.cart-bill')
@include('Share::functions.to-fa-number')
@include('Share::ajax-functions.product-add-to-favorite')

<script>
    $(document).ready(function () {
        bill();

        $('.cart-number').click(function () {
            bill();
        });
    });

</script>
