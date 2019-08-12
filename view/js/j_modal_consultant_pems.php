<script type="text/javascript">  
    
    var map_otable;
    var map_load_type;
    var map_1st_load = true;
    var map_otable_personnel;
    var data_map_personnel;
    var map_otable_project;
    var data_map_project;
    var map_interval;
    var map_interval_cnt = 0;
    var map_total_section = [];
    
    $(document).ready(function () {
        
        $('#map_btn_next').on('click', function () {
            var stepNum = $('#map_wizard').wizard('selectedItem'); 
            if (stepNum.step == 4)
                $('#map_btn_next').prop('disabled', true);
        });
        
        $('#map_btn_prev').on('click', function () {
            var stepNum = $('#map_wizard').wizard('selectedItem'); 
            if (stepNum.step == 5)
                $('#map_btn_next').prop('disabled', false);
        });
        
        $('#map_snote_wfTask_remark').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#form_map_6').bootstrapValidator('revalidateField', 'map_snote_wfTask_remark');
                    $('#map_wfTask_remark').val(contents);
                }
            }
        });     
        
        $('#form_map_2_1').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                'map_consultant_type[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Type of Consultant required'
                        }                        
                    }
                },
                'map_consEmisCate_value[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Categories of Emission Monitoring required'
                        }                        
                    }
                },
                map_consPems_model : {
                    validators: {
                        notEmpty: {
                            message: 'Modeling Software is required'
                        },
                        stringLength : {
                            max : 150,
                            message : 'Modeling Software must be not more than 150 characters long'
                        }
                    }
                },
                map_consPems_version : {
                    validators: {
                        notEmpty: {
                            message: 'Software Version is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Software Version must be not more than 30 characters long'
                        }
                    }
                },
                map_consPems_ownerStatus : {
                    validators: {
                        notEmpty: {
                            message: 'Software Development is required'
                        }
                    }
                },
                map_consPems_outsource : {
                    validators: {
                        callback: {
                            message: 'Outsourced Company is required',
                            callback: function (value, validator, $field) {
                                return ($('#map_consPems_ownerStatus').val() != '2') ? true : (value !== '');
                            }
                        },
                        stringLength : {
                            max : 80,
                            message : 'Outsourced Company must be not more than 80 characters long'
                        }
                    }
                },
                map_consPems_mobileConsultant : {
                    validators: {
                        notEmpty: {
                            message: 'Mobile-CEMS Consultant is required'
                        }
                    }
                },
                map_consPems_mobileCems : {
                    validators: {
                        notEmpty: {
                            message: 'Mobile/Portable Analyzer Model No. is required'
                        }
                    }
                },
                map_consPems_security : {
                    validators: {
                        notEmpty: {
                            message: 'Security Features of Software is required'
                        }
                    }
                }
            }
        });     
        
        $('#form_map_2_5').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                map_das_probeSoftware : {
                    validators: {
                        stringLength : {
                            max : 100,
                            message : 'Probe Software Version must be not more than 100 characters long'
                        }
                    }
                },
                map_das_probeDesc : {
                    validators: {
                        stringLength : {
                            max : 255,
                            message : 'Probe Software Description must be not more than 100 characters long'
                        }
                    }
                },
                map_das_analyzerSoftware : {
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
                map_das_analyzerDesc : {
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
                map_dis_name : {
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
                map_dis_type : {
                    validators: {
                        notEmpty: {
                            message: 'Status of DIS is required'
                        }
                    }
                },
                map_dis_outsource : {
                    validators: {
                        callback: {
                            message: 'Outsourced Company is required',
                            callback: function (value, validator, $field) {
                                return ($('#map_dis_type').val() != '2') ? true : (value !== '');
                            }
                        },
                        stringLength : {
                            max : 80,
                            message : 'Outsourced Company must be not more than 80 characters long'
                        }
                    }
                },
                map_dis_description : {
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
        
        $('#form_map_3').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                map_consPers_name : {
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
                map_personnel_icNo : {
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
                                var value_citizen = $('input[name="map_personnel_citizenship"]:checked').val();
                                return {
                                    valid: (value_citizen==1 && value.length== 12) || (value_citizen==2&&value.length>=5 && value.length<=9),
                                    message: (value_citizen==1?'Identification No.':'Passport') + ' No. must be ' + (value_citizen==1?'12':'between 5 and 9') + ' digits long'
                                };
                            }
                        }
                    }
                },
                map_consPers_qualification : {
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
                map_consPers_experience : {
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
                map_consPers_certificate : {
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
                map_consPers_document_name : {
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
                map_consPers_document : {
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
        
        $('#form_map_3').find('[name="map_personnel_citizenship"]').on('click', function () { 
            var is_enabled = $(this).val() == '1';
            $('#form_map_3').bootstrapValidator('enableFieldValidators', 'map_personnel_icNo', is_enabled, 'digits');
            $('#form_map_3').bootstrapValidator('revalidateField', 'map_personnel_icNo');
        });
        
        $('#form_map_3').find('[name="map_consPers_workingStatus"]').on('click', function () { 
            var is_enabled = $(this).val() == '2';
            $('#form_map_3').bootstrapValidator('enableFieldValidators', 'map_consPers_document', is_enabled);
            $('#form_map_3').bootstrapValidator('revalidateField', 'map_consPers_document');
            $('#form_map_3').bootstrapValidator('enableFieldValidators', 'map_consPers_document_name', is_enabled);
            $('#form_map_3').bootstrapValidator('revalidateField', 'map_consPers_document_name');
            is_enabled ? $('#map_star_document_name').show() : $('#map_star_document_name').hide(); 
        });
                            
        $('#form_map_5').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                map_consProject_title : {
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
                map_consProject_year : {
                    validators: {
                        notEmpty: {
                            message: 'Year is required'
                        }
                    }
                },
                map_consProject_client : {
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
                map_consProject_desc : {
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
                map_consProject_scope : {
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
                map_consProject_source : {
                    validators: {
                        notEmpty: {
                            message: 'Source of Activity is required'
                        }
                    }
                },
                map_consProject_value : {
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
        
        $('#form_map_6').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                map_declare_1 : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration required'
                        }                        
                    }
                },
                map_declare_2 : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'Declaration required'
                        }                        
                    }
                },
                map_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="map_snote_wfTask_remark"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#modal_consultant_pems').on('show.bs.modal', function() {
            $('#map_wizard').wizard('selectedItem', { step:1 });
            $('#map_btn_next').prop('disabled', false);
            if ($('#map_load_type').val() == '1' || $('#map_load_type').val() == '2') {
//                map_interval = window.setInterval(function(){ 
//                    if (map_interval_cnt == 1) {
//                        $("#map_funct").val('save_consultant_pems');
//                        $('#map_wfTask_remark').val($('[name="map_snote_wfTask_remark"]').summernote('code'));
//                        $('#modal_waiting').on('shown.bs.modal', function(e){
//                            if (f_submit_forms('form_map,#form_map_2_1,#form_map_2_5,#form_map_6', 'p_registration', 'Data successfully saved.')) {
//                                if (map_otable == 'cps')
//                                    f_table_cps ();
//                            }
//                            $('#modal_waiting').modal('hide');
//                            $(this).unbind(e);
//                        }).modal('show'); 
//                    }
//                    map_interval_cnt = 1;
//                }, 300000);
            }
        });
        
        $('#modal_consultant_pems').on('hide.bs.modal', function() {
            map_interval_cnt = 0;
            //clearInterval(map_interval);
            map_interval = 0;
        });
        
        $('#map_dis_type').on('change', function () {
            $('#map_dis_outsource').val('');
            $('#form_map_2_5').bootstrapValidator('revalidateField', 'map_dis_outsource');
            $('#map_dis_outsource').attr('disabled',$(this).val() == '2' ? false : true);
            $('#form_map_2_5').bootstrapValidator('revalidateField', 'map_dis_outsource');
        });
        
        $('#map_consPems_ownerStatus').on('change', function () {
            $('#map_consPems_outsource').val('');
            $('#form_map_2_1').bootstrapValidator('revalidateField', 'map_consPems_outsource');
            $('#map_consPems_outsource').attr('disabled',$(this).val() == '2' ? false : true); 
            $('#form_map_2_1').bootstrapValidator('revalidateField', 'map_consPems_outsource');
        });
                
        $('#map_btn_save').on('click', function () {
            if ($('#map_load_type').val() == '4') {
                $('#modal_waiting').on('shown.bs.modal', function(e){ 
                    var parameters = {};
                    parameters['wfTask_id'] = $('#map_wfTask_id').val();      
                    parameters['wfFlow_id'] = '2';         
                    $.each(map_total_section, function(value){     
                        parameters['check_remark_'+map_total_section[value]] = $('#map_check_remark_'+map_total_section[value]).val();
                        parameters['check_pass_'+map_total_section[value]] = $("input[name='map_check_pass_"+map_total_section[value]+"']").is(':checked') ? '1' : '0';
                    });
                    f_submit_normal('save_process_checking', parameters, 'p_registration', 'Process Checklist successfully saved.');
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                $("#map_funct").val('save_consultant_pems');
                $('#map_wfTask_remark').val($('[name="map_snote_wfTask_remark"]').summernote('code'));
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_map,#form_map_2_1,#form_map_2_5,#form_map_6', 'p_registration', 'Data successfully saved.')) {
                        if (map_otable == 'cps')
                            f_table_cps ();
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            }
        }); 
        
        $('#map_btn_submit').on('click', function () {            
            var bootstrapValidator = $("#form_map_2_1").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#map_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            bootstrapValidator = $("#form_map_2_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#map_wizard').wizard('selectedItem', { step:2 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            if (data_map_personnel.length == 0) {
                $('#map_wizard').wizard('selectedItem', { step:3 });
                $('#map_btn_add_personnel').focus();
                f_notify(2, 'Error', 'Please provide Information of Personnel for PEMS!');    
                return false;
            }
            if (!f_submit_normal('check_consultant_personnel', {consAll_id:$('#map_consAll_id').val(), wfGroup_id: $('#map_wfGroup_id').val()}, 'p_registration')) {
                $('#map_wizard').wizard('selectedItem', { step:3 });
                $('#map_btn_add_personnel').focus();
                return false;
            }   
            if (data_map_project.length == 0) {
                $('#map_wizard').wizard('selectedItem', { step:4 });
                $('#map_btn_add_project').focus();
                f_notify(2, 'Error', 'Please provide Information of Company\'s Working Experience!');    
                return false;
            }
            bootstrapValidator = $("#form_map_6").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                $('#map_wizard').wizard('selectedItem', { step:5 });
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            var chk_doc_27 = f_get_general_info_multiple('t_consultant_docSupport', {consultant_id:$('#map_consultant_id').val(), documentName_id:'27'});
            if(chk_doc_27.length === 0) {
                f_notify(2, 'Error', 'Please make Company Profile uploaded from Consultant Information menu!');    
                return false;
            }
            var chk_doc_28 = f_get_general_info_multiple('t_consultant_docSupport', {consultant_id:$('#map_consultant_id').val(), documentName_id:'28'});
            if(chk_doc_28.length === 0) {
                f_notify(2, 'Error', 'Please make Registry of Companies uploaded from Consultant Information menu!');    
                return false;
            }
            $("#map_funct").val('save_consultant_pems');
            $('#map_wfTask_remark').val($('[name="map_snote_wfTask_remark"]').summernote('code'));
            if (f_submit_forms('form_map,#form_map_2_1,#form_map_2_5,#form_map_6', 'p_registration')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure to submit the PEMS Consultant Registration Form?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {
                        $('#modal_waiting').on('shown.bs.modal', function(e){  
                            if (f_submit_normal('check_consultant_active', {wfGroup_id: $('#map_wfGroup_id').val()}, 'p_registration')) {
                                var submit_status = $('#map_wfTask_status').val() == '2' ? '10' : '13';
                                var submit_msg = $('#map_wfTask_status').val() == '2' ? 'Your application successfully submitted. Result will be alerted through your email.' : 'Your application successfully resubmitted. Result will be alerted through your email.';
                                var condition_no = $('#map_wfTask_status').val() == '2' ? '' : '1';
                                var wfGroup_id = $('#map_wfTask_status').val() == '2' ? $('#map_wfGroup_id').val() : '';
                                if (f_submit($('#map_wfTask_id').val(), $('#map_wfTaskType_id').val(), submit_status, submit_msg, $('#map_wfTask_remark').val(), condition_no, wfGroup_id, '', 'consAll_id', $('#map_consAll_id').val())) {
                                    var email_type = submit_status == '2' ? 'email_assign' : 'email_process';
                                    f_send_email(email_type, {wfTask_id:result_submit_task}); 
                                    if (map_otable == 'hm8')
                                        f_hm8_set_alert();
                                    else if (map_otable == 'cps')
                                        f_table_cps ();
                                    $('#modal_consultant_pems').modal('hide');
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
                
        $('#map_btn_add_personnel').on('click', function () {
            var bootstrapValidator = $("#form_map_3").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#map_funct').val('save_consultant_personnel_pems');
                $('#modal_waiting').on('shown.bs.modal', function(e){     
                    var formData = new FormData($('#form_map_3')[0]);
                    formData.append('funct', 'save_consultant_personnel_pems');
                    formData.append('map_consAll_id', $('#map_consAll_id').val());
                    formData.append('map_wfGroup_id', $('#map_wfGroup_id').val());
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
                                $('#form_map_3').trigger('reset');
                                $('#form_map_3').bootstrapValidator('resetForm', true);
                                $('#map_star_document_name').hide();
                                data_map_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#map_consAll_id').val()}, '', '', 'consPers_id');
                                f_dataTable_draw(map_otable_personnel, data_map_personnel, 'datatable_map_personnel', 8);
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
        
        $('#map_btn_add_project').on('click', function () {
            var bootstrapValidator = $("#form_map_5").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#map_funct').val('save_consultant_project_pems');
                $('#modal_waiting').on('shown.bs.modal', function(e){   
                    if (f_submit_forms('form_map,#form_map_5', 'p_registration', 'Company Working Experience successfully added.')) {
                        $('#form_map_5').bootstrapValidator('resetForm', true);                    
                        data_map_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#map_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
                        f_dataTable_draw(map_otable_project, data_map_project, 'datatable_map_project', 9);
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        $('#map_consPems_mobileConsultant').on('change', function () {
            $('#form_map_2_1').data('bootstrapValidator').resetField('map_consPems_mobileCems');
            f_map_set_mobileCems('', $(this).val()); 
        });
        
        var datatable_map_personnel = undefined; 
        map_otable_personnel = $('#datatable_map_personnel').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_map_personnel) {
                    datatable_map_personnel = new ResponsiveDatatablesHelper($('#datatable_map_personnel'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_map_personnel.createExpandIcon(nRow);
                var info = map_otable_personnel.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_map_personnel.respond();
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
                            $label += '<button type="button" class="btn btn-danger btn-xs map_hideView" title="Delete" onclick="f_map_delete_consPers ('+row.consPers_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_map_project = undefined; 
        map_otable_project = $('#datatable_map_project').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_map_project) {
                    datatable_map_project = new ResponsiveDatatablesHelper($('#datatable_map_project'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_map_project.createExpandIcon(nRow);
                var info = map_otable_project.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_map_project.respond();
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
                                $label = '<button type="button" class="btn btn-danger btn-xs map_hideView" title="Delete" onclick="f_map_delete_project ('+row.consProject_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
    });    
        
    function f_map_delete_consPers (consPers_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){   
            if (f_submit_normal('delete_consultant_personnel', {consPers_id: consPers_id, wfGroup_id: $('#map_wfGroup_id').val()}, 'p_registration', 'Data successfully deleted.')) {
                data_map_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#map_consAll_id').val()}, '', '', 'consPers_id');
                f_dataTable_draw(map_otable_personnel, data_map_personnel, 'datatable_map_personnel', 8);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_map_delete_project (consProject_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){   
            if (f_submit_normal('delete_consultant_project', {consProject_id: consProject_id}, 'p_registration', 'Data successfully deleted.')) {
                data_map_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#map_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
                f_dataTable_draw(map_otable_project, data_map_project, 'datatable_map_project', 9);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
    function f_map_set_mobileCems(consPems_mobileCems, consPems_mobileConsultant) {
        set_option_empty('map_consPems_mobileCems');
        if ($('#map_consPems_mobileConsultant').val() != '') {   
            get_option ('map_consPems_mobileCems', '1', 't_consultant_mobile', 'consAll_id', 'consMobile_modelNo', 'consMobile_status', ' ', 'ref_desc', 'consultant_id', consPems_mobileConsultant);
            $('#map_consPems_mobileCems').prop('disabled', false).val(consPems_mobileCems);
        }
    }
        
    function f_load_consultant_pems (load_type, wfGroup_id, consAll_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            if (map_1st_load) {                           
                var source_activity = f_get_general_info_multiple('t_source_activity', {sourceActivity_status:'1'}, {}, '', 'sourceActivity_id');
                $.each(source_activity, function(u){
                    var html = '<div class="checkbox"><label>';
                    html += '<input type="checkbox" class="checkbox" name="map_sourceActivity_id[]" value="'+source_activity[u].sourceActivity_id+'" >';
                    html += '<span>'+source_activity[u].sourceActivity_desc+'</span>';
                    html += '</label></div>';
                    $('#map_div_sourceActivity').append(html);
                });        
                var bootstrapValidator = $("#form_map_2_1").data('bootstrapValidator');
                bootstrapValidator.addField('map_sourceActivity_id[]', {validators:{choice:{min:1,message:'At least 1 Source of Activity required'}}});
                // ---------------- \\
                map_1st_load = false;
                get_option('map_consProject_source', '1', 't_source_activity', 'sourceActivity_id', 'sourceActivity_desc', 'sourceActivity_status', ' ', 'ref_id');           
            }
            if (load_type == 1) {      
                var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wfGroup_id, 'wfGroup_isFirstTime');        
                if (isFirstTime == '1') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', 'Please update Consultant Information as first-time login user in order to perform CEMS Analyzer registration');  
                    f_menu_redirect(11,0,0);
                    return false;
                }
            }
            $('#form_map,#form_map_1,#form_map_2_1,#form_map_2_5,#form_map_3,#form_map_5,#form_map_6').trigger('reset');
            $('#form_map_2_1').bootstrapValidator('resetForm', true);
            $('#form_map_2_5').bootstrapValidator('resetForm', true);
            $('#form_map_3').bootstrapValidator('resetForm', true);
            $('#form_map_5').bootstrapValidator('resetForm', true);
            $('#form_map_6').bootstrapValidator('resetForm', true);
            $('#map_load_type').val(load_type);
            $('#map_wfGroup_id').val(wfGroup_id);
            $('#map_consAll_id').val(consAll_id);
            map_otable = otable;
            map_load_type = load_type;
            $('#form_map,#form_map_1,#form_map_2_1,#form_map_2_5,#form_map_3,#form_map_5,#form_map_6').find('input, textarea, select').prop('disabled',false);
            $('.map_hideView').show();
            $('.map_disView,#map_dis_outsource,#map_consPems_outsource').attr('disabled',true);
            $('#map_alert_box, .map_checkView, #map_star_document_name').hide();
            $('#map_snote_wfTask_remark').summernote('enable');
            $("input[name='map_declare_1'], input[name='map_declare_2']").prop('checked', false);
            // ---------------- \\
            if (map_load_type == 1) {      
                if (wfGroup_id == '') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                if (!f_submit_normal('create_consultant', {wfGroup_id:wfGroup_id, wfTaskType_id:'11', wfFlow_id:'2', consAll_type:'2'}, 'p_registration', '', errMsg_default))   return false;
                $('#map_consAll_id').val(result_submit);
                if (map_otable == 'hm8') 
                    f_hm8_set_alert();
                else if (map_otable == 'cps')
                    f_table_cps ();
            } 
            // --- extract details --- //
            var status = load_type <= 2 ? '1' : '';
            var status_mobile = load_type <= 2 ? 'AND consMobile_status = 1' : '';
            get_option('map_softwareMethod_id', status, 't_software_method', 'softwareMethod_id', 'softwareMethod_desc', 'softwareMethod_status', ' ', 'ref_id');
            get_option('map_consPems_mobileConsultant', status_mobile, 'mobile_cems', '', '', '', ' ', 'ref_id');
            var consultant_pems = f_get_general_info('vw_consultant_pems_details', {consAll_id:$('#map_consAll_id').val()}, 'map');   
            if ((consultant_pems.wfTask_status == '22' && consultant_pems.consPems_status == '22') || (consultant_pems.wfTask_status == '23' && consultant_pems.consPems_status == '23')) {
                var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:consultant_pems.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
                $('#map_alert_box').show();
                $('#map_alert_message').html(previous_task[0].wfTask_remark);
            }
            if (consultant_pems.consPems_isInstall == '1')
                $("input[name='map_consultant_type[]'][value=1]").prop('checked', true);     
            if (consultant_pems.consPems_isMaintain == '1')
                $("input[name='map_consultant_type[]'][value=2]").prop('checked', true);     
            $('#map_consPems_outsource').attr('disabled', $('#map_consPems_ownerStatus').val() == '2' ? false : true);
            //$('#form_map_2_1').bootstrapValidator('revalidateField', 'map_consPems_outsource');
            f_map_set_mobileCems(consultant_pems.consPems_mobileCems, consultant_pems.consPems_mobileConsultant);
            $('#form_map_3').bootstrapValidator('enableFieldValidators', 'map_consPers_document', false);            
            $('#form_map_3').bootstrapValidator('enableFieldValidators', 'map_consPers_document_name', false);
            // ---------------- \\
            $("input[name='map_consEmisCate_value[]'][value=1]").prop('checked', true);
            $("input[name='map_consEmisCate_value[]']").prop('disabled', true);
            // ---------------- \\
            var consultant_source = f_get_general_info_multiple('t_consultant_source', {consAll_id:$('#map_consAll_id').val()});
            $.each(consultant_source, function(u){
                $("input[name='map_sourceActivity_id[]'][value=" + consultant_source[u].sourceActivity_id + "]").prop('checked', true);
            });
            // ---------------- \\
            $('#map_dis_outsource').attr('disabled', $('#map_dis_type').val() == '2' ? false : true);
            // ---------------- \\
            $('[name="map_snote_wfTask_remark"]').summernote('code', consultant_pems.consAll_remark);
            $('#form_map_6').bootstrapValidator('resetField', 'map_snote_wfTask_remark');
            // --- tables --- //
            data_map_personnel = f_get_general_info_multiple('dt_consultant_personnel', {consAll_id:$('#map_consAll_id').val()}, '', '', 'consPers_id');
            f_dataTable_draw(map_otable_personnel, data_map_personnel, 'datatable_map_personnel', 8);
            data_map_project = f_get_general_info_multiple('dt_consultant_project', {consultant_id:$('#map_consultant_id').val(), consProject_status:'1'}, '', '', 'consProject_year desc');
            f_dataTable_draw(map_otable_project, data_map_project, 'datatable_map_project', 9);
            // ---------------- \\
            if (map_load_type >= 3) {
                map_total_section = [];
                $('#form_map,#form_map_1,#form_map_2_1,#form_map_2_5,#form_map_3,#form_map_5,#form_map_6').find('input, textarea, select').prop('disabled',true);
                $('#map_snote_wfTask_remark').summernote('disable');
                $("input[name='map_declare_1'], input[name='map_declare_2']").prop('checked', true);
                $('.map_hideView').hide();
                if (map_load_type >= 4) {
                    $('.map_form_check').prop('disabled', false);
                    $('.map_checkView, #map_btn_save').show();
                    var checklist_task = f_get_general_info_multiple('t_checklist_task', {wfTask_id:$('#map_wfTask_id').val(), checklistTask_status:'1'});
                    $.each(checklist_task, function(u){
                        $('#map_check_remark_'+checklist_task[u].checklist_id).val(checklist_task[u].checklistTask_remark);
                        if (checklist_task[u].checklistTask_result == '1')
                            $("input[name='map_check_pass_"+checklist_task[u].checklist_id+"']").prop('checked', true);
                        map_total_section[u] = checklist_task[u].checklist_id;
                    });    
                }
            }      
            $('#modal_consultant_pems').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>