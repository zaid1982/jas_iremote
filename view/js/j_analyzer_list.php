<?php 
include 'view/js/j_modal_consultant_cems.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
                
        $('#anz_dateRegistered').daterangepicker({
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
            $('#anz_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(7).search('').draw();
            $('#anz_table_title').html('');
        }).val('');
        
        var datatable_anz = undefined;  var cnt_anz = 1;
        dataNew = $('#datatable_anz').DataTable({
            "aaSorting": [[1,'asc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_anz) {
                    datatable_anz = new ResponsiveDatatablesHelper($('#datatable_anz'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_anz.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_anz.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_anz)
                                cnt_anz = 1;
                            if ( iColumn === 0 )
                                return cnt_anz++;
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
                            if (datas.length < cnt_anz)
                                cnt_anz = 1;
                            if ( iColumn === 0 )
                                return cnt_anz++;
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
                    {mData: null, bSortable: false},
                    {mData: 'consCems_modelNo'},
                    {mData: 'consCems_brand'},
                    {mData: 'wfGroup_name'},
                    {mData: 'cons_type'},
                    {mData: 'consCems_isNormalize',
                        mRender: function (data, type, row) {
                            return data == '1' ? 'Yes' : 'No';
                        }
                    },
                    {mData: 'consCems_timeCreated'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var $label = '<button type="button" class="btn btn-info btn-xs" id="anz_btn_info" title="Info" onclick="f_load_consultant_cems (3, '+row.wfGroup_id+', '+row.consAll_id+',\'anz\');"><i class="fa fa-info-circle"></i></button>';
                            if (row['status_id'] === '0') {
                                $label += ' <button type="button" class="btn btn-success btn-xs" id="anz_btn_activate" title="Activate" onclick="f_activate_analyzer_cems (3, '+row.wfGroup_id+', '+row.consAll_id+',\'anz\');"><i class="fa fa-check"></i></button>';
                            } else if (row['status_id'] === '1') {
                                $label += ' <button type="button" class="btn btn-danger btn-xs" id="anz_btn_deactivate" title="Deactivate" onclick="f_deactivate_analyzer_cems (3, '+row.wfGroup_id+', '+row.consAll_id+',\'anz\');"><i class="fa fa-times"></i></button>';
                            }
                            return $label;
                        }
                    }
                ]
        });
        //filter
        $("#datatable_anz thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_anz thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_anz thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            f_table_anz ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');                   
        
    });
    
    function f_table_anz () {
        datas = f_get_general_info_multiple('dt_analyzer', {consCems_status:'1'});
        f_dataTable_draw(dataNew, datas, 'datatable_anz', 10);
    }
            
</script>