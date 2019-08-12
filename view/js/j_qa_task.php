<? 
include 'view/js/j_modal_analyzer.php';
include 'view/js/j_modal_qa_report.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        var datatable_qat = undefined;  var cnt_qat = 1;
        dataNew = $('#datatable_qat').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_qat'>><'col-sm-6 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_qat) {
                    datatable_qat = new ResponsiveDatatablesHelper($('#datatable_qat'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_qat.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_qat.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_qat)
                                cnt_qat = 1;
                            if ( iColumn === 0 )
                                return cnt_qat++;
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
                            if (datas.length < cnt_qat)
                                cnt_qat = 1;
                            if ( iColumn === 0 )
                                return cnt_qat++;
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
                    {mData: 'data1'},
                    {mData: 'data2'},
                    {mData: 'data3'},
                    {mData: 'data4'},
                    {mData: 'data5'},
                    {mData: 'data6', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: 'data7', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.data8 == 'Done')
                                $label = '<b class="badge bg-color-green"> '+row.data8+' </b>';
                            else if (row.data8.indexOf('In')>=0)
                                $label = '<b class="badge bg-color-yellow"> '+row.data8+' </b>';
                            else 
                                $label = '<b class="badge bg-color-red"> '+row.data8+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="qat_btn_info" title="Analyzer Information" onclick="f_load_analyzer (3, '+row.cems_id+',\'qat\');"><i class="fa fa-info-circle"></i></button>';
                            if (row.data8 == 'Done') {                                
                                $label += ' <button type="button" class="btn btn-warning btn-xs" id="qat_btn_qa" title="QA Report" onclick="f_load_qa_report (3, '+row.cems_id+',\'qat\');"><i class="fa fa-check-square-o"></i></button>';
                            } else {
                                $label += ' <button type="button" class="btn btn-warning btn-xs" id="qat_btn_qa" title="QA Report" onclick="f_load_qa_report (2, '+row.cems_id+',\'qat\');"><i class="fa fa-check-square-o"></i></button>';
                            }
                            return $label;
                        }
                    }
                ]
        });
        $("div.toolbar_qat").html('<div style="padding-bottom:5px; width:300px" class="selectContainer">' +
            '<select class="form-control" id="" style="width:250px"><option value="">All States</option><option value="">Selangor</option></select></div>');
         
        $("#datatable_qat thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_qat thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_qat thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        datas = [{data1:'F1001', data2:'CEMS', data3:'SIRA 100212/13', data4:'Rania Resources Sdn Bhd', data5:'RATA', data6:'2016-04-14', data7:'2016-04-14 12:32:33', data8:'Late 15 days'},
        {data1:'F1001', data2:'CEMS', data3:'SIRA 100212/13', data4:'Rania Resources Sdn Bhd', data5:'RAA', data6:'2016-05-15', data7:'2016-05-15 23:32:44', data8:'In 3 days'},
        {data1:'F1001', data2:'CEMS', data3:'SIRA 100212/13', data4:'Rania Resources Sdn Bhd', data5:'RAA', data6:'2015-08-15', data7:'2015-08-15 23:32:44', data8:'Done'}];
        f_dataTable_draw(dataNew, datas);
        
        
    });
            
</script>