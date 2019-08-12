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

    var data_iqa_new;
    var data_iqa_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#iqa_dateExpected').daterangepicker({
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
            f_table_iqa_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(5).search('').draw();
            f_table_iqa_title ();
        }).val(''); 
        
        $('#iqa_dateActual').daterangepicker({
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
            f_table_iqa_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_iqa_title ();
        }).val('');
        
        var datatable_iqa = undefined;  var cnt_iqa = 1;
        dataNew = $('#datatable_iqa').DataTable({
            "aaSorting": [5,'asc'],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_iqa) {
                    datatable_iqa = new ResponsiveDatatablesHelper($('#datatable_iqa'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_iqa.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_iqa.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_iqa_new.length < cnt_iqa)
                                cnt_iqa = 1;
                            if ( iColumn === 0 )
                                return cnt_iqa++;
                            else if ( iColumn === 7 )
                                return data_iqa_new[iDataIndex].status_desc;
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
                            if (data_iqa_new.length < cnt_iqa)
                                cnt_iqa = 1;
                            if ( iColumn === 0 )
                                return cnt_iqa++;
                            else if ( iColumn === 7 )
                                return data_iqa_new[iDataIndex].status_desc;
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
                            $label = '<button type="button" class="btn btn-info btn-xs" id="itp_btn_info" title="Information" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'iqa\');"><i class="fa fa-info-circle"></i></button> ';
                            var load_types = jQuery.inArray(row.qa_status, ['50', '22']) >= 0 ? '2':'3';
                            var load_color = jQuery.inArray(row.qa_status, ['50', '22']) >= 0  ? 'warning':'success';
                            if (jQuery.inArray(row.qa_type, ['2', '5']) >= 0)
                                $label += '<button type="button" class="btn btn-'+load_color+' btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_rata ('+load_types+', '+row.qa_id+', \'\',\'iqa\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (jQuery.inArray(row.qa_type, ['1', '3', '4']) >= 0)    
                                $label += '<button type="button" class="btn btn-'+load_color+' btn-xs" title="'+row.qa_types+' Report" onclick="f_load_cems_rata ('+load_types+', '+row.qa_id+', \'\',\'iqa\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (row.qa_type == '6')        
                                $label += '<button type="button" class="btn btn-'+load_color+' btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_raa ('+load_types+', '+row.qa_id+', \'\',\'iqa\');"><i class="fa fa-file-text-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_iqa thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_iqa thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_iqa thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#iqa2_dateExpected').daterangepicker({
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
            f_table_iqa_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(5).search('').draw();
            f_table_iqa_title2 ();
        }).val(''); 
        
        $('#iqa2_dateActual').daterangepicker({
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
            f_table_iqa_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            f_table_iqa_title2 ();
        }).val('');   
        
        var datatable_iqa2 = undefined;  var cnt_iqa2 = 1;
        dataHistory = $('#datatable_iqa2').DataTable({
            "aaSorting": [[5,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_iqa2) {
                    datatable_iqa2 = new ResponsiveDatatablesHelper($('#datatable_iqa2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_iqa2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_iqa2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_iqa_history.length < cnt_iqa2)
                                cnt_iqa2 = 1;
                            if ( iColumn === 0 )
                                return cnt_iqa2++;
                            else if ( iColumn === 8 )
                                return data_iqa_history[iDataIndex].status_desc;
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
                            if (data_iqa_history.length < cnt_iqa2)
                                cnt_iqa2 = 1;
                            if ( iColumn === 0 )
                                return cnt_iqa2++;
                            else if ( iColumn === 8 )
                                return data_iqa_history[iDataIndex].status_desc;
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
                            $label = '<button type="button" class="btn btn-info btn-xs" id="itp_btn_info" title="Information" onclick="f_load_'+modal_open+' (3, \'\', '+row.indAll_id+',\'iqa\');"><i class="fa fa-info-circle"></i></button> ';
                            if (jQuery.inArray(row.qa_type, ['2', '5']) >= 0)
                                $label += '<button type="button" class="btn btn-success btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_rata (3, '+row.qa_id+', \'\',\'iqa\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (jQuery.inArray(row.qa_type, ['1', '3', '4']) >= 0)
                                $label += '<button type="button" class="btn btn-success btn-xs" title="'+row.qa_types+' Report" onclick="f_load_cems_rata (3, '+row.qa_id+', \'\',\'iqa\');"><i class="fa fa-file-text-o"></i></button>';
                            else if (row.qa_type == '6')    
                                $label += '<button type="button" class="btn btn-success btn-xs" title="'+row.qa_types+' Report" onclick="f_load_pems_raa (3, '+row.qa_id+', \'\',\'iqa\');"><i class="fa fa-file-text-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_iqa2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_iqa2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_iqa2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#iqa_wfGroup_id').val(wf_group.wfGroup_id);
            f_table_iqa_new ();
            f_table_iqa_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
        
    });
    
    function f_table_iqa_new () {
        data_iqa_new = f_get_general_info_multiple('dt_qa', {qa_status:'(50,22,47)'}, {wfGroup_id:$('#iqa_wfGroup_id').val()!=''?$('#iqa_wfGroup_id').val():' '});
        f_dataTable_draw(dataNew, data_iqa_new, 'datatable_iqa', 9);
    }
    
    function f_table_iqa_history () {
        data_iqa_history = f_get_general_info_multiple('dt_qa', {qa_status:'(23,49)'}, {wfGroup_id:$('#iqa_wfGroup_id').val()!=''?$('#iqa_wfGroup_id').val():' '});
        f_dataTable_draw(dataHistory, data_iqa_history, 'datatable_iqa2', 9);
    }
    
    function f_table_iqa_title () {
        var txt_title = '';
        if ($('#iqa_dateExpected').val() != '') {
            txt_title = 'Scheduled Date : '+$('#iqa_dateExpected').val();
            if ($('#iqa_dateActual').val() != '') 
                txt_title += ', Actual Date : '+$('#iqa_dateActual').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#iqa_dateActual').val() != '') 
                txt_title += '<i>(Actual Date : '+$('#iqa_dateActual').val()+')</i>';
        }
        $('#iqa_table_title').html(txt_title);
    }
    
    function f_table_iqa_title2 () {
        var txt_title = '';
        if ($('#iqa2_dateExpected').val() != '') {
            txt_title = 'Scheduled Date : '+$('#iqa2_dateExpected').val();
            if ($('#iqa2_dateActual').val() != '') 
                txt_title += ', Actual Date : '+$('#iqa2_dateActual').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#iqa2_dateActual').val() != '') 
                txt_title += '<i>(Actual Date : '+$('#iqa2_dateActual').val()+')</i>';
        }
        $('#iqa2_table_title').html(txt_title);
    }
            
</script>