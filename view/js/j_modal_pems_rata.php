<script src="js/plugin/summernote/summernote.min.js"></script>

<script type="text/javascript">
    
    var mqk_otable;
    var mqk_load_type;
    var data_mqk_raLow;
    var mqk_otable_raLow;
    var data_mqk_raLow;
    var mqk_otable_raLow;
    var data_mqk_raHigh;
    var mqk_otable_raHigh;
    var data_mqk_ftest;
    var mqk_otable_ftest;
    var arr_param = [];
        
    $(document).ready(function () {
        
        var arr_input_param = f_get_general_info_multiple('t_input_parameter');
        $.each(arr_input_param, function(u){
            arr_param[parseInt(arr_input_param[u].inputParam_id)] = arr_input_param[u].inputParam_desc;
        });
        
        $('#mqk_snote_qa_message').summernote({
            height: 150,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']]
            ]
        });   
        
        $('#mqk_snote_wfTask_verify').summernote({
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
                    $('#form_mqk_verify').bootstrapValidator('revalidateField', 'mqk_snote_wfTask_verify');
                    $('#mqk_snote_wfTask_verify').val(contents);
                }
            }
        });  
        
        $('#mqk_qa_dateActual').datepicker({
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
                $('#form_mqk_form').bootstrapValidator('revalidateField', 'mqk_qa_dateActual');
            }
        });
        
        $('#mqk_indAll_datePoolStart').datepicker({
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
                $('#form_mqk_form').bootstrapValidator('revalidateField', 'mqk_indAll_datePoolStart');
            }
        });     
        
        $('#form_mqk_form').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
                mqk_qa_dateActual : {
                    validators : {
                        notEmpty: {
                            message: 'Actual Test Date is required'
                        }                     
                    }
                },
                mqk_indAll_datePoolStart : {
                    validators : {
                        notEmpty: {
                            message: 'Pooling Start Date is required'
                        }                     
                    }
                }
            }
        });
        
        $('#form_mqk_form_2').bootstrapValidator({      
            excluded: ':disabled',
            fields: {  
            }
        });
        
        var datatable_mqk_raLow = undefined; 
        mqk_otable_raLow = $('#datatable_mqk_raLow').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqk_raLow) {
                    datatable_mqk_raLow = new ResponsiveDatatablesHelper($('#datatable_mqk_raLow'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqk_raLow.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqk_raLow.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                        bootstrapValidator.addField('mqk_qaRa_rmAverage_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaRa_average_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaRa_ra_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_id', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return arr_param[parseInt(data)];
                        }
                    },
                    {mData: 'qaRa_rmAverage', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_rmAverage_'+row.qaRa_id+'" id="mqk_qaRa_rmAverage_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'" onkeyup="f_mqk_calc_diff('+row.qaRa_id+');"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_average', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_average_'+row.qaRa_id+'" id="mqk_qaRa_average_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'" onkeyup="f_mqk_calc_diff('+row.qaRa_id+');"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_difference', sClass: 'text-right',
                        mRender: function (data, type, row) {                            
                            $label = '<span id="lmqk_qaRa_difference_'+row.qaRa_id+'">'+(data!=null?formattedNumber(data,3):'')+'</span>';
                            $label += '<input type="hidden" name="mqk_qaRa_difference_'+row.qaRa_id+'" id="mqk_qaRa_difference_'+row.qaRa_id+'"  value="'+(data!=null?data:'')+'" />';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_ra', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_ra_'+row.qaRa_id+'" id="mqk_qaRa_ra_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_status', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (data == '36')
                                $label = '<b class="badge bg-color-green"> Pass </b>';
                            else if (data == '6')
                                $label = '<b class="badge bg-color-red"> Fail </b>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mqk_raNormal = undefined; 
        mqk_otable_raNormal = $('#datatable_mqk_raNormal').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqk_raNormal) {
                    datatable_mqk_raNormal = new ResponsiveDatatablesHelper($('#datatable_mqk_raNormal'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqk_raNormal.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqk_raNormal.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                        bootstrapValidator.addField('mqk_qaRa_rmAverage_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaRa_average_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaRa_ra_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_id', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return arr_param[parseInt(data)];
                        }
                    },
                    {mData: 'qaRa_rmAverage', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_rmAverage_'+row.qaRa_id+'" id="mqk_qaRa_rmAverage_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'" onkeyup="f_mqk_calc_diff('+row.qaRa_id+');"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_average', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_average_'+row.qaRa_id+'" id="mqk_qaRa_average_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'" onkeyup="f_mqk_calc_diff('+row.qaRa_id+');"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_difference', sClass: 'text-right',
                        mRender: function (data, type, row) {                            
                            $label = '<span id="lmqk_qaRa_difference_'+row.qaRa_id+'">'+(data!=null?formattedNumber(data,3):'')+'</span>';
                            $label += '<input type="hidden" name="mqk_qaRa_difference_'+row.qaRa_id+'" id="mqk_qaRa_difference_'+row.qaRa_id+'"  value="'+(data!=null?data:'')+'" />';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_ra', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_ra_'+row.qaRa_id+'" id="mqk_qaRa_ra_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_status', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (data == '36')
                                $label = '<b class="badge bg-color-green"> Pass </b>';
                            else if (data == '6')
                                $label = '<b class="badge bg-color-red"> Fail </b>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mqk_raHigh = undefined; 
        mqk_otable_raHigh = $('#datatable_mqk_raHigh').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqk_raHigh) {
                    datatable_mqk_raHigh = new ResponsiveDatatablesHelper($('#datatable_mqk_raHigh'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqk_raHigh.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqk_raHigh.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                        bootstrapValidator.addField('mqk_qaRa_rmAverage_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaRa_average_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaRa_ra_'+visibleRows[j].qaRa_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_id', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return arr_param[parseInt(data)];
                        }
                    },
                    {mData: 'qaRa_rmAverage', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_rmAverage_'+row.qaRa_id+'" id="mqk_qaRa_rmAverage_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'" onkeyup="f_mqk_calc_diff('+row.qaRa_id+');"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_average', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_average_'+row.qaRa_id+'" id="mqk_qaRa_average_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'" onkeyup="f_mqk_calc_diff('+row.qaRa_id+');"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_difference', sClass: 'text-right',
                        mRender: function (data, type, row) {                            
                            $label = '<span id="lmqk_qaRa_difference_'+row.qaRa_id+'">'+(data!=null?formattedNumber(data,3):'')+'</span>';
                            $label += '<input type="hidden" name="mqk_qaRa_difference_'+row.qaRa_id+'" id="mqk_qaRa_difference_'+row.qaRa_id+'"  value="'+(data!=null?data:'')+'" />';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_ra', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaRa_ra_'+row.qaRa_id+'" id="mqk_qaRa_ra_'+row.qaRa_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaRa_status', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (data == '36')
                                $label = '<b class="badge bg-color-green"> Pass </b>';
                            else if (data == '6')
                                $label = '<b class="badge bg-color-red"> Fail </b>';
                            return $label;
                        }
                    }
                ]
        });
        
        var datatable_mqk_ftest = undefined; 
        mqk_otable_ftest = $('#datatable_mqk_ftest').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqk_ftest) {
                    datatable_mqk_ftest = new ResponsiveDatatablesHelper($('#datatable_mqk_ftest'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqk_ftest.createExpandIcon(nRow);
            },
            "drawCallback": function (oSettings) {
                datatable_mqk_ftest.respond();
                var api = this.api();
                var visibleRows=api.rows().data();
                if(visibleRows.length >= 1){
                    for(var j=0;j<visibleRows.length;j++){
                        var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                        bootstrapValidator.addField('mqk_qaFtest_low_'+visibleRows[j].qaFtest_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaFtest_mid_'+visibleRows[j].qaFtest_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaFtest_high_'+visibleRows[j].qaFtest_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                        bootstrapValidator.addField('mqk_qaFtest_corrValue_'+visibleRows[j].qaFtest_id, {validators:{notEmpty:{message:'Required'},numeric:{message:'Must numeric',thousandsSeparator: '',decimalSeparator: '.'}}});
                    }
                }
            },
            "aoColumns":
                [
                    {mData: 'inputParam_id', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            return arr_param[parseInt(data)];
                        }
                    },
                    {mData: 'qaFtest_low', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaFtest_low_'+row.qaFtest_id+'" id="mqk_Ftest_low_'+row.qaFtest_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaFtest_mid', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaFtest_mid_'+row.qaFtest_id+'" id="mqk_qaFtest_mid_'+row.qaFtest_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaFtest_high', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaFtest_high_'+row.qaFtest_id+'" id="mqk_qaFtest_high_'+row.qaFtest_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaFtest_result', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (data == '36')
                                $label = '<b class="badge bg-color-green"> Pass </b>';
                            else if (data == '6')
                                $label = '<b class="badge bg-color-red"> Fail </b>';
                            return $label;
                        }
                    },
                    {mData: 'qaFtest_corrValue', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '<div class="form-group margin-bottom-0"><div class="col-md-12">' +
                                '<input type="text" class="input-sm form-control" style="width:100%" name="mqk_qaFtest_corrValue_'+row.qaFtest_id+'" id="mqk_qaFtest_corrValue_'+row.qaFtest_id+'" value="'+(data!=null?data:'')+'"/>' +
                                '</div></div>';
                            return $label;
                        }
                    },
                    {mData: 'qaFtest_corrResult', sClass: 'padding-5 text-center',
                        mRender: function (data, type, row) {
                            $label = '';
                            if (data == '36')
                                $label = '<b class="badge bg-color-green"> Pass </b>';
                            else if (data == '6')
                                $label = '<b class="badge bg-color-red"> Fail </b>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#form_mqk_doc').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mqk_supDoc_file: {
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
                mqk_supDoc_name : {
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
        
        var datatable_mqk_supportDoc = undefined; 
        mqk_otable_supportDoc = $('#datatable_mqk_supportDoc').DataTable({
            "paging": false,
            "ordering": false,
            "autoWidth": false,
            "info": false,
            "bFilter": false,
            "preDrawCallback": function () {
                if (!datatable_mqk_supportDoc) {
                    datatable_mqk_supportDoc = new ResponsiveDatatablesHelper($('#datatable_mqk_supportDoc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mqk_supportDoc.createExpandIcon(nRow);
                var info = mqk_otable_supportDoc.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mqk_supportDoc.respond();
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
                            $label += ' <button type="button" class="btn btn-danger btn-xs mqk_hide_view" title="Delete" onclick="f_mqk_delete_supportDoc ('+row.qaDoc_id+');"><i class="fa fa-trash-o"></i></button>';
                            return $label;
                        }
                    }
                ]
        });
        
        $('#mqk_btn_add_supDoc').on('click', function () {
            var bootstrapValidator = $("#form_mqk_doc").data('bootstrapValidator');
            bootstrapValidator.validate();
            if (bootstrapValidator.isValid()) {       
                $('#modal_waiting').on('shown.bs.modal', function(e){      
                    var formData = new FormData($('#form_mqk_doc')[0]);
                    formData.append('funct', 'save_qa_doc_k');
                    formData.append('mqk_qa_id', $('#mqk_qa_id').val());
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
                                $('#form_mqk_doc').trigger('reset');
                                $('#form_mqk_doc').bootstrapValidator('resetForm', true);
                                data_mqk_supportDoc = f_get_general_info_multiple('dt_qa_document', {qa_id:$('#mqk_qa_id').val()}, '', '', 'qa_id');
                                f_dataTable_draw(mqk_otable_supportDoc, data_mqk_supportDoc, 'datatable_mqk_supportDoc', 4);
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
        
        $('#form_mqk_verify').bootstrapValidator({
            excluded: ':disabled',
            fields: {  
                mqk_result : {
                    validators: {
                        notEmpty: {
                            message: 'Verification Result is required'
                        }
                    }
                },
                mqk_snote_wfTask_verify : {
                    validators: {
                        callback: {
                            message: 'Message/Feedback is required',
                            callback: function(value, validator, $field) {
                                var code = $('[name="mqk_snote_wfTask_verify"]').summernote('code');
                                return (code !== '' && code !== '<p><br></p>');
                            }
                        }
                    }
                }
            }
        });
        
        $('#modal_pems_rata').on('hide.bs.modal', function() {
            $.each(data_mqk_raLow, function(u){
                var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                bootstrapValidator.removeField('mqk_qaRa_rmAverage_'+data_mqk_raLow[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaRa_average_'+data_mqk_raLow[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaRa_ra_'+data_mqk_raLow[u].qaRa_id);
            });
            $.each(data_mqk_raNormal, function(u){
                var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                bootstrapValidator.removeField('mqk_qaRa_rmAverage_'+data_mqk_raNormal[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaRa_average_'+data_mqk_raNormal[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaRa_ra_'+data_mqk_raNormal[u].qaRa_id);
            });
            $.each(data_mqk_raHigh, function(u){
                var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                bootstrapValidator.removeField('mqk_qaRa_rmAverage_'+data_mqk_raHigh[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaRa_average_'+data_mqk_raHigh[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaRa_ra_'+data_mqk_raHigh[u].qaRa_id);
            });
            $.each(data_mqk_ftest, function(u){
                var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                bootstrapValidator.removeField('mqk_qaFtest_low_'+data_mqk_ftest[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaFtest_mid_'+data_mqk_ftest[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaFtest_high_'+data_mqk_ftest[u].qaRa_id);
                bootstrapValidator.removeField('mqk_qaFtest_corrValue_'+data_mqk_ftest[u].qaRa_id);
            });
        }); 
        
        $('#mqk_btn_save').on('click', function () {
            $('#modal_waiting').on('shown.bs.modal', function(e){   
                if (($('#mqk_wfTaskType_id').val() == '47' && mqk_otable == 'ipm') || ($('#mqk_wfTaskType_id').val() == '91' && mqk_otable == 'iqa')) {
                    $('#mqk_funct').val('save_qa_k');
                    $('#mqk_qa_message').val($('[name="mqk_snote_qa_message"]').summernote('code'));
                    if (f_submit_forms('form_mqk_base,#form_mqk_form,#form_mqk_form_2', 'p_registration', 'Data successfully saved.')) {
                        data_mqk_raLow = f_get_general_info_multiple('t_qa_ra', {qa_id:$('#mqk_qa_id').val(), qaRa_loadType:'2'});
                        f_dataTable_draw(mqk_otable_raLow, data_mqk_raLow, 'datatable_mqk_raLow', 6);
                        data_mqk_raNormal = f_get_general_info_multiple('t_qa_ra', {qa_id:$('#mqk_qa_id').val(), qaRa_loadType:'1'});
                        f_dataTable_draw(mqk_otable_raNormal, data_mqk_raNormal, 'datatable_mqk_raNormal', 6);
                        data_mqk_raHigh = f_get_general_info_multiple('t_qa_ra', {qa_id:$('#mqk_qa_id').val(), qaRa_loadType:'3'});
                        f_dataTable_draw(mqk_otable_raHigh, data_mqk_raHigh, 'datatable_mqk_raHigh', 6);
                        data_mqk_ftest = f_get_general_info_multiple('t_qa_ftest', {qa_id:$('#mqk_qa_id').val()});
                        f_dataTable_draw(mqk_otable_ftest, data_mqk_ftest, 'datatable_mqk_ftest', 7);
                    }
                } else if (($('#mqk_wfTaskType_id').val() == '48' && mqk_otable == 'itp')) {
                    $('#mqk_funct').val('save_verify_initial_RATA_k');
                    $('#mqk_wfTask_verify').val($('[name="mqk_snote_wfTask_verify"]').summernote('code'));
                    f_submit_forms('form_mqk_base,#form_mqk_verify', 'p_registration', 'Data successfully saved.');
                } else {  
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
                $('#modal_waiting').modal('hide');
                $(this).unbind(e);
            }).modal('show'); 
        });
        
        $('#mqk_btn_submit').on('click', function () {
            var submit_status = '', submit_group = '', condition_no = '';
            if (mqk_otable == 'ipm' && $('#mqk_wfTaskType_id').val() == '47') {
                var bootstrapValidator = $("#form_mqk_form_2").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                var bootstrapValidator = $("#form_mqk_form").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure to submit this Initial RATA Report?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {
                        $('#modal_waiting').on('shown.bs.modal', function(e){  
                            $('#mqk_funct').val('save_qa_k');
                            $('#mqk_qa_message').val($('[name="mqk_snote_qa_message"]').summernote('code'));
                            if (f_submit_forms('form_mqk_base,#form_mqk_form,#form_mqk_form_2', 'p_registration')) {
                                submit_status = $('#mqk_wfTask_status').val() == '28' ?  '10' : '13';
                                if (f_submit($('#mqk_wfTask_id').val(), $('#mqk_wfTaskType_id').val(), submit_status, 'Initial RATA successfully submitted', $('#mqk_qa_message').val(), condition_no, submit_group, '', $('#mqk_wfTask_refName').val(), $('#mqk_wfTask_refValue').val())) {
                                    f_table_ipm ();
                                    f_send_email('email_verify_initRATA', {wfTask_id:result_submit_task}); 
                                    $('#modal_pems_rata').modal('hide');
                                }
                            }
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });  
            } else if (mqk_otable == 'itp' && $('#mqk_wfTaskType_id').val() == '48') {
                var bootstrapValidator = $("#form_mqk_verify").data('bootstrapValidator');
                bootstrapValidator.validate();
                if (!bootstrapValidator.isValid()) {         
                    f_notify(2, 'Error', errMsg_validation);    
                    return false;
                }
                $.SmartMessageBox({
                    title : "<i class='fa fa-exclamation-circle'></i> Confirmation!",
                    content : "Are you sure?",
                    buttons : '[No][Yes]'
                }, function(ButtonPressed) {
                    if (ButtonPressed === "Yes") {
                        $('#modal_waiting').on('shown.bs.modal', function(e){  
                            $('#mqk_funct').val('save_verify_initial_RATA_k');
                            $('#mqk_wfTask_verify').val($('[name="mqk_snote_wfTask_verify"]').summernote('code'));
                            if (f_submit_forms('form_mqk_base,#form_mqk_verify', 'p_registration')) {
                                submit_status = $('input[name="mqk_result"]:checked').val();
                                condition_no = submit_status == '17' ? '' : '1';
                                if (f_submit($('#mqk_wfTask_id').val(), $('#mqk_wfTaskType_id').val(), submit_status, 'The verification result successfully submitted', $('#mqk_wfTask_verify').val(), condition_no, submit_group, '', $('#mqk_wfTask_refName').val(), $('#mqk_wfTask_refValue').val())) {
                                    f_table_itp_new ();
                                    f_table_itp_history ();
                                    if (submit_status == '12')
                                        f_send_email('email_return_initRATA', {wfTask_id:$('#mqk_wfTask_id').val()}); 
                                    else if (submit_status == '46')
                                        f_send_email('email_redo_initRATA', {wfTask_id:$('#mqk_wfTask_id').val()}); 
                                    $('#modal_pems_rata').modal('hide');
                                }
                            }
                            $('#modal_waiting').modal('hide');
                            $(this).unbind(e);
                        }).modal('show'); 
                    }
                });  
            }
        });   
        
    });
    
    function f_mqk_delete_supportDoc (qaDoc_id) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            if (f_submit_normal('delete_qa_doc', {qaDoc_id: qaDoc_id}, 'p_registration', 'Data successfully deleted.')) {
                data_mqk_supportDoc = f_get_general_info_multiple('dt_qa_document', {qa_id:$('#mqk_qa_id').val()}, '', '', 'qa_id');
                f_dataTable_draw(mqk_otable_supportDoc, data_mqk_supportDoc, 'datatable_mqk_supportDoc', 4);
            }
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
    }
    
    function f_mqk_calc_diff (qaRa_id) {
        var result = parseFloat(0);
        var rmAverage = parseFloat($('#mqk_qaRa_rmAverage_'+qaRa_id).val()!=''?$('#mqk_qaRa_rmAverage_'+qaRa_id).val():0);
        var average = parseFloat($('#mqk_qaRa_average_'+qaRa_id).val()!=''?$('#mqk_qaRa_average_'+qaRa_id).val():0);
        result = (rmAverage - average);
        if (isNaN(result)) {
            $('#lmqk_qaRa_difference_'+qaRa_id).html('');
            $('#mqk_qaRa_difference_'+qaRa_id).val('');
        } else {
            result = result < 0 ? (result*(-1)) : result;
            $('#lmqk_qaRa_difference_'+qaRa_id).html(formattedNumber(result,3));
            $('#mqk_qaRa_difference_'+qaRa_id).val(result);
        }
    }
    
    function f_load_pems_rata(load_type, qa_id, wfTask_id, otable) {
        $('#modal_waiting').on('shown.bs.modal', function(e){
            $('#form_mqk_base, #form_mqk_form, #form_mqk_form_2, #form_mqk_doc, #form_mqk_verify').trigger('reset'); 
            $('#form_mqk_form').bootstrapValidator('resetForm', true);
            $('#form_mqk_form_2').bootstrapValidator('resetForm', true);
            $('#form_mqk_doc').bootstrapValidator('resetForm', true);
            $('#form_mqk_verify').bootstrapValidator('resetForm', true);
            $('#form_mqk_form, #form_mqk_form_2, #form_mqk_doc').find('input, textarea, select').prop('disabled',true);
            $('#mqk_snote_qa_message').summernote('code', '');
            $('#mqk_snote_qa_message').summernote('disable');
            if (qa_id == '' && wfTask_id == '') {
                f_notify(2, 'Error', errMsg_default);    
                return false;
            } 
            if (qa_id == '') {
                // all transaction with null qa_id should be initial RATA.
                var wf_task = f_get_general_info('wf_task', {wfTask_id:wfTask_id}); 
                var arr_qa = f_get_general_info_multiple('vw_qa_task', {wfTrans_id:wf_task.wfTrans_id, wfTask_id:'<='+wfTask_id}, '', '', 'qa_id DESC');
                qa_id = arr_qa[0].qa_id;
            } else if (wfTask_id == '') {
                wfTask_id = f_get_value_from_table('t_qa', 'qa_id', qa_id, 'wfTask_id');
            } 
            if (qa_id == '' || wfTask_id == '') {
                f_notify(2, 'Error', errMsg_default);    
                return false;
            } 
            mqk_otable = otable;
            mqk_load_type = load_type;
            $('.mqk_hide_view, .mqk_show_view, #mqk_alert_box, .mqk_div_verify, #mqk_div_datePoolStart').hide();
            $('.mqk_show_view').show();
            var task_info = f_get_general_info('vw_task_info', {wfTask_id:wfTask_id}, 'mqk');    
            var is_end = (task_info.wfFlow_id == '5') ? 'N' : '';
            var arr_steps = f_get_general_info_multiple('wf_task_type', {wfFlow_id:task_info.wfFlow_id, wfTaskType_isEnd:is_end});
            var previous_task = f_get_general_info_multiple('wf_task', {wfTrans_id:task_info.wfTrans_id, wfTask_partition:'2'}, '', '', 'wfTask_id DESC');
            var wfTaskType_turn = task_info.wfTaskType_turn != '0' ? task_info.wfTaskType_turn : f_get_value_from_table('wf_task_type', 'wfTaskType_id', previous_task[0].wfTaskType_id, 'wfTaskType_turn');
            f_steps (arr_steps, wfTaskType_turn, 'mqk_steps');     
            var qa_detail = f_get_general_info('vw_qa_details', {qa_id:qa_id}, 'mqk');
            $('#lmqk_qa_type_title').html(qa_detail.qa_type_desc);
            $('[name="mqk_snote_qa_message"]').summernote('code', qa_detail.qa_message);
            data_mqk_raLow = f_get_general_info_multiple('t_qa_ra', {qa_id:qa_id, qaRa_loadType:'2'});
            f_dataTable_draw(mqk_otable_raLow, data_mqk_raLow, 'datatable_mqk_raLow', 6);
            data_mqk_raNormal = f_get_general_info_multiple('t_qa_ra', {qa_id:qa_id, qaRa_loadType:'1'});
            f_dataTable_draw(mqk_otable_raNormal, data_mqk_raNormal, 'datatable_mqk_raNormal', 6);
            data_mqk_raHigh = f_get_general_info_multiple('t_qa_ra', {qa_id:qa_id, qaRa_loadType:'3'});
            f_dataTable_draw(mqk_otable_raHigh, data_mqk_raHigh, 'datatable_mqk_raHigh', 6);
            data_mqk_ftest = f_get_general_info_multiple('t_qa_ftest', {qa_id:qa_id});
            f_dataTable_draw(mqk_otable_ftest, data_mqk_ftest, 'datatable_mqk_ftest', 7);
            data_mqk_supportDoc = f_get_general_info_multiple('dt_qa_document', {qa_id:qa_id}, '', '', 'qa_id');
            f_dataTable_draw(mqk_otable_supportDoc, data_mqk_supportDoc, 'datatable_mqk_supportDoc', 4);
            $('#form_mqk_form_2').find('input').prop('disabled',true);
            $('.mqk_hide_view').hide();
            if (task_info.wfFlow_id == '5')
                $('#mqk_div_datePoolStart').show();
            if (mqk_load_type == 2) {
                if (mqk_otable == 'ipm') {
                    if (previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {                    
                        $('#mqk_alert_box').show();
                        $('#mqk_alert_message').html(previous_task[0].wfTask_remark);
                        var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                        $('#mqk_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                    }
                    $('.mqk_show_view').hide();
                    $('.mqk_hide_view').show();
                    $('#mqk_snote_qa_message').summernote('enable');
                    $('#form_mqk_form, #form_mqk_form_2, #form_mqk_doc').find('input, textarea, select').prop('disabled',false);
                } else if (mqk_otable == 'itp') {
                    $("input[name='mqk_result'][value=" + task_info.wfTask_statusSave + "]").prop('checked', true);
                    if (task_info.wfTask_remark != null && task_info.wfTask_remark != '<p><br></p>')
                        $('[name="mqk_snote_wfTask_verify"]').summernote('code', task_info.wfTask_remark);
                    else
                        $('[name="mqk_snote_wfTask_verify"]').summernote('code', '');
                    $('#form_mqk_verify').bootstrapValidator('resetField', 'mqk_snote_wfTask_verify');
                    $('.mqk_div_verify, #mqk_btn_save, #mqk_btn_submit').show();
                } else if (mqk_otable == 'iqa') {
                    if (previous_task != '' && previous_task[0].wfTask_remark != null && previous_task[0].wfTask_remark != '<p><br></p>') {                    
                        $('#mqk_alert_box').show();
                        $('#mqk_alert_message').html(previous_task[0].wfTask_remark);
                        var profile = f_get_general_info('profile', {user_id:previous_task[0].wfTask_claimedBy, profile_status:'1'}); 
                        $('#mqk_alert_date').html('from '+profile.profile_name+'</br>'+dateString2Date(previous_task[0].wfTask_timeSubmitted).toLocaleString());
                    }
                    $('.mqk_show_view').hide();
                    $('.mqk_hide_view').show();
                    $('#mqk_snote_qa_message').summernote('enable');
                    $('#form_mqk_form, #form_mqk_form_2, #form_mqk_doc').find('input, textarea, select').prop('disabled',false);
                } else {
                    f_notify(2, 'Error', errMsg_default);    
                    return false;
                }
            } 
            $('.mqk_disabled').prop('disabled',true);
            $('#mqk_wfTask_id').val(wfTask_id); 
            $('#mqk_qa_id').val(qa_id); 
            $('#modal_pems_rata').modal('show');
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show');
    }
    
</script>