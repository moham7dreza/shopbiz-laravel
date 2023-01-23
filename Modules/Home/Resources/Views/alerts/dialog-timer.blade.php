@if(session('swal-timer'))
    <script>
        $(document).ready(function () {
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: '{{ session('swal-timer') }}',
                showConfirmButton: false,
                timer: 2500
            })
        });
    </script>
@endif
