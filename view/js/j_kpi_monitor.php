<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();        
        f_chart_color();
        
        f_kpi_1();
        chart_kpi_columnPair('kpi_chart_3');
    
    });
    
    function f_kpi_1(){
        var data_chart_cate = [], data_chart_late = [], data_chart_ontime = [];
        var kpi_chart_1 = f_get_general_info_multiple('vw_kpi_chart_1');
        $.each(kpi_chart_1, function(u){
            data_chart_cate.push(kpi_chart_1[u].wfFlow_desc + '<br/>(' + kpi_chart_1[u].wfTaskType_name+')');
            data_chart_late.push(-parseInt(kpi_chart_1[u].late));
            data_chart_ontime.push(parseInt(kpi_chart_1[u].ontime));
        });
        var data_chart = [{
                name: 'Late Tasks',
                color: Highcharts.getOptions().colors[5],
                data: data_chart_late
            }, {
                name: 'On-time Tasks',
                color: Highcharts.getOptions().colors[9],
                data: data_chart_ontime
            }];
        chart_kpi_bar2ways('kpi_chart_1', 'Pending Task by Task Name', 'All pending tasks', data_chart_cate, data_chart);
    }
    
    function chart_kpi_bar2ways(chart_div, title, subtitle, categories, dataset) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'bar'
            },
            title: {
                text: title
            },
            subtitle: {
                text: subtitle
            },
            credits:{
              enabled:false
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
                    enabled: false
                }
            }],
            yAxis: {
                title: {
                    text: null
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
            series: dataset
        });
    }
         
    function chart_kpi_columnPair(chart_div,parameter,dataset) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Average Task Duration'
            },
            subtitle: {
                text: 'All Types; All Roles; December, 2016'
            },
            xAxis: {
                categories: [
                    'Aidi bin Sukri (Proses)',
                    'Anis Soraya bte Zul (Proses)',
                    'Mariana bte Najib (Proses)',
                    'Soraya Balqis bte Abd Ghani (Penyelia)',
                    'Che Qalani bin Hamzah (Pengambil Maklum)'
                ]
            },
            yAxis: [{
                min: 0,
                title: {
                    text: 'Average Days'
                }
            }],
            legend: {
                shadow: false
            },
            tooltip: {
                shared: true
            },
            plotOptions: {
                column: {
                    grouping: false,
                    shadow: false,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Limit Task Duration',
                color: '#f2caa4',
                data: [5, 5, 5, 4, 4],
                pointPadding: 0.1
            }, {
                name: 'Average Days',
                color: 'red',
                data: [4.12, 4.23, 7.45, 2.35, 4.34],
                pointPadding: 0.3
            }]
        });
    }
       
//    function chart_kpi_3(chart_div,parameter,dataset) {
//        Highcharts.chart(chart_div, {
//            chart: {
//                type: 'column'
//            },				
//            title: {
//                text: 'Total Daily Task Status'
//            },
//            subtitle: {
//                text: 'Aidi Sukri bin Ngah - Pegawai Pemproses'
//            },
//            xAxis: {
//                //categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
//                type: 'datetime',
//                dateTimeLabelFormats: {
//                    day: '%e %b'
//                },
//                labels: {
//                    rotation: -90,
//                    style: {
//                        fontSize: '11px',
//                        fontFamily: 'Verdana, sans-serif'
//                    }
//                },
//                tickInterval: 24*3600000
//            },
//            yAxis: {
//                allowDecimals: false,
//                min: 0,
//                title: {
//                    text: 'Total Number of Tasks'
//                }
//            },
//            tooltip: {
//                formatter: function () {
//                    return '<b>' +  Highcharts.dateFormat('%e %b, %Y', this.x) + '</b><br/>' +
//                        this.series.name + ': ' + this.y + '<br/>' +
//                        'Total ' +  this.series.options.stack + ':' + this.point.stackTotal;
//                }
//            },
//            plotOptions: {
//                column: {
//                    stacking: 'normal',
//                    pointInterval: 24*3600000, // one hour
//                    pointStart: Date.UTC(2016, 11, 1, 0, 0, 0)
//                },
//                series: {
//                    pointPadding: 0.1, // Defaults to 0.1
//                    groupPadding: 0.13 // Defaults to 0.2
//                }
//            },
//            series: [{
//                name: 'Completed On-time',
//                data: [15, 13, 4, 7, 12, 15, 13, 4, 7, 12, 15, 13, 4, 7, 12, 15, 13, 4, 7, 12, 15, 13, 4, 7, 12, 15, 13, 4, 7, 12],
//                stack: 'Completed',
//                color: '#36e033'
//            }, {
//                name: 'Completed Late',
//                data: [2, 4, 3, 2, 5, 2, 4, 3, 2, 5, 2, 4, 3, 2, 5, 2, 4, 3, 2, 5, 2, 4, 3, 2, 5, 2, 4, 3, 2, 5],
//                stack: 'Completed',
//                color: '#327c30'
//            }, {
//                name: 'Pending On-time ',
//                data: [22, 25, 26, 32, 21, 22, 25, 26, 32, 21, 22, 25, 26, 32, 21, 22, 25, 26, 32, 21, 22, 25, 26, 32, 21, 22, 25, 26, 32, 21],
//                stack: 'Pending',
//                color: '#f40909'
//            }, {
//                name: 'Pending Late',
//                data: [3, 6, 4, 2, 3, 3, 6, 4, 2, 3, 3, 6, 4, 2, 3, 3, 6, 4, 2, 3, 3, 6, 4, 2, 3, 3, 6, 4, 2, 3],
//                stack: 'Pending',
//                color: '#b22727'
//            }]
//        });
//    }
</script>