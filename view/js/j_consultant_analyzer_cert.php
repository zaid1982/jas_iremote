<?php 
include 'view/js/j_modal_consultant_cems.php';
include 'view/js/j_modal_consultant_pems.php';
include 'view/js/j_modal_consultant_mobile.php';
include 'view/js/j_modal_renew_cert.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $('#cac_dateExpiry').daterangepicker({
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
            $('#cac_table_title').html($('#cac_dateExpiry').val() != '' ? '<i>(Expiry Date : '+$('#cac_dateExpiry').val()+')</i>' : '');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            $('#cac_table_title').html($('#cac_dateExpiry').val() != '' ? '<i>(Expiry Date : '+$('#cac_dateExpiry').val()+')</i>' : '');
        }).val('');
        
        var datatable_cac = undefined;  var cnt_cac = 1;
        dataNew = $('#datatable_cac').DataTable({
            "aaSorting": [[4,'asc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cac) {
                    datatable_cac = new ResponsiveDatatablesHelper($('#datatable_cac'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cac.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cac.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_cac_new.length < cnt_cac)
                                cnt_cac = 1;
                            if ( iColumn === 0 )
                                return cnt_cac++;
                            else if ( iColumn === 7 )
                                return data_cac_new[iDataIndex].status_desc;
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
                            if (data_cac_new.length < cnt_cac)
                                cnt_cac = 1;
                            if ( iColumn === 0 )
                                return cnt_cac++;
                            else if ( iColumn === 7 )
                                return data_cac_new[iDataIndex].status_desc;
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
                    {mData: 'certificate_no'},                  
                    {mData: 'certIssuer_desc'},
                    {mData: 'certificate_basic'},
                    {mData: 'model_no'},
                    {mData: 'analyzer_type'},
                    {mData: 'certificate_dateExpired'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                            if (row.renew_status == '4')
                                $label += '<b class="badge bg-color-blueLight"> Submitted </b>';
                            if (row.renew_status == '22')
                                $label += '<b class="badge bg-color-magenta"> Returned </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.consAll_type == '1')       modal_open = 'cems';
                            else if (row.consAll_type == '3')  modal_open = 'mobile';
                            $label = '<button type="button" class="btn btn-info btn-xs" title="Analyzer Information" onclick="f_load_consultant_'+modal_open+' (3, \'\', '+row.consAll_id+',\'cac\');"><i class="fa fa-info-circle"></i></button>';
                            if (row.renew_taskType == null || row.renew_taskType == '81') {
                                var load_type = row.renew_task==null?'1':'2';
                                var btn_color = row.status_id=='37'?'danger':'success';
                                if (load_type == '2')   btn_color = 'warning';
                                var cert_id = load_type=='2'?row.renew_id:row.certificate_id;
                                $label += ' <button type="button" class="btn btn-'+btn_color+' btn-xs" title="Renew Certificate" onclick="f_load_renew_cert ('+load_type+', '+cert_id+', '+row.renew_task+',\'cac\');"><i class="fa fa-edit"></i></button>';
                            } else if (row.renew_task != null) {
                               $label += ' <button type="button" class="btn btn-primary btn-xs" title="Renewal Information" onclick="f_load_renew_cert (3, '+row.renew_id+', '+row.renew_task+',\'cac\');"><i class="fa fa-certificate"></i></button>'; 
                            }
                            return $label;
                        }
                    }
                ]
        });
        $('#datatable_cac').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        $("#datatable_cac thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cac thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        
        $('#cac_dateExpiry2').daterangepicker({
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
            $('#cac_table_title2').html($('#cac_dateExpiry').val() != '' ? '<i>(Expiry Date : '+$('#cac_dateExpiry2').val()+')</i>' : '');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataHistory.column(6).search('').draw();
            $('#cac_table_title2').html($('#cac_dateExpiry').val() != '' ? '<i>(Expiry Date : '+$('#cac_dateExpiry2').val()+')</i>' : '');
        }).val('');
        
        var datatable_cac2 = undefined;  var cnt_cac2 = 1;
        dataHistory = $('#datatable_cac_history').DataTable({
            "aaSorting": [[4,'asc']],
            "sDom": "<'dt-toolbar'<'col-sm-5 hidden-xs'l><'col-sm-7 col-xs-12'CT>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-xs-5'i><'col-xs-7'p>>",
            "autoWidth": true,
            "preDrawCallback": function () {
                if (!datatable_cac2) {
                    datatable_cac2 = new ResponsiveDatatablesHelper($('#datatable_cac_history'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cac2.createExpandIcon(nRow);
                var info = dataHistory.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cac2.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (data_cac_history.length < cnt_cac2)
                                cnt_cac2 = 1;
                            if ( iColumn === 0 )
                                return cnt_cac2++;
                            else if ( iColumn === 7 )
                                return data_cac_history[iDataIndex].status_desc;
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
                            if (data_cac_history.length < cnt_cac2)
                                cnt_cac2 = 1;
                            if ( iColumn === 0 )
                                return cnt_cac2++;
                            else if ( iColumn === 7 )
                                return data_cac_history[iDataIndex].status_desc;
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
                    {mData: 'certificate_no'},                  
                    {mData: 'certIssuer_desc'},
                    {mData: 'certificate_basic'},
                    {mData: 'model_no'},
                    {mData: 'analyzer_type'},
                    {mData: 'certificate_dateExpired'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            var modal_open = '';
                            if (row.consAll_type == '1')       modal_open = 'cems';
                            else if (row.consAll_type == '3')  modal_open = 'mobile';
                            $label = '<button type="button" class="btn btn-info btn-xs" title="Analyzer Information" onclick="f_load_consultant_'+modal_open+' (3, \'\', '+row.wfTask_refValue+',\'cac2\');"><i class="fa fa-info-circle"></i></button>';
                            if (row.renew_task != null) 
                               $label += ' <button type="button" class="btn btn-primary btn-xs" title="Renewal Information" onclick="f_load_renew_cert (3, '+row.renew_id+', '+row.renew_task+',\'cac\');"><i class="fa fa-certificate"></i></button>'; 
                            return $label;
                        }
                    }
                ]
        });
        $('#datatable_cac2').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        $("#datatable_cac2 thead th input[type=text]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cac2 thead th input[type=number]").on('keyup change', function () {
            dataHistory.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){ 
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#cac_wfGroup_id').val(wf_group.wfGroup_id);            
            f_table_cac_new ();
            f_table_cac_history ();
            f_cac_certificate_bar ();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');          

    });
    
    function f_table_cac_new () {
        data_cac_new = f_get_general_info_multiple('dt_certificate_cons', {wfGroup_id:$('#cac_wfGroup_id').val()!=''?$('#cac_wfGroup_id').val():' ', certificate_status:'1'});
        f_dataTable_draw(dataNew, data_cac_new, 'datatable_cac', 9);
    }
    
    function f_table_cac_history () {
        data_cac_history = f_get_general_info_multiple('dt_certificate_cons', {wfGroup_id:$('#cac_wfGroup_id').val()!=''?$('#cac_wfGroup_id').val():' ', certificate_status:'3'});
        f_dataTable_draw(dataHistory, data_cac_history, 'datatable_cac_history', 9);
    }
    
    function f_cac_certificate_bar () {
        var data_bar = f_get_general_info_multiple('vw_hm_bar_6', {wfGroup_id:$('#cac_wfGroup_id').val()}, '', '', 'consAll_id');
        if (data_bar.length > 0) {
            var cur_consAll_id = '';
            $.each(data_bar, function(u){ 
                if (cur_consAll_id == '' || cur_consAll_id != data_bar[u].consAll_id) {
                    if (cur_consAll_id != '')
                        $('#cac_div_certBar').append('<hr class="simple">');
                    cur_consAll_id = data_bar[u].consAll_id;
                    $('#cac_div_certBar').append('<h6 class="padding-bottom-5">CEMS Analyzer ><small> Model '+data_bar[u].model_no+'</small></h6>');   
                }
                var perc = parseInt(data_bar[u].diff_t_e) > 100 ? 100 : parseInt(data_bar[u].diff_t_s)/parseInt(data_bar[u].diff_e_s)*100;
                var days_expiry = parseInt(data_bar[u].diff_t_e) > 100 ? 'expired' : -parseInt(data_bar[u].diff_t_e)+'-days';
                var alert_red = parseInt(data_bar[u].diff_t_e) > 100 ? 'txt-color-red' : '';
                var html = '<p class="txt-color-blueDark margin-bottom-5"><strong>'+data_bar[u].certIssuer_desc+'</strong> - <i>cert. no:</i> '+data_bar[u].certificate_no+'<span class="hidden-xs">, <i>start:</i> '+convert_date_to_picker(data_bar[u].certificate_dateStart)+'</span> <span class="pull-right '+alert_red+'"><i class="fa fa-warning"></i> <i>Expiry date:</i> '+convert_date_to_picker(data_bar[u].certificate_dateExpired)+' ('+days_expiry+')</span></p>' +
                        '<div class="progress progress-striped active">' +
                        '<div class="progress-bar bg-color-'+bg_color_set[u%bg_color_set.length]+'" role="progressbar" style="width: '+perc+'%"></div>' +
                    '</div>';
                $('#cac_div_certBar').append(html);
            }); 
        } else {
            var html = '<div class="alert alert-block alert-warning">' +
                    '<i class="fa-fw fa fa-warning"></i>You have no certificate registered to any active analyzer yet.' +
                '</div>';
            $('#cac_div_certBar').html(html); 
        }
    }
            
</script>