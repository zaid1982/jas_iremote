<script type="text/javascript">
        
    var mpf_otable;
    var mpf_load_type;
    var mpf_1st_load = true;
    
    $(document).ready(function () {
        
        $('#modal_profile').on('shown.bs.modal', function() {
            //f_load_profile();
            $("#tabs").tabs({ active: 0 });
        });
        
        $('#form_mpfa').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                 mpfa_profile_name : {
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
                mpfa_profile_icNo : {
                    validators: {
                        notEmpty: {
                            message: 'Identification No. is required'
                        },
                        stringLength : {
                            min : 12,
                            max : 12,
                            message : 'Identification No. must be 12 digits long'
                        },
                        digits : {
                            message : 'Identification No. must be digits'
                        }
                    }
                },
                mpfa_profile_mobileNo : {
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
                mpfa_profile_email : {
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
                }
            }
        }); 
        
        $('#form_mpfb').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mpfb_password_current : {
                    validators: {
                        notEmpty: {
                            message: 'Current Password is required'
                        },
                        callback: {
                            message: 'Current Password is not correct',
                            callback: function (value, validator, $field) {
                                return value == $('#mpfb_user_password').val();
                            }
                        }
                    }
                },
                mpfb_password_new : {
                    validators: {
                        notEmpty: {
                            message: 'New Password is required'
                        },
                        stringLength: {
                            min : 6,
                            max : 20,
                            message : 'New Password must be not less than 6 and not more than 20 characters long'
                        },
                        callback: {
                            message: 'New Password cannot be same as Old Password',
                            callback: function (value, validator, $field) {
                                return value != $('#mpfb_user_password').val();
                            }
                        }
                    }
                },
                mpfb_password_confirm : {
                    validators: {
                        notEmpty: {
                            message: 'Confirm Password is required'
                        },
                        stringLength: {
                            min : 6,
                            max : 20,
                            message : 'Confirm Password must be not less than 6 and not more than 20 characters long'
                        },
                        identical: {
                            field : 'mpfb_password_new',
                            message : 'Confirm Password not same as New Password'
                        }
                    }
                },
                mpfb_secQues_id : {
                    validators: {
                        notEmpty: {
                            message: 'Security Question is required'
                        }
                    }
                },
                mpfb_user_security_answer : {
                    validators: {
                        notEmpty: {
                            message: 'Security Answer is required'
                        },
                        stringLength: {
                            max : 100,
                            message : 'Security Answer must be not less than 100 characters long'
                        }
                    }
                }
            }
        }); 
        
        $('#mpfa_btn_update').on('click', function () {
            var bootstrapValidator = $("#form_mpfa").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {  
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    f_submit_forms('form_mpfa', 'p_login', 'Your profile successfully updated.', '', 'modal_profile');        
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else 
                f_notify(2, 'Error', errMsg_validation);                     
        });
        
        $('#mpfb_btn_update').on('click', function () {
            var bootstrapValidator = $("#form_mpfb").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {    
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    f_submit_forms('form_mpfb', 'p_login', 'Your password successfully updated.', '', 'modal_profile'); 
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');
            } else 
                f_notify(2, 'Error', errMsg_validation);                     
        });
        
    });
    
    function f_load_profile(load_type, user_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (mpf_1st_load) {  
                get_option('mpfb_secQues_id', '1', 'ref_security_question', 'secQues_id', 'secQues_desc', 'secQues_status', ' ', 'ref_id');
                mpf_1st_load = false;
            }
            $('#form_mpfa,#form_mpfb').trigger('reset');
            $('#form_mpfa').bootstrapValidator('resetForm', true);
            $('#form_mpfb').bootstrapValidator('resetForm', true);
            mpf_load_type = load_type;
            mpf_otable = otable;
            $('#mpfb_user_id').val(user_id);     
            var profile = f_get_general_info('vw_profile', {user_id:user_id}, 'mpfa');             
            if (profile.user_type == 1)
                $('#mpf_li_b').addClass('hidden');
            else
                $('#mpf_li_b').removeClass('hidden');
            $('#mpfb_user_password').val(profile.user_password); 
            $('#mpfb_secQues_id').val(profile.secQues_id); 
            $('#mpfb_user_security_answer').val(profile.user_security_answer); 
            $('#modal_profile').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>