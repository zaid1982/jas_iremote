<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
    
    
    $(document).ready(function () {
        
        pageSetUp(); 
        
        $('#wid-id-cmn2').hide();
        get_option('cmn_state_code', '1', 'ref_state', 'state_code', 'state_desc', 'state_status', ' ');
        
        $('#form_cmn').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                cmn_state_code : {
                    validators: {
                        notEmpty: {
                            message: 'State is required'
                        }
                    }
                },
                cmn_industrial_id : {
                    validators: {
                        notEmpty: {
                            message: 'Industrial Premise is required'
                        }
                    }
                },
                cmn_indAll_stackNo : {
                    validators: {
                        notEmpty: {
                            message: 'Stack ID is required'
                        }
                    }
                },
                cmn_input_param : {
                    validators: {
                        notEmpty: {
                            message: 'Input Parameter is required'
                        }
                    }
                },
                cmn_month : {
                    validators: {
                        notEmpty: {
                            message: 'Month is required'
                        }
                    }
                },
                cmn_year : {
                    validators: {
                        notEmpty: {
                            message: 'Year is required'
                        }
                    }
                }
            }
        });
        
        $('#cmn_state_code').on('change', function () { 
            $('#cmn_industrial_id, #cmn_indAll_stackNo, #cmn_input_param, #cmn_month, #cmn_year').val('');
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_industrial_id', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_indAll_stackNo', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_input_param', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_month', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_year', true);
            $('#cmn_industrial_id, #cmn_indAll_stackNo, #cmn_input_param, #cmn_month, #cmn_year').attr('disabled', true);
            if ($(this).val() != '') {
                get_option('cmn_industrial_id', $(this).val(), 'industrial_active', '', '', 'state_id', ' ', 'ref_desc');
                $('#cmn_industrial_id').attr('disabled', false);
            }             
        });
        
        $('#cmn_industrial_id').on('change', function () { 
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_indAll_stackNo', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_input_param', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_month', true);
            $('#form_cmn').bootstrapValidator('resetField', 'cmn_year', true);
            $('#cmn_indAll_stackNo, #cmn_input_param, #cmn_month, #cmn_year').attr('disabled', true);
            if ($(this).val() != '') { 
                var date_start = new Date().toISOString().slice(0,10);
                get_option('cmn_indAll_stackNo', $(this).val(), 'stack_complience', date_start, '', '', ' ', 'ref_desc');
                $('#cmn_indAll_stackNo, #cmn_input_param, #cmn_month, #cmn_year').attr('disabled', false);
            }
        });
        
        $('#cmn_btn_view').on('click', function () {     
            var bootstrapValidator = $("#form_cmn").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }   
            var data_plot = [];
            var total_minute = daysInMonth(parseInt($('#cmn_month').val()), parseInt($('#cmn_year').val()))*1440;
            var dateUtc_start = Date.UTC(parseInt($('#cmn_year').val()), parseInt($('#cmn_month').val())-1, 1, 0, 0);            
            for (var i=0; i<total_minute; i++) {
                data_plot[i] = {
                    x: dateUtc_start+(i*60000),
                    y: null
                };
            }
            var limit_value = 0;
            var pub_param = f_get_general_info('dt_pub_param', {indAll_id:$('#cmn_indAll_stackNo').val(), inputParam_id:$('#cmn_input_param').val()});
            if (pub_param != '' && pub_param.indParam_limitValue != null)
                limit_value = pub_param.indParam_limitValue;
            limit_value = parseInt($('#cmn_input_param').val()) < 8 ? (limit_value*2) : limit_value;
            var data_01 = f_get_general_info_multiple('dt_compliance_month', {}, {tablename:'z17_1003b0240593', yr:$('#cmn_year').val(), mnth:$('#cmn_month').val(), stack_id:$("#cmn_indAll_stackNo option:selected").text(), input_param:$('#cmn_input_param').val()}); 
            $.each(data_01, function(uv){
                var data_value = parseFloat(data_01[uv]['data_value']);
                if (data_value != 0) {
                    var data_index = parseInt(data_01[uv]['minute_index']);
                    data_plot[data_index] = {x:parseInt(data_01[uv]['time_utc']) , y:data_value};
                }
            });
            var units = 'mg/Nm<sup>3</sup>';
            var chart_title = '1-minute Chart';
            chart_complience_month('cmn_chart', $("#cmn_industrial_id option:selected").text(), chart_title, data_plot, units, limit_value);
            $('#wid-id-cmn2').show();     
            
        });
        
    });
        
    function daysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }
    
    function chart_complience_month(chart_div, title, subtitle, dataset, units, limit_value) {
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
                enabled:false
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
                            lineWidth: 3
                        }
                    },
                    marker: {
                        radius: 3,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [
                {name:'Compliance Data',  data:dataset, threshold: limit_value, negativeColor:'blue', color: 'red'}
            ],
            navigation: {
                menuItemStyle: {
                    fontSize: '10px'
                }
            }
        });
    }

</script>
