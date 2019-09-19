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

    function f_generate_pdf(_indAll_id, _type, _from) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('generate_pdf', {indAll_id: _indAll_id, pdf_type: _type}, 'p_registration')) {
                if (_from === 'cpl') {
                    f_table_cpl ();
                    f_load_pdf(1, result_submit);
                }
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }

</script>