<!-- Full Calendar -->
<script src="js/plugin/moment/moment.min.js"></script>
<script src="js/plugin/fullcalendar/jquery.fullcalendar.min.js"></script>

<script type="text/javascript">  
    
    $(document).ready(function () {
        
        pageSetUp();
                
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
                        title: 'RATA (Done)',
                        start: new Date(y, m, 4),
                        description: 'Petronas Gebeng Berhad<br>Stack 20329',
                        className: ["event", "bg-color-green"],
                        icon: 'fa-check'
                    }, {
                        title: 'RATA',
                        description: 'Kerteh Oil Sdn Bhd<br>Stack 19200',
                        start: new Date(y, m, d + 5),
                        className: ["event", "bg-color-greenLight"],
                        icon: 'fa-gavel'
                    }, {
                        title: 'RATA',
                        description: 'Nilai Industry Sdn Bhd<br>Stack 10001',
                        start: new Date(y, m, d + 9),
                        className: ["event", "bg-color-greenLight"],
                        icon: 'fa-gavel'
                    }, {
                        title: 'RATA',
                        description: 'Serdang Oil Sdn Bhd<br>Stack C0021',
                        start: new Date(y, m, d + 15),
                        className: ["event", "bg-color-greenLight"],
                        icon: 'fa-gavel'
                    }, {
                        title: 'RATA (Done - late)',
                        description: 'Kerteh Oil Sdn Bhd<br>Stack 21122',
                        start: new Date(y, m, d -2),
                        className: ["event", "bg-color-orange"],
                        icon: 'fa-check'
                    }, {
                        id: 999,
                        title: 'RAA',
                        description: 'Kejor Sdn Bhd<br>Stack S0001',
                        start: new Date(y, m, d - 1),
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
        
</script>