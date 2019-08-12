<!-- Modal -->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">            
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-upload'></i>&nbsp; Attach File</h4>
            </div>
            <div class="modal-body padding-gutter">
                <form class="form-horizontal" id="form_upl" enctype="multipart/form-data">
                    <fieldset>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> Document Title</label>
                            <div class="col-md-9">
                                <select class="form-control" name="upl_documentName_id" id="upl_documentName_id"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Please Specify</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="upl_document_name" id="upl_document_name" disabled="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Description</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="upl_document_remarks" id="upl_document_remarks" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">File</label>
                            <div class="col-md-9">
                                <input type="file" class="form-control btn btn-default" name="file_upload" id="file_upload">
                            </div>
                        </div>
                        <div class="form-group padding-top-0 margin-top-0">
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9">
                                <p class="help-block padding-top-0 margin-top-0">
                                    <i>.pdf file format only</br>
                                    Maximum file size is 5MB</i>
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    <input type="hidden" name="funct" id="upl_funct" value="upload_file" />
                    <input type="hidden" name="upl_load_type" id="upl_load_type" />                    
                    <input type="hidden" name="upl_id" id="upl_id" />
                    <div class="form-actions margin-top-0">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" id="upl_btn_close" data-dismiss="modal">
                                    <i class="fa fa-ban"></i><span class="hidden-mobile">&nbsp;Close</span>
                                </button>
                                <button type="submit" class="btn btn-success" id="upl_btn_upload">
                                    <i class="fa fa-upload"></i><span class="hidden-mobile">&nbsp;Upload</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
            