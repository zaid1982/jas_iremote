<?php
include 'view/js/j_modal_response.php';
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
?>
<script type="text/javascript">  
    
    var data_cpf_new;
    var data_cpf_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#cpf_datePooling').daterangepicker({
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
            f_table_cpf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_cpf_title ();
        }).val(''); 
        
        $('#cpf_dateReceived').daterangepicker({
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
            f_table_cpf_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(7).search('').draw();
            f_table_cpf_title ();
        }).val('');
        
        $('#cpf_datePooling2').daterangepicker({
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
            f_table_cpf_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_cpf_title2 ();
        }).val(''); 
        
        $('#cpf_dateClose').daterangepicker({
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
            f_table_cpf_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(7).search('').draw();
            f_table_cpf_title2 ();
        }).val(''); 
        
        var datatable_cpf = undefined;  var cnt_cpf = 1;
        dataNew = $('#datatable_cpf').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_cpf) {
                    datatable_cpf = new ResponsiveDatatablesHelper($('#datatable_cpf'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cpf.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cpf.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_cpf_new.length < cnt_cpf)
                                cnt_cpf = 1;
                            if ( iColumn === 0 )
                                return cnt_cpf++;
                            else if ( iColumn === 9 )
                                return (data_cpf_new[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
                            else if ( iColumn === 10 )
                                return data_cpf_new[iDataIndex].wfTaskType_statusName;
                            else if ( iColumn === 11 )
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
                            if (data_cpf_new.length < cnt_cpf)
                                cnt_cpf = 1;
                            if ( iColumn === 0 )
                                return cnt_cpf++;
                            else if ( iColumn === 9 )
                                return (data_cpf_new[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
                            else if ( iColumn === 10 )
                                return data_cpf_new[iDataIndex].wfTaskType_statusName;
                            else if ( iColumn === 11 )
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
                    {mData: 'wfGroup_name'},
                    {mData: 'ind_regNo'},
                    {mData: 'indAll_stackNo'},
                    {mData: 'inputParam_desc'},
                    {mData: 'response_date'},
                    {mData: 'response_timeCreated'},
                    {mData: 'state_desc'},
                    {mData: 'response_dataReceived',   
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+(data=='0'?'red':'purple')+'"> '+(data=='0'?'Empty':'Incomplete')+' </b>';
                        }
                    },
                    {mData: 'wfTaskType_statusName',   
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+(row.wfTaskType_id=='52'?'red':'blue')+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = row.indAll_type == '1' ? 'cems':'pems';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="cpf_btn_info" title="Industrial Info" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'cpf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="cpf_btn_response" title="Industrial Response" onclick="f_load_mre (3, '+row.response_id+', '+row.wfTask_id+',\'cpf\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_cpf thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cpf thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cpf thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });    
        
        var datatable_cpf2 = undefined;  var cnt_cpf2 = 1;
        dataHistory = $('#datatable_cpf2').DataTable({
            "aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_cpf2) {
                    datatable_cpf2 = new ResponsiveDatatablesHelper($('#datatable_cpf2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cpf2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cpf2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_cpf_history.length < cnt_cpf2)
                                cnt_cpf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_cpf2++;
                            else if ( iColumn === 9 )
                                return (data_cpf_history[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
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
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (data_cpf_history.length < cnt_cpf2)
                                cnt_cpf2 = 1;
                            if ( iColumn === 0 )
                                return cnt_cpf2++;
                            else if ( iColumn === 9 )
                                return (data_cpf_history[iDataIndex].response_dataReceived=='0'?'Empty':'Incomplete');
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
                    {mData: 'wfTrans_regNo'},
                    {mData: 'wfGroup_name'},
                    {mData: 'ind_regNo'},
                    {mData: 'indAll_stackNo'},
                    {mData: 'inputParam_desc'},
                    {mData: 'response_date'},
                    {mData: 'wfTask_timeCreated'},
                    {mData: 'state_desc'},
                    {mData: 'response_dataReceived',   // manually count result
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+(data=='0'?'red':'orange')+'"> '+(data=='0'?'Empty':'Incomplete')+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = row.indAll_type == '1' ? 'cems':'pems';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="cpf_btn_info" title="Industrial Info" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'cpf\');"><i class="fa fa-info-circle"></i></button>';
                            $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="cpf_btn_response" title="Industrial Response" onclick="f_load_mre (3, '+row.response_id+', '+row.wfTask_id+',\'cpf\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_cpf2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cpf2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cpf2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });     
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            f_table_cpf_new ();
            f_table_cpf_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');

    });
    
    function f_table_cpf_new () {
        data_cpf_new = f_get_general_info_multiple('dt_fail_response_list_all', {wfTaskType_id:'(62,63)'});
        f_dataTable_draw(dataNew, data_cpf_new, 'datatable_cpf', 12);
    }
    
    function f_table_cpf_history () {
        data_cpf_history = f_get_general_info_multiple('dt_fail_response_list_all', {wfTaskType_id:'64'});
        f_dataTable_draw(dataHistory, data_cpf_history, 'datatable_cpf2', 11);
    }
    
    function f_table_cpf_title () {
        var txt_title = '';
        if ($('#cpf_datePooling').val() != '') {
            txt_title = 'Pooling Date : '+$('#cpf_datePooling').val();
            if ($('#cpf_dateReceived').val() != '') 
                txt_title += ', Received Date : '+$('#cpf_dateReceived').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#cpf_dateReceived').val() != '') 
                txt_title += '<i>(Received Date : '+$('#cpf_dateReceived').val()+')</i>';
        }
        $('#cpf_table_title').html(txt_title);
    }
    
    function f_table_cpf_title2 () {
        var txt_title = '';
        if ($('#cpf_datePooling2').val() != '') {
            txt_title = 'Pooling Date : '+$('#cpf_datePooling2').val();
            if ($('#cpf_dateClose').val() != '') 
                txt_title += ', Received Date : '+$('#cpf_dateClose').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#cpf_dateClose').val() != '') 
                txt_title += '<i>(Received Date : '+$('#cpf_dateClose').val()+')</i>';
        }
        $('#cpf_table_title2').html(txt_title);
    }
                   
</script>