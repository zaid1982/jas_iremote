<script src="js/plugin/summernote/summernote.min.js"></script>

<script type="text/javascript">
        
    var mre_otable;
    var mre_load_type;
    var mre_otable_history;
    var data_mre_history;
    var mre_otable_viewDoc;
    var data_mre_viewDoc;
    var mre_otable_supportDoc;
    var data_mre_supportDoc;
    
    $(document).ready(function () {
                             
        $('#mre_snote_wfTask_remark').summernote({
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
                    $('#form_mre').bootstrapValidator('revalidateField', 'mre_snote_wfTask_remark');
                    $('#mre_snote_wfTask_remark').val(contents);
                }
            }
        });   
        
        $('#mre_snote_wfTask_verify').summernote({
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
                    $('#form_mre_verify').bootstrapValidator('revalidateField', 'mre_snote_wfTask_verify');
                    $('#mre_snote_wfTask_verify').val(contents);
                }
            }
        });   
                
        $('#form_mre').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mre_reasonFail_id : {
                    validators : {
                        notEmpty: {
                            message: 'Reason is required'
                        }                     
                    }
                },
                mre_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Message/feedback is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mre_snote_wfTask_remark"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#form_mre_2').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mre_supDoc_file: {
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
                mre_supDoc_name : {
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
        
        $('#form_mre_verify').bootstrapValidator({   
            excluded: ':disabled',
            fields: {  
                mre_result : {
                    validators : {
                        notEmpty: {
                            message: 'Verification Result is required'
                        }                     
                    }
                },
                mre_snote_wfTask_verify : {
                    validators: {
                        callback: {
                            message: 'Message/feedback is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mre_snote_wfTask_verify"]').summernote('code');
                                var check = $('input[name="mre_result"]:checked').val();
                                return (typeof check !== 'undefined' && check == '18') ? true : (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('input[name="mre_result"]').on('click', function () {  
            $('#form_mre_verify').bootstrapValidator('revalidateField', 'mre_snote_wfTask_verify');
        }); 
        
        var datatable_mre_history = undefined; 
        mre_otable_history = $('#datatable_mre_history').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mre_history) {
                    datatable_mre_history = new ResponsiveDatatablesHelper($('#datatable_mre_history'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mre_history.createExpandIcon(nRow);
                var info = mre_otable_history.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mre_history.respond();
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
        
        var datatable_mre_viewDoc = undefined; 
        mre_otable_viewDoc = $('#datatable_mre_viewDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mre_viewDoc) {
                    datatable_mre_viewDoc = new ResponsiveDatatablesHelper($('#datatable_mre_viewDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mre_viewDoc.createExpandIcon(nRow);
                var info = mre_otable_viewDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mre_viewDoc.respond();
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
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mre_supportDoc = undefined; 
        mre_otable_supportDoc = $('#datatable_mre_supportDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mre_supportDoc) {
                    datatable_mre_supportDoc = new ResponsiveDatatablesHelper($('#datatable_mre_supportDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mre_supportDoc.createExpandIcon(nRow);
                var info = mre_otable_supportDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mre_supportDoc.respond();
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
                            $label += ' <button type="button" class="btn btn-danger btn-xs mac_hideView" title="Delete" onclick="f_mre_delete_supportDoc ('+row.responseDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#mre_btn_add_supDoc').on('click', function () {
            var bootstrapValidator = $("#form_mre_2").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mre_2')[0]);
                    formData.append('funct', 'save_response_doc');
                    formData.append('mre_response_id', $('#mre_response_id').val());
                    formData.append('mre_response_type', $('#mre_response_type').val());
                    $.ajax({
                        url: "process/p_pooling.php",
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
                                $('#form_mre_2').trigger('reset');
                                $('#form_mre_2').bootstrapValidator('resetForm', true);
                                data_mre_supportDoc = f_get_general_info_multiple('dt_response_document', {response_id:$('#mre_response_id').val(), responseDoc_status:'2'}, '', '', 'response_id');
                                f_dataTable_draw(mre_otable_supportDoc, data_mre_supportDoc, 'datatable_mre_supportDoc', 4);
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
        
        $('#mre_btn_save').on('click', function () {
            $('#modal_waiting').on('shown.bs.modal', function(e){   
                if ((mre_otable == 'ipf' && $('#mre_wfTaskType_id').val() == '52') || (mre_otable == 'icf' && $('#mre_wfTaskType_id').val() == '62')) {
                    $('#mre_funct').val('save_fail_response');
                    $('#mre_wfTask_remark').val($('[name="mre_snote_wfTask_remark"]').summernote('code'));
                    f_submit_forms('form_mre', 'p_pooling', 'Data successfully saved.');
                } else if ((mre_otable == 'vpf' && $('#mre_wfTaskType_id').val() == '53') || (mre_otable == 'vcf' && $('#mre_wfTaskType_id').val() == '63')) {
                    $('#mre_funct').val('save_fail_response_verify');
                    $('#mre_wfTask_verify').val($('[name="mre_snote_wfTask_verify"]').summernote('code'));
                    f_submit_forms('form_mre,#form_mre_verify', 'p_pooling', 'Data successfully saved.');
                } else {
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show');
        }); 
        
        $('#mre_btn_submit').on('click', function () {  
            var submit_remark = '';
            if ((mre_otable == 'ipf' && $('#mre_wfTaskType_id').val() == '52') || (mre_otable == 'icf' && $('#mre_wfTaskType_id').val() == '62')) {
                var bootstrapValidator = $("#form_mre").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mre_funct').val('save_fail_response');
                $('#mre_wfTask_remark').val($('[name="mre_snote_wfTask_remark"]').summernote('code'));
                submit_remark = $('#mre_wfTask_remark').val();
            } else if ((mre_otable == 'vpf' && $('#mre_wfTaskType_id').val() == '53') || (mre_otable == 'vcf' && $('#mre_wfTaskType_id').val() == '63')) {
                var bootstrapValidator = $("#form_mre_verify").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mre_funct').val('save_fail_response_verify');
                $('#mre_wfTask_verify').val($('[name="mre_snote_wfTask_verify"]').summernote('code'));
                submit_remark = $('#mre_wfTask_verify').val();
            } else {  
                f_notify(2, 'Error', errMsg_default);    
                return false;
            }
            if (f_submit_forms('form_mre,#form_mre_verify', 'p_pooling')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {
                        $('#modal_waiting').on('shown.bs.modal', function(e){
                            var submit_wfGroup_id = '';
                            var submit_message = jQuery.inArray($('#mre_wfTaskType_id').val(), ['52','62']) >= 0 ? 'The report successfully submitted' : 'The verification result submitted';
                            var condition_no = '';
                            var submit_status = '';
                            if (jQuery.inArray($('#mre_wfTaskType_id').val(), ['52','62']) >= 0) {
                                submit_status = $('#mre_wfTask_status').val() == '22' ?  '13' : '10'; 
                                submit_wfGroup_id = $('#mre_wfGroup_id').val();
                            } else if (jQuery.inArray($('#mre_wfTaskType_id').val(), ['53','63']) >= 0) {
                                submit_status = $('input[name="mre_result"]:checked').val();
                                condition_no = submit_status == '12' ? '1' : '';
                            } else {  
                                f_notify(2, 'Error', errMsg_default);    
                                return false;
                            }
                            if (f_submit($('#mre_wfTask_id').val(), $('#mre_wfTaskType_id').val(), submit_status, submit_message, submit_remark, condition_no, submit_wfGroup_id, '', $('#mre_wfTask_refName').val(), $('#mre_wfTask_refValue').val())) {
                                if ($('#mre_wfTaskType_id').val() == '52') {
                                    if (mre_otable == 'ipf') {
                                        f_table_ipf_new ();
                                        f_table_ipf_history ();
                                    } 
                                    f_send_email('email_failReport_verify', {wfTask_id:result_submit_task}); 
                                } else if ($('#mre_wfTaskType_id').val() == '62') {
                                    if (mre_otable == 'icf') {
                                        f_table_icf_new ();
                                        f_table_icf_history ();
                                    } 
                                    f_send_email('email_failReport_verify', {wfTask_id:result_submit_task}); 
                                } else if ($('#mre_wfTaskType_id').val() == '53') {
                                    if (mre_otable == 'vpf') {
                                        f_table_vpf_new ();
                                        f_table_vpf_history ();
                                    }              
                                    f_send_email('email_failReport_user', {wfTask_id:$("#mre_wfTask_id").val()}); 
                                } else if ($('#mre_wfTaskType_id').val() == '63') {
                                    if (mre_otable == 'vcf') {
                                        f_table_vcf_new ();
                                        f_table_vcf_history ();
                                    }              
                                    f_send_email('email_failReport_user', {wfTask_id:$("#mre_wfTask_id").val()}); 
                                }        
                                $('#modal_mre').modal('hide');                        
                            }
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });
            }
        });
        
    });
    
    function f_mre_delete_supportDoc (responseDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_response_doc', {responseDoc_id: responseDoc_id}, 'p_pooling', 'Data successfully deleted.')) {
                data_mre_supportDoc = f_get_general_info_multiple('dt_response_document', {response_id:$('#mre_response_id').val(), responseDoc_status:'2'}, '', '', 'response_id');
                f_dataTable_draw(mre_otable_supportDoc, data_mre_supportDoc, 'datatable_mre_supportDoc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_load_mre (load_type, response_id, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mre, #form_mre_2, #form_mre_verify').trigger('reset');            
            $('#mre_snote_wfTask_remark').summernote('code', '');
            $('#mre_snote_wfTask_remark').summernote('disable');
            $('#form_mre').bootstrapValidator('resetForm', true);
            $('#form_mre_2').bootstrapValidator('resetForm', true);
            $('#mre_load_type').val(load_type);
            $('#mre_wfTask_id').val(wfTask_id); 
            $('#mre_response_id').val(response_id); 
            mre_otable = otable;
            mre_load_type = load_type;
            $('.mre_div_response').show();
            $('#mre_alert_box, .mre_hide_view, .mre_div_verify, #form_mre_2').hide();
            $('.mre_field_response').attr('disabled',true);
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'mre');  
            var arr_steps = f_get_general_info_multiple('wf_task_type', {wfFlow_id:task_info.wfFlow_id, wfTaskType_isEnd:'N'});
            var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:task_info.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
            var wfTaskType_turn = task_info.wfTaskType_turn != '0' ? task_info.wfTaskType_turn : f_get_value_from_table('wf_task_type', 'wfTaskType_id', previous_task[0].wfTaskType_id, 'wfTaskType_turn');
            f_steps (arr_steps, wfTaskType_turn, 'mre_steps');    
            var btn_type = task_info.wfTaskType_turn == '0' ? 'btn-info' : 'btn-default';
            var html = '<div class="process-step">' +
                '<button type="button" class="btn ' + btn_type + ' btn-circle" data-toggle="tab"><i class="fa fa-file-text fa-2x"></i></button>' +
                '<p><small>Close</p>' +
                '</div>';
            $('#mre_steps').append(html);
            var response_detail = f_get_general_info('vw_response_info', {response_id:response_id}, 'mre');     
            if (mre_otable == 'pof' || mre_otable == 'ipf' || mre_otable == 'vpf') {
                $('#mre_response_type').val('1');
                $('#mre_title').html('Fail Pooling Report');
                $('#lmre_label_issue_is').html('Total Data Received');
                $('#lmre_label_reason').html('Reason fail to send Data');
                $('#lmre_response_dataReceive').html(formattedNumber(response_detail.response_dataReceived)+' / '+formattedNumber(response_detail.response_dataNeeded));
                $('#lmre_response_issue').html((response_detail.response_dataReceived==null||response_detail.response_dataReceived=='0'?'Data Not Received':'Data Incomplete'));
            } else if (mre_otable == 'cpf' || mre_otable == 'icf' || mre_otable == 'vcf') {
                $('#mre_response_type').val('2');
                $('#mre_title').html('Excess Emission Report');
                $('#lmre_label_issue_is').html('Concentration Data');
                $('#lmre_label_reason').html('Reason Excess Emission');        
                $('#lmre_response_dataReceive').html(formattedNumber(response_detail.response_averageValue,3)+' / '+formattedNumber(response_detail.response_averageLimit));
                $('#lmre_response_issue').html(response_detail.complianceType_desc);
            }     
            if ((response_detail.response_status == '33' || response_detail.response_status == '22') && (mre_otable == 'ipf' || mre_otable == 'icf')) {
                $('#form_mre_2').show();
                $('.mre_field_response').attr('disabled',false);
                $('#mre_snote_wfTask_remark').summernote('enable');
            }
            data_mre_history = f_get_general_info_multiple('dt_task_history', {wfTrans_id:task_info.wfTrans_id}, '', '', 'wfTask_id');
            f_dataTable_draw(mre_otable_history, data_mre_history, 'datatable_mre_history', 6);
            data_mre_viewDoc = f_get_general_info_multiple('dt_response_document', {response_id:$('#mre_response_id').val(), responseDoc_status:'1'}, '', '', 'response_id');
            f_dataTable_draw(mre_otable_viewDoc, data_mre_viewDoc, 'datatable_mre_viewDoc', 4);
            $('[name="mre_snote_wfTask_remark"]').summernote('code', response_detail.response_message);
            get_option('mre_reasonFail_id', '1', 't_reason_fail', 'reasonFail_id', 'reasonFail_desc', 'reasonFail_status', ' ', 'ref_id', 'reasonFail_type', $('#mre_response_type').val()); 
            $('#form_mre').bootstrapValidator('enableFieldValidators', 'mre_reasonFail_id', jQuery.inArray($('#mre_wfTaskType_id').val(), ['52','62']) >= 0);
            $('#form_mre').bootstrapValidator('resetForm', true);
            $('#mre_reasonFail_id').val(response_detail.reasonFail_id); 
            if (mre_load_type == 2) {                
                if (previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {
                    $('#mre_alert_box').show();
                    $('#mre_alert_message').html('<i>(<b>Reason : </b>'+response_detail.reasonFail_desc+')</i></br>'+previous_task[0].wfTask_remark);
                    var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                    $('#mre_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                }
                data_mre_supportDoc = f_get_general_info_multiple('dt_response_document', {response_id:$('#mre_response_id').val(), responseDoc_status:'2'}, '', '', 'responseDoc_id');
                f_dataTable_draw(mre_otable_supportDoc, data_mre_supportDoc, 'datatable_mre_supportDoc', 4);
                $('.mre_hide_view').show();
                if (response_detail.response_status == '32' && jQuery.inArray(mre_otable, ['vpf','vcf']) >= 0) {    
                    $('[name="mre_snote_wfTask_verify"]').summernote('code', task_info.wfTask_remark);
                    $('#form_mre_verify').bootstrapValidator('resetForm', true);
                    $("input[name='mre_result'][value=" + task_info.wfTask_statusSave + "]").prop('checked', true);
                    $('.mre_div_verify').show();
                }
            }            
            if (response_detail.response_status == '33' && mre_otable != 'ipf' && mre_otable != 'icf')
                $('.mre_div_response').hide();
            $('#modal_mre').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
</script>