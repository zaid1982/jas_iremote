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
                name: 'Late',
                y: 353,
                color: Highcharts.getOptions().colors[5]
            },
            {
                name: 'In 7-days',
                y: 696,
                color: Highcharts.getOptions().colors[2],
                sliced: true,
                selected: true
            }];
        chart_pie_3d('gqf_chart_1', 'Total Pending Inquiry by Status', 'All Cases; December 2016', dataSeries);
        dataSeries = [
                    {name:'iRemote System', y:21},
                    {name:'CEMS Installation', y:32},
                    {name:'PEMS Installation', y:2},
                    {name:'CEMS/PEMS Consultant Registration', y:32},
                    {name:'Complaint', y:76},
                    {name:'Suggestion', y:12}
                ];
        chart_donut_3d('gqf_chart_2', 'Total Inquiry by Category', 'All Cases; December 2016', dataSeries);
        chart_gqf_3('gqf_chart_3');
        
    });
    
    function chart_gqf_3(chart_div,parameter,dataset) {
        Highcharts.chart(chart_div, {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Total Inquiry Recorded'
            },
            subtitle: {
                text: 'All Cases'
            },
            credits:{
              enabled:false
            },
            xAxis: [{
                categories: ['23/10/16', '24/10/16', '25/10/16', '26/10/16', '27/10/16', '28/10/16', '29/10/16', '30/10/16', '31/10/16', '1/11/16', '2/11/16', '3/11/16', '4/11/16', '5/11/16', '6/11/16', '7/11/16', '8/11/16', '9/11/16'],
                crosshair: true
            }],
            yAxis: [{ // Primary yAxis
                title: {
                    text: 'Total Pending',
                    style: {
                        color: Highcharts.getOptions().colors[5]
                    }
                },
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[5]
                    }
                },
                opposite: true
            },{ // Secondary yAxis
                labels: {
                    style: {
                        color: Highcharts.getOptions().colors[8]
                    }
                },
                title: {
                    text: 'Inquiry Registered',
                    style: {
                        color: Highcharts.getOptions().colors[8]
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
            plotOptions: {
                column: {
                    stacking: 'normal'
                }
            },
            series: [{
                name: 'Inquiry Registered',
                type: 'column',
                yAxis: 1,
                color: Highcharts.getOptions().colors[9],
                data: [12, 34, 32, 4, 7, 24, 32, 34, 51, 42, 44, 31, 39, 38, 34, 54, 76, 65]
            }, {
                name: 'Total Pending',
                type: 'spline',
                color: Highcharts.getOptions().colors[5],
                data: [32, 23, 24, 25, 26, 25, 24, 15, 25, 24, 37, 36, 33, 23, 34, 33, 35, 36]
            }]
        });
    }
    
</script>