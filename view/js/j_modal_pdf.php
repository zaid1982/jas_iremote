<script type="text/javascript">	
    
    function f_load_pdf(types, pdf_id, ids) { 
        
        if (pdf_id === null) {
//            if (types == 'resit')
//                f_submit_normal('create_pdf_resit', {fi_id:ids}, 'p_fi');
            pdf_id = result_submit;
        }
        var pdf = f_get_general_info('pdf', {pdf_id:pdf_id});
        $('#mpdf_iframe').attr('src', 'pdf/'+pdf.pdf_type+'/'+pdf.pdf_folder+'/'+pdf.pdf_filename+'#zoom=100'); 
        $('#modal_pdf').modal('show'); 
    }
    
</script>