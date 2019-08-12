<?php 
include 'view/js/j_modal_consultant_cems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
include 'view/js/j_modal_renew_cert.php';
?>
<script type="text/javascript">  
    
    var data_cvc_new;
    var data_cvc_history;
    
    $(document).ready(function () {
        
        pageSetUp();
               
        $('#cvc_dateReceived').daterangepicker({
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
            dataNew.column(7).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_cvc_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(7).search('').draw();
            f_table_cvc_title ();
        }).val('');
        
        $('#cvc_dateDue').daterangepicker({
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
            var filteredData = dataNew.column(8).data().filter(function (value, index) {
                var evalDate = 0;
                if (value !== null && value !== "") {
                    var dateArray = data_cvc_new[index].wfTask_dateExpired.substr(0,10).split("-");
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
            dataNew.column(8).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw();     
            f_table_cvc_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(8).search('').draw();
            f_table_cvc_title ();
        }).val('');
        
        $('#cvc_dateExpiry').daterangepicker({
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
                    var dateArray = data_cvc_new[index].certificate_dateExpired.substr(0,10).split("-");
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
            f_table_cvc_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_cvc_title ();
        }).val('');
        
        var datatable_cvc = undefined;  var cnt_cvc = 1;
        dataNew = $('#datatable_cvc').DataTable({
            "aaSorting": [[7,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cvc) {
                    datatable_cvc = new ResponsiveDatatablesHelper($('#datatable_cvc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cvc.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cvc.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_cvc_new.length < cnt_cvc)
                                cnt_cvc = 1;
                            if ( iColumn === 0 )
                                return cnt_cvc++;
                            else if ( iColumn === 6 )
                                return data_cvc_new[iDataIndex].certificate_dateExpired;
                            else if ( iColumn === 8 )
                                return data_cvc_new[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 9 )
                                return data_cvc_new[iDataIndex].status_desc;
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
                            if (data_cvc_new.length < cnt_cvc)
                                cnt_cvc = 1;
                            if ( iColumn === 0 )
                                return cnt_cvc++;
                            else if ( iColumn === 6 )
                                return data_cvc_new[iDataIndex].certificate_dateExpired;
                            else if ( iColumn === 8 )
                                return data_cvc_new[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 9 )
                                return data_cvc_new[iDataIndex].status_desc;
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
                    {mData: 'wfGroup_name'},
                    {mData: 'model_no'},
                    {mData: 'certificate_no'},
                    {mData: 'certIssuer_desc'},
                    {mData: 'certificate_dateExpired',
                        mRender: function (data, type, row) {
                            $label = data;
                            if (parseInt(row.certdiff) > 0) {
                                $label = '<b class="badge bg-color-red">' + data + '</b>';
                            }
                            return $label;
                        }
                    },
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
                            if (row.consAll_type == '1')       modal_open = 'cems';
                            else if (row.consAll_type == '3')  modal_open = 'mobile';
                            else return '';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="cvc_btn_info" title="Application Information" onclick="f_load_consultant_'+modal_open+' (3, \'\', '+row.consAll_id+',\'cvc\');"><i class="fa fa-info-circle"></i></button>';
                            $label += ' <button type="button" class="btn btn-success btn-xs" id="cvc_btn_edit" title="Process Certificate Renewal" onclick="f_load_renew_cert (2, '+row.wfTask_refValue+', '+row.wfTask_id+',\'cvc\');"><i class="fa fa-mail-forward"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $('#datatable_cvc').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        $("#datatable_cvc thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cvc thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
                
        $('#cvc2_dateSubmit').daterangepicker({
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
            f_table_cvc2_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(7).search('').draw();
            f_table_cvc2_title ();
        }).val('');
        
        $('#cvc2_dateDue').daterangepicker({
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
                    var dateArray = data_cvc_history[index].wfTask_dateExpired.substr(0,10).split("-");
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
            f_table_cvc2_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(8).search('').draw();
            f_table_cvc2_title ();
        }).val('');
        
        $('#cvc2_dateExpiry').daterangepicker({
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
                    var dateArray = dataHistory[index].certificate_dateExpired.substr(0,10).split("-");
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
            f_table_cvc2_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_cvc2_title ();
        }).val('');
        
        var datatable_cvc2 = undefined;  var cnt_cvc2 = 1;
        dataHistory = $('#datatable_cvc2').DataTable({
            "aaSorting": [[7,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cvc2) {
                    datatable_cvc2 = new ResponsiveDatatablesHelper($('#datatable_cvc2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cvc2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cvc2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_cvc_history.length < cnt_cvc2)
                                cnt_cvc2 = 1;
                            if ( iColumn === 0 )
                                return cnt_cvc2++;
                            else if ( iColumn === 6 )
                                return data_cvc_history[iDataIndex].certificate_dateExpired;
                            else if ( iColumn === 8 )
                                return data_cvc_history[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 9 )
                                return data_cvc_history[iDataIndex].status_desc;
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
                            if (data_cvc_history.length < cnt_cvc2)
                                cnt_cvc2 = 1;
                            if ( iColumn === 0 )
                                return cnt_cvc2++;
                            else if ( iColumn === 6 )
                                return data_cvc_history[iDataIndex].certificate_dateExpired;
                            else if ( iColumn === 8 )
                                return data_cvc_history[iDataIndex].wfTask_dateExpired;
                            else if ( iColumn === 9 )
                                return data_cvc_history[iDataIndex].status_desc;
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
                    {mData: 'wfGroup_name'},
                    {mData: 'model_no'},
                    {mData: 'certificate_no'},
                    {mData: 'certIssuer_desc'},
                    {mData: 'certificate_dateExpired'},                    
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
                            if (row.consAll_type == '1')       modal_open = 'cems';
                            else if (row.consAll_type == '3')  modal_open = 'mobile';
                            else return '';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="cvc_btn_info" title="Application Information" onclick="f_load_consultant_'+modal_open+' (3, \'\', '+row.consAll_id+',\'cvc2\');"><i class="fa fa-info-circle"></i></button>';
                            $label += ' <button type="button" class="btn btn-success btn-xs" id="cvc_btn_edit" title="View Renewal Information" onclick="f_load_renew_cert (3, '+row.wfTask_refValue+', '+row.wfTask_id+',\'cvc2\');"><i class="fa fa-mail-forward"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $('#datatable_cvc2').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        $("#datatable_cvc2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cvc2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#modal_waiting').on('shown.bs.modal', function(e){ 
            f_table_cvc_new ();
            f_table_cvc_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
        
    });
    
    function f_table_cvc_new () {
        data_cvc_new = f_get_general_info_multiple('dt_certificate_verify', {wfTask_partition:'1'});
        f_dataTable_draw(dataNew, data_cvc_new, 'datatable_cvc', 11);
    }
    
    function f_table_cvc_history () {
        data_cvc_history = f_get_general_info_multiple('dt_certificate_verify', {wfTask_partition:'2'});
        f_dataTable_draw(dataHistory, data_cvc_history, 'datatable_cvc2', 11);
    }
    
    function f_table_cvc_title () {
        var txt_title = '';
        if ($('#cvc_dateReceived').val() != '') {
            txt_title = 'Received Date : '+$('#cvc_dateReceived').val();
            if ($('#cvc_dateDue').val() != '') 
                txt_title += ', Due Date : '+$('#cvc_dateDue').val();
            if ($('#cvc_dateExpiry').val() != '') 
                txt_title += ', Certificate Expiry Date : '+$('#cvc_dateExpiry').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else if ($('#cvc_dateDue').val() != '') {
            if ($('#cvc_dateExpiry').val() != '') {
                txt_title += '<i>(Due Date : '+$('#cvc_dateDue').val();
                txt_title += ', Certificate Expiry Date : '+$('#cvc_dateExpiry').val()+')</i>';
            } else
                txt_title += '<i>(Due Date : '+$('#cvc_dateDue').val()+')</i>';
        }
        else if ($('#cvc_dateExpiry').val() != '') 
            txt_title += '<i>(Certificate Expiry Date : '+$('#cvc_dateExpiry').val()+')</i>';
        $('#cvc_table_title').html(txt_title);
    }
    
    function f_table_cvc2_title () {
        var txt_title = '';
        if ($('#cvc2_dateSubmit').val() != '') {
            txt_title = 'Submission Date : '+$('#cvc2_dateSubmit').val();
            if ($('#cvc2_dateDue').val() != '') 
                txt_title += ', Due Date : '+$('#cvc2_dateDue').val();
            if ($('#cvc2_dateExpiry').val() != '') 
                txt_title += ', Certificate Expiry Date : '+$('#cvc2_dateExpiry').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else if ($('#cvc2_dateDue').val() != '') {            
            if ($('#cvc2_dateExpiry').val() != '') {
                txt_title += '<i>(Due Date : '+$('#cvc2_dateDue').val();
                txt_title += ', Certificate Expiry Date : '+$('#cvc2_dateExpiry').val()+')</i>';
            } else
                txt_title += '<i>(Due Date : '+$('#cvc2_dateDue').val()+')</i>';
        } else if ($('#cvc2_dateExpiry').val() != '') 
            txt_title += '<i>(Certificate Expiry Date : '+$('#cvc2_dateExpiry').val()+')</i>';
        $('#cvc2_table_title').html(txt_title);
    }
            
</script>