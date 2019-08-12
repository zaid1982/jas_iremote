<script type="text/javascript">
        
    var mdg_otable;
    
    $(document).ready(function () {
        
        $('#modal_delegate').on('shown.bs.modal', function() {
            
        });
        
    });
    
    function f_load_delegate(mdg_id, otable) {
        $('#form_mdg').trigger('reset');
        //$('#form_mdg').bootstrapValidator('resetForm', true);
        mdg_otable = otable;
        $('#mdg_user_id').val(mdg_id);         
        $('#modal_delegate').modal('show');
    }
    
</script>