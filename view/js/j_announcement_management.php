<?php 
include 'view/js/j_modal_announcement.php';
?>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        var datatable_anc = undefined;  var cnt_anc = 1;
        dataNew = $('#datatable_anc').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_anc'>><'col-sm-6 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_anc) {
                    datatable_anc = new ResponsiveDatatablesHelper($('#datatable_anc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_anc.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_anc.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_anc)
                                cnt_anc = 1;
                            if ( iColumn === 0 )
                                return cnt_anc++;
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
                            if (datas.length < cnt_anc)
                                cnt_anc = 1;
                            if ( iColumn === 0 )
                                return cnt_anc++;
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
                    {mData: 'data2', sClass: 'text-center'},
                    {mData: 'data3'},
                    {mData: 'data4'},
                    {mData: 'data5', sClass: 'text-center'},
                    {mData: 'data6', sClass: 'text-center'},
                    {mData: 'data7'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.data8 == 'Active')
                                $label = '<b class="badge bg-color-green"> '+row.data8+' </b>';
                            else if (row.data8 == 'Waiting')
                                $label = '<b class="badge bg-color-blueLight"> '+row.data8+' </b>';
                            else 
                                $label = '<b class="badge bg-color-yellow"> '+row.data8+' </b>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-info btn-xs" id="anc_btn_info" title="Edit Announcement" onclick="f_load_announcement (2, '+row.cems_id+',\'anc\');"><i class="fa fa-edit"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        $("div.toolbar_anc").html('<div style="padding-bottom:5px">' +
            '<button type="button" class="btn btn-labeled bg-color-teal txt-color-white" id="anc_btn_add" onclick="f_load_announcement(1,\'\',\'anc\')"><span class="btn-label"><i class="fa fa-plus"></i></span>Add New Announcement</button></div>');
         
        $("#datatable_anc thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_anc thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_anc thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        datas = [{data1:'Q160110001P', data2:'2016-08-10 12:20:20', data3:'Masadi bin Ahmadi', data4:'Announcement', data5:'2016-04-01 12:20:20', data6:'2016-04-10 12:20:20', data7:'Please be informed that starting 1/7/2017, CEMS and PEMS Installation application must be done through iRemote System.', data8:'Active'},
        {data1:'Q160110001S', data2:'2016-08-10 02:20:13', data3:'Junaidi bin Azman', data4:'News', data5:'2016-04-10 12:20:20', data6:'2015-08-08 09:45:34', data7:'Syarikat Adha Sdn Bhd has been fined $500,000 from exceeding the allowed quantity of NOX from their chimney.', data8:'Waiting'},
        {data1:'Q160110003S', data2:'2016-08-08 13:53:43', data3:'Junaidi bin Azman', data4:'Information', data5:'2016-04-10 12:20:20', data6:'2015-08-01 03:54:12', data7:'Please keep alert on the application notification from email and login to iRemote system to proceed.', data8:'Done'}];
        f_dataTable_draw(dataNew, datas);
        
    });
            
</script>