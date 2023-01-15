<script>
    $(document).ready(function () {
        $('#province').change(function () {
            var element = $('#province option:selected');
            var url = element.attr('data-url');

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    if (response.status) {
                        let cities = response.cities;
                        $('#city').empty();
                        cities.map((city) => {
                            $('#city').append($('<option/>').val(city.id).text(city
                                .name))
                        })
                    } else {
                        errorToast('خطا پیش آمده است')
                    }
                },
                error: function () {
                    errorToast('خطا پیش آمده است')
                }
            })
        })


        // edit
        var addresses = {!! auth()->user()->addresses !!}
            // console.log(addresses);
        addresses.map(function (address) {
            var id = address.id;
            var target = `#province-${id}`;
            var selected = `${target} option:selected`
            $(target).change(function () {
                var element = $(selected);
                var url = element.attr('data-url');

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (response) {
                        if (response.status) {
                            let cities = response.cities;
                            $(`#city-${id}`).empty();
                            cities.map((city) => {
                                $(`#city-${id}`).append($('<option/>').val(city.id).text(city
                                    .name))
                            })
                        } else {
                            errorToast('خطا پیش آمده است')
                        }
                    },
                    error: function () {
                        errorToast('خطا پیش آمده است')
                    }
                })
            })
        })

    })
</script>
