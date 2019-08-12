<?php
include 'view/js/j_modal_qnf.php';
?>
<script type="text/javascript">  

    var data_qff_new;
    var data_qff_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#qff_dateReceived').daterangepicker({
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
            f_table_qff_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(5).search('').draw();
            f_table_qff_title ();
        }).val(''); 
        
        $('#qff_dateDue').daterangepicker({
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
            f_table_qff_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_qff_title ();
        }).val(''); 
        
        var datatable_qff = undefined;  var cnt_qff = 1;
        dataNew = $('#datatable_qff').DataTable({
            "aaSorting": [[5,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_qff) {
                    datatable_qff = new ResponsiveDatatablesHelper($('#datatable_qff'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qff.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qff.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_qff_new.length < cnt_qff)
                                cnt_qff = 1;
                            if ( iColumn === 0 )
                                return cnt_qff++;
                            else if ( iColumn === 3 )
                                return data_qff_new[iDataIndex].qnf_postType=='1'?'Internal':'External';
                            else if ( iColumn === 6 )
                                return data_qff_new[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 7 )
                                return data_qff_new[iDataIndex].action_desc;
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
                            if (data_qff_new.length < cnt_qff)
                                cnt_qff = 1;
                            if ( iColumn === 0 )
                                return cnt_qff++;
                            else if ( iColumn === 3 )
                                return data_qff_new[iDataIndex].qnf_postType=='1'?'Internal':'External';
                            else if ( iColumn === 6 )
                                return data_qff_new[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 7 )
                                return data_qff_new[iDataIndex].action_desc;
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
                    {mData: 'qnfCate_desc'},
                    {mData: 'qnf_postType',
                        mRender: function (data, type, row) {                            
                            return data=='1'?'Internal':'External';
                        }
                    },
                    {mData: 'qnf_title'},
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
                    {mData: 'action_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.action_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-success btn-xs" id="qff_btn_info" title="Query and Feedback" onclick="f_load_qnf (2, '+row.qnf_id+', '+row.wfTask_id+',\'qff\');"><i class="fa fa-comments-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_qff thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        
        $('#qff_dateSubmit2').daterangepicker({
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
            f_table_qff_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(5).search('').draw();
            f_table_qff_title2 ();
        }).val(''); 
        
        $('#qff_dateDue2').daterangepicker({
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
            f_table_qff_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_qff_title2 ();
        }).val('');     
        
        var datatable_qff2 = undefined;  var cnt_qff2 = 1;
        dataHistory = $('#datatable_qff2').DataTable({
            "aaSorting": [[5,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_qff2) {
                    datatable_qff2 = new ResponsiveDatatablesHelper($('#datatable_qff2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qff2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qff2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_qff_history.length < cnt_qff2)
                                cnt_qff2 = 1;
                            if ( iColumn === 0 )
                                return cnt_qff++;
                            else if ( iColumn === 3 )
                                return data_qff_history[iDataIndex].qnf_postType=='1'?'Internal':'External';
                            else if ( iColumn === 6 )
                                return data_qff_history[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 7 )
                                return data_qff_history[iDataIndex].action_desc;
                            else if ( iColumn === 8 )
                                return data_qff_history[iDataIndex].status_desc;
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
                            if (data_qff_history.length < cnt_qff2)
                                cnt_qff2 = 1;
                            if ( iColumn === 0 )
                                return cnt_qff++;
                            else if ( iColumn === 3 )
                                return data_qff_history[iDataIndex].qnf_postType=='1'?'Internal':'External';
                            else if ( iColumn === 6 )
                                return data_qff_history[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 7 )
                                return data_qff_history[iDataIndex].action_desc;
                            else if ( iColumn === 8 )
                                return data_qff_history[iDataIndex].status_desc;
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
                    {mData: 'qnfCate_desc'},
                    {mData: 'qnf_postType',
                        mRender: function (data, type, row) {                            
                            return data=='1'?'Internal':'External';
                        }
                    },
                    {mData: 'qnf_title'},
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
                    {mData: 'action_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.action_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="qff_btn_info" title="Query and Feedback" onclick="f_load_qnf (3, '+row.qnf_id+', '+row.wfTask_id+',\'qff\');"><i class="fa fa-comments-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_qff2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            f_table_qff_new ();
            f_table_qff_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
        
    });
    
    function f_table_qff_new () {
        data_qff_new = f_get_general_info_multiple('dt_qnf_task', {wfTaskType_id:'74', wfTask_partition:'1', wfTask_claimedBy:$('#user_id').val()});
        f_dataTable_draw(dataNew, data_qff_new, 'datatable_qff', 9);
    }
    
    function f_table_qff_history () {
        data_qff_history = f_get_general_info_multiple('dt_qnf_task', {wfTaskType_id:'74', wfTask_partition:'2', wfTask_claimedBy:$('#user_id').val()});
        f_dataTable_draw(dataHistory, data_qff_history, 'datatable_qff2', 10);
    }
    
    function f_table_qff_title () {
        var txt_title = '';
        if ($('#qff_dateReceived').val() != '') {
            txt_title = 'Received Date : '+$('#qff_dateReceived').val();
            if ($('#qff_dateDue').val() != '') 
                txt_title += ', Due Date : '+$('#qff_dateDue').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#qff_dateDue').val() != '') 
                txt_title += '<i>(Due Date : '+$('#qff_dateDue').val()+')</i>';
        }
        $('#qff_table_title').html(txt_title);
    }
    
    function f_table_qff_title2 () {
        if ($('#qff_dateSubmit2').val() != '') {
            txt_title = 'Received Date : '+$('#qff_dateSubmit2').val();
            if ($('#qff_dateDue2').val() != '') 
                txt_title += ', Due Date : '+$('#qff_dateDue2').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#qff_dateDue2').val() != '') 
                txt_title += '<i>(Due Date : '+$('#qff_dateDue2').val()+')</i>';
        }
        $('#qff_table_title2').html(txt_title);
    }
            
</script>