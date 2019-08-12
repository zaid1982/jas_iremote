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
        
        $('#ccp_dateRegistered').daterangepicker({
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
            var filteredData = dataNew.column(10).data().filter(function (value, index) {
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
            dataNew.column(10).search(val ? "^" + val + "$" : "^" + "-" + "$", true, false, true).draw(); 
            $('#ccp_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(10).search('').draw();
            $('#ccp_table_title').html('');
        }).val('');  
        
        var datatable_ccp = undefined;  var cnt_ccp = 1;
        dataNew = $('#datatable_ccp').DataTable({
            "aaSorting": [[10,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": false,
            "preDrawCallback": function () {
                if (!datatable_ccp) {
                    datatable_ccp = new ResponsiveDatatablesHelper($('#datatable_ccp'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_ccp.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_ccp.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_ccp)
                                cnt_ccp = 1;
                            if ( iColumn === 0 )
                                return cnt_ccp++;
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
                            if (datas.length < cnt_ccp)
                                cnt_ccp = 1;
                            if ( iColumn === 0 )
                                return cnt_ccp++;
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
                    {mData: 'wfTrans_regNo'},
                    {mData: 'wfGroup_name'},
                    {mData: 'indAll_stackNo'},
                    {mData: 'indAll_type',
                        mRender: function (data, type, row) {
                            return data == '2' ? 'PEMS' : 'CEMS';
                        }
                    },
                    {mData: 'consAll_type',
                        mRender: function (data, type, row) {
                            return data == '2' ? 'PEMS' : 'CEMS';
                        }
                    },
                    {mData: 'cons_regNo'},
                    {mData: 'consCems_modelNo', visible: false, 
                        mRender: function(data, type, row) { 
                            return row.consAll_type == '2' ? row.consPems_model : row.consCems_modelNo;
                        }
                    },
                    {mData: 'city_desc'},
                    {mData: 'state_desc', visible: false},
                    {mData: 'wfTask_timeSubmitted'} ,
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
//                            if (row.data8 == 'Active')
//                                $label = '<b class="badge bg-color-green"> '+row.data8+' </b>';
//                            else if (row.data8 == 'Shutdown')   
//                                $label = '<b class="badge bg-color-blueDark" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Shutdown</b>" data-content="<b>Date : </b>2016-12-12 to 2016-12-24<br><b>Reason : </b>Power maintenance scheduled for entire factory" data-html="true">' + row.data8 + '</b>';
//                            else 
//                                $label = '<b class="badge bg-color-yellow" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Closed</b>" data-content="<b>Date : </b>Since 2016-12-12<br><b>Reason : </b>The premise was shutdown." data-html="true">' + row.data8 + '</b>';
                            //return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var ind_type = row.indAll_type == '2' ? 'pems' : 'cems';
                            var cons_type = row.consAll_type == '2' ? 'pems' : 'cems';
                            $label = '<button type="button" class="btn btn-warning btn-xs" id="ccp_btn_info" title="Analyzer Information" onclick="f_load_'+ind_type+' (3, \'\', '+row.indAll_id+',\'ccp\');"><i class="fa fa-dashboard"></i></button>';
                            $label += ' <button type="button" class="btn btn-info btn-xs" id="ccp_btn_info" title="Analyzer Information" onclick="f_load_consultant_'+cons_type+' (3, \'\', '+row.consAll_id+',\'ccp\');"><i class="fa fa-info-circle"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_ccp thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_ccp thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_ccp thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
//        $('#datatable_ccp').on('draw.dt', function () {
//            $('[data-toggle="popover"]').popover();
//        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            f_table_ccp ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');   

    });
        
    function f_table_ccp () {
        var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val()});
        datas = f_get_general_info_multiple('dt_installed_CEMS_PEMS', {indAll_status:'(27,28,29,30,1)', wfGroup_id:wf_group_user.wfGroup_id});
        f_dataTable_draw(dataNew, datas, 'datatable_ccp', 13);
    }
            
</script>