<? 
include 'view/js/j_modal_consultant.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $('#cnl_dateRegistered').daterangepicker({
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
            $('#cnl_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            $('#cnl_table_title').html('');
        }).val('');
        
        var datatable_cnl = undefined;  var cnt_cnl = 1;
        dataNew = $('#datatable_cnl').DataTable({
            "aaSorting": [6,'desc'],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cnl) {
                    datatable_cnl = new ResponsiveDatatablesHelper($('#datatable_cnl'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cnl.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cnl.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_cnl)
                                cnt_cnl = 1;
                            if ( iColumn === 0 )
                                return cnt_cnl++;
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
                            if (datas.length < cnt_cnl)
                                cnt_cnl = 1;
                            if ( iColumn === 0 )
                                return cnt_cnl++;
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
                    {mData: 'wfGroup_name'},
                    {mData: 'wfGroup_regNo'},
                    {mData: 'cons_type'},
                    {mData: 'city_desc'},
                    {mData: 'state_desc'},
                    {mData: 'wfGroup_timeCreated'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" title="Consultant Information" onclick="f_load_consultant(3, '+row.consultant_id+', \'cnl\');"><i class="fa fa-info-circle"></i></button>';
                            if (row['status_id'] === '0') {
                                $label += ' <button type="button" class="btn btn-success btn-xs" id="cnl_btn_activate" title="Activate" onclick="f_activation_consultant (1, '+row.consultant_id+');"><i class="fa fa-check"></i></button>';
                            } else if (row['status_id'] === '1') {
                                $label += ' <button type="button" class="btn btn-danger btn-xs" id="cnl_btn_deactivate" title="Deactivate" onclick="f_activation_consultant (0, '+row.consultant_id+');"><i class="fa fa-times"></i></button>';
                            }
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_cnl thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cnl thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cnl thead th select").on('change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });      
        $('#datatable_cnl').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            f_table_cnl ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 

    });
    
    function f_table_cnl () {
        var user_table = f_get_general_info('user', {user_id:$('#user_id').val()});
        var total_appl = user_table.user_type == '1' ? '' : 'is not NULL';
        datas = f_get_general_info_multiple('dt_consultant_list', {totals:total_appl});
        f_dataTable_draw(dataNew, datas, 'datatable_cnl', 9);
    }

    function f_activation_consultant(_status, _consultant_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            const success_msg = _status === 1 ? 'Consultant successfully activated' : 'Consultant successfully deactivated';
            if (f_submit_normal('activation_consultant', {consultant_id: _consultant_id, consultant_status: _status}, 'p_registration', success_msg)) {
                f_table_cnl ();
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
            
</script>