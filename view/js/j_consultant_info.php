<script type="text/javascript">  
    
    var cin_otable_doc;
    var data_cin_doc;
    
    $(document).ready(function () {
        
        pageSetUp();      
        
        get_option('cin_documentName_id', '1', 'document_name', 'documentName_id', 'documentName_desc', 'documentName_status', ' ', 'ref_id', 'documentName_type', 'consultant');
        
        $("#cin_consultant_dateIncorporate").datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            maxDate: '0', 
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
                $('#form_cin_form').bootstrapValidator('revalidateField', 'cin_consultant_dateIncorporate');
            }
        });
        
        $('#form_cin_form').bootstrapValidator({         
            excluded: ':disabled',
            fields: {  
                cin_address_line1 : {
                    validators: {
                        notEmpty: {
                            message: 'Registered Address is required'
                        }
                    }
                },    
                cin_address_postcode: {
                    validators: {
                        notEmpty: {
                            message: 'Registered Address Postcode is required'
                        },
                        regexp: {
                            regexp: /^\d{5}$/,
                            message: 'Registered Address Postcode must contain 5 digits'
                        }
                    }
                },    
                cin_state_id : {
                    validators: {
                        notEmpty: {
                            message: 'Registered Address State is required'
                        }
                    }
                },  
                cin_city_id : {
                    validators: {
                        notEmpty: {
                            message: 'Registered Address City is required'
                        }
                    }
                },
                cin_maddress_line1 : {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address is required'
                        }
                    }
                },    
                cin_maddress_postcode: {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address Postcode is required'
                        },
                        regexp: {
                            regexp: /^\d{5}$/,
                            message: 'Mail Address Postcode must contain 5 digits'
                        }
                    }
                },    
                cin_mstate_id : {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address State is required'
                        }
                    }
                },  
                cin_mcity_id : {
                    validators: {
                        notEmpty: {
                            message: 'Mail Address City is required'
                        }
                    }
                },
                cin_wfGroup_phoneNo : {
                    validators: {
                        notEmpty: {
                            message: 'Mobile No. is required'
                        },
                        stringLength : {
                            max : 11,
                            message : 'Mobile No. must be not more than 11 characters long'
                        },
                        digits : {
                            message : 'Mobile No. must be digits'
                        }
                    }
                },                        
                cin_wfGroup_faxNo : {
                    validators: {                        
                        stringLength : {
                            max : 11,
                            message : 'Fax No. must be not more than 11 characters long'
                        },
                        digits : {
                            message : 'Fax No. must be digits'
                        }
                    }
                },
                wfGroup_website : {
                    validators: {
                        stringLength : {
                            max : 150,
                            message : 'Website must be not more than 150 characters long'
                        }
                    }
                }
            }
        });         
        
        $('.cin_disView').attr('disabled',true);
        
        $('#cin_btn_update').on('click', function () {
            var bootstrapValidator = $("#form_cin_form").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {         
                $('#modal_waiting').on('shown.bs.modal', function(e){
                    if (f_submit_forms('form_cin,#form_cin_form', 'p_registration', 'Your consultant profile successfully updated.'))   
                        f_cin_set_alert($('#cin_wfGroup_id').val());
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show');  
            } else 
                f_notify(2, 'Error', errMsg_validation);             
        });
                            
        $('#cin_state_id').on('change', function () {
            $('#form_cin_form').data('bootstrapValidator').resetField('cin_city_id');
            f_set_city('cin_city_id', '', 'cin_state_id', $(this).val()); 
            if ($('#form_cin_form').find('[name="cin_same_address"]').is(':checked')) {
                $('#cin_mstate_id').val($(this).val());
                f_set_city('cin_mcity_id', $('#cin_city_id').val(), 'cin_mstate_id', $(this).val()); 
                $('#cin_mcity_id').prop('disabled', true);
            }
        });
        
        $('#cin_city_id').on('change', function () {
            if ($('#form_cin_form').find('[name="cin_same_address"]').is(':checked')) {
                f_set_city('cin_mcity_id', $(this).val(), 'cin_mstate_id', $('#cin_state_id').val()); 
                $('#cin_mcity_id').prop('disabled', true);
            }
        });   
        
        $('#cin_mstate_id').on('change', function () {
            $('#form_cin_form').data('bootstrapValidator').resetField('cin_mcity_id');
            f_set_city('cin_mcity_id', '', 'cin_mstate_id', $(this).val()); 
        });
        
        $('#form_cin_form').find('[name="cin_same_address"]').on('click', function () {
            var value = $(this).is(':checked') ? '1' : null;
            f_cin_same_address(value);
        });
        
        $('#cin_address_line1').on('keyup', function () {
            if ($('#form_cin_form').find('[name="cin_same_address"]').is(':checked'))
                $('#cin_maddress_line1').val($(this).val());
        });
        
        $('#cin_address_postcode').on('keyup', function () {
            if ($('#form_cin_form').find('[name="cin_same_address"]').is(':checked'))
                $('#cin_maddress_postcode').val($(this).val());
        });
        
        $('#form_cin_doc').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                cin_documentName_id : {
                    validators: {
                        notEmpty: {
                            message: 'Document Type is required'
                        }
                    }
                },
                cin_document_name : {
                    validators: {
                        notEmpty: {
                            message: 'Document Title is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Document Title must be not more than 30 characters long'
                        }
                    }
                },
                cin_file_document: {
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
        });   
        
        var datatable_cin_doc = undefined; 
        cin_otable_doc = $('#datatable_cin_doc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_cin_doc) {
                    datatable_cin_doc = new ResponsiveDatatablesHelper($('#datatable_cin_doc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_cin_doc.createExpandIcon(nRow);
                var info = cin_otable_doc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_cin_doc.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'documentName_desc'},
                    {mData: 'document_name'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.document_id != null)
                                $label += '<a type="button" class="btn btn-success btn-xs" title="Download Support Document" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            $label += ' <button type="button" class="btn btn-danger btn-xs" title="Delete" onclick="f_cin_delete_consultantDoc ('+row.consultantDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#cin_btn_add_document').on('click', function () {         
            var bootstrapValidator = $("#form_cin_doc").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {  
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_cin_doc')[0]);
                    formData.append('funct', 'upload_consultant_supportDoc');
                    formData.append('consultant_id', $('#cin_consultant_id').val());
                    $.ajax({
                        url: "process/p_registration.php",
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
                                $('#form_cin_doc').trigger('reset');
                                $('#form_cin_doc').bootstrapValidator('resetForm', true);
                                data_cin_doc = f_get_general_info_multiple('dt_consultant_docSupport', {consultant_id:$('#cin_consultant_id').val(), documentName_type:'consultant'}, '', '', 'consultantDoc_id');
                                f_dataTable_draw(cin_otable_doc, data_cin_doc, 'datatable_cin_doc', 4);
                            } else {
                                f_notify(2, 'Error', resp.errors);
                            }
                        },
                        error: function() {
                            f_notify(2, 'Error', errMsg_default);
                        }
                    }); 
                    $('#modal_waiting').modal('hide');
                    $(this).unbind(e);
                }).modal('show'); 
            } else {
                $('#mac_file_catalogue').focus();
                f_notify(2, 'Error', 'Please make sure file to be uploaded is selected.');   
            }
        });
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group_user = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            f_cin_set_alert(wf_group_user.wfGroup_id);       
            get_option ('cin_state_id', '1', 'ref_state', 'state_id', 'state_desc', 'state_status', ' ');
            get_option ('cin_mstate_id', '1', 'ref_state', 'state_id', 'state_desc', 'state_status', ' ');
            var consultant_info = f_get_general_info('vw_consultant_info', {}, 'cin', '', {wfGroup_id:wf_group_user.wfGroup_id});
            f_set_city('cin_city_id', consultant_info.city_id, 'cin_state_id', consultant_info.state_id); 
            f_set_city('cin_mcity_id', consultant_info.mcity_id, 'cin_mstate_id', consultant_info.mstate_id); 
            $("input[name='cin_same_address'][value=" + consultant_info.wfGroup_address_same + "]").prop('checked', true);
            if (consultant_info.wfGroup_address_same == '1')
                f_cin_same_address (consultant_info.wfGroup_address_same, 'cin_mcity_id');
            data_cin_doc = f_get_general_info_multiple('dt_consultant_docSupport', {consultant_id:consultant_info.consultant_id, documentName_type:'consultant'}, '', '', 'consultantDoc_id');
            f_dataTable_draw(cin_otable_doc, data_cin_doc, 'datatable_cin_doc', 4);
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');     
        
    });  
    
    function f_cin_delete_consultantDoc (consultantDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_consultant_doc', {consultantDoc_id: consultantDoc_id}, 'p_registration', 'Document successfully deleted.')) {
                data_cin_doc = f_get_general_info_multiple('dt_consultant_docSupport', {consultant_id:$('#cin_consultant_id').val(), documentName_type:'consultant'}, '', '', 'consultantDoc_id');
                f_dataTable_draw(cin_otable_doc, data_cin_doc, 'datatable_cin_doc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_cin_set_alert(wfGroup_id) {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', wfGroup_id, 'wfGroup_isFirstTime');        
        if (isFirstTime == '1') {
            $('#cin_alert').removeClass('hide');
            $('#cin_alert_txt').html('You are 1st time login as <strong>Consultant</strong>. Please complete the <strong>Consultant Information</strong> first before proceed to registration.');
            $('#cin_info_register').addClass('hide');
        } else {
            $('#cin_alert').addClass('hide');
            $('#cin_info_register').removeClass('hide');
        }
    }
    
    function f_cin_same_address(value) {
        $('#form_cin_form').data('bootstrapValidator').resetField('cin_maddress_line1').resetField('cin_maddress_postcode').resetField('cin_mstate_id').resetField('cin_mcity_id');
        $('.cin_disSameAddress').val('').prop('disabled', (value=='1'?true:false));
        set_option_empty('cin_mcity_id');
        if (value == '1') {
            $('#cin_maddress_line1').val($('#cin_address_line1').val());
            $('#cin_maddress_postcode').val($('#cin_address_postcode').val());
            $('#cin_mstate_id').val($('#cin_state_id').val());
            f_set_city('cin_mcity_id', $('#cin_city_id').val(), 'cin_mstate_id', $('#cin_state_id').val()); 
            $('#cin_mcity_id').prop('disabled', true);
        } 
    }
        
</script>