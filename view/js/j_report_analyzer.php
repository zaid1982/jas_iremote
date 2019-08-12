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
        
        var gca_count_active = f_get_general_info('vw_gca_count_active').total;
        $('#gca_count_active').html('<i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;'+formattedNumber(gca_count_active)+'&nbsp;&nbsp;&nbsp;');
        
        f_gca_1();
        f_gca_2();
        f_gca_3();
        f_gca_4();
        f_gca_5();
        
    });
    
    function f_gca_1(){
        var data_chart = [
            {name:'Gas Analyzer', y:0, short:''},
            {name:'Opacity Meter', y:0, short:''},
            {name:'Particulate Monitors', y:0, short:''}
        ];
        var gca_chart_1 = f_get_general_info_multiple('vw_gca_chart_1');
        $.each(gca_chart_1, function(u){
            data_chart[parseInt(gca_chart_1[u].consType_type)-1]['y'] = parseInt(gca_chart_1[u].total);
        });    
        chart_pie('gca_chart_1', 'Total CEMS Analyzer by Type', '', data_chart, false);
    }
    
    function f_gca_2(){
        var data_chart = [];
        var gca_chart_2 = f_get_general_info_multiple('vw_gca_chart_2');
        $.each(gca_chart_2, function(u){
            data_chart.push({name:gca_chart_2[u].analyzerTechnique_desc, y:parseInt(gca_chart_2[u].total), short:''});
        });    
        chart_pie('gca_chart_2', 'Total CEMS Analyzer by Method of Detection', '', data_chart, false);
    }   
        
    function f_gca_3(){
        var data_chart = [
            {name:'Extractive Analyzer', y:0, color: Highcharts.getOptions().colors[0]},
            {name:'In-Situ Analyzer', y:0, color: Highcharts.getOptions().colors[5]}
        ];
        var gca_chart_3 = f_get_general_info_multiple('vw_gca_chart_3');
        $.each(gca_chart_3, function(u){
            data_chart[parseInt(gca_chart_3[u].consCems_techniqueType)-1]['y'] = parseInt(gca_chart_3[u].total);
        }); 
        chart_donut('gca_chart_3', 'Total CEMS Analyzer by Technique', '', data_chart);
    }   
    
    function f_gca_4(){
        var data_chart = [
            {name:'Auto', y:0, color: Highcharts.getOptions().colors[3]},
            {name:'Manual', y:0, color: Highcharts.getOptions().colors[4]}
        ];
        var gca_chart_4 = f_get_general_info_multiple('vw_gca_chart_4');
        $.each(gca_chart_4, function(u){
            data_chart[parseInt(gca_chart_4[u].consCems_isNormalize)-1]['y'] = parseInt(gca_chart_4[u].total);
        }); 
        chart_donut('gca_chart_4', 'Total CEMS Analyzer by Normalization Type', '', data_chart);
    }  
    
    function f_gca_5(){
        var gca_chart_5 = f_get_general_info('vw_gca_chart_5');
        var data_chart = [
            {name:'Active', y:(gca_chart_5.total_active!=null?parseInt(gca_chart_5.total_active):0), color: Highcharts.getOptions().colors[2]},
            {name:'Expired in 1 month', y:(gca_chart_5.total_month!=null?parseInt(gca_chart_5.total_month):0), color: Highcharts.getOptions().colors[6]},
            {name:'Expired in 1 week', y:(gca_chart_5.total_week!=null?parseInt(gca_chart_5.total_week):0), color: Highcharts.getOptions().colors[7]},
            {name:'Expired', y:(gca_chart_5.total_expired!=null?parseInt(gca_chart_5.total_expired):0), color: Highcharts.getOptions().colors[8]}
        ];
        chart_donut('gca_chart_5', 'Total CEMS Analyzer by Certificate Expiry Status', '', data_chart);
    }
    
</script>