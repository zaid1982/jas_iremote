<?php
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
include 'view/js/j_modal_consultant_cems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $('#cpl_dateRegistered').daterangepicker({
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
            $('#cpl_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(7).search('').draw();
            $('#cpl_table_title').html('');
        }).val('');        
        
        var datatable_cpl = undefined;  var cnt_cpl = 1;
        dataNew = $('#datatable_cpl').DataTable({
            "aaSorting": [[7,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cpl) {
                    datatable_cpl = new ResponsiveDatatablesHelper($('#datatable_cpl'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cpl.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cpl.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_cpl)
                                cnt_cpl = 1;
                            if ( iColumn === 0 )
                                return cnt_cpl++;
                            else if ( iColumn === 8 )
                                return datas[iDataIndex].status_desc;
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
                            if (datas.length < cnt_cpl)
                                cnt_cpl = 1;
                            if ( iColumn === 0 )
                                return cnt_cpl++;
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
                    {mData: 'wfTrans_regNo'},
                    {mData: 'wfGroup_name'},
                    {mData: 'indAll_stackNo'},
                    {mData: 'indAll_type',
                        mRender: function (data, type, row) {
                            return data == '2' ? 'PEMS' : 'CEMS';
                        }
                    },
                    {mData: null,
                        mRender: function (data, type, row) {
                            return row.indAll_type == '2' ? row.consPems_model : row.consCems_modelNo;
                        }
                    },
                    {mData: 'consultant_name'},
                    {mData: 'wfTrans_timeCreated'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var $label = '<button type="button" class="btn btn-info btn-xs" id="cpl_btn_info" title="Info" onclick="f_load_'+(row.indAll_type=='2'?'pems':'cems')+'(3, \'\', '+row.indAll_id+',\'cpl\');"><i class="fa fa-info-circle"></i></button>';
                            if ($('#user_type').val() === '1') {
                                if (row['pdf_suratLulus'] !== null) {
                                    $label += ' <button type="button" class="btn btn-warning btn-xs" title="Surat Tiada Halangan" onclick="f_load_pdf (1, '+row.pdf_suratLulus+');"><i class="fa fa-file-pdf-o"></i></button>';
                                } else {
                                    $label += ' <button type="button" class="btn btn-warning btn-xs" title="Surat Tiada Halangan" onclick="f_generate_pdf ('+row.indAll_id+', \'surat_lulus_'+(row.indAll_type=='2'?'pems':'cems')+'\', \'cpl\');"><i class="fa fa-file-pdf-o"></i></button>';
                                }
                                if (row['pdf_suratTerimaData'] !== null) {
                                    $label += ' <button type="button" class="btn btn-primary btn-xs" title="Surat Terima Data" onclick="f_load_pdf (1, '+row.pdf_suratTerimaData+');"><i class="fa fa-file-pdf-o"></i></button>';
                                } else {
                                    $label += ' <button type="button" class="btn btn-primary btn-xs" title="Surat Terima Data" onclick="f_generate_pdf ('+row.indAll_id+', \'surat_terima_data\', \'cpl\');"><i class="fa fa-file-pdf-o"></i></button>';
                                }
                                if (row['status_id'] === '0') {
                                    $label += ' <button type="button" class="btn btn-success btn-xs" id="cpl_btn_activate" title="Activate" onclick="f_activation_stack (1, '+row.indAll_id+');"><i class="fa fa-check"></i></button>';
                                } else if (row['status_id'] === '1') {
                                    $label += ' <button type="button" class="btn btn-danger btn-warning btn-xs" id="cpl_btn_deactivate" title="Deactivate" onclick="f_activation_stack (0, '+row.indAll_id+');"><i class="fa fa-times"></i></button>';
                                }
                            }
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_cpl thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cpl thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cpl thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        $('#datatable_cpl').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
                
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            f_table_cpl ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');                   
        
    });
    
    function f_table_cpl () {
        datas = f_get_general_info_multiple('dt_industrial_all_list', {indAll_status:'(27,28,29,30,1,0)'});
        f_dataTable_draw(dataNew, datas, 'datatable_cpl', 10);
    }

    function f_activation_stack(_status, _indAll_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            const success_msg = _status === 1 ? 'Stack successfully activated' : 'Stack successfully deactivated';
            if (f_submit_normal('activation_stack', {indAll_id: _indAll_id, indAll_status: _status}, 'p_registration', success_msg)) {
                f_table_cpl ();
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
            
</script>