@include('Share::functions.home.cart-bill')
@include('Share::functions.home.to-fa-number')
@include('Share::ajax-functions.home.product-add-to-favorite')
@include('Share::toast-functions.swal')
@include('Share::toast-functions.login-toast')
@include('Share::alerts.sweetalert.cart-item-delete-confirm')
@include('Share::ajax-functions.home.post-add-to-favorite')
@include('Share::ajax-functions.home.post-like')
<script>
    $(document).ready(function () {
        bill();

        $('.cart-number').click(function () {
            bill();
        });
    });

</script>
