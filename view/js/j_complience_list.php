<? 
include 'view/js/j_modal_cems.php';
include 'view/js/j_modal_pems.php';
include 'view/js/j_modal_response.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();        
                
        var datatable_cmn = undefined;  var cnt_cmn = 1;
        dataNew = $('#datatable_cmn').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-3 col-xs-12'<'toolbar_cmn'>><'col-sm-9 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_cmn) {
                    datatable_cmn = new ResponsiveDatatablesHelper($('#datatable_cmn'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cmn.createExpandIcon(nRow);          
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));      
            },
            "drawCallback": function (oSettings) {
                datatable_cmn.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_cmn)
                                cnt_cmn = 1;
                            if ( iColumn === 0 )
                                return cnt_cmn++;
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
                            if (datas.length < cnt_cmn)
                                cnt_cmn = 1;
                            if ( iColumn === 0 )
                                return cnt_cmn++;
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
                    {mData: 'data1'},
                    {mData: 'data2', sClass: 'text-center'},
                    {mData: 'data3', sClass: 'text-center'},
                    {mData: 'data4', sClass: 'text-center'},
                    {mData: 'data5', sClass: 'text-center'},
                    {mData: 'data6', sClass: 'text-right'},
                    {mData: 'data7', sClass: 'text-right'},
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.data8 == 'Fail')
                                $label = '<b class="badge bg-color-red"> '+row.data8+' </b>';
                            else
                                $label = '<b class="badge bg-color-green"> '+row.data8+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="" title="Consultant Information" onclick="f_load_cems(3);"><i class="fa fa-info-circle"></i></button>';
                            if (row.data8 == 'Fail')
                                $label += '&nbsp;<button type="button" class="btn btn-warning btn-xs" id="cmn_btn_response" title="Industrial Response" onclick="f_load_mre (3,\'cmn\');"><i class="fa fa-comment"></i></button>';
                            return $label;
                        }
                    }
                ]
        });  
        $("#datatable_cmn thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cmn thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cmn thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });  
        
        datas = [{data1:'Kilang Kelapa Sawit Nilai', data2:'6593843-2', data3:'S00012', data4:'21/03/2016 14:23:44', data5:'CO', data6:'60', data7:'80', data8:'Fail'},
            {data1:'MTBE Petronas Gebeng', data2:'693433D-1', data3:'M00001', data4:'24/03/2016 11:45:22', data5:'NO2', data6:'80', data7:'60', data8:'Good'}];
        f_dataTable_draw(dataNew, datas);
        
    });
    
            
</script>