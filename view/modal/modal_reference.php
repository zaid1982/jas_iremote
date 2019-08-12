<!-- Modal -->
<div class="modal fade" id="modal_reference" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <form class="form-horizontal" id="form_mrf">
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title"><i class='fa fa-tags'></i>&nbsp; Reference Data - <span id='mrf_title'></span></h4>
                </div>
                <div class="modal-body padding-gutter modal-fixHeight">                
                    <fieldset>  
                        <div class="well mrf_info">
                            <div class="form-group no-margin mrf_info_1">
                                <label class="col-md-4 control-label"><strong><span id='mrf_infoTitle_1'></span></strong></label>
                                <div class="col-md-8 control-label text-align-left">
                                    <span id='mrf_infoValue_1'></span>
                                </div>
                            </div>
                            <div class="form-group no-margin mrf_info_2">
                                <label class="col-md-4 control-label"><strong><span id='mrf_infoTitle_2'></span></strong></label>
                                <div class="col-md-8 control-label text-align-left">
                                    <span id='mrf_infoValue_2'></span>
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label class="col-md-4 control-label"><strong>Created Time</strong></label>
                                <div class="col-md-8 control-label text-align-left">
                                    <span id='mrf_infoValue_3'></span>
                                </div>
                            </div>
                            <div class="form-group no-margin margin-bottom-5">
                                <label class="col-md-4 control-label"><strong>Status</strong></label>
                                <div class="col-md-8 control-label text-align-left">
                                    <span id='mrf_infoValue_4'></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">      
                            <label class="col-md-4 control-label"><font color="red">*</font> <span id='mrf_formTitle_1'></span></label>
                            <div class="col-md-7">
                                <input type="text" name="mrf_ref_desc" id="mrf_ref_desc" class="form-control">
                            </div>   
                        </div>
                        <div class="form-group mrf_column">      
                            <label class="col-md-4 control-label"><font color="red">*</font> <span id='mrf_formTitle_2'></span></label>
                            <div class="col-md-7 selectContainer">
                                <select name="mrf_opt_parent" id="mrf_opt_parent" class="form-control" ><option></option></select>
                            </div>   
                        </div>
                    </fieldset>        
                </div>           
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-labeled btn-danger pull-left" id="mrf_btn_cancel" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </button>
                            <button type="button" class="btn btn-labeled btn-success" id="mrf_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="mrf_ref_id" id="mrf_ref_id" />
                <input type="hidden" name="funct" id="funct" value="" />
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
