<script type="text/javascript">
        
    var mch_otable;
    
    $(document).ready(function () {
        
        $('#modal_change_consultant').on('shown.bs.modal', function() {
            
        });
        
    });
    
    function f_load_change_consultant(mch_id, otable) {
        $('#form_mch').trigger('reset');
        //$('#form_mdg').bootstrapValidator('resetForm', true);
        mch_otable = otable;  
        $('#modal_change_consultant').modal('show');
    }
    
</script>