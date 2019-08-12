<? 
include 'view/js/j_modal_qnf.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        var datatable_qfe = undefined;  var cnt_qfe = 1;
        dataNew = $('#datatable_qfe').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_qfe'>><'col-sm-6 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_qfe) {
                    datatable_qfe = new ResponsiveDatatablesHelper($('#datatable_qfe'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qfe.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qfe.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_qfe)
                                cnt_qfe = 1;
                            if ( iColumn === 0 )
                                return cnt_qfe++;
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
                            if (datas.length < cnt_qfe)
                                cnt_qfe = 1;
                            if ( iColumn === 0 )
                                return cnt_qfe++;
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
                    {mData: 'data1', sClass: 'text-center'},
                    {mData: 'data2', sClass: 'text-center'},
                    {mData: 'data4'},
                    {mData: 'data7'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.data8 == 'Closed')
                                $label = '<b class="badge bg-color-green"> '+row.data8+' </b>';
                            else if (row.data8 == 'Feedback')
                                $label = '<b class="badge bg-color-red"> '+row.data8+' </b>';
                            else if (row.data8 == 'Post')
                                $label = '<b class="badge bg-color-orange"> '+row.data8+' </b>';
                            else if (row.data8 == 'Solved')
                                $label = '<b class="badge bg-color-greenLight"> '+row.data8+' </b>';
                            else 
                                $label = '<b class="badge bg-color-yellow"> '+row.data8+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="qfe_btn_info" title="Query and Feedback Conversation" onclick="f_load_qnf (3, '+row.cems_id+',\'qfe\');"><i class="fa fa-comments-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("div.toolbar_qfe").html('<div style="padding-bottom:5px">' +
            '<button type="button" class="btn btn-labeled bg-color-pinkDark txt-color-white" id="qfe_btn_post"><span class="btn-label"><i class="fa fa-plus"></i></span>Post New Inquiry</button></div>');
        $("#datatable_qfe thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_qfe thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_qfe thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        $('#qfe_btn_post').click(function () {
            f_load_qnf (1, '', 'qfe');
        });
        
        datas = [{data1:'Q160110001P', data2:'2016-08-10 12:20:20', data3:'Masadi bin Ahmadi', data4:'CEMS Form', data5:'Sulaiman Bin Razak', data6:'2016-04-10 12:20:20', data7:'Terdapat pilihan category dari fuel type yang tidak clear untuk diisi...', data8:'Post'},
        {data1:'Q160110001S', data2:'2016-08-10 02:20:13', data3:'Junaidi bin Azman', data4:'System Issue', data5:'Ali bin Ahmad', data6:'2015-08-08 09:45:34', data7:'Bila permohonan disemak dan dipulangkan ke pegawai pemproses...', data8:'Feedback'},
        {data1:'Q160110002S', data2:'2016-08-08 13:53:43', data3:'Junaidi bin Azman', data4:'System Issue', data5:'', data6:'2015-08-01 03:54:12', data7:'Bila permohonan disemak dan dipulangkan ke pegawai pemproses...', data8:'Closed'}];
        f_dataTable_draw(dataNew, datas);
        
    });
            
</script>