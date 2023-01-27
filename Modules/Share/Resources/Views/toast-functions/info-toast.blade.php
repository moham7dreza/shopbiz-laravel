<script type="text/javascript">
    function infoToast(message) {

        var infoToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-info text-dark">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(infoToastTag);
        $('.toast').toast('show').delay(5500).queue(function () {
            $(this).remove();
        })
        $('.toast-wrapper').addClass('low-z-index');
    }
</script>
