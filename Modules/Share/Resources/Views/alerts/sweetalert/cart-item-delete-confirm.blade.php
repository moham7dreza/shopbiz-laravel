<script>
    $(document).ready(function () {
        const cartItems = {!! auth()->user()->cartItems !!};
        cartItems.map(function (cartItem) {
            const id = cartItem.id;
            const target = `#delete-${id}`;
            const route = `#delete-route-${id}`;
            $(target).on('click', function (e) {
                e.preventDefault();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-2',
                        cancelButton: 'btn btn-danger mx-2'
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: 'آیا مطمئن هستید؟',
                    // text: "شما میتوانید درخواست خود را لغو نمایید",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'بله',
                    cancelButtonText: 'خیر',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value === true) {
                        $(route).click();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire({
                            title: 'لغو درخواست',
                            // text: "درخواست شما لغو شد",
                            icon: 'error',
                            confirmButtonText: 'باشه.'
                        })
                    }
                })
            })
        })
    })
</script>
