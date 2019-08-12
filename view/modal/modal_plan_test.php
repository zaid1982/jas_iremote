<div class="modal fade" id="modal_plan_test" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <form class="form-horizontal" id="form_mpt">
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title"><i class='fa fa-calendar-plus-o'></i>&nbsp; Set Initial RATA Date</h4>
                </div>
                <div class="modal-body">   
                    <div class="well">
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Application No.</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_wfTrans_regNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Company Name</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_wfGroup_name"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Application Type</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_wfFlow_desc"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Stack ID</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_indAll_stackNo"></span>  
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>JAS File No.</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_industrial_jasFileNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Premise ID</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_industrial_premiseId"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Draft No.</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_wfTrans_no"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-4 control-label"><strong>Current Status</strong></label>
                            <div class="col-md-8 control-label text-align-left">
                                <span id="lmpt_current_status"></span>  
                            </div>
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="form-group">
                                <label class="col-md-4 control-label">Initial RATA Date</label>
                                <div class="col-md-4">   
                                    <div class="input-group">
                                        <input type="text" name="mpt_indAll_dateRataSet" id="mpt_indAll_dateRataSet" class="form-control" readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="funct" id="mpt_funct" value="save_initial_rata_date" /> 
                    <input type="hidden" name="mpt_wfTask_id" id="mpt_wfTask_id" />
                    <input type="hidden" name="mpt_wfTrans_id" id="mpt_wfTrans_id" />
                    <input type="hidden" name="mpt_wfTaskType_id" id="mpt_wfTaskType_id" />
                    <input type="hidden" name="mpt_wfGroup_id" id="mpt_wfGroup_id" />
                    <input type="hidden" name="mpt_wfTask_refName" id="mpt_wfTask_refName" />
                    <input type="hidden" name="mpt_wfTask_refValue" id="mpt_wfTask_refValue" />
                    <input type="hidden" name="mpt_indAll_id" id="mpt_indAll_id" />
                    <input type="hidden" name="mpt_load_type" id="mpt_load_type" />
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </button>
                            <button type="button" class="btn btn-labeled btn-success" id="mpt_btn_submit">
                                <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>