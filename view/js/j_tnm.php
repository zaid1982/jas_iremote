<? 
include 'view/js/j_modal_action.php';
include 'view/js/j_modal_consultant_cems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
include 'view/js/j_modal_delegate.php';
?>
<script type="text/javascript">  
    
    var uType_main = '';
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#tnm_dateReceived').daterangepicker({
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
            f_table_tnm_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(5).search('').draw();
            f_table_tnm_title ();
        }).val('');
        
        $('#tnm_dateDue').daterangepicker({
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
            dataNew.column(6).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            f_table_tnm_title ();
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            f_table_tnm_title ();
        }).val('');        
        
        var user_type = f_get_general_info_multiple('user_type', {user_id:$('#user_id').val(), uType_id:'(1,4)'});
        
        var datatable_tnm = undefined;  var cnt_tnm = 1;
        dataNew = $('#datatable_tnm').DataTable({
            "aaSorting": [[5,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_tnm) {
                    datatable_tnm = new ResponsiveDatatablesHelper($('#datatable_tnm'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_tnm.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_tnm.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_tnm)
                                cnt_tnm = 1;
                            if ( iColumn === 0 )
                                return cnt_tnm++;
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
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (datas.length < cnt_tnm)
                                cnt_tnm = 1;
                            if ( iColumn === 0 )
                                return cnt_tnm++;
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
                    {mData: 'wfFlow_desc'},
                    {mData: 'wfTaskType_name'},
                    {mData: 'profile_name'},
                    {mData: 'wfTrans_timeCreated', sClass: 'text-center'},
                    {mData: 'wfTrans_dateDue', sClass: 'text-center'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.wfFlow_id == '1')       modal_open = 'f_load_consultant_cems';
                            else if (row.wfFlow_id == '2')  modal_open = 'f_load_consultant_pems';
                            else if (row.wfFlow_id == '3')  modal_open = 'f_load_consultant_mobile';
                            else if (row.wfFlow_id == '4')  modal_open = 'f_load_cems';
                            else if (row.wfFlow_id == '5')  modal_open = 'f_load_pems';
                            $label = modal_open == '' ? '' : '<button type="button" class="btn btn-info btn-xs" id="ctp_btn_info" title="Application Information" onclick="'+modal_open+' (3, \'\', '+row.wfTask_refValue+',\'ctp\');"><i class="fa fa-info-circle"></i></button>';
                            $label += ' <button type="button" class="btn btn-warning btn-xs" title="Transaction History" onclick="f_load_action (3, '+row.wfTask_id+',\'tnm\');"><i class="fa fa-history"></i></button>';
                            if (user_type.length > 0 && row.uType_ids == '3')
                                $label += ' <button type="button" class="btn btn-danger btn-xs" id="tnm_btn_delegate" title="Delegate Task" onclick="f_load_delegate (1,\'tnm\');"><i class="fa fa-share-square-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
         
        $("#datatable_tnm thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_tnm thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_tnm thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            f_table_tnm ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');     
        
    });
    
    function f_table_tnm () {
        datas = f_get_general_info_multiple('dt_track_monitoring');
        f_dataTable_draw(dataNew, datas, 'datatable_tnm', 9);
    }
    
    function f_table_tnm_title () {
        var txt_title = '';
        if ($('#tnm_dateReceived').val() != '') {
            txt_title = 'Received Date : '+$('#tnm_dateReceived').val();
            if ($('#tnm_dateDue').val() != '') 
                txt_title += ', Due Date : '+$('#tnm_dateDue').val();
            txt_title = '<i>('+txt_title+')</i>';
        } else {
            if ($('#tnm_dateDue').val() != '') 
                txt_title += '<i>(Due Date : '+$('#tnm_dateDue').val()+')</i>';
        }
        $('#tnm_table_title').html(txt_title);
    }
            
</script>