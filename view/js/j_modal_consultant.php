<script type="text/javascript">  
    
    var mcs_otable;
    var mcs_load_type;
    
    $(document).ready(function () {
        
    });    
    
    function f_load_consultant (load_type, consultant_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mcs').trigger('reset');
            $('#mcs_load_type').val(load_type);
            $('#mcs_consultant_id').val(consultant_id);
            mcs_otable = otable;
            mcs_load_type = load_type;
            $('#form_mcs').find('input, textarea, button, select').prop('disabled',false);               
            // --- extract details --- //
            var consultant = f_get_general_info('vw_consultant_info_view', {consultant_id:consultant_id}, 'mcs');  
            if (mcs_load_type == 3) {
                $('#form_mcs').find('input, textarea, button, select').prop('disabled',true);           
            }
            $('#modal_consultant').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>