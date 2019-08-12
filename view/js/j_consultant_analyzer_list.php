<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
                
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.2/js/buttons.colVis.min.js"></script>    

<?php 
include 'view/js/j_modal_consultant_cems.php';
?>  

<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $('#cca_dateRegistered').daterangepicker({
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
            $('#cca_table_title').html('<i>(Registered Date : '+$(this).val()+')</i>');
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            dataNew.column(6).search('').draw();
            $('#cca_table_title').html('');
        }).val('');                      
        
        var datatable_cca = undefined;   
        var but_cca = {
            exportOptions: {
                format: {
                    body: function ( data, row, column, node ) {
                        if (column === 8)
                            return '';
                        else if (column === 7)
                            return datas[row].status_desc;
                        else {
                            return column === 0 ? (row+1) : data;
                        }
                    }
                }
            }
        };     
        dataNew = $('#datatable_cca').DataTable({
            "aaSorting": [[1,'desc']],
            dom: 'l<"pull-right"B>rtip',
            buttons: [	
                $.extend( true, {}, but_cca, {
                    extend: 'copyHtml5'
                }),
                $.extend( true, {}, but_cca, {
                    extend: 'excelHtml5'
                }),
                $.extend( true, {}, but_cca, {
                    extend: 'csvHtml5'
                }),
                $.extend( true, {}, but_cca, {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }),
                'colvis'
            ],
            "preDrawCallback": function () {
                if (!datatable_cca) {
                    datatable_cca = new ResponsiveDatatablesHelper($('#datatable_cca'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cca.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cca.respond();
            },
            "aoColumns":
                [
                    {mData: null, bSortable: false, sClass: 'text-center'},
                    {mData: 'wfTrans_no', mRender: function (data, type, row) { return row.wfTrans_regNo != null ? row.wfTrans_regNo : data; }},                  
                    {mData: 'consCems_modelNo'},                   
                    {mData: 'consCems_brand'},
                    {mData: 'cons_type'},
                    {mData: 'consType_type'}, 
                    {mData: 'wfTrans_timeSubmit'},
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.status_id == '2') {    
                                $label = '<button type="button" class="btn btn-warning btn-xs" id="cca_btn_edit" title="Edit" onclick="f_load_consultant_cems (2, '+row.wfGroup_id+', '+row.consAll_id+',\'cca\');"><i class="fa fa-pencil"></i></button> ';
                                $label += '<button type="button" class="btn btn-danger btn-xs" id="cca_btn_delete" title="Delete" onclick="f_delete_consultant_cems ('+row.wfTask_id+','+row.consAll_id+');"><i class="fa fa-minus"></i></button>';
                            } else if (row.status_id == '22') {    
                                $label = '<button type="button" class="btn btn-success btn-xs" id="cca_btn_edit" title="Revise" onclick="f_load_consultant_cems (2, '+row.wfGroup_id+', '+row.consAll_id+',\'cca\');"><i class="fa fa-pencil-square-o"></i></button> ';
                            } else   
                                $label = '<button type="button" class="btn btn-info btn-xs" id="cca_btn_info" title="Info" onclick="f_load_consultant_cems (3, '+row.wfGroup_id+', '+row.consAll_id+',\'cca\');"><i class="fa fa-info-circle"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("#datatable_cca thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cca thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cca thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });         
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#cca_wfGroup_id').val(wf_group.wfGroup_id);
            f_cca_set_alert();
            f_table_cca();   
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    });
    
    function f_table_cca () {
        datas = f_get_general_info_multiple('dt_consultant_cems_cons', {wfGroup_id:$('#cca_wfGroup_id').val()!=''?$('#cca_wfGroup_id').val():' '});
        f_dataTable_draw(dataNew, datas, 'datatable_cca', 9);
    }
    
    function f_delete_consultant_cems (wfTask_id, consAll_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit(wfTask_id, '1', '14', 'Draft data successfully deleted.', '', '2', '', '', 'consAll_id', consAll_id)) {                        
                f_table_cca ();
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
    function f_cca_set_alert() {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', $('#cca_wfGroup_id').val(), 'wfGroup_isFirstTime');         
        if (isFirstTime == '1') {
            $('#cca_alert').removeClass('hide');
            $('#cca_btn_upd_cons').removeClass('hide');
            $('#cca_alert_txt').html('You are 1st time login as <strong>Consultant</strong>. Please complete the <strong>Consultant Information</strong> first before proceed to registration.');
        } else {
            $('#cca_info_register').removeClass('hide');
        }        
    }
            
</script>