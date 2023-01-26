@if(session('swal-animate'))
    <script>
        $(document).ready(function () {
            Swal.fire({
                title: '{{ session('swal-animate') }}',
                icon: 'info',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                },
                showConfirmButton: false,
                timer: 2500
            })
        });
    </script>
@endif
