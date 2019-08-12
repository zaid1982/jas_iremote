<script type="text/javascript">  
    
    var mid_otable;
    var mid_load_type;
    
    $(document).ready(function () {
        
    });    
    
    function f_load_industrial (load_type, industrial_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mid').trigger('reset');
            $('#mid_load_type').val(load_type);
            $('#mid_industrial_id').val(industrial_id);
            mid_otable = otable;
            mid_load_type = load_type;
            $('#form_mid').find('input, textarea, button, select').prop('disabled',false);               
            // --- extract details --- //
            var industrial = f_get_general_info('vw_industrial_info_view', {industrial_id:industrial_id}, 'mid');  
            if (mid_load_type == 3) {
                $('#form_mid').find('input, textarea, button, select').prop('disabled',true);           
            }
            $('#modal_industrial').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');  
    }
    
</script>