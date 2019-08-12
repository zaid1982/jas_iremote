<script src="js/plugin/sparkline/jquery.sparkline.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script type="text/javascript">  
    
    $(document).ready(function () {
        
        pageSetUp();                
        f_chart_color();   
        
        var gcp_count_registered = f_get_general_info('vw_gcp_count_registered').total;
        $('#gcp_count_registered').html('<i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;'+formattedNumber(gcp_count_registered)+'&nbsp;&nbsp;&nbsp;');
        
        f_gcp_1($('#gcp1_opt_year').html(), monthname.indexOf($('#gcp1_opt_month').html()));
        f_gcp_2();
        f_gcp_3();
        f_gcp_4();
        f_gcp_5();
        
    });
    
    function f_gcp_1(selected_year, selected_month){
        var data_chart_1 = [];
        var data_chart_2 = [];
        var gcp_chart_1 = f_get_general_info_multiple('vw_gcp_chart_1', {}, {year:selected_year, month:selected_month});
        $.each(gcp_chart_1, function(u){    
            data_chart_1.push([Date.UTC(selected_year, selected_month, parseInt(gcp_chart_1[u].list_day)), parseInt(gcp_chart_1[u].total)]);
            data_chart_2.push([Date.UTC(selected_year, selected_month, parseInt(gcp_chart_1[u].list_day)), parseInt(gcp_chart_1[u].total_sum)]);
        });
        chart_combine_line_bar('gcp_chart_1', 'Total CEMS/PEMS Registration', 'Daily Registration and Total Registered', data_chart_1, data_chart_2, 'datetime', (24*3600*1000), 'Daily Registration', 'Total Registered');
    }
    
    function f_gcp_2(){
        var data_chart = [];
        var gcp_chart_2 = f_get_general_info_multiple('vw_gcp_chart_2', {}, {}, '', 'total DESC, state_desc');
        $.each(gcp_chart_2, function(u){
            data_chart.push({drilldown:gcp_chart_2[u].state_id, name:gcp_chart_2[u].state_desc, y:parseInt(gcp_chart_2[u].total)});
        });           
        var data_chart_sub = [];
        var data_chart_subd = [];
        var current_state = ''; 
        var gcp_chart_2_sub = f_get_general_info_multiple('vw_gcp_chart_2_sub', {}, {}, '', 'state_id, total DESC, city_report');
        $.each(gcp_chart_2_sub, function(u){
            if (current_state == '') {
                current_state = gcp_chart_2_sub[u].state_id;
            } else if (current_state != gcp_chart_2_sub[u].state_id) {
                data_chart_sub.push({id:gcp_chart_2_sub[u-1].state_id, name:gcp_chart_2_sub[u-1].state_desc, 'data':data_chart_subd});
                current_state = gcp_chart_2_sub[u].state_id;
                data_chart_subd = [];
            }
            data_chart_subd.push({name:gcp_chart_2_sub[u].city_report, y:parseInt(gcp_chart_2_sub[u].total), ids:gcp_chart_2_sub[u].city_id});
            if (u == gcp_chart_2_sub.length - 1) {
                data_chart_sub.push({id:gcp_chart_2_sub[u].state_id, name:gcp_chart_2_sub[u].state_desc, 'data':data_chart_subd});
            }
        });
        chart_bar_sub('gcp_chart_2', 'Total CEMS/PEMS Installation by State', '', data_chart, data_chart_sub, 'Total CEMS/PEMS');
    }
    
    function f_gcp_3(){
        var data_cate = [];
        var data_value = [];
        var gcp_chart_3 = f_get_general_info_multiple('vw_gcp_chart_3');
        $.each(gcp_chart_3, function(u){
            data_cate.push(gcp_chart_3[u].indAll_type_desc);
            data_value.push(parseInt(gcp_chart_3[u].total));
        });    
        chart_bar('gcp_chart_3', 'Total Installation by Category', '', data_cate, data_value, 'Total Installation');
    }
    
    function f_gcp_4(){
        var data_cate = ['Gases', 'Particulate', 'Opacity'];
        var data_value = [0, 0, 0];
        var gcp_chart_4 = f_get_general_info_multiple('vw_gcp_chart_4');
        $.each(gcp_chart_4, function(u){
            data_value[(parseInt(gcp_chart_4[u].pollutionMonitored_id)-1)] = parseInt(gcp_chart_4[u].total);
        });    
        chart_bar('gcp_chart_4', 'Total CEMS/PEMS by Pollution Monitored', '', data_cate, data_value, 'Total CEMS/PEMS');
    }
            
    function f_gcp_5(){
        var data_chart = [];
        var gcp_chart_5 = f_get_general_info_multiple('vw_gcp_chart_5', {}, {}, '', 'total DESC, sourceActivity_id');
        $.each(gcp_chart_5, function(u){
            data_chart.push({drilldown:gcp_chart_5[u].sourceActivity_id, name:gcp_chart_5[u].sourceActivity_desc, y:parseInt(gcp_chart_5[u].total)});
        });           
        var data_chart_sub = [];
        var data_chart_subd = [];
        var current_source = ''; 
        var gcp_chart_5_sub = f_get_general_info_multiple('vw_gcp_chart_5_sub', {}, {}, '', 'sourceActivity_id, total DESC, sourceCapacity_id');
        $.each(gcp_chart_5_sub, function(u){
            if (current_source == '') {
                current_source = gcp_chart_5_sub[u].sourceActivity_id;
            } else if (current_source != gcp_chart_5_sub[u].sourceActivity_id) {
                data_chart_sub.push({id:gcp_chart_5_sub[u-1].sourceActivity_id, name:gcp_chart_5_sub[u-1].sourceActivity_desc, 'data':data_chart_subd});
                current_source = gcp_chart_5_sub[u].sourceActivity_id;
                data_chart_subd = [];
            }
            data_chart_subd.push({name:gcp_chart_5_sub[u].sourceCapacity_desc, y:parseInt(gcp_chart_5_sub[u].total), ids:gcp_chart_5_sub[u].sourceCapacity_id});
            if (u == gcp_chart_5_sub.length - 1) {
                data_chart_sub.push({id:gcp_chart_5_sub[u].sourceActivity_id, name:gcp_chart_5_sub[u].sourceActivity_desc, 'data':data_chart_subd});
            }
        });
        chart_pie_sub('gcp_chart_5', 'Total CEMS/PEMS BY Source Activity', '', data_chart, data_chart_sub, 'Total CEMS/PEMS');
    }
            
    function chart_gcp_4(chart_div,parameter,dataset) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Total CEMS/PEMS by Source'
            },
            subtitle: {
                text: ''
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: false,
                        format: '{point.name}: {point.y:.1f} ({point.percentage:.1f}%)'
                    },
                    animation: true,
                    showInLegend: true
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> ({point.percentage:.1f}% of total)<br/>'
            },
            series: [{
                name: 'Source',
                colorByPoint: true,
                data: [{
                    name: 'Fuel Burning Equipment',
                    y: 322,
                    drilldown: null
                }, {
                    name: 'Heat and Power Generation',
                    y: 1211,
                    drilldown: 'Heat and Power Generation'
                }, {
                    name: 'Ferrous Metals',
                    y: 322,
                    drilldown: 'Ferrous Metals'
                }, {
                    name: 'Non-Ferrous Metals',
                    y: 544,
                    drilldown: 'Non-Ferrous Metals'
                }, {
                    name: 'Oil and Gas Industries',
                    y: 122,
                    drilldown: 'Oil and Gas Industries'
                }, {
                    name: 'Non-metallic Industry',
                    y: 322,
                    drilldown: 'Non-metallic Industry'
                }, {
                    name: 'Waste Incinerator',
                    y: 98,
                    drilldown: null
                }]
            }],
            drilldown: {
                series: [{
                    name: 'Heat and Power Generation',
                    id: 'Heat and Power Generation',
                    data: [
                        ['Boilers', 213],
                        ['Combustion Turbines', 121]
                    ]
                }, {
                    name: 'Ferrous Metals',
                    id: 'Ferrous Metals',
                    data: [
                        ['Sinter Plants', 511],
                        ['Coke Ovens', 432],
                        ['Blast Furnaces', 212],
                        ['Electric Arc Furnaces', 32]
                    ]
                }, {
                    name: 'Non-Ferrous Metals',
                    id: 'Non-Ferrous Metals',
                    data: [
                        ['Sinter Plants', 511],
                        ['Copper and Zinc', 432],
                        ['Lead', 322],
                        ['Primary Aluminium', 211],
                        ['Secondary Aluminium', 123],
                        ['Smelting, Alloying and Refining of Aluminium', 54],
                        ['Smelting, Alloying and Refining of Other Non-Ferrous Metals', 32]
                    ]
                }, {
                    name: 'Oil and Gas Industries',
                    id: 'Oil and Gas Industries',
                    data: [
                        ['Catalytic Cracking', 211],
                        ['Calcination', 43]
                    ]
                }, {
                    name: 'Non-metallic Industry',
                    id: 'Non-metallic Industry',
                    data: [
                        ['Cement Kiln', 455],
                        ['Glass Furnaces', 432],
                        ['Rotary Furnaces', 123],
                        ['Ceramic Furnaces', 21]
                    ]
                }]
            }
        }); 
    }
        
</script>