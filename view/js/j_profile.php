<script type="text/javascript">

    $(document).ready(function () {

        pageSetUp();

        $('#form_pfc').bootstrapValidator({
            excluded: [':disabled'],
            fields: {
                pfc_profile_name: {
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
                pfc_profile_mobileNo: {
                    validators: {
                        notEmpty: {
                            message: 'Mobile No. is required'
                        },
                        stringLength : {
                            max : 11,
                            message : 'Mobile No. must be not more than 11 digits long'
                        },
                        digits : {
                            message : 'Mobile No. is not valid'
                        }
                    }
                },
                pfc_profile_email: {
                    validators: {
                        notEmpty: {
                            message: 'Email Address is required'
                        },
                        stringLength : {
                            max : 80,
                            message : 'Email Address must be not more than 80 characters long'
                        },
                        emailAddress : {
                            message : 'Email Address is not valid'
                        }
                    }
                }
            }
        });
        
        $('#form_pfp').bootstrapValidator({
            excluded: [':disabled'],
            fields: {
                pfp_old_password: {
                    validators: {
                        notEmpty: {
                            message: 'Old Password is required'
                        },
                        callback: {
                            message: 'Old Password is not correct',
                            callback: function (value, validator, $field) {
                                return value == $('#pfp_user_password').val();
                            }
                        }
                    }
                },
                pfp_new_password: {
                    validators: {
                        notEmpty: {
                            message: 'New Password is required'
                        },
                        stringLength: {
                            min : 8,
                            max : 20,
                            message : 'New Password must be not less than 8 and not more than 20 characters long'
                        },
                        callback: {
                            message: 'New Password cannot be same as Old Password',
                            callback: function (value, validator, $field) {
                                return value != $('#pfp_user_password').val();
                            }
                        }
                    }
                },
                pfp_confirm_password: {
                    validators: {
                        notEmpty: {
                            message: 'Confirm Password is required'
                        },
                        stringLength: {
                            min : 8,
                            max : 20,
                            message : 'Confirm Password must be not less than 8 and not more than 20 characters long'
                        },
                        identical: {
                            field : 'pfp_new_password',
                            message : 'Confirm Password not same as New Password'
                        }
                    }
                }
            }
        });

        $("#form_pfc").on('submit', function (event) {
            event.preventDefault();
        });

        $("#pfc_but_submit").on('click', function () {
            var bootstrapValidator = $("#form_pfc").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {
                if (f_submit_forms('form_pfc', 'p_login', 'Profile successfully updated.', errMsg_default)) {
                    f_get_page_data();
                }
            } else {
                return false;
            }
        });
        
        $("#form_pfp").on('submit', function (event) {
            event.preventDefault();
        });

        $("#pfp_but_submit").on('click', function () {
            var bootstrapValidator = $("#form_pfp").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {
                if (f_submit_forms('form_pfp', 'p_login', 'Password successfully updated.', errMsg_default)) {
                    f_get_page_data();
                }
            } else {
                return false;
            }
        });
        
        $("#pfc_but_reset, #pfp_but_reset").on('click', function () {
            f_get_page_data();
        });
        
        f_get_page_data();

    });

    function f_get_page_data() {
        // tab profile
        $('#form_pfc').bootstrapValidator('resetForm', true);
        $('#pfc_table_roles tbody').empty();
        var profile = f_get_general_info('vw_profile', {'user_id': 'user_id'}, 'pfc');
        $('#lpfc_title, #l_login_name').html(profile.profile_name);
        var user_role = f_get_general_info_multiple('vw_user_role', {'user_id': 'user_id'});
        $.each(user_role, function(u){
            var newRowContent = "<tr><td>"+(u+1)+"</td><td>"+user_role[u].role_desc+"</td><td>"+user_role[u].status_desc+"</td></tr>";
            $(newRowContent).appendTo($("#pfc_table_roles"));
        });
        // tab password
        $('#form_pfp').bootstrapValidator('resetForm', true);
        $('#form_pfp').trigger('reset');
        f_get_general_info('user', {'user_id': 'user_id'}, 'pfp');        
    }
</script>