<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/my/my-all.js"></script>

<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        chart_hm6_1('hm6_chart_1');
        chart_hm6_2('hm6_chart_2');
        
    });
    
    function chart_hm6_1(chart_div,parameter,dataset) {

        // Prepare demo data
        var data = [
            {
                "hc-key": "my-sa",
                "value": 5
            },
            {
                "hc-key": "my-sk",
                "value": 1
            },
            {
                "hc-key": "my-la",
                "value": 2
            },
            {
                "hc-key": "my-pg",
                "value": 3
            },
            {
                "hc-key": "my-kh",
                "value": 4
            },
            {
                "hc-key": "my-sl",
                "value": 5
            },
            {
                "hc-key": "my-ph",
                "value": 6
            },
            {
                "hc-key": "my-kl",
                "value": 24
            },
            {
                "hc-key": "my-pj",
                "value": 12
            },
            {
                "hc-key": "my-pl",
                "value": 9
            },
            {
                "hc-key": "my-jh",
                "value": 10
            },
            {
                "hc-key": "my-pk",
                "value": 11
            },
            {
                "hc-key": "my-kn",
                "value": 12
            },
            {
                "hc-key": "my-me",
                "value": 13
            },
            {
                "hc-key": "my-ns",
                "value": 14
            },
            {
                "hc-key": "my-te",
                "value": 15
            },
            {
                "value": 16
            }
        ];

        // Initiate the chart
        $('#'+chart_div).highcharts('Map', {

            title : {
                text : 'Total Fail Data Pooling Cases'
            },

            subtitle : {
                text : 'Date : 24/11/2016, Total of 234 cases'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                min: 0
            },

            series : [{
                data : data,
                mapData: Highcharts.maps['countries/my/my-all'],
                joinBy: 'hc-key',
                name: 'Random data',
                states: {
                    hover: {
                        color: '#a4edba'
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }, {
                name: 'Separators',
                type: 'mapline',
                data: Highcharts.geojson(Highcharts.maps['countries/my/my-all'], 'mapline'),
                color: 'silver',
                showInLegend: false,
                enableMouseTracking: false
            }]
        });
    }
    
    function chart_hm6_2(chart_div,parameter,dataset) {

        // Prepare demo data
        var data = [
            {
                "hc-key": "my-sa",
                "value": 27
            },
            {
                "hc-key": "my-sk",
                "value": 23
            },
            {
                "hc-key": "my-la",
                "value": 2
            },
            {
                "hc-key": "my-pg",
                "value": 3
            },
            {
                "hc-key": "my-kh",
                "value": 4
            },
            {
                "hc-key": "my-sl",
                "value": 16
            },
            {
                "hc-key": "my-ph",
                "value": 17
            },
            {
                "hc-key": "my-kl",
                "value": 24
            },
            {
                "hc-key": "my-pj",
                "value": 12
            },
            {
                "hc-key": "my-pl",
                "value": 9
            },
            {
                "hc-key": "my-jh",
                "value": 10
            },
            {
                "hc-key": "my-pk",
                "value": 11
            },
            {
                "hc-key": "my-kn",
                "value": 12
            },
            {
                "hc-key": "my-me",
                "value": 13
            },
            {
                "hc-key": "my-ns",
                "value": 14
            },
            {
                "hc-key": "my-te",
                "value": 15
            },
            {
                "value": 16
            }
        ];

        // Initiate the chart
        $('#'+chart_div).highcharts('Map', {

            title : {
                text : 'Total Fail Data Compliance Cases'
            },

            subtitle : {
                text : 'Date : 24/11/2016, Total of 1,322 cases'
            },

            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },

            colorAxis: {
                min: 1,
                max: 30,
                minColor: '#efecf3',
                maxColor: '#990041'
            },

            series : [{
                data : data,
                mapData: Highcharts.maps['countries/my/my-all'],
                joinBy: 'hc-key',
                name: 'Random data',
                states: {
                    hover: {
                        color: '#a4edba'
                    }
                },
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }, {
                name: 'Separators',
                type: 'mapline',
                data: Highcharts.geojson(Highcharts.maps['countries/my/my-all'], 'mapline'),
                color: 'silver',
                showInLegend: false,
                enableMouseTracking: false
            }]
        });
    }
    
</script>