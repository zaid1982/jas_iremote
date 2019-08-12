<?php 
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
include 'view/js/j_modal_consultant_cems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
include 'view/js/j_modal_cems_rata.php';
include 'view/js/j_modal_pems_rata.php';
include 'view/js/j_modal_pems_raa.php';
?>
<script type="text/javascript">  

    var data_qls_new;
    var data_qls_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#qls_dateExpected').daterangepicker({
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
            f_table_qls_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(5).search('').draw();
            f_table_qls_title ();
        }).val(''); 
        
        $('#qls_dateActual').daterangepicker({
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
            f_table_qls_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_qls_title ();
        }).val('');
        
        var datatable_qls = undefined;  var cnt_qls = 1;
        dataNew = $('#datatable_qls').DataTable({
            "aaSorting": [5,'asc'],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_qls) {
                    datatable_qls = new ResponsiveDatatablesHelper($('#datatable_qls'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qls.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qls.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_qls_new.length < cnt_qls)
                                cnt_qls = 1;
                            if ( iColumn === 0 )
                                return cnt_qls++;
                            else if ( iColumn === 7 )
                                return data_qls_new[iDataIndex].status_desc;
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
                            if (data_qls_new.length < cnt_qls)
                                cnt_qls = 1;
                            if ( iColumn === 0 )
                                return cnt_qls++;
                            else if ( iColumn === 7 )
                                return data_qls_new[iDataIndex].status_desc;
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
                    {mData: 'indAll_stackNo'},
                    {mData: 'qa_types'},
                    {mData: 'wfGroup_name'},
                    {mData: 'qa_dateExpected'},
                    {mData: 'qa_dateActual'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.indAll_type == '1')       modal_open = 'cems';
                            else if (row.indAll_type == '2')  modal_open = 'pems';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="itp_btn_info" title="Information" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'qls\');"><i class="fa fa-info-circle"></i></button> ';
                            var load_types = jQuery.inArray(row.qa_status, ['50', '22']) >= 0 ? '2':'3';
                            var load_color = jQuery.inArray(row.qa_status, ['50', '22']) >= 0  ? 'warning':'success';
                            if (jQuery.inArray(row.qa_type, ['2', '5']) >= 0)
                                $label += '<button type="button" class="btn btn-'+load_color+' btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_rata (3, '+row.qa_id+', \'\',\'qls\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (jQuery.inArray(row.qa_type, ['1', '3', '4']) >= 0)    
                                $label += '<button type="button" class="btn btn-'+load_color+' btn-xs" title="'+row.qa_types+' Report" onclick="f_load_cems_rata (3, '+row.qa_id+', \'\',\'qls\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (row.qa_type == '6')        
                                $label += '<button type="button" class="btn btn-'+load_color+' btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_raa (3, '+row.qa_id+', \'\',\'qls\');"><i class="fa fa-file-text-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_qls thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_qls thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_qls thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#qls2_dateExpected').daterangepicker({
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
            f_table_qls_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(5).search('').draw();
            f_table_qls_title2 ();
        }).val(''); 
        
        $('#qls2_dateActual').daterangepicker({
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
            f_table_qls_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_qls_title2 ();
        }).val('');   
        
        var datatable_qls2 = undefined;  var cnt_qls2 = 1;
        dataHistory = $('#datatable_qls2').DataTable({
            "aaSorting": [[5,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_qls2) {
                    datatable_qls2 = new ResponsiveDatatablesHelper($('#datatable_qls2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qls2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qls2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_qls_history.length < cnt_qls2)
                                cnt_qls2 = 1;
                            if ( iColumn === 0 )
                                return cnt_qls2++;
                            else if ( iColumn === 8 )
                                return data_qls_history[iDataIndex].status_desc;
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
                            if (data_qls_history.length < cnt_qls2)
                                cnt_qls2 = 1;
                            if ( iColumn === 0 )
                                return cnt_qls2++;
                            else if ( iColumn === 8 )
                                return data_qls_history[iDataIndex].status_desc;
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
                    {mData: 'indAll_stackNo'},
                    {mData: 'qa_types'},
                    {mData: 'wfGroup_name'},
                    {mData: 'qa_dateExpected'},
                    {mData: 'qa_dateActual'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.indAll_type == '1')       modal_open = 'cems';
                            else if (row.indAll_type == '2')  modal_open = 'pems';
                            $label = '<button type="button" class="btn btn-info btn-xs" id="itp_btn_info" title="Information" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'qls\');"><i class="fa fa-info-circle"></i></button> ';
                            if (jQuery.inArray(row.qa_type, ['2', '5']) >= 0)
                                $label += '<button type="button" class="btn btn-success btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_rata (3, '+row.qa_id+', \'\',\'qls\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (jQuery.inArray(row.qa_type, ['1', '3', '4']) >= 0)
                                $label += '<button type="button" class="btn btn-success btn-xs" title="'+row.qa_types+' Report" onclick="f_load_cems_rata (3, '+row.qa_id+', \'\',\'qls\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (row.qa_type == '6')    
                                $label += '<button type="button" class="btn btn-success btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_raa (3, '+row.qa_id+', \'\',\'qls\');"><i class="fa fa-file-text-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_qls2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_qls2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_qls2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            f_table_qls_new ();
            f_table_qls_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
        
    });
    
    function f_table_qls_new () {
        data_qls_new = f_get_general_info_multiple('dt_qa_list', {qa_status:'(50,22,47)'});
        f_dataTable_draw(dataNew, data_qls_new, 'datatable_qls', 9);
    }
    
    function f_table_qls_history () {
        data_qls_history = f_get_general_info_multiple('dt_qa_list', {qa_status:'(23,49)'});
        f_dataTable_draw(dataHistory, data_qls_history, 'datatable_qls2', 9);
    }
    
    function f_table_qls_title () {
        var txt_title = '';
        if ($('#qls_dateExpected').val() != '') {
            txt_title = 'Scheduled Date : '+$('#qls_dateExpected').val();
            if ($('#qls_dateActual').val() != '') 
                txt_title += ', Actual Date : '+$('#qls_dateActual').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#qls_dateActual').val() != '') 
                txt_title += '<i>(Actual Date : '+$('#qls_dateActual').val()+')</i>';
        }
        $('#qls_table_title').html(txt_title);
    }
    
    function f_table_qls_title2 () {
        var txt_title = '';
        if ($('#qls2_dateExpected').val() != '') {
            txt_title = 'Scheduled Date : '+$('#qls2_dateExpected').val();
            if ($('#qls2_dateActual').val() != '') 
                txt_title += ', Actual Date : '+$('#qls2_dateActual').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#qls2_dateActual').val() != '') 
                txt_title += '<i>(Actual Date : '+$('#qls2_dateActual').val()+')</i>';
        }
        $('#qls2_table_title').html(txt_title);
    }
            
</script>