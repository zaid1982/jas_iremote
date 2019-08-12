<?php 
    include 'view/js/j_modal_consultant_pems.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $('#cps_dateRegistered').daterangepicker({
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
            $('#cps_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(7).search('').draw();
            $('#cps_table_title').html('');
        }).val('');
        
        var datatable_cps = undefined;  var cnt_cps = 1;
        dataNew = $('#datatable_cps').DataTable({
            "aaSorting": [[1,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cps) {
                    datatable_cps = new ResponsiveDatatablesHelper($('#datatable_cps'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cps.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cps.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_cps)
                                cnt_cps = 1;
                            if ( iColumn === 0 )
                                return cnt_cps++;
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
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (datas.length < cnt_cps)
                                cnt_cps = 1;
                            if ( iColumn === 0 )
                                return cnt_cps++;
                            else if ( iColumn === 8 )
                                return datas[iDataIndex].status_desc;
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
                    {mData: null, bSortable: false, sClass: 'text-center'},
                    {mData: 'wfTrans_no', mRender: function (data, type, row) { return row.wfTrans_regNo != null ? row.wfTrans_regNo : data; }},                  
                    {mData: 'consPems_model'},
                    {mData: 'consPems_version'},
                    {mData: 'cons_type'},                    
                    {mData: 'softwareMethod_desc'},
                    {mData: 'consPems_ownerStatus',
                        mRender: function (data, type, row) {
                            return data == '1' ? 'Own-developed' : row.consPems_outsource;
                        }
                    },
                    {mData: 'wfTrans_timeSubmit'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.status_id == '2') {    
                                $label = '<button type="button" class="btn btn-warning btn-xs" id="cps_btn_edit" title="Edit" onclick="f_load_consultant_pems (2, '+row.wfGroup_id+', '+row.consAll_id+',\'cps\');"><i class="fa fa-pencil"></i></button> ';
                                $label += '<button type="button" class="btn btn-danger btn-xs" id="cps_btn_delete" title="Delete" onclick="f_delete_consultant_pems ('+row.wfTask_id+','+row.consAll_id+');"><i class="fa fa-minus"></i></button>';
                            } else if (row.status_id == '22') {    
                                $label = '<button type="button" class="btn btn-success btn-xs" id="cps_btn_edit" title="Revise" onclick="f_load_consultant_pems (2, '+row.wfGroup_id+', '+row.consAll_id+',\'cps\');"><i class="fa fa-pencil-square-o"></i></button> ';
                            } else   
                                $label = '<button type="button" class="btn btn-info btn-xs" id="cps_btn_info" title="Info" onclick="f_load_consultant_pems (3, '+row.wfGroup_id+', '+row.consAll_id+',\'cps\');"><i class="fa fa-info-circle"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_cps thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cps thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cps thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });         
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#cps_wfGroup_id').val(wf_group.wfGroup_id);
            f_cps_set_alert();
            f_table_cps();   
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');   
        
    });
    
    function f_table_cps () {
        datas = f_get_general_info_multiple('dt_consultant_pems_cons', {wfGroup_id:$('#cps_wfGroup_id').val()!=''?$('#cps_wfGroup_id').val():' '});
        f_dataTable_draw(dataNew, datas, 'datatable_cps', 10);
    }
    
    function f_delete_consultant_pems (wfTask_id, consAll_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit(wfTask_id, '11', '14', 'Draft data successfully deleted.', '', '2', '', '', 'consAll_id', consAll_id)) {                        
                f_table_cps ();
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
    function f_cps_set_alert() {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', $('#cps_wfGroup_id').val(), 'wfGroup_isFirstTime');         
        if (isFirstTime == '1') {
            $('#cps_alert').removeClass('hide');
            $('#cps_btn_upd_cons').removeClass('hide');
            $('#cps_alert_txt').html('You are 1st time login as <strong>Consultant</strong>. Please complete the <strong>Consultant Information</strong> first before proceed to registration.');
        } else {
            $('#cps_info_register').removeClass('hide');
        }        
    }
            
</script>
