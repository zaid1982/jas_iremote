<script type="text/javascript">
        
    var mus_otable;
    var mus_load_type;
    
    $(document).ready(function () {
        
        get_option('mus_wfGroup_id', '1', 'wf_group', 'wfGroup_id', 'wfGroup_name', 'wfGroup_status', ' ', 'ref_id', 'wfGroup_type', 'JAS');
        get_option('mus_department_id', '1', 'ref_department', 'department_id', 'department_desc', 'department_status', ' ', 'ref_id');
        
        $('#form_mus').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mus_profile_name : {
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
                mus_profile_icNo : {
                    validators: {
                        notEmpty: {
                            message: 'Identification No. is required'
                        },
                        stringLength : {
                            min : 12,
                            max : 12,
                            message : 'Identification No. must be not 12 digits long'
                        },
                        digits : {
                            message : 'Identification No. must be digits'
                        }
                    }
                },
                mus_wfGroup_id : {
                    validators: {
                        callback: {
                            message: 'Agency is required',
                            callback: function (value, validator, $field) {
                                return ($('#mus_user_type').val() === '2') ? true : (value !== '');
                            }
                        }
                    }
                },
                mus_department_id : {
                    validators: {
                        callback: {
                            message: 'Department is required',
                            callback: function (value, validator, $field) {
                                return ($('#mus_user_type').val() === '2') ? true : (value !== '');
                            }
                        }
                    }
                },
                mus_wfGroupUser_designation : {
                    validators: {
                        notEmpty: {
                            message: 'Designation is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Designation must be not more than 30 characters long'
                        }
                    }
                },
                mus_profile_mobileNo : {
                    validators: {
                        notEmpty: {
                            message: 'Mobile No. is required'
                        },
                        stringLength : {
                            max : 11,
                            message : 'Mobile No. must be not more than 11 characters long'
                        },
                        digits : {
                            message : 'Mobile No. must be digits'
                        }
                    }
                },
                mus_profile_email : {
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
                mus_roles : {
                    validators: {
                        notEmpty: {
                            message: 'Roles is required'
                        }
                    }
                }
            }
        }); 
        
        $('#mus_btn_save').click(function () {
            var bootstrapValidator = $("#form_mus").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {   
                var role_sent = '';
                var role_select = $('#mus_roles').val();
                $.each(role_select, function(u){
                    role_sent = role_sent == '' ? role_select[u] : role_sent+','+role_select[u];
                });
                $('#mus_role_comma').val(role_sent);
                var msg_success = mus_load_type == 1 ? 'User successfully added.' : 'User profile successfully updated.';
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_mus', 'p_maintenance', msg_success, '', 'modal_user')) {         
                        if (mus_otable == 'umg') {
                            if (mus_load_type == 1)
                                f_send_email('email_user_creation', {user_id:result_submit_forms});
                            f_table_umg ();
                        }
                    }
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else 
                f_notify(2, 'Error', errMsg_validation);                     
        });
        
    });
    
    function f_load_user(load_type, user_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mus').trigger('reset');
            $('#form_mus').bootstrapValidator('resetForm', true);
            mus_load_type = load_type;
            mus_otable = otable;
            $('#mus_user_id').val(user_id); 
            $('#form_mus').find('input, textarea, select').prop('disabled',false);
            $('#mus_btn_modal_submit').show();
            // -- default -- //
            $('.mus_viewOnly, #mus_roles, #mus_profile_icNo, #mus_profile_email').prop('disabled',false);
            $('#mus_grp_company').hide();
            $('#mus_grp_agency, #mus_grp_department').show();
            get_option('mus_roles', '(1,2,3,4,5,6,11,13,14)', 'ref_utype', 'uType_id', 'uType_desc', 'uType_id', '', 'ref_id');
            $('#mus_roles').attr('size', parseInt($('#mus_roles option').length)); 
            // --- //
            if (mus_load_type == 1) {            
                $('#mus_user_type').val('1');
                $("#form_mus").find("#funct").val('add_user');
            } else if (mus_load_type == 2) {
                $('.mus_viewOnly').prop('disabled',true);
                var profile = f_get_general_info('vw_profile', {user_id:user_id}, 'mus'); 
                $("input[name=mus_user_status][value=" + profile.user_status + "]").prop('checked', true);   
                if ($('#mus_user_type').val() == '2') {
                    get_option('mus_roles', '(7,8)', 'ref_utype', 'uType_id', 'uType_desc', 'uType_id', '', 'ref_id');
                    $('#mus_roles').attr('size', parseInt($('#mus_roles option').length)); 
                    $('#mus_grp_company').show();
                    $('#mus_grp_agency, #mus_grp_department').hide();
                    $('#mus_roles, #mus_profile_icNo').prop('disabled',true);
                } else {
                    $('#mus_profile_email').prop('disabled',true);
                }
                var arr_role = [];
                var list_role = f_get_general_info_multiple('user_type', {user_id:user_id,userType_status:1}); 
                $.each(list_role, function(u){
                    arr_role.push(list_role[u].uType_id);
                });
                $('#mus_roles').val(arr_role);
                if (mus_load_type == 2) {
                    $("#form_mus").find("#funct").val('update_user');                
                } else {
                    $('#form_mus').find('input, textarea, button, select').prop('disabled',true);
                    $('#mus_btn_save').hide();
                }         
            } else {
                f_notify(2, 'Ralat', errMsg_default);
                return false;
            }        
            $('#modal_user').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
</script>