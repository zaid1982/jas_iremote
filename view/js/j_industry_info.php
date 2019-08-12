<script type="text/javascript">  

    $(document).ready(function () {
        
        pageSetUp();      
                                      
        $('#form_iin').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                iin_maddress_line1 : {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address is required'
                        }
                    }
                },    
                iin_maddress_postcode: {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address Postcode is required'
                        },
                        regexp: {
                            regexp: /^\d{5}$/,
                            message: 'Mail Address Postcode must contain 5 digits'
                        }
                    }
                },    
                iin_mstate_id : {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address State is required'
                        }
                    }
                },  
                iin_mcity_id : {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address City is required'
                        }
                    }
                },
                iin_wfGroup_phoneNo : {
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
                iin_wfGroup_faxNo : {
                    validators: { 
                        stringLength : {
                            max : 11,
                            message : 'Fax No. must be not more than 11 characters long'
                        },
                        digits : {
                            message : 'Fax No. must be digits'
                        }
                    }
                },
                iin_sic_id : {
                    validators: {
                        notEmpty: {
                            message: 'Plant Sector is required'
                        }
                    }
                },
                iin_subSic_id : {
                    validators: {
                        notEmpty: {
                            message: 'Plant Sub Sector is required'
                        }
                    }
                },
                iin_parlimen_id : {
                    validators: {
                        notEmpty: {
                            message: 'Parliament is required'
                        }
                    }
                },              
                iin_industrial_totalStack : {
                    validators: {            
                        notEmpty: {
                            message: 'Total Stack is required'
                        },  
                        integer : {
                            message : 'Total Stack must be integer'
                        },
                        between: {
                            min: 1,
                            max: 99999,
                            message: 'Total Stack must be between 0 to 99999'
                        }
                    }
                }
            }
        });         
        
        $('.iin_disView').attr('disabled',true);
        
        $('#iin_btn_update').click(function () {
            var bootstrapValidator = $("#form_iin").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_iin', 'p_registration', 'Your industrial profile successfully updated.', '', 'modal_profile'))   
                        f_iin_set_alert($('#iin_wfGroup_id').val());
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');  
            } else 
                f_notify(2, 'Error', errMsg_validation);             
        });
        
        $('#iin_sic_id').on('change', function () {
            $('#form_iin').data('bootstrapValidator').resetField('iin_subSic_id');
            f_set_sub_sector('iin_subSic_id', '', 'iin_sic_id', $(this).val()); 
        });
        
        $('#iin_state_id').on('change', function () {
            $('#form_iin').data('bootstrapValidator').resetField('iin_city_id');
            f_set_city('iin_city_id', '', 'iin_state_id', $(this).val()); 
            if ($('#form_iin').find('[name="iin_same_address"]').is(':checked')) {
                $('#iin_mstate_id').val($(this).val());
                f_set_city('iin_mcity_id', $('#iin_city_id').val(), 'iin_mstate_id', $(this).val()); 
                $('#iin_mcity_id').prop('disabled', true);
            }
        });
        
        $('#iin_city_id').on('change', function () {
            if ($('#form_iin').find('[name="iin_same_address"]').is(':checked')) {
                f_set_city('iin_mcity_id', $(this).val(), 'iin_mstate_id', $('#iin_state_id').val()); 
                $('#iin_mcity_id').prop('disabled', true);
            }
        });   
        
        $('#iin_mstate_id').on('change', function () {
            $('#form_iin').data('bootstrapValidator').resetField('iin_mcity_id');
            f_set_city('iin_mcity_id', '', 'iin_mstate_id', $(this).val()); 
        });
        
        $('#form_iin').find('[name="iin_same_address"]').on('click', function () {
            var value = $(this).is(':checked') ? '1' : null;
            f_iin_same_address(value);
        });
        
        $('#iin_address_line1').on('keyup', function () {
            if ($('#form_iin').find('[name="iin_same_address"]').is(':checked'))
                $('#iin_maddress_line1').val($(this).val());
        });
        
        $('#iin_address_postcode').on('keyup', function () {
            if ($('#form_iin').find('[name="iin_same_address"]').is(':checked'))
                $('#iin_maddress_postcode').val($(this).val());
        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){ 
            var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            f_iin_set_alert(wf_group_user.wfGroup_id);  
            get_option ('iin_state_id', '1', 'ref_state', 'state_id', 'state_desc', 'state_status', ' ');
            get_option ('iin_mstate_id', '1', 'ref_state', 'state_id', 'state_desc', 'state_status', ' ');
            get_option ('iin_sic_id', '1', 'ref_sic', 'sic_id', 'sic_desc', 'sic_status', ' ');
            get_option_group ('iin_parlimen_id', '1', 'vw_parlimen_state', 'parlimen_id', 'parlimen_view', 'state_desc', 'parlimen_status');
            var industrial_info = f_get_general_info('vw_industrial_info', {}, 'iin', '', {wfGroup_id:wf_group_user.wfGroup_id});
            f_set_city('iin_city_id', industrial_info.city_id, 'iin_state_id', industrial_info.state_id); 
            f_set_city('iin_mcity_id', industrial_info.mcity_id, 'iin_mstate_id', industrial_info.mstate_id);
            f_set_sub_sector('iin_subSic_id', industrial_info.subSic_id, 'iin_sic_id', industrial_info.sic_id);
            $("input[name='iin_same_address'][value=" + industrial_info.wfGroup_address_same + "]").prop('checked', true);
            if (industrial_info.wfGroup_address_same == '1')
                f_iin_same_address (industrial_info.wfGroup_address_same, 'iin_mcity_id');
            $('.iin_disView').attr('disabled',true);
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
        
        $('.iin_disView').attr('disabled',true);
    });
    
    function f_set_sub_sector(subSic_name, subSic_id, sic_name, sic_id) {
        set_option_empty(subSic_name);
        if ($('#'+sic_name).val() != '') {   
            get_option (subSic_name, '1', 'ref_sub_sic', 'subSic_id', 'subSic_desc', 'subSic_status', ' ', 'ref_desc', 'sic_id', sic_id);
            $('#'+subSic_name).prop('disabled', false).val(subSic_id);
        }
    }
    
    function f_iin_set_alert(wfGroup_id) {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wfGroup_id, 'wfGroup_isFirstTime');        
        if (isFirstTime == '1') {
            $('#iin_alert').removeClass('hide');
            $('#iin_alert_txt').html('You are 1st time login as <strong>Industrial</strong>. Please complete the <strong>Industrial Information</strong> first before proceed to registration.');
            $('#iin_info_register').addClass('hide');
        } else {
            $('#iin_alert').addClass('hide');
            $('#iin_info_register').removeClass('hide');
        }   
    }
    
    function f_iin_same_address(value) {
        $('#form_iin').data('bootstrapValidator').resetField('iin_maddress_line1').resetField('iin_maddress_postcode').resetField('iin_mstate_id').resetField('iin_mcity_id');
        $('.iin_disSameAddress').val('').prop('disabled', (value=='1'?true:false));
        set_option_empty('iin_mcity_id');
        if (value == '1') {
            $('#iin_maddress_line1').val($('#iin_address_line1').val());
            $('#iin_maddress_postcode').val($('#iin_address_postcode').val());
            $('#iin_mstate_id').val($('#iin_state_id').val());
            f_set_city('iin_mcity_id', $('#iin_city_id').val(), 'iin_mstate_id', $('#iin_state_id').val()); 
            $('#iin_mcity_id').prop('disabled', true);
        } 
    }
            
</script>