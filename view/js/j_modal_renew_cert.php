<script type="text/javascript">  
    
    var mbc_otable;
    var mbc_load_type;
    var mbc_1st_load = true;
    var mbc_otable_history;
    var data_mbc_history;
    
    $(document).ready(function () {
        
        $('#mbc_certificate_dateExpired').datepicker({
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
                $('#form_mbc_form').bootstrapValidator('revalidateField', 'mbc_certificate_dateExpired');
            }
        });
        
        $('#form_mbc_form').bootstrapValidator({    
            excluded: ':disabled',
            fields: {  
                mbc_certificate_no : {
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
                mbc_certIssuer_id : {
                    validators: {
                        notEmpty: {
                            message: 'Certificate Issuer is required'
                        }
                    }
                },
                mbc_certificate_dateExpired : {
                    validators: {
                        notEmpty: {
                            message: 'Expired Date is required'
                        }
                    }
                }
            }
        });
        
        $('#mbc_certIssuer_id').on('change', function() {
            var is_enabled = $(this).val() != '3';
            $('#form_mbc_form').bootstrapValidator('enableFieldValidators', 'mbc_certificate_dateExpired', is_enabled)
                .bootstrapValidator('enableFieldValidators', 'mbc_certificate_basic', is_enabled)
                .bootstrapValidator('enableFieldValidators', 'mbc_file_certificate', is_enabled);
            $('#form_mbc_form').bootstrapValidator('revalidateField', 'mbc_certificate_dateExpired')
                .bootstrapValidator('revalidateField', 'mbc_certificate_basic')
                .bootstrapValidator('revalidateField', 'mbc_file_certificate');
        });    
                
        $('#mbc_snote_wfTask_remark').summernote({
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
                    $('#mbc_wfTask_remark').val(contents);
                }
            }
        });
        
        $('#form_mbc_form_2').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mbc_file_certificate : {
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
        
        var datatable_mbc_history = undefined; 
        mbc_otable_history = $('#datatable_mbc_history').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mbc_history) {
                    datatable_mbc_history = new ResponsiveDatatablesHelper($('#datatable_mbc_history'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mbc_history.createExpandIcon(nRow);
                var info = mbc_otable_history.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mbc_history.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'wfTaskType_name'},
                    {mData: 'status_desc'},
                    {mData: 'claimed_by'},
                    {mData: 'wfTask_timeSubmitted'},
                    {mData: 'wfTask_remark'}
                ]
        });
        
        $('#mbc_btn_add_certificate').on('click', function () {
            var bootstrapValidator = $("#form_mbc_form_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mbc_form_2')[0]);
                    formData.append('funct', 'save_certificate_doc');
                    formData.append('mbc_certificate_id', $('#mbc_certificate_id').val());
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
                                f_notify(1, 'Success', 'Certificate Attachment successfully added.');
                                $('#form_mbc_form_2').trigger('reset');
                                $('#form_mbc_form_2').bootstrapValidator('resetForm', true);
                                var html = '<a href="process/download.php?doc_id='+resp.result.document_id+'">'+resp.result.document_uplname+'</a>';
                                $('#mbc_div_certDoc').html(html);
                                $('#lmbc_document_uplname_link').html(html);
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
        
        $('#mbc_snote_wfTask_verify').summernote({
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
                    $('#form_mbc_verify').bootstrapValidator('revalidateField', 'mbc_snote_wfTask_verify');
                    $('#mbc_snote_wfTask_verify').val(contents);
                }
            }
        });
        
        $('#form_mbc_verify').bootstrapValidator({   
            excluded: ':disabled',
            fields: {  
                mbc_result : {
                    validators : {
                        notEmpty: {
                            message: 'Verification Result is required'
                        }                     
                    }
                },
                mbc_snote_wfTask_verify : {
                    validators: {
                        callback: {
                            message: 'Message/feedback is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mbc_snote_wfTask_verify"]').summernote('code');
                                var check = $('input[name="mbc_result"]:checked').val();
                                return (typeof check !== 'undefined' && check == '18') ? true : (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('input[name="mbc_result"]').on('click', function () {  
            $('#form_mbc_verify').bootstrapValidator('revalidateField', 'mbc_snote_wfTask_verify');
        });
        
        $('#mbc_btn_save').on('click', function () {
            $('#modal_waiting').on('shown.bs.modal', function(e){   
                if (mbc_otable == 'cac' && $('#mbc_wfTaskType_id').val() == '81') {
                    $('#mbc_funct').val('save_certificate_renewal');
                    $('#mbc_wfTask_remark').val($('[name="mbc_snote_wfTask_remark"]').summernote('code'));
                    f_submit_forms('form_mbc,#form_mbc_form,#form_mbc_form_3', 'p_registration', 'Data successfully saved.');
                    f_get_general_info('vw_certificate_details', {certificate_id:$('#mbc_certificate_id').val()}, 'mbc');
                    var certificate_basic = f_get_general_info_multiple('t_certificate_basic_list', {certificate_id:$('#mbc_certificate_id').val()});
                    $.each(certificate_basic, function(u){
                        $("input[name='mbc_certBasic_id[]'][value=" + certificate_basic[u].certBasic_id + "]").prop('checked', true);
                    });
                    f_table_cac_new ();
                } else if (mbc_otable == 'cvc' && $('#mbc_wfTaskType_id').val() == '82') {
                    $('#mbc_funct').val('save_certificate_verify');
                    $('#mbc_wfTask_verify').val($('[name="mbc_snote_wfTask_verify"]').summernote('code'));
                    f_submit_forms('form_mbc,#form_mbc_verify', 'p_registration', 'Data successfully saved.');
                } else {
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        });
        
        $('#mbc_btn_submit').on('click', function () {
            var submit_status = '', submit_group = '', condition_no = '';
            if (mbc_otable == 'cac' && $('#mbc_wfTaskType_id').val() == '81') {
                var bootstrapValidator = $("#form_mbc_form").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mbc_funct').val('save_certificate_renewal');
                $('#mbc_wfTask_remark').val($('[name="mbc_snote_wfTask_remark"]').summernote('code'));
                if (f_submit_forms('form_mbc,#form_mbc_form,#form_mbc_form_3', 'p_registration')){
                    f_get_general_info('vw_certificate_details', {certificate_id:$('#mbc_certificate_id').val()}, 'mbc');
                    var certificate_basic = f_get_general_info_multiple('t_certificate_basic_list', {certificate_id:$('#mbc_certificate_id').val()});
                    $.each(certificate_basic, function(u){
                        $("input[name='mbc_certBasic_id[]'][value=" + certificate_basic[u].certBasic_id + "]").prop('checked', true);
                    }); 
                    f_table_cac_new ();                     
                    $.SmartMessageBox({
                        title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                        content : "Are you sure to submit this Certificate Renewal?",
                        buttons : '[No][Yes]'
                    }, function(ButtonPressed) {
                        if (ButtonPressed === "Yes") {
                            $('#modal_waiting').on('shown.bs.modal', function(e){   
                                if ($('#mbc_wfTask_status').val() == '2') {
                                    submit_status = '10';
                                    submit_group = $('#mbc_wfGroup_id').val();
                                } else if ($('#mbc_wfTask_status').val() == '22') {
                                    submit_status = '13';
                                } else {  
                                    f_notify(2, 'Error', errMsg_default);    
                                    return false;
                                }
                                if (f_submit($('#mbc_wfTask_id').val(), $('#mbc_wfTaskType_id').val(), submit_status, 'The Certificate Renewal successfully submitted', $('#mbc_wfTask_remark').val(), '', submit_group, '', $('#mbc_wfTask_refName').val(), $('#mbc_wfTask_refValue').val())) {
                                    f_table_cac_new (); 
                                    f_send_email('email_certRenewal_verify', {wfTask_id:result_submit_task}); 
                                    $('#modal_renew_cert').modal('hide');
                                }
                                $('#modal_waiting').modal('hide');
                                $(this).unbind(e);
                            }).modal('show'); 
                        }
                    });    
                }          
            } else if (mbc_otable == 'cvc' && $('#mbc_wfTaskType_id').val() == '82') {
                var bootstrapValidator = $("#form_mbc_verify").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mbc_funct').val('save_certificate_verify');
                $('#mbc_wfTask_verify').val($('[name="mbc_snote_wfTask_verify"]').summernote('code'));
                if (f_submit_forms('form_mbc,#form_mbc_verify', 'p_registration')){
                    $.SmartMessageBox({
                        title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                        content : "Are you sure?",
                        buttons : '[No][Yes]'
                    }, function(ButtonPressed) {
                        if (ButtonPressed === "Yes") {
                            $('#modal_waiting').on('shown.bs.modal', function(e){   
                                submit_status = $('input[name="mbc_result"]:checked').val();
                                if (submit_status == '12') 
                                    condition_no = '1';
                                if (f_submit($('#mbc_wfTask_id').val(), $('#mbc_wfTaskType_id').val(), submit_status, 'The verification result submitted', $('#mbc_wfTask_verify').val(), condition_no, '', '', $('#mbc_wfTask_refName').val(), $('#mbc_wfTask_refValue').val())) {
                                    f_table_cvc_new ();
                                    f_table_cvc_history ();
                                    f_send_email('email_certRenewal_result', {wfTask_id:$("#mbc_wfTask_id").val()}); 
                                    $('#modal_renew_cert').modal('hide');
                                }
                                $('#modal_waiting').modal('hide');
                                $(this).unbind(e);
                            }).modal('show'); 
                        }
                    });
                }
            } else {  
                f_notify(2, 'Error', errMsg_default);    
                return false;
            }
        });
        
    });    
    
    function f_load_renew_cert (load_type, certificate_id, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (mbc_1st_load) {   
                var certificate_basic = f_get_general_info_multiple('t_certificate_basic', {certBasic_status:'1'}, {}, '', 'certBasic_id');
                $.each(certificate_basic, function(u){
                    var html = '<div class="checkbox"><label>';
                    html += '<input type="checkbox" class="checkbox" name="mbc_certBasic_id[]" value="'+certificate_basic[u].certBasic_id+'">';
                    html += '<span>'+certificate_basic[u].certBasic_desc+'</span>';
                    html += '</label></div>';
                    $('#mbc_div_certBasic_id').append(html);
                });                                
                var bootstrapValidator = $("#form_mbc_form").data('bootstrapValidator');
                bootstrapValidator.addField('mbc_certBasic_id[]', {validators:{choice:{min:1,message:'At least 1 Basic of Certification required'}}});
                bootstrapValidator.addField('mbc_certBasic_id[]', {
                    validators:{
                        callback: {
                            message: 'Basic of Certification must have EN-15267-3',
                            callback: function (value, validator, $field) { return $("input[name='mbc_certBasic_id[]'][value=3]").is(':checked'); }
                        }
                    }
                });
                mbc_1st_load = false;
            }
            if (certificate_id == '') {
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
                f_notify(2, 'Error', errMsg_default);    
                return false;
            }
            $('#form_mbc, #form_mbc_form, #form_mbc_form_2, #form_mbc_form_3, #form_mbc_verify').trigger('reset');  
            $('#mbc_snote_wfTask_remark').summernote('code', '');
            $('#mbc_snote_wfTask_remark').summernote('disable');
            $('#form_mbc_form').bootstrapValidator('resetForm', true);   
            $('#form_mbc_form_2').bootstrapValidator('resetForm', true);
            $('#mbc_load_type').val(load_type);
            mbc_otable = otable;
            mbc_load_type = load_type;
            $('#form_mbc_form, #form_mbc_form_2, #form_mbc_form_3').find('input, textarea, select').prop('disabled',true);
            $('#mbc_alert_box, #mbc_div_certDocField, .mbc_hide_view, .mbc_div_verify').hide();
            if (mbc_load_type == 1) {   
                if (!f_submit_normal('create_certificate_renewal', {certificate_id:certificate_id}, 'p_registration', '', errMsg_default))   return false;
                certificate_id = result_submit.certificate_id;
                wfTask_id = result_submit.wfTask_id;
                if (mbc_otable == 'cac') {
                    f_table_cac_new ();
                    f_cac_certificate_bar ();
                }
                mbc_load_type = 2;
            } 
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'mbc');  
            var arr_steps = f_get_general_info_multiple('wf_task_type', {wfFlow_id:task_info.wfFlow_id});
            var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:task_info.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
            var wfTaskType_turn = task_info.wfTaskType_turn != '0' ? task_info.wfTaskType_turn : f_get_value_from_table('wf_task_type', 'wfTaskType_id', previous_task[0].wfTaskType_id, 'wfTaskType_turn');
            f_steps (arr_steps, wfTaskType_turn, 'mbc_steps'); 
            var status = load_type <= 2 ? '1' : '';
            get_option('mbc_certIssuer_id', status, 't_certificate_issuer', 'certIssuer_id', 'certIssuer_desc', 'certIssuer_status', ' ', 'ref_id');            
            var certificate_detail = f_get_general_info('vw_certificate_details', {certificate_id:certificate_id}, 'mbc');
            var certificate_basic = f_get_general_info_multiple('t_certificate_basic_list', {certificate_id:certificate_id});
            $.each(certificate_basic, function(u){
                $("input[name='mbc_certBasic_id[]'][value=" + certificate_basic[u].certBasic_id + "]").prop('checked', true);
            });
            $('[name="mbc_snote_wfTask_remark"]').summernote('code', certificate_detail.certificate_remark);
            $('#mbc_div_certDoc').html('-');
            if (certificate_detail.document_id != null) {
                var html = '<a href="process/download.php?doc_id='+certificate_detail.document_id+'">'+certificate_detail.document_uplname+'</a>';
                $('#mbc_div_certDoc').html(html);
                $('#lmbc_document_uplname_link').html(html);
            }
            data_mbc_history = f_get_general_info_multiple('dt_task_history', {wfTrans_id:task_info.wfTrans_id}, '', '', 'wfTask_id');
            f_dataTable_draw(mbc_otable_history, data_mbc_history, 'datatable_mbc_history', 6);      
            if (mbc_load_type == 2) {   
                if (previous_task != '' && previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {
                    $('#mbc_alert_box').show();
                    $('#mbc_alert_message').html(previous_task[0].wfTask_remark);
                    var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                    $('#mbc_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                }      
                $('.mbc_hide_view').show();
                if (mbc_otable == 'cac' && $('#mbc_wfTaskType_id').val() == '81') {
                    $('#form_mbc_form, #form_mbc_form_2, #form_mbc_form_3').find('input, textarea, select').prop('disabled',false);
                    $('#mbc_snote_wfTask_remark').summernote('enable');
                    $('#mbc_div_certDocField').show();
                } else if (mbc_otable == 'cvc' && $('#mbc_wfTaskType_id').val() == '82') {
                    $('[name="mbc_snote_wfTask_verify"]').summernote('code', task_info.wfTask_remark);
                    $('#form_mbc_verify').bootstrapValidator('resetForm', true);
                    $("input[name='mbc_result'][value=" + task_info.wfTask_statusSave + "]").prop('checked', true);
                    $('.mbc_div_verify').show();
                }
            }
            $('#mbc_wfTask_id').val(wfTask_id); 
            $('#mbc_certificate_id').val(certificate_id); 
            $('#modal_renew_cert').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
</script>