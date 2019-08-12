<script type="text/javascript">  
    
    var mrf_otable;
    var mrf_load_type;
    var mrf_title;
    var mrf_parent;
    var mrf_refresh;
    
    $(document).ready(function () {
        
        $('#form_mrf').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mrf_ref_desc : {
                    validators: {
                        notEmpty: {
                            message: mrf_title+' is required'
                        }
                    }
                },
                mrf_opt_parent : {
                    validators: {
                        callback: {
                            message: mrf_parent+' is required',
                            callback: function (value, validator, $field) {
                                return (mrf_parent != '' && mrf_load_type == 1) ? (value !== '') : true;
                            }
                        }
                    }
                }
            }
        });
        
        $('#mrf_btn_save').click(function () {
            var bootstrapValidator = $("#form_mrf").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {   
                if (f_submit_forms('form_mrf', 'p_maintenance', mrf_title+' successfully saved', '', 'modal_reference')) {         
                    datas = f_get_general_info_multiple(mrf_refresh);
                    f_dataTable_draw(dataNew, datas);
                }
            } else 
                f_notify(2, 'Error', errMsg_validation);                     
        });            
            
    });    
    
    function f_load_reference (load_type, ref_id, ref_refresh, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){ 
            $('#form_mrf').trigger('reset');
            $('#form_mrf').bootstrapValidator('resetForm', true);
            $('#mrf_load_type').val(load_type);
            $('#mrf_ref_id').val(ref_id);
            mrf_otable = otable;
            mrf_load_type = load_type;
            mrf_refresh = ref_refresh;
            mrf_parent = '';
            $('.mrf_info').show();
            $('.mrf_column, .mrf_info_2').hide();
            if (mrf_otable == 'stt') {
                mrf_title = 'State';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_state':'edit_state');
                if (mrf_load_type == 2) {
                    var state = f_get_general_info(ref_refresh, {state_id:ref_id}); 
                    $('#mrf_ref_desc').val(state.state_desc);
                    $('#mrf_infoValue_1').html(state.state_desc);
                    $('#mrf_infoValue_3').html(state.state_timeCreated);
                    $('#mrf_infoValue_4').html(state.status_desc);
                }
            } else if (mrf_otable == 'cty') {
                mrf_title = 'City';
                mrf_parent = 'State';
                $('.mrf_info_2').show();
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_city':'edit_city');
                get_option('mrf_opt_parent', '1', 'ref_state', 'state_id', 'state_desc', 'state_status', ' ', 'ref_id');
                if (mrf_load_type == 1) {
                    $('.mrf_column').show();
                    $('#mrf_formTitle_2').html(mrf_parent);
                } else {                
                    var city = f_get_general_info(ref_refresh, {city_id:ref_id}); 
                    $('#mrf_ref_desc').val(city.city_desc);
                    $('#mrf_opt_parent').val(city.state_id);
                    $('#mrf_infoValue_1').html(city.city_desc);
                    $('#mrf_infoValue_3').html(city.city_timeCreated);
                    $('#mrf_infoValue_4').html(city.status_desc);            
                    $('#mrf_infoTitle_2').html(mrf_parent);
                    $('#mrf_infoValue_2').html(city.state_desc);
                }
            } else if (mrf_otable == 'dpt') {
                mrf_title = 'Department';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_department':'edit_department');
                if (mrf_load_type == 2) {
                    var department = f_get_general_info(ref_refresh, {department_id:ref_id}); 
                    $('#mrf_ref_desc').val(department.department_desc);
                    $('#mrf_infoValue_1').html(department.department_desc);
                    $('#mrf_infoValue_3').html(department.department_timeCreated);
                    $('#mrf_infoValue_4').html(department.status_desc);
                }
            } else if (mrf_otable == 'iqc') {
                mrf_title = 'Inquiry Category';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_inquiry_category':'edit_inquiry_category');
                if (mrf_load_type == 2) {
                    var inquiryCate = f_get_general_info(ref_refresh, {qnfCate_id:ref_id}); 
                    $('#mrf_ref_desc').val(inquiryCate.qnfCate_desc);
                    $('#mrf_infoValue_1').html(inquiryCate.qnfCate_desc);
                    $('#mrf_infoValue_3').html(inquiryCate.qnfCate_timeCreated);
                    $('#mrf_infoValue_4').html(inquiryCate.status_desc);
                }
            } else if (mrf_otable == 'cei') {
                mrf_title = 'Analyzer Certificate Issuer';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_certificate_issuer':'edit_certificate_issuer');
                if (mrf_load_type == 2) {
                    var certIssuer = f_get_general_info(ref_refresh, {certIssuer_id:ref_id}); 
                    $('#mrf_ref_desc').val(certIssuer.certIssuer_desc);
                    $('#mrf_infoValue_1').html(certIssuer.certIssuer_desc);
                    $('#mrf_infoValue_3').html(certIssuer.certIssuer_timeCreated);
                    $('#mrf_infoValue_4').html(certIssuer.status_desc);
                }
            } else if (mrf_otable == 'pdm') {
                mrf_title = 'PEMS Software Predictive Method';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_software_method':'edit_software_method');
                if (mrf_load_type == 2) {
                    var softwareMethod = f_get_general_info(ref_refresh, {softwareMethod_id:ref_id}); 
                    $('#mrf_ref_desc').val(softwareMethod.softwareMethod_desc);
                    $('#mrf_infoValue_1').html(softwareMethod.softwareMethod_desc);
                    $('#mrf_infoValue_3').html(softwareMethod.softwareMethod_timeCreated);
                    $('#mrf_infoValue_4').html(softwareMethod.status_desc);
                }
            } else if (mrf_otable == 'cpd') {
                mrf_title = 'CEMS Industrial Process Description';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_CEMS_description':'edit_CEMS_description');
                if (mrf_load_type == 2) {
                    var cemsDescription = f_get_general_info(ref_refresh, {documentName_id:ref_id}); 
                    $('#mrf_ref_desc').val(cemsDescription.documentName_desc);
                    $('#mrf_infoValue_1').html(cemsDescription.documentName_desc);
                    $('#mrf_infoValue_3').html(cemsDescription.documentName_timeCreated);
                    $('#mrf_infoValue_4').html(cemsDescription.status_desc);
                }
            } else if (mrf_otable == 'ppd') {
                mrf_title = 'PEMS Industrial Process Description';
                $("#form_mrf").find("#funct").val(mrf_load_type == 1?'create_PEMS_description':'edit_PEMS_description');
                if (mrf_load_type == 2) {
                    var pemsDescription = f_get_general_info(ref_refresh, {documentName_id:ref_id}); 
                    $('#mrf_ref_desc').val(pemsDescription.documentName_desc);
                    $('#mrf_infoValue_1').html(pemsDescription.documentName_desc);
                    $('#mrf_infoValue_3').html(pemsDescription.documentName_timeCreated);
                    $('#mrf_infoValue_4').html(pemsDescription.status_desc);
                }
            }
            $('#mrf_title').html(mrf_title);
            $('#mrf_infoTitle_1').html(mrf_title);
            $('#mrf_formTitle_1').html(mrf_title);
            if (mrf_load_type == 1) {
                $('.mrf_info').hide();
            }
            $('#form_mrf').bootstrapValidator('updateMessage', 'mrf_ref_desc','notEmpty',mrf_title+' is required');
            $('#form_mrf').bootstrapValidator('updateMessage', 'mrf_opt_parent','callback',mrf_parent+' is required');
            $('#modal_reference').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
</script>