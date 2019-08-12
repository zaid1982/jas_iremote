<!-- Full Calendar -->
<script src="js/plugin/moment/moment.min.js"></script>
<script src="js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>
<? 
include 'view/js/j_modal_response.php';
?>
<script type="text/javascript">

    $(document).ready(function () {

        pageSetUp();
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#hm7_wfGroup_id').val(wf_group.wfGroup_id);
            f_hm7_set_alert();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');         
        
        var datatable_hm71 = undefined;
        var cnt_hm71 = 1;
        dataNew = $('#datatable_hm71').DataTable({
            "aaSorting": [[3, 'desc']],
            "sDom": "<'dt-toolbar'<'col-sm-12 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_hm71) {
                    datatable_hm71 = new ResponsiveDatatablesHelper($('#datatable_hm71'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_hm71.createExpandIcon(nRow);
                var info = dataNew.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_hm71.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "sPdfMessage": "iRemote Excel Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function (sValue, iColumn, nTr, iDataIndex) {
                            if (datas.length < cnt_hm71)
                                cnt_hm71 = 1;
                            if (iColumn === 0)
                                return cnt_hm71++;
                            else if (iColumn === 9)
                                return '';
                            return sValue;
                        }
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "fnCellRender": function (sValue, iColumn, nTr, iDataIndex) {
                            if (datas.length < cnt_hm71)
                                cnt_hm71 = 1;
                            if (iColumn === 0)
                                return cnt_hm71++;
                            else if (iColumn === 9)
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
                        {mData: 'data5'},
                        {mData: 'data2'},
                        {mData: 'data1'},
                        {mData: 'data3'},
                        {mData: null, bSortable: false, sClass: 'text-center',
                            mRender: function (data, type, row) {
                                $label = '&nbsp;<button type="button" class="btn btn-danger btn-xs" id="hm71_btn_response" title="Industrial Response" onclick="f_load_mre (3,\'hm71\');"><i class="fa fa-comment"></i></button>';
                                return $label;
                            }
                        }
                    ]
        });
        $("#datatable_hm71 thead th input[type=text]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_hm71 thead th input[type=number]").on('keyup change', function () {
            dataNew.column($(this).parent().index() + ':visible').search('^' + this.value + '$', true, false, true).draw();
        });
        $("#datatable_hm71 thead th select").on('change', function () {
            if (this.value == '')
                dataNew.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataNew.column($(this).parent().index() + ':visible').search('^' + this.value + '$', true, false, true).draw();
        });

        datas = [{data1: 'S000-1', data2: 'Pooling', data3: 'CO', data5: '24/10/2016 00:30:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 12:30:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 13:00:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 13:30:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 14:00:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 14:30:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 15:00:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 15:30:00'},
            {data1: 'S000-1', data2: 'Compliance', data3: 'CO', data5: '25/10/2016 16:00:00'}];
        f_dataTable_draw(dataNew, datas);

        /*
         * FULL CALENDAR JS
         */

        if ($("#calendar").length) {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                draggable: true,
                selectable: false,
                selectHelper: true,
                unselectAuto: false,
                disableResizing: false,
                height: "auto",
                header: {
                    left: 'title', //,today
                    center: 'prev, next, today',
                    right: 'month, agendaWeek, agenDay' //month, agendaDay,
                },
                select: function (start, end, allDay) {
                    var title = prompt('Event Title:');
                    if (title) {
                        calendar.fullCalendar('renderEvent', {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay
                        }, true // make the event "stick"
                                );
                    }
                    calendar.fullCalendar('unselect');
                },
                events: [{
                        title: 'Quality Assurance',
                        start: new Date(y, m, 4),
                        description: 'Annual RAA for CEMS Installation at Stack S00001',
                        className: ["event", "bg-color-greenLight"],
                        icon: 'fa-check'
                    }, {
                        title: 'Fail Data Pooling',
                        description: 'Stack S0001; Pamaeter SO, CO',
                        start: new Date(y, m, d - 5),
                        end: new Date(y, m, d - 2),
                        className: ["event", "bg-color-red"],
                        icon: 'fa-database'
                    }, {
                        id: 999,
                        title: 'Fail Compliance',
                        description: 'Stack S0001; Pamaeter CO',
                        start: new Date(y, m, d + 4, 16, 0),
                        allDay: false,
                        className: ["event", "bg-color-redLight"],
                        icon: 'fa-warning'
                    }],
                eventRender: function (event, element, icon) {
                    if (!event.description == "") {
                        element.find('.fc-title').append("<br/><span class='ultra-light'>" + event.description + "</span>");
                    }
                    if (!event.icon == "") {
                        element.find('.fc-title').append("<i class='air air-top-right fa " + event.icon + " '></i>");
                    }
                }
            });
        };

        /* hide default buttons */
        $('.fc-toolbar .fc-right, .fc-toolbar .fc-center').hide();

        // calendar prev
        $('#calendar-buttons #btn-prev').click(function () {
            $('.fc-prev-button').click();
            return false;
        });

        // calendar next
        $('#calendar-buttons #btn-next').click(function () {
            $('.fc-next-button').click();
            return false;
        });

        // calendar today
        $('#calendar-buttons #btn-today').click(function () {
            $('.fc-button-today').click();
            return false;
        });

        // calendar month
        $('#mt').click(function () {
            $('#calendar').fullCalendar('changeView', 'month');
        });

        // calendar agenda week
        $('#ag').click(function () {
            $('#calendar').fullCalendar('changeView', 'agendaWeek');
        });

        // calendar agenda day
        $('#td').click(function () {
            $('#calendar').fullCalendar('changeView', 'agendaDay');
        });

    });
    
    function f_hm7_set_alert() {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', $('#hm7_wfGroup_id').val(), 'wfGroup_isFirstTime');         
        if (isFirstTime == '1') {
            $('#hm7_alert').removeClass('hide');
            $('#hm7_btn_upd_ind').removeClass('hide');
            $('#hm7_alert_txt').html('You are 1st time login as <strong>Industrial</strong>. Please complete the <strong>Industrial Information</strong> first before proceed to registration.');
            $('#hm7_info_register').addClass('hide');
        } else {
            $('#hm7_alert').addClass('hide');   
            $('#hm7_btn_upd_cons').addClass('hide');
            $('#hm7_info_register').removeClass('hide');
        }        
    }
    
</script>