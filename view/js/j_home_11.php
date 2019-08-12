<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();
        
        chart_nm11_1('nm11_chart_1');
        chart_nm11_2('nm11_chart_2');
        
        var datatable_h31 = undefined;  var cnt_h31 = 1;
        dataNew = $('#datatable_h31').DataTable({
            "ordering": false,
            "pageLength": 5,
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_h31'>><'col-sm-6 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_h31) {
                    datatable_h31 = new ResponsiveDatatablesHelper($('#datatable_h31'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_h31.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_h31.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function ( sValue, iColumn, nTr, iDataIndex ) {
                            if (datas.length < cnt_h31)
                                cnt_h31 = 1;
                            if ( iColumn === 0 )
                                return cnt_h31++;
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
                            if (datas.length < cnt_h31)
                                cnt_h31 = 1;
                            if ( iColumn === 0 )
                                return cnt_h31++;
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
                    {mData: 'data6', sClass: 'text-center'},
                    {mData: 'data7', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.data7 == '23/10/2016')
                                $label = '<b class="badge bg-color-orange" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i>Still need deeper checking." data-content="Still need deeper checking." data-html="true">' + row.data7 + '</b>';
                            else if (row.data7 == '24/10/2016')
                                $label = '<b class="badge bg-color-red" data-toggle="popover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="<form action=\'#\' ><div class=\'row\'><div class=\'col-md-11\'><textarea rows=\'4\' class=\'form-control\'></textarea></div></div></br><div class=\'form-actions\'><div class=\'row\'><div class=\'col-md-12\'><button class=\'btn btn-primary btn-sm\' type=\'button\'>Submit</button></div></div></div></form>" data-html="true">' + row.data7 + '</b>';
                            else 
                                $label = row.data7;
                            return $label;
                        }
                    },
                ]
        });         
        $("#datatable_h31 thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_h31 thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });
        $("#datatable_h31 thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });     
        $('#datatable_h31').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        
        datas = [{data1:'CEMS/203102/1', data2:'CEMS Installation', data4:'Rania Resources Sdn Bhd', data5:'', data6:'27/10/2016 12:20:20', data7:'28/10/2016'},
        {data1:'CEMSC/203102/1', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'},
        {data1:'CEMSC/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:27:34', data7:'24/10/2016'},
        {data1:'ADU/203102/2', data2:'Complaint', data4:'Sazali bin AHmad', data5:'', data6:'27/04/2016 12:28:37', data7:'23/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:24:54', data7:'24/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'},
        {data1:'CEMS/203102/2', data2:'Consultant Registration', data4:'Gula Pasir Sdn Bhd', data5:'', data6:'27/04/2016 12:20:20', data7:'23/10/2016'}];
        f_dataTable_draw(dataNew, datas);
    
    });
    
    function chart_nm11_1(chart_div) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: 'Current Pending Tasks by Category',
                floating: true,
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    innerSize: 50,
                    depth: 45,
                    dataLabels: {
                        enabled: true,
                        distance: 5,
                        format: '{point.short}: {y}',
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: '',
                data: [
                    {name:'CEMS Installation', y:3, short:'CEMS Inst'},
                    {name:'PEMS Installation', y:8, short:'PEMS Inst'},
                    {name:'CEMS Consultant', y:21, short:'CEMS Cons'},
                    {name:'PEMS Consultant', y:11, short:'PEMS Cons'},
                    {name:'Analyzer', y:4, short:'Analyzer'},
                    {name:'Complaint', y:4, short:'Complaint'}
                ]
            }]
        });
        
    }
    
    function chart_nm11_2(chart_div,parameter,dataset) {
        var categories = ['Complaint Feedback',
            'CEMS Analyzer Registraton', 'PEMS Consultant Registration', 'CEMS Consultant Registration', 'PEMS Installation', 'CEMS Installation'];
        Highcharts.chart(chart_div, {
            chart: {
                type: 'bar',
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: -15,
                    viewDistance: 25,
                    depth: 40
                }
            },
            title: {
                text: 'Pending Tasks Summary'
            },
            subtitle: {
                text: 'Due date Monitoring by Application Type'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: false,
                categories: categories,
                linkedTo: 0,
                labels: {
                    enabled: false,
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return this.value<0?-this.value:this.value;
                    }
                }
            },
            plotOptions: {
                series: {
                    stacking: 'normal'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ' for ' + this.point.category + '</b><br/>' +
                        'Total Tasks: ' + Highcharts.numberFormat(this.point.y, 0);
                }
            },

            series: [{
                name: 'Late Submission',
                color: '#d12c23',
                data: [-7, -8, -1, -3, -0.01, -32]
            }, {
                name: 'On-time Submission',
                color: '#19b71c',
                data: [10, 9, 2, 15, 3, 40]
            }]
        });
        
    }
    
</script>