<script type="text/javascript">
        
    var mcx_otable;
    var mcx_load_type;
    
    $(document).ready(function () {
        
        $('#form_mcx').bootstrapValidator({
            excluded: ':disabled',
            fields: { 
                mcx_consUnr_consultant : {
                    validators: {
                        notEmpty: {
                            message: 'Consultant Name is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Consultant Name must be not more than 150 characters long'
                        }
                    }
                }, 
                mcx_consUnr_modelNo : {
                    validators: {
                        notEmpty: {
                            message: 'Model No. is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Model No. must be not more than 30 characters long'
                        }
                    }
                },
                'mcx_inputParam_id[]' : {
                    validators : {
                        choice : {
                            min : 1,
                            message : 'At least 1 Input Parameter required'
                        }                        
                    }
                }
            }
        });
        
        $('#modal_consultant_existing').on('hide.bs.modal', function() {
            if (mcx_otable == 'mce')
                $('#modal_cems').removeClass('darken');
        });
        
        $('#mcx_btn_submit').on('click', function () {             
            var bootstrapValidator = $("#form_mcx").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {         
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }            
            $.SmartMessageBox({
                title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                content : "Are you sure to submit old CEMS Analyzer Form?",
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Yes") {            
                    $('#modal_waiting').on('shown.bs.modal', function(e){    
                        $('#mcx_funct').val(mcx_load_type==1?'create_consultant_unregistered':'save_consultant_unregistered');
                        if (f_submit_forms('form_mcx', 'p_registration', 'Data successfully saved.')) {
                            if (mcx_otable == 'mce') {
                                data_mce_consultant = f_get_general_info_multiple('dt_industrial_consultant', {indAll_id:$('#mce_indAll_id').val()});
                                f_dataTable_draw(mce_otable_consultant, data_mce_consultant, 'datatable_mce_consultant', 6);
                            }
                            $('#modal_consultant_existing').modal('hide');
                        }
                        $('#modal_waiting').modal('hide');
                        $(this).unbind(e);
                    }).modal('show'); 
                }
            });
        });
                        
    });
    
    function f_mcx_delete_consultant_unregirstered (indCons_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_unregistered', {indCons_id: indCons_id}, 'p_registration', 'Data successfully deleted.', '', 'modal_consultant_existing')) {
                if (otable == 'mce') {
                    data_mce_consultant = f_get_general_info_multiple('dt_industrial_consultant', {indAll_id:$('#mce_indAll_id').val()});
                    f_dataTable_draw(mce_otable_consultant, data_mce_consultant, 'datatable_mce_consultant', 6);
                }
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }  
    
    function f_load_mcx(load_type, indAll_id, consAll_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){            
            $('#form_mcx').trigger('reset');
            $('#form_mcx').bootstrapValidator('resetForm', true);
            mcx_load_type = load_type;
            mcx_otable = otable;  
            $('#form_mcx').find('input, textarea, select').prop('disabled',false);
            if (mcx_load_type == 1) {
                if (indAll_id == '') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                $('#mcx_title').html('Register');
            } else {
                if (consAll_id == '') {
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }  
                f_get_general_info('t_consultant_unregistered', {consAll_id:consAll_id}, 'mcx');  
                $('#mcx_title').html('');
                $('#mcx_consAll_id').val(consAll_id);
                f_get_general_info('t_consultant_cems', {consAll_id:consAll_id}, 'mcx');
                var arr_input_param = f_get_general_info_multiple('t_consultant_parameter', {consAll_id:consAll_id});
                $.each(arr_input_param, function(u){
                    $("input[name='mcx_inputParam_id[]'][value=" + arr_input_param[u].inputParam_id + "]").prop('checked', true);
                });
                if (mcx_load_type == 3) {
                    $('#form_mcx').find('input, textarea, select').prop('disabled',true);
                }
            }
            $('#mcx_indAll_id').val(indAll_id);
            if (mcx_otable == 'mce') 
                $('#modal_cems').addClass('darken');
            $('#modal_consultant_existing').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>