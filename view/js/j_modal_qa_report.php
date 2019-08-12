<script src="js/plugin/summernote/summernote.min.js"></script>

<script type="text/javascript">
        
    var mqa_otable;
    var mqa_load_type;
    var mqa_1st_load = true;
    var arr_qa_check; 
    var mqa_otable_calibrate_1;
    var data_mqa_calibrate_1;
    var mqa_otable_calibrate_2;
    var data_mqa_calibrate_2;
    var mqa_otable_calibrate_3;
    var data_mqa_calibrate_3;
    var mqa_otable_calibrate_4;
    var data_mqa_calibrate_4;
    var mqa_otable_supportDoc;
    var data_mqa_supportDoc;
    
    $(document).ready(function () {
        
        $('#mqa_snote_wfTask_remark').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#form_mqa').bootstrapValidator('revalidateField', 'mqa_snote_wfTask_remark');
                    $('#mqa_snote_wfTask_remark').val(contents);
                }
            }
        });  
        
        $('#mqa_snote_wfTask_verify').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#form_mqa_verify').bootstrapValidator('revalidateField', 'mqa_snote_wfTask_verify');
                    $('#mqa_snote_wfTask_verify').val(contents);
                }
            }
        });  
        
        $('#mqa_qa_dateActual').datepicker({
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
                $('#form_mqa').bootstrapValidator('revalidateField', 'mqa_qa_dateActual');
            }
        });
        
        $('#mqa_indAll_datePoolStart').datepicker({
            dateFormat: 'yy-mm-dd',
            defaultDate: '0',
            changeMonth: true,
            changeYear: true,
            minDate: '0', 
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
                $('#form_mqa').bootstrapValidator('revalidateField', 'mqa_indAll_datePoolStart');
            }
        });               
        
        $('#modal_qa_report').on('hide.bs.modal', function() {
            var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
            bootstrapValidator.removeField('mqa_qaCheck_id_1[]');
            bootstrapValidator.removeField('mqa_qaCheck_id_2[]');
            bootstrapValidator.removeField('mqa_qaCheck_id_3[]');
            bootstrapValidator.removeField('mqa_qaCheck_id_4[]');
            $.each(data_mqa_calibrate_1, function(u){
                var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                bootstrapValidator.removeField('mqa_qaCalibrate_before_'+data_mqa_calibrate_1[u].qaCalibrate_id);
                bootstrapValidator.removeField('mqa_qaCalibrate_after_'+data_mqa_calibrate_1[u].qaCalibrate_id);
            });
            $.each(data_mqa_calibrate_2, function(u){
                var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                bootstrapValidator.removeField('mqa_qaCalibrate_before_'+data_mqa_calibrate_2[u].qaCalibrate_id);
                bootstrapValidator.removeField('mqa_qaCalibrate_after_'+data_mqa_calibrate_2[u].qaCalibrate_id);
                bootstrapValidator.removeField('mqa_qaCalibrate_trace_'+data_mqa_calibrate_2[u].qaCalibrate_id);
            });
            $.each(data_mqa_calibrate_3, function(u){
                var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                bootstrapValidator.removeField('mqa_qaCalibrate_before_'+data_mqa_calibrate_3[u].qaCalibrate_id);
                bootstrapValidator.removeField('mqa_qaCalibrate_after_'+data_mqa_calibrate_3[u].qaCalibrate_id);
            });
            $.each(data_mqa_calibrate_4, function(u){
                var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                bootstrapValidator.removeField('mqa_qaCalibrate_before_'+data_mqa_calibrate_4[u].qaCalibrate_id);
                bootstrapValidator.removeField('mqa_qaCalibrate_after_'+data_mqa_calibrate_4[u].qaCalibrate_id);
                bootstrapValidator.removeField('mqa_qaCalibrate_trace_'+data_mqa_calibrate_4[u].qaCalibrate_id);
            });
        });  
        
        $('#form_mqa').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mqa_qa_dateActual : {
                    validators: {
                        notEmpty: {
                            message: 'Actual Test Date is required'
                        }
                    }
                },    
                mqa_qa_responseTime_less200 : {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        numeric: {
                            message: 'Not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Must be greater than 0',
                            callback: function (value, validator, $field) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mqa_qa_responseTime_more200 : {
                    validators: {
                        notEmpty: {
                            message: 'Required'
                        },
                        numeric: {
                            message: 'Not a valid number',
                            thousandsSeparator: '',
                            decimalSeparator: '.'
                        },
                        callback: {
                            message: 'Must be greater than 0',
                            callback: function (value, validator, $field) {
                                return (parseFloat(value) > 0);
                            }
                        }
                    }
                },
                mqa_indAll_datePoolStart : {
                    validators: {
                        notEmpty: {
                            message: 'Pooling Start Date is required'
                        }
                    }
                },
                mqa_snote_wfTask_remark : {
                    validators: {
                        callback: {
                            message: 'Additional Message is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mqa_snote_wfTask_remark"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });  
        
        var datatable_mqa_calibrate_1 = undefined; 
        mqa_otable_calibrate_1 = $('#datatable_mqa_calibrate_1').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqa_calibrate_1) {
                    datatable_mqa_calibrate_1 = new ResponsiveDatatablesHelper($('#datatable_mqa_calibrate_1'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqa_calibrate_1.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqa_calibrate_1.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                        bootstrapValidator.addField('mqa_qaCalibrate_before_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqa_qaCalibrate_after_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_desc',
                        mRender: function (data, type, row) {
                            return data + (row.inputParam_id=='8'?' (%)':' (mg/m<sup>3</sup>)');
                        }
                    },
                    {mData: 'qaCalibrate_concentration', sClass: 'text-right'},
                    {mData: 'qaCalibrate_before', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" name="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_before!=null?row.qaCalibrate_before:'')+'"/>' +                                
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaCalibrate_after', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" name="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_after!=null?row.qaCalibrate_after:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = data == null ? '' : '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                            return $label;
                        }
                    }
                ]
        });

        var datatable_mqa_calibrate_2 = undefined; 
        mqa_otable_calibrate_2 = $('#datatable_mqa_calibrate_2').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqa_calibrate_2) {
                    datatable_mqa_calibrate_2 = new ResponsiveDatatablesHelper($('#datatable_mqa_calibrate_2'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqa_calibrate_2.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqa_calibrate_2.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                        bootstrapValidator.addField('mqa_qaCalibrate_before_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqa_qaCalibrate_after_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqa_qaCalibrate_trace_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_desc',
                        mRender: function (data, type, row) {
                            return data + (row.inputParam_id=='8'?' (%)':' (mg/m<sup>3</sup>)');
                        }
                    },
                    {mData: 'qaCalibrate_concentration', sClass: 'text-right'},
                    {mData: 'qaCalibrate_before', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" style="width:90px" name="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_before!=null?row.qaCalibrate_before:'')+'"/>' +                                
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaCalibrate_after', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" style="width:90px" name="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_after!=null?row.qaCalibrate_after:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaCalibrate_traceReference', sClass: 'text-right'},
                    {mData: 'qaCalibrate_traceActual', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" style="width:90px" name="mqa_qaCalibrate_trace_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_trace_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_traceActual!=null?row.qaCalibrate_traceActual:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = data == null ? '' : '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mqa_calibrate_3 = undefined; 
        mqa_otable_calibrate_3 = $('#datatable_mqa_calibrate_3').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqa_calibrate_3) {
                    datatable_mqa_calibrate_3 = new ResponsiveDatatablesHelper($('#datatable_mqa_calibrate_3'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqa_calibrate_3.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqa_calibrate_3.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                        bootstrapValidator.addField('mqa_qaCalibrate_before_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqa_qaCalibrate_after_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_desc',
                        mRender: function (data, type, row) {
                            return data + (row.inputParam_id=='8'?' (%)':' (mg/m<sup>3</sup>)');
                        }
                    },
                    {mData: 'qaCalibrate_concentration', sClass: 'text-right'},
                    {mData: 'qaCalibrate_before', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" name="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_before!=null?row.qaCalibrate_before:'')+'"/>' +                                
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaCalibrate_after', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" name="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_after!=null?row.qaCalibrate_after:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = data == null ? '' : '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                            return $label;
                        }
                    }
                ]
        });

        var datatable_mqa_calibrate_4 = undefined; 
        mqa_otable_calibrate_4 = $('#datatable_mqa_calibrate_4').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqa_calibrate_4) {
                    datatable_mqa_calibrate_4 = new ResponsiveDatatablesHelper($('#datatable_mqa_calibrate_4'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqa_calibrate_4.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqa_calibrate_4.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                        bootstrapValidator.addField('mqa_qaCalibrate_before_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqa_qaCalibrate_after_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqa_qaCalibrate_trace_'+visibleRows[j].qaCalibrate_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must be number',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_desc',
                        mRender: function (data, type, row) {
                            return data + (row.inputParam_id=='8'?' (%)':' (mg/m<sup>3</sup>)');
                        }
                    },
                    {mData: 'qaCalibrate_traceReference', sClass: 'text-right'},
                    {mData: 'qaCalibrate_before', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" style="width:90px" name="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_before_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_before!=null?row.qaCalibrate_before:'')+'"/>' +                                
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaCalibrate_after', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" style="width:90px" name="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_after_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_after!=null?row.qaCalibrate_after:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaCalibrate_concentration', sClass: 'text-right'},
                    {mData: 'qaCalibrate_traceActual', sClass: 'padding-5',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group"><div class="col-md-12">' +
                                '<input type="text" class="form-control" style="width:90px" name="mqa_qaCalibrate_trace_'+row.qaCalibrate_id+'" id="mqa_qaCalibrate_trace_'+row.qaCalibrate_id+'" value="'+(row.qaCalibrate_traceActual!=null?row.qaCalibrate_traceActual:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'status_desc', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = data == null ? '' : '<b class="badge bg-color-'+row.status_color+'"> '+data+' </b>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#form_mqa_doc').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mqa_supDoc_file: {
                    validators: {
                        notEmpty: {
                            message: 'Supporting Attachment File is required'
                        },
                        file: {
                            extension: 'pdf',
                            type: 'application/pdf',
                            maxSize: '20000000',
                            message: 'Only PDF file format max 20MB allowed.'
                        }
                    }
                },
                mqa_supDoc_name : {
                    validators: {
                        notEmpty: {
                            message: 'Supporting Attachment Name is required'
                        },
                        stringLength : {
                            max : 30,
                            message : 'Supporting Attachment Name must be not more than 30 characters long'
                        }
                    }
                }
            }
        });
        
        var datatable_mqa_supportDoc = undefined; 
        mqa_otable_supportDoc = $('#datatable_mqa_supportDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqa_supportDoc) {
                    datatable_mqa_supportDoc = new ResponsiveDatatablesHelper($('#datatable_mqa_supportDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqa_supportDoc.createExpandIcon(nRow);
                var info = mqa_otable_supportDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mqa_supportDoc.respond();
            },
            "aoColumns":
                [
                    {mData: null},
                    {mData: 'document_name'},
                    {mData: 'document_uplname'},
                    {mData: null, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (row.document_id != null)
                                $label += '<a type="button" class="btn btn-success btn-xs" title="Download Support Document" href="process/download.php?doc_id='+row.document_id+'"><i class="fa fa-download"></i></a>';
                            $label += ' <button type="button" class="btn btn-danger btn-xs mqa_hide_view" title="Delete" onclick="f_mqa_delete_supportDoc ('+row.qaDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#mqa_btn_add_supDoc').on('click', function () {
            var bootstrapValidator = $("#form_mqa_doc").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mqa_doc')[0]);
                    formData.append('funct', 'save_qa_doc');
                    formData.append('mqa_qa_id', $('#mqa_qa_id').val());
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
                                f_notify(1, 'Success', 'Supporting Document successfully added.');
                                $('#form_mqa_doc').trigger('reset');
                                $('#form_mqa_doc').bootstrapValidator('resetForm', true);
                                data_mqa_supportDoc = f_get_general_info_multiple('dt_qa_document', {qa_id:$('#mqa_qa_id').val()}, '', '', 'qa_id');
                                f_dataTable_draw(mqa_otable_supportDoc, data_mqa_supportDoc, 'datatable_mqa_supportDoc', 4);
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
                f_notify(2, 'Error', errMsg_validation);    
                return false;
            }
        }); 
        
        $('#form_mqa_verify').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mqa_result : {
                    validators: {
                        notEmpty: {
                            message: 'Verification Result is required'
                        }
                    }
                },
                mqa_snote_wfTask_verify : {
                    validators: {
                        callback: {
                            message: 'Additional Message is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mqa_snote_wfTask_verify"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#mqa_btn_save').on('click', function () {
            if (($('#mqa_wfTaskType_id').val() == '37' && mqa_otable == 'icm')) {
                $('#mqa_funct').val('save_qa');
                $('#mqa_wfTask_remark').val($('[name="mqa_snote_wfTask_remark"]').summernote('code'));
                if (f_submit_forms('form_mqa_base,#form_mqa', 'p_registration', 'Data successfully saved.')) {
                    data_mqa_calibrate_1 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'1'}, '', '', 'inputParam_id');
                    f_dataTable_draw(mqa_otable_calibrate_1, data_mqa_calibrate_1, 'datatable_mqa_calibrate_1', 5);
                    data_mqa_calibrate_2 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'2'}, '', '', 'inputParam_id');
                    f_dataTable_draw(mqa_otable_calibrate_2, data_mqa_calibrate_2, 'datatable_mqa_calibrate_2', 7);
                    data_mqa_calibrate_3 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'3'}, '', '', 'inputParam_id');
                    f_dataTable_draw(mqa_otable_calibrate_3, data_mqa_calibrate_3, 'datatable_mqa_calibrate_3', 5);
                    data_mqa_calibrate_4 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'4'}, '', '', 'inputParam_id');
                    f_dataTable_draw(mqa_otable_calibrate_4, data_mqa_calibrate_4, 'datatable_mqa_calibrate_4', 7);
                }
            } else if (jQuery.inArray($('#mqa_wfTaskType_id').val(), ['38', '48']) >= 0 && mqa_otable == 'itp') {
                $('#mqa_funct').val('save_verify_initial_RATA');
                $('#mqa_wfTask_verify').val($('[name="mqa_snote_wfTask_verify"]').summernote('code'));
                f_submit_forms('form_mqa_base,#form_mqa_verify', 'p_registration', 'Data successfully saved.');
            } else {  
                f_notify(2, 'Error', errMsg_default);    
                return false;
            }
        }); 
        
        $('#mqa_btn_submit').on('click', function () {
            if (($('#mqa_wfTaskType_id').val() == '37' && mqa_otable == 'icm')) {
                var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mqa_funct').val('save_qa');
                $('#mqa_wfTask_remark').val($('[name="mqa_snote_wfTask_remark"]').summernote('code'));
                if (!f_submit_forms('form_mqa_base,#form_mqa', 'p_registration'))                     
                    return false;
                data_mqa_calibrate_1 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'1'}, '', '', 'inputParam_id');
                f_dataTable_draw(mqa_otable_calibrate_1, data_mqa_calibrate_1, 'datatable_mqa_calibrate_1', 5);
                data_mqa_calibrate_2 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'2'}, '', '', 'inputParam_id');
                f_dataTable_draw(mqa_otable_calibrate_2, data_mqa_calibrate_2, 'datatable_mqa_calibrate_2', 7);
                data_mqa_calibrate_3 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'3'}, '', '', 'inputParam_id');
                f_dataTable_draw(mqa_otable_calibrate_3, data_mqa_calibrate_3, 'datatable_mqa_calibrate_3', 5);
                data_mqa_calibrate_4 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'4'}, '', '', 'inputParam_id');
                f_dataTable_draw(mqa_otable_calibrate_4, data_mqa_calibrate_4, 'datatable_mqa_calibrate_4', 7);
            } else if (jQuery.inArray($('#mqa_wfTaskType_id').val(), ['38', '48']) >= 0 && mqa_otable == 'itp') {
                var bootstrapValidator = $("#form_mqa_verify").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $('#mqa_funct').val('save_verify_initial_RATA');
                $('#mqa_wfTask_verify').val($('[name="mqa_snote_wfTask_verify"]').summernote('code'));
                if (!f_submit_forms('form_mqa_base,#form_mqa_verify', 'p_registration'))                     
                    return false;
            } else {  
                f_notify(2, 'Error', errMsg_default);    
                return false;
            }
            $.SmartMessageBox({
                title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                content : "Are you sure?",
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Yes") {
                    var submit_message = jQuery.inArray($('#mqa_wfTaskType_id').val(), ['38','48']) >= 0 ? 'The report successfully submitted' : 'The verification result submitted';
                    var condition_no = '';
                    var submit_status = '';
                    if (jQuery.inArray($('#mqa_wfTaskType_id').val(), ['37','47']) >= 0) {
                        submit_status = $('#mqa_wfTask_status').val() == '22' ?  '13' : '10'; 
                    } else if (jQuery.inArray($('#mqa_wfTaskType_id').val(), ['38','48']) >= 0) {
                        submit_status = $('input[name="mqa_result"]:checked').val();
                        condition_no = submit_status == '12' ? '1' : '';
                    } else {  
                        f_notify(2, 'Error', errMsg_default);    
                        return false;
                    }
                    if (f_submit($('#mqa_wfTask_id').val(), $('#mqa_wfTaskType_id').val(), submit_status, submit_message, $('#mqa_wfTask_remark').val(), condition_no, '', '', $('#mqa_wfTask_refName').val(), $('#mqa_wfTask_refValue').val())) {
                        if ($('#mqa_wfTaskType_id').val() == '37') {
                            if (mqa_otable == 'icm') {
                                f_table_icm ();
                            } 
                            f_send_email('email_verify_initRATA', {wfTask_id:result_submit_task}); 
                        } else if ($('#mqa_wfTaskType_id').val() == '38') {
                            if (mqa_otable == 'itp') {
                                f_table_itp_new ();
                                f_table_itp_history ();
                            } 
                            f_send_email('email_return_initRATA', {wfTask_id:$('#mqa_wfTask_id').val()}); 
                        }
                        $('#modal_qa_report').modal('hide');
                    }
                }
            });
        });   
        
    });
    
    function f_mqa_delete_supportDoc (qaDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_qa_doc', {qaDoc_id: qaDoc_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mqa_supportDoc = f_get_general_info_multiple('dt_qa_document', {qa_id:$('#mqa_qa_id').val()}, '', '', 'qa_id');
                f_dataTable_draw(mqa_otable_supportDoc, data_mqa_supportDoc, 'datatable_mqa_supportDoc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mqa_get_type(qaType_id) {
        var qaType_desc = '';
        if (qaType_id == 1) { 
            qaType_desc = 'Initial RATA (CEMS)';
        } else if (qaType_id == 2) { 
            qaType_desc = 'Initial RATA (PEMS)';
        } else if (qaType_id == 3) {
            qaType_desc = 'RATA (CEMS)';
        } else if (qaType_id == 4) {
            qaType_desc = 'RAA (CEMS)';
        } else if (qaType_id == 5) {
            qaType_desc = 'RATA (PEMS)';
        } else if (qaType_id == 6) {
            qaType_desc = 'RAA (PEMS)';
        } 
        return qaType_desc;
    }
    
    function f_load_qa_report(load_type, qa_id, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mqa_base, #form_mqa, #form_mqa_doc, #form_mqa_verify').trigger('reset');   
            $('#mqa_snote_wfTask_remark').summernote('code', '');
            $('#mqa_snote_wfTask_verify').summernote('code', '');
            $('#mqa_snote_wfTask_remark').summernote('disable');
            $('#form_mqa').bootstrapValidator('resetForm', true);
            $('#form_mqa_doc').bootstrapValidator('resetForm', true);
            $('#form_mqa_verify').bootstrapValidator('resetForm', true);
            if (qa_id == '' && wfTask_id == '') {
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
                f_notify(2, 'Error', errMsg_default);    
                return false;
            } 
            var wfTask_qa = wfTask_id;
            if (qa_id == '') {
                var wfTrans_id = f_get_value_from_table('wf_task', 'wfTask_id', wfTask_id, 'wfTrans_id');
                var qa_task = f_get_general_info_multiple('wf_task', {wfTrans_id:wfTrans_id, wfTaskType_id:'(37,47)'}, '', '', 'wfTask_id DESC');
                wfTask_qa = qa_task[0].wfTask_id;
                qa_id = f_get_value_from_table('t_qa', 'wfTask_id', wfTask_qa, 'qa_id');
            } else if (wfTask_id == '') {
                wfTask_id = f_get_value_from_table('t_qa', 'qa_id', qa_id, 'wfTask_id');
            } 
            if (qa_id == '' || wfTask_id == '') {
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
                f_notify(2, 'Error', errMsg_default);    
                return false;
            } 
            $('#mqa_qa_id').val(qa_id); 
            mqa_load_type = load_type;
            mqa_otable = otable;
            $('#form_mqa').find('input, textarea, select').prop('disabled',false);
            $('.mqa_disabled').prop('disabled',true);
            $('.mqa_hide_view, .mqa_show_view, #mqa_alert_box, .mqa_div_verify').hide();             
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'mqa');  
            var arr_steps = f_get_general_info_multiple('wf_task_type', {wfFlow_id:task_info.wfFlow_id, wfTaskType_isEnd:'N'});
            var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:task_info.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
            var wfTaskType_turn = task_info.wfTaskType_turn != '0' ? task_info.wfTaskType_turn : f_get_value_from_table('wf_task_type', 'wfTaskType_id', previous_task[0].wfTaskType_id, 'wfTaskType_turn');
            f_steps (arr_steps, wfTaskType_turn, 'mqa_steps');            
            var qa_info = f_get_general_info('vw_qa_info', {}, 'mqa', '', {wfTask_id:wfTask_qa});
            $('#mqa_wfTask_id').val(wfTask_id); 
            $('#mqa_label_title').html(f_mqa_get_type(qa_info.qa_type));       
            $('#lmqa_qaType_desc').html(f_mqa_get_type(qa_info.qa_type));
            $('[name="mqa_snote_wfTask_remark"]').summernote('code', qa_info.qa_message);
            $('#form_mqa').bootstrapValidator('resetField', 'mqa_snote_wfTask_remark');
            arr_qa_check = f_get_general_info_multiple('dt_qa_check', {qa_id:qa_id}, {}, '', 'qaChecklist_type, qaChecklist_id');
            $('#mqa_div_qaCheck_1, #mqa_div_qaCheck_2, #mqa_div_qaCheck_3, #mqa_div_qaCheck_4').html('');
            $.each(arr_qa_check, function(u){
                var checked = arr_qa_check[u].qaCheck_checked == '1' ? 'checked' : '';
                var html = '<div class="checkbox"><label>';
                html += '<input type="checkbox" class="checkbox" name="mqa_qaCheck_id_'+arr_qa_check[u].qaChecklist_type+'[]" value="'+arr_qa_check[u].qaCheck_id+'" '+checked+'>';
                html += '<span>'+arr_qa_check[u].qaChecklist_desc+'</span>';
                html += '</label></div>';
                $('#mqa_div_qaCheck_'+arr_qa_check[u].qaChecklist_type).append(html);
            });
            var bootstrapValidator = $("#form_mqa").data('bootstrapValidator');
            bootstrapValidator.addField('mqa_qaCheck_id_1[]', {validators:{choice:{min:1,message:'At least 1 activity required'}}});
            bootstrapValidator.addField('mqa_qaCheck_id_2[]', {validators:{choice:{min:1,message:'At least 1 activity required'}}});
            bootstrapValidator.addField('mqa_qaCheck_id_3[]', {validators:{choice:{min:1,message:'At least 1 activity required'}}});
            bootstrapValidator.addField('mqa_qaCheck_id_4[]', {validators:{choice:{min:1,message:'At least 1 activity required'}}});
            data_mqa_calibrate_1 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'1'}, '', '', 'inputParam_id');
            f_dataTable_draw(mqa_otable_calibrate_1, data_mqa_calibrate_1, 'datatable_mqa_calibrate_1', 5);
            data_mqa_calibrate_2 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'2'}, '', '', 'inputParam_id');
            f_dataTable_draw(mqa_otable_calibrate_2, data_mqa_calibrate_2, 'datatable_mqa_calibrate_2', 7);
            data_mqa_calibrate_3 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'3'}, '', '', 'inputParam_id');
            f_dataTable_draw(mqa_otable_calibrate_3, data_mqa_calibrate_3, 'datatable_mqa_calibrate_3', 5);
            data_mqa_calibrate_4 = f_get_general_info_multiple('dt_qa_calibrate', {qa_id:$('#mqa_qa_id').val(), qaCalibrate_type:'4'}, '', '', 'inputParam_id');
            f_dataTable_draw(mqa_otable_calibrate_4, data_mqa_calibrate_4, 'datatable_mqa_calibrate_4', 7);
            data_mqa_supportDoc = f_get_general_info_multiple('dt_qa_document', {qa_id:$('#mqa_qa_id').val()}, '', '', 'qa_id');
            f_dataTable_draw(mqa_otable_supportDoc, data_mqa_supportDoc, 'datatable_mqa_supportDoc', 4);
            if (mqa_load_type == 2) {          
                if (previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {                    
                    $('#mqa_alert_box').show();
                    $('#mqa_alert_message').html(previous_task[0].wfTask_remark);
                    var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                    $('#mqa_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                }
                $('.mqa_show_view').hide();
                $('.mqa_hide_view').show();    
                $('#mqa_snote_wfTask_remark').summernote('enable');
            } else if (mqa_load_type >= 3) {
                $('#form_mqa').find('input, textarea, select').prop('disabled',true);
                $('#mqa_snote_wfTask_remark').summernote('disable');
                $('.mqa_show_view').show();
                $('.mqa_hide_view').hide();
                if (mqa_load_type == 4) {
                    $("input[name='mqa_result'][value=" + task_info.wfTask_statusSave + "]").prop('checked', true);
                    if (task_info.wfTask_remark != null && task_info.wfTask_remark != '<p><br></p>')
                        $('[name="mqa_snote_wfTask_verify"]').summernote('code', task_info.wfTask_remark);
                    else
                        $('[name="mqa_snote_wfTask_verify"]').summernote('code', '');
                    $('#form_mqa_verify').bootstrapValidator('resetField', 'mqa_snote_wfTask_verify');
                    $('.mqa_div_verify, #mqa_btn_save, #mqa_btn_submit').show();
                }
            } else {
                f_notify(2, 'Ralat', errMsg_default);
                return false;
            }  
            
            $('#modal_qa_report').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
</script>