<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">
    var shown = true;
    //setInterval(f_dcm_blink, 200);

    var cur_minute;
    var date_current = new Date();
    //date_current.setDate(date_current.getDate() - 342);
    var date_fullyear = date_current.getFullYear();
    var date_year = date_fullyear.toString();
    date_year = date_year.substr(2, 2); // new Date(Date.now()).toLocaleString()
    var date_minute = date_current.getMinutes();
    var date_hour = date_current.getHours();
    var minutes = date_current.getMinutes() >= 10 ? date_current.getMinutes() : '0' + date_current.getMinutes();
    var hours = date_current.getHours() >= 10 ? date_current.getHours() : '0' + date_current.getHours();
    cur_minute = hours + ':' + minutes + ':00';
    //var stored_minute = cur_minute;
    var dcm_monitor_info = [
        {data_id: 0, industrial_premiseId: 0, inputParam_id: 0, total_rows: 0, sum_rows: 0, indParam_limitValue: 0, stack_id: 0},
        {data_id: 0, industrial_premiseId: 0, inputParam_id: 0, total_rows: 0, sum_rows: 0, indParam_limitValue: 0, stack_id: 0},
        {data_id: 0, industrial_premiseId: 0, inputParam_id: 0, total_rows: 0, sum_rows: 0, indParam_limitValue: 0, stack_id: 0},
        {data_id: 0, industrial_premiseId: 0, inputParam_id: 0, total_rows: 0, sum_rows: 0, indParam_limitValue: 0, stack_id: 0}
    ];
    var data_plots = [];
    $(document).ready(function () {

        pageSetUp();

        for (var i = 0; i < 4; i++) {
            $('#dcm_btn_removeMonitor_' + i).hide();
            $('#dcm_chart_' + i + '_1').html('<h1 class="padding-15"><i>** Compliance Monitor Slot is empty. Choose industrial premise\'s stack and input parameter from Limit Exceeding Report page to monitor.</i></h1>');
            $('#dcm_chart_' + i + '_2').html('');
            $('#dcm_chart_' + i + '_3').html('');
        }
        for (var i = 0; i < 1440; i++) {
            data_plots[i] = {
                x: Date.UTC(date_current.getFullYear(), date_current.getMonth(), date_current.getDate(), Math.floor(i / 60), i % 60),
                y: null
            };
        }
//        var arr_input_param = f_get_general_info_multiple('vw_monitor_compliance'); 
//        $.each(arr_input_param, function(ux){            
//            $('#dcm_btn_removeMonitor_'+ux).show();
//            $('#dcm_indParam_id_'+ux).val(arr_input_param[ux].indParam_id);
//            var units = '', chart_limit = '', total_rows = 0, sum_rows = 0;
//            var data_plot = [];  
//            var total_not_comply = 0;
//            dcm_monitor_info[ux].industrial_premiseId = arr_input_param[ux].industrial_premiseId;
//            dcm_monitor_info[ux].inputParam_id = arr_input_param[ux].inputParam_id;
//            dcm_monitor_info[ux].indParam_limitValue = arr_input_param[ux].indParam_limitValue;
//            dcm_monitor_info[ux].stack_id = arr_input_param[ux].indAll_stackNo;
//            if (arr_input_param[ux].inputParam_id >= '8') {
//                for (var i=0; i<1440; i++) {
//                    data_plot[i] = {
//                        x: Date.UTC(date_current.getFullYear(), date_current.getMonth(), date_current.getDate(), Math.floor(i/60), i%60),
//                        y: null
//                    };
//                }
//                var check_table = f_get_general_info('information_schema.tables', {TABLE_NAME:'z'+date_year+'_'+arr_input_param[ux].industrial_premiseId});
//                if (check_table) {
//                    var data_01 = f_get_general_info_multiple('z'+date_year+'_'+arr_input_param[ux].industrial_premiseId, {stack_id:arr_input_param[ux].indAll_stackNo, 'year(data_timestamp)':date_current.getFullYear(), 'month(data_timestamp)':date_current.getMonth()+1, 'day(data_timestamp)':date_current.getDate(), 'TIME(data_timestamp)':'<='+cur_minute}, null, null, 'data_timestamp');
//                    $.each(data_01, function(u){
//                        var times = data_01[u].data_timestamp;
//                        var data_hour = parseInt(times.substr(11,2));
//                        var data_minute = parseInt(times.substr(14,2));
//                        var data_index = data_hour*60 + data_minute;
//                        var data_value = parseFloat(data_01[u]['data_'+arr_input_param[ux].inputParam_id]);
//                        if (data_value != 0) {
//                            data_plot[data_index] = {
//                                x: Date.UTC(date_current.getFullYear(), date_current.getMonth(), date_current.getDate(), data_hour, data_minute),
//                                y: parseFloat(data_value.toFixed(3))
//                            };              
//                            dcm_monitor_info[ux].data_id = parseInt(data_01[u].data_id);
//                            sum_rows += data_value;
//                            total_rows ++;
//                            if (data_value > parseFloat(arr_input_param[ux].indParam_limitValue))
//                                total_not_comply++;
//                        }
//                    });
//                }
//                units = '%';
//                chart_limit = parseInt(arr_input_param[ux].indParam_limitValue);
//            } else {  
//                for (var i=0; i<48; i++) {
//                    var j = (i%2==0)?0:30;
//                    data_plot[i] = {
//                        x: Date.UTC(date_current.getFullYear(), date_current.getMonth(), date_current.getDate(), Math.floor(i/2), j),
//                        y: null
//                    };
//                }
//                var check_table = f_get_general_info('information_schema.tables', {TABLE_SCHEMA: 'cems', TABLE_NAME:'z'+date_year+'_'+arr_input_param[ux].industrial_premiseId});
//                if (check_table) {
//                    var data_30 = f_get_general_info_multiple('dt_30_minute', {stack_id:arr_input_param[ux].indAll_stackNo, 'TIME(thirtyHourInterval)':'<='+cur_minute}, {tablename:'z'+date_year+'_'+arr_input_param[ux].industrial_premiseId, data_timestamp:mysqlDate(date_current)}, null, 'thirtyHourInterval');
//                    $.each(data_30, function(u){
//                        var times = data_30[u].thirtyHourInterval;
//                        var data_hour = parseInt(times.substr(11,2));
//                        var data_minute = parseInt(times.substr(14,2));
//                        var data_index = (data_hour*60 + data_minute) / 30;
//                        var data_sum = parseFloat(data_30[u]['sum_'+arr_input_param[ux].inputParam_id]);
//                        var data_count = parseFloat(data_30[u]['count_'+arr_input_param[ux].inputParam_id]);
//                        if (data_count > 22 && data_sum != 0) {
//                            var data_value = data_sum/data_count;
//                            if (data_value > parseInt(2*arr_input_param[ux].indParam_limitValue)) {
//                                data_plot[data_index] = {
//                                    x: Date.UTC(date_current.getFullYear(), date_current.getMonth(), date_current.getDate(), data_hour, data_minute),
//                                    y: parseFloat(data_value.toFixed(3)),
//                                    marker: { symbol: 'url(img/darkcloud.png)', height:35, width:45}
//                                };
//                                total_not_comply++;
//                            } else {
//                                data_plot[data_index] = {
//                                    x: Date.UTC(date_current.getFullYear(), date_current.getMonth(), date_current.getDate(), data_hour, data_minute),
//                                    y: parseFloat(data_value.toFixed(3))
//                                };
//                            }  
//                            dcm_monitor_info[ux].data_id = parseInt(data_30[u].data_id);                
//                            sum_rows += data_value;
//                            total_rows ++;
//                        }
//                    });
//                }
//                units = 'mg/m<sup>3</sup>';
//                chart_limit = parseInt(arr_input_param[ux].indParam_limitValue)*2;
//            }
//            dcm_monitor_info[ux].sum_rows = sum_rows;
//            dcm_monitor_info[ux].total_rows = total_rows;
//            //chart_dcm_1('dcm_chart_'+ux+'_1', '<p style="font-size:16px">'+arr_input_param[ux].wfGroup_name+',  '+arr_input_param[ux].city_desc+', '+arr_input_param[ux].state_desc+'</p>', 'Stack '+arr_input_param[ux].indAll_stackNo+', '+' Parameter '+arr_input_param[ux].inputParam_desc+', '+date_current.toDateString()+' (limit='+chart_limit+units+')', arr_input_param[ux].inputParam_desc, data_plot, chart_limit, ux, units);
//            f_dcm_set_averageBar(arr_input_param[ux].inputParam_id, sum_rows, total_rows, parseInt(arr_input_param[ux].indParam_limitValue), units, ux, total_not_comply);
//        });

        //function chart_dcm_1(chart_div, title, subtitle, parameter, dataset, limitValue, chart_no, units) {

        var tt = 1;
        var chart = new Highcharts.Chart({
            //Highcharts.chart('dcm_chart_0_1', {
            chart: {
                type: 'spline',
                renderTo: 'dcm_chart_0_1',
                animation: Highcharts.svg,
                marginRight: 10,
                events: {
                    load: function () {

                        // set up the updating of the chart each second
                        var series = this.series[0];
                        setInterval(function () {
                            
                            x = (new Date()).getTime();
                            y = Math.random();
                            chart.series[0].addPoint([x, y], true, true);
                            
                        }, 1000);
                    }
                }
            },
            title: {
                text: 'Live random data'
            },
            xAxis: {
                type: 'datetime',
                //tickPixelInterval: 150
            },
            yAxis: {
                title: {
                    text: 'Value'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            Highcharts.dateFormat('%Y-%m-%d %H:%M:%S', this.x) + '<br/>' +
                            Highcharts.numberFormat(this.y, 2);
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                    name: 'Random data',
                    data: (function () {
                        // generate an array of random data
                        var data = [],
                                time = (new Date()).getTime(),
                                i;
                        for (i = -19; i <= 0; i++) {
                            data.push({
                                x: time + i * 1000,
                                y: Math.random()
                            });
                        }
                        return data;
                    })()
                }]
        });
        //}

    });

    function mysqlDate(date) {
        date = date || new Date();
        return date.toISOString().split('T')[0];
    }

    function f_dcm_set_averageBar(inputParam_id, sum_rows, total_rows, limitValue, units, u, total_not_comply) {
        var data_average = !isNaN(sum_rows / total_rows) ? (sum_rows / total_rows).toFixed(3) : 0;
        var percent_average = data_average > limitValue ? 100 : (data_average / limitValue * 100);
        var max_time = inputParam_id >= '8' ? 1440 : 48;
        $('#dcm_chart_' + u + '_2').html('');
        var html_average = '<div class="bar-holder no-padding no-margin margin-bottom-5">' +
                '<p class="margin-bottom-5">Daily Average : <i class="' + (data_average > limitValue ? 'dcm_blink txt-color-red' : 'txt-color-blue') + ' text-bold">' + formattedNumber(data_average, 3) + ' ' + units + '</i> <span class="pull-right semi-bold text-muted">' + limitValue + ' ' + units + '</span> ' +
                '<div class="progress progress-sm progress-striped active">' +
                '<div class="progress-bar" style="width: ' + percent_average + '%; background-color: ' + color_set[0] + '"></div></div></div>';
        $('#dcm_chart_' + u + '_2').append(html_average);
        var html_average = '<div class="bar-holder no-padding no-margin">' +
                '<p class="margin-bottom-5">Total Data Received : <i class="' + (total_rows < 1 ? 'dcm_blink txt-color-red' : 'txt-color-blue') + ' text-bold">' + formattedNumber(total_rows) + '</i></br>Total Not Comply : <i class="' + (total_not_comply > 0 ? 'dcm_blink txt-color-red' : 'txt-color-blue') + ' text-bold"">' + formattedNumber(total_not_comply) + '</i> <span class="pull-right semi-bold text-muted">' + formattedNumber(max_time) + '</span></p>' +
                '<div class="progress progress-sm progress-striped active">' +
                '<div class="progress-bar bg-color-red" style="width: ' + (total_rows / max_time * 100) + '%"></div>' +
                '<div class="progress-bar" style="width: ' + ((total_rows - total_not_comply) / max_time * 100) + '%; background-color: ' + color_set[0] + '"></div></div></div>';
        $('#dcm_chart_' + u + '_2').append(html_average);
    }

    function f_dcm_blink() {
        if (shown) {
            $('.dcm_blink').hide();
            shown = false;
        } else {
            $('.dcm_blink').show();
            shown = true;
        }
    }

    function f_dcm_removeMonitor(chart_no, indParam_id) {
        if (f_submit_normal('remove_monitor', {indParam_id: indParam_id}, 'p_pooling', 'Stack and Input Parameter successfully removed from monitoring slot.')) {
            $('#dcm_btn_removeMonitor_' + chart_no).hide();
            $('#dcm_chart_' + chart_no + '_1').html('<h1 class="padding-15"><i>** Compliance Monitor Slot is empty. Choose industrial premise\'s stack and input parameter from Limit Exceeding Report page to monitor.</i></h1>');
            $('#dcm_chart_' + chart_no + '_2').html('');
            $('#dcm_chart_' + chart_no + '_3').html('');
            dcm_monitor_info[chart_no].data_id = '0';
        }
    }



</script>

