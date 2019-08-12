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
        
        $('#gid_count_registered').html('<i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;'+formattedNumber(f_get_general_info('vw_gid_count_registered').total)+'&nbsp;&nbsp;&nbsp;');
        $('#gid_count_active').html('<i class="fa fa-toggle-right"></i>&nbsp;&nbsp;'+formattedNumber(f_get_general_info('vw_gid_count_active').total)+'&nbsp;&nbsp;&nbsp;');
        
        f_gid_1($('#gid1_opt_year').html(), monthname.indexOf($('#gid1_opt_month').html()));
        f_gid_2();
        f_gid_3();
    
    });
    
    function f_gid_1(selected_year, selected_month){
        var data_chart_1 = [];
        var data_chart_2 = [];
        var gid_chart_1 = f_get_general_info_multiple('vw_gid_chart_1', {}, {year:selected_year, month:selected_month});
        $.each(gid_chart_1, function(u){    
            data_chart_1.push([Date.UTC(selected_year, selected_month, parseInt(gid_chart_1[u].list_day)), parseInt(gid_chart_1[u].total)]);
            data_chart_2.push([Date.UTC(selected_year, selected_month, parseInt(gid_chart_1[u].list_day)), parseInt(gid_chart_1[u].total_sum)]);
        });
        chart_combine_line_bar('gid_chart_1', 'Total Industrial Registration', 'Daily Registration and Total Registered', data_chart_1, data_chart_2, 'datetime', (24*3600*1000), 'Daily Registration', 'Total Registered');
    }
    
    function f_gid_2(){
        var data_chart = [];
        var gid_chart_2 = f_get_general_info_multiple('vw_gid_chart_2', {}, {}, '', 'total DESC, state_desc');
        $.each(gid_chart_2, function(u){
            data_chart.push({drilldown:gid_chart_2[u].state_id, name:gid_chart_2[u].state_desc, y:parseInt(gid_chart_2[u].total)});
        });           
        var data_chart_sub = [];
        var data_chart_subd = [];
        var current_state = ''; 
        var gid_chart_2_sub = f_get_general_info_multiple('vw_gid_chart_2_sub', {}, {}, '', 'state_id, total DESC, city_report');
        $.each(gid_chart_2_sub, function(u){
            if (current_state == '') {
                current_state = gid_chart_2_sub[u].state_id;
            } else if (current_state != gid_chart_2_sub[u].state_id) {
                data_chart_sub.push({id:gid_chart_2_sub[u-1].state_id, name:gid_chart_2_sub[u-1].state_desc, 'data':data_chart_subd});
                current_state = gid_chart_2_sub[u].state_id;
                data_chart_subd = [];
            }
            data_chart_subd.push({name:gid_chart_2_sub[u].city_report, y:parseInt(gid_chart_2_sub[u].total), ids:gid_chart_2_sub[u].city_id});
            if (u == gid_chart_2_sub.length - 1) {
                data_chart_sub.push({id:gid_chart_2_sub[u].state_id, name:gid_chart_2_sub[u].state_desc, 'data':data_chart_subd});
            }
        });
        chart_bar_sub('gid_chart_2', 'Total Industrial by State', '', data_chart, data_chart_sub, 'Total Active Industrial');
    }
    
    function f_gid_3(){
        var data_chart = [];
        var gid_chart_3 = f_get_general_info_multiple('vw_gid_chart_3');
        $.each(gid_chart_3, function(u){
            data_chart.push({name:gid_chart_3[u].sic_desc, y:parseInt(gid_chart_3[u].total), short:''});
        });    
        chart_pie('gid_chart_3', 'Total Industrial by Plant Sector', '', data_chart, false);
    }             
        
//    function event_chart_pie_3d(id){
//        alert(id);return false;
//    }
        
</script>