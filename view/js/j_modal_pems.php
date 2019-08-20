<script type="text/javascript">
    
    let mpe_otable;
    let mpe_load_type;
    let mpe_1st_load = true;
    let mpe_otable_parameter;
    let data_mpe_parameter;
    let mpe_otable_written;
    let data_mpe_written;
    let mpe_otable_document;
    let data_mpe_document;
    let mpe_otable_inputReading;
    let data_mpe_inputReading;
    let mpe_otable_docNormalize;
    let data_mpe_docNormalize;
    let mpe_otable_personnel;
    let data_mpe_personnel;
    let mpe_interval;
    let mpe_interval_cnt = 0;
    let mpe_total_section = [];
    let mpe_check_1, mpe_check_2, mpe_check_3, mpe_check_4;
    
    $(document).ready(function () {
        
        $('#mpe_btn_next').on('click', function () {
            const stepNum = $('#mpe_wizard').wizard('selectedItem');
            if (stepNum.step === 4)
                $('#mpe_btn_next').prop('disabled', true);
        });
        
        $('#mpe_btn_prev').on('click', function () {
            const stepNum = $('#mpe_wizard').wizard('selectedItem');
            if (stepNum.step === 5)
                $('#mpe_btn_next').prop('disabled', false);
        });
        
        $('#form_mpe_2_1').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                mpe_indAll_installType : {
                    validators: {
                        notEmpty: {
                            message: 'Type of Installation is required'
                        }
                    }
                },
                'mpe_indReason_id[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Reason of PEMS Installation required'
                        }                        
                    }
                },
                mpe_indReason_other : {
                    validators: {
                        callback: {
                            message: 'Other Reason is required',
                            callback: function (value) {
                                const check = $('#form_mpe_2_1').find('[name="mpe_indReason_id[]"][value=4]').is(':checked');
                                return (check === false) ? true : (value !== '');
                            }
                        },
                        stringLength : {
                            max : 100,
                            message : 'Other Reason must be not more than 100 characters long'
                        }
                    }
                },
                mpe_sourceActivity_id : {
                    validators: {
                        notEmpty: {
                            message: 'Source of Activity is required'
                        }
                    }
                },
                mpe_sourceCapacity_id : {
                    validators: {
                        notEmpty: {
                            message: 'Source is required'
                        }
                    }
                },
                mpe_fuelType_id : {
                    validators: {
                        notEmpty: {
                            message: 'Type of Fuel is required'
                        }
                    }
                },
                mpe_indAll_fuelQuantity : {
                    validators: {
                        numeric: {
                            message: 'Fuel Quantity is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value) {
                                if ($('#mpe_sourceActivity_id').val() === '2') {
                                    return {
                                        valid: value!=='',
                                        message: 'Fuel Quantity is required for source Heat and Power Generation'
                                    }
                                } else {
                                    return {
                                        valid: (value==='' || (value!=='' && parseFloat(value) > 0)),
                                        message: 'Fuel Quantity must be greater than 0'
                                    }
                                }
                            }
                        }
                    }
                },
                mpe_metalType_id : {
                    validators: {
                        notEmpty: {
                            message: 'Type of Metal is required'
                        }
                    }
                },
                mpe_indAll_sourceCapacity : {
                    validators: {
                        numeric: {
                            message: 'Source Capacity is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            callback: function (value) {
                                if ($('#mpe_sourceActivity_id').val() === '2') {
                                    return {
                                        valid: value!=='',
                                        message: 'Source Capacity is required for source Heat and Power Generation'
                                    }
                                } else {
                                    return {
                                        valid: (value==='' || (value!=='' && parseFloat(value) > 0)),
                                        message: 'Source Capacity must be greater than 0'
                                    }
                                }
                            }
                        }
                    }
                },
                mpe_indAll_stackNo : {
                    validators: {
                        notEmpty: {
                            message: 'Stack ID is required'
                        },
                        stringLength : {
                            max : 15,
                            message : 'Stack ID must be not more than 15 characters long'
                        }
                    }
                },
                mpe_indAll_stackHeight : {
                    validators: {
                        notEmpty: {
                            message: 'Stack Height is required'
                        },
                        numeric: {
                            message: 'Stack Height is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Stack Height must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mpe_indAll_stackDiameter : {
                    validators: {
                        notEmpty: {
                            message: 'Stack Diameter is required'
                        },
                        numeric: {
                            message: 'Stack Diameter is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Stack Diameter must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mpe_indAll_stackLongitude : {
                    validators: {
                        notEmpty: {
                            message: 'Stack Longitude is required'
                        },
                        numeric: {
                            message: 'Stack Longitude is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        between: {
                            min: 99.640656,
                            max: 119.268526,
                            message: 'Stack Longitude must be between 99.640656 and 119.268526'
                        }
                    }
                },
                mpe_indAll_stackLatitude : {
                    validators: {
                        notEmpty: {
                            message: 'Stack Latitude is required'
                        },
                        numeric: {
                            message: 'Stack Latitude is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        between: {
                            min: 0.860575,
                            max: 7.362652,
                            message: 'Stack Latitude must be between 0.860575 and 7.362652 (Malaysia Region)'
                        }
                    }
                },
                mpe_indAll_gasTemperature : {
                    validators: {
                        notEmpty: {
                            message: 'Temperature is required'
                        },
                        numeric: {
                            message: 'Temperature is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Temperature must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mpe_indAll_airFlowRate : {
                    validators: {
                        notEmpty: {
                            message: 'Air Flow Rate is required'
                        },
                        numeric: {
                            message: 'Air Flow Rate is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Air Flow Rate must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mpe_indAll_stackVelocity : {
                    validators: {
                        notEmpty: {
                            message: 'Stack Velocity is required'
                        },
                        numeric: {
                            message: 'Stack Velocity is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Stack Velocity must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mpe_indAll_moistureContect : {
                    validators: {
                        notEmpty: {
                            message: 'Moisture Content is required'
                        },
                        numeric: {
                            message: 'Moisture Content is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Moisture Content must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mpe_indAll_pressure : {
                    validators: {
                        notEmpty: {
                            message: 'Pressure is required'
                        },
                        numeric: {
                            message: 'Pressure is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Pressure must be greater than 0',
                            callback: function (value) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                }
            }
        });  
        
        let datatable_mpe_parameter = undefined;
        mpe_otable_parameter = $('#datatable_mpe_parameter').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mpe_parameter) {
                    datatable_mpe_parameter = new ResponsiveDatatablesHelper($('#datatable_mpe_parameter'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpe_parameter.createExpandIcon(nRow);
                const info = mpe_otable_parameter.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1)); 
            },
            "drawCallback": function () {
                datatable_mpe_parameter.respond();
                const api = this.api();
                const visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(let j=0;j<visibleRows.length;j++){
                        let bootstrapValidator = $("#form_mpe_2_1").data('bootstrapValidator');
                        bootstrapValidator.addField('mpe_indParam_concentration_'+visibleRows[j].indParam_id, {validators:{notEmpty:{message:'Concentration required'},numeric:{message:'Concentration not a valid number',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'inputParam_desc', sClass: 'text-center'},
                    {mData: 'pub_referenceValue', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            let label = '';
                            if (row.pub_referenceGas != null && data != null)
                                label = row.pub_referenceGas + ' : ' + data + '%';
                            return label;
                        }
                    },
                    {mData: 'indParam_limitValue', sClass: 'text-right',
                        mRender: function (data, type, row) {
                            return (row.inputParam_id>8?'-':data + ' ' + row.inputParam_unit); 
                        }
                    },
                    {mData: null, sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            return '<div class="form-group margin-bottom-0"><div class="col-md-12"><div class="input-group">' +
                                '<input type="text" class="form-control" name="mpe_indParam_concentration_'+row.indParam_id+'" id="mpe_indParam_concentration_'+row.indParam_id+'" value="'+(row.indParam_concentration!=null?row.indParam_concentration:'')+'"/>' +
                                '<span class="input-group-addon font-xs">' + row.inputParam_unit + '</span>' +
                                '</div></div></div>';
                        }
                    }
                ]
        });
        
        $('#form_mpe_2_1').find('[name="mpe_indReason_id[]"][value=4]').on('click', function () {
            $('#mpe_indReason_other').val('');
            $('#form_mpe_2_1').bootstrapValidator('enableFieldValidators', 'mpe_indReason_other', $(this).is(':checked'));
            $('#form_mpe_2_1').bootstrapValidator('revalidateField', 'mpe_indReason_other');
            $(this).is(':checked') ? $('.mpe_disReason').prop('disabled', false) : $('.mpe_disReason').prop('disabled', true);
        });
            
        $('#mpe_sourceActivity_id').on('change', function () {
            $('#form_mpe_2_1').data('bootstrapValidator').resetField('mpe_sourceCapacity_id');
            f_mpe_set_sourceCapacity('', $(this).val()); 
            $('#form_mpe_2_1').data('bootstrapValidator').resetField('mpe_metalType_id');
            f_mpe_set_metalType ('',  $(this).val());
            $('#form_mpe_2_1').data('bootstrapValidator').resetField('mpe_fuelType_id');
            $('#mpe_fuelType_id').prop('disabled', true).val('');
            f_mpe_insert_parameter ();  
        });
        
        $('#mpe_sourceCapacity_id').on('change', function () {
            $('#form_mpe_2_1').data('bootstrapValidator').resetField('mpe_fuelType_id');
            if ($(this).val() === '1' || $(this).val() === '2')
                $('#mpe_fuelType_id').prop('disabled', false).val('');
            else{                
                $('#mpe_fuelType_id').prop('disabled', true).val('');
            }
            $('#mpe_fuelType_id option[value="1"]').attr("disabled", $(this).val() !== '1');
            $('#mpe_fuelType_id option[value="2"]').attr("disabled", $(this).val() !== '2');
            f_mpe_insert_parameter (); 
        });
        
        $('#mpe_fuelType_id').on('change', function () {
            if ($('#mpe_sourceCapacity_id').val() === '1' || $('#mpe_sourceCapacity_id').val() === '2')
                f_mpe_insert_parameter (); 
        });
                
        $('#form_mpe_2_2').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mpe_indWritten_equipmentName : {
                    validators: {
                        notEmpty: {
                            message: 'Equipment Name is required'
                        },
                        stringLength : {
                            max : 100,
                            message : 'Equipment Name must be not more than 100 characters long'
                        }
                    }
                },
                mpe_indWritten_referenceNo : {
                    validators: {
                        notEmpty: {
                            message: 'Reference No. is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Reference No. must be not more than 30 characters long'
                        }
                    }
                },
                mpe_written_type : {
                    validators: {
                        notEmpty: {
                            message: 'Attachment Type is required'
                        }
                    }
                },
                mpe_indWritten_dateReference : {
                    validators: {
                        notEmpty: {
                            message: 'Reference Date is required'
                        }
                    }
                },
                mpe_file_written_name : {
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
                mpe_file_written : {
                    validators: {
                        notEmpty: {
                            message: 'Attachment File is required'
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
        
        $('#mpe_indWritten_dateReference').datepicker({
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
                    let clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            },
            onSelect: function() {
                $('#form_mpe_2_2').bootstrapValidator('revalidateField', 'mpe_indWritten_dateReference');
            }
        });

        let datatable_mpe_written = undefined;
        mpe_otable_written = $('#datatable_mpe_written').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mpe_written) {
                    datatable_mpe_written = new ResponsiveDatatablesHelper($('#datatable_mpe_written'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpe_written.createExpandIcon(nRow);
                const info = mpe_otable_written.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function () {
                datatable_mpe_written.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'indWritten_equipmentName'},
                    {mData: 'documentName_desc'},
                    {mData: 'indWritten_referenceNo'},
                    {mData: 'indWritten_dateReference'},
                    {mData: 'document_name'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            let label = '';
                            if (row.document_id != null)
                                label += '<a type="button" class="btn btn-success btn-xs" title="Download Written Approval" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            label += ' <button type="button" class="btn btn-danger btn-xs mpe_hideView" title="Delete" onclick="f_mpe_delete_written ('+row.indWritten_id+');"><i class="fa fa-trash-o"></i></button>';
                            return label;
                        }
                    }
                ]
        });
        
        $('#mpe_btn_add_written').on('click', function () {
            let bootstrapValidator = $("#form_mpe_2_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    let formData = new FormData($('#form_mpe_2_2')[0]);
                    formData.append('funct', 'save_industrial_written_pems');
                    formData.append('mpe_indAll_id', $('#mpe_indAll_id').val());
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
                            return $.ajaxSettings.xhr();
                        },
                        success: function(resp) {
                            if (resp.success === true){
                                f_notify(1, 'Success', 'Written Approval successfully added.');
                                $('#form_mpe_2_2').trigger('reset');
                                $('#form_mpe_2_2').bootstrapValidator('resetForm', true);
                                data_mpe_written = f_get_general_info_multiple('dt_written_approval', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'indWritten_id');
                                f_dataTable_draw(mpe_otable_written, data_mpe_written, 'datatable_mpe_written', 6);
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
        
        $('#form_mpe_2_3').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mpe_document_type : {
                    validators: {
                        notEmpty: {
                            message: 'Attachment Type is required'
                        }
                    }
                },
                mpe_indDoc_others : {
                    validators: {
                        notEmpty: {
                            message: 'Other Type is required'
                        },
                        stringLength : {
                            max : 150,
                            message : 'Other Type must be not more than 150 characters long'
                        }
                    }
                },
                mpe_file_document_name : {
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
                mpe_file_document : {
                    validators: {
                        notEmpty: {
                            message: 'Attachment File is required'
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
        
        $('#mpe_document_type').on('change', function () {
            $('#mpe_indDoc_others').val('');
            if($(this).val() === '18') {
                $('#mpe_div_doc_other').show(); 
                $('#form_mpe_2_3').bootstrapValidator('enableFieldValidators', 'mpe_indDoc_others', true);
            } else {
                $('#mpe_div_doc_other').hide();
                $('#form_mpe_2_3').bootstrapValidator('enableFieldValidators', 'mpe_indDoc_others', false);
            }
        });

        let datatable_mpe_document = undefined;
        mpe_otable_document = $('#datatable_mpe_document').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mpe_document) {
                    datatable_mpe_document = new ResponsiveDatatablesHelper($('#datatable_mpe_document'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpe_document.createExpandIcon(nRow);
                const info = mpe_otable_document.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function () {
                datatable_mpe_document.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'documentName_desc'},
                    {mData: 'document_name'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            let label = '';
                            if (row.document_id != null)
                                label += '<a type="button" class="btn btn-success btn-xs" title="Download Document" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            label += ' <button type="button" class="btn btn-danger btn-xs mpe_hideView" title="Delete" onclick="f_mpe_delete_document ('+row.indDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return label;
                        }
                    }
                ]
        });
        
        $('#mpe_btn_add_document').on('click', function () {
            let bootstrapValidator = $("#form_mpe_2_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    let formData = new FormData($('#form_mpe_2_3')[0]);
                    formData.append('funct', 'save_industrial_document_pems');
                    formData.append('mpe_indAll_id', $('#mpe_indAll_id').val());
                    formData.append('mpe_indDoc_others', $('#mpe_indDoc_others').val());
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
                            return $.ajaxSettings.xhr();
                        },
                        success: function(resp) {
                            if (resp.success === true){
                                f_notify(1, 'Success', 'Document successfully added.');
                                $('#form_mpe_2_3').trigger('reset');
                                $('#form_mpe_2_3').bootstrapValidator('resetForm', true);
                                $('#mpe_div_doc_other').hide();
                                $('#form_mpe_2_3').bootstrapValidator('enableFieldValidators', 'mpe_indDoc_others', false);
                                data_mpe_document = f_get_general_info_multiple('dt_industrial_document', {indAll_id:$('#mpe_indAll_id').val(), documentName_id:'(5,6,7,8,18)'}, '', '', 'indDoc_id');
                                f_dataTable_draw(mpe_otable_document, data_mpe_document, 'datatable_mpe_document', 4);
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
        
        $('#form_mpe_3_1').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mpe_consultant_id : {
                    validators: {
                        notEmpty: {
                            message: 'PEMS Consultant is required'
                        }
                    }
                },
                mpe_consAll_id : {
                    validators: {
                        notEmpty: {
                            message: 'Software Modelling is required'
                        }
                    }
                }
            }
        });
        
        $('#form_mpe_3_3').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
//                mpe_pemsInput_name : {
//                    validators: {
//                        notEmpty: {
//                            message: 'Input is required'
//                        },
//                        stringLength : {
//                            max : 30,
//                            message : 'Input must be not more than 30 characters long'
//                        }
//                    }
//                },
//                mpe_pemsInput_desc : {
//                    validators: {
//                        notEmpty: {
//                            message: 'Description is required'
//                        },
//                        stringLength : {
//                            max : 150,
//                            message : 'Description must be not more than 150 characters long'
//                        }
//                    }
//                },
                mpe_pemsReading_desc : {
                    validators: {
                        notEmpty: {
                            message: 'Description is required'
                        },
                        stringLength : {
                            max : 150,
                            message : 'Description must be not more than 150 characters long'
                        }
                    }
                },
                mpe_pemsReading_idd : {
                    validators: {
                        notEmpty: {
                            message: 'ID is required'
                        },
                        stringLength : {
                            max : 50,
                            message : 'ID must be not more than 50 characters long'
                        }
                    }
                },
                mpe_pemsReading_unit : {
                    validators: {
                        notEmpty: {
                            message: 'Unit is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Unit must be not more than 30 characters long'
                        }
                    }
                },
                mpe_pemsReading_min : {
                    validators: {
                        notEmpty: {
                            message: 'Min is required'
                        },
                        numeric: {
                            message: 'Min is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }
                    }
                },
                mpe_pemsReading_max : {
                    validators: {
                        notEmpty: {
                            message: 'Max is required'
                        },
                        numeric: {
                            message: 'Max is not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        }
                    }
                }
            }
        });
        
        $('#mpe_btn_add_inputReading').on('click', function () {
            let bootstrapValidator = $("#form_mpe_3_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){  
                    $('#mpe_funct').val('save_pems_input_reading');
                    if (f_submit_forms('form_mpe,#form_mpe_3_3', 'p_registration', 'PEMS Input Reading successfully added.')) {
                        $('#form_mpe_3_3').bootstrapValidator('resetForm', true);        
//                        f_mpe_table_inputReading();
                        data_mpe_inputReading = f_get_general_info_multiple('t_industrial_pems_reading', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'pemsReading_id');
                        f_dataTable_draw(mpe_otable_inputReading, data_mpe_inputReading, 'datatable_mpe_inputReading', 7);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        });
        
        $('#form_mpe_3_4').bootstrapValidator({
            excluded: ':disabled',
            fields: {
                mpe_indAll_qaMethod : {
                    validators: {
                        notEmpty: {
                            message: 'Method is required'
                        }
                    }
                },
                'mpe_q_indQuarter_no[]' : {
                    validators: {
                        choice : {
                            min : 3,
                            max : 3,
                            message : '3 Quarter required'
                        }  
                    }
                },
                'mpe_y_indQuarter_no' : {
                    validators: {
                        notEmpty : {
                            message : 'Quarter is required'
                        }  
                    }
                }
            }
        });
        
        $('#form_mpe_3_4').find('[name="mpe_indAll_qaFreqQuarterly"]').on('click', function () {
            if ($(this).is(':checked')) {
                $('#form_mpe_3_4').bootstrapValidator('enableFieldValidators', 'mpe_q_indQuarter_no[]', true);
                $('.mpe_q_quarter').show();
                $('#form_mpe_3_4').bootstrapValidator('resetField', 'mpe_q_indQuarter_no[]', true);
                f_mpe_set_quarterRATA();
            } else {
                $('#form_mpe_3_4').bootstrapValidator('resetField', 'mpe_q_indQuarter_no[]', true);
                $('#form_mpe_3_4').bootstrapValidator('enableFieldValidators', 'mpe_q_indQuarter_no[]', false);
                $('.mpe_q_quarter').hide();
            }
        });
        
        $('#form_mpe_3_4').find('[name="mpe_indAll_qaFreqYearly"]').on('click', function () {             
            if ($(this).is(':checked')) {    
                $('#form_mpe_3_4').bootstrapValidator('enableFieldValidators', 'mpe_y_indQuarter_no', true);
                $('.mpe_q_year').show(); 
                $('#form_mpe_3_4').bootstrapValidator('resetField', 'mpe_y_indQuarter_no', true);
                f_mpe_set_yearRATA();      
            } else {
                $('#form_mpe_3_4').bootstrapValidator('resetField', 'mpe_y_indQuarter_no', true);
                $('#form_mpe_3_4').bootstrapValidator('enableFieldValidators', 'mpe_y_indQuarter_no', false);
                $('.mpe_q_year').hide();
            }
        });
        
        $('#form_mpe_3_4').find('[name="mpe_q_indQuarter_no[]"]').on('click', function () { 
            f_mpe_set_yearRATA();
        });
        
        $('#form_mpe_3_4').find('[name="mpe_y_indQuarter_no"]').on('click', function () { 
            f_mpe_set_quarterRATA();
        });
        
        $('#mpe_consultant_id').on('change', function () {
            $('#form_mpe_3_1').data('bootstrapValidator').resetField('mpe_consAll_id');
            f_mpe_set_consAll('', $(this).val()); 
        });
        
        $('#mpe_consAll_id').on('change', function () {
            f_mpe_set_link_consAll($(this).val()); 
        });
        
        $('#form_mpe_3_2').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mpe_docNormalize_type : {
                    validators: {
                        notEmpty: {
                            message: 'Attachment Type is required'
                        }
                    }
                },
                mpe_file_docNormalize_name : {
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
                mpe_file_docNormalize : {
                    validators: {
                        notEmpty: {
                            message: 'Attachment File is required'
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

        let datatable_mpe_docNormalize = undefined;
        mpe_otable_docNormalize = $('#datatable_mpe_docNormalize').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mpe_docNormalize) {
                    datatable_mpe_docNormalize = new ResponsiveDatatablesHelper($('#datatable_mpe_docNormalize'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpe_docNormalize.createExpandIcon(nRow);
                const info = mpe_otable_docNormalize.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function () {
                datatable_mpe_docNormalize.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'documentName_desc'},
                    {mData: 'document_name'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            let label = '';
                            if (row.document_id != null)
                                label += '<a type="button" class="btn btn-success btn-xs" title="Download Document" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            label += ' <button type="button" class="btn btn-danger btn-xs mpe_hideView" title="Delete" onclick="f_mpe_delete_docNormalize ('+row.indDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return label;
                        }
                    }
                ]
        });
        
        $('#mpe_btn_add_docNormalize').on('click', function () {
            let bootstrapValidator = $("#form_mpe_3_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    let formData = new FormData($('#form_mpe_3_2')[0]);
                    formData.append('funct', 'save_industrial_docNormalize_pems');
                    formData.append('mpe_indAll_id', $('#mpe_indAll_id').val());
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
                            return $.ajaxSettings.xhr();
                        },
                        success: function(resp) {
                            if (resp.success === true){
                                f_notify(1, 'Success', 'Document successfully added.');
                                $('#form_mpe_3_2').trigger('reset');
                                $('#form_mpe_3_2').bootstrapValidator('resetForm', true);
                                data_mpe_docNormalize = f_get_general_info_multiple('dt_industrial_document', {indAll_id:$('#mpe_indAll_id').val(), documentName_id:'(15,16,26)'}, '', '', 'indDoc_id');
                                f_dataTable_draw(mpe_otable_docNormalize, data_mpe_docNormalize, 'datatable_mpe_docNormalize', 4);
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

        let datatable_mpe_inputReading = undefined;
        mpe_otable_inputReading = $('#datatable_mpe_inputReading').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mpe_inputReading) {
                    datatable_mpe_inputReading = new ResponsiveDatatablesHelper($('#datatable_mpe_inputReading'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpe_inputReading.createExpandIcon(nRow);
                const info = mpe_otable_inputReading.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function () {
                datatable_mpe_inputReading.respond();
//                var api = this.api();
//                var visibleRows=api.rows().data();
//                if(visibleRows.length >= 1){
//                    for(var j=0;j<visibleRows.length;j++){
//                        var bootstrapValidator = $("#form_mpe_3_4").data('bootstrapValidator');
//                        bootstrapValidator.addField('mpe_low_min_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_low_max_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_low_weight_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_normal_min_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_normal_max_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_normal_weight_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_high_min_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_high_max_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                        bootstrapValidator.addField('mpe_high_weight_'+visibleRows[j].pemsInput_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}, callback: {message: 'Must > 0',callback: function (value, validator, $field){return (parseFloat(value) > 0);}}}});
//                    }
//                }
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'pemsReading_desc'},
                    {mData: 'pemsReading_idd'},
                    {mData: 'pemsReading_unit'},
                    {mData: 'pemsReading_min', sClass: 'text-right', mRender: function (data) { return formattedNumber(data,3) }},
                    {mData: 'pemsReading_max', sClass: 'text-right', mRender: function (data) { return formattedNumber(data,3) }},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger btn-xs mpe_hideView" title="Delete" onclick="f_mpe_delete_inputReading('+row.pemsReading_id+')"><i class="fa fa-minus"></i></button>';
                        }
                    }
//                    {mData: 'pemsInput_name'},
//                    {mData: 'pemsInput_desc'},
//                    {mData: 'low_min', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:50px" name="mpe_low_min_'+row.pemsInput_id+'" id="mpe_low_min_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'low_max', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:50px" name="mpe_low_max_'+row.pemsInput_id+'" id="mpe_low_max_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'low_weight', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:60px" name="mpe_low_weight_'+row.pemsInput_id+'" id="mpe_low_weight_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'normal_min', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:50px" name="mpe_normal_min_'+row.pemsInput_id+'" id="mpe_normal_min_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'normal_max', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:50px" name="mpe_normal_max_'+row.pemsInput_id+'" id="mpe_normal_max_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'normal_weight', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:60px" name="mpe_normal_weight_'+row.pemsInput_id+'" id="mpe_normal_weight_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'high_min', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:50px" name="mpe_high_min_'+row.pemsInput_id+'" id="mpe_high_min_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'high_max', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:50px" name="mpe_high_max_'+row.pemsInput_id+'" id="mpe_high_max_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: 'high_weight', sClass: 'padding-5',
//                        mRender: function (data, type, row) {
//                            $label = '<div class="form-group"><div class="col-md-12">' +
//                                '<input type="text" class="form-control" style="width:60px" name="mpe_high_weight_'+row.pemsInput_id+'" id="mpe_high_weight_'+row.pemsInput_id+'" value="'+data+'"/>' +                                
//                                '</div></div>';
//                            return $label;
//                        }
//                    },
//                    {mData: null, sClass: 'text-center',
//                        mRender: function (data, type, row) {
//                            $label = '<button type="button" class="btn btn-danger btn-xs mpe_hideView" title="Delete" onclick="f_mpe_delete_inputReading('+row.pemsInput_id+')"><i class="fa fa-minus"></i></button>';
//                            return $label;
//                        }
//                    }
                ]
        });
        
        $('#form_mpe_4').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mpe_indPers_name : {
                    validators: {
                        notEmpty: {
                            message: 'Name is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Name must be not more than 80 characters long'
                        }
                    }
                },
                mpe_indPers_icNo : {
                    validators: {
                        notEmpty: {
                            message: 'MyKad No. is required'
                        },
                        digits : {
                            message : 'MyKad No. must be digits'
                        },
                        callback: {
                            message: 'MyKad No. must be 12 digits long',
                            callback: function (value) {
                                return value.length === 12;
                            }
                        }
                    }
                },
                mpe_indPers_position : {
                    validators: {
                        notEmpty: {
                            message: 'Position is required'
                        },
                        stringLength : {
                            max : 50,
                            message : 'Position must be not more than 50 characters long'
                        }
                    }
                },
                mpe_indPers_contactNo : {
                    validators: {
                        notEmpty: {
                            message: 'Contact No. is required'
                        },
                        stringLength : {
                            max : 11,
                            message : 'Contact No. must be not more than 11 characters long'
                        },
                        digits : {
                            message : 'Contact No. must be digits'
                        }
                    }
                },
                mpe_indPers_email : {
                    validators: {
                        notEmpty: {
                            message: 'Email is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Email must be not more than 80 characters long'
                        },
                        emailAddress : {
                            message : 'Email is not valid'
                        }
                    }
                },
                mpe_indPers_qualification : {
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
                mpe_indPers_certificate : {
                    validators: {
                        notEmpty: {
                            message: 'Certificate is required'
                        },
                        stringLength : {
                            max : 255,
                            message : 'Certificate must be not more than 255 characters long'
                        }
                    }
                }
            }
        });
        
        $('#mpe_btn_add_personnel').on('click', function () {
            let bootstrapValidator = $("#form_mpe_4").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) { 
                $('#mpe_funct').val('save_industrial_personnel_pems');
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    if (f_submit_forms('form_mpe,#form_mpe_4', 'p_registration', 'PEMS Personnel successfully added.')) {
                        $('#form_mpe_4').bootstrapValidator('resetForm', true);                    
                        data_mpe_personnel = f_get_general_info_multiple('t_industrial_personnel', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'indPers_id');
                        f_dataTable_draw(mpe_otable_personnel, data_mpe_personnel, 'datatable_mpe_personnel', 9);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        });

        let datatable_mpe_personnel = undefined;
        mpe_otable_personnel = $('#datatable_mpe_personnel').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mpe_personnel) {
                    datatable_mpe_personnel = new ResponsiveDatatablesHelper($('#datatable_mpe_personnel'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpe_personnel.createExpandIcon(nRow);
                const info = mpe_otable_personnel.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function () {
                datatable_mpe_personnel.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'indPers_name'},
                    {mData: 'indPers_icNo'},
                    {mData: 'indPers_position'},
                    {mData: 'indPers_contactNo'},
                    {mData: 'indPers_email'},
                    {mData: 'indPers_qualification'},
                    {mData: 'indPers_certificate'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return '<button type="button" class="btn btn-danger btn-xs mpe_hideView" title="Delete" onclick="f_mpe_delete_personnel ('+row.indPers_id+');"><i class="fa fa-trash-o"></i></button>';
                        }
                    }
                ]
        });
        
        $('#form_mpe_5').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mpe_declare : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration is required'
                        }                        
                    }
                },
                mpe_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function() {
                                const code = $('[name="mpe_snote_wfTask_remark"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#mpe_snote_wfTask_remark').summernote({
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
                onChange: function(contents) {
                    $('#form_mpe_5').bootstrapValidator('revalidateField', 'mpe_snote_wfTask_remark');
                    $('#mpe_wfTask_remark').val(contents);
                }
            }
        });   
                
        $('#modal_pems').on('shown.bs.modal', function() {
            $('#mpe_wizard').wizard('selectedItem', { step:1 });
            $('#mpe_btn_next').prop('disabled', false); 
            if ($('#mpe_load_type').val() === '1' || $('#mpe_load_type').val() === '2') {
//                mpe_interval = window.setInterval(function(){ 
//                    if (mpe_interval_cnt === 1) {
//                        $('#mpe_funct').val('save_installation_pems');
//                        $('#mpe_wfTask_remark').val($('[name="mpe_snote_wfTask_remark"]').summernote('code'));
//                        $('#modal_waiting').on('shown.bs.modal', function(e){
//                            if (f_submit_forms('form_mpe,#form_mpe_2_1,#form_mpe_3_1,#form_mpe_5', 'p_registration', 'Data successfully saved.')) {
//                                if (mpe_otable === 'ipm')
//                                    f_table_ipm ();
//                            }
//                            $('#modal_waiting').modal('hide');
//                            $(this).unbind(e);
//                        }).modal('show');  
//                    }
//                    mpe_interval_cnt = 1;
//                }, 300000);
            }
        });     
        
        $('#modal_pems').on('hide.bs.modal', function() {
//            mpe_interval_cnt = 0;
//            clearInterval(mpe_interval);
//            mpe_interval = 0;
            $.each(data_mpe_parameter, function(u){
                let bootstrapValidator = $("#form_mpe_2_1").data('bootstrapValidator');
                bootstrapValidator.removeField('mpe_indParam_concentration_'+data_mpe_parameter[u].indParam_id);
            });
//            $.each(data_mpe_inputReading, function(u){
//                var bootstrapValidator = $("#form_mpe_3_4").data('bootstrapValidator');
//                bootstrapValidator.removeField('mpe_low_min_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_low_max_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_low_weight_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_normal_min_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_normal_max_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_normal_weight_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_high_min_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_high_max_'+data_mpe_inputReading[u].pemsInput_id);
//                bootstrapValidator.removeField('mpe_high_weight_'+data_mpe_inputReading[u].pemsInput_id);
//            });
        });  
                
        $('#mpe_btn_save').on('click', function () {         
            if ($('#mpe_load_type').val() === '4') {
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    let parameters = {};
                    parameters['wfTask_id'] = $('#mpe_wfTask_id').val();    
                    parameters['wfFlow_id'] = '5';       
                    $.each(mpe_total_section, function(value){     
                        parameters['check_remark_'+mpe_total_section[value]] = $('#mpe_check_remark_'+mpe_total_section[value]).val();
                        parameters['check_pass_'+mpe_total_section[value]] = $("input[name='mpe_check_pass_"+mpe_total_section[value]+"']").is(':checked') ? '1' : '0';
                    });
                    f_submit_normal('save_process_checking', parameters, 'p_registration', 'Process Checklist successfully saved.');
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                $('#mpe_funct').val('save_installation_pems');
                $('#mpe_wfTask_remark').val($('[name="mpe_snote_wfTask_remark"]').summernote('code'));
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_mpe,#form_mpe_2_1,#form_mpe_3_1,#form_mpe_3_4,#form_mpe_5', 'p_registration', 'Data successfully saved.')) {
                        if (mpe_otable === 'ipm')
                            f_table_ipm ();
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            }
        });        
        
        $('#mpe_btn_submit').on('click', function () {
            let bootstrapValidator = $("#form_mpe_2_1").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mpe_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }      
            if (data_mpe_written.length === 0) {
                $('#mpe_wizard').wizard('selectedItem', { step:2 });
                $('#mpe_btn_add_written').focus();
                f_notify(2, 'Error', 'Please make sure any Written Approval or Notification Status of Specified Equipment provided!');    
                return false;
            }            
            mpe_check_1 = false; mpe_check_2 = false; mpe_check_3 = false; mpe_check_4 = false;
            $.each(data_mpe_document, function(u){
                if (data_mpe_document[u].documentName_id === '5')        mpe_check_1 = true;
                else if (data_mpe_document[u].documentName_id === '6')   mpe_check_2 = true;
                else if (data_mpe_document[u].documentName_id === '7')   mpe_check_3 = true;
                else if (data_mpe_document[u].documentName_id === '8')   mpe_check_4 = true;
            });
            if (!mpe_check_1 || !mpe_check_2 || !mpe_check_3 || !mpe_check_4) {
                $('#mpe_wizard').wizard('selectedItem', { step:2 });
                $('#mpe_btn_add_document').focus();
                f_notify(2, 'Error', 'Please make sure all Industrial Process Description provided!');    
                return false;
            }
            bootstrapValidator = $("#form_mpe_3_1").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mpe_wizard').wizard('selectedItem', { step:3 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            bootstrapValidator = $("#form_mpe_3_4").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mpe_wizard').wizard('selectedItem', { step:3 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            mpe_check_1 = false; mpe_check_2 = false; mpe_check_3 = false;
            $.each(data_mpe_docNormalize, function(u){
                if (data_mpe_docNormalize[u].documentName_id === '15')        mpe_check_1 = true;
                else if (data_mpe_docNormalize[u].documentName_id === '16')   mpe_check_2 = true;
                else if (data_mpe_docNormalize[u].documentName_id === '26')   mpe_check_3 = true;
            });
            if (!mpe_check_1 || !mpe_check_2 || !mpe_check_3) {
                $('#mpe_wizard').wizard('selectedItem', { step:3 });
                $('#mpe_btn_add_docNormalize').focus();
                f_notify(2, 'Error', 'Please make sure all Normalization Attachment Type provided!');    
                return false;
            }
            if (data_mpe_personnel.length === 0) {
                $('#mpe_wizard').wizard('selectedItem', { step:4 });
                $('#mpe_btn_add_personnel').focus();
                f_notify(2, 'Error', 'Please make sure PEMS Personal provided');    
                return false;
            }      
            bootstrapValidator = $("#form_mpe_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#mpe_wizard').wizard('selectedItem', { step:5 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            $('#mpe_funct').val('save_installation_pems');
            $('#mpe_wfTask_remark').val($('[name="mpe_snote_wfTask_remark"]').summernote('code'));
            if (f_submit_forms('form_mpe,#form_mpe_2_1,#form_mpe_3_1,#form_mpe_3_4,#form_mpe_5', 'p_registration')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure to submit the PEMS Installation Registration Form?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {            
                        $('#modal_waiting').on('shown.bs.modal', function(e){    
                            const submit_status = $('#mpe_wfTask_status').val() === '2' ? '10' : '13';
                            const submit_msg = $('#mpe_wfTask_status').val() === '2' ? 'Your application successfully submitted. Result will be alerted through your email.' : 'Your application successfully resubmitted. Result will be alerted through your email.';
                            const condition_no = $('#mpe_wfTask_status').val() === '2' ? '' : '1';
                            const wfGroup_id = $('#mpe_wfTask_status').val() === '2' ? $('#mpe_wfGroup_id').val() : '';
                            if (f_submit($('#mpe_wfTask_id').val(), $('#mpe_wfTaskType_id').val(), submit_status, submit_msg, $('#mpe_wfTask_remark').val(), condition_no, wfGroup_id, '', 'indAll_id', $('#mpe_indAll_id').val())) {
                                const email_type = submit_status === '2' ? 'email_assign' : 'email_process';
                                f_send_email(email_type, {wfTask_id:result_submit_task}); 
                                if (mpe_otable === 'ipm')
                                    f_table_ipm ();
                                $('#modal_pems').modal('hide');
                            }
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });
            }
        }); 
                
    });
        
    function f_mpe_insert_parameter () {
        let pollution = [];
        pollution.push('1');
        if (f_submit_normal('insert_industrial_parameter', {sourceActivity_id:$('#mpe_sourceActivity_id').val(), sourceCapacity_id:$('#mpe_sourceCapacity_id').val(), indAll_id:$('#mpe_indAll_id').val(), fuelType_id:$('#mpe_fuelType_id').val(), pollutions:pollution}, 'p_registration')) {
            if (result_submit === '2')
                f_notify(1, 'Success', 'Parameter to be Monitored successfully inserted.');
            $.each(data_mpe_parameter, function(u){
                let bootstrapValidator = $("#form_mpe_2_1").data('bootstrapValidator');
                bootstrapValidator.removeField('mpe_indParam_concentration_'+data_mpe_parameter[u].indParam_id);
            });
            data_mpe_parameter = f_get_general_info_multiple('dt_pub_param', {indAll_id:$('#mpe_indAll_id').val(), indParam_status:'1'}, '', '', 'inputParam_id');
            f_dataTable_draw(mpe_otable_parameter, data_mpe_parameter, 'datatable_mpe_parameter', 5);  
            
        }  
    }
    function f_mpe_delete_written (indWritten_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_industrial_written', {indWritten_id: indWritten_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mpe_written = f_get_general_info_multiple('dt_written_approval', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'indWritten_id');
                f_dataTable_draw(mpe_otable_written, data_mpe_written, 'datatable_mpe_written', 6);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }    
    
    function f_mpe_delete_document (indDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_industrial_document', {indDoc_id: indDoc_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mpe_document = f_get_general_info_multiple('dt_industrial_document', {indAll_id:$('#mpe_indAll_id').val(), documentName_id:'(5,6,7,8,18)'}, '', '', 'indDoc_id');
                f_dataTable_draw(mpe_otable_document, data_mpe_document, 'datatable_mpe_document', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mpe_delete_docNormalize (indDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_industrial_document', {indDoc_id: indDoc_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mpe_docNormalize = f_get_general_info_multiple('dt_industrial_document', {indAll_id:$('#mpe_indAll_id').val(), documentName_id:'(15,16,26)'}, '', '', 'indDoc_id');
                f_dataTable_draw(mpe_otable_docNormalize, data_mpe_docNormalize, 'datatable_mpe_docNormalize', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mpe_delete_personnel (indPers_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_industrial_personnel', {indPers_id: indPers_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mpe_personnel = f_get_general_info_multiple('t_industrial_personnel', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'indPers_id');
                f_dataTable_draw(mpe_otable_personnel, data_mpe_personnel, 'datatable_mpe_personnel', 9);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_mpe_set_sourceCapacity (sourceCapacity_id, sourceActivity_id) {
        set_option_empty('mpe_sourceCapacity_id');
        if ($('#mpe_sourceActivity_id').val() !== '') {
            get_option ('mpe_sourceCapacity_id', '1', 't_source_capacity', 'sourceCapacity_id', 'sourceCapacity_desc', 'sourceCapacity_status', ' ', 'ref_desc', 'sourceActivity_id', sourceActivity_id);
            $('#mpe_sourceCapacity_id').prop('disabled', false).val(sourceCapacity_id);
        }
    }
    
    function f_mpe_set_metalType (metalType_id, sourceActivity_id) {
        $('#mpe_metalType_id').prop('disabled', sourceActivity_id !== '4').val(metalType_id);
    }
    
    function f_mpe_set_consAll (consAll_id, consultant_id) {
        set_option_empty('mpe_consAll_id');
        if ($('#mpe_consultant_id').val() !== '') {
            get_option ('mpe_consAll_id', '1', 't_consultant_pems', 'consAll_id', 'consPems_model', 'consPems_status', ' ', 'ref_desc', 'consultant_id', consultant_id);
            $('#mpe_consAll_id').prop('disabled', false).val(consAll_id);            
        }        
        f_mpe_set_link_consAll (consAll_id);
    }
    
    function f_mpe_set_link_consAll (consAll_id) {
        if (consAll_id === '' || consAll_id === null) {
            $('#mpe_divAnalyzerDetails').html('');  
        } else {
            const wfTrans_id = f_get_value_from_table('t_consultant_pems', 'consAll_id', consAll_id, 'wfTrans_id');
            const wfTrans_regNo = f_get_value_from_table('wf_transaction', 'wfTrans_id', wfTrans_id, 'wfTrans_regNo');
            $('#mpe_divAnalyzerDetails').html('<a href="#" onClick="f_load_consultant_pems (3, \'\', '+consAll_id+',\'ctp\');">'+wfTrans_regNo+'</a>');
            const softwareMethod_id = f_get_value_from_table('t_consultant_pems', 'consAll_id', consAll_id, 'softwareMethod_id');
            const softwareMethod_desc = f_get_value_from_table('t_software_method', 'softwareMethod_id', softwareMethod_id, 'softwareMethod_desc');
            $('#mpe_divSoftwareMethod').html(softwareMethod_desc);
        }     
    }
    
    function f_mpe_set_yearRATA() {
        const searchIDs = $("input[name='mpe_q_indQuarter_no[]']:checked").map(function(){
            return $(this).val();
        }).get();
        if (searchIDs.length === 3) {
            if ($('input[name="mpe_indAll_qaFreqQuarterly"]:checked').val() === '1' && $('input[name="mpe_indAll_qaFreqYearly"]:checked').val() === '1') {
                for(let n=1; n<=4; n++) {
                    if (!$("input[name='mpe_q_indQuarter_no[]'][value="+n+"]").is(':checked'))
                        $("input[name='mpe_y_indQuarter_no'][value="+n+"]").prop('checked', true);
                }
                $('#form_mpe_3_4').bootstrapValidator('revalidateField', 'mpe_y_indQuarter_no');
            }
        }
    }
    
    function f_mpe_set_quarterRATA() {
        const searchIDs = $("input[name='mpe_q_indQuarter_no[]']:checked").map(function(){
            return $(this).val();
        }).get();
        if (searchIDs.length <= 3) {
            if ($('input[name="mpe_indAll_qaFreqQuarterly"]:checked').val() === '1' && $('input[name="mpe_indAll_qaFreqYearly"]:checked').val() === '1') {
                for(let n=1; n<=4; n++) {
                    $("input[name='mpe_q_indQuarter_no[]'][value="+n+"]").prop('checked', false);
                    if (n !== parseInt($('input[name="mpe_y_indQuarter_no"]:checked').val())) {
                        $("input[name='mpe_q_indQuarter_no[]'][value="+n+"]").prop('checked', true);
                    }
                }
                $('#form_mpe_3_4').bootstrapValidator('revalidateField', 'mpe_q_indQuarter_no[]');
            }
        }
    }
    
//    function f_mpe_table_inputReading () {
//        $.each(data_mpe_inputReading, function(u){
//            var bootstrapValidator = $("#form_mpe_3_4").data('bootstrapValidator');
//            bootstrapValidator.removeField('mpe_low_min_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_low_max_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_low_weight_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_normal_min_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_normal_max_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_normal_weight_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_high_min_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_high_max_'+data_mpe_inputReading[u].pemsInput_id);
//            bootstrapValidator.removeField('mpe_high_weight_'+data_mpe_inputReading[u].pemsInput_id);
//        });        
//        var selected_wfTask = f_get_general_info_multiple('wf_task', {wfTrans_id:$('#mpe_wfTrans_id').val(), wfTaskType_id:'41'}, '', '', 'wfTask_id DESC'); 
//        data_mpe_inputReading  = f_get_general_info_multiple('dt_pems_reading', {}, {indAll_id:$('#mpe_indAll_id').val(), wfTask_id:selected_wfTask[0].wfTask_id}, '', 'pemsInput_id');
//        f_dataTable_draw(mpe_otable_inputReading, data_mpe_inputReading, 'datatable_mpe_inputReading', 15);
//    }
    
    function f_mpe_delete_inputReading (pemsReading_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_pems_input_reading', {pemsReading_id: pemsReading_id}, 'p_registration', 'Data successfully deleted.')) {
                //f_mpe_table_inputReading ();
                data_mpe_inputReading = f_get_general_info_multiple('t_industrial_pems_reading', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'pemsReading_id');
                f_dataTable_draw(mpe_otable_inputReading, data_mpe_inputReading, 'datatable_mpe_inputReading', 7);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_load_pems (load_type, wfGroup_id, indAll_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (mpe_1st_load) {      
                get_option('mpe_document_type', '1', 'document_name', 'documentName_id', 'documentName_desc', 'documentName_status', ' ', 'ref_id', 'documentName_type', 'pems');           
                get_option('mpe_docNormalize_type', '1', 'document_name', 'documentName_id', 'documentName_desc', 'documentName_status', ' ', 'ref_id', 'documentName_type', 'normalize');           
                mpe_1st_load = false;
            }
            if (load_type === 1) {
                const isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wfGroup_id, 'wfGroup_isFirstTime');
                if (isFirstTime === '1') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', 'Please update Industrial Information as first-time login user in order to perform PEMS Installation registration');  
                    f_menu_redirect(11,0,0);
                    return false;
                }
            }
            $('#form_mpe,#form_mpe_2_1,#form_mpe_2_2,#form_mpe_2_3,#form_mpe_3_1,#form_mpe_3_2,#form_mpe_3_3,#form_mpe_3_4,#form_mpe_4,#form_mpe_5').trigger('reset');
            $('#form_mpe_2_1').bootstrapValidator('resetForm', true);
            $('#form_mpe_2_2').bootstrapValidator('resetForm', true);
            $('#form_mpe_2_3').bootstrapValidator('resetForm', true);
            $('#form_mpe_3_1').bootstrapValidator('resetForm', true);
            $('#form_mpe_3_2').bootstrapValidator('resetForm', true);
            $('#form_mpe_3_3').bootstrapValidator('resetForm', true);
            $('#form_mpe_3_4').bootstrapValidator('resetForm', true);
            $('#form_mpe_4').bootstrapValidator('resetForm', true);
            $('#form_mpe_5').bootstrapValidator('resetForm', true);            
            $('#mpe_load_type').val(load_type);
            $('#mpe_wfGroup_id').val(wfGroup_id);
            $('#mpe_indAll_id').val(indAll_id);
            mpe_otable = otable;
            mpe_load_type = load_type;
            $('#form_mpe,#form_mpe_2_1,#form_mpe_2_2,#form_mpe_2_3,#form_mpe_3_1,#form_mpe_3_2,#form_mpe_3_3,#form_mpe_3_4,#form_mpe_5').find('input, textarea, select').prop('disabled',false);
            $('.mpe_hideView').show();
            $('.mpe_disView, .mpe_disReason').attr('disabled',true);
            $('#mpe_alert_box, .mpe_checkView, #mpe_div_doc_other, .mpe_q_daily, .mpe_q_quarter, .mpe_q_year').hide();
            $('#mpe_snote_wfTask_remark').summernote('enable');
            $("input[name='mpe_declare']").prop('checked', false);
            // ---------------- \\
            if (mpe_load_type === 1) {
                if (wfGroup_id === '') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                if (!f_submit_normal('create_installation', {wfGroup_id:wfGroup_id, wfTaskType_id:'41', wfFlow_id:'5', indAll_type:'2'}, 'p_registration', '', errMsg_default))   return false;
                $('#mpe_indAll_id').val(result_submit);
                if (mpe_otable === 'ipm')
                    f_table_ipm ();
            } 
            // --- extract details --- //
            const status = load_type <= 2 ? '1' : '';
            const status_cons = load_type <= 2 ? 'AND consPems_status = 1' : '';
            get_option('mpe_sourceActivity_id', status, 't_source_activity', 'sourceActivity_id', 'sourceActivity_desc', 'sourceActivity_status', ' ', 'ref_id');           
            get_option('mpe_consultant_id', status_cons, 'consultant_pems', '', '', '', ' ', 'ref_id');
            const installation_all = f_get_general_info('vw_installation_all_details', {indAll_id:$('#mpe_indAll_id').val()}, 'mpe');
            if ((installation_all.wfTask_status === '22' && installation_all.indAll_status === '22') || (installation_all.wfTask_status === '23' && installation_all.indAll_status === '23')) {
                const previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:installation_all.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
                $('#mpe_alert_box').show();
                $('#mpe_alert_message').html(previous_task[0].wfTask_remark);
            }
            $("input[name='mpe_indAll_installType'][value=" + installation_all.indAll_installType + "]").prop('checked', true);
            $("input[name='mpe_indAll_qaFreqDaily'][value=" + installation_all.indAll_qaFreqDaily + "]").prop('checked', true);
            $("input[name='mpe_indAll_qaMethod'][value=" + installation_all.indAll_qaMethod + "]").prop('checked', true);
            $("input[name='mpe_indAll_qaFreqQuarterly'][value=" + installation_all.indAll_qaFreqQuarterly + "]").prop('checked', true);
            $("input[name='mpe_indAll_qaFreqYearly'][value=" + installation_all.indAll_qaFreqYearly + "]").prop('checked', true);
            if (installation_all.indAll_qaFreqDaily === '1')
                $('.mpe_q_daily').show();
            if (installation_all.indAll_qaFreqQuarterly === '1')
                $('.mpe_q_quarter').show();
            if (installation_all.indAll_qaFreqYearly === '1')
                $('.mpe_q_year').show();
            const industrial_quarter = f_get_general_info_multiple('t_industrial_quarter', {indAll_id:$('#mpe_indAll_id').val()});
            $.each(industrial_quarter, function(u){
                if (industrial_quarter[u].indQuarter_type === '1')
                    $("input[name='mpe_q_indQuarter_no[]'][value=" + industrial_quarter[u].indQuarter_no + "]").prop('checked', true);
                else if (industrial_quarter[u].indQuarter_type === '2')
                    $("input[name='mpe_y_indQuarter_no'][value=" + industrial_quarter[u].indQuarter_no + "]").prop('checked', true);
            });
            f_mpe_set_sourceCapacity (installation_all.sourceCapacity_id, installation_all.sourceActivity_id);
            f_mpe_set_metalType (installation_all.metalType_id, installation_all.sourceActivity_id);
//            var industrial_pollution = f_get_general_info_multiple('t_industrial_pollution', {indAll_id:$('#mpe_indAll_id').val()});
//            $.each(industrial_pollution, function(u){
//                $("input[name='mpe_pollutionMonitored_id[]'][value=" + industrial_pollution[u].pollutionMonitored_id + "]").prop('checked', true);
//            }); 
            $("input[name='mpe_pollutionMonitored_id[]'][value=1]").prop('checked', true).prop('disabled', true);
            $("input[name='mpe_pollutionMonitored_id[]']").prop('disabled', true);
            const industrial_reason = f_get_general_info_multiple('t_industrial_reason', {indAll_id:$('#mpe_indAll_id').val()});
            $.each(industrial_reason, function(u){
                $("input[name='mpe_indReason_id[]'][value=" + industrial_reason[u].indReason_id + "]").prop('checked', true);
                if (industrial_reason[u].indReason_id === '4') {
                    $('.mpe_disReason').prop('disabled', false);
                    $('#mpe_indReason_other').val(industrial_reason[u].indReason_other);
                }
            });  
            $('#form_mpe_2_3').bootstrapValidator('enableFieldValidators', 'mpe_indDoc_others', false);                      
            if (installation_all.sourceCapacity_id === '1' || installation_all.sourceCapacity_id === '2')
                $('#mpe_fuelType_id').prop('disabled', false);            
            // $('#mpe_fuelType_id option[value="1"]').attr("disabled", installation_all.sourceCapacity_id != '1');
            // $('#mpe_fuelType_id option[value="2"]').attr("disabled", installation_all.sourceCapacity_id != '2');
            $('#mpe_fuelType_id option[value="3"]').attr("disabled", installation_all.sourceCapacity_id !== '3');
            // ---------------- \\
            f_mpe_set_consAll (installation_all.consAll_id, installation_all.consultant_id);
            // ---------------- \\
            $('[name="mpe_snote_wfTask_remark"]').summernote('code', installation_all.indAll_remark);
            $('#form_mpe_5').bootstrapValidator('resetField', 'mpe_snote_wfTask_remark');
            // ---------------- \\
            data_mpe_parameter = f_get_general_info_multiple('dt_pub_param', {indAll_id:$('#mpe_indAll_id').val(), indParam_status:'1'}, '', '', 'inputParam_id');
            f_dataTable_draw(mpe_otable_parameter, data_mpe_parameter, 'datatable_mpe_parameter', 5);
            data_mpe_written = f_get_general_info_multiple('dt_written_approval', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'indWritten_id');
            f_dataTable_draw(mpe_otable_written, data_mpe_written, 'datatable_mpe_written', 6);
            data_mpe_document = f_get_general_info_multiple('dt_industrial_document', {indAll_id:$('#mpe_indAll_id').val(), documentName_id:'(5,6,7,8,18)'}, '', '', 'indDoc_id');
            f_dataTable_draw(mpe_otable_document, data_mpe_document, 'datatable_mpe_document', 4);
            data_mpe_docNormalize = f_get_general_info_multiple('dt_industrial_document', {indAll_id:$('#mpe_indAll_id').val(), documentName_id:'(15,16,26)'}, '', '', 'indDoc_id');
            f_dataTable_draw(mpe_otable_docNormalize, data_mpe_docNormalize, 'datatable_mpe_docNormalize', 4);
            data_mpe_personnel = f_get_general_info_multiple('t_industrial_personnel', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'indPers_id');
            f_dataTable_draw(mpe_otable_personnel, data_mpe_personnel, 'datatable_mpe_personnel', 9);
            data_mpe_inputReading = f_get_general_info_multiple('t_industrial_pems_reading', {indAll_id:$('#mpe_indAll_id').val()}, '', '', 'pemsReading_id');
            f_dataTable_draw(mpe_otable_inputReading, data_mpe_inputReading, 'datatable_mpe_inputReading', 7);
//            f_mpe_table_inputReading();
            // ---------------- \\
            if (mpe_load_type >= 3) {
                mpe_total_section = [];
                $('#form_mpe,#form_mpe_2_1,#form_mpe_2_2,#form_mpe_2_3,#form_mpe_3_1,#form_mpe_3_2,#form_mpe_3_4,#form_mpe_5').find('input, textarea, select').prop('disabled',true);
                $('#mpe_snote_wfTask_remark').summernote('disable');
                $("input[name='mpe_declare']").prop('checked', true);
                $('.mpe_hideView').hide();
                if (mpe_load_type >= 4) {
                    $('.mpe_form_check').prop('disabled', false);
                    $('.mpe_checkView, #mpe_btn_save').show();
                    const checklist_task = f_get_general_info_multiple('t_checklist_task', {wfTask_id:$('#mpe_wfTask_id').val(), checklistTask_status:'1'});
                    $.each(checklist_task, function(u){
                        $('#mpe_check_remark_'+checklist_task[u].checklist_id).val(checklist_task[u].checklistTask_remark);
                        if (checklist_task[u].checklistTask_result === '1')
                            $("input[name='mpe_check_pass_"+checklist_task[u].checklist_id+"']").prop('checked', true);
                        mpe_total_section[u] = checklist_task[u].checklist_id;
                    });    
                }
            }    
            $('#modal_pems').modal('show');       
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
        
    }
        
</script>