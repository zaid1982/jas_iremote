<?php 
include 'view/js/j_modal_pems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
include 'view/js/j_modal_change_consultant.php';
include 'view/js/j_modal_plan_test.php';
include 'view/js/j_modal_pems_rata.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $('#ipm_dateRegistered').daterangepicker({
            "showDropdowns": true,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            },
            "ranges": {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
        }).on('apply.daterangepicker', function (ev, picker) {
            var dateStart = picker.startDate.format('YYYYMMDD');
            var dateEnd = picker.endDate.format('YYYYMMDD');
            var filteredData = dataNew.column(6).data().filter(function (value, index) {
                var evalDate = 0;
                if (value !== null && value !== "") {
                    var dateArray = value.substr(0,10).split("-");
                    evalDate = dateArray[0] + dateArray[1] + dateArray[2];
                }
                if ((isNaN(dateStart) && isNaN(dateEnd)) || (evalDate >= dateStart && evalDate <= dateEnd)) {
                    return true;
                }
                return false;
            });
            var val = "";
            for (var count = 0; count < filteredData.length; count++) {
                val += filteredData[count] + "|";
            }
            val = val.slice(0, -1);
            dataNew.column(6).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            $('#ipm_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            $('#ipm_table_title').html('');
        }).val(''); 
        
        var datatable_ipm = undefined;  var cnt_ipm = 1;
        dataNew = $('#datatable_ipm').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_ipm) {
                    datatable_ipm = new ResponsiveDatatablesHelper($('#datatable_ipm'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_ipm.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_ipm.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_ipm)
                                cnt_ipm = 1;
                            if ( iColumn === 0 )
                                return cnt_ipm++;
                            else if ( iColumn === 7 )
                                return datas[iDataIndex].status_desc;
                            else if ( iColumn === 8 )
                                return '';
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
                            if (datas.length < cnt_ipm)
                                cnt_ipm = 1;
                            if ( iColumn === 0 )
                                return cnt_ipm++;
                            else if ( iColumn === 7 )
                                return datas[iDataIndex].status_desc;
                            else if ( iColumn === 8 )
                                return '';
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
                    {mData: 'wfTrans_no', mRender: function (data, type, row) { return row.wfTrans_regNo != null ? row.wfTrans_regNo : data; }},                  
                    {mData: 'indAll_stackNo'},
                    {mData: 'sourceActivity_desc'},
                    {mData: 'consultant_name'},
                    {mData: 'consPems_model'},
                    {mData: 'wfTrans_timeSubmit'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.status_id == '2') {    
                                $label = '<button type="button" class="btn btn-warning btn-xs" id="ipm_btn_edit" title="Edit" onclick="f_load_pems (2, '+row.wfGroup_id+', '+row.indAll_id+',\'ipm\');"><i class="fa fa-pencil"></i></button>';
                                $label += ' <button type="button" class="btn btn-danger btn-xs" id="ipm_btn_delete" title="Delete" onclick="f_delete_industrial_pems ('+row.wfTask_id+','+row.indAll_id+');"><i class="fa fa-minus"></i></button>';
                            } else {  
                                $label = '<button type="button" class="btn btn-info btn-xs" id="ipm_btn_info" title="Info" onclick="f_load_pems (3, '+row.wfGroup_id+', '+row.indAll_id+',\'ipm\');"><i class="fa fa-info-circle"></i></button>';
                                if (row.status_id == '1') {
                                    $label += ' <button type="button" class="btn btn-warning btn-xs" id="ipm_btn_change_consultant" title="Change Maintenance Consultant" onclick="f_load_change_consultant (1, '+row.wfTask_id+',\'ipm\');"><i class="fa fa-user-secret"></i></button>';
                                    $label += ' <button type="button" class="btn btn-danger btn-xs" id="ipm_btn_shutdown" data-toggle="popover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-pause\'></i> Shutdown" data-content="<form action=\'#\' ><div class=\'row padding-bottom-10\'><div class=\'col-md-3\'>Date From</div><div class=\'col-md-8\'><input type=\'date\' class=\'form-control\'  /></div></div><div class=\'row padding-bottom-10\'><div class=\'col-md-3\'>Date To</div><div class=\'col-md-8\'><input type=\'date\' class=\'form-control\'  /></div></div><div class=\'row\'><div class=\'col-md-3\'>Reason</div><div class=\'col-md-8\'><textarea rows=\'4\' class=\'form-control\'></textarea></div></div></br><div class=\'form-actions\'><div class=\'row\'><div class=\'col-md-12\'><button class=\'btn btn-primary btn-sm\' type=\'button\' onclick=\'f_shutdown_submit();\'>Submit</button></div></div></div></form>" data-html="true"><i class="fa fa-pause"></i></button>';
                                } else if (row.status_id == '22') {    
                                    $label = '<button type="button" class="btn btn-warning btn-xs" id="cca_btn_edit" title="Revise" onclick="f_load_pems (2, '+row.wfGroup_id+', '+row.indAll_id+',\'ipm\');"><i class="fa fa-pencil-square-o"></i></button> ';
                                } else if (row.status_id == '27') {
                                    $label += ' <button type="button" class="btn btn-success btn-xs" title="Plan Initial RATA Test" onclick="f_load_plan_test (1, '+row.wfTask_id+',\'ipm\');"><i class="fa fa-mail-forward"></i></button>';
                                } else if (jQuery.inArray(row.status_id, ['28', '47']) >= 0) {
                                    $label += ' <button type="button" class="btn btn-warning btn-xs" title="PEMS Initial RATA Test Report" onclick="f_load_pems_rata (2, \'\', '+row.wfTask_id+',\'ipm\');"><i class="fa fa-file-text-o"></i></button>';
                                } else if (jQuery.inArray(row.status_id, ['29', '30']) >= 0) {
                                    $label += ' <button type="button" class="btn btn-warning btn-xs" title="PEMS Initial RATA Test Report" onclick="f_load_pems_rata (3, \'\', '+row.wfTask_id+',\'ipm\');"><i class="fa fa-file-text-o"></i></button>';
                                }
                            }
                            return $label;
                        }
                    }
                ]
        });        
        //filter
        $("#datatable_ipm thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_ipm thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_ipm thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });          
        $('#datatable_ipm').on('draw.dt', function () {
            $('#ipm_btn_shutdown').popover().click(function(e) {
                $('#ipm_btn_shutdown').not(this).popover('hide');
                $(this).popover('toggle');
            });
        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#ipm_wfGroup_id').val(wf_group.wfGroup_id);
            f_ipm_set_alert();
            f_table_ipm();   
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
                                
    });
    
    function f_shutdown_submit() {        
        $('#ipm_btn_shutdown').popover('hide');
    }
    
    function f_table_ipm () {
        datas = f_get_general_info_multiple('dt_industrial_all', {indAll_type:'2', wfGroup_id:$('#ipm_wfGroup_id').val()!=''?$('#ipm_wfGroup_id').val():' '});
        f_dataTable_draw(dataNew, datas, 'datatable_ipm', 9);
    }    
    
    function f_delete_industrial_pems (wfTask_id, indAll_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit(wfTask_id, '41', '14', 'Draft data successfully deleted.', '', '2', '', '', 'indAll_id', indAll_id)) {                        
                f_table_ipm ();
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
    function f_ipm_set_alert() {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', $('#ipm_wfGroup_id').val(), 'wfGroup_isFirstTime');         
        if (isFirstTime == '1') {
            $('#ipm_alert').removeClass('hide');
            $('#ipm_btn_upd_ind').removeClass('hide');
            $('#ipm_alert_txt').html('You are 1st time login as <strong>Industrial Premise</strong>. Please complete the <strong>Industrial Information</strong> first before proceed to registration.');
        } else {
            $('#ipm_info_register').removeClass('hide');
        }        
    }
            
</script>