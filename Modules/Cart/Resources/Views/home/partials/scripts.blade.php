@include('Cart::home.functions.cart-bill')
@include('Product::home.functions.to-fa-number')
@include('Product::home.functions.add-to-favorite')
@include('Panel::functions.toasts')

<script>
    $(document).ready(function () {
        bill();

        $('.cart-number').click(function () {
            bill();
        });
    });

</script>
