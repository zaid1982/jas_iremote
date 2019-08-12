<script type="text/javascript">
        
    var maw_otable;
    var maw_load_type;
    var maw_otable_history;    
    var data_maw_history;
    var maw_otable_checking;
    var data_maw_checking;
    var maw_otable_checking_view;
    var data_maw_checking_view;
    
    $(document).ready(function () {
                         
        $('#maw_snote_wfTask_remark').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']]
                //['insert', ['link', 'picture', 'hr']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#form_maw').bootstrapValidator('revalidateField', 'maw_snote_wfTask_remark');
                    $('#maw_snote_wfTask_remark').val(contents);
                }
            }
        }); 
                
        $('#form_maw').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                maw_assign_to : {
                    validators : {
                        callback: {
                            message: 'Assign To is required',
                            callback: function(value, validator, $field) {
                                return (jQuery.inArray($('#maw_wfTaskType_id').val(), ['2', '12', '22', '32', '42']) < 0) ? true : (value !== '');
                            }
                        }                     
                    }
                },
                maw_result : {
                    validators : {
                        callback: {
                            message: 'Result is required',
                            callback: function(value, validator, $field) {
                                var check = $('input[name="maw_result"]:checked').val(); 
                                return (jQuery.inArray($('#maw_wfTaskType_id').val(), ['2', '12', '22', '32', '42']) >= 0) ? true : (typeof check !== 'undefined');
                            }
                        }                          
                    }
                },
                maw_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Remark is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="maw_snote_wfTask_remark"]').summernote('code');
                                var check = $('input[name="maw_result"]:checked').val();    
                                return (jQuery.inArray($('#maw_wfTaskType_id').val(), ['2', '12', '22', '32', '42']) >= 0 || (typeof check !== 'undefined' && check == '10')) ? true : (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('input[name="maw_result"]').on('click', function () { 
            $('#form_maw').bootstrapValidator('revalidateField', 'maw_snote_wfTask_remark');
        }); 
        
        $('#maw_btn_save').on('click', function () {
            $('#modal_waiting').on('shown.bs.modal', function(e){
                $('#maw_funct').val('save_task_action');
                $('#maw_wfTask_remark').val($('[name="maw_snote_wfTask_remark"]').summernote('code'));
                f_submit_forms('form_maw', 'p_registration', 'Data successfully saved.');
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        }); 
        
        $('#maw_btn_submit').on('click', function () {    
            var bootstrapValidator = $("#form_maw").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
            $("#maw_funct").val('submit_task_action');
            $('#maw_wfTask_remark').val($('[name="maw_snote_wfTask_remark"]').summernote('code'));
            if (f_submit_forms('form_maw', 'p_registration')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {
                        $('#modal_waiting').on('shown.bs.modal', function(e){    
                            var assign_to = jQuery.inArray($('#maw_wfTaskType_id').val(), ['2', '12', '22', '32', '42']) >= 0 ? $('#maw_assign_to').val() : '';
                            var submit_status = jQuery.inArray($('#maw_wfTaskType_id').val(), ['2', '12', '22', '32', '42']) >= 0 ? '15' : $('input[name="maw_result"]:checked').val();
                            var condition_no = '';
                            if (submit_status == '11') {
                                if (jQuery.inArray($('#maw_wfTaskType_id').val(), ['3', '13', '23', '33', '43']) >= 0)
                                    submit_status = '26';
                                else
                                    condition_no = '2';
                            } else if (submit_status == '12') {
                                condition_no = '1';
                            } else if (submit_status == '10') {
                                if (jQuery.inArray($('#maw_wfTaskType_id').val(), ['3', '13', '23', '33', '43']) >= 0) submit_status = '25';
                                else if (jQuery.inArray($('#maw_wfTaskType_id').val(), ['4', '14', '24', '34', '44']) >= 0) submit_status = '17';
                                else if (jQuery.inArray($('#maw_wfTaskType_id').val(), ['5', '15', '25', '35', '45']) >= 0) submit_status = '18';                            
                            } else if (submit_status != '15') {
                                f_notify(2, 'Error', errMsg_validation);    
                                return false;
                            }
                            if (f_submit($('#maw_wfTask_id').val(), $('#maw_wfTaskType_id').val(), submit_status, 'The application successfully assigned and submitted.', $('#maw_wfTask_remark').val(), condition_no, $('#maw_wfGroup_id').val(), assign_to, $('#maw_wfTask_refName').val(), $('#maw_wfTask_refValue').val())) {
                                if (maw_otable == 'ctf') {
                                    f_send_email('email_process', {wfTask_id:result_submit_task}); 
                                    f_table_ctf_new ();
                                    f_table_ctf_history ();
                                } else if (maw_otable == 'ctp') {
                                    if (submit_status == '11')
                                        f_send_email('email_reject', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else if (submit_status == '12') 
                                        f_send_email('email_return', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else
                                        f_send_email('email_verify', {wfTask_id:result_submit_task});     
                                    f_table_ctp_new ();
                                    f_table_ctp_history ();
                                } else if (maw_otable == 'ctv') {
                                    if (submit_status == '11')
                                        f_send_email('email_reject', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else if (submit_status == '12') 
                                        f_send_email('email_revise', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else
                                        f_send_email('email_approval', {wfTask_id:result_submit_task});     
                                    f_table_ctv_new ();
                                    f_table_ctv_history ();
                                } else if (maw_otable == 'cta') {
                                    if (submit_status == '11')
                                        f_send_email('email_reject', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else if (submit_status == '12') 
                                        f_send_email('email_revise', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else
                                        f_send_email('email_approve', {wfTask_id:$("#maw_wfTask_id").val()});     
                                    f_table_cta_new ();
                                    f_table_cta_history ();
                                } else if (maw_otable == 'itf') {
                                    f_send_email('email_process', {wfTask_id:result_submit_task}); 
                                    f_table_itf_new ();
                                    f_table_itf_history ();
                                } else if (maw_otable == 'itp') {
                                    if (submit_status == '11')
                                        f_send_email('email_reject', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else if (submit_status == '12') 
                                        f_send_email('email_return', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else
                                        f_send_email('email_verify', {wfTask_id:result_submit_task});     
                                    f_table_itp_new ();
                                    f_table_itp_history ();
                                } else if (maw_otable == 'itv') {
                                    if (submit_status == '11')
                                        f_send_email('email_reject', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else if (submit_status == '12') 
                                        f_send_email('email_revise', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else
                                        f_send_email('email_approval', {wfTask_id:result_submit_task});     
                                    f_table_itv_new ();
                                    f_table_itv_history ();
                                } else if (maw_otable == 'ita') {
                                    if (submit_status == '11')
                                        f_send_email('email_reject', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else if (submit_status == '12') 
                                        f_send_email('email_revise', {wfTask_id:$("#maw_wfTask_id").val()}); 
                                    else
                                        f_send_email('email_approve', {wfTask_id:$("#maw_wfTask_id").val()});     
                                    f_table_ita_new ();
                                    f_table_ita_history ();
                                }
                                $('#modal_maw').modal('hide');
                            }                            
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });
            }
        });
        
        var datatable_maw_history = undefined;
        maw_otable_history = $('#datatable_maw_history').DataTable({
            iDisplayLength : 5,
            ordering: false,
            info: false,
            autoWidth: false,
            bFilter: false,
            bLengthChange: false,
            "preDrawCallback": function () {
                if (!datatable_maw_history) {
                    datatable_maw_history = new ResponsiveDatatablesHelper($('#datatable_maw_history'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_maw_history.createExpandIcon(nRow);
                var info = maw_otable_history.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_maw_history.respond();
            },
            "oTableTools": {
                "aButtons": [
                    {
                        "sExtends": "xls",
                        "sTitle": "iRemote_xls",
                        "mColumns": "all"
                    },
                    {
                        "sExtends": "pdf",
                        "sTitle": "iRemote_pdf",
                        "sPdfMessage": "iRemote PDF Export",
                        "sPdfSize": "letter",
                        "sPdfOrientation": "landscape",
                        "mColumns": "visible"
                    },
                    {
                        "sExtends": "print",
                        "sTitle": "iRemote_print",
                        "sMessage": "iRemote System"
                    }
                ],
               "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "aoColumns":
                [
                    {mData: null, bSortable: false, sClass: 'text-center'},
                    {mData: 'wfTaskType_name'},
                    {mData: 'status_desc'},
                    {mData: 'wfGroup_name'},
                    {mData: 'claimed_by'},
                    {mData: 'wfTask_timeCreated'},
                    {mData: 'wfTask_timeSubmitted'},
                    {mData: 'wfTask_dateExpired'},
                    {mData: 'wfTask_remark'}
                ]
        });
        $('#datatable_maw_history tbody').delegate('tr', 'mouseenter', function (evt) {
            var $cell=$(evt.target).closest('td');
            $cell.css( 'cursor', 'pointer' );             
        });    
        
        var datatable_maw_checking = undefined; 
        maw_otable_checking = $('#datatable_maw_checking').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_maw_checking) {
                    datatable_maw_checking = new ResponsiveDatatablesHelper($('#datatable_maw_checking'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_maw_checking.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_maw_checking.respond();
            },
            "aoColumns":
                [
                    {mData: 'checklist_section'},
                    {mData: 'checklist_desc'},
                    {mData: 'checklistTask_result', sClass: 'text-center padding-bottom-0',
                        mRender: function (data, type, row) {
                            var checked = data == '1' ? 'checked' : '';
                            $label = '<span class="onoffswitch">' +
                                    '<input type="checkbox" class="onoffswitch-checkbox" '+checked+' disabled>' +
                                    '<label class="onoffswitch-label" for="maw">' + 
                                        '<span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span>' + 
                                        '<span class="onoffswitch-switch"></span>' +                                        
                                    '</label>' +                                     
                                '</span>';
                            return $label;
                        }
                    },
                    {mData: 'checklistTask_remark'}
                ]
        });
        
        var datatable_maw_checking_view = undefined; 
        maw_otable_checking_view = $('#datatable_maw_checking_view').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_maw_checking_view) {
                    datatable_maw_checking_view = new ResponsiveDatatablesHelper($('#datatable_maw_checking_view'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_maw_checking_view.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_maw_checking_view.respond();
            },
            "aoColumns":
                [
                    {mData: 'checklist_section'},
                    {mData: 'checklist_desc'},
                    {mData: 'checklistTask_result', sClass: 'text-center padding-bottom-0',
                        mRender: function (data, type, row) {
                            var checked = data == '1' ? 'checked' : '';
                            $label = '<span class="onoffswitch">' +
                                    '<input type="checkbox" class="onoffswitch-checkbox" '+checked+' disabled>' +
                                    '<label class="onoffswitch-label" for="maw">' + 
                                        '<span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span>' + 
                                        '<span class="onoffswitch-switch"></span>' +                                        
                                    '</label>' +                                     
                                '</span>';
                            return $label;
                        }
                    },
                    {mData: 'checklistTask_remark'}
                ]
        });
                
    });
    
    function f_maw_checklist_view (wfTrans_id) {
        var wfTask_proses = f_get_general_info_multiple('wf_task', {wfTrans_id:wfTrans_id, wfTaskType_id:'(3,13,23,33,43)'}, '', '', 'wfTask_id DESC')    
        if (wfTask_proses.length == 0)   return false;
        data_maw_checking_view = f_get_general_info_multiple('vw_checklist_task', {wfTask_id:wfTask_proses[0].wfTask_id}, '', '', 'checklist_id');        
        if (data_maw_checking_view.length == 0)   return false;
        f_dataTable_draw(maw_otable_checking_view, data_maw_checking_view, 'datatable_maw_checking_view', 4);
        $('.maw_show_checklist').show();
    }
    
    function f_load_action (load_type, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_maw').trigger('reset');
            $('#form_maw').bootstrapValidator('resetForm', true);
            $('#maw_load_type').val(load_type);
            $('#maw_wfTask_id').val(wfTask_id); 
            maw_otable = otable;
            maw_load_type = load_type;
            $('.maw_show_action_chk, .maw_show_assign, .maw_show_checklist, #maw_alert_box').hide();
            $('.maw_hide_action, maw_hide_return, maw_hide_assign').show();
            $('#maw_titleIcon').removeClass('fa-check-square-o,fa-history');
            if ($('[name="maw_check_process[]"]').val() === undefined)
                $('#form_maw').bootstrapValidator('removeField', 'maw_check_process[]');
            // --- extract details --- //
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'maw');    
            if (maw_load_type == 1) {   // unused!!
                $('#maw_title').html('Resubmit '+task_info.wfFlow_desc+' '+'Application');
                $('.maw_titleIcon').addClass('fa-check-square-o');
                $('.maw_hide_return').hide();
            } else {
                $('#maw_title').html(task_info.wfTaskType_statusName+' '+task_info.wfFlow_desc+' '+'Application');
                $('.maw_titleIcon').addClass('fa-check-square-o');
                $('#maw_return').html('Return to Previous Officer');
                $('#maw_reject').html('Reject');
                $('#maw_lbl_action').html('Application Action');
                var arr_steps = f_get_general_info_multiple('wf_task_type', {wfFlow_id:task_info.wfFlow_id, wfTaskType_isEnd:'N'});
                var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:task_info.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
                var wfTaskType_turn = task_info.wfTaskType_turn != '0' ? task_info.wfTaskType_turn : f_get_value_from_table('wf_task_type', 'wfTaskType_id', previous_task[0].wfTaskType_id, 'wfTaskType_turn');
                f_steps (arr_steps, wfTaskType_turn, 'maw_steps');            
                data_maw_history = f_get_general_info_multiple('dt_task_history', {wfTrans_id:task_info.wfTrans_id}, '', '', 'wfTask_id');
                f_dataTable_draw(maw_otable_history, data_maw_history, 'datatable_maw_history', 9);                   
                if (maw_load_type == 2) {
                    if (task_info.wfTask_remark != null && task_info.wfTask_remark != '<p><br></p>')
                        $('[name="maw_snote_wfTask_remark"]').summernote('code', task_info.wfTask_remark);
                    else
                        $('[name="maw_snote_wfTask_remark"]').summernote('code', '');
                    $('#form_maw').data('bootstrapValidator').resetField('maw_snote_wfTask_remark');
                    if (previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {                    
                        $('#maw_alert_box').show();
                        $('#maw_alert_message').html(previous_task[0].wfTask_remark);
                        var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                        $('#maw_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                    }
                    $("input[name='maw_result'][value=" + task_info.wfTask_statusSave + "]").prop('checked', true);
                    if (maw_otable == 'ctf' || maw_otable == 'itf') {
                        $('.maw_show_assign').show();
                        $('.maw_hide_assign').hide();
                        var taskType_assign = '0';
                        if (task_info.wfFlow_id == '1')         taskType_assign = '3';
                        else if (task_info.wfFlow_id == '2')    taskType_assign = '13';
                        else if (task_info.wfFlow_id == '3')    taskType_assign = '23';
                        else if (task_info.wfFlow_id == '4')    taskType_assign = '33';
                        else if (task_info.wfFlow_id == '5')    taskType_assign = '43';
                        get_option('maw_assign_to', taskType_assign, 'task_assign', 'user_id', 'profile_name', '1', '-- Please select Pegawai Pemproses --');
                        var task_assign_where = f_get_general_info('wf_task_assign', {wfTaskType_id:taskType_assign, wfTaskAssign_from:wfTask_id});
                        var assign_to = (task_assign_where == false || task_assign_where.user_id == null) ? '' : task_assign_where.user_id;
                        $('#maw_assign_to').val(assign_to);
                    } else if (maw_otable == 'ctp' || maw_otable == 'itp') {
                        $('#maw_result').html('Recommended for Approval');
                        $('#maw_reject').html('Recommended for Rejection');
                        $('#maw_return').html('Return to Applicant (to be completed)');
                        $('#maw_lbl_action').html('Recommended Action');
                        $('.maw_show_action_chk').show();
                        data_maw_checking = f_get_general_info_multiple('vw_checklist_task', {wfTask_id:wfTask_id}, '', '', 'checklist_id');
                        f_dataTable_draw(maw_otable_checking, data_maw_checking, 'datatable_maw_checking', 4);
                    } else if (maw_otable == 'ctv' || maw_otable == 'itv') {
                        $('#maw_result').html('Verify');     
                        $('#maw_return').html('Return to Pegawai Pemproses');
                        f_maw_checklist_view (task_info.wfTrans_id); 
                    } else if (maw_otable == 'cta' || maw_otable == 'ita') {
                        $('#maw_result').html('Approve');    
                        $('#maw_return').html('Return to Pegawai Pemproses');
                        f_maw_checklist_view (task_info.wfTrans_id); 
                    }
                } else if (maw_load_type == 3) {
                    $('#maw_title').html('Transaction History');
                    $('.maw_titleIcon').addClass('fa-history');
                    f_maw_checklist_view (task_info.wfTrans_id); 
                    $('.maw_hide_action').hide();
                }
            }   
            $('#modal_maw').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
        
</script>