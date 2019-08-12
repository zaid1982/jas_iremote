<script src="js/plugin/summernote/summernote.min.js"></script>

<script type="text/javascript">
        
    var mqf_otable;
    var mqf_load_type;
    var mqf_otable_history;
    var data_mqf_history;
    var mqf_otable_qnfDoc;
    var data_mqf_qnfDoc;
    
    $(document).ready(function () {
                             
        $("#form_mqf").on('submit', function (event) {
            event.preventDefault();
        });
        
        $('#mqf_snote_qnf_message').summernote({
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
                    $('#form_mqf_form').bootstrapValidator('revalidateField', 'mqf_snote_qnf_message');
                    $('#mqf_qnf_message').val(contents);
                }
            }
        });   
        
        $('#form_mqf_form').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mqf_qnf_title : {
                    validators: {
                        notEmpty: {
                            message: 'Title is required'
                        },
                        stringLength : {
                            max : 255,
                            message : 'Title must be not more than 255 characters long'
                        }
                    }
                },
                mqf_qnfCate_id : {
                    validators: {
                        notEmpty: {
                            message: 'Category is required'
                        }
                    }
                },
                mqf_snote_qnf_message : {
                    validators: {
                        callback: {
                            message: 'Message is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mqf_snote_qnf_message"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#form_mqf_form_2').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mqf_supDoc_file: {
                    validators: {
                        notEmpty: {
                            message: 'Supporting Attachment File is required'
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: '20000000',
                            message: 'Only PDF file format max 20MB allowed.'
                        }
                    }
                },
                mqf_supDoc_name : {
                    validators: {
                        notEmpty: {
                            message: 'Supporting Attachment Name is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Supporting Attachment Name must be not more than 30 characters long'
                        }
                    }
                }
            }
        });
        
        var datatable_mqf_qnfDoc = undefined; 
        mqf_otable_qnfDoc = $('#datatable_mqf_qnfDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqf_qnfDoc) {
                    datatable_mqf_qnfDoc = new ResponsiveDatatablesHelper($('#datatable_mqf_qnfDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqf_qnfDoc.createExpandIcon(nRow);
                var info = mqf_otable_qnfDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mqf_qnfDoc.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'document_name'},
                    {mData: 'document_uplname'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.document_id != null)
                                $label += '<a type="button" class="btn btn-success btn-xs" title="Download Support Document" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            $label += ' <button type="button" class="btn btn-danger btn-xs mqf_hide_view" title="Delete" onclick="f_mqf_delete_qnfDoc ('+row.qnfDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#mqf_btn_add_supDoc').on('click', function () {
            var bootstrapValidator = $("#form_mqf_form_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mqf_form_2')[0]);
                    formData.append('funct', 'save_qnf_doc');
                    formData.append('mqf_qnf_id', $('#mqf_qnf_id').val());
                    $.ajax({
                        url: "process/p_maintenance.php",
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
                                f_notify(1, 'Success', 'Supporting Document successfully added.');
                                $('#form_mqf_form_2').trigger('reset');
                                $('#form_mqf_form_2').bootstrapValidator('resetForm', true);
                                data_mqf_qnfDoc = f_get_general_info_multiple('dt_qnf_document', {qnf_id:$('#mqf_qnf_id').val()}, '', '', 'qnfDoc_id');
                                f_dataTable_draw(mqf_otable_qnfDoc, data_mqf_qnfDoc, 'datatable_mqf_qnfDoc', 4);
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
        
        $('#mqf_snote_wfTask_remark').summernote({
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
                    $('#form_mqf_action').bootstrapValidator('revalidateField', 'mqf_snote_wfTask_remark');
                    $('#mqf_wfTask_remark').val(contents);
                }
            }
        });   
        
        $('#form_mqf_action').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mqf_wfTrans_processOfficer : {
                    validators : {
                        callback: {
                            message: 'Delegate To is required',
                            callback: function(value, validator, $field) {
                                var check = $('input[name="mqf_result"]:checked').val(); 
                                return $('#mqf_wfTaskType_id').val() == '73' &&  check == '38' ? (value !== '') : true;
                            }
                        }                     
                    }
                },
                mqf_result : {
                    validators : {
                        notEmpty: {
                            message: 'Result is required'
                        }                     
                    }
                },
                mqf_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mqf_snote_wfTask_remark"]').summernote('code');
                                var check = $('input[name="mqf_result"]:checked').val();    
                                return typeof check !== 'undefined' && check == '38' ? true : (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('input[name="mqf_result"]').on('click', function () {
            $('#form_mqf_action').bootstrapValidator('revalidateField', 'mqf_snote_wfTask_remark');
            var check = $('input[name="mqf_result"]:checked').val();  
            if (check != '38') 
                $('#mqf_wfTrans_processOfficer').val('');
            $('#form_mqf_action').bootstrapValidator('resetField', 'mqf_wfTrans_processOfficer', true); 
            $('#mqf_wfTrans_processOfficer').prop('disabled', check != '38');
            $('#form_mqf_action').bootstrapValidator('enableFieldValidators', 'mqf_wfTrans_processOfficer', check == '38');
            $('#form_mqf_action').bootstrapValidator('revalidateField', 'mqf_wfTrans_processOfficer'); 
        }); 
        
        var datatable_mqf_history = undefined; 
        mqf_otable_history = $('#datatable_mqf_history').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqf_history) {
                    datatable_mqf_history = new ResponsiveDatatablesHelper($('#datatable_mqf_history'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqf_history.createExpandIcon(nRow);
                var info = mqf_otable_history.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mqf_history.respond();
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
        
        $('#mqf_snote_wfTask_respond').summernote({
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
                    $('#form_mqf_respond').bootstrapValidator('revalidateField', 'mqf_snote_wfTask_respond');
                    $('#mqf_wfTask_respond').val(contents);
                }
            }
        });   
        
        $('#form_mqf_respond').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mqf_snote_wfTask_respond : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mqf_snote_wfTask_respond"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#mqf_btn_save').on('click', function () {
            $('#modal_waiting').on('shown.bs.modal', function(e){ 
                if (mqf_otable == 'qfp' && $('#mqf_wfTaskType_id').val() == '72') {
                    if ($('#mqf_wfTask_status').val() == '2') {
                        $('#mqf_funct').val('save_qnf_post');
                        $('#mqf_qnf_message').val($('[name="mqf_snote_qnf_message"]').summernote('code'));
                        f_submit_forms('form_mqf,#form_mqf_form', 'p_maintenance', 'Data successfully saved.');
                        f_table_qfp_new ();
                    } else if ($('#mqf_wfTask_status').val() == '22' || $('#mqf_wfTask_status').val() == '44') {
                        $('#mqf_funct').val('save_qnf_reply');
                        $('#mqf_wfTask_respond').val($('[name="mqf_snote_wfTask_respond"]').summernote('code'));
                        f_submit_forms('form_mqf,#form_mqf_respond', 'p_maintenance', 'Data successfully saved.');
                    }
                } else if (mqf_otable == 'qfd' && $('#mqf_wfTaskType_id').val() == '73') {
                    $('#mqf_funct').val('save_qnf_delegate');
                    $('#mqf_wfTask_remark').val($('[name="mqf_snote_wfTask_remark"]').summernote('code'));
                    f_submit_forms('form_mqf,#form_mqf_action', 'p_maintenance', 'Data successfully saved.');
                } else if (mqf_otable == 'qff' && $('#mqf_wfTaskType_id').val() == '74') {
                    $('#mqf_funct').val('save_qnf_feedback');
                    $('#mqf_wfTask_remark').val($('[name="mqf_snote_wfTask_remark"]').summernote('code'));
                    f_submit_forms('form_mqf,#form_mqf_action', 'p_maintenance', 'Data successfully saved.');
                }
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show');
        });   
        
        $('#mqf_btn_submit').on('click', function () {
            var submit_status = '', submit_group = '', condition_no = '';
            if (mqf_otable == 'qfp' && $('#mqf_wfTaskType_id').val() == '72') {
                if ($('#mqf_wfTask_status').val() == '2') {
                    var bootstrapValidator = $("#form_mqf_form").data('bootstrapValidator');
                    bootstrapValidator.validate();
                    if (!bootstrapValidator.isValid()) {         
                        f_notify(2, 'Error', errMsg_validation);    
                        return false;
                    }
                    $('#mqf_funct').val('save_qnf_post');
                    $('#mqf_qnf_message').val($('[name="mqf_snote_qnf_message"]').summernote('code'));
                    if (f_submit_forms('form_mqf,#form_mqf_form', 'p_maintenance')){
                        f_table_qfp_new ();
                        $.SmartMessageBox({
                            title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                            content : "Are you sure to submit this Inquiry?",
                            buttons : '[No][Yes]'
                        }, function(ButtonPressed) {
                            if (ButtonPressed === "Yes") {
                                $('#modal_waiting').on('shown.bs.modal', function(e){  
                                    submit_status = '10';
                                    submit_group = $('#mqf_wfGroup_id').val();
                                    if (f_submit($('#mqf_wfTask_id').val(), $('#mqf_wfTaskType_id').val(), submit_status, 'Your Inquiry successfully submitted', '', condition_no, submit_group, '', $('#mqf_wfTask_refName').val(), $('#mqf_wfTask_refValue').val())) {
                                        f_table_qfp_new (); 
                                        f_send_email('email_qnf_delegate', {wfTask_id:result_submit_task});
                                        $('#modal_qnf').modal('hide');
                                    }
                                    $('#modal_waiting').modal('hide');
                                    $(this).unbind(e);
                                }).modal('show'); 
                            }
                        });    
                    } 
                } else if ($('#mqf_wfTask_status').val() == '22' || $('#mqf_wfTask_status').val() == '44') {
                    var bootstrapValidator = $("#form_mqf_respond").data('bootstrapValidator');
                    bootstrapValidator.validate();
                    if (!bootstrapValidator.isValid()) {         
                        f_notify(2, 'Error', errMsg_validation);    
                        return false;
                    }
                    $('#mqf_funct').val('save_qnf_reply');
                    $('#mqf_wfTask_respond').val($('[name="mqf_snote_wfTask_respond"]').summernote('code'));
                    if (f_submit_forms('form_mqf,#form_mqf_respond', 'p_maintenance')){
                        $.SmartMessageBox({
                            title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                            content : "Are you sure?",
                            buttons : '[No][Yes]'
                        }, function(ButtonPressed) {
                            if (ButtonPressed === "Yes") {
                                $('#modal_waiting').on('shown.bs.modal', function(e){
                                    if ($('#mqf_wfTask_status').val() == '22') {
                                        submit_status = '42';
                                    } else if ($('#mqf_wfTask_status').val() == '44') {
                                        submit_status = '42';
                                        condition_no = '1';
                                    } 
                                    if (f_submit($('#mqf_wfTask_id').val(), $('#mqf_wfTaskType_id').val(), submit_status, 'Your Inquiry Reply successfully submitted', $('#mqf_wfTask_respond').val(), condition_no, submit_group, '', $('#mqf_wfTask_refName').val(), $('#mqf_wfTask_refValue').val())) {
                                        f_table_qfp_new (); 
                                        f_send_email('email_qnf_reply', {wfTask_id:result_submit_task}); 
                                        $('#modal_qnf').modal('hide');
                                    }
                                    $('#modal_waiting').modal('hide');
                                    $(this).unbind(e);
                                }).modal('show'); 
                            }
                        });    
                    } 
                }
            } else if (mqf_otable == 'qfd' && $('#mqf_wfTaskType_id').val() == '73') {
                var bootstrapValidator = $("#form_mqf_action").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mqf_funct').val('save_qnf_delegate');
                $('#mqf_wfTask_remark').val($('[name="mqf_snote_wfTask_remark"]').summernote('code'));
                if (f_submit_forms('form_mqf,#form_mqf_action', 'p_maintenance')){
                    $.SmartMessageBox({
                        title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                        content : "Are you sure?",
                        buttons : '[No][Yes]'
                    }, function(ButtonPressed) {
                        if (ButtonPressed === "Yes") {
                            $('#modal_waiting').on('shown.bs.modal', function(e){   
                                var wf_group_user;
                                var assigned_user = '';
                                submit_status = $('input[name="mqf_result"]:checked').val();
                                if (submit_status == '12') {
                                    condition_no = '2';
                                } else if (submit_status == '40') {
                                    condition_no = '3';
                                } else if (submit_status == '38') {
                                    wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#mqf_wfTrans_processOfficer').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
                                    submit_group = wf_group_user.wfGroup_id;
                                    assigned_user = $('#mqf_wfTrans_processOfficer').val();
                                }
                                if (f_submit($('#mqf_wfTask_id').val(), $('#mqf_wfTaskType_id').val(), submit_status, 'The Inquiry successfully submitted', $('#mqf_wfTask_remark').val(), condition_no, submit_group, assigned_user, $('#mqf_wfTask_refName').val(), $('#mqf_wfTask_refValue').val())) {
                                    f_table_qfd_new (); 
                                    f_table_qfd_history ();
                                    if (submit_status == '12') {
                                        f_send_email('email_qnf_return', {wfTask_id:result_submit_task}); 
                                    } else if (submit_status == '40') {
                                        f_send_email(($('#mqf_qnf_postType').val()=='1'?'email_qnf_resolve':'email_qnf_resolve_external'), {wfTask_id:$('#mqf_wfTask_id').val()}); 
                                    } else if (submit_status == '38') {
                                        f_send_email('email_qnf_feedback', {wfTask_id:result_submit_task}); 
                                    }
                                    $('#modal_qnf').modal('hide');
                                }
                                $('#modal_waiting').modal('hide');
                                $(this).unbind(e);
                            }).modal('show'); 
                        }
                    });    
                }
            } else if (mqf_otable == 'qff' && $('#mqf_wfTaskType_id').val() == '74') {
                var bootstrapValidator = $("#form_mqf_action").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mqf_funct').val('save_qnf_feedback');
                $('#mqf_wfTask_remark').val($('[name="mqf_snote_wfTask_remark"]').summernote('code'));
                if (f_submit_forms('form_mqf,#form_mqf_action', 'p_maintenance')){
                    $.SmartMessageBox({
                        title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                        content : "Are you sure?",
                        buttons : '[No][Yes]'
                    }, function(ButtonPressed) {
                        if (ButtonPressed === "Yes") {
                            $('#modal_waiting').on('shown.bs.modal', function(e){   
                                submit_status = $('input[name="mqf_result"]:checked').val();
                                if (submit_status == '12') {
                                    condition_no = '2';
                                } else if (submit_status == '40') {
                                    //
                                } else if (submit_status == '45') {
                                    condition_no = '3';
                                }
                                if (f_submit($('#mqf_wfTask_id').val(), $('#mqf_wfTaskType_id').val(), submit_status, 'The Inquiry successfully submitted', $('#mqf_wfTask_remark').val(), condition_no, '', '', $('#mqf_wfTask_refName').val(), $('#mqf_wfTask_refValue').val())) {
                                    f_table_qff_new (); 
                                    f_table_qff_history ();
                                    if (submit_status == '12') {
                                        f_send_email('email_qnf_return', {wfTask_id:result_submit_task}); 
                                    } else if (submit_status == '40') {
                                        f_send_email(($('#mqf_qnf_postType').val()=='1'?'email_qnf_resolve':'email_qnf_resolve_external'), {wfTask_id:$('#mqf_wfTask_id').val()}); 
                                    } else if (submit_status == '45') {
                                        f_send_email('email_qnf_return_internal', {wfTask_id:result_submit_task}); 
                                    }
                                    $('#modal_qnf').modal('hide');
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
    
    function f_mqf_delete_qnfDoc (qnfDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_qnf_doc', {qnfDoc_id: qnfDoc_id}, 'p_maintenance', 'Data successfully deleted.')) {
                data_mqf_qnfDoc = f_get_general_info_multiple('dt_qnf_document', {qnf_id:$('#mqf_qnf_id').val()}, '', '', 'qnfDoc_id');
                f_dataTable_draw(mqf_otable_qnfDoc, data_mqf_qnfDoc, 'datatable_mqf_qnfDoc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_load_qnf (load_type, qnf_id, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mqf_form, #form_mqf_form_2, #form_mqf_action, #form_mqf_respond').trigger('reset'); 
            $('#form_mqf_form').bootstrapValidator('resetForm', true);
            $('#form_mqf_form_2').bootstrapValidator('resetForm', true);
            $('#form_mqf_action').bootstrapValidator('resetForm', true);
            $('#form_mqf_respond').bootstrapValidator('resetForm', true);
            $('#form_mqf_form, #form_mqf_form_2, #form_mqf_action, #form_mqf_respond').find('input, textarea, select').prop('disabled',true);
            $('#mqf_snote_qnf_message').summernote('code', '');
            $('#mqf_snote_qnf_message').summernote('disable');
            $('#mqf_snote_wfTask_remark').summernote('code', '');
            $('#mqf_snote_wfTask_respond').summernote('code', '');
            mqf_otable = otable;
            mqf_load_type = load_type;
            $('#mqf_alert_box, .mqf_div_action, #mqf_div_attach, .mqf_div_delegate_to, .mqf_show_delegate, .mqf_show_feedback, .mqf_div_respond').hide();
            $('#mqf_lbl_attach').show();
            if (mqf_load_type == 1) {  
                var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
                if (!f_submit_normal('create_qnf_internal', {wfGroup_id:wf_group_user.wfGroup_id}, 'p_maintenance', '', errMsg_default))   return false;
                qnf_id = result_submit.qnf_id;
                wfTask_id = result_submit.wfTask_id;
                if (mqf_otable == 'qfp') {
                    f_table_qfp_new ();
                }
                mqf_load_type = 2;
            }
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'mqf');  
            var arr_steps = f_get_general_info_multiple('wf_task_type', {wfFlow_id:task_info.wfFlow_id, wfTaskType_id:'>71'});
            var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:task_info.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
            var wfTaskType_turn = task_info.wfTaskType_turn != '0' ? task_info.wfTaskType_turn : f_get_value_from_table('wf_task_type', 'wfTaskType_id', previous_task[0].wfTaskType_id, 'wfTaskType_turn');
            f_steps (arr_steps, wfTaskType_turn, 'mqf_steps', task_info.wfTaskType_turn);             
            var status = load_type <= 2 ? '1' : '';
            get_option('mqf_qnfCate_id', status, 't_qnf_category', 'qnfCate_id', 'qnfCate_desc', 'qnfCate_status', ' ', 'ref_id');            
            var qnf_detail = f_get_general_info('vw_qnf_details', {qnf_id:qnf_id}, 'mqf');
            $('[name="mqf_snote_qnf_message"]').summernote('code', qnf_detail.qnf_message);
            data_mqf_qnfDoc = f_get_general_info_multiple('dt_qnf_document', {qnf_id:qnf_id}, '', '', 'qnfDoc_id');
            f_dataTable_draw(mqf_otable_qnfDoc, data_mqf_qnfDoc, 'datatable_mqf_qnfDoc', 4);
            data_mqf_history = f_get_general_info_multiple('dt_task_history', {wfTrans_id:task_info.wfTrans_id}, '', '', 'wfTask_id');
            f_dataTable_draw(mqf_otable_history, data_mqf_history, 'datatable_mqf_history', 6);
            $('.mqf_hide_view').hide();
            if (mqf_load_type == 2) { 
                if (previous_task != '' && previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {
                    $('#mqf_alert_box').show();
                    $('#mqf_alert_message').html(previous_task[0].wfTask_remark);
                    var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                    $('#mqf_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                }
                $('.mqf_hide_view').show();
                if (mqf_otable == 'qfp') {
                    if (task_info.wfTask_status == '2') {
                        $('#form_mqf_form, #form_mqf_form_2').find('input, textarea, select').prop('disabled',false);
                        $('#mqf_qnf_name').val(qnf_detail.profile_name).prop('disabled',true);
                        $('#mqf_qnf_contactNo').val(qnf_detail.profile_mobileNo).prop('disabled',true);
                        $('#mqf_qnf_email').val(qnf_detail.profile_email).prop('disabled',true);
                        $('#mqf_snote_qnf_message').summernote('enable');
                        $('#mqf_div_attach').show();
                        $('#mqf_lbl_attach').hide();
                    } else if (task_info.wfTask_status == '22' || task_info.wfTask_status == '44') {
                        $('#form_mqf_form_2, #form_mqf_respond').find('input, textarea, select').prop('disabled',false);
                        $('#mqf_snote_wfTask_respond').summernote('enable');
                        $('[name="mqf_snote_wfTask_respond"]').summernote('code', task_info.wfTask_remark);
                        $('#form_mqf_respond').bootstrapValidator('resetField', 'mqf_snote_wfTask_respond', true);
                        $('#mqf_div_attach, .mqf_div_respond').show();
                        $('#mqf_lbl_attach').hide();
                    }
                } else {  
                    $('#form_mqf_action').find('input, textarea, select').prop('disabled',false);
                    $('[name="mqf_snote_wfTask_remark"]').summernote('code', task_info.wfTask_remark);
                    $('#form_mqf_action').bootstrapValidator('resetField', 'mqf_snote_wfTask_remark', true);
                    $("input[name='mqf_result'][value=" + task_info.wfTask_statusSave + "]").prop('checked', true);
                    if (mqf_otable == 'qfd') {
                        $('.mqf_div_action, .mqf_div_delegate_to, .mqf_show_delegate').show();
                        $('#mqf_lbl_action').html('Delegate Inquiry');    
                        get_option('mqf_wfTrans_processOfficer', '74', 'task_assign', 'user_id', 'profile_name', '', '-- Please select Officer to give feedback --');
                        $('#mqf_wfTrans_processOfficer').val(qnf_detail.wfTrans_processOfficer);
                        var check = $('input[name="mqf_result"]:checked').val();  
                        $('#mqf_wfTrans_processOfficer').prop('disabled', check != '38');
                        $("input[name='mqf_result'][value=12]").prop('disabled', qnf_detail.qnf_postType=='2');
                    } else if (mqf_otable == 'qff') {
                        $('.mqf_div_action, .mqf_show_feedback').show();
                        $('#mqf_lbl_action').html('Feedback Inquiry');                        
                    }
                }
            }
            $('#mqf_wfTask_id').val(wfTask_id); 
            $('#mqf_qnf_id').val(qnf_id);         
            $('#modal_qnf').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
</script>