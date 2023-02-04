<script>
    function swal(title, icon = 'success', position = 'top-start', timer = 1500)
    {
        Swal.fire({
            position: position,
            icon: icon,
            title: title,
            width: 500,
            padding: '3em',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            showConfirmButton: false,
            timer: timer
        })
    }
</script>
