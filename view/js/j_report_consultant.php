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
        
        var gcs_count_registered = f_get_general_info('vw_gcs_count_registered').total;
        var gcs_count_approved = f_get_general_info('vw_gcs_count_approved').total;
        $('#gcs_count_registered').html('<i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;'+formattedNumber(gcs_count_registered)+'&nbsp;&nbsp;&nbsp;');
        $('#gcs_count_approved').html('<i class="fa fa-check-square-o"></i>&nbsp;&nbsp;'+formattedNumber(gcs_count_approved)+'&nbsp;&nbsp;&nbsp;');
        
        f_gcs_1($('#gcs1_opt_year').html(), monthname.indexOf($('#gcs1_opt_month').html()));
        f_gcs_2();
        f_gcs_3(gcs_count_registered, gcs_count_approved);
        f_gcs_4();
        f_gcs_5();
        f_gcs_6();
        
    });
    
    function f_gcs_1(selected_year, selected_month){
        var data_chart_1 = [];
        var data_chart_2 = [];
        var gcs_chart_1 = f_get_general_info_multiple('vw_gcs_chart_1', {}, {year:selected_year, month:selected_month});
        $.each(gcs_chart_1, function(u){    
            data_chart_1.push([Date.UTC(selected_year, selected_month, parseInt(gcs_chart_1[u].list_day)), parseInt(gcs_chart_1[u].total)]);
            data_chart_2.push([Date.UTC(selected_year, selected_month, parseInt(gcs_chart_1[u].list_day)), parseInt(gcs_chart_1[u].total_sum)]);
        });
        chart_combine_line_bar('gcs_chart_1', 'Total Consultant Registration', 'Daily Registration and Total Approved', data_chart_1, data_chart_2, 'datetime', (24*3600*1000), 'Daily Registration', 'Total Approved');
    }
    
    function f_gcs_2(){
        var data_cate = [];
        var data_value = [];
        var gcs_chart_2 = f_get_general_info_multiple('vw_gcs_chart_2');
        $.each(gcs_chart_2, function(u){
            data_cate.push(gcs_chart_2[u].consAll_type_desc);
            data_value.push(parseInt(gcs_chart_2[u].total));
        });    
        chart_bar('gcs_chart_2', 'Total Consultant by Category', '', data_cate, data_value, 'Total Consultant');
    }     
    
    function f_gcs_3(registered, approved){
        var data_chart = [];
        data_chart.push({name:'Applying', y:parseInt(registered)-parseInt(approved), short:'', color: Highcharts.getOptions().colors[8]});  
        data_chart.push({name:'Approved', y:parseInt(approved), short:'', color: Highcharts.getOptions().colors[2]});   
        chart_pie('gcs_chart_3', 'Total Consultant by Status', '', data_chart, false);
    } 
    
    function f_gcs_4(){
        var data_cate = ['Gases', 'Particulate', 'Opacity'];
        var data_value = [0, 0, 0];
        var gcs_chart_4 = f_get_general_info_multiple('vw_gcs_chart_4');
        $.each(gcs_chart_4, function(u){
            data_value[(parseInt(gcs_chart_4[u].type)-1)] = parseInt(gcs_chart_4[u].total);
        });    
        chart_bar('gcs_chart_4', 'Total Consultant by Emission Monitored', '', data_cate, data_value, 'Total Consultant');
    } 
    
    function f_gcs_5(){
        var data_chart = [];
        var gcs_chart_5 = f_get_general_info_multiple('vw_gcs_chart_5', {}, {}, '', 'total DESC, state_desc');
        $.each(gcs_chart_5, function(u){
            data_chart.push({drilldown:gcs_chart_5[u].state_id, name:gcs_chart_5[u].state_desc, y:parseInt(gcs_chart_5[u].total)});
        });           
        var data_chart_sub = [];
        var data_chart_subd = [];
        var current_state = ''; 
        var gcs_chart_5_sub = f_get_general_info_multiple('vw_gcs_chart_5_sub', {}, {}, '', 'state_id, total DESC, city_report');
        $.each(gcs_chart_5_sub, function(u){
            if (current_state == '') {
                current_state = gcs_chart_5_sub[u].state_id;
            } else if (current_state != gcs_chart_5_sub[u].state_id) {
                data_chart_sub.push({id:gcs_chart_5_sub[u-1].state_id, name:gcs_chart_5_sub[u-1].state_desc, 'data':data_chart_subd});
                current_state = gcs_chart_5_sub[u].state_id;
                data_chart_subd = [];
            }
            data_chart_subd.push({name:gcs_chart_5_sub[u].city_report, y:parseInt(gcs_chart_5_sub[u].total), ids:gcs_chart_5_sub[u].city_id});
            if (u == gcs_chart_5_sub.length - 1) {
                data_chart_sub.push({id:gcs_chart_5_sub[u].state_id, name:gcs_chart_5_sub[u].state_desc, 'data':data_chart_subd});
            }
        });
        chart_bar_sub('gcs_chart_5', 'Total Consultant by State', '', data_chart, data_chart_sub, 'Total Active Consultant');
    }
    
    function f_gcs_6(){
        var data_chart_1 = [];
        var data_chart_2 = [];
        var data_categories = [];
        var gcs_chart_6 = f_get_general_info_multiple('vw_gcs_chart_6', {}, {}, '', 'total DESC, total_cems DESC');
        $.each(gcs_chart_6, function(u){
            data_categories.push(gcs_chart_6[u].wfGroup_name);
            data_chart_1.push(parseInt(gcs_chart_6[u].total_cems));
            data_chart_2.push(parseInt(gcs_chart_6[u].total_pems));
        }); 
        var data_series = [{
                name: 'PEMS',
                color: Highcharts.getOptions().colors[6],
                data: data_chart_2
            }, {
                name: 'CEMS',
                color: Highcharts.getOptions().colors[7],
                data: data_chart_1
            }];
        chart_bar_stack('gcs_chart_6', 'Total Stack Installation (CEMS/PEMS)', 'Top 10 Consultant', data_categories, data_series, 'Total Stack');        
    }
         
</script>


