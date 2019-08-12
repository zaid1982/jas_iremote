<?php 
include 'view/js/j_modal_cems.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        var datatable_cpb = undefined;  var cnt_cpb = 1;
        dataNew = $('#datatable_cpb').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_cpb'>><'col-sm-6 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_cpb) {
                    datatable_cpb = new ResponsiveDatatablesHelper($('#datatable_cpb'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cpb.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cpb.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_cpb)
                                cnt_cpb = 1;
                            if ( iColumn === 0 )
                                return cnt_cpb++;
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
                            if (datas.length < cnt_cpb)
                                cnt_cpb = 1;
                            if ( iColumn === 0 )
                                return cnt_cpb++;
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
                    {mData: 'data4'},
                    {mData: 'data6'},
                    {mData: 'data5'},
                    {mData: 'data7', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}}, //  visible:false, 
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.data8 == 'Active')
                                $label = '<b class="badge bg-color-green"> '+row.data8+' </b>';
                            else 
                                $label = '<b class="badge bg-color-yellow"> '+row.data8+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="cpb_btn_info" title="Analyzer Information" onclick="f_load_cems (3, '+row.cems_id+',\'cpb\');"><i class="fa fa-info-circle"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("div.toolbar_cpb").html('<div style="padding-bottom:5px; width:300px" class="selectContainer">' +
            '<select class="form-control" id="" style="width:250px"><option value="">All States</option><option value="">Selangor</option></select></div>');
         
        $("#datatable_cpb thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_cpb thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_cpb thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        datas = [{data1:'CEMS', data2:'Petronas MTBE Gebeng', data3:'Fuel Burning Equipment', data4:'D0001', data5:'SIRA 1000011/12', data6:'Rania Resources Sdn Bhd', data7:'2016-04-14 12:32:33', data8:'Active'},
        {data1:'PEMS', data2:'Kilang Perabot Nilai', data3:'Heat and Power Generation', data4:'D0021', data5:'Software B', data6:'Rania Resources Sdn Bhd', data7:'2015-08-15 23:32:44', data8:'Not Active'}];
        f_dataTable_draw(dataNew, datas);
        
        
    });
            
</script>