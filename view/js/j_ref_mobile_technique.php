<?php
include 'view/js/j_modal_reference.php';
?>
<script type="text/javascript">

    $(document).ready(function () {

        pageSetUp();

        $('#rmt_created_date').daterangepicker({
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
            $('#rmt_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(2).search('').draw();
            $('#rmt_table_title').html('');
        }).val('');

        var datatable_rmt = undefined;  var cnt_rmt = 1;
        dataNew = $('#datatable_rmt').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_rmt) {
                    datatable_rmt = new ResponsiveDatatablesHelper($('#datatable_rmt'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_rmt.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_rmt.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_rmt)
                                cnt_rmt = 1;
                            if ( iColumn === 0 )
                                return cnt_rmt++;
                            else if ( iColumn === 3 )
                                return datas[iDataIndex].status_desc;
                            else if ( iColumn === 4 )
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
                            if (datas.length < cnt_rmt)
                                cnt_rmt = 1;
                            if ( iColumn === 0 )
                                return cnt_rmt++;
                            else if ( iColumn === 3 )
                                return datas[iDataIndex].status_desc;
                            else if ( iColumn === 4 )
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
                    {mData: 'mobileTechnique_desc'},
                    {mData: 'mobileTechnique_timeCreated'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (data == 'Active')
                                $label = '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                            else
                                $label = '<b class="badge bg-color-red"> '+data+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-warning btn-xs" id="rmt_btn_info" title="Edit Reference Data" onclick="f_load_reference (2, '+row.mobileTechnique_id+',\'dt_ref_mobile_technique\',\'rmt\');"><i class="fa fa-edit"></i></button>';
                            if (row['mobileTechnique_id'] !== '1') {
                                if (row.status_desc == 'Active')
                                    $label += ' <button type="button" class="btn btn-danger btn-xs" id="rmt_btn_activate" title="Deactivate" onclick="f_update_status_ref(0,\'t_mobile_technique\', '+row.mobileTechnique_id+', \'mobileTechnique\', \'CEMS Mobile Technique\', \'deactivated\', \'dt_ref_mobile_technique\');"><i class="fa fa-minus-square"></i></button>';
                                else
                                    $label += ' <button type="button" class="btn btn-success btn-xs" id="rmt_btn_deactivate" title="Activate" onclick="f_update_status_ref(1,\'t_mobile_technique\', '+row.mobileTechnique_id+', \'mobileTechnique\', \'CEMS Mobile Technique\', \'activated\', \'dt_ref_mobile_technique\');"><i class="fa fa-check-square"></i></button>';
                            }
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_rmt thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_rmt thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_rmt thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });

        $('#modal_waiting').on('shown.bs.modal', function(e){
            datas = f_get_general_info_multiple('dt_ref_mobile_technique');
            f_dataTable_draw(dataNew, datas);
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');

    });

</script>