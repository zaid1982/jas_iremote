<script type="text/javascript">	
    
    var upl_load_type;
    var is_submit_upload = false;
    
    $(document).ready(function() {  
                
        $('#form_upl').bootstrapValidator({
            excluded: [':hidden'],
            fields: {
                upl_documentName_id: {
                    validators: {
                        notEmpty: {
                            message: 'Document Title is required'
                        }
                    }
                },
                upl_document_name: {
                    validators : {
                        stringLength : {
                            max : 100,
                            message : 'Document Title must be not more than 100 characters long'
                        },
                        callback: {
                            message: 'Please specify other Document Title',
                            callback: function (value, validator, $field) {
                                var nature = $('#form_upl').find('[name="upl_documentName_id"]').val();
                                return (nature != '1' || value != '');
                            }
                        }
                    }
                },
                upl_document_remarks: {
                    validators: {
                        stringLength : {
                            max : 100,
                            message : 'Document Descriptoin must be not more than 100 characters long'
                        }
                    }
                },
                file_upload: {
                    validators: {
                        notEmpty: {
                            message: 'Attachment File is required'
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: '20000000',
                            message: 'Only PDF file format max 20MB allowed.'
                        }
                    }
                }
            }
        }).on('change', '[name="upl_documentName_id"]', function(e) {
            $('#form_upl').bootstrapValidator('revalidateField', 'upl_document_name');
        });
        
        
        $('#upl_documentName_id').on('change', function (event) {
            $(this).val() == '1' ? $('#upl_document_name').attr('disabled', false) : $('#upl_document_name').attr('disabled', true);
        });   
        
        $('#form_upl').on('submit', function (event) {
            event.preventDefault();
        });                
        
        $('#upl_btn_upload').on('click', function () {
            var bootstrapValidator = $("#form_upl").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {
                if (is_submit_upload)
                    return j;
                is_submit_upload = true;
                var formData = new FormData($('#form_upl')[0]);
                $.ajax({
                    url: "process/p_upload.php",
                    type: "POST",
                    dataType: "json",
                    async: false,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function() {
                        myXhr = $.ajaxSettings.xhr();
                        return myXhr;
                    },
                    success: function(resp) {
                        if (resp.success == true){ 
                            f_notify(1, 'Success', 'Document successfully uploaded.');
                            if (upl_load_type == 'mrc') { 
                                dataAttach = f_get_general_info_multiple('vw_vendor_document', {'v_vendor_id':$('#upl_id').val()});
                                f_display_attachment('mrc');
                            } else if (upl_load_type == 'mqf') { 
                                dataAttach = f_get_general_info_multiple('vw_qnf_document', {'qnf_id':$('#upl_id').val()});
                                f_display_attachment('mqf');
                            } else if (upl_load_type == 'mqv') { 
                                dataAttach = f_get_general_info_multiple('vw_qnf_document', {'qnf_id':$('#upl_id').val()});
                                f_display_attachment('mqv');
                            }
                        } else {
                            f_notify(2, 'Error', resp.errors);
                        }
                    },
                    error: function() {
                        f_notify(2, 'Error', errMsg_default);
                    }
                });
                is_submit_upload = false;
                $('#modal_upload').modal('hide');    
            } else
                return false;
        });
    });
    
    function f_load_upload (load_type, upl_id) {
        f_modal_reset('form_upl');
        $('#form_upl').bootstrapValidator('resetForm', true);     
        upl_load_type = load_type;
        $('#upl_load_type').val(load_type);
        $('#upl_id').val(upl_id);
        $('#upl_documentName_id').html('');
        if (load_type == 'mrc') {
            get_option('upl_documentName_id', '1', 'document_name', 'documentName_id', 'documentName_desc', 'documentName_status', ' ');
            $('#upl_documentName_id').append($('<option>', {value: 1, text: 'Others'}));
        } else if (jQuery.inArray(load_type, ['mqf', 'mqv']) >=0) {
            $('#upl_documentName_id').append($('<option>', {value: '', text: ' '}));
            $('#upl_documentName_id').append($('<option>', {value: 1, text: 'Others'}));
        }
        $('#modal_upload').modal('show');
    }      
        
</script>