<? 
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
include 'view/js/j_modal_change_consultant.php';
include 'view/js/j_modal_plan_test.php';
include 'view/js/j_modal_cems_test.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $("#icm_dateRegistered").datepicker({
            dateFormat: 'dd/mm/yy',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: true,
            closeText:'Clear',
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            },
            onSelect: function( input ) {
                dataNew.column('7:visible').search(input).draw();
            }
        });
        
        var datatable_icm = undefined;  var cnt_icm = 1;
        dataNew = $('#datatable_icm').DataTable({
            //"aaSorting": [[6,'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_icm'>><'col-sm-6 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_icm) {
                    datatable_icm = new ResponsiveDatatablesHelper($('#datatable_icm'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_icm.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_icm.respond();
                $("#date_row_1").datepicker({
                    dateFormat: 'dd/mm/yy',
                    defaultDate: '0',
                    changeMonth: true,
                    changeYear: true,
                    prevText: '<i class="fa fa-chevron-left"></i>',
                    nextText: '<i class="fa fa-chevron-right"></i>',
                    showButtonPanel: true,
                    closeText:'Clear',
                    beforeShow: function( input ) {
                        setTimeout(function() {
                            var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                            clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                            }, 1 );
                    }
                });
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_icm)
                                cnt_icm = 1;
                            if ( iColumn === 0 )
                                return cnt_icm++;
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
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {                            
                            if (datas.length < cnt_icm)
                                cnt_icm = 1;
                            if ( iColumn === 0 )
                                return cnt_icm++;
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
                    {mData: 'wfTrans_no'},
                    {mData: 'industryType_desc'},
                    {mData: 'equipment_stackNo'},
                    {mData: 'source'},
                    {mData: 'industrial_name'},
                    {mData: 'analyzer'},
                    {mData: 'equipment_timeApplied', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.status_desc == 'Active')
                                $label = '<b class="badge bg-color-green"> '+row.status_desc+' </b>';
                            else if (row.status_desc == 'Processing')
                                $label = '<b class="badge bg-color-teal"> '+row.status_desc+' </b>';
                            else if (row.status_desc == 'Plan Test')
                                $label = '<b class="badge bg-color-blueDark"> '+row.status_desc+' </b>';
                            else if (row.status_desc == 'DATA Test')
                                $label = '<b class="badge bg-color-blueLight"> '+row.status_desc+' </b>';
                            else 
                                $label = '<b class="badge bg-color-yellow"> '+row.status_desc+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.status_desc == 'Draft') {    
                                $label = '<button type="button" class="btn btn-warning btn-xs" id="icm_btn_edit" title="Edit" onclick="f_load_cems (2, '+row.wfTask_id+',\'icm\');"><i class="fa fa-pencil"></i></button>';
                                $label += ' <button type="button" class="btn btn-danger btn-xs" id="icm_btn_delete" title="Delete" onclick="f_load_cems (2, '+row.wfTask_id+',\'icm\');"><i class="fa fa-minus"></i></button>';
                            } else {  
                                $label = '<button type="button" class="btn btn-info btn-xs" id="icm_btn_info" title="Info" onclick="f_load_pems (3, '+row.wfTask_id+',\'icm\');"><i class="fa fa-info-circle"></i></button>';
                                if (row.status_desc == 'Active') {
                                    $label += ' <button type="button" class="btn btn-warning btn-xs" id="icm_btn_change_consultant" title="Change Maintenance Consultant" onclick="f_load_change_consultant (1, '+row.wfTask_id+',\'icm\');"><i class="fa fa-user-secret"></i></button>';
                                    $label += ' <button type="button" class="btn btn-danger btn-xs" id="icm_btn_shutdown" data-toggle="popover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-pause\'></i> Shutdown" data-content="<form action=\'#\' ><div class=\'row padding-bottom-10\'><div class=\'col-md-3\'>Date From</div><div class=\'col-md-8\'><input type=\'date\' class=\'form-control\'  /></div></div><div class=\'row padding-bottom-10\'><div class=\'col-md-3\'>Date To</div><div class=\'col-md-8\'><input type=\'date\' class=\'form-control\'  /></div></div><div class=\'row\'><div class=\'col-md-3\'>Reason</div><div class=\'col-md-8\'><textarea rows=\'4\' class=\'form-control\'></textarea></div></div></br><div class=\'form-actions\'><div class=\'row\'><div class=\'col-md-12\'><button class=\'btn btn-primary btn-sm\' type=\'button\' onclick=\'f_shutdown_submit();\'>Submit</button></div></div></div></form>" data-html="true"><i class="fa fa-pause"></i></button>';
                                } else if (row.status_desc == 'Plan Test') {
                                    $label += ' <button type="button" class="btn btn-success btn-xs" id="icm_btn_plan_test" title="Plan Initial RATA Test" onclick="f_load_plan_test (1, '+row.wfTask_id+',\'icm\');"><i class="fa fa-mail-forward"></i></button>';
                                } else if (row.status_desc == 'DATA Test') {
                                    $label += ' <button type="button" class="btn btn-success btn-xs" id="icm_btn_plan_test" title="Initial RATA Test Report" onclick="f_load_cems_test (1, '+row.wfTask_id+',\'icm\');"><i class="fa fa-mail-forward"></i></button>';
                                }
                            }
                            return $label;
                        }
                    }
                ]
        });
        $("div.toolbar_icm").html('<div style="padding-bottom:5px">' +
            '<button type="button" class="btn btn-labeled bg-color-pinkDark txt-color-white" id="icm_btn_addCems"><span class="btn-label"><i class="fa fa-plus"></i></span>Apply New CEMS</button>&nbsp;' +
            '<button type="button" class="btn btn-labeled bg-color-teal txt-color-white" id="icm_btn_addPems"><span class="btn-label"><i class="fa fa-plus"></i></span>Apply New PEMS</button></div>');
        
        //filter
        $("#datatable_icm thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_icm thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_icm thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });     
        $('#datatable_icm').on('draw.dt', function () {
            $('#icm_btn_shutdown').popover().click(function(e) {
                $('#icm_btn_shutdown').not(this).popover('hide');
                $(this).popover('toggle');
            });
        });
        
        datas = [{source:'Fuel Burning Equipment', analyzer:'SIRA 1000011/12', wfTrans_no:'VD20231', industrial_regNo:'ABCDEF', industrial_name:'Slag Cement Sdn Bhd', industryType_desc:'CEMS', equipment_stackNo:'CSD2323', state_desc:'Pahang', equipment_timeApplied:'2016-05-15 23:32:44', status_desc:'Draft'},
            {source:'Heat and Power Generation', analyzer:'Software A', wfTrans_no:'VD22322', industrial_regNo:'FEFESS', industrial_name:'Bell Palm Industries Sdn Bhd', industryType_desc:'PEMS', equipment_stackNo:'UFE324234', state_desc:'Perak', equipment_timeApplied:'2014-04-14 12:32:33', status_desc:'Processing'},
            {source:'Heat and Power Generation', analyzer:'CE02392', wfTrans_no:'VD22323', industrial_regNo:'EFEFE', industrial_name:'Hugo Oil Sdn Bhd', industryType_desc:'CEMS', equipment_stackNo:'GR23232', state_desc:'Selangor', equipment_timeApplied:'2016-05-04 23:12:14', status_desc:'Plan Test'},
            {source:'Heat and Power Generation', analyzer:'VEE3242', wfTrans_no:'VD22325', industrial_regNo:'KR3232', industrial_name:'Ujang Industry Sdn Bhd', industryType_desc:'CEMS', equipment_stackNo:'FE32342', state_desc:'Negeri Sembilan', equipment_timeApplied:'2016-03-23 06:36:32', status_desc:'DATA Test'},
            {source:'Heat and Power Generation', analyzer:'Software B', wfTrans_no:'VD20224', industrial_regNo:'DEFGHI', industrial_name:'Bell Palm Industries Sdn Bhd', industryType_desc:'PEMS', equipment_stackNo:'UFE324234', state_desc:'Terengganu', equipment_timeApplied:'2014-04-14 12:32:33', status_desc:'Active'}];
        f_dataTable_draw(dataNew, datas);
        
        $('#icm_btn_addCems').on('click', function () {
            f_load_cems(1,'','icm');          
        }); 
        
        $('#icm_btn_addPems').on('click', function () {
            f_load_pems(1,'','icm');          
        }); 
                
    });
    
    function f_shutdown_submit() {
        
        $('#icm_btn_shutdown').popover('hide');
    }
            
</script>