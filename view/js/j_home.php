<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="http://code.highcharts.com/maps/modules/map.js"></script>
<script src="http://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="http://code.highcharts.com/mapdata/countries/my/my-all.js"></script>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        chart_hm0_1('hm0_chart_1');
        chart_hm0_2('hm0_chart_2');
        chart_hm0_3('hm0_chart_3');
    
    });
    
    function chart_hm0_1(chart_div,parameter,dataset) {
        var categories = ['Complaint Feedback',
            'CEMS Analyzer Registraton', 'PEMS Consultant Registration', 'CEMS Consultant Registration', 'PEMS Installation', 'CEMS Installation'];
        Highcharts.chart(chart_div, {
            chart: {
                type: 'bar',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: -15,
                    viewDistance: 25,
                    depth: 40
                }
            },
            title: {
                text: 'Pending Tasks Summary'
            },
            subtitle: {
                text: 'Due date Monitoring by Application Type'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0,
                labels: {
                    enabled: false,
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return this.value<0?-this.value:this.value;
                    }
                }
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ' for ' + this.point.category + '</b><br/>' +
                        'Total Tasks: ' + Highcharts.numberFormat(this.point.y, 0);
                }
            },

            series: [{
                name: 'Late Submission',
                color: '#d12c23',
                data: [-7, -8, -1, -3, -0.01, -32]
            }, {
                name: 'On-time Submission',
                color: '#19b71c',
                data: [10, 9, 2, 15, 3, 40]
            }]
        });
        
    }
     
    function chart_hm0_2(chart_div,parameter,dataset) {

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
    
    function chart_hm0_3(chart_div,parameter,dataset) {

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