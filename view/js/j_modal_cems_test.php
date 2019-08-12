<script src="js/plugin/summernote/summernote.min.js"></script>

<script type="text/javascript">
        
    var mtc_otable;
    var mtc_load_type;
    
    $(document).ready(function () {
                
        $('#mtc_summernote').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'hr']]
            ]
        });              
    });
    
    function f_load_cems_test(load_type, mtc_id, otable) {
        $('#form_mtc').trigger('reset');
        //$('#form_mtc').bootstrapValidator('resetForm', true);
        mtc_load_type = load_type;
        mtc_otable = otable;
        $('#mtc_mtc_id').val(mtc_id); 
        $('#form_mtc').find('input, textarea, button, select').prop('disabled',false);
        $('#mtc_date_planned').prop('disabled',true);
        $('.mtc_show_process, .mtc_show_industry').hide();
        if (mtc_load_type == 1) {  
            $('.mtc_show_industry').show();
        } else if (mtc_load_type >= 2) {
            $('#form_mtc').find('input, textarea, button, select').prop('disabled',true);
            $('#mtc_attachment_download').prop('disabled',false);
            $('.mtc_show_process').show();
            if (mtc_load_type == 2) {
                
            } else {
                
            }         
        } else {
            f_notify(2, 'Error Notification', errMsg_default);
            return false;
        }        
        $('#modal_cems_test').modal('show');
    }
    
</script>