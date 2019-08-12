<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/map.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/my/my-all.js"></script>
<script type="text/javascript">  
    
    var data_map_array = [
        { "hc-key": "my-sa", "value": 0 },
        { "hc-key": "my-sk", "value": 0 },
        { "hc-key": "my-la", "value": 0 },
        { "hc-key": "my-pg", "value": 0 },
        { "hc-key": "my-kh", "value": 0 },
        { "hc-key": "my-sl", "value": 0 },
        { "hc-key": "my-ph", "value": 0 },
        { "hc-key": "my-kl", "value": 0 },
        { "hc-key": "my-pj", "value": 0 },
        { "hc-key": "my-pl", "value": 0 },
        { "hc-key": "my-jh", "value": 0 },
        { "hc-key": "my-pk", "value": 0 },
        { "hc-key": "my-kn", "value": 0 },
        { "hc-key": "my-me", "value": 0 },
        { "hc-key": "my-ns", "value": 0 },
        { "hc-key": "my-te", "value": 0 }
    ];
        
    $(document).ready(function () {
                
        pageSetUp();
        f_chart_color();  
        
        var widget_no = [];
        var arr_user_type = f_get_general_info_multiple('vw_widget_no', {user_id:$('#user_id').val(), userType_status:'1'});
        $.each(arr_user_type, function(u){
            widget_no.push(arr_user_type[u].widget_no);
        });   
        var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
                    
        if (widget_no.indexOf('1') >= 0) {
            $('#hm_row_1').removeClass('hide');            
            f_submit_normal('get_summary_total', {}, 'p_home');
            $('#lhm1_total_industry').html('<i class="fa fa-building"></i>&nbsp;'+formattedNumber(result_submit.total_industry));
            $('#lhm1_total_consultant').html('<i class="fa fa-user-secret"></i>&nbsp;'+formattedNumber(result_submit.total_consultant));
            $('#lhm1_total_cems').html('<i class="fa fa-dashboard"></i>&nbsp;'+formattedNumber(result_submit.total_cems));
            $('#lhm1_total_pems').html('<i class="fa fa-desktop"></i>&nbsp;'+formattedNumber(result_submit.total_pems));
            $('#lhm1_total_cems_analyzer').html('<i class="fa fa-hdd-o"></i>&nbsp;'+formattedNumber(result_submit.total_cems_analyzer));
            $('#lhm1_total_pems_software').html('<i class="fa fa-laptop"></i>&nbsp;'+formattedNumber(result_submit.total_pems_software));
        }
        
        if (widget_no.indexOf('2') >= 0) {
            $('#hm_row_2').removeClass('hide');                        
            var data_h2;
            var datatable_h2 = undefined;  var cnt_h2 = 1;
            var dataH2 = $('#datatable_h2').DataTable({
                "ordering": false,
                "pageLength": 5,
                "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_h2'>><'col-sm-6 hidden-xs'T>r>" + "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                "autoWidth": true,
                "oLanguage": {
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                "preDrawCallback": function () {
                    if (!datatable_h2) {
                        datatable_h2 = new ResponsiveDatatablesHelper($('#datatable_h2'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow, aData, index) {
                    datatable_h2.createExpandIcon(nRow);
                    var info = dataH2.page.info();
                    $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
                },
                "drawCallback": function (oSettings) {
                    datatable_h2.respond();
                },
                "oTableTools": {
                    "aButtons": [
                        {
                            "sExtends": "xls",
                            "sTitle": "iRemote_xls",
                            "mColumns": "all",
                            "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                                if (data_h2.length < cnt_h2)
                                    cnt_h2 = 1;
                                if ( iColumn === 0 )
                                    return cnt_h2++;
                                else if ( iColumn === 5 )
                                    return data_h2[iDataIndex].wfTask_dateExpired;
                                return sValue;
                            }
                        },
                        {
                            "sExtends": "pdf",
                            "sTitle": "iRemote_pdf",
                            "sPdfMessage": "iRemote PDF Export",
                            "sPdfSize": "letter",
                            "sPdfOrientation": "landscape",
                            "mColumns": "visible",
                            "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                                if (data_h2.length < cnt_h2)
                                    cnt_h2 = 1;
                                if ( iColumn === 0 )
                                    return cnt_h2++;
                                else if ( iColumn === 5 )
                                    return data_h2[iDataIndex].wfTask_dateExpired;
                                return sValue;
                            }
                        },
                        {
                            "sExtends": "print",
                            "sTitle": "iRemote_print",
                            "sMessage": "iRemote System"
                        }
                    ],
                   "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                },
                "aoColumns":
                    [
                        {mData: null, bSortable: false},
                        {mData: 'wfTrans_no'},
                        {mData: 'wfFlow_desc'},
                        {mData: 'wfGroup_name'},
                        {mData: 'wfTask_timeCreated', sClass: 'text-center'},
                        {mData: 'wfTask_dateExpired', sClass: 'text-center',
                            mRender: function (data, type, row) {
                                $label = data;
                                if (parseInt(row.datediff) > 0) {
                                    if (row.wfExcuse_desc != null)
                                        $label = '<b class="badge bg-color-orange" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="Still need deeper checking." data-html="true">' + data + '</b>';
                                    else
                                        $label = '<b class="badge bg-color-red" data-toggle="popover" data-trigger="click" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="<form action=\'#\' ><div class=\'row\'><div class=\'col-md-11\'><textarea rows=\'4\' class=\'form-control\'></textarea></div></div></br><div class=\'form-actions\'><div class=\'row\'><div class=\'col-md-12\'><button class=\'btn btn-primary btn-sm\' type=\'button\'>Submit</button></div></div></div></form>" data-html="true">' + data + '</b>';
                                }
                                return $label;
                            }
                        },
                    ]
            }); 
            $('#datatable_h2').on('draw.dt', function () {
                $('[data-toggle="popover"]').popover();
            });
            
            data_h2 = f_get_general_info_multiple('dt_hm_2', {}, {user_id:$('#user_id').val()}, '', 'wfTask_timeCreated DESC');
            f_dataTable_draw(dataH2, data_h2, 'datatable_h2', 6);
            $('#hm_lbl_total_pending').html(data_h2.length);
            if (data_h2.length == 0) {
                $('#hm_div_2_1').hide();
                $('#hm_div_2_2').removeClass('col-md-7').addClass('col-md-12');
                $('#hm_alert_2').removeClass('alert-danger').addClass('alert-success');
            } else {
                var data_chart = [];
                var data_chart_2 = f_get_general_info_multiple('vw_hm_chart_2', {}, {user_id:$('#user_id').val()});
                $.each(data_chart_2, function(u){
                    data_chart.push({name:data_chart_2[u].wfFlow_desc, y:parseInt(data_chart_2[u].total), short:data_chart_2[u].wfFlow_short});
                });     
                //chart_hm_pie_3d('hm_chart_2', 'Total Pending Tasks by Application Type', data_chart_2);
                chart_pie('hm_chart_2', 'Total Pending Tasks by Application Type', '', data_chart, true);
            }
        }
        
        if (widget_no.indexOf('3') >= 0) {            
            var data_cate = [], data_late = [], data_ontime = [];
            var data_chart_3 = f_get_general_info_multiple('vw_hm_chart_3', {}, {user_id:$('#user_id').val()});
            $.each(data_chart_3, function(u){
                data_cate[u] = data_chart_3[u].wfFlow_desc;
                data_late[u] = -parseInt(data_chart_3[u].late);
                data_ontime[u] = parseInt(data_chart_3[u].ontime);
            });     
            if (data_chart_3.length > 0) {
                $('#hm_row_3').removeClass('hide');            
                var data_min = Math.min.apply(null, data_late),
                    data_max = Math.max.apply(null, data_ontime);
                var data_chart = [{
                        name: 'Late Submission',
                        color: '#d12c23',
                        data: data_late
                    }, {
                        name: 'On-time Submission',
                        color: '#19b71c',
                        data: data_ontime
                    }];
                chart_hm_3('hm_chart_3', 'Pending Tasks Summary', 'Due date Monitoring by Application Type', data_cate, data_chart, data_min, data_max);
            }
        }
        
        if (widget_no.indexOf('4') >= 0) {            
            var data_cate = [], data_late = [], data_ontime = [];
            var data_chart_4 = f_get_general_info_multiple('vw_hm_chart_4', {}, {}, '', 'wfFlow_desc DESC');
            $.each(data_chart_4, function(u){
                data_cate[u] = data_chart_4[u].wfFlow_desc;
                data_late[u] = -parseInt(data_chart_4[u].late);
                data_ontime[u] = parseInt(data_chart_4[u].ontime);
            });     
            if (data_chart_4.length > 0) {
                $('#hm_row_4').removeClass('hide');            
                var data_min = Math.min.apply(null, data_late),
                    data_max = Math.max.apply(null, data_ontime);
                var data_chart = [{
                        name: 'Late Submission',
                        color: '#d12c23',
                        data: data_late
                    }, {
                        name: 'On-time Submission',
                        color: '#19b71c',
                        data: data_ontime
                    }];
                chart_hm_3('hm_chart_4', 'Officers\' Pending Tasks Summary', 'Due date Monitoring by Application Type', data_cate, data_chart, data_min, data_max);
            }
        }
        
        if (widget_no.indexOf('5') >= 0) { 
            $.each(data_map_array, function(u){
                data_map_array[u].value = 0;
            });
            var data_map_5 = f_get_general_info_multiple('vw_hm_map_5', {}, {response_date:get_yesterday_mysql(),response_type:'1'});
            $.each(data_map_5, function(u){                
                $.each(data_map_array, function(uv){
                    if (data_map_5[u].state_hc_key == data_map_array[uv]["hc-key"]) 
                        data_map_array[uv].value = parseInt(data_map_5[u].total);
                });
            }); 
            $('#hm_row_5').removeClass('hide');            
            chart_hm_map('hm_chart_5_1', 'Fail Pooling Maps', 'Date : '+get_yesterday()+', Total of '+data_map_5.length+' cases', 'Fail Pooling Cases', data_map_array);
            f_chart_hm_bardrill('hm_chart_5_3', 'vw_hm_chart_5', {response_date:get_yesterday_mysql(),response_type:'1'}, 'Total Fail Pooling');
            $.each(data_map_array, function(u){
                data_map_array[u].value = 0;
            });
            var data_map_5 = f_get_general_info_multiple('vw_hm_map_5', {}, {response_date:get_yesterday_mysql(),response_type:'2'});
            $.each(data_map_5, function(u){
                $.each(data_map_array, function(uv){
                    if (data_map_5[u].state_hc_key == data_map_array[uv]["hc-key"])
                        data_map_array[uv].value = parseInt(data_map_5[u].total);
                });
            }); 
            $('#hm_row_5').show();
            chart_hm_map('hm_chart_5_2', 'Fail Compliance Maps', 'Date : '+get_yesterday()+', Total of '+formattedNumber(data_map_5.length)+' cases', 'Fail Compliance Cases', data_map_array);
            f_chart_hm_bardrill('hm_chart_5_4', 'vw_hm_chart_5', {response_date:get_yesterday_mysql(),response_type:'2'}, 'Total Fail Compliance');
        }
        
        if (widget_no.indexOf('6') >= 0) { 
            var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wf_group.wfGroup_id, 'wfGroup_isFirstTime');         
            if (isFirstTime == '1') {
                $('#hm_div_7_alert').removeClass('hide');
                $('.hm_class_6').removeClass('hide');
                $('#hm_7_alert_txt').html('You are 1st time login as <strong>Consultant</strong>. Please complete the <strong>Consultant Information</strong> first before proceed to registration.');
            } else {
                $('#hm_div_7_info').removeClass('hide');
                $('.hm_class_6').removeClass('hide');
                $('#hm_7_info_txt').html('Please choose on the menu to add <strong>CEMS Analyzer</strong>, <strong>PEMS Software</strong> or <strong>Mobile/Portable Analyzer</strong>. </br>' +
                    'Registered Analyzer / Software will be enabled when Industrial register <strong>CEMS / PEMS Installation Form</strong>.');
            }
            $('#hm_6_content').html('');
            var data_bar_6 = f_get_general_info_multiple('vw_hm_bar_6', {wfGroup_id:wf_group.wfGroup_id}, '', '', 'consAll_id');
            if (data_bar_6.length > 0) {
                var cur_consAll_id = '';
                $.each(data_bar_6, function(u){ 
                    if (cur_consAll_id == '' || cur_consAll_id != data_bar_6[u].consAll_id) {
                        if (cur_consAll_id != '')
                            $('#hm_6_content').append('<hr class="simple">');
                        cur_consAll_id = data_bar_6[u].consAll_id;
                        $('#hm_6_content').append('<h6 class="padding-bottom-5">CEMS Analyzer ><small> Model '+data_bar_6[u].model_no+'</small></h6>');   
                    }
                    var perc = parseInt(data_bar_6[u].diff_t_e) > 100 ? 100 : parseInt(data_bar_6[u].diff_t_s)/parseInt(data_bar_6[u].diff_e_s)*100;
                    var days_expiry = parseInt(data_bar_6[u].diff_t_e) > 100 ? 'expired' : -parseInt(data_bar_6[u].diff_t_e)+'-days';
                    var alert_red = parseInt(data_bar_6[u].diff_t_e) > 100 ? 'txt-color-red' : '';
                    var html = '<p class="txt-color-blueDark margin-bottom-5"><strong>'+data_bar_6[u].certIssuer_desc+'</strong> - <i>cert. no:</i> '+data_bar_6[u].certificate_no+'<span class="hidden-xs">, <i>start:</i> '+convert_date_to_picker(data_bar_6[u].certificate_dateStart)+'</span> <span class="pull-right '+alert_red+'"><i class="fa fa-warning"></i> <i>Expiry date:</i> '+convert_date_to_picker(data_bar_6[u].certificate_dateExpired)+' ('+days_expiry+')</span></p>' +
                            '<div class="progress progress-striped active">' +
                            '<div class="progress-bar bg-color-'+bg_color_set[u%bg_color_set.length]+'" role="progressbar" style="width: '+perc+'%"></div>' +
                        '</div>';
                    $('#hm_6_content').append(html);
                }); 
            } else {
                var html = '<div class="alert alert-block alert-warning">' +
                        '<i class="fa-fw fa fa-warning"></i>You have no certificate registered to any active analyzer yet.' +
                    '</div>';
                $('#hm_6_content').html(html); 
            }
            $('#hm_row_6').removeClass('hide');            
        }
        
        if (widget_no.indexOf('7') >= 0) { 
            var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wf_group.wfGroup_id, 'wfGroup_isFirstTime');         
            if (isFirstTime == '1') {
                $('#hm_div_7_alert').removeClass('hide');
                $('.hm_class_7').removeClass('hide');
                $('#hm_7_alert_txt').html('You are 1st time login as <strong>Industrial</strong>. Please complete the <strong>Industrial Information</strong> first before proceed to registration.');
            } else {
                $('#hm_div_7_info').removeClass('hide');
                $('.hm_class_7').removeClass('hide');
                $('#hm_7_info_txt').html('Please choose on the menu to register <strong>CEMS Installation</strong> or <strong>PEMS Installation</strong>.');
            }
        }
            
    });
    
    function f_chart_hm_bardrill(chart_div, sql_name, arr_where, title){
        var data_chart = [];
        var gid_chart_2 = f_get_general_info_multiple(sql_name, {}, arr_where, '', 'total DESC, state_desc');
        $.each(gid_chart_2, function(u){
            data_chart.push({drilldown:gid_chart_2[u].state_id, name:gid_chart_2[u].state_desc, y:parseInt(gid_chart_2[u].total)});
        });           
        var data_chart_sub = [];
        var data_chart_subd = [];
        var current_state = ''; 
        var gid_chart_2_sub = f_get_general_info_multiple(sql_name+'_sub', {}, arr_where, '', 'state_id, total DESC, city_report');
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
        chart_bar_sub(chart_div, title+' by State', '', data_chart, data_chart_sub, title);
    }
    
    function chart_hm_pie_3d(chart_div, title, data_chart) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45,
                    beta: 0
                }
            },
            title: {
                text: title,
                floating: true,
            },
            credits:{
              enabled:false
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    innerSize: 50,
                    depth: 45,
                    dataLabels: {
                        enabled: true,
                        distance: 5,
                        format: '{point.short}: {y}',
                    },
                    showInLegend: true
                }
            },
            tooltip: {
                pointFormat: 'Total : <b>{point.y} ({point.percentage:.1f}%)</b>'
            },
            series: [{
                name: '',
                data: data_chart
            }]
        });
        
    }
    
    function chart_hm_3(chart_div, title, subtitle, data_cate, data_chart, data_min, data_max) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'bar',
