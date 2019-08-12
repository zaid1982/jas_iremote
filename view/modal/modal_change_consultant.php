<!-- Modal -->
<div class="modal fade" id="modal_change_consultant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-user-secret'></i>&nbsp; Change Maintenance Consultant</h4>
            </div>
            <div class="modal-body">   
                <form class="form-horizontal" id="form_mch">
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="well">
                                <div class="form-group no-margin">
                                    <label class="col-md-4 control-label"><strong>Current Consultant</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        Rania Resources Sdn Bhd
                                    </div>
                                </div> 
                                <div class="form-group no-margin">
                                    <label class="col-md-4 control-label"><strong>Analyzer Model</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        DE102001
                                    </div>
                                </div> 
                                <div class="form-group no-margin margin-bottom-5">
                                    <label class="col-md-4 control-label"><strong>Certificate Needed</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        TUV
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="form-group">
                                <label class="col-md-3 control-label">New Consultant</label>
                                <div class="col-md-9 selectContainer">   
                                    <select class="form-control" name="" id="">
                                        <option value="">Rania Resources Sdn Bhd</option>
                                        <option value="">ATT Sdn Bhd</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Changes Date</label>
                                <div class="col-md-4">   
                                    <div class="input-group col-md-12">
                                        <input type="text" id="" class="form-control" readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Changes Reason</label>
                                <div class="col-md-9">   
                                    <textarea class="form-control" name="" id="" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mch_btn_modal_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success" id="mch_btn_modal_post">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>