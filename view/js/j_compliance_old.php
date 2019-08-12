<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">  
           
    $(document).ready(function () {
        
        pageSetUp();
        
        get_option('olc_state_code', '1', 'ref_state', 'state_code', 'state_desc', 'state_status', ' ');     
        
        $('#olc_data_date').datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            maxDate: '0', 
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
                $('#form_olc').bootstrapValidator('revalidateField', 'olc_data_date');
            }
        });
        
        $('#form_olc').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                olc_state_code : {
                    validators: {
                        notEmpty: {
                            message: 'State is required'
                        }
                    }
                },
                olc_premise_id : {
                    validators: {
                        notEmpty: {
                            message: 'Industrial Premise is required'
                        }
                    }
                },
                olc_data_date : {
                    validators: {
                        notEmpty: {
                            message: 'Data Date is required'
                        }
                    }
                },
                olc_input_param : {
                    validators: {
                        notEmpty: {
                            message: 'Input Parameter is required'
                        }
                    }
                }
            }
        }); 
        
        $('#olc_state_code').on('change', function () { 
            $('#form_olc').bootstrapValidator('resetField', 'olc_premise_id');
            set_option_empty('olc_premise_id');
            $('#olc_premise_id').trigger('change');
            if ($(this).val() != '') {
                get_option('olc_premise_id', $(this).val(), 'cems_premise', 'premise_id', 'p_name', 'state_id', ' '); 
                $('#olc_premise_id').prop('disabled', false);
            }
        });
                
        $('#exr_btn_view').on('click', function () {
            var bootstrapValidator = $("#form_olc").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            $('#modal_waiting').on('shown.bs.modal', function(e){
                if (f_submit_forms('form_olc', 'p_pooling')) {
                    var date_form = $('#olc_data_date').val(); 
                    var units = '', chart_title = ''; 
                    var arr_stack = result_submit_forms.stack;
                    var arr_data = result_submit_forms.data;
                    var data_plot_combine = [];
                    var list_stack = [];
                    $.each(arr_stack, function(u){
                        list_stack.push((arr_stack[u].stack_id));
                        var data_plot = [];
                        if ($('#olc_input_param').val() == 'opacity') {
                            for (var i=0; i<1440; i++) {
                                data_plot[i] = {
                                    x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), Math.floor(i/60), i%60),
                                    y: null
                                };
                            }  
                        } else {
                            for (var i=0; i<48; i++) {
                                var j = (i%2==0)?0:30;
                                data_plot[i] = {
                                    x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), Math.floor(i/2), j),
                                    y: null
                                };
                            }  
                        }
                        data_plot_combine.push({name:'Stack '+arr_stack[u].stack_id, data:data_plot, color:color_set[u]});
                    });                    
                    $.each(arr_data, function(uv){
                        var times = arr_data[uv].data_timestamp;
                        var data_hour = parseInt(times.substr(11,2));
                        var data_minute = parseInt(times.substr(14,2));
                        var data_index = 0;
                        if ($('#olc_input_param').val() == 'opacity') {
                            data_index = data_hour*60 + data_minute;
                            if (arr_data[uv]['data_value'] != null) {
                                var data_value = parseFloat(arr_data[uv]['data_value']);
                                data_plot_combine[list_stack.indexOf(arr_data[uv]['stack_id'])].data[data_index] = {
                                    x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), data_hour, data_minute),
                                    y: data_value
                                };  
                            }
                        } else {
                            data_index = (data_hour*60 + data_minute) / 30;
                            if (arr_data[uv]['data_value'] != null) {
                                var data_value = parseFloat(arr_data[uv]['data_value']);
                                data_plot_combine[list_stack.indexOf(arr_data[uv]['stack_id'])].data[data_index] = {
                                    x: Date.UTC(parseInt(date_form.substr(0,4)), parseInt(date_form.substr(5,2))-1, parseInt(date_form.substr(8,2)), data_hour, data_minute),
                                    y: data_value
                                };    
                            }
                        }
                    });   
                    if ($('#olc_input_param').val() == 'opacity') {
                        units = '%';
                        chart_title = '1-minute Chart';
                    } else if ($('#olc_input_param').val() == 'o2' || $('#olc_input_param').val() == 'co2') {
                        units = '%';
                        chart_title = 'Half-hour Chart';
                    } else {
                        units = 'mg/Nm<sup>3</sup>';
                        chart_title = 'Half-hour Chart';
                    }
                    chart_complience_old('olc_chart', $("#olc_premise_id option:selected").text(), chart_title, data_plot_combine, units);
                }
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        });
        
    });
    
    function chart_complience_old(chart_div, title, subtitle, dataset, units) {
        Highcharts.chart(chart_div, {
            chart: {
                type: 'spline',
                animation: Highcharts.svg,
                marginRight: 10,
                zoomType: 'x'
            },
            title: {
                text: title
            },
            subtitle: {
                text: subtitle
            },
            credits:{
              enabled:false
            },
            xAxis: {
                type: 'datetime',
                labels: {
                    overflow: 'justify'
                }
            },
            yAxis: {
                title: {
                    text: 'Concentration ('+units+')'
                },
                minorGridLineWidth: 0,
                gridLineWidth: 0,
                alternateGridColor: null
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },
            tooltip: {
                valueSuffix: units
            },
            plotOptions: {
                series: {
                    turboThreshold: 0
                },
                spline: {
                    lineWidth: 2,
                    //color: 'blue',
                    states: {
                        hover: {
                            lineWidth: 4
                        }
                    },
                    marker: {
                        radius: 3,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: dataset,
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
    }

</script>