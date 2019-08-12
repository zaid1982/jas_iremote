<script type="text/javascript">  
    
    var mam_otable;
    var mam_load_type;
    var mam_1st_load = true;
    var mam_otable_catDoc;
    var data_mam_catDoc;
    var mam_otable_component_1;
    var data_mam_component_1;
    var mam_otable_component_2;
    var data_mam_component_2;
    var mam_otable_component_3;
    var data_mam_component_3;
    var mam_otable_cert;
    var data_mam_cert;
    var mam_otable_consParam;
    var data_mam_consParam;
    var mam_otable_personnel;
    var data_mam_personnel;
    var mam_otable_project;
    var data_mam_project;
    var mam_interval;
    var mam_interval_cnt = 0;
    var mam_total_section = [];
    
    $(document).ready(function () {
        
        $('#mam_btn_next').on('click', function () {
            var stepNum = $('#mam_wizard').wizard('selectedItem'); 
            if (stepNum.step == 4)
                $('#mam_btn_next').prop('disabled', true);
        });
        
        $('#mam_btn_prev').on('click', function () {
            var stepNum = $('#mam_wizard').wizard('selectedItem'); 
            if (stepNum.step == 5)
                $('#mam_btn_next').prop('disabled', false);
        });

        $('#mam_certificate_dateExpired').datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            minDate: '0', 
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
                $('#form_mam_2_4').bootstrapValidator('revalidateField', 'mam_certificate_dateExpired');
            }
        });
        
        $('#mam_snote_wfTask_remark').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#form_mam_6').bootstrapValidator('revalidateField', 'mam_snote_wfTask_remark');
                    $('#mam_wfTask_remark').val(contents);
                }
            }
        });   
        
        $('#form_mam_2_1').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mam_consMobile_refMethod : {
                    validators: {
                        notEmpty: {
                            message: 'Reference Method is required'
                        }
                    }
                },
                'mam_consType_type[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Type of Analyzer required'
                        }                        
                    }
                },
                mam_consMobile_modelNo : {
                    validators: {
                        notEmpty: {
                            message: 'Model No. is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Model No. must be not more than 30 characters long'
                        }
                    }
                },
                mam_consMobile_isNormalize : {
                    validators: {
                        notEmpty: {
                            message: 'Normalization is required'
                        }
                    }
                },
                mam_consMobile_correction : {
                    validators: {
                        notEmpty: {
                            message: 'Correction is required'
                        }
                    }
                },
                mam_consMobile_techniqueType : {
                    validators: {
                        notEmpty: {
                            message: 'Technique is required'
                        }
                    }
                },
                mam_consMobile_brand : {
                    validators: {
                        notEmpty: {
                            message: 'Brand is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Brand must be not more than 30 characters long'
                        }
                    }
                },
                mam_consMobile_manufacturer : {
                    validators: {
                        notEmpty: {
                            message: 'Manufacturer is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Manufacturer must be not more than 80 characters long'
                        }
                    }
                },
                mam_consMobile_probeType : {
                    validators: {
                        notEmpty: {
                            message: 'Probe Type is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Probe Type must be not more than 80 characters long'
                        }
                    }
                },
                mam_consMobile_probeLength : {
                    validators: {
                        notEmpty: {
                            message: 'Probe Length is required'
                        },
                        numeric: {
                            message: 'Probe Length is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Probe Length must be greater than 0',
                            callback: function (value, validator, $field) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mam_consMobile_samplingLine : {
                    validators: {
                        notEmpty: {
                            message: 'Heated Sampling Line is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Heated Sampling Line must be not more than 80 characters long'
                        }
                    }
                }
            }
        });     
        
        $('#mam_consMobile_techniqueType').on('change', function () {
            $('#mam_dis_outsource').val('');
            $('#form_mam_2_1').bootstrapValidator('revalidateField', 'mam_consMobile_samplingLine');
        });
        
        $('#form_mam_2_7').bootstrapValidator({    
            excluded: ':disabled',
            fields: {  
                //
            }
        });     
        
        $('#form_mam_2_6').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mam_consMobile_compStatus : {
                    validators: {
                        notEmpty: {
                            message: 'Product Status is required'
                        }
                    }
                }
            }
        });     
        
        $('#form_mam_2_2').bootstrapValidator({       
            excluded: ':disabled',
            fields: {  
                mam_cat_documentName_id : {
                    validators: {
                        notEmpty: {
                            message: 'Document Type is required'
                        }
                    }
                },
                mam_cat_document_name : {
                    validators: {
                        notEmpty: {
                            message: 'Document Title is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Document Title must be not more than 30 characters long'
                        }
                    }
                },
                mam_file_catalogue: {
                    validators: {
                        notEmpty: {
                            message: 'Manual / Catalogue Attachment File is required'
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: '20000000',
                            message: 'Only PDF file format max 20MB allowed.'
                        }
                    }
                }
            }
        });   
        
        $('#form_mam_2_3').bootstrapValidator({   
            excluded: ':disabled',
            fields: {  
                mam_inputParam_id : {
                    validators: {
                        notEmpty: {
                            message: 'Input Parameter is required'
                        }
                    }
                },
                'mam_analyzerTechnique_id[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Method of Detection is required'
                        }                        
                    }
                },
                mam_consParamRange_from_0 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (From) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (From) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Analyzer Certified (From) must in the range of 0 and 1,000',
                            callback: function (value, validator, $field) {
                                if ($('#mam_consParamRange_to_0').val() != '')
                                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_0');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParamRange_to_0 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (To) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (To) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var value_from = parseFloat($('#mam_consParamRange_from_0').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 1000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 1,000'
                                };
                            }
                        }
                    }
                },
                mam_consParamRange_from_1 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (From) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (From) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Analyzer Certified (From) must in the range of 0 and 1,000',
                            callback: function (value, validator, $field) {
                                if ($('#mam_consParamRange_to_1').val() != '')
                                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_1');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParamRange_to_1 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (To) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (To) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var value_from = parseFloat($('#mam_consParamRange_from_1').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 1000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 1,000'
                                };
                            }
                        }
                    }
                },
                mam_consParamRange_from_2 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (From) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (From) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Analyzer Certified (From) must in the range of 0 and 1,000',
                            callback: function (value, validator, $field) {
                                if ($('#mam_consParamRange_to_2').val() != '')
                                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_2');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParamRange_to_2 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (To) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (To) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var value_from = parseFloat($('#mam_consParamRange_from_2').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 1000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 1,000'
                                };
                            }
                        }
                    }
                },
                mam_consParamRange_from_3 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (From) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (From) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Analyzer Certified (From) must in the range of 0 and 1,000',
                            callback: function (value, validator, $field) {
                                if ($('#mam_consParamRange_to_3').val() != '')
                                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_3');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParamRange_to_3 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (To) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (To) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var value_from = parseFloat($('#mam_consParamRange_from_3').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 1000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 1,000'
                                };
                            }
                        }
                    }
                },
                mam_consParamRange_from_4 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (From) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (From) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Analyzer Certified (From) must in the range of 0 and 1,000',
                            callback: function (value, validator, $field) {
                                if ($('#mam_consParamRange_to_4').val() != '')
                                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_4');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParamRange_to_4 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (To) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (To) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var value_from = parseFloat($('#mam_consParamRange_from_4').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 1000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 1,000'
                                };
                            }
                        }
                    }
                },
                mam_consParamRange_from_5 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (From) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (From) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Analyzer Certified (From) must in the range of 0 and 1,000',
                            callback: function (value, validator, $field) {
                                if ($('#mam_consParamRange_to_5').val() != '')
                                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_5');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParamRange_to_5 : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Certified (To) is required'
                        },
                        numeric: {
                            message: 'Analyzer Certified (To) is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value, validator, $field) {
                                var value_from = parseFloat($('#mam_consParamRange_from_5').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 1000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 1,000'
                                };
                            }
                        }
                    }
                },
                mam_consParam_reference : {
                    validators: {
                        notEmpty: {
                            message: 'Consumable Span Gas is required'
                        },
                        stringLength : {
                            max : 100,
                            message : 'Consumable Span Gas must be not more than 100 characters long'
                        }
                    }
                },
                mam_consParam_dataGeneration : {
                    validators: {
                        notEmpty: {
                            message: 'Data Generation is required'
                        },
                        numeric: {
                            message: 'Data Generation is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Data Generation must be greater than 0',
                            callback: function (value, validator, $field) {
                                return (parseFloat(value) > 0 && parseFloat(value) <= 1000);
                            }
                        }
                    }
                },
                mam_consParam_method : {
                    validators: {
                        notEmpty: {
                            message: 'Method is required'
                        }
                    }
                }
            }
        });  
        
        $('#mam_inputParam_id').on('change', function () {
            if (jQuery.inArray($(this).val(), ['1', '2', '3', '4', '5', '6', '7']) >= 0) {
                $('.mam_consParam_unit').html('mg/m<sup>3</sup>');
            } else if (jQuery.inArray($(this).val(), ['8', '9', '10', '11']) >= 0) {
                $('.mam_consParam_unit').html('%');
            }
            if (jQuery.inArray($(this).val(), ['1', '8']) >= 0) {
                $('#mam_consParam_reference, #mam_consParam_method').attr('disabled', true)
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParam_reference', false)
                    .bootstrapValidator('enableFieldValidators', 'mam_consParam_method', false);
            } else {
                $('#mam_consParam_reference, #mam_consParam_method').attr('disabled', false)
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParam_reference', true)
                    .bootstrapValidator('enableFieldValidators', 'mam_consParam_method', true);
            }
        });
                
        $('#form_mam_2_4').bootstrapValidator({ 
            excluded: ':disabled',
            fields: {  
                mam_certificate_no : {
                    validators: {
                        notEmpty: {
                            message: 'Certificate No. is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Certificate No. must be not more than 30 characters long'
                        }
                    }
                },
                mam_certIssuer_id : {
                    validators: {
                        notEmpty: {
                            message: 'Certificate Issuer is required'
                        }
                    }
                },
                mam_certificate_dateExpired : {
                    validators: {
                        notEmpty: {
                            message: 'Expired Date is required'
                        }
                    }
                },
                mam_file_certificate_name : {
                    validators: {
                        notEmpty: {
                            message: 'Document Title is required'
                        },
                        stringLength : {
                            max : 100,
                            message : 'Document Title must be not more than 100 characters long'
                        }
                    }
                },
                mam_file_certificate : {
                    validators: {
                        notEmpty: {
                            message: 'Certificate Attachment File is required'
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: '20000000',
                            message: 'Only PDF file format max 20MB allowed.'
                        }
                    }
                }
            }
        });
        
        $('#mam_certIssuer_id').on('change', function() {
            var is_enabled = $(this).val() != '3';
            $('#form_mam_2_4').bootstrapValidator('enableFieldValidators', 'mam_certificate_dateExpired', is_enabled)
                .bootstrapValidator('enableFieldValidators', 'mam_certificate_basic', is_enabled)
                .bootstrapValidator('enableFieldValidators', 'mam_file_certificate', is_enabled);
            $('#form_mam_2_4').bootstrapValidator('revalidateField', 'mam_certificate_dateExpired')
                .bootstrapValidator('revalidateField', 'mam_certificate_basic')
                .bootstrapValidator('revalidateField', 'mam_file_certificate');
        });    
        
        $('#form_mam_2_5').bootstrapValidator({       
            excluded: ':disabled',
            fields: {  
                mam_das_probeSoftware : {
                    validators: {
                        stringLength : {
                            max : 100,
                            message : 'Probe Software Version must be not more than 100 characters long'
                        }
                    }
                },
                mam_das_probeDesc : {
                    validators: {
                        stringLength : {
                            max : 255,
                            message : 'Probe Software Description must be not more than 100 characters long'
                        }
                    }
                },
                mam_das_analyzerSoftware : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Software Version is required'
                        },
                        stringLength : {
                            max : 100,
                            message : 'Analyzer Software Version must be not more than 100 characters long'
                        }
                    }
                },
                mam_das_analyzerDesc : {
                    validators: {
                        notEmpty: {
                            message: 'Analyzer Software Description is required'
                        },
                        stringLength : {
                            max : 100,
                            message : 'Analyzer Software Description must be not more than 255 characters long'
                        }
                    }
                },
                mam_dis_name : {
                    validators: {
                        notEmpty: {
                            message: 'Name of DIS is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Name of DIS must be not more than 80 characters long'
                        }
                    }
                },
                mam_dis_type : {
                    validators: {
                        notEmpty: {
                            message: 'Status of DIS is required'
                        }
                    }
                },
                mam_dis_outsource : {
                    validators: {
                        callback: {
                            message: 'Outsourced Company is required',
                            callback: function (value, validator, $field) {
                                return ($('#mam_dis_type').val() != '2') ? true : (value !== '');
                            }
                        },
                        stringLength : {
                            max : 80,
                            message : 'Outsourced Company must be not more than 80 characters long'
                        }
                    }
                },
                mam_dis_description : {
                    validators: {
                        notEmpty: {
                            message: 'Description is required'
                        },
                        stringLength : {
                            max : 500,
                            message : 'Description must be not more than 500 characters long'
                        }
                    }
                }
            }
        });   
        
        $('#form_mam_3').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mam_consPers_name : {
                    validators: {
                        notEmpty: {
                            message: 'Name of Certified Employee is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Name of Certified Employee must be not more than 80 characters long'
                        }
                    }
                },
                mam_personnel_icNo : {
                    validators: {
                        notEmpty: {
                            message: 'IC / Passport No. is required'
                        },
                        digits : {
                            message : 'Identification No. must be digits'
                        },
                        callback: {
                            message: 'Identification No. must be 12 digits long',
                            callback: function (value, validator, $field) {
                                var value_citizen = $('input[name="mam_personnel_citizenship"]:checked').val();
                                return {
                                    valid: (value_citizen==1 && value.length== 12) || (value_citizen==2&&value.length>=5 && value.length<=9),
                                    message: (value_citizen==1?'Identification No.':'Passport') + ' No. must be ' + (value_citizen==1?'12':'between 5 and 9') + ' digits long'
                                };
                            }
                        }
                    }
                },
                mam_consPers_qualification : {
                    validators: {
                        notEmpty: {
                            message: 'Academic Qualification is required'
                        },
                        stringLength : {
                            max : 255,
                            message : 'Academic Qualification must be not more than 255 characters long'
                        }
                    }
                },
                mam_consPers_experience : {
                    validators: {
                        notEmpty: {
                            message: 'Working Experience is required'
                        },                        
                        numeric: {
                            message: 'Working Experience is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Working Experience must not less than 0',
                            callback: function (value, validator, $field) {
                                return (parseFloat(value) >= 0);
                            }
                        },
                        stringLength : {
                            max : 2,
                            message : 'Working Experience must be not more than 2 characters long'
                        }
                    }
                },
                mam_consPers_certificate : {
                    validators: {
                        notEmpty: {
                            message: 'Training Certification is required'
                        },
                        stringLength : {
                            max : 255,
                            message : 'Training Certification must be not more than 255 characters long'
                        }
                    }
                },
                mam_consPers_document_name : {
                    validators: {
                        notEmpty: {
                            message: 'Document Title is required'
                        },
                        stringLength : {
                            max : 100,
                            message : 'Document Title must be not more than 255 characters long'
                        }
                    }
                },
                mam_consPers_document : {
                    validators: {
                        notEmpty: {
                            message: 'Personnel Supporting Document is required',
                            enabled: false,
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: '20000000',
                            message: 'Only PDF file format max 20MB allowed.',
                            enabled: false,
                        }
                    }
                }
            }
        });   
        
        $('#form_mam_3').find('[name="mam_personnel_citizenship"]').on('click', function () { 
            var is_enabled = $(this).val() == '1';
            $('#form_mam_3').bootstrapValidator('enableFieldValidators', 'mam_personnel_icNo', is_enabled, 'digits');
            $('#form_mam_3').bootstrapValidator('revalidateField', 'mam_personnel_icNo');
        });
        
        $('#form_mam_3').find('[name="mam_consPers_workingStatus"]').on('click', function () { 
            var is_enabled = $(this).val() == '2';
            $('#form_mam_3').bootstrapValidator('enableFieldValidators', 'mam_consPers_document', is_enabled);
            $('#form_mam_3').bootstrapValidator('revalidateField', 'mam_consPers_document');
            $('#form_mam_3').bootstrapValidator('enableFieldValidators', 'mam_consPers_document_name', is_enabled);
            $('#form_mam_3').bootstrapValidator('revalidateField', 'mam_consPers_document_name');
            is_enabled ? $('#mam_star_document_name').show() : $('#mam_star_document_name').hide(); 
        });
        
        $('#form_mam_5').bootstrapValidator({       
            excluded: ':disabled',
            fields: {  
                mam_consProject_title : {
                    validators: {
                        notEmpty: {
                            message: 'Project Title is required'
                        },
                        stringLength : {
                            max : 150,
                            message : 'Project Title must be not more than 150 characters long'
                        }
                    }
                },
                mam_consProject_year : {
                    validators: {
                        notEmpty: {
                            message: 'Year is required'
                        }
                    }
                },
                mam_consProject_client : {
                    validators: {
                        notEmpty: {
                            message: 'Client is required'
                        },
                        stringLength : {
                            max : 150,
                            message : 'Client must be not more than 150 characters long'
                        }
                    }
                },
                mam_consProject_desc : {
                    validators: {
                        notEmpty: {
                            message: 'Project Description is required'
                        },
                        stringLength : {
                            max : 255,
                            message : 'Project Description must be not more than 255 characters long'
                        }
                    }
                },
                mam_consProject_scope : {
                    validators: {
                        notEmpty: {
                            message: 'Scope of Work is required'
                        },
                        stringLength : {
                            max : 150,
                            message : 'Scope of Work must be not more than 150 characters long'
                        }
                    }
                },
                mam_consProject_source : {
                    validators: {
                        notEmpty: {
                            message: 'Source of Activity is required'
                        }
                    }
                },
                mam_consProject_value : {
                    validators: {
                        numeric: {
                            message: 'Project Value must numeric',
                            decimalSeparator: '.'
                        },
                        greaterThan: {
                            value: 0,
                            message: 'Project Value must greater than 0',
                        },
                        stringLength : {
                            max : 15,
                            message : 'Project Value must be not more than 15 characters long'
                        }
                    }
                }
            }
        });
        
        $('#form_mam_6').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mam_declare_1 : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration required'
                        }                        
                    }
                },
                mam_declare_2 : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration required'
                        }                        
                    }
                },
                mam_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mam_snote_wfTask_remark"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#modal_consultant_mobile').on('show.bs.modal', function() {
            $('#mam_wizard').wizard('selectedItem', { step:1 });
            $('#mam_btn_next').prop('disabled', false);    
//            if ($('#mam_load_type').val() == '1' || $('#mam_load_type').val() == '2') {
//                mam_interval = window.setInterval(function(){ 
//                    if (mam_interval_cnt == 1) {
//                        $('#mam_funct').val('save_consultant_mobile');
//                        $('#mam_wfTask_remark').val($('[name="mam_snote_wfTask_remark"]').summernote('code'));
//                        $('#modal_waiting').on('shown.bs.modal', function(e){
//                            if (f_submit_forms('form_mam,#form_mam_2_1,#form_mam_2_5,#form_mam_2_6,#form_mam_2_7,#form_mam_6', 'p_registration', 'Data successfully saved.')) {
//                                if (mam_otable == 'cmc')
//                                    f_table_cmc ();
//                            }
//                            $('#modal_waiting').modal('hide');
//                            $(this).unbind(e);
//                        }).modal('show');  
//                    }
//                    mam_interval_cnt = 1;
//                }, 300000);
//            }
        });
        
        $('#modal_consultant_mobile').on('hide.bs.modal', function() {
            mam_interval_cnt = 0;
//            clearInterval(mam_interval);
            mam_interval = 0;
            $.each(data_mam_component_2, function(u){
                if (data_mam_component_2[u].mobileEquip_mandatory == '1') {  
                    var bootstrapValidator = $("#form_mam_2_7").data('bootstrapValidator');
                    bootstrapValidator.removeField('mam_consMobileEquip_model_'+data_mam_component_2[u].mobileEquip_ids);
                    bootstrapValidator.removeField('mam_consMobileEquip_manufacturer_'+data_mam_component_2[u].mobileEquip_ids);
                    bootstrapValidator.removeField('mam_consMobileEquip_spec_'+data_mam_component_2[u].mobileEquip_ids);
                }
            });
        });
             
        $('#mam_consMobile_techniqueType').on('change', function () {
            f_mam_set_component($(this).val());
        });
        
        $('#mam_dis_type').on('change', function () {
            $('#mam_dis_outsource').val('');
            $('#form_mam_2_5').bootstrapValidator('revalidateField', 'mam_dis_outsource');
            $('#mam_dis_outsource').attr('disabled',$(this).val() == '2' ? false : true);
            $('#form_mam_2_5').bootstrapValidator('revalidateField', 'mam_dis_outsource');
        });
        
        $('#mam_btn_save').on('click', function () {            
            if ($('#mam_load_type').val() == '4') {
                $('#modal_waiting').on('shown.bs.modal', function(e){ 
                    var parameters = {};
                    parameters['wfTask_id'] = $('#mam_wfTask_id').val();     
                    parameters['wfFlow_id'] = '3';       
                    $.each(mam_total_section, function(value){     
                        parameters['check_remark_'+mam_total_section[value]] = $('#mam_check_remark_'+mam_total_section[value]).val();
                        parameters['check_pass_'+mam_total_section[value]] = $("input[name='mam_check_pass_"+mam_total_section[value]+"']").is(':checked') ? '1' : '0';
                    });
                    f_submit_normal('save_process_checking', parameters, 'p_registration', 'Process Checklist successfully saved.');
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                $('#mam_funct').val('save_consultant_mobile');
                $('#mam_wfTask_remark').val($('[name="mam_snote_wfTask_remark"]').summernote('code'));
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_mam,#form_mam_2_1,#form_mam_2_5,#form_mam_2_6,#form_mam_2_7,#form_mam_6', 'p_registration', 'Data successfully saved.')) {
                        if (mam_otable == 'cmc')
                            f_table_cmc ();
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            }
        }); 
        
        $('#mam_btn_submit').on('click', function () {            
            var bootstrapValidator = $("#form_mam_2_1").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_mam_catDoc.length == 0) {
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                $('#mam_btn_upload_catalogue').focus();
                f_notify(2, 'Error', 'Please provide Manual and Catalogue!');    
                return false;
            } else {
                var is_exist_9 = false; 
                var is_exist_23 = false;
                $.each(data_mam_catDoc, function(v){     
                    if (data_mam_catDoc[v].documentName_id == '9')
                        is_exist_9 = true;
                    else if (data_mam_catDoc[v].documentName_id == '23')
                        is_exist_23 = true;
                });
                if (!is_exist_9) {
                    f_notify(2, 'Error', 'Please provide <strong>CEMS Analyzer Catalogue</strong> in Manual / Catalogue section!');    
                    return false; 
                } else if (!is_exist_23) {
                    f_notify(2, 'Error', 'Please provide <strong>CEMS Operating Procedure</strong> in Manual / Catalogue section!');    
                    return false; 
                }
            }
            bootstrapValidator = $("#form_mam_2_6").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            bootstrapValidator = $("#form_mam_2_7").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_mam_consParam.length == 0) {
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                $('#mam_btn_add_parameter').focus();
                f_notify(2, 'Error', 'Please provide Parameters and Specified Range!');    
                return false;
            //} else {
            //    var is_exist = false;
            //    var arrStr_sourceActivity = '';
            //    $.each($("input[name='mam_sourceActivity_id[]']:checked"), function(){     
            //        arrStr_sourceActivity += ',' + $(this).val();
            //    });
            //    var arrStr_inputParam_type = '';
            //    $.each($("input[name='mam_consType_type[]']:checked"), function(){     
            //        arrStr_inputParam_type += ',' + $(this).val();
            //    });;
            //    var arr_inputParam = f_get_general_info_multiple('vw_pub_group_inputParam', {}, {arr_inputParam_type:arrStr_inputParam_type, arr_sourceActivity_id:arrStr_sourceActivity});
            //    $.each(arr_inputParam, function(u){     
            //        is_exist = false;
            //        $.each(data_mam_consParam, function(v){     
            //            if (data_mam_consParam[v].inputParam_id == arr_inputParam[u].inputParam_id)
            //                is_exist = true;
            //        });
            //        if (!is_exist) {
             //           f_notify(2, 'Error', 'Please provide specified range for parameter <strong>'+arr_inputParam[u].inputParam_desc+'</strong> in Section B.3. Parameters and Specified Range!');    
             //           return false; 
            //        }
            //    });
            //    if (!is_exist) {
            //        $('#mam_wizard').wizard('selectedItem', { step:2 });
            //        $('#mam_btn_add_parameter').focus();                    
             //       return false;
             //   }
            }
            if (data_mam_cert.length == 0) {
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                $('#mam_btn_add_certificate').focus();
                f_notify(2, 'Error', 'Please provide Analyzer Certification!');    
                return false;
            }
            bootstrapValidator = $("#form_mam_2_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mam_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_mam_personnel.length == 0) {
                $('#mam_wizard').wizard('selectedItem', { step:3 });
                $('#mam_btn_add_personnel').focus();
                f_notify(2, 'Error', 'Please provide Information of Personnel for CEMS!');    
                return false;
            }
            if (!f_submit_normal('check_consultant_personnel', {consAll_id:$('#mam_consAll_id').val(), wfGroup_id: $('#mam_wfGroup_id').val()}, 'p_registration')) {
                $('#mam_wizard').wizard('selectedItem', { step:3 });
                $('#mam_btn_add_personnel').focus();
                return false;
            }       
            if (data_mam_project.length == 0) {
                $('#mam_wizard').wizard('selectedItem', { step:5 });
                $('#mam_btn_add_project').focus();
                f_notify(2, 'Error', 'Please provide Information of Company\'s Working Experience!');    
                return false;
            }
            bootstrapValidator = $("#form_mam_6").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mam_wizard').wizard('selectedItem', { step:6 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            var chk_doc_27 = f_get_general_info_multiple('t_consultant_docSupport', {consultant_id:$('#mam_consultant_id').val(), documentName_id:'27'});
            if(chk_doc_27.length === 0) {
                f_notify(2, 'Error', 'Please make Company Profile uploaded from Consultant Information menu!');    
                return false;
            }
            var chk_doc_28 = f_get_general_info_multiple('t_consultant_docSupport', {consultant_id:$('#mam_consultant_id').val(), documentName_id:'28'});
            if(chk_doc_28.length === 0) {
                f_notify(2, 'Error', 'Please make Registry of Companies uploaded from Consultant Information menu!');    
                return false;
            }
            $("#mam_funct").val('save_consultant_mobile');
            $('#mam_wfTask_remark').val($('[name="mam_snote_wfTask_remark"]').summernote('code'));
            if (f_submit_forms('form_mam,#form_mam_2_1,#form_mam_2_5,#form_mam_2_6,#form_mam_2_7,#form_mam_6', 'p_registration')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure to submit the Mobile/Portable Analyzer Registration Form?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {            
                        $('#modal_waiting').on('shown.bs.modal', function(e){    
                            if (f_submit_normal('check_consultant_active', {wfGroup_id: $('#mam_wfGroup_id').val()}, 'p_registration')) {
                                var submit_status = $('#mam_wfTask_status').val() == '2' ? '10' : '13';
                                var submit_msg = $('#mam_wfTask_status').val() == '2' ? 'Your application successfully submitted. Result will be alerted through your email.' : 'Your application successfully resubmitted. Result will be alerted through your email.';
                                var condition_no = $('#mam_wfTask_status').val() == '2' ? '' : '1';
                                var wfGroup_id = $('#mam_wfTask_status').val() == '2' ? $('#mam_wfGroup_id').val() : '';
                                if (f_submit($('#mam_wfTask_id').val(), $('#mam_wfTaskType_id').val(), submit_status, submit_msg, $('#mam_wfTask_remark').val(), condition_no, wfGroup_id, '', 'consAll_id', $('#mam_consAll_id').val())) {
                                    var email_type = submit_status == '2' ? 'email_assign' : 'email_process';
                                    f_send_email(email_type, {wfTask_id:result_submit_task}); 
                                    if (mam_otable == 'hm8') 
                                        f_hm8_set_alert();
                                    else if (mam_otable == 'cmc')
                                        f_table_cmc ();
                                    $('#modal_consultant_mobile').modal('hide');
                                }
                            } else {
                                f_notify(2, 'Error', 'Your application cannot be proceed because the Company Registration No. already activated by another user. Please contact administrator to report this issue.');    
                            }
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });
            }
        }); 
        
        $('#mam_btn_upload_catalogue').on('click', function () {
            var bootstrapValidator = $("#form_mam_2_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {  
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mam_2_2')[0]);
                    formData.append('funct', 'upload_analyzer_catalogue_mobile');
                    formData.append('consAll_id', $('#mam_consAll_id').val());
                    $.ajax({
                        url: "process/p_registration.php",
                        type: "POST",
                        dataType: "json",
                        async: false,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            myXhr = $.ajaxSettings.xhr();
                            return myXhr;
                        },
                        success: function(resp) {
                            if (resp.success == true){ 
                                f_notify(1, 'Success', 'Document successfully uploaded.');
                                $('#form_mam_2_2').trigger('reset');
                                $('#form_mam_2_2').bootstrapValidator('resetForm', true);
                                data_mam_catDoc = f_get_general_info_multiple('dt_consultant_doc', {consAll_id:$('#mam_consAll_id').val(), documentName_type:'analyz_man'}, '', '', 'consDoc_id');
                                f_dataTable_draw(mam_otable_catDoc, data_mam_catDoc, 'datatable_mam_catDoc', 4);
                            } else {
                                f_notify(2, 'Error', resp.errors);
                            }
                        },
                        error: function() {
                            f_notify(2, 'Error', errMsg_default);
                        }
                    }); 
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                $('#mam_file_catalogue').focus();
                f_notify(2, 'Error', 'Please make sure file to be uploaded is selected.');   
            }
        });
        
        $('#mam_btn_add_parameter').on('click', function () {            
            var bootstrapValidator = $("#form_mam_2_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {     
                $('#mam_funct').val('save_consultant_parameter_mobile');
                $('#modal_waiting').on('shown.bs.modal', function(e){                    
                    if (f_submit_forms('form_mam,#form_mam_2_3', 'p_registration', 'Input Parameter successfully added.')) {
                        $('#form_mam_2_3').trigger('reset');
                        $('#mam_analyzerTechnique_id').val([]).trigger('change');
                        $('#form_mam_2_3').bootstrapValidator('resetForm', true);
                        $('.mam_div_paramRange').hide();
                        $('#mam_btn_add_range').prop('disabled', false);
                        for (var i=1; i<=5; i++) {
                            $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_from_'+i, false);
                            $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_to_'+i, false);
                        }
                        $('#mam_consParam_reference, #mam_consParam_method').prop('disabled', true);
                        $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParam_reference', false)
                            .bootstrapValidator('enableFieldValidators', 'mam_consParam_method', false); 
                        data_mam_consParam = f_get_general_info_multiple('dt_consultant_parameter', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'consParam_id');
                        f_dataTable_draw(mam_otable_consParam, data_mam_consParam, 'datatable_mam_consParam', 6);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        $('#mam_btn_add_certificate').on('click', function () {
            var bootstrapValidator = $("#form_mam_2_4").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mam_2_4')[0]);
                    formData.append('funct', 'save_certificate_mobile');
                    formData.append('mam_consAll_id', $('#mam_consAll_id').val());
                    $.ajax({
                        url: "process/p_registration.php",
                        type: "POST",
                        dataType: "json",
                        async: false,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            myXhr = $.ajaxSettings.xhr();
                            return myXhr;
                        },
                        success: function(resp) {
                            if (resp.success == true){ 
                                f_notify(1, 'Success', 'Certificate successfully added.');
                                $('#form_mam_2_4').trigger('reset');
                                $('#form_mam_2_4').bootstrapValidator('resetForm', true);
                                f_mam_cert_usepa();
                                data_mam_cert = f_get_general_info_multiple('dt_certificate', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'certificate_id');
                                f_dataTable_draw(mam_otable_cert, data_mam_cert, 'datatable_mam_cert', 6);
                            } else {
                                f_notify(2, 'Error', resp.errors);
                            }
                        },
                        error: function() {
                            f_notify(2, 'Error', errMsg_default);
                        }
                    });
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        $('#mam_btn_add_personnel').on('click', function () {
            var bootstrapValidator = $("#form_mam_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#mam_funct').val('save_consultant_personnel_mobile');
                $('#modal_waiting').on('shown.bs.modal', function(e){     
                    var formData = new FormData($('#form_mam_3')[0]);
                    formData.append('funct', 'save_consultant_personnel_mobile');
                    formData.append('mam_consAll_id', $('#mam_consAll_id').val());
                    formData.append('mam_wfGroup_id', $('#mam_wfGroup_id').val());
                    $.ajax({
                        url: "process/p_registration.php",
                        type: "POST",
                        dataType: "json",
                        async: false,
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        xhr: function() {
                            myXhr = $.ajaxSettings.xhr();
                            return myXhr;
                        },
                        success: function(resp) {
                            if (resp.success == true){ 
                                f_notify(1, 'Success', 'CEMS Personnel successfully added.');
                                $('#form_mam_3').trigger('reset');
                                $('#form_mam_3').bootstrapValidator('resetForm', true);
                                $('#mam_star_document_name').hide();
                                data_mam_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'consPers_id');
                                f_dataTable_draw(mam_otable_personnel, data_mam_personnel, 'datatable_mam_personnel', 8);
                            } else {
                                f_notify(2, 'Error', resp.errors);
                            }
                        },
                        error: function() {
                            f_notify(2, 'Error', errMsg_default);
                        }
                    });
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        $('#mam_btn_add_project').on('click', function () {
            var bootstrapValidator = $("#form_mam_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#mam_funct').val('save_consultant_project_mobile');
                $('#modal_waiting').on('shown.bs.modal', function(e){    
                    if (f_submit_forms('form_mam,#form_mam_5', 'p_registration', 'Company Working Experience successfully added.')) {
                        $('#form_mam_5').bootstrapValidator('resetForm', true);                    
                        data_mam_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#mam_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
                        f_dataTable_draw(mam_otable_project, data_mam_project, 'datatable_mam_project', 9);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        var datatable_mam_catDoc = undefined; 
        mam_otable_catDoc = $('#datatable_mam_catDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_catDoc) {
                    datatable_mam_catDoc = new ResponsiveDatatablesHelper($('#datatable_mam_catDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_catDoc.createExpandIcon(nRow);
                var info = mam_otable_catDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mam_catDoc.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'documentName_desc'},
                    {mData: 'document_name'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.document_id != null)
                                $label += '<a type="button" class="btn btn-success btn-xs" title="Download Support Document" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            $label += ' <button type="button" class="btn btn-danger btn-xs mam_hideView" title="Delete" onclick="f_mam_delete_catDoc ('+row.consDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_component_1 = undefined; 
        mam_otable_component_1 = $('#datatable_mam_component_1').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_component_1) {
                    datatable_mam_component_1 = new ResponsiveDatatablesHelper($('#datatable_mam_component_1'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_component_1.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mam_component_1.respond();
            },
            "aoColumns":
                [
                    {mData: 'mobileEquip_desc'},
                    {mData: null, sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" style="min-width: 532px" class="form-control" name="mam_consMobileEquip_spec_'+row.mobileEquip_ids+'" id="mam_consMobileEquip_spec_'+row.mobileEquip_ids+'" value="'+(row.consMobileEquip_spec!=null?row.consMobileEquip_spec:'')+'" maxlength="150"/>' +
                                '</div></div>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_component_2 = undefined; 
        mam_otable_component_2 = $('#datatable_mam_component_2').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_component_2) {
                    datatable_mam_component_2 = new ResponsiveDatatablesHelper($('#datatable_mam_component_2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_component_2.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mam_component_2.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        if (visibleRows[j].mobileEquip_mandatory == '1') {  
                            var bootstrapValidator = $("#form_mam_2_7").data('bootstrapValidator');
                            bootstrapValidator.addField('mam_consMobileEquip_model_'+visibleRows[j].mobileEquip_ids, {validators:{notEmpty:{message:'Required'}}});
                            bootstrapValidator.addField('mam_consMobileEquip_manufacturer_'+visibleRows[j].mobileEquip_ids, {validators:{notEmpty:{message:'Required'}}});
                            bootstrapValidator.addField('mam_consMobileEquip_spec_'+visibleRows[j].mobileEquip_ids, {validators:{notEmpty:{message:'Required'}}});
                        }
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'mobileEquip_desc',
                        mRender: function (data, type, row) {
                            return row.mobileEquip_mandatory == '1' ? '<font color="red">*</font> '+data : data;
                        }
                    },
                    {mData: null, sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' + 
                                '<input type="text" style="max-width: 130px" class="form-control" name="mam_consMobileEquip_model_'+row.mobileEquip_ids+'" id="mam_consMobileEquip_model_'+row.mobileEquip_ids+'" value="'+(row.consMobileEquip_model!=null?row.consMobileEquip_model:'')+'" maxlength="30"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: null, sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' + 
                                '<input type="text" style="max-width: 130px" class="form-control" name="mam_consMobileEquip_manufacturer_'+row.mobileEquip_ids+'" id="mam_consMobileEquip_manufacturer_'+row.mobileEquip_ids+'" value="'+(row.consMobileEquip_manufacturer!=null?row.consMobileEquip_manufacturer:'')+'" maxlength="100"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: null, sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' + 
                                '<input type="text" style="min-width: 250px" class="form-control" name="mam_consMobileEquip_spec_'+row.mobileEquip_ids+'" id="mam_consMobileEquip_spec_'+row.mobileEquip_ids+'" value="'+(row.consMobileEquip_spec!=null?row.consMobileEquip_spec:'')+'"  maxlength="150"/>' +
                                '</div></div>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_component_3 = undefined; 
        mam_otable_component_3 = $('#datatable_mam_component_3').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_component_3) {
                    datatable_mam_component_3 = new ResponsiveDatatablesHelper($('#datatable_mam_component_3'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_component_3.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mam_component_3.respond();
            },
            "aoColumns":
                [
                    {mData: 'mobileEquip_desc'},
                    {mData: null, sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" style="min-width: 532px" class="form-control" name="mam_consMobileEquip_spec_'+row.mobileEquip_ids+'" id="mam_consMobileEquip_spec_'+row.mobileEquip_ids+'" value="'+(row.consMobileEquip_spec!=null?row.consMobileEquip_spec:'')+'" maxlength="150"/>' +
                                '</div></div>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_cert = undefined; 
        mam_otable_cert = $('#datatable_mam_cert').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_cert) {
                    datatable_mam_cert = new ResponsiveDatatablesHelper($('#datatable_mam_cert'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_cert.createExpandIcon(nRow);
                var info = mam_otable_cert.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mam_cert.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'certificate_no'},
                    {mData: 'certIssuer_desc'},
                    {mData: 'certBasic_desc'},
                    {mData: 'certificate_dateExpired'},
                    {mData: 'document_name'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.document_id != null)
                                $label += '<a type="button" class="btn btn-success btn-xs" title="Download Certificate" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            $label += ' <button type="button" class="btn btn-danger btn-xs mam_hideView" title="Delete" onclick="f_mam_delete_certificate ('+row.certificate_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_consParam = undefined; 
        mam_otable_consParam = $('#datatable_mam_consParam').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_consParam) {
                    datatable_mam_consParam = new ResponsiveDatatablesHelper($('#datatable_mam_consParam'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_consParam.createExpandIcon(nRow);
                var info = mam_otable_consParam.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mam_consParam.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'inputParam_desc'},
                    {mData: 'parameter_range'},
                    {mData: 'consParam_reference'},
                    {mData: 'consParam_dataGeneration'},
                    {mData: 'consParam_method',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (data == '1')
                                $label = 'US-EPA Protocol 1 Method';
                            else
                                $label = 'NIST Standards';
                            return $label;
                        }
                    },
                    {mData: 'consParam_methodDetection'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-danger btn-xs mam_hideView" title="Delete" onclick="f_mam_delete_consParam ('+row.consParam_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_personnel = undefined; 
        mam_otable_personnel = $('#datatable_mam_personnel').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_personnel) {
                    datatable_mam_personnel = new ResponsiveDatatablesHelper($('#datatable_mam_personnel'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_personnel.createExpandIcon(nRow);
                var info = mam_otable_personnel.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mam_personnel.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'personnel_icNo'},
                    {mData: 'consPers_name'},
                    {mData: 'consPers_workingStatus',
                        mRender: function (data, type, row) {
                            return data == '2' ? 'Loan / Contracted' : 'Staff';
                        }
                    },
                    {mData: 'consPers_qualification'},
                    {mData: 'consPers_experience'},
                    {mData: 'consPers_certificate'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.consPers_document != null)
                                $label = '<a type="button" class="btn btn-success btn-xs" title="'+row.document_name+'" href="process/download.php?doc_id='+row.consPers_document+'"><i class="fa fa-download"></i></a> ';
                            $label += '<button type="button" class="btn btn-danger btn-xs mam_hideView" title="Delete" onclick="f_mam_delete_consPers ('+row.consPers_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mam_project = undefined; 
        mam_otable_project = $('#datatable_mam_project').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mam_project) {
                    datatable_mam_project = new ResponsiveDatatablesHelper($('#datatable_mam_project'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mam_project.createExpandIcon(nRow);
                var info = mam_otable_project.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mam_project.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'consProject_title'},
                    {mData: 'consProject_year'},
                    {mData: 'consProject_client'},
                    {mData: 'consProject_desc'},
                    {mData: 'consProject_scope'},
                    {mData: 'sourceActivity_desc'},
                    {mData: 'consProject_value', sClass: 'text-right', mRender: function(data) { return formattedNumber(data,2);}},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.consProject_type == '1')
                                $label = '<button type="button" class="btn btn-danger btn-xs mam_hideView" title="Delete" onclick="f_mam_delete_project ('+row.consProject_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
    });   
    
    function f_mam_delete_catDoc (consDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_analyzer_catalogue', {consDoc_id: consDoc_id}, 'p_registration', 'Document successfully deleted.')) {
                data_mam_catDoc = f_get_general_info_multiple('dt_consultant_doc', {consAll_id:$('#mam_consAll_id').val(), documentName_type:'analyz_man'}, '', '', 'consDoc_id');
                f_dataTable_draw(mam_otable_catDoc, data_mam_catDoc, 'datatable_mam_catDoc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mam_delete_certificate (certificate_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_certificate', {certificate_id: certificate_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mam_cert = f_get_general_info_multiple('dt_certificate', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'certificate_id');
                f_dataTable_draw(mam_otable_cert, data_mam_cert, 'datatable_mam_cert', 6);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mam_delete_consParam (consParam_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_parameter', {consParam_id: consParam_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mam_consParam = f_get_general_info_multiple('dt_consultant_parameter', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'consParam_id');
                f_dataTable_draw(mam_otable_consParam, data_mam_consParam, 'datatable_mam_consParam', 6);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mam_delete_consPers (consPers_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_personnel', {consPers_id: consPers_id, wfGroup_id: $('#mam_wfGroup_id').val()}, 'p_registration', 'Data successfully deleted.')) {
                data_mam_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'consPers_id');
                f_dataTable_draw(mam_otable_personnel, data_mam_personnel, 'datatable_mam_personnel', 8);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mam_delete_project (consProject_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_project', {consProject_id: consProject_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mam_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#mam_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
                f_dataTable_draw(mam_otable_project, data_mam_project, 'datatable_mam_project', 9);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mam_refresh_inputParameter() {        
        var arrStr_sourceActivity = '';
        $.each($("input[name='mam_sourceActivity_id[]']:checked"), function(){     
            arrStr_sourceActivity += ',' + $(this).val();
        });
        var arrStr_inputParam_type = '';
        $.each($("input[name='mam_consType_type[]']:checked"), function(){     
            arrStr_inputParam_type += ',' + $(this).val();
        });
        var arr_inputParam = f_get_general_info_multiple('vw_pub_group_inputParam', {}, {arr_inputParam_type:arrStr_inputParam_type, arr_sourceActivity_id:arrStr_sourceActivity});
        get_option_data('mam_inputParam_id', arr_inputParam, 'inputParam_id', 'inputParam_desc', ' ');
    }
            
    function f_mam_set_component(technique) {
        if (technique == '1') {
            $('.mam_div_component_gas').show();
            $('.mam_div_component_situ').hide();            
        } else {
            $('.mam_div_component_gas').hide();
            $('.mam_div_component_situ').show();
        }
        $.each(data_mam_component_2, function(u){
            if (data_mam_component_2[u].mobileEquip_mandatory == '1') {  
                $('#form_mam_2_7').bootstrapValidator('enableFieldValidators', 'mam_consMobileEquip_model_'+data_mam_component_2[u].mobileEquip_ids, (technique == '1'));
                $('#form_mam_2_7').bootstrapValidator('enableFieldValidators', 'mam_consMobileEquip_manufacturer_'+data_mam_component_2[u].mobileEquip_ids, (technique == '1'));
                $('#form_mam_2_7').bootstrapValidator('enableFieldValidators', 'mam_consMobileEquip_spec_'+data_mam_component_2[u].mobileEquip_ids, (technique == '1'));
            }
        });
    }
    
    function f_mam_addRange() {
        for (var i=1; i<=5; i++) {
            if (!$('#mam_div_paramRange_'+i).is(':visible')) {
                $('#mam_div_paramRange_'+i).show();
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_from_'+i, true);
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_to_'+i, true);
                for (var x=i; x>0; x--) {
                    $('#mam_consParamRange_from_'+x).val($('#mam_consParamRange_from_'+(x-1)).val());                    
                    $('#mam_consParamRange_to_'+x).val($('#mam_consParamRange_to_'+(x-1)).val());
                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_from_'+x);
                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_'+x);
                }
                $('#mam_consParamRange_from_0').val('');
                $('#mam_consParamRange_to_0').val('');
                if (i == 5)
                    $('#mam_btn_add_range').prop('disabled', true);
                break;
            }
        }
        $('#form_mam_2_3').bootstrapValidator('resetField', 'mam_consParamRange_from_0', true);
        $('#form_mam_2_3').bootstrapValidator('resetField', 'mam_consParamRange_to_0', true);
    }
    
    function f_mam_deleteRange(div_id) {
        for (var i=div_id; i<=5; i++) {
            if (i == 5) {
                $('#mam_div_paramRange_'+i).val('');
                $('#mam_consParamRange_to_'+i).val('');
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_from_'+i, false);
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_to_'+i, false);
                $('#mam_div_paramRange_'+i).hide();
            } else {
                if ($('#mam_div_paramRange_'+(i+1)).is(':visible')) {
                    $('#mam_consParamRange_from_'+i).val($('#mam_consParamRange_from_'+(i+1)).val());
                    $('#mam_consParamRange_to_'+i).val($('#mam_consParamRange_to_'+(i+1)).val());
                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_from_'+i);
                    $('#form_mam_2_3').bootstrapValidator('revalidateField', 'mam_consParamRange_to_'+i);
                } else {
                    $('#mam_div_paramRange_'+i).val('');
                    $('#mam_consParamRange_to_'+i).val('');
                    $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_from_'+i, false);
                    $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_to_'+i, false);
                    $('#mam_div_paramRange_'+i).hide();
                    break;
                }
            }
        }        
        $('#mam_btn_add_range').prop('disabled', false);
    }
    
    function f_mam_method_detection(analyzerTechnique_id) {
        set_option_empty('mam_analyzerTechnique_id');
        analyzerTechnique_id = typeof analyzerTechnique_id !== 'undefined' ? analyzerTechnique_id : '';
        var technique_type = '(0';
        $.each($("input[name='mam_consType_type[]']:checked"), function(){     
            technique_type += ',' + ($(this).val() == '1' ? '1':'2');
        });
        technique_type += ')';
        get_option('mam_analyzerTechnique_id', (mam_load_type <= 2 ? '1' : ''), 't_analyzer_technique', 'analyzerTechnique_id', 'analyzerTechnique_desc', 'analyzerTechnique_status', ' ', 'ref_id', 'analyzerTechnique_type', technique_type);
        $('#mam_analyzerTechnique_id').val(analyzerTechnique_id).prop('disabled', (mam_load_type > 2));
        if (mam_load_type <= 2 && analyzerTechnique_id == '')
            $('#form_mam_2_1').bootstrapValidator('revalidateField', 'mam_analyzerTechnique_id');
    }
    
    function f_mam_cert_usepa(certIssuer_id) {
        certIssuer_id = typeof certIssuer_id !== 'undefined' ? certIssuer_id : '';
        $('#form_mam_2_4').bootstrapValidator('resetField', 'mam_certificate_dateExpired', true);
        $('#form_mam_2_4').bootstrapValidator('resetField', 'mam_certBasic_id[]', true);
        $('#mam_certificate_dateExpired').prop('disabled', certIssuer_id == '' || certIssuer_id == '3');
        $("input[name='mam_certBasic_id[]']").prop('disabled', certIssuer_id == '' || certIssuer_id == '3');
    }
    
    function f_load_consultant_mobile (load_type, wfGroup_id, consAll_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (mam_1st_load) {          
                var source_activity = f_get_general_info_multiple('t_source_activity', {sourceActivity_status:'1'}, {}, '', 'sourceActivity_id');
                $.each(source_activity, function(u){
                    var html = '<div class="checkbox"><label>';
                    html += '<input type="checkbox" class="checkbox" name="mam_sourceActivity_id[]" value="'+source_activity[u].sourceActivity_id+'" >'; // onclick="f_mam_refresh_inputParameter();"
                    html += '<span>'+source_activity[u].sourceActivity_desc+'</span>';
                    html += '</label></div>';
                    $('#mam_div_sourceActivity').append(html);
                });                                
                var bootstrapValidator = $("#form_mam_2_6").data('bootstrapValidator');
                bootstrapValidator.addField('mam_sourceActivity_id[]', {validators:{choice:{min:1,message:'At least 1 Source of Activity required'}}});
                // ---------------- \\
                var certificate_basic = f_get_general_info_multiple('t_certificate_basic', {certBasic_status:'1'}, {}, '', 'certBasic_id');
                $.each(certificate_basic, function(u){
                    var html = '<div class="checkbox"><label>';
                    html += '<input type="checkbox" class="checkbox" name="mam_certBasic_id[]" value="'+certificate_basic[u].certBasic_id+'">';
                    html += '<span>'+certificate_basic[u].certBasic_desc+'</span>';
                    html += '</label></div>';
                    $('#mam_div_certBasic_id').append(html);
                });                                
                var bootstrapValidator = $("#form_mam_2_4").data('bootstrapValidator');
                bootstrapValidator.addField('mam_certBasic_id[]', {validators:{choice:{min:1,message:'At least 1 Basic of Certification required'}}});
                bootstrapValidator.addField('mam_certBasic_id[]', {
                    validators:{
                        callback: {
                            message: 'Basic of Certification must have EN-15267-3',
                            callback: function (value, validator, $field) { return $("input[name='mam_certBasic_id[]'][value=3]").is(':checked'); }
                        }
                    }
                });
                // ---------------- \\
                get_option('mam_cat_documentName_id', '1', 'document_name', 'documentName_id', 'documentName_desc', 'documentName_status', ' ', 'ref_id', 'documentName_type', 'analyz_man');           
                get_option('mam_certIssuer_id', '1', 't_certificate_issuer', 'certIssuer_id', 'certIssuer_desc', 'certIssuer_status', ' ', 'ref_id');           
                get_option('mam_consProject_source', '1', 't_source_activity', 'sourceActivity_id', 'sourceActivity_desc', 'sourceActivity_status', ' ', 'ref_id');           
                get_option('mam_analyzerTechnique_id', '1', 't_analyzer_technique', 'analyzerTechnique_id', 'analyzerTechnique_desc', 'analyzerTechnique_status', '', 'ref_id');            
                mam_1st_load = false;
            }
            if (load_type == 1) {            
                var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wfGroup_id, 'wfGroup_isFirstTime');        
                if (isFirstTime == '1') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', 'Please update Consultant Information as first-time login user in order to perform Mobile/Portable Analyzer registration');  
                    f_menu_redirect(7,0,0);
                    return false;
                }
            }
            $('#mam_analyzerTechnique_id').val([]).trigger('change');
            $('#form_mam,#form_mam_1,#form_mam_2_1,#form_mam_2_2,#form_mam_2_3,#form_mam_2_4,#form_mam_2_6,#form_mam_2_5, #form_mam_2_7,#form_mam_3,#form_mam_5,#form_mam_6,#form_mam_7').trigger('reset');
            $('#form_mam_2_1').bootstrapValidator('resetForm', true);
            $('#form_mam_2_2').bootstrapValidator('resetForm', true);
            $('#form_mam_2_3').bootstrapValidator('resetForm', true);
            $('#form_mam_2_4').bootstrapValidator('resetForm', true);
            $('#form_mam_2_5').bootstrapValidator('resetForm', true);
            $('#form_mam_2_6').bootstrapValidator('resetForm', true);
            $('#form_mam_2_7').bootstrapValidator('resetForm', true);
            $('#form_mam_3').bootstrapValidator('resetForm', true);
            $('#form_mam_5').bootstrapValidator('resetForm', true);
            $('#form_mam_6').bootstrapValidator('resetForm', true);
            $('#form_mam_7').bootstrapValidator('resetForm', true);
            $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_analyzerTechnique_id[]', true); 
            $('#mam_load_type').val(load_type);
            $('#mam_wfGroup_id').val(wfGroup_id);
            $('#mam_consAll_id').val(consAll_id);
            mam_otable = otable;
            mam_load_type = load_type;
            $('#form_mam,#form_mam_1,#form_mam_2_1,#form_mam_2_2,#form_mam_2_3,#form_mam_2_4,#form_mam_2_6,#form_mam_2_5, #form_mam_2_7,#form_mam_3,#form_mam_5,#form_mam_6').find('input, textarea, select').prop('disabled',false);
            $('.mam_hideView, .mam_div_component_situ').show();
            $('.mam_disView, #mam_dis_outsource, #mam_consParam_reference, #mam_consParam_method').attr('disabled',true);
            $('#mam_alert_box, .mam_checkView, .mam_div_component_gas, .mam_div_paramRange, #mam_lbl_catalogue, #mam_star_document_name').hide();
            $('#mam_snote_wfTask_remark').summernote('enable');
            $("input[name='mam_declare_1'], input[name='mam_declare_2']").prop('checked', false);
            $('#mam_btn_add_range').prop('disabled', false);
            for (var i=1; i<=5; i++) {
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_from_'+i, false);
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParamRange_to_'+i, false);
            }
            $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_consParam_reference', false)
                .bootstrapValidator('enableFieldValidators', 'mam_consParam_method', false);
            f_mam_cert_usepa();
            // ---------------- \\
            if (mam_load_type == 1) {            
                if (wfGroup_id == '') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                if (!f_submit_normal('create_consultant', {wfGroup_id:wfGroup_id, wfTaskType_id:'21', wfFlow_id:'3', consAll_type:'3'}, 'p_registration', '', errMsg_default))   return false;
                $('#mam_consAll_id').val(result_submit);
                if (mam_otable == 'cmc')
                    f_table_cmc ();
            } 
            // --- extract details --- //
            var status = load_type <= 2 ? '1' : '';
            get_option('mam_inputParam_id', status, 't_input_parameter', 'inputParam_id', 'inputParam_desc', 'inputParam_status', ' ', 'ref_id');
            var consultant_mobile = f_get_general_info('vw_consultant_mobile_details', {consAll_id:$('#mam_consAll_id').val()}, 'mam');  
            if ((consultant_mobile.wfTask_status == '22' && consultant_mobile.consMobile_status == '22') || (consultant_mobile.wfTask_status == '23' && consultant_mobile.consMobile_status == '23')) {
                var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:consultant_mobile.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
                $('#mam_alert_box').show();
                $('#mam_alert_message').html(previous_task[0].wfTask_remark);
            }
            $("input[name='mam_consMobile_probeEnabled']").prop('checked', (consultant_mobile.consMobile_probeEnabled=='1'));
            f_switch('form_mam_2_1', 'mam_consMobile_probeEnabled', 'mam_consMobile_probeType', 'mam_consMobile_probeLength');
            $("input[name='mam_consMobile_samplingEnabled']").prop('checked', (consultant_mobile.consMobile_samplingEnabled=='1'));
            f_switch('form_mam_2_1', 'mam_consMobile_samplingEnabled', 'mam_consMobile_samplingLine');
            $('#form_mam_3').bootstrapValidator('enableFieldValidators', 'mam_consPers_document', false);            
            $('#form_mam_3').bootstrapValidator('enableFieldValidators', 'mam_consPers_document_name', false);
            // ---------------- \\
            var consultant_type = f_get_general_info_multiple('t_consultant_type', {consAll_id:$('#mam_consAll_id').val()});
            $.each(consultant_type, function(u){
                $("input[name='mam_consType_type[]'][value=" + consultant_type[u].consType_type + "]").prop('checked', true);
            });
            var consultant_source = f_get_general_info_multiple('t_consultant_source', {consAll_id:$('#mam_consAll_id').val()});
            $.each(consultant_source, function(u){
                $("input[name='mam_sourceActivity_id[]'][value=" + consultant_source[u].sourceActivity_id + "]").prop('checked', true);
            });
            //f_mam_refresh_inputParameter();
            //f_mam_method_detection(consultant_mobile.analyzerTechnique_id);
            // ---------------- \\
            $("input[name='mam_consMobile_refMethod'][value=" + consultant_mobile.consMobile_refMethod + "]").prop('checked', true);
            $("input[name='mam_consMobile_compStatus'][value=" + consultant_mobile.consMobile_compStatus + "]").prop('checked', true);
            f_display_attachment('mam_doc_catalogue', f_get_general_info_multiple('vw_consultant_doc', {param_id:$('#mam_consAll_id').val()}));
            $('#mam_dis_outsource').attr('disabled', $('#mam_dis_type').val() == '2' ? false : true);
            // ---------------- \\
            $('[name="mam_snote_wfTask_remark"]').summernote('code', consultant_mobile.consAll_remark);
            $('#form_mam_6').bootstrapValidator('resetField', 'mam_snote_wfTask_remark');
            // --- tables --- //
            data_mam_catDoc = f_get_general_info_multiple('dt_consultant_doc', {consAll_id:$('#mam_consAll_id').val(), documentName_type:'analyz_man'}, '', '', 'consDoc_id');
            f_dataTable_draw(mam_otable_catDoc, data_mam_catDoc, 'datatable_mam_catDoc', 4);
            data_mam_component_1 = f_get_general_info_multiple('dt_mobile_cems_equipment', {mobileEquip_type:'1', mobileEquip_status:1}, {consAll_id:$('#mam_consAll_id').val()}, '', 'mobileEquip_ids');
            f_dataTable_draw(mam_otable_component_1, data_mam_component_1, 'datatable_mam_component_1', 2);
            data_mam_component_2 = f_get_general_info_multiple('dt_mobile_cems_equipment', {mobileEquip_type:'2', mobileEquip_status:1}, {consAll_id:$('#mam_consAll_id').val()}, '', 'mobileEquip_ids');
            f_dataTable_draw(mam_otable_component_2, data_mam_component_2, 'datatable_mam_component_2', 4);
            data_mam_component_3 = f_get_general_info_multiple('dt_mobile_cems_equipment', {mobileEquip_type:'3', mobileEquip_status:1}, {consAll_id:$('#mam_consAll_id').val()}, '', 'mobileEquip_ids');
            f_dataTable_draw(mam_otable_component_3, data_mam_component_3, 'datatable_mam_component_3', 2);
            data_mam_cert = f_get_general_info_multiple('dt_certificate', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'certificate_id');
            f_dataTable_draw(mam_otable_cert, data_mam_cert, 'datatable_mam_cert', 6);
            data_mam_consParam = f_get_general_info_multiple('dt_consultant_parameter', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'consParam_id');
            f_dataTable_draw(mam_otable_consParam, data_mam_consParam, 'datatable_mam_consParam', 6);
            data_mam_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#mam_consAll_id').val()}, '', '', 'consPers_id');
            f_dataTable_draw(mam_otable_personnel, data_mam_personnel, 'datatable_mam_personnel', 8);
            data_mam_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#mam_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
            f_dataTable_draw(mam_otable_project, data_mam_project, 'datatable_mam_project', 9);
            // ---------------- \\
            f_mam_set_component(consultant_mobile.consMobile_techniqueType);
            // ---------------- \\
            if (mam_load_type >= 3) {
                mam_total_section = [];
                $('#form_mam,#form_mam_1,#form_mam_2_1,#form_mam_2_2,#form_mam_2_3,#form_mam_2_4,#form_mam_2_6,#form_mam_2_7,#form_mam_2_5,#form_mam_3,#form_mam_5,#form_mam_6').find('input, textarea, select').prop('disabled',true);
                $('#mam_snote_wfTask_remark').summernote('disable');
                $("input[name='mam_declare_1'], input[name='mam_declare_2']").prop('checked', true);
                $('.mam_hideView').hide();
                $('#mam_lbl_catalogue').show();
                $('#form_mam_2_3').bootstrapValidator('enableFieldValidators', 'mam_analyzerTechnique_id[]', false); 
                if (mam_load_type >= 4) {
                    $('.mam_form_check').prop('disabled', false);
                    $('.mam_checkView, #mam_btn_save').show();
                    var checklist_task = f_get_general_info_multiple('t_checklist_task', {wfTask_id:$('#mam_wfTask_id').val(), checklistTask_status:'1'});
                    $.each(checklist_task, function(u){
                        $('#mam_check_remark_'+checklist_task[u].checklist_id).val(checklist_task[u].checklistTask_remark);
                        if (checklist_task[u].checklistTask_result == '1')
                            $("input[name='mam_check_pass_"+checklist_task[u].checklist_id+"']").prop('checked', true);
                        mam_total_section[u] = checklist_task[u].checklist_id;
                    });    
                }
            }    
            $('#modal_consultant_mobile').modal('show');            
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>