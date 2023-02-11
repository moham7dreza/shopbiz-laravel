<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>

{{--<script src="{{ asset('admin-assets/js/chart/highcharts.js') }}"></script>--}}
{{--<script src="{{ asset('admin-assets/js/chart/series-label.js') }}"></script>--}}
{{--<script src="{{ asset('admin-assets/js/chart/exporting.js') }}"></script>--}}
{{--<script src="{{ asset('admin-assets/js/chart/export-data.js') }}"></script>--}}
{{--<script src="{{ asset('admin-assets/js/chart/accessibility.js') }}"></script>--}}
{{--<script src="{{ asset('admin-assets/js/chart/data.js') }}"></script>--}}

<script>
    // Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
    weeklySalesChartData = []
    var weeklySalesChart = Highcharts.chart('weekly-sales-chart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'نمودار فروش هفتگی'
        },
        subtitle: {
            text: 'منبع داده : ' +
                '<a href="" ' +
                'target="_blank">techzilla.com</a>'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            categories: ['شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنج شنبه', 'جمعه']
            // type: 'category'
        },
        yAxis: {
            title: {
                text: 'مبلغ فروش بر حسب تومان'
            }
        },
        plotOptions: {
            // line: {
            //     dataLabels: {
            //         enabled: true
            //     },
            //     enableMouseTracking: false
            // },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.0f}'
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [
            {
                name: "فروش هفتگی",
                colorByPoint: true,
                data: weeklySalesChartData,
            },
        ]
    });
    fetch('{{ route('api.market.report.weekly.sales') }}', {headers: {Accept: 'application/json'}})
        .then(result => result.json())
        .then(result => {
            weeklySalesChart.series[0].setData(result.data);
        })
        .catch(error => console.log(error));

</script>

<script>
    // Data retrieved https://en.wikipedia.org/wiki/List_of_cities_by_average_temperature
    monthlySalesChartData = []
    var monthlySalesChart = Highcharts.chart('monthly-sales-chart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'نمودار فروش ماهیانه'
        },
        subtitle: {
            text: 'منبع داده : ' +
                '<a href="" ' +
                'target="_blank">techzilla.com</a>'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            categories: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند']
            // type: 'category'
        },
        yAxis: {
            title: {
                text: 'مبلغ فروش بر حسب تومان'
            }
        },
        plotOptions: {
            // line: {
            //     dataLabels: {
            //         enabled: true
            //     },
            //     enableMouseTracking: false
            // },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: false,
                    format: '{point.y:.0f}'
                }
            }
        },
        legend: {
            enabled: false
        },
        series: [
            {
                name: "فروش ماهیانه",
                colorByPoint: true,
                data: monthlySalesChart,
            },
        ]
    });
    fetch('{{ route('api.market.report.monthly.sales') }}', {headers: {Accept: 'application/json'}})
        .then(result => result.json())
        .then(result => {
            monthlySalesChart.series[0].setData(result.data);
            // console.log(result.data)
        })
        .catch(error => console.log(error));

</script>
