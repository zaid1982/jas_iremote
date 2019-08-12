<?php
include 'view/js/j_modal_qnf.php';
?>
<script type="text/javascript">  

    var data_qfp_new;
    var data_qfp_history;
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#qfp_timestamp').daterangepicker({
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
            var filteredData = dataNew.column(2).data().filter(function (value, index) {
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
            dataNew.column(2).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_qfp_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(2).search('').draw();
            f_table_qfp_title ();
        }).val(''); 
        
        var datatable_qfp = undefined;  var cnt_qfp = 1;
        dataNew = $('#datatable_qfp').DataTable({
            "aaSorting": [[2,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_qfp) {
                    datatable_qfp = new ResponsiveDatatablesHelper($('#datatable_qfp'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qfp.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qfp.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_qfp_new.length < cnt_qfp)
                                cnt_qfp = 1;
                            if ( iColumn === 0 )
                                return cnt_qfp++;
                            else if ( iColumn === 5 )
                                return data_qfp_new[iDataIndex].status_desc;
                            else if ( iColumn === 6 )
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
                            if (data_qfp_new.length < cnt_qfp)
                                cnt_qfp = 1;
                            if ( iColumn === 0 )
                                return cnt_qfp++;
                            else if ( iColumn === 5 )
                                return data_qfp_new[iDataIndex].status_desc;
                            else if ( iColumn === 6 )
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
                    {mData: 'qnf_timeSubmitted'},
                    {mData: 'qnfCate_desc'},
                    {mData: 'qnf_title'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var load_types = row.wfTaskType_id == '72' ? '2':'3';
                            var load_color = row.wfTaskType_id == '72' ? 'success':'info';
                            $label = '<button type="button" class="btn btn-'+load_color+' btn-xs" id="qfp_btn_info" title="Query and Feedback" onclick="f_load_qnf ('+load_types+', '+row.qnf_id+', '+row.wfTask_id+',\'qfp\');"><i class="fa fa-comments-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_qfp thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_qfp thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_qfp thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#qfp_timestamp2').daterangepicker({
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
            var filteredData = dataHistory.column(2).data().filter(function (value, index) {
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
            dataHistory.column(2).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_qfp_title2 ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(2).search('').draw();
            f_table_qfp_title2 ();
        }).val('');        
        
        var datatable_qfp2 = undefined;  var cnt_qfp2 = 1;
        dataHistory = $('#datatable_qfp2').DataTable({
            "aaSorting": [[2,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_qfp2) {
                    datatable_qfp2 = new ResponsiveDatatablesHelper($('#datatable_qfp2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qfp2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qfp2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_qfp_history.length < cnt_qfp2)
                                cnt_qfp2 = 1;
                            if ( iColumn === 0 )
                                return cnt_qfp2++;
                            else if ( iColumn === 5 )
                                return data_qfp_history[iDataIndex].status_desc;
                            else if ( iColumn === 6 )
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
                            if (data_qfp_history.length < cnt_qfp2)
                                cnt_qfp2 = 1;
                            if ( iColumn === 0 )
                                return cnt_qfp2++;
                            else if ( iColumn === 5 )
                                return data_qfp_history[iDataIndex].status_desc;
                            else if ( iColumn === 6 )
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
                    {mData: 'qnf_timeSubmitted'},
                    {mData: 'qnfCate_desc'},
                    {mData: 'qnf_title'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="qfp_btn_info" title="Query and Feedback" onclick="f_load_qnf (3, '+row.qnf_id+', '+row.wfTask_id+',\'qfp\');"><i class="fa fa-comments-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_qfp2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_qfp2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_qfp2 thead th select").on('change', function () {
            if (this.value == '')
                dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            f_table_qfp_new ();
            f_table_qfp_history ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
        
    });
    
    function f_table_qfp_new () {
        data_qfp_new = f_get_general_info_multiple('dt_qnf_post', {}, {is_end:'N'});
        f_dataTable_draw(dataNew, data_qfp_new, 'datatable_qfp', 7);
    }
    
    function f_table_qfp_history () {
        data_qfp_history = f_get_general_info_multiple('dt_qnf_post', {}, {is_end:'Y'});
        f_dataTable_draw(dataHistory, data_qfp_history, 'datatable_qfp2', 7);
    }
    
    function f_table_qfp_title () {
        var txt_title = '';
        if ($('#qfp_timestamp').val() != '') {
            txt_title = '<i>(Inquiry Date : '+$('#qfp_timestamp').val()+')</i>';
        } 
        $('#qfp_table_title').html(txt_title);
    }
    
    function f_table_qfp_title2 () {
        var txt_title = '';
        if ($('#qfp_timestamp2').val() != '') {
            txt_title = '<i>(Inquiry Date : '+$('#qfp_timestamp2').val()+')</i>';
        } 
        $('#qfp_table_title2').html(txt_title);
    }
            
</script>