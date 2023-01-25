<script type="text/javascript">
    function toFarsiNumber(number) {
        const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        // add comma
        number = new Intl.NumberFormat().format(number);
        //convert to persian
        return number.toString().replace(/\d/g, x => farsiDigits[x]);
    }
</script>
