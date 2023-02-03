<script>
    var products = {!! $repo->productsWithActiveAmazingSales() !!};
    products.map(function (product) {
        var id = product.id;
        var rate = product.rating;
        var rate_very_good = `#rate_very_good_${id}`;
        var rate_good = `#rate_good_${id}`;
        var rate_normal = `#rate_normal_${id}`;
        var rate_low = `#rate_low_${id}`;
        var rate_very_low = `#rate_very_low_${id}`;
        if (rate < 1) {
            $(rate_very_low).addClass('text-greenyellow');
            $(rate_low).addClass('text-gray');
            $(rate_normal).addClass('text-gray');
            $(rate_good).addClass('text-gray');
            $(rate_very_good).addClass('text-gray');
        }
    });
</script>
