<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script type="text/javascript">  
    
    $(document).ready(function () {
        
        pageSetUp();
                
        f_chart_color();   
        dataSeries = [
            {
                name: 'Not Received',
                y: 353,
                color: Highcharts.getOptions().colors[5]
            },
            {
                name: 'Fail Format',
                y: 102,
                color: Highcharts.getOptions().colors[3]
            },
            {
                name: 'Success',
                y: 696,
                sliced: true,
                selected: true
            }];
        chart_pie_3d('gpo_chart_1', 'Total Pooling by Status', 'December 2016', dataSeries);
        dataSeries = [
            {
                name: 'Responded',
                y: 122
            },
            {
                name: 'Not Responded',
                y: 232,
                color: Highcharts.getOptions().colors[5],
                sliced: true,
                selected: true
            }];
        chart_pie_3d('gpo_chart_2', 'Total Fail Pooling by Respond Status', 'December 2016', dataSeries);        
        chart_gpo_4('gpo_chart_4');
        chart_gpo_5('gpo_chart_5');
        
    });
    
    function chart_gpo_4(chart_div,parameter,dataset) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Total Fail Pooling by State'
            },
            subtitle: {
                text: 'December 2016'
            },
            credits:{
              enabled:false
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total Fail Pooling (per input parameters)'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    },
                    pointPadding: 0
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },
            series: [{
                name: 'State',
                colorByPoint: true,
                data: [{
                    name: 'Selangor',
                    y: 343,
                    drilldown: 'Selangor'
                }, {
                    name: 'Pahang',
                    y: 341,
                    drilldown: 'Pahang'
                }, {
                    name: 'Perak',
                    y: 332,
                    drilldown: 'Perak'
                }, {
                    name: 'Johor',
                    y: 312,
                    drilldown: 'Johor'
                }, {
                    name: 'Kelantan',
                    y: 290,
                    drilldown: 'Kelantan'
                }, {
                    name: 'Negeri Sembilan',
                    y: 275,
                    drilldown: 'Negeri Sembilan'
                }, {
                    name: 'Kedah',
                    y: 243,
                    drilldown: 'Kedah'
                }, {
                    name: 'Kuala Lumpur',
                    y: 231,
                    drilldown: 'Kuala Lumpur'
                }, {
                    name: 'Sarawak',
                    y: 206,
                    drilldown: 'Sarawak'
                }, {
                    name: 'Pulau Pinang',
                    y: 197,
                    drilldown: 'Pulau Pinang'
                }, {
                    name: 'Terengganu',
                    y: 134,
                    drilldown: 'Terengganu'
                }, {
                    name: 'Melaka',
                    y: 123,
                    drilldown: 'Melaka'
                }, {
                    name: 'Sabah',
                    y: 104,
                    drilldown: 'Sabah'
                }, {
                    name: 'Perlis',
                    y: 34,
                    drilldown: 'Perlis'
                }, {
                    name: 'Labuan',
                    y: 12,
                    drilldown: 'Labuan'
                }]
            }],
            drilldown: {
                series: [{
                    name: 'Selangor',
                    id: 'Selangor',
                    data: [
                        [
                            'Shah Alam',
                            65
                        ],
                        [
                            'Klang',
                            59
                        ],
                        [
                            'Cheras',
                            48
                        ],
                        [
                            'Puchong',
                            37
                        ],
                        [
                            'Petaling Jaya',
                            25
                        ],
                        [
                            'Subang Jaya',
                            25
                        ],
                        [
                            'Sungai Buloh',
                            23
                        ],
                        [
                            'Bandar Baru Bangi',
                            14
                        ],
                        [
                            'Semenyih',
                            4
                        ]
                    ]
                }]
            }
        });
    }
    
    function chart_gpo_5(chart_div,parameter,dataset) {
        Highcharts.chart(chart_div, {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Total Fail Pooling'
            },
            subtitle: {
                text: 'Total Fail Pooling vs Percentage Fail Pooling'
            },
            credits:{
              enabled:false
            },
            xAxis: [{
                categories: ['23/11/16', '24/11/16', '25/11/16', '26/11/16', '27/11/16', '28/11/16', '29/11/16', '30/11/16', '1/12/16', '2/12/16', '3/12/16', '4/12/16', '5/12/16', '6/12/16', '7/12/16', '8/12/16', '9/12/16', '10/12/16'],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                title: {
                    text: 'Percentage Fail Pooling (%)',
                    style: {
                        color: Highcharts.getOptions().colors[7]
                    }
                },
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[7]
                    }
                },
                opposite: true
            },{ // Secondary yAxis
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[5]
                    }
                },
                title: {
                    text: 'Total Fail Pooling',
                    style: {
                        color: Highcharts.getOptions().colors[5]
                    }
                }
            }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 120,
                y: 100,
                floating: true,
                borderWidth: 1,
                backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
                shadow: true
            },
            series: [{
                name: 'Total Fail Pooling',
                type: 'column',
                yAxis: 1,
                color: Highcharts.getOptions().colors[5],
                data: [132, 344, 322, 42, 73, 244, 332, 354, 514, 422, 444, 313, 395, 383, 346, 545, 736, 625]
            }, {
                name: 'Percentage (%)',
                type: 'spline',
                color: Highcharts.getOptions().colors[7],
                data: [23, 36, 35, 8, 11, 27, 31, 32, 41, 39, 40, 32, 35, 35, 37, 34, 42, 42]
            }]
        });
    }
    
</script>


