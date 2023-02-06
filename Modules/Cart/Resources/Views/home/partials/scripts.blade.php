@include('Share::functions.cart-bill')
@include('Share::functions.to-fa-number')
@include('Share::ajax-functions.product-add-to-favorite')
@include('Share::toast-functions.swal')
@include('Share::toast-functions.login-toast')
@include('Share::alerts.sweetalert.cart-item-delete-confirm')
<script>
    $(document).ready(function () {
        bill();

        $('.cart-number').click(function () {
            bill();
        });
    });

</script>
