<?php
include 'view/js/j_modal_response.php';
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
?>
<script type="text/javascript">  
    
    var industrial_id;
    var data_ipf_new;
    var data_ipf_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#ipf_datePooling').daterangepicker({
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
            var filteredData = dataNew.column(5).data().filter(function (value, index) {
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
            dataNew.column(5).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_ipf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(5).search('').draw();
            f_table_ipf_title ();
        }).val(''); 
        
        $('#ipf_dateReceived').daterangepicker({
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
            f_table_ipf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_ipf_title ();
        }).val('');
        
        $('#ipf_datePooling2').daterangepicker({
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
            var filteredData = dataHistory.column(5).data().filter(function (value, index) {
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
            dataHistory.column(5).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_ipf_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(5).search('').draw();
            f_table_ipf_title2 ();
        }).val(''); 
        
        $('#ipf_dateClose').daterangepicker({
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
            var filteredData = dataHistory.column(6).data().filter(function (value, index) {
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
            dataHistory.column(6).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_ipf_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_ipf_title2 ();
        }).val(''); 
        
        var datatable_ipf = undefined;  var cnt_ipf = 1;
        dataNew = $('#datatable_ipf').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_ipf) {
                    datatable_ipf = new ResponsiveDatatablesHelper($('#datatable_ipf'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_ipf.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_ipf.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_ipf_new.length < cnt_ipf)
                                cnt_ipf = 1;
                            if ( iColumn === 0 )
                                return cnt_ipf++;
                            else if ( iColumn === 7 )
                                return (data_ipf_new[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
                            else if ( iColumn === 8 )
                                return data_ipf_new[iDataIndex].status_desc;
                            else if ( iColumn === 9 )
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
                            if (data_ipf_new.length < cnt_ipf)
                                cnt_ipf = 1;
                            if ( iColumn === 0 )
                                return cnt_ipf++;
                            else if ( iColumn === 7 )
                                return (data_ipf_new[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
                            else if ( iColumn === 8 )
                                return data_ipf_new[iDataIndex].status_desc;
                            else if ( iColumn === 9 )
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
                    {mData: 'wfTrans_regNo'},
                    {mData: 'ind_regNo'},
                    {mData: 'indAll_stackNo'},
                    {mData: 'inputParam_desc'},
                    {mData: 'response_dates'},
                    {mData: 'response_timeCreated'},
                    {mData: 'response_dataReceived',   // manually count result
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+(data=='0'?'red':'orange')+'"> '+(data=='0'?'Empty':'Incomplete')+' </b>';
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = row.indAll_type == '1' ? 'cems':'pems';
                            var modal_loadType = row.wfTask_partition == '1' && row.wfTaskUser_id != null ? '2':'3';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="ipf_btn_info" title="Industrial Info" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'ipf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="ipf_btn_response" title="Industrial Response" onclick="f_load_mre ('+modal_loadType+', '+row.response_id+', '+row.wfTask_id+',\'ipf\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_ipf thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_ipf thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_ipf thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });    
        
        var datatable_ipf2 = undefined;  var cnt_ipf2 = 1;
        dataHistory = $('#datatable_ipf2').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_ipf2) {
                    datatable_ipf2 = new ResponsiveDatatablesHelper($('#datatable_ipf2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_ipf2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_ipf2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_ipf_history.length < cnt_ipf2)
                                cnt_ipf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_ipf2++;
                            else if ( iColumn === 7 )
                                return (data_ipf_history[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
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
                            if (data_ipf_history.length < cnt_ipf2)
                                cnt_ipf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_ipf2++;
                            else if ( iColumn === 7 )
                                return (data_ipf_history[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
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
                    {mData: 'wfTrans_regNo'},
                    {mData: 'ind_regNo'},
                    {mData: 'indAll_stackNo'},
                    {mData: 'inputParam_desc'},
                    {mData: 'response_dates'},
                    {mData: 'wfTask_timeCreated'},
                    {mData: 'response_dataReceived',   // manually count result
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+(data=='0'?'red':'orange')+'"> '+(data=='0'?'Empty':'Incomplete')+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = row.indAll_type == '1' ? 'cems':'pems';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="ipf_btn_info" title="Industrial Info" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'ipf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="ipf_btn_response" title="Industrial Response" onclick="f_load_mre (3, '+row.response_id+', '+row.wfTask_id+',\'ipf\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_ipf2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_ipf2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_ipf2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });     
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            industrial_id = f_get_value_from_table('t_industrial', 'wfGroup_id', wf_group_user.wfGroup_id, 'industrial_id');
            f_table_ipf_new ();
            f_table_ipf_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');

    });
    
    function f_table_ipf_new () {
        data_ipf_new = f_get_general_info_multiple('dt_fail_response_list', {industrial_id:industrial_id, wfTaskType_id:'(52,53)'});
        f_dataTable_draw(dataNew, data_ipf_new, 'datatable_ipf', 10);
    }
    
    function f_table_ipf_history () {
        data_ipf_history = f_get_general_info_multiple('dt_fail_response_list', {industrial_id:industrial_id, wfTaskType_id:'54'});
        f_dataTable_draw(dataHistory, data_ipf_history, 'datatable_ipf2', 9);
    }
    
    function f_table_ipf_title () {
        var txt_title = '';
        if ($('#ipf_datePooling').val() != '') {
            txt_title = 'Pooling Date : '+$('#ipf_datePooling').val();
            if ($('#ipf_dateReceived').val() != '') 
                txt_title += ', Received Date : '+$('#ipf_dateReceived').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#ipf_dateReceived').val() != '') 
                txt_title += '<i>(Received Date : '+$('#ipf_dateReceived').val()+')</i>';
        }
        $('#ipf_table_title').html(txt_title);
    }
    
    function f_table_ipf_title2 () {
        var txt_title = '';
        if ($('#ipf_datePooling2').val() != '') {
            txt_title = 'Pooling Date : '+$('#ipf_datePooling2').val();
            if ($('#ipf_dateClose').val() != '') 
                txt_title += ', Received Date : '+$('#ipf_dateClose').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#ipf_dateClose').val() != '') 
                txt_title += '<i>(Received Date : '+$('#ipf_dateClose').val()+')</i>';
        }
        $('#ipf_table_title2').html(txt_title);
    }
                   
</script>