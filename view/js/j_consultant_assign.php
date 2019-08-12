<?php
include 'view/js/j_modal_consultant_cems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
include 'view/js/j_modal_action.php';
?>

<script type="text/javascript">  
    
    var data_ctf_new;
    var data_ctf_history;
    
    $(document).ready(function () {
        
        pageSetUp();
               
        $('#ctf_dateReceived').daterangepicker({
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
            f_table_ctf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_ctf_title ();
        }).val('');
        
        $('#ctf_dateDue').daterangepicker({
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
            var filteredData = dataNew.column(7).data().filter(function (value, index) {
                var evalDate = 0;
                if (value !== null && value !== "") {
                    var dateArray = data_ctf_new[index].wfTask_dateExpired.substr(0,10).split("-");
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
            dataNew.column(7).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw();     
            f_table_ctf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(7).search('').draw();
            f_table_ctf_title ();
        }).val('');
        
        var datatable_ctf = undefined;  var cnt_ctf = 1;
        dataNew = $('#datatable_ctf').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_ctf) {
                    datatable_ctf = new ResponsiveDatatablesHelper($('#datatable_ctf'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_ctf.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_ctf.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_ctf_new.length < cnt_ctf)
                                cnt_ctf = 1;
                            if ( iColumn === 0 )
                                return cnt_ctf++;
                            else if ( iColumn === 7 )
                                return data_ctf_new[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 8 )
                                return data_ctf_new[iDataIndex].status_desc;
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
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (data_ctf_new.length < cnt_ctf)
                                cnt_ctf = 1;
                            if ( iColumn === 0 )
                                return cnt_ctf++;
                            else if ( iColumn === 7 )
                                return data_ctf_new[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 8 )
                                return data_ctf_new[iDataIndex].status_desc;
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
                    {mData: 'wfTrans_no', mRender: function (data, type, row) { return row.wfTrans_regNo != null ? row.wfTrans_regNo : data; }},                  
                    {mData: 'wfFlow_desc'},
                    {mData: 'wfGroup_name'},
                    {mData: 'wfGroup_regNo'},
                    {mData: 'cons_type'},
                    {mData: 'wfTask_timeCreated'},
                    {mData: 'wfTask_dateExpired',
                        mRender: function (data, type, row) {
                            $label = data;
                            if (parseInt(row.datediff) > 0) {
                                if (row.wfExcuse_desc != null)
                                    $label = '<b class="badge bg-color-orange" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="Still need deeper checking." data-html="true">' + data + '</b>';
                                else
                                    $label = '<b class="badge bg-color-red" data-toggle="popover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="<form action=\'#\' ><div class=\'row\'><div class=\'col-md-11\'><textarea rows=\'4\' class=\'form-control\'></textarea></div></div></br><div class=\'form-actions\'><div class=\'row\'><div class=\'col-md-12\'><button class=\'btn btn-primary btn-sm\' type=\'button\'>Submit</button></div></div></div></form>" data-html="true">' + data + '</b>';
                            }
                            return $label;
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.wfFlow_id == '1')       modal_open = 'cems';
                            else if (row.wfFlow_id == '2')  modal_open = 'pems';
                            else if (row.wfFlow_id == '3')  modal_open = 'mobile';
                            else return '';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="ctf_btn_info" title="Application Information" onclick="f_load_consultant_'+modal_open+' (3, \'\', '+row.wfTask_refValue+',\'ctf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += ' <button type="button" class="btn btn-success btn-xs" id="ctf_btn_edit" title="Assign Application" onclick="f_load_action (2, '+row.wfTask_id+',\'ctf\');"><i class="fa fa-mail-forward"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $('#datatable_ctf').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        $("#datatable_ctf thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_ctf thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_ctf thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
                
        $('#ctf2_dateSubmit').daterangepicker({
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
            var filteredData = dataHistory.column(7).data().filter(function (value, index) {
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
            dataHistory.column(7).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_ctf2_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(7).search('').draw();
            f_table_ctf2_title ();
        }).val('');
        
        $('#ctf2_dateDue').daterangepicker({
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
            var filteredData = dataHistory.column(8).data().filter(function (value, index) {
                var evalDate = 0;
                if (value !== null && value !== "") {
                    var dateArray = data_ctf_history[index].wfTask_dateExpired.substr(0,10).split("-");
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
            dataHistory.column(8).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw();     
            f_table_ctf2_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(8).search('').draw();
            f_table_ctf2_title ();
        }).val('');
        
        var datatable_ctf2 = undefined;  var cnt_ctf2 = 1;
        dataHistory = $('#datatable_ctf2').DataTable({
            "aaSorting": [[7,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_ctf2) {
                    datatable_ctf2 = new ResponsiveDatatablesHelper($('#datatable_ctf2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_ctf2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_ctf2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_ctf_history.length < cnt_ctf2)
                                cnt_ctf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_ctf2++;
                            else if ( iColumn === 8 )
                                return data_ctf_history[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 9 )
                                return data_ctf_history[iDataIndex].status_desc;
                            else if ( iColumn === 10 )
                                return '';
                            return sValue;
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (data_ctf_history.length < cnt_ctf2)
                                cnt_ctf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_ctf2++;
                            else if ( iColumn === 8 )
                                return data_ctf_history[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 9 )
                                return data_ctf_history[iDataIndex].status_desc;
                            else if ( iColumn === 10 )
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
                    {mData: 'wfFlow_desc'},
                    {mData: 'wfGroup_name'},
                    {mData: 'wfGroup_regNo'},
                    {mData: 'cons_type'},
                    {mData: 'profile_name'},
                    {mData: 'wfTask_timeSubmitted'},
                    {mData: 'wfTask_dateExpired',
                        mRender: function (data, type, row) {
                            $label = data;
                            if (parseInt(row.datediff) > 0) {
                                if (row.wfExcuse_desc != null)
                                    $label = '<b class="badge bg-color-orange" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="Still need deeper checking." data-html="true">' + data + '</b>';
                                else
                                    $label = '<b class="badge bg-color-red" data-toggle="popover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="<form action=\'#\' ><div class=\'row\'><div class=\'col-md-11\'><textarea rows=\'4\' class=\'form-control\'></textarea></div></div></br><div class=\'form-actions\'><div class=\'row\'><div class=\'col-md-12\'><button class=\'btn btn-primary btn-sm\' type=\'button\'>Submit</button></div></div></div></form>" data-html="true">' + data + '</b>';
                            }
                            return $label;
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.wfFlow_id == '1')       modal_open = 'cems';
                            else if (row.wfFlow_id == '2')  modal_open = 'pems';
                            else if (row.wfFlow_id == '3')  modal_open = 'mobile';
                            else return '';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="ctf_btn_info" title="Application Information" onclick="f_load_consultant_'+modal_open+' (3, \'\', '+row.wfTask_refValue+',\'ctf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += ' <button type="button" class="btn btn-warning btn-xs" title="Transaction History" onclick="f_load_action (3, '+row.wfTask_id+',\'ctf\');"><i class="fa fa-history"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $('#datatable_ctf2').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        $("#datatable_ctf2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_ctf2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_ctf2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        $('#modal_waiting').on('shown.bs.modal', function(e){ 
            f_table_ctf_new ();
            f_table_ctf_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  

    });
    
    function f_table_ctf_new () {
        data_ctf_new = f_get_general_info_multiple('dt_task_consultant', {wfTaskType_id:'(2,12,22)', wfTask_partition:'1'});
        f_dataTable_draw(dataNew, data_ctf_new, 'datatable_ctf', 10);
    }
    
    function f_table_ctf_history () {
        data_ctf_history = f_get_general_info_multiple('dt_task_consultant', {wfTaskType_id:'(2,12,22)', wfTask_partition:'2'});
        f_dataTable_draw(dataHistory, data_ctf_history, 'datatable_ctf2', 11);
    }
    
    function f_table_ctf_title () {
        var txt_title = '';
        if ($('#ctf_dateReceived').val() != '') {
            txt_title = 'Received Date : '+$('#ctf_dateReceived').val();
            if ($('#ctf_dateDue').val() != '') 
                txt_title += ', Due Date : '+$('#ctf_dateDue').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#ctf_dateDue').val() != '') 
                txt_title += '<i>(Due Date : '+$('#ctf_dateDue').val()+')</i>';
        }
        $('#ctf_table_title').html(txt_title);
    }
    
    function f_table_ctf2_title () {
        var txt_title = '';
        if ($('#ctf2_dateSubmit').val() != '') {
            txt_title = 'Received Date : '+$('#ctf2_dateSubmit').val();
            if ($('#ctf2_dateDue').val() != '') 
                txt_title += ', Due Date : '+$('#ctf2_dateDue').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#ctf2_dateDue').val() != '') 
                txt_title += '<i>(Due Date : '+$('#ctf2_dateDue').val()+')</i>';
        }
        $('#ctf2_table_title').html(txt_title);
    }
            
</script>