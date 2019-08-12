<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        $("#aud_action_date").datepicker({
            dateFormat: 'yy-mm-dd',
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
                dataNew.column('6:visible').search(input).draw();
            }
        });
        
        var datatable_aud = undefined;  var cnt_aud = 1;
        dataNew = $('#datatable_aud').DataTable({
            "sDom": "<'dt-toolbar'<'col-sm-4 col-xs-12'<'toolbar_aud'>><'col-sm-8 hidden-xs'lTC>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6'i><'col-sm-6'p>>",
            "aaSorting": [6,'desc'],
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_aud) {
                    datatable_aud = new ResponsiveDatatablesHelper($('#datatable_aud'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_aud.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_aud.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_aud)
                                cnt_aud = 1;
                            if ( iColumn === 0 )
                                return cnt_aud++;
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
                            if (datas.length < cnt_aud)
                                cnt_aud = 1;
                            if ( iColumn === 0 )
                                return cnt_aud++;
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
                    {mData: 'profile_name'},
                    {mData: 'profile_icNo'},
                    {mData: 'role_list'},
                    {mData: 'audit_ip'},
                    {mData: 'audit_place'},
                    {mData: 'audit_timestamp'},
                    {mData: 'auditModule_desc'},
                    {mData: 'auditAction_desc'}
                ]
        });
         
        $("#datatable_aud thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_aud thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_aud thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });        
        
        datas = f_get_general_info_multiple('dt_audit');
        f_dataTable_draw(dataNew, datas);
        
    });
            
</script>