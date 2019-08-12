<script type="text/javascript">
        
    var mpt_otable;
    var mpt_load_type;
    
    $(document).ready(function () {
        
        $('#form_mpt').bootstrapValidator({   
            excluded: ':disabled',
            fields: {  
                mpt_indAll_dateRataSet : {
                    validators : {
                        notEmpty: {
                            message: 'Initial RATA Date is required'
                        }                      
                    }
                }
            }
        });
        
        $('#mpt_indAll_dateRataSet').datepicker({
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
                $('#form_mpt').bootstrapValidator('revalidateField', 'mpt_indAll_dateRataSet');
            }
        });
        
        $('#mpt_btn_submit').on('click', function () {
            var bootstrapValidator = $("#form_mpt").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (!bootstrapValidator.isValid()) {       
                $('#mpt_indAll_dateRataSet').focus();
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            } 
            if (f_submit_forms('form_mpt', 'p_registration')) {
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure to submit the Initial RATA date?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {            
                        $('#modal_waiting').on('shown.bs.modal', function(e){    
                            if (f_submit($('#mpt_wfTask_id').val(), $('#mpt_wfTaskType_id').val(), '27', 'Your application successfully submitted. Please perform the initial RATA on the set date and submit the report.', '', '', '', '', $('#mpt_wfTask_refName').val(), $('#mpt_wfTask_refValue').val())) {
                                f_send_email('email_initialRATA', {wfTask_id:result_submit_task}); 
                                if (mpt_otable == 'icm')
                                    f_table_icm ();
                                else if (mpt_otable == 'ipm')
                                    f_table_ipm ();
                                $('#modal_plan_test').modal('hide');
                            }
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });
            }    
        });
        
    });
    
    function f_load_plan_test (load_type, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mpt').trigger('reset');
            $('#form_mpt').bootstrapValidator('resetForm', true);
            $('#mpt_load_type').val(load_type);
            $('#mpt_wfTask_id').val(wfTask_id); 
            mpt_otable = otable;
            mpt_load_type = load_type;
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'mpt');    
            var industrial_all = f_get_general_info('t_industrial_all', {wfTrans_id:task_info.wfTrans_id}, 'mpt'); 
            var industrial = f_get_general_info('t_industrial', {industrial_id:industrial_all.industrial_id}, 'mpt'); 
            $('#modal_plan_test').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
</script>