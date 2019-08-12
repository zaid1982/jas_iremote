<script type="text/javascript">  
    
    var mac_otable;
    var mac_load_type;
    var mac_1st_load = true;
    var mac_otable_docSupport;
    var data_mac_docSupport;
    var mac_otable_catDoc;
    var data_mac_catDoc;
    var mac_otable_cert;
    var data_mac_cert;
    var mac_otable_consParam;
    var data_mac_consParam;
    var mac_otable_personnel;
    var data_mac_personnel;
    var mac_otable_project;
    var data_mac_project;
    var mac_interval;
    var mac_interval_cnt = 0;
    var mac_total_section = [];
    
    $(document).ready(function () {
        
        $('#mac_btn_next').on('click', function () {
            var stepNum = $('#mac_wizard').wizard('selectedItem'); 
            if (stepNum.step == 4)
                $('#mac_btn_next').prop('disabled', true);
        });
        
        $('#mac_btn_prev').on('click', function () {
            var stepNum = $('#mac_wizard').wizard('selectedItem'); 
            if (stepNum.step == 5)
                $('#mac_btn_next').prop('disabled', false);
        });

        $('#mac_certificate_dateExpired').datepicker({
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
                $('#form_mac_2_4').bootstrapValidator('revalidateField', 'mac_certificate_dateExpired');
            }
        });
        
        $('#mac_snote_wfTask_remark').summernote({
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
                    $('#form_mac_6').bootstrapValidator('revalidateField', 'mac_snote_wfTask_remark');
                    $('#mac_wfTask_remark').val(contents);
                }
            }
        });   
        
        $('#form_mac_2_1').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                'mac_consType_type[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Type of Analyzer required'
                        }                        
                    }
                },
                mac_consCems_modelNo : {
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
                mac_consCems_isNormalize : {
                    validators: {
                        notEmpty: {
                            message: 'Normalization is required'
                        }
                    }
                },
                mac_consCems_correction : {
                    validators: {
                        notEmpty: {
                            message: 'Correction is required'
                        }
                    }
                },
                mac_consCems_techniqueType : {
                    validators: {
                        notEmpty: {
                            message: 'Technique is required'
                        }
                    }
                },
                mac_consCems_brand : {
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
                mac_consCems_manufacturer : {
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
                mac_consCems_probeType : {
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
                mac_consCems_probeLength : {
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
                mac_consCems_samplingLine : {
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
        
        $('#mac_consCems_techniqueType').on('change', function () {
            $('#mac_dis_outsource').val('');
            $('#form_mac_2_1').bootstrapValidator('revalidateField', 'mac_consCems_samplingLine');
        });
        
        $('#form_mac_2_6').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                'mac_consultant_type[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Type of Consultant required'
                        }                        
                    }
                },
                mac_consCems_compStatus : {
                    validators: {
                        notEmpty: {
                            message: 'Product Status is required'
                        }
                    }
                }
            }
        });     
        
        $('#form_mac_2_2').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mac_cat_documentName_id : {
                    validators: {
                        notEmpty: {
                            message: 'Document Type is required'
                        }
                    }
                },
                mac_cat_document_name : {
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
                mac_file_catalogue: {
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
        
        $('#form_mac_2_3').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mac_inputParam_id : {
                    validators: {
                        notEmpty: {
                            message: 'Input Parameter is required'
                        }
                    }
                },                
                'mac_analyzerTechnique_id[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Method of Detection is required'
                        }                        
                    }
                },
                mac_consParamRange_from_0 : {
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
                            message: 'Analyzer Certified (From) must in the range of 0 and 10,000',
                            callback: function (value, validator, $field) {
                                if ($('#mac_consParamRange_to_0').val() != '')
                                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_0');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 10000);
                            }
                        }
                    }
                },
                mac_consParamRange_to_0 : {
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
                                var value_from = parseFloat($('#mac_consParamRange_from_0').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 10000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 10,000'
                                };
                            }
                        }
                    }
                },
                mac_consParamRange_from_1 : {
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
                            message: 'Analyzer Certified (From) must in the range of 0 and 10,000',
                            callback: function (value, validator, $field) {
                                if ($('#mac_consParamRange_to_1').val() != '')
                                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_1');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 10000);
                            }
                        }
                    }
                },
                mac_consParamRange_to_1 : {
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
                                var value_from = parseFloat($('#mac_consParamRange_from_1').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 10000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 10,000'
                                };
                            }
                        }
                    }
                },
                mac_consParamRange_from_2 : {
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
                            message: 'Analyzer Certified (From) must in the range of 0 and 10,000',
                            callback: function (value, validator, $field) {
                                if ($('#mac_consParamRange_to_2').val() != '')
                                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_2');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 10000);
                            }
                        }
                    }
                },
                mac_consParamRange_to_2 : {
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
                                var value_from = parseFloat($('#mac_consParamRange_from_2').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 10000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 10,000'
                                };
                            }
                        }
                    }
                },
                mac_consParamRange_from_3 : {
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
                            message: 'Analyzer Certified (From) must in the range of 0 and 10,000',
                            callback: function (value, validator, $field) {
                                if ($('#mac_consParamRange_to_3').val() != '')
                                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_3');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 10000);
                            }
                        }
                    }
                },
                mac_consParamRange_to_3 : {
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
                                var value_from = parseFloat($('#mac_consParamRange_from_3').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 10000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 10,000'
                                };
                            }
                        }
                    }
                },
                mac_consParamRange_from_4 : {
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
                            message: 'Analyzer Certified (From) must in the range of 0 and 10,000',
                            callback: function (value, validator, $field) {
                                if ($('#mac_consParamRange_to_4').val() != '')
                                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_4');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 10000);
                            }
                        }
                    }
                },
                mac_consParamRange_to_4 : {
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
                                var value_from = parseFloat($('#mac_consParamRange_from_4').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 10000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 10,000'
                                };
                            }
                        }
                    }
                },
                mac_consParamRange_from_5 : {
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
                            message: 'Analyzer Certified (From) must in the range of 0 and 10,000',
                            callback: function (value, validator, $field) {
                                if ($('#mac_consParamRange_to_5').val() != '')
                                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_5');
                                return (parseFloat(value) >= 0 && parseFloat(value) <= 10000);
                            }
                        }
                    }
                },
                mac_consParamRange_to_5 : {
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
                                var value_from = parseFloat($('#mac_consParamRange_from_5').val());
                                return {
                                    valid: parseFloat(value) >= (isNaN(value_from)?0:value_from) && parseFloat(value) <= 10000,
                                    message: 'Specified Range To must in the range of ' + (isNaN(value_from)?0:value_from) + ' and 10,000'
                                };
                            }
                        }
                    }
                },
                mac_consParam_reference : {
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
                mac_consParam_dataGeneration : {
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
                mac_consParam_method : {
                    validators: {
                        notEmpty: {
                            message: 'Method is required'
                        }
                    }
                }
            }
        });
        
        $('#mac_inputParam_id').on('change', function () {
            if (jQuery.inArray($(this).val(), ['1', '2', '3', '4', '5', '6', '7']) >= 0) {
                $('.mac_consParam_unit').html('mg/m<sup>3</sup>');
            } else if (jQuery.inArray($(this).val(), ['8', '9', '10', '11']) >= 0) {
                $('.mac_consParam_unit').html('%');
            }
            if (jQuery.inArray($(this).val(), ['1', '8']) >= 0) {
                $('#mac_consParam_reference, #mac_consParam_method').attr('disabled', true)
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParam_reference', false)
                    .bootstrapValidator('enableFieldValidators', 'mac_consParam_method', false);
            } else {
                $('#mac_consParam_reference, #mac_consParam_method').attr('disabled', false)
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParam_reference', true)
                    .bootstrapValidator('enableFieldValidators', 'mac_consParam_method', true);
            }
        });
        
        $('#form_mac_2_4').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mac_certificate_no : {
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
                mac_certIssuer_id : {
                    validators: {
                        notEmpty: {
                            message: 'Certificate Issuer is required'
                        }
                    }
                },
                mac_certificate_dateExpired : {
                    validators: {
                        notEmpty: {
                            message: 'Expired Date is required'
                        }
                    }
                },
                mac_file_certificate_name : {
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
                mac_file_certificate : {
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
        
        $('#mac_certIssuer_id').on('change', function() {
            var is_enabled = $(this).val() != '3';
            $('#form_mac_2_4').bootstrapValidator('enableFieldValidators', 'mac_certificate_dateExpired', is_enabled)
                .bootstrapValidator('enableFieldValidators', 'mac_certificate_basic', is_enabled)
                .bootstrapValidator('enableFieldValidators', 'mac_file_certificate', is_enabled);
            $('#form_mac_2_4').bootstrapValidator('revalidateField', 'mac_certificate_dateExpired')
                .bootstrapValidator('revalidateField', 'mac_certificate_basic')
                .bootstrapValidator('revalidateField', 'mac_file_certificate');
        });    
        
        $('#form_mac_2_5').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mac_das_probeSoftware : {
                    validators: {
                        stringLength : {
                            max : 100,
                            message : 'Probe Software Version must be not more than 100 characters long'
                        }
                    }
                },
                mac_das_probeDesc : {
                    validators: {
                        stringLength : {
                            max : 255,
                            message : 'Probe Software Description must be not more than 100 characters long'
                        }
                    }
                },
                mac_das_analyzerSoftware : {
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
                mac_das_analyzerDesc : {
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
                mac_dis_name : {
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
                mac_dis_type : {
                    validators: {
                        notEmpty: {
                            message: 'Status of DIS is required'
                        }
                    }
                },
                mac_dis_outsource : {
                    validators: {
                        callback: {
                            message: 'Outsourced Company is required',
                            callback: function (value, validator, $field) {
                                return ($('#mac_dis_type').val() != '2') ? true : (value !== '');
                            }
                        },
                        stringLength : {
                            max : 80,
                            message : 'Outsourced Company must be not more than 80 characters long'
                        }
                    }
                },
                mac_dis_description : {
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
        
        $('#form_mac_3').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mac_consPers_name : {
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
                mac_personnel_icNo : {
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
                                var value_citizen = $('input[name="mac_personnel_citizenship"]:checked').val();
                                return {
                                    valid: (value_citizen==1 && value.length== 12) || (value_citizen==2&&value.length>=5 && value.length<=9),
                                    message: (value_citizen==1?'Identification No.':'Passport') + ' No. must be ' + (value_citizen==1?'12':'between 5 and 9') + ' digits long'
                                };
                            }
                        }
                    }
                },
                mac_consPers_qualification : {
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
                mac_consPers_experience : {
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
                mac_consPers_certificate : {
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
                mac_consPers_document_name : {
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
                mac_consPers_document : {
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
        
        $('#form_mac_3').find('[name="mac_personnel_citizenship"]').on('click', function () { 
            var is_enabled = $(this).val() == '1';
            $('#form_mac_3').bootstrapValidator('enableFieldValidators', 'mac_personnel_icNo', is_enabled, 'digits');
            $('#form_mac_3').bootstrapValidator('revalidateField', 'mac_personnel_icNo');
        });
        
        $('#form_mac_3').find('[name="mac_consPers_workingStatus"]').on('click', function () { 
            var is_enabled = $(this).val() == '2';
            $('#form_mac_3').bootstrapValidator('enableFieldValidators', 'mac_consPers_document', is_enabled);
            $('#form_mac_3').bootstrapValidator('revalidateField', 'mac_consPers_document');
            $('#form_mac_3').bootstrapValidator('enableFieldValidators', 'mac_consPers_document_name', is_enabled);
            $('#form_mac_3').bootstrapValidator('revalidateField', 'mac_consPers_document_name');
            is_enabled ? $('#mac_star_document_name').show() : $('#mac_star_document_name').hide(); 
        });
        
        $('#form_mac_5').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mac_consProject_title : {
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
                mac_consProject_year : {
                    validators: {
                        notEmpty: {
                            message: 'Year is required'
                        }
                    }
                },
                mac_consProject_client : {
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
                mac_consProject_desc : {
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
                mac_consProject_scope : {
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
                mac_consProject_source : {
                    validators: {
                        notEmpty: {
                            message: 'Source of Activity is required'
                        }
                    }
                },
                mac_consProject_value : {
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
        
        $('#form_mac_6').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mac_declare_1 : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration required'
                        }                        
                    }
                },
                mac_declare_2 : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration required'
                        }                        
                    }
                },
                mac_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mac_snote_wfTask_remark"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#modal_consultant_cems').on('show.bs.modal', function() {
            $('#mac_wizard').wizard('selectedItem', { step:1 });
            $('#mac_btn_next').prop('disabled', false);    
//            if ($('#mac_load_type').val() == '1' || $('#mac_load_type').val() == '2') {
//                mac_interval = window.setInterval(function(){ 
//                    if (mac_interval_cnt == 1) {
//                        $('#mac_funct').val('save_consultant_cems');
//                        $('#mac_wfTask_remark').val($('[name="mac_snote_wfTask_remark"]').summernote('code'));
//                        $('#modal_waiting').on('shown.bs.modal', function(e){
//                            if (f_submit_forms('form_mac,#form_mac_2_1,#form_mac_2_5,#form_mac_2_6,#form_mac_6', 'p_registration', 'Data successfully saved.')) {
//                                if (mac_otable == 'cca')
//                                    f_table_cca ();
//                            }
//                            $('#modal_waiting').modal('hide');
//                            $(this).unbind(e);
//                        }).modal('show');  
//                    }
//                    mac_interval_cnt = 1;
//                }, 300000);
//            }
        });
        
        $('#modal_consultant_cems').on('hide.bs.modal', function() {
            mac_interval_cnt = 0;
            //clearInterval(mac_interval);
            mac_interval = 0;
        });
                
        $('#mac_dis_type').on('change', function () {
            $('#mac_dis_outsource').val('');
            $('#form_mac_2_5').bootstrapValidator('revalidateField', 'mac_dis_outsource');
            $('#mac_dis_outsource').attr('disabled',$(this).val() == '2' ? false : true);
            $('#form_mac_2_5').bootstrapValidator('revalidateField', 'mac_dis_outsource');
        });
        
        $('#mac_btn_save').on('click', function () {            
            if ($('#mac_load_type').val() == '4') {
                $('#modal_waiting').on('shown.bs.modal', function(e){ 
                    var parameters = {};
                    parameters['wfTask_id'] = $('#mac_wfTask_id').val();    
                    parameters['wfFlow_id'] = '1';       
                    $.each(mac_total_section, function(value){     
                        parameters['check_remark_'+mac_total_section[value]] = $('#mac_check_remark_'+mac_total_section[value]).val();
                        parameters['check_pass_'+mac_total_section[value]] = $("input[name='mac_check_pass_"+mac_total_section[value]+"']").is(':checked') ? '1' : '0';
                    });
                    f_submit_normal('save_process_checking', parameters, 'p_registration', 'Process Checklist successfully saved.');
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                $('#mac_funct').val('save_consultant_cems');
                $('#mac_wfTask_remark').val($('[name="mac_snote_wfTask_remark"]').summernote('code'));
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_mac,#form_mac_2_1,#form_mac_2_5,#form_mac_2_6,#form_mac_6', 'p_registration', 'Data successfully saved.')) {
                        if (mac_otable == 'cca')
                            f_table_cca ();
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            }
        }); 
        
        $('#mac_btn_submit').on('click', function () {  
            var bootstrapValidator = $("#form_mac_2_1").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mac_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_mac_catDoc.length == 0) {
                $('#mac_wizard').wizard('selectedItem', { step:2 });
                $('#mac_btn_upload_catalogue').focus();
                f_notify(2, 'Error', 'Please provide Manual and Catalogue!');    
                return false;
            } else {
                var is_exist_9 = false; 
                var is_exist_23 = false;
                $.each(data_mac_catDoc, function(v){     
                    if (data_mac_catDoc[v].documentName_id == '9')
                        is_exist_9 = true;
                    else if (data_mac_catDoc[v].documentName_id == '23')
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
            bootstrapValidator = $("#form_mac_2_6").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mac_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_mac_consParam.length == 0) {
                $('#mac_wizard').wizard('selectedItem', { step:2 });
                $('#mac_btn_add_parameter').focus();
                f_notify(2, 'Error', 'Please provide Parameters and Specified Range!');    
                return false;            
            }
            if (data_mac_cert.length == 0) {
                $('#mac_wizard').wizard('selectedItem', { step:2 });
                $('#mac_btn_add_certificate').focus();
                f_notify(2, 'Error', 'Please provide Analyzer Certification!');    
                return false;
            }
            bootstrapValidator = $("#form_mac_2_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mac_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_mac_personnel.length == 0) {
                $('#mac_wizard').wizard('selectedItem', { step:3 });
                $('#mac_btn_add_personnel').focus();
                f_notify(2, 'Error', 'Please provide Information of Personnel for CEMS!');    
                return false;
            }
            if (!f_submit_normal('check_consultant_personnel', {consAll_id:$('#mac_consAll_id').val(), wfGroup_id: $('#mac_wfGroup_id').val()}, 'p_registration')) {
                $('#mac_wizard').wizard('selectedItem', { step:3 });
                $('#mac_btn_add_personnel').focus();
                return false;
            }                 
            if (data_mac_project.length == 0) {
                $('#mac_wizard').wizard('selectedItem', { step:4 });
                $('#mac_btn_add_project').focus();
                f_notify(2, 'Error', 'Please provide Information of Company\'s Working Experience!');    
                return false;
            }
            bootstrapValidator = $("#form_mac_6").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mac_wizard').wizard('selectedItem', { step:5 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            var chk_doc_27 = f_get_general_info_multiple('t_consultant_docSupport', {consultant_id:$('#mac_consultant_id').val(), documentName_id:'27'});
            if(chk_doc_27.length === 0) {
                f_notify(2, 'Error', 'Please upload Company Profile on Consultant Information menu!');    
                return false;
            }
            var chk_doc_28 = f_get_general_info_multiple('t_consultant_docSupport', {consultant_id:$('#mac_consultant_id').val(), documentName_id:'28'});
            if(chk_doc_28.length === 0) {
                f_notify(2, 'Error', 'Please upload Registration of Companies on Consultant Information menu!');    
                return false;
            }
            $("#mac_funct").val('save_consultant_cems');
            $('#mac_wfTask_remark').val($('[name="mac_snote_wfTask_remark"]').summernote('code'));
            if (f_submit_forms('form_mac,#form_mac_2_1,#form_mac_2_5,#form_mac_2_6,#form_mac_6', 'p_registration')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure to submit the CEMS Consultant Registration Form?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {            
                        $('#modal_waiting').on('shown.bs.modal', function(e){    
                            if (f_submit_normal('check_consultant_active', {wfGroup_id: $('#mac_wfGroup_id').val()}, 'p_registration')) {
                                var submit_status = $('#mac_wfTask_status').val() == '2' ? '10' : '13';
                                var submit_msg = $('#mac_wfTask_status').val() == '2' ? 'Your application successfully submitted. Result will be alerted through your email.' : 'Your application successfully resubmitted. Result will be alerted through your email.';
                                var condition_no = $('#mac_wfTask_status').val() == '2' ? '' : '1';
                                var wfGroup_id = $('#mac_wfTask_status').val() == '2' ? $('#mac_wfGroup_id').val() : '';
                                if (f_submit($('#mac_wfTask_id').val(), $('#mac_wfTaskType_id').val(), submit_status, submit_msg, $('#mac_wfTask_remark').val(), condition_no, wfGroup_id, '', 'consAll_id', $('#mac_consAll_id').val())) {
                                    var email_type = submit_status == '2' ? 'email_assign' : 'email_process';
                                    f_send_email(email_type, {wfTask_id:result_submit_task}); 
                                    if (mac_otable == 'hm8') 
                                        f_hm8_set_alert();
                                    else if (mac_otable == 'cca')
                                        f_table_cca ();
                                    $('#modal_consultant_cems').modal('hide');
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
        
        $('#mac_btn_upload_catalogue').on('click', function () {
            var bootstrapValidator = $("#form_mac_2_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {  
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mac_2_2')[0]);
                    formData.append('funct', 'upload_analyzer_catalogue');
                    formData.append('consAll_id', $('#mac_consAll_id').val());
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
                                $('#form_mac_2_2').trigger('reset');
                                $('#form_mac_2_2').bootstrapValidator('resetForm', true);
                                data_mac_catDoc = f_get_general_info_multiple('dt_consultant_doc', {consAll_id:$('#mac_consAll_id').val(), documentName_type:'analyz_man'}, '', '', 'consDoc_id');
                                f_dataTable_draw(mac_otable_catDoc, data_mac_catDoc, 'datatable_mac_catDoc', 4);
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
                $('#mac_file_catalogue').focus();
                f_notify(2, 'Error', 'Please make sure file to be uploaded is selected.');   
            }
        });
        
        $('#mac_btn_add_parameter').on('click', function () {            
            var bootstrapValidator = $("#form_mac_2_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {     
                $('#mac_funct').val('save_consultant_parameter');
                $('#modal_waiting').on('shown.bs.modal', function(e){                    
                    if (f_submit_forms('form_mac,#form_mac_2_3', 'p_registration', 'Input Parameter successfully added.')) {
                        $('#form_mac_2_3').trigger('reset');
                        $('#mac_analyzerTechnique_id').val([]).trigger('change');
                        $('#form_mac_2_3').bootstrapValidator('resetForm', true);                        
                        $('.mac_div_paramRange').hide();
                        $('#mac_btn_add_range').prop('disabled', false);
                        for (var i=1; i<=5; i++) {
                            $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_from_'+i, false);
                            $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_to_'+i, false);
                        }                        
                        $('#mac_consParam_reference, #mac_consParam_method').prop('disabled', true);
                        $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParam_reference', false)
                            .bootstrapValidator('enableFieldValidators', 'mac_consParam_method', false);
                        data_mac_consParam = f_get_general_info_multiple('dt_consultant_parameter', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'consParam_id');
                        f_dataTable_draw(mac_otable_consParam, data_mac_consParam, 'datatable_mac_consParam', 6);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        $('#mac_btn_add_certificate').on('click', function () {
            var bootstrapValidator = $("#form_mac_2_4").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mac_2_4')[0]);
                    formData.append('funct', 'save_certificate');
                    formData.append('mac_consAll_id', $('#mac_consAll_id').val());
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
                                $('#form_mac_2_4').trigger('reset');
                                $('#form_mac_2_4').bootstrapValidator('resetForm', true);
                                f_mac_cert_usepa();
                                data_mac_cert = f_get_general_info_multiple('dt_certificate', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'certificate_id');
                                f_dataTable_draw(mac_otable_cert, data_mac_cert, 'datatable_mac_cert', 6);
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
        
        $('#mac_btn_add_personnel').on('click', function () {
            var bootstrapValidator = $("#form_mac_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#mac_funct').val('save_consultant_personnel');
                $('#modal_waiting').on('shown.bs.modal', function(e){     
                    var formData = new FormData($('#form_mac_3')[0]);
                    formData.append('funct', 'save_consultant_personnel');
                    formData.append('mac_consAll_id', $('#mac_consAll_id').val());
                    formData.append('mac_wfGroup_id', $('#mac_wfGroup_id').val());
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
                                $('#form_mac_3').trigger('reset');
                                $('#form_mac_3').bootstrapValidator('resetForm', true);
                                $('#mac_star_document_name').hide();
                                data_mac_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'consPers_id');
                                f_dataTable_draw(mac_otable_personnel, data_mac_personnel, 'datatable_mac_personnel', 8);
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
        
        $('#mac_btn_add_project').on('click', function () {
            var bootstrapValidator = $("#form_mac_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#mac_funct').val('save_consultant_project');
                $('#modal_waiting').on('shown.bs.modal', function(e){    
                    if (f_submit_forms('form_mac,#form_mac_5', 'p_registration', 'Company Working Experience successfully added.')) {
                        $('#form_mac_5').bootstrapValidator('resetForm', true);                    
                        data_mac_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#mac_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
                        f_dataTable_draw(mac_otable_project, data_mac_project, 'datatable_mac_project', 9);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        });
        
        var datatable_mac_docSupport = undefined; 
        mac_otable_docSupport = $('#datatable_mac_docSupport').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mac_docSupport) {
                    datatable_mac_docSupport = new ResponsiveDatatablesHelper($('#datatable_mac_docSupport'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mac_docSupport.createExpandIcon(nRow);
                var info = mac_otable_docSupport.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mac_docSupport.respond();
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
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mac_catDoc = undefined; 
        mac_otable_catDoc = $('#datatable_mac_catDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mac_catDoc) {
                    datatable_mac_catDoc = new ResponsiveDatatablesHelper($('#datatable_mac_catDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mac_catDoc.createExpandIcon(nRow);
                var info = mac_otable_catDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mac_catDoc.respond();
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
                            $label += ' <button type="button" class="btn btn-danger btn-xs mac_hideView" title="Delete" onclick="f_mac_delete_catDoc ('+row.consDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mac_cert = undefined; 
        mac_otable_cert = $('#datatable_mac_cert').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mac_cert) {
                    datatable_mac_cert = new ResponsiveDatatablesHelper($('#datatable_mac_cert'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mac_cert.createExpandIcon(nRow);
                var info = mac_otable_cert.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mac_cert.respond();
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
                            $label += ' <button type="button" class="btn btn-danger btn-xs mac_hideView" title="Delete" onclick="f_mac_delete_certificate ('+row.certificate_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mac_consParam = undefined; 
        mac_otable_consParam = $('#datatable_mac_consParam').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mac_consParam) {
                    datatable_mac_consParam = new ResponsiveDatatablesHelper($('#datatable_mac_consParam'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mac_consParam.createExpandIcon(nRow);
                var info = mac_otable_consParam.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mac_consParam.respond();
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
                            else if (data == '2')
                                $label = 'NIST Standards';
                            return $label;
                        }
                    },
                    {mData: 'consParam_methodDetection'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<button type="button" class="btn btn-danger btn-xs mac_hideView" title="Delete" onclick="f_mac_delete_consParam ('+row.consParam_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mac_personnel = undefined; 
        mac_otable_personnel = $('#datatable_mac_personnel').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mac_personnel) {
                    datatable_mac_personnel = new ResponsiveDatatablesHelper($('#datatable_mac_personnel'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mac_personnel.createExpandIcon(nRow);
                var info = mac_otable_personnel.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mac_personnel.respond();
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
                            $label += '<button type="button" class="btn btn-danger btn-xs mac_hideView" title="Delete" onclick="f_mac_delete_consPers ('+row.consPers_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mac_project = undefined; 
        mac_otable_project = $('#datatable_mac_project').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mac_project) {
                    datatable_mac_project = new ResponsiveDatatablesHelper($('#datatable_mac_project'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mac_project.createExpandIcon(nRow);
                var info = mac_otable_project.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mac_project.respond();
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
                                $label = '<button type="button" class="btn btn-danger btn-xs mac_hideView" title="Delete" onclick="f_mac_delete_project ('+row.consProject_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
    });  
    
    function f_mac_delete_catDoc (consDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_analyzer_catalogue', {consDoc_id: consDoc_id}, 'p_registration', 'Document successfully deleted.')) {
                data_mac_catDoc = f_get_general_info_multiple('dt_consultant_doc', {consAll_id:$('#mac_consAll_id').val(), documentName_type:'analyz_man'}, '', '', 'consDoc_id');
                f_dataTable_draw(mac_otable_catDoc, data_mac_catDoc, 'datatable_mac_catDoc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mac_delete_certificate (certificate_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_certificate', {certificate_id: certificate_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mac_cert = f_get_general_info_multiple('dt_certificate', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'certificate_id');
                f_dataTable_draw(mac_otable_cert, data_mac_cert, 'datatable_mac_cert', 6);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mac_delete_consParam (consParam_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_parameter', {consParam_id: consParam_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mac_consParam = f_get_general_info_multiple('dt_consultant_parameter', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'consParam_id');
                f_dataTable_draw(mac_otable_consParam, data_mac_consParam, 'datatable_mac_consParam', 6);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mac_delete_consPers (consPers_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_personnel', {consPers_id: consPers_id, wfGroup_id: $('#mac_wfGroup_id').val()}, 'p_registration', 'Data successfully deleted.')) {
                data_mac_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'consPers_id');
                f_dataTable_draw(mac_otable_personnel, data_mac_personnel, 'datatable_mac_personnel', 8);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mac_delete_project (consProject_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_project', {consProject_id: consProject_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mac_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#mac_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
                f_dataTable_draw(mac_otable_project, data_mac_project, 'datatable_mac_project', 9);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mac_refresh_inputParameter() {        
        var arrStr_sourceActivity = '';
        $.each($("input[name='mac_sourceActivity_id[]']:checked"), function(){     
            arrStr_sourceActivity += ',' + $(this).val();
        });
        var arrStr_inputParam_type = '';
        $.each($("input[name='mac_consType_type[]']:checked"), function(){     
            arrStr_inputParam_type += ',' + $(this).val();
        });
        var arr_inputParam = f_get_general_info_multiple('vw_pub_group_inputParam', {}, {arr_inputParam_type:arrStr_inputParam_type, arr_sourceActivity_id:arrStr_sourceActivity});
        get_option_data('mac_inputParam_id', arr_inputParam, 'inputParam_id', 'inputParam_desc', ' ');
    }
        
    function f_mac_addRange() {
        for (var i=1; i<=5; i++) {
            if (!$('#mac_div_paramRange_'+i).is(':visible')) {
                $('#mac_div_paramRange_'+i).show();
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_from_'+i, true);
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_to_'+i, true);
                for (var x=i; x>0; x--) {
                    $('#mac_consParamRange_from_'+x).val($('#mac_consParamRange_from_'+(x-1)).val());                    
                    $('#mac_consParamRange_to_'+x).val($('#mac_consParamRange_to_'+(x-1)).val());
                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_from_'+x);
                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_'+x);
                }
                $('#mac_consParamRange_from_0').val('');
                $('#mac_consParamRange_to_0').val('');
                if (i == 5)
                    $('#mac_btn_add_range').prop('disabled', true);
                break;
            }
        }
        $('#form_mac_2_3').bootstrapValidator('resetField', 'mac_consParamRange_from_0', true);
        $('#form_mac_2_3').bootstrapValidator('resetField', 'mac_consParamRange_to_0', true);
    }
    
    function f_mac_deleteRange(div_id) {
        for (var i=div_id; i<=5; i++) {
            if (i == 5) {
                $('#mac_div_paramRange_'+i).val('');
                $('#mac_consParamRange_to_'+i).val('');
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_from_'+i, false);
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_to_'+i, false);
                $('#mac_div_paramRange_'+i).hide();
            } else {
                if ($('#mac_div_paramRange_'+(i+1)).is(':visible')) {
                    $('#mac_consParamRange_from_'+i).val($('#mac_consParamRange_from_'+(i+1)).val());
                    $('#mac_consParamRange_to_'+i).val($('#mac_consParamRange_to_'+(i+1)).val());
                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_from_'+i);
                    $('#form_mac_2_3').bootstrapValidator('revalidateField', 'mac_consParamRange_to_'+i);
                } else {
                    $('#mac_div_paramRange_'+i).val('');
                    $('#mac_consParamRange_to_'+i).val('');
                    $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_from_'+i, false);
                    $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_to_'+i, false);
                    $('#mac_div_paramRange_'+i).hide();
                    break;
                }
            }
        }        
        $('#mac_btn_add_range').prop('disabled', false);
    }
    
    function f_mac_method_detection(analyzerTechnique_id) {
        set_option_empty('mac_analyzerTechnique_id');
        analyzerTechnique_id = typeof analyzerTechnique_id !== 'undefined' ? analyzerTechnique_id : '';
        var technique_type = '(0';
        $.each($("input[name='mac_consType_type[]']:checked"), function(){     
            technique_type += ',' + ($(this).val() == '1' ? '1':'2');
        });
        technique_type += ')';
        get_option('mac_analyzerTechnique_id', (mac_load_type <= 2 ? '1' : ''), 't_analyzer_technique', 'analyzerTechnique_id', 'analyzerTechnique_desc', 'analyzerTechnique_status', ' ', 'ref_id', 'analyzerTechnique_type', technique_type);
        $('#mac_analyzerTechnique_id').val(analyzerTechnique_id).prop('disabled', (mac_load_type > 2));
        if (mac_load_type <= 2 && analyzerTechnique_id == '')
            $('#form_mac_2_1').bootstrapValidator('revalidateField', 'mac_analyzerTechnique_id');
    }
    
    function f_mac_cert_usepa(certIssuer_id) {
        certIssuer_id = typeof certIssuer_id !== 'undefined' ? certIssuer_id : '';
        $('#form_mac_2_4').bootstrapValidator('resetField', 'mac_certificate_dateExpired', true);
        $('#form_mac_2_4').bootstrapValidator('resetField', 'mac_certBasic_id[]', true);
        $('#mac_certificate_dateExpired').prop('disabled', certIssuer_id == '' || certIssuer_id == '3');
        $("input[name='mac_certBasic_id[]']").prop('disabled', certIssuer_id == '' || certIssuer_id == '3');
    }
        
    function f_load_consultant_cems(load_type, wfGroup_id, consAll_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (mac_1st_load) {          
                var source_activity = f_get_general_info_multiple('t_source_activity', {sourceActivity_status:'1'}, {}, '', 'sourceActivity_id');
                $.each(source_activity, function(u){
                    var html = '<div class="checkbox"><label>';
                    html += '<input type="checkbox" class="checkbox" name="mac_sourceActivity_id[]" value="'+source_activity[u].sourceActivity_id+'" >'; //onclick="f_mac_refresh_inputParameter();"
                    html += '<span>'+source_activity[u].sourceActivity_desc+'</span>';
                    html += '</label></div>';
                    $('#mac_div_sourceActivity').append(html);
                });                                
                var bootstrapValidator = $("#form_mac_2_6").data('bootstrapValidator');
                bootstrapValidator.addField('mac_sourceActivity_id[]', {validators:{choice:{min:1,message:'At least 1 Source of Activity required'}}});
                // ---------------- \\
                var certificate_basic = f_get_general_info_multiple('t_certificate_basic', {certBasic_status:'1'}, {}, '', 'certBasic_id');
                $.each(certificate_basic, function(u){
                    var html = '<div class="checkbox"><label>';
                    html += '<input type="checkbox" class="checkbox" name="mac_certBasic_id[]" value="'+certificate_basic[u].certBasic_id+'">';
                    html += '<span>'+certificate_basic[u].certBasic_desc+'</span>';
                    html += '</label></div>';
                    $('#mac_div_certBasic_id').append(html);
                });                                
                var bootstrapValidator = $("#form_mac_2_4").data('bootstrapValidator');
                bootstrapValidator.addField('mac_certBasic_id[]', {validators:{choice:{min:1,message:'At least 1 Basic of Certification required'}}});
                bootstrapValidator.addField('mac_certBasic_id[]', {
                    validators:{
                        callback: {
                            message: 'Basic of Certification must have EN-15267-3',
                            callback: function (value, validator, $field) { return $("input[name='mac_certBasic_id[]'][value=3]").is(':checked'); }
                        }
                    }
                });
                // ---------------- \\
                get_option('mac_cat_documentName_id', '1', 'document_name', 'documentName_id', 'documentName_desc', 'documentName_status', ' ', 'ref_id', 'documentName_type', 'analyz_man');           
                get_option('mac_certIssuer_id', '1', 't_certificate_issuer', 'certIssuer_id', 'certIssuer_desc', 'certIssuer_status', ' ', 'ref_id');           
                get_option('mac_consProject_source', '1', 't_source_activity', 'sourceActivity_id', 'sourceActivity_desc', 'sourceActivity_status', ' ', 'ref_id');           
                get_option('mac_analyzerTechnique_id', '1', 't_analyzer_technique', 'analyzerTechnique_id', 'analyzerTechnique_desc', 'analyzerTechnique_status', '', 'ref_id');            
                mac_1st_load = false;
            }
            if (load_type == 1) {            
                var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wfGroup_id, 'wfGroup_isFirstTime');        
                if (isFirstTime == '1') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', 'Please update Consultant Information as first-time login user in order to perform CEMS Analyzer registration');  
                    f_menu_redirect(7,0,0);
                    return false;
                }
            }
            $('#mac_analyzerTechnique_id').val([]).trigger('change');
            $('#form_mac,#form_mac_1,#form_mac_2_1,#form_mac_2_2,#form_mac_2_3,#form_mac_2_4,#form_mac_2_6,#form_mac_2_5,#form_mac_3,#form_mac_5,#form_mac_6').trigger('reset');
            $('#form_mac_2_1').bootstrapValidator('resetForm', true);
            $('#form_mac_2_2').bootstrapValidator('resetForm', true);
            $('#form_mac_2_3').bootstrapValidator('resetForm', true);
            $('#form_mac_2_4').bootstrapValidator('resetForm', true);
            $('#form_mac_2_5').bootstrapValidator('resetForm', true);
            $('#form_mac_2_6').bootstrapValidator('resetForm', true);
            $('#form_mac_3').bootstrapValidator('resetForm', true);
            $('#form_mac_5').bootstrapValidator('resetForm', true);
            $('#form_mac_6').bootstrapValidator('resetForm', true);
            $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_analyzerTechnique_id[]', true); 
            $('#mac_load_type').val(load_type);
            $('#mac_wfGroup_id').val(wfGroup_id);
            $('#mac_consAll_id').val(consAll_id);
            mac_otable = otable;
            mac_load_type = load_type;
            $('#form_mac,#form_mac_1,#form_mac_2_1,#form_mac_2_2,#form_mac_2_3,#form_mac_2_4,#form_mac_2_6,#form_mac_2_5,#form_mac_3,#form_mac_5,#form_mac_6').find('input, textarea, select').prop('disabled',false);
            $('.mac_hideView').show();
            $('.mac_disView, #mac_dis_outsource, #mac_consParam_reference, #mac_consParam_method').prop('disabled', true);
            $('#mac_alert_box, .mac_checkView, .mac_div_paramRange, #mac_lbl_catalogue, #mac_star_document_name').hide();
            $('#mac_snote_wfTask_remark').summernote('enable');
            $("input[name='mac_declare_1'], input[name='mac_declare_2']").prop('checked', false);
            $('#mac_btn_add_range').prop('disabled', false);
            for (var i=1; i<=5; i++) {
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_from_'+i, false);
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParamRange_to_'+i, false);
            }
            $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_consParam_reference', false)
                .bootstrapValidator('enableFieldValidators', 'mac_consParam_method', false);
            f_mac_cert_usepa();
            // ---------------- \\
            if (mac_load_type == 1) {            
                if (wfGroup_id == '') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                if (!f_submit_normal('create_consultant', {wfGroup_id:wfGroup_id, wfTaskType_id:'1', wfFlow_id:'1', consAll_type:'1'}, 'p_registration', '', errMsg_default))   return false;
                $('#mac_consAll_id').val(result_submit);
                if (mac_otable == 'cca')
                    f_table_cca ();
            } 
            // --- extract details --- //
            var status = load_type <= 2 ? '1' : '';            
            get_option('mac_inputParam_id', status, 't_input_parameter', 'inputParam_id', 'inputParam_desc', 'inputParam_status', ' ', 'ref_id');
            var consultant_cems = f_get_general_info('vw_consultant_cems_details', {consAll_id:$('#mac_consAll_id').val()}, 'mac');  
            if ((consultant_cems.wfTask_status == '22' && consultant_cems.consCems_status == '22') || (consultant_cems.wfTask_status == '23' && consultant_cems.consCems_status == '23')) {
                var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:consultant_cems.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
                $('#mac_alert_box').show();
                $('#mac_alert_message').html(previous_task[0].wfTask_remark);
            }
            $("input[name='mac_consCems_probeEnabled']").prop('checked', (consultant_cems.consCems_probeEnabled=='1'));
            f_switch('form_mac_2_1', 'mac_consCems_probeEnabled', 'mac_consCems_probeType', 'mac_consCems_probeLength');
            $("input[name='mac_consCems_samplingEnabled']").prop('checked', (consultant_cems.consCems_samplingEnabled=='1'));
            f_switch('form_mac_2_1', 'mac_consCems_samplingEnabled', 'mac_consCems_samplingLine');
            if (consultant_cems.consCems_isInstall == '1')
                $("input[name='mac_consultant_type[]'][value=1]").prop('checked', true);
            if (consultant_cems.consCems_isMaintain == '1')
                $("input[name='mac_consultant_type[]'][value=2]").prop('checked', true);
            $('#form_mac_3').bootstrapValidator('enableFieldValidators', 'mac_consPers_document', false);            
            $('#form_mac_3').bootstrapValidator('enableFieldValidators', 'mac_consPers_document_name', false);
            // ---------------- \\
            var consultant_type = f_get_general_info_multiple('t_consultant_type', {consAll_id:$('#mac_consAll_id').val()});
            $.each(consultant_type, function(u){
                $("input[name='mac_consType_type[]'][value=" + consultant_type[u].consType_type + "]").prop('checked', true);
            });
            var consultant_source = f_get_general_info_multiple('t_consultant_source', {consAll_id:$('#mac_consAll_id').val()});
            $.each(consultant_source, function(u){
                $("input[name='mac_sourceActivity_id[]'][value=" + consultant_source[u].sourceActivity_id + "]").prop('checked', true);
            });
            //f_mac_refresh_inputParameter();
            //f_mac_method_detection(consultant_cems.analyzerTechnique_id);
            // ---------------- \\
            $("input[name='mac_consCems_compStatus'][value=" + consultant_cems.consCems_compStatus + "]").prop('checked', true);
            $('#mac_dis_outsource').attr('disabled', $('#mac_dis_type').val() == '2' ? false : true);
            // ---------------- \\
            $('[name="mac_snote_wfTask_remark"]').summernote('code', consultant_cems.consAll_remark);
            $('#form_mac_6').bootstrapValidator('resetField', 'mac_snote_wfTask_remark');
            // ---------------- \\
            data_mac_docSupport = f_get_general_info_multiple('dt_consultant_docSupport', {consultant_id:consultant_cems.consultant_id, documentName_type:'consultant'}, '', '', 'consultantDoc_id');
            f_dataTable_draw(mac_otable_docSupport, data_mac_docSupport, 'datatable_mac_docSupport', 4);
            data_mac_catDoc = f_get_general_info_multiple('dt_consultant_doc', {consAll_id:$('#mac_consAll_id').val(), documentName_type:'analyz_man'}, '', '', 'consDoc_id');
            f_dataTable_draw(mac_otable_catDoc, data_mac_catDoc, 'datatable_mac_catDoc', 4);
            data_mac_cert = f_get_general_info_multiple('dt_certificate', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'certificate_id');
            f_dataTable_draw(mac_otable_cert, data_mac_cert, 'datatable_mac_cert', 6);
            data_mac_consParam = f_get_general_info_multiple('dt_consultant_parameter', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'consParam_id');
            f_dataTable_draw(mac_otable_consParam, data_mac_consParam, 'datatable_mac_consParam', 6);
            data_mac_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#mac_consAll_id').val()}, '', '', 'consPers_id');
            f_dataTable_draw(mac_otable_personnel, data_mac_personnel, 'datatable_mac_personnel', 8);
            data_mac_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#mac_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
            f_dataTable_draw(mac_otable_project, data_mac_project, 'datatable_mac_project', 9);
            // ---------------- \\
            if (mac_load_type >= 3) {
                mac_total_section = [];
                $('#form_mac,#form_mac_1,#form_mac_2_1,#form_mac_2_2,#form_mac_2_3,#form_mac_2_4,#form_mac_2_6,#form_mac_2_5,#form_mac_3,#form_mac_5,#form_mac_6').find('input, textarea, select').prop('disabled',true);
                $('#mac_snote_wfTask_remark').summernote('disable');
                $("input[name='mac_declare_1'], input[name='mac_declare_2']").prop('checked', true);
                $('.mac_hideView').hide();
                $('#mac_lbl_catalogue').show();
                $('#form_mac_2_3').bootstrapValidator('enableFieldValidators', 'mac_analyzerTechnique_id[]', false); 
                if (mac_load_type >= 4) {
                    $('.mac_form_check').prop('disabled', false);
                    $('.mac_checkView, #mac_btn_save').show();
                    var checklist_task = f_get_general_info_multiple('t_checklist_task', {wfTask_id:$('#mac_wfTask_id').val(), checklistTask_status:'1'});
                    $.each(checklist_task, function(u){
                        $('#mac_check_remark_'+checklist_task[u].checklist_id).val(checklist_task[u].checklistTask_remark);
                        if (checklist_task[u].checklistTask_result == '1')
                            $("input[name='mac_check_pass_"+checklist_task[u].checklist_id+"']").prop('checked', true);
                        mac_total_section[u] = checklist_task[u].checklist_id;
                    });    
                }
            }    
            $('#modal_consultant_cems').modal('show');            
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>