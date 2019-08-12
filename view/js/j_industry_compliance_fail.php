<?php
include 'view/js/j_modal_response.php';
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
?>
<script type="text/javascript">  
    
    var industrial_id;
    var data_icf_new;
    var data_icf_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#icf_datePooling').daterangepicker({
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
            f_table_icf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(5).search('').draw();
            f_table_icf_title ();
        }).val(''); 
        
        $('#icf_dateReceived').daterangepicker({
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
            f_table_icf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_icf_title ();
        }).val('');
        
        $('#icf_datePooling2').daterangepicker({
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
            f_table_icf_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(5).search('').draw();
            f_table_icf_title2 ();
        }).val(''); 
        
        $('#icf_dateClose').daterangepicker({
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
            f_table_icf_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_icf_title2 ();
        }).val(''); 
        
        var datatable_icf = undefined;  var cnt_icf = 1;
        dataNew = $('#datatable_icf').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_icf) {
                    datatable_icf = new ResponsiveDatatablesHelper($('#datatable_icf'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_icf.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_icf.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_icf_new.length < cnt_icf)
                                cnt_icf = 1;
                            if ( iColumn === 0 )
                                return cnt_icf++;
                           else if ( iColumn === 8 )
                                return data_icf_new[iDataIndex].status_desc;
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
                            if (data_icf_new.length < cnt_icf)
                                cnt_icf = 1;
                            if ( iColumn === 0 )
                                return cnt_icf++;
                            else if ( iColumn === 8 )
                                return data_icf_new[iDataIndex].status_desc;
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
                    {mData: 'response_date'},
                    {mData: 'response_timeCreated'},
                    {mData: 'complianceType_desc'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = row.indAll_type == '1' ? 'cems':'pems';
                            var modal_loadType = row.wfTask_partition == '1' && row.wfTaskUser_id != null ? '2':'3';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="icf_btn_info" title="Industrial Info" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'icf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="icf_btn_response" title="Industrial Response" onclick="f_load_mre ('+modal_loadType+', '+row.response_id+', '+row.wfTask_id+',\'icf\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_icf thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_icf thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_icf thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });    
        
        var datatable_icf2 = undefined;  var cnt_icf2 = 1;
        dataHistory = $('#datatable_icf2').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_icf2) {
                    datatable_icf2 = new ResponsiveDatatablesHelper($('#datatable_icf2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_icf2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_icf2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_icf_history.length < cnt_icf2)
                                cnt_icf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_icf2++;
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
                            if (data_icf_history.length < cnt_icf2)
                                cnt_icf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_icf2++;
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
                    {mData: 'response_date'},
                    {mData: 'wfTask_timeCreated'},
                    {mData: 'complianceType_desc'},
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = row.indAll_type == '1' ? 'cems':'pems';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="icf_btn_info" title="Industrial Info" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'icf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="icf_btn_response" title="Industrial Response" onclick="f_load_mre (3, '+row.response_id+', '+row.wfTask_id+',\'icf\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_icf2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_icf2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_icf2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });     
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            industrial_id = f_get_value_from_table('t_industrial', 'wfGroup_id', wf_group_user.wfGroup_id, 'industrial_id');
            f_table_icf_new ();
            f_table_icf_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');

    });
    
    function f_table_icf_new () {
        data_icf_new = f_get_general_info_multiple('dt_fail_response_list', {industrial_id:industrial_id, wfTaskType_id:'(62,63)'});
        f_dataTable_draw(dataNew, data_icf_new, 'datatable_icf', 10);
    }
    
    function f_table_icf_history () {
        data_icf_history = f_get_general_info_multiple('dt_fail_response_list', {industrial_id:industrial_id, wfTaskType_id:'64'});
        f_dataTable_draw(dataHistory, data_icf_history, 'datatable_icf2', 9);
    }
    
    function f_table_icf_title () {
        var txt_title = '';
        if ($('#icf_datePooling').val() != '') {
            txt_title = 'Pooling Date : '+$('#icf_datePooling').val();
            if ($('#icf_dateReceived').val() != '') 
                txt_title += ', Received Date : '+$('#icf_dateReceived').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#icf_dateReceived').val() != '') 
                txt_title += '<i>(Received Date : '+$('#icf_dateReceived').val()+')</i>';
        }
        $('#icf_table_title').html(txt_title);
    }
    
    function f_table_icf_title2 () {
        var txt_title = '';
        if ($('#icf_datePooling2').val() != '') {
            txt_title = 'Pooling Date : '+$('#icf_datePooling2').val();
            if ($('#icf_dateClose').val() != '') 
                txt_title += ', Received Date : '+$('#icf_dateClose').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#icf_dateClose').val() != '') 
                txt_title += '<i>(Received Date : '+$('#icf_dateClose').val()+')</i>';
        }
        $('#icf_table_title2').html(txt_title);
    }
                   
</script>