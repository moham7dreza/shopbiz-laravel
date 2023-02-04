@include('Share::functions.cart-bill')
@include('Share::functions.to-fa-number')
@include('Share::ajax-functions.product-add-to-favorite')
@include('Share::toast-functions.swal')
@include('Share::toast-functions.login-toast')
<script>
    $(document).ready(function () {
        bill();

        $('.cart-number').click(function () {
            bill();
        });
    });

</script>