//                options3d: {
//                    enabled: true,
//                    alpha: 15,
//                    beta: -15,
//                    viewDistance: 25,
//                    depth: 40
//                }
            },
            title: {
                text: title
            },
            subtitle: {
                text: subtitle
            },
            xAxis: [{
                categories: data_cate,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: data_cate,
                linkedTo: 0,
                labels: {
                    enabled: false,
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                tickInterval:1,
                labels: {
                    formatter: function () {
                        return this.value<0?-this.value:this.value;
                    }
                },
                min: data_min - 1, 
                max: data_max + 1,
                plotBands: [{ 
                    from: data_min - 1,
                    to: 0,
                    color: 'rgba(252, 176, 191, 0.25)',
                    label: {
                        text: data_chart[0].name,
                        style: {
                            color: '#606060'
                        }
                    }
                }, { 
                    from: 0,
                    to: data_max + 1,
                    color: 'rgba(68, 170, 213, 0.1)',
                    label: {
                        text: data_chart[1].name,
                        style: {
                            color: '#606060'
                        }
                    }
                }]
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            credits:{
              enabled:false
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ' for ' + this.point.category + '</b><br/>' +
                        'Total Tasks: ' + Highcharts.numberFormat(this.point.y<0?-this.point.y:this.point.y, 0);
                }
            },
            series: data_chart
        });
        
    }
    
    function chart_hm_map(chart_div, title, subtitle, title_tooltip, data_map) {
        $('#'+chart_div).highcharts('Map', {
            title : {
                text : title
            },
            subtitle : {
                text : subtitle
            },
            mapNavigation: {
                enabled: true,
                buttonOptions: {
                    verticalAlign: 'bottom'
                }
            },
            colorAxis: {
                min:0,
                minColor: '#efecf3',
                maxColor: '#990041'
            },
            credits:{
              enabled:false
            },
            series : [{
                data : data_map,
                mapData: Highcharts.maps['countries/my/my-all'],
                joinBy: 'hc-key',
                name: title_tooltip,
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
                enableMouseTracking: true
            }]
        });
    }
        
</script>