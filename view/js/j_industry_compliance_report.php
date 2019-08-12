<?php 
    include 'view/js/j_modal_cems.php';
    include 'view/js/j_modal_pems.php';
    include 'view/js/j_modal_consultant_cems.php';
    include 'view/js/j_modal_consultant_pems.php';
    include 'view/js/j_modal_consultant_mobile.php';
?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">  
    
    var data_exi;
    var data_exi_opa;
    var industrial_param;
    var exi_limit_value = [0,0,0,0,0,0,0,0,0,0,0,0];
    var arr_param_all = [];
    var arr_param_stack_in = []; 
    var arr_param_plot = []; 
    var premise_no;
    var industrial;
    var wf_group;
    var shown = true;
    setInterval(f_exi_blink, 200);
    
    $(document).ready(function () {
        
        pageSetUp(); 
        
        var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
        industrial = f_get_general_info('t_industrial', {wfGroup_id:wf_group_user.wfGroup_id});
        wf_group = f_get_general_info('wf_group', {wfGroup_id:wf_group_user.wfGroup_id});
        $('#exi_widget_stack').hide();
        
        $('#form_exi').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                exi_data_timestamp : {
                    validators: {
                        notEmpty: {
                            message: 'Reference Date is required'
                        }
                    }
                }
            }
        });   
        
        $('#exi_data_timestamp').datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            maxDate: '0', 
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: true,
            closeText:'Clear',
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            },
            onSelect: function( input ) {
                $('#form_exi').bootstrapValidator('revalidateField', 'exi_data_timestamp');
            }
        });
                        
        $('#exi_indAll_id').on('change', function () { 
            var indAll_id = $(this).val();
            $('#modal_waiting').on('shown.bs.modal', function(e){
                f_exi_stack_data(indAll_id);
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        }); 
        
        var datatable_exi = undefined;  
        data_exi = $('#datatable_exi').DataTable({
            "ordering":false,
            //"pageLength":50,
            "scrollY": "590px",
            "scrollCollapse": true,
            "paging":         false,
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_exi'>><'col-sm-6 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-12'i>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_exi) {
                    datatable_exi = new ResponsiveDatatablesHelper($('#datatable_exi'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_exi.createExpandIcon(nRow);                
            },
            "drawCallback": function (oSettings) {
                datatable_exi.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible",
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
                    {mData: 'list_time', sClass: 'padding-5 text-center'},
                    {mData: 'sum_1', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(1, data, row);
                        }
                    },
                    {mData: 'sum_2', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(2, data, row);
                        }
                    },
                    {mData: 'sum_3', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(3, data, row);
                        }
                    },
                    {mData: 'sum_4', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(4, data, row);
                        }
                    },
                    {mData: 'sum_5', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(5, data, row);
                        }
                    },
                    {mData: 'sum_6', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(6, data, row);
                        }
                    },
                    {mData: 'sum_7', sClass: 'padding-5 text-right', 
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(7, data, row);
                        }
                    }
                ]
        });   
        $("div.toolbar_exi").html('<div style="padding-top:5px"><b>30-minute Data (mg/m<sup>3</sup>) :</b></div>');
        
        var datatable_exi_opa = undefined;  
        data_exi_opa = $('#datatable_exi_opa').DataTable({
            "ordering":false,
            //"pageLength":50,
            "scrollY": "590px",
            "scrollCollapse": true,
            "paging":         false,
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_exi_opa'>><'col-sm-6 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-12'i>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_exi_opa) {
                    datatable_exi_opa = new ResponsiveDatatablesHelper($('#datatable_exi_opa'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_exi_opa.createExpandIcon(nRow);                
            },
            "drawCallback": function (oSettings) {
                datatable_exi_opa.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible",
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
                    {mData: 'list_time', sClass: 'padding-5 text-center'},
                    {mData: 'data_8', sClass: 'padding-5 text-right',
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(8, data, row);
                        }
                    },
                    {mData: 'data_9', sClass: 'padding-5 text-right',
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(9, data, row);
                        }
                    },
                    {mData: 'data_10', sClass: 'padding-5 text-right',
                        mRender: function (data, type, row) {
                            return f_exi_data_listing(10, data, row);
                        }
                    }
                ]
        });  
        $("div.toolbar_exi_opa").html('<div style="padding-top:5px"><b>1-minute Data (%) :</b></div>');
        
        $('#exi_widget_0_title').html('Compliance Monitoring Chart');
        $('#exi_chart_0_1').html('<h1 class="padding-15"><i>** Please select Industrial Premise and date to view the Compliance Report</i></h1>');
        $('.exi_hideView').hide();
                
        $('#exi_btn_view').on('click', function () {     
            var bootstrapValidator = $("#form_exi").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }    
            if (industrial == '') {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }    
            $('#modal_waiting').on('shown.bs.modal', function(e){
                $('.exi_hideView').hide(); 
                $('#exi_chart_0_1').html('<h1 class="padding-15"><i>** Please select Industrial Premise and date to view the Compliance Report</i></h1>');
                $('#exi_widget_0_title').html('Compliance Monitoring Chart');
                $('#exi_widget_0_title_data').html('Stack Data for '+date_form+' - '+wf_group.wfGroup_name);
                var opt_indAll_id = get_option('exi_indAll_id', industrial.industrial_id, 'stack_complience', $('#exi_data_timestamp').val(), '', '', null, 'ref_desc'); 
                if (opt_indAll_id.length === 0) {
                    f_notify(2, 'Error', 'No stack available to obtain data from the selected Industrial and Date');
                    return false;
                }
                var indAll_id_list = '';
                $.each(opt_indAll_id, function(u){
                    indAll_id_list += ','+opt_indAll_id[u].ref_id;
                });         
                var arr_input_param = f_get_general_info_multiple('vw_compliance_param_list', {indAll_id:'('+indAll_id_list.substr(1)+')'}, '', '', 'inputParam_id, indAll_id');
                if (arr_input_param.length === 0) {         
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                } 
                premise_no = industrial.industrial_premiseId;
                var date_form = $('#exi_data_timestamp').val(); 
                var date_year = date_form.substr(2,2);   
                arr_param_all = [];  
                $.each(arr_input_param, function(u){
                    var index = 0;
                    $.each(opt_indAll_id, function(ux){
                        if (opt_indAll_id[ux].ref_id == arr_input_param[u].indAll_id)
                            index = ux;
                    });  
                    var limit_value = arr_input_param[u].inputParam_id < 8 ? parseInt(arr_input_param[u].indParam_limitValue)*2 : parseInt(arr_input_param[u].indParam_limitValue);
                    if (u === 0) {
                        arr_param_stack_in = []; 
                        arr_param_plot = []; 
                        arr_param_stack_in.push(arr_input_param[u]);
                        arr_param_plot.push({name:'Stack '+arr_input_param[u].indAll_stackNo, indAll_id:arr_input_param[u].indAll_id, data:f_exi_default_plot(arr_input_param[u].inputParam_id, date_form), threshold: limit_value, negativeColor:color_set[index], color: 'red', indParam_limitValue:arr_input_param[u].indParam_limitValue});
                    } else if (arr_input_param[u].inputParam_id == arr_input_param[u-1].inputParam_id) {
                        arr_param_stack_in.push(arr_input_param[u]);
                        arr_param_plot.push({name:'Stack '+arr_input_param[u].indAll_stackNo, indAll_id:arr_input_param[u].indAll_id, data:f_exi_default_plot(arr_input_param[u].inputParam_id, date_form), threshold: limit_value, negativeColor:color_set[index], color: 'red', indParam_limitValue:arr_input_param[u].indParam_limitValue});
                    } else {
                        arr_param_all.push({inputParam_id:arr_param_stack_in[0].inputParam_id,inputParam_desc:arr_param_stack_in[0].inputParam_desc, data:arr_param_stack_in, data_plot:arr_param_plot});
                        arr_param_stack_in = []; 
                        arr_param_plot = []; 
                        arr_param_stack_in.push(arr_input_param[u]);
                        arr_param_plot.push({name:'Stack '+arr_input_param[u].indAll_stackNo, indAll_id:arr_input_param[u].indAll_id, data:f_exi_default_plot(arr_input_param[u].inputParam_id, date_form), threshold: limit_value, negativeColor:color_set[index], color: 'red', indParam_limitValue:arr_input_param[u].indParam_limitValue});
                    }
                    if (u == arr_input_param.length - 1)
                        arr_param_all.push({inputParam_id:arr_param_stack_in[0].inputParam_id,inputParam_desc:arr_param_stack_in[0].inputParam_desc, data:arr_param_stack_in, data_plot:arr_param_plot});
                });   
                $('#exi_div_bar_0').html('');
                $('#exi_div_bar_0, #exi_widget_stack').show();   
                var data_01 = f_get_general_info_multiple('z'+date_year+'_'+premise_no, {'date(data_timestamp)':date_form}); 
                $.each(data_01, function(uv){
                    for(var ux=0;ux<arr_param_all.length;ux++){
                        var inputParam_id = arr_param_all[ux].inputParam_id;
                        if (parseInt(inputParam_id) >= 8) {                                             
                            var times = data_01[uv].data_timestamp;
                            var data_hour = parseInt(times.substr(11,2));
                            var data_minute = parseInt(times.substr(14,2));
                            var data_index = data_hour*60 + data_minute;
                            var stack_index = -1;
                            for(var uw=0;uw<arr_param_all[ux]['data'].length;uw++){
                                if (arr_param_all[ux]['data'][uw].indAll_stackNo == data_01[uv].stack_id) {
                                    stack_index = uw;
                                    break;
                                }                                    
                            }
                            if (stack_index != '-1') {
                                if (typeof arr_param_all[ux]['data_plot'][stack_index] !== 'undefined') {
                                    var data_value = parseFloat(data_01[uv]['data_'+inputParam_id]);
                                    if (data_value != 0) {
                                        arr_param_all[ux]['data_plot'][stack_index]['data'][data_index] = {
                                            x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), data_hour, data_minute),
                                            y: parseFloat(data_value.toFixed(3))
                                        }; 
                                        if (data_value > parseInt(arr_param_all[ux]['data_plot'][stack_index]['indParam_limitValue'])) {
                                            var total_not_comply = parseInt(arr_param_all[ux]['data'][stack_index]['total_not_comply']) + 1; 
                                            arr_param_all[ux]['data'][stack_index]['total_not_comply'] = total_not_comply;
                                        }
                                        var total_rows = parseInt(arr_param_all[ux]['data'][stack_index]['total_rows']) + 1; 
                                        arr_param_all[ux]['data'][stack_index]['total_rows'] = total_rows;
                                        var sum_rows = parseFloat(arr_param_all[ux]['data'][stack_index]['sum_rows']) + data_value; 
                                        arr_param_all[ux]['data'][stack_index]['sum_rows'] = sum_rows;
                                    }
                                }
                            }
                        }                        
                    }
                });                  
                $.each(arr_param_all, function(ux){
                    if (parseInt(arr_param_all[ux].inputParam_id) >= 8) {
                        $('#exi_widget_'+ux).show();
                        $('#exi_widget_'+ux+'_title').html(wf_group.wfGroup_name+' : '+arr_param_all[ux].inputParam_desc);
                        chart_complience('exi_chart_'+ux+'_1', '<p style="font-size:16px"><strong>One-Minute Chart :</strong> '+arr_param_all[ux].inputParam_desc+'</p>', 'Date : '+date_form, arr_param_all[ux].data_plot, '%');
                        var arr_param = arr_param_all[ux].data;
                        $('#exi_div_bar_'+ux).html('');
                        $.each(arr_param, function(u){
                            $('#exi_div_bar_'+ux).append('<h6 class="margin-bottom-5 padding-top-15">Stack '+arr_param[u].indAll_stackNo+'&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-primary btn-xs" title="Add to Compliance Monitoring" onclick="f_exi_addMonitor('+arr_param[u].indParam_id+');" id="exi_btn_addMonitor_'+arr_param[u].indParam_id+'"><i class="fa fa-desktop"></i></a>' +
                                '<a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Remove from Compliance Monitoring" onclick="f_exi_removeMonitor('+arr_param[u].indParam_id+');" id="exi_btn_removeMonitor_'+arr_param[u].indParam_id+'"><i class="fa fa-minus-square"></i></a>' +
                                '</h6>');
                            var sum_rows = parseInt(arr_param[u]['sum_rows']);
                            var total_rows = parseFloat(arr_param[u]['total_rows']);
                            var total_not_comply = parseInt(arr_param[u]['total_not_comply']);
                            var data_average = !isNaN(sum_rows/total_rows) ? parseFloat((sum_rows/total_rows).toFixed(3)) : 0;
                            var percent_average  = data_average / parseFloat(arr_param[u].indParam_limitValue) * 100;
                            percent_average = percent_average > 100 ? 100 : percent_average;
                            var index = 0;
                            $.each(opt_indAll_id, function(uw){
                                if (opt_indAll_id[uw].ref_id == arr_param[u].indAll_id)
                                    index = uw;
                            });  
                            var html_average = '<div class="bar-holder no-padding no-margin margin-bottom-5">' +
                                '<p class="margin-bottom-5">Daily Average : <i class="'+(data_average>parseFloat(arr_param[u].indParam_limitValue)?'exi_blink txt-color-red':'txt-color-blue')+' text-bold">'+formattedNumber(data_average,3)+'%</i> <span class="pull-right semi-bold text-muted">'+parseInt(arr_param[u].indParam_limitValue)+'%</span> ' +
                                '<div class="progress progress-sm progress-striped active">' + 
                                '<div class="progress-bar" style="width: '+percent_average+'%; background-color: '+color_set[index]+'"></div></div></div>';        
                            $('#exi_div_bar_'+ux).append(html_average);
                            var html_average = '<div class="bar-holder no-padding no-margin">' +
                                '<p class="margin-bottom-5">Total Data Received : <i class="'+(total_rows<1?'exi_blink txt-color-red':'txt-color-blue')+' text-bold">'+formattedNumber(total_rows)+'</i></br>Total Not Comply : <i class="'+(total_not_comply>0?'exi_blink txt-color-red':'txt-color-blue')+' text-bold"">'+formattedNumber(total_not_comply)+'</i> <span class="pull-right semi-bold text-muted">1,440</span></p>' +
                                '<div class="progress progress-sm progress-striped active">' + 
                                '<div class="progress-bar bg-color-red" style="width: '+(total_rows/1440*100)+'%"></div>' +
                                '<div class="progress-bar" style="width: '+((total_rows-total_not_comply)/1440*100)+'%; background-color: '+color_set[index]+'"></div></div></div>';        
                            $('#exi_div_bar_'+ux).append(html_average);
                            if (arr_param[u].monitor_status == '1') {
                                $('#exi_btn_addMonitor_'+arr_param[u].indParam_id).hide();
                                $('#exi_btn_removeMonitor_'+arr_param[u].indParam_id).show();
                            } else {                            
                                $('#exi_btn_addMonitor_'+arr_param[u].indParam_id).show();
                                $('#exi_btn_removeMonitor_'+arr_param[u].indParam_id).hide();
                            }
                        });
                    }
                });
                var data_30 = f_get_general_info_multiple('dt_30_minute', {}, {tablename:'z'+date_year+'_'+premise_no, 'data_timestamp':date_form}); 
                $.each(data_30, function(uv){
                    for(var ux=0;ux<arr_param_all.length;ux++){
                        var inputParam_id = arr_param_all[ux].inputParam_id;
                        if (parseInt(inputParam_id) < 8) {
                            var times = data_30[uv].thirtyHourInterval;
                            var data_hour = parseInt(times.substr(11,2));
                            var data_minute = parseInt(times.substr(14,2));
                            var data_index = (data_hour*60 + data_minute) / 30;
                            var stack_index = -1;
                            for(var uw=0;uw<arr_param_all[ux]['data'].length;uw++){
                                if (arr_param_all[ux]['data'][uw].indAll_stackNo == data_30[uv].stack_id) {
                                    stack_index = uw;
                                    break;
                                }                                    
                            }
                            if (stack_index != '-1') {    
                                var data_sum = parseFloat(data_30[uv]['sum_'+inputParam_id]);
                                var data_count = parseFloat(data_30[uv]['count_'+inputParam_id]);
                                if (data_count > 22 && data_sum != 0) {
                                    var data_value = data_sum/data_count;
                                    if (typeof arr_param_all[ux]['data_plot'][stack_index] !== 'undefined') {
                                        if (data_value > parseInt(2*(arr_param_all[ux]['data_plot'][stack_index]['indParam_limitValue']))) {
                                            arr_param_all[ux]['data_plot'][stack_index]['data'][data_index] = {
                                                x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), data_hour, data_minute),
                                                y: parseFloat(data_value.toFixed(3)),
                                                marker: { symbol: 'url(img/darkcloud.png)', height:35, width:45}
                                            };
                                            var total_not_comply = parseInt(arr_param_all[ux]['data'][stack_index]['total_not_comply']) + 1; 
                                            arr_param_all[ux]['data'][stack_index]['total_not_comply'] = total_not_comply;
                                        } else {
                                            arr_param_all[ux]['data_plot'][stack_index]['data'][data_index] = {
                                                x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), data_hour, data_minute),
                                                y: parseFloat(data_value.toFixed(3))
                                            };
                                        }      
                                        var total_rows = parseInt(arr_param_all[ux]['data'][stack_index]['total_rows']) + 1; 
                                        arr_param_all[ux]['data'][stack_index]['total_rows'] = total_rows;
                                        var sum_rows = parseFloat(arr_param_all[ux]['data'][stack_index]['sum_rows']) + data_value; 
                                        arr_param_all[ux]['data'][stack_index]['sum_rows'] = sum_rows;
                                    }
                                }   
                            }                                                                 
                        }                        
                    }    
                });
                $.each(arr_param_all, function(ux){
                    if (parseInt(arr_param_all[ux].inputParam_id) < 8) {
                        $('#exi_widget_'+ux).show();
                        $('#exi_widget_'+ux+'_title').html(wf_group.wfGroup_name+' : '+arr_param_all[ux].inputParam_desc);
                        chart_complience('exi_chart_'+ux+'_1', '<p style="font-size:16px"><strong>30-Minute Chart :</strong> '+arr_param_all[ux].inputParam_desc+'</p>', 'Date : '+date_form, arr_param_all[ux].data_plot, 'mg/m<sup>3</sup>');
                        var arr_param = arr_param_all[ux].data;
                        $('#exi_div_bar_'+ux).html('');
                        $.each(arr_param, function(u){
                            $('#exi_div_bar_'+ux).append('<h6 class="margin-bottom-5 padding-top-15">Stack '+arr_param[u].indAll_stackNo+'&nbsp;&nbsp;<a href="javascript:void(0);" class="btn btn-primary btn-xs" title="Add to Compliance Monitoring" onclick="f_exi_addMonitor('+arr_param[u].indParam_id+');" id="exi_btn_addMonitor_'+arr_param[u].indParam_id+'"><i class="fa fa-desktop"></i></a>' +
                                '<a href="javascript:void(0);" class="btn btn-danger btn-xs" title="Remove from Compliance Monitoring" onclick="f_exi_removeMonitor('+arr_param[u].indParam_id+');" id="exi_btn_removeMonitor_'+arr_param[u].indParam_id+'"><i class="fa fa-minus-square"></i></a>' +
                                '</h6>');
                            var sum_rows = parseInt(arr_param[u]['sum_rows']);
                            var total_rows = parseFloat(arr_param[u]['total_rows']);
                            var total_not_comply = parseInt(arr_param[u]['total_not_comply']);
                            var data_average = !isNaN(sum_rows/total_rows) ? parseFloat((sum_rows/total_rows).toFixed(3)) : 0;
                            var percent_average = data_average / parseFloat(arr_param[u].indParam_limitValue) * 100;
                            percent_average = percent_average > 100 ? 100 : percent_average;
                            var index = 0;
                            $.each(opt_indAll_id, function(uw){
                                if (opt_indAll_id[uw].ref_id == arr_param[u].indAll_id)
                                    index = uw;
                            });  
                            var html_average = '<div class="bar-holder no-padding no-margin margin-bottom-5">' +
                                '<p class="margin-bottom-5">Daily Average : <i class="'+(data_average>parseFloat(arr_param[u].indParam_limitValue)?'exi_blink txt-color-red':'txt-color-blue')+' text-bold">'+formattedNumber(data_average,3)+' mg/m<sup>3</sup></i> <span class="pull-right semi-bold text-muted">'+parseInt(arr_param[u].indParam_limitValue)+' mg/m<sup>3</sup></span></p>' +
                                '<div class="progress progress-sm progress-striped active">' + 
                                '<div class="progress-bar" style="width: '+percent_average+'%; background-color: '+color_set[index]+'"></div></div></div>';        
                            $('#exi_div_bar_'+ux).append(html_average);
                            var html_average = '<div class="bar-holder no-padding no-margin">' +
                                '<p class="margin-bottom-5">Total Data Received : <i class="'+(total_rows<1?'exi_blink txt-color-red':'txt-color-blue')+' text-bold">'+formattedNumber(total_rows)+'</i></br>Total Not Comply : <i class="'+(total_not_comply>0?'exi_blink txt-color-red':'txt-color-blue')+' text-bold">'+formattedNumber(total_not_comply)+'</i> <span class="pull-right semi-bold text-muted">48</span></p>' +
                                '<div class="progress progress-sm progress-striped active">' + 
                                '<div class="progress-bar bg-color-red" style="width: '+(total_rows/48*100)+'%"></div>' +
                                '<div class="progress-bar" style="width: '+((total_rows-total_not_comply)/48*100)+'%; background-color: '+color_set[index]+'"></div></div></div>';        
                            $('#exi_div_bar_'+ux).append(html_average);
                            
                            if (arr_param[u].monitor_status == '1') {
                                $('#exi_btn_addMonitor_'+arr_param[u].indParam_id).hide();
                                $('#exi_btn_removeMonitor_'+arr_param[u].indParam_id).show();
                            } else {                            
                                $('#exi_btn_addMonitor_'+arr_param[u].indParam_id).show();
                                $('#exi_btn_removeMonitor_'+arr_param[u].indParam_id).hide();
                            }
                        });
                    }
                });
                f_exi_stack_data(opt_indAll_id[0].ref_id);
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        });

    });
    
    function f_exi_data_listing(param_id, data, rows){
        var label = '-';
        if (data != null) {
            $.each(arr_param_all, function(ux){
                if (arr_param_all[ux].inputParam_id == param_id.toString()) {
                    var arr_param = arr_param_all[ux].data;
                    $.each(arr_param, function(uv){
                        if (arr_param[uv]['indAll_stackNo'] == rows.stack_id && arr_param[uv]['sum_rows'] != 0) {
                            var final_data = param_id < 8 ? parseFloat(rows['sum_'+param_id])/parseInt(rows['count_'+param_id]) : parseFloat(data);
                            var format_data = formattedNumber(final_data,3);
                            if (final_data <= 0)
                                label = '<b class="badge bg-color-pinkDark"> '+format_data+' </b>';
                            else if (final_data > exi_limit_value[param_id] && param_id >= 8)
                                label = '<b class="badge bg-coloWr-red"> '+format_data+' </b>';
                            else if (final_data > 2*exi_limit_value[param_id] && param_id <8)
                                label = '<b class="badge bg-color-red"> '+format_data+' </b>';
                            else 
                                label = format_data;
                        }
                    });
                }
            });
        }
        return label;
    }
    
    function f_exi_default_plot(inputParam_id, date_search){
        var data_plot = [];
        if (jQuery.inArray(inputParam_id, ['1', '2', '3', '4', '5', '6', '7']) >= 0) {
            for (var i=0; i<48; i++) {
                var j = (i%2==0)?0:30;
                data_plot[i] = {
                    x: Date.UTC(parseInt(date_search.substr(0,4)), parseInt(date_search.substr(5,2))-1, parseInt(date_search.substr(8,2)), Math.floor(i/2), j),
                    y: null
                };
            } 
        } else if (jQuery.inArray(inputParam_id, ['8', '9', '10']) >= 0) {
            for (var i=0; i<1440; i++) {
                data_plot[i] = {
                    x: Date.UTC(parseInt(date_search.substr(0,4)), parseInt(date_search.substr(5,2))-1, parseInt(date_search.substr(8,2)), Math.floor(i/60), i%60),
                    y: null
                };
            }
        }
        return data_plot;
    }
    
    function f_exi_stack_data (indAll_id) {
        var date_form = $('#exi_data_timestamp').val(); 
        $('#exi_div_bar_stack').html('');
        f_get_general_info('vw_pooling_selected_stack', {indAll_id:indAll_id}, 'exi');
        var date_year = date_form.substr(2,2);
        exi_limit_value = [0,0,0,0,0,0,0,0,0,0,0,0];
        var is_opa = false, is_data = false;   
        for (var i=1;i<8;i++) {
            data_exi.columns(i).visible(false);
        }        
        for (var i=1;i<=3;i++) {
            data_exi_opa.columns(i).visible(false);
        }
        industrial_param = f_get_general_info_multiple('vw_compliance_param_list', {indAll_id:indAll_id}, '', '', 'inputParam_id');
        $.each(industrial_param, function(u){ 
            if (industrial_param[u].inputParam_id >= '8') {
                is_opa = true;
                data_exi_opa.columns(parseInt(industrial_param[u].inputParam_id)-7).visible(true);
                $('#exi_tblheader_'+industrial_param[u].inputParam_id).html(formattedNumber(industrial_param[u].indParam_limitValue));
            } else {
                is_data = true;
                data_exi.columns(industrial_param[u].inputParam_id).visible(true);
                $('#exi_tblheader_'+industrial_param[u].inputParam_id).html(formattedNumber(industrial_param[u].indParam_limitValue));
            }
            exi_limit_value[parseInt(industrial_param[u].inputParam_id)] = industrial_param[u].indParam_limitValue;
        });  
        var indAll_stackNo = $("#exi_indAll_id option:selected").text();
        datas = '';
        if (is_data)
           datas = f_get_general_info_multiple('dt_data_30', {}, {short_year:date_year, data_date:date_form, indAll_stackNo:indAll_stackNo, premise_no:premise_no});
        f_dataTable_draw(data_exi, datas);
        datas = '';
        if (is_opa)
           datas = f_get_general_info_multiple('dt_data_01', {}, {short_year:date_year, data_date:date_form, indAll_stackNo:indAll_stackNo, premise_no:premise_no});
        f_dataTable_draw(data_exi_opa, datas);
    }
    
    function f_exi_link (link_id, wfFlow_id , link_type) {
        if (link_type == 'industrial') {
            if (wfFlow_id == '4')
                f_load_cems (3, '', link_id, 'exi');
            else if (wfFlow_id == '5')
                f_load_pems (3, '', link_id, 'exi');
        } else if (link_type == 'consultant') {
            if (wfFlow_id == '4')
                f_load_consultant_cems (3, '', link_id, 'exi');
            else if (wfFlow_id == '5')
                f_load_consultant_pems (3, '', link_id, 'exi');
        }
    }
    
    function f_exi_addMonitor (indParam_id) {
        if (f_submit_normal('add_monitor', {indParam_id: indParam_id}, 'p_pooling', 'Stack and Input Parameter successfully added to monitoring slot.')) {
            $('#exi_btn_addMonitor_'+indParam_id).hide();
            $('#exi_btn_removeMonitor_'+indParam_id).show();
        }
    }
    
    function f_exi_removeMonitor (indParam_id) {
        if (f_submit_normal('remove_monitor', {indParam_id: indParam_id}, 'p_pooling', 'Stack and Input Parameter successfully removed from monitoring slot.')) {
            $('#exi_btn_addMonitor_'+indParam_id).show();
            $('#exi_btn_removeMonitor_'+indParam_id).hide();
        }
    }
    
    function f_exi_blink() {
        if(shown) {
            $('.exi_blink').hide();
            shown = false;
        } else {
            $('.exi_blink').show();
            shown = true;
        }
    }
            
</script>