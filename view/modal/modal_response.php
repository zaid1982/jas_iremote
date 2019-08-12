<!-- Modal -->
<div class="modal fade" id="modal_mre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">              
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-comment'></i>&nbsp; <span id="mre_title"></span></h4>
            </div>
            <div class="modal-body modal-fixHeight">  
                <div class="alert alert-block alert-warning" id="mre_alert_box">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Message</h4>
                    <div class="pull-right text-italic text-align-right" id="mre_alert_date"></div>
                    <p id="mre_alert_message"></p>
                </div>
                <div class="row padding-15">
                    <div class="process">
                        <div class="process-row2 nav nav-tabs" id="mre_steps"></div>
                    </div>
                </div>  
                <h6>Information</h6>
                <div class="well">
                    <form class="form-horizontal">
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Report No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_wfGroup_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Issue</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_response_issue"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Industrial Name</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_ind_regNo"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Stack ID</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_indAll_stackNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Registration No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_wfTrans_regNo"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>JAS File No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_industrial_jasFileNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Date of Issue</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_response_date"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Input Parameter</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_inputParam_desc"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin margin-bottom-5">
                            <label class="col-md-2 control-label"><strong><span id="lmre_label_issue_is"></span></strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_response_dataReceive"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Status</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmre_status_desc"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <h6 class="mre_div_response">Response to Failure</h6>
                <div class="well well-light mre_div_response">
                    <form class="form-horizontal" id="form_mre">
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> <span id="lmre_label_reason"></span></label>
                            <div class="col-md-6 selectContainer">
                                <select class="form-control mre_field_response" name="mre_reasonFail_id" id="mre_reasonFail_id"></select>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> Explanation Message/Feedback</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mre_snote_wfTask_remark" id="mre_snote_wfTask_remark" rows="6"></textarea>
                                <input type="hidden" name="mre_wfTask_remark" id="mre_wfTask_remark" />
                            </div>
                        </div>                     
                        <input type="hidden" name="funct" id="mre_funct" value="save_response" /> 
                        <input type="hidden" name="mre_wfTask_id" id="mre_wfTask_id" />
                        <input type="hidden" name="mre_wfTaskType_id" id="mre_wfTaskType_id" />
                        <input type="hidden" name="mre_wfGroup_id" id="mre_wfGroup_id" />
                        <input type="hidden" name="mre_wfTask_refName" id="mre_wfTask_refName" />
                        <input type="hidden" name="mre_wfTask_refValue" id="mre_wfTask_refValue" />
                        <input type="hidden" name="mre_wfTask_status" id="mre_wfTask_status" />
                        <input type="hidden" name="mre_response_id" id="mre_response_id" />
                        <input type="hidden" name="mre_response_type" id="mre_response_type" />
                        <input type="hidden" name="mre_load_type" id="mre_load_type" />
                    </form>    
                    <form class="form-horizontal" id="form_mre_2" method="post" enctype="multipart/form-data">
                        <div class="form-group margin-bottom-5">      
                            <label class="col-md-3 control-label"> Supporting Attachment</label>
                            <div class="col-md-5">          
                                <input type="text" class="form-control" name="mre_supDoc_name" id="mre_supDoc_name"/>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="mre_supDoc_file" name="mre_supDoc_file" style="width: 100%">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="mre_btn_add_supDoc"><i class="fa fa-upload"></i></button>
                                    </span>
                                </div>
                            </div>   
                        </div>
                        <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mre_supportDoc"> 
                                    <thead>
                                        <tr>
                                            <th width="4%" class="text-center bg-color-teal txt-color-white">No.</th>
                                            <th width="35%" class="text-center bg-color-teal txt-color-white">Title</th>
                                            <th class="text-center bg-color-teal txt-color-white">Filename</th>
                                            <th width="70px" style="min-width: 70px" class="text-center bg-color-teal txt-color-white">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>                    
                    </form>
                </div> 
                <h6 class="mre_div_verify">Verification</h6>
                <div class="well well-light mre_div_verify">
                    <form class="form-horizontal" id="form_mre_verify">
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Verification Result</label>
                            <div class="col-md-9">
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mre_result" value="18">
                                    <span>Approve and Close Case</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mre_result" value="12">
                                    <span>Reject and Return</span>
                                </label>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> Message/Feedback</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mre_snote_wfTask_verify" id="mre_snote_wfTask_verify" rows="6"></textarea>
                                <input type="hidden" name="mre_wfTask_verify" id="mre_wfTask_verify" />
                            </div>
                        </div>    
                    </form>
                </div>
                <h6>Conversation History</h6>
                <div class="row">
                    <div class="col-md-12">             
                        <table id="datatable_mre_history" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="40px" data-hide="phone" class="text-center bg-color-teal txt-color-white">No</th>
                                    <th data-class="expand" class="text-center bg-color-teal txt-color-white">Task Name</th>
                                    <th data-hide="phone" class="text-center bg-color-teal txt-color-white">Task Status</th>
                                    <th data-hide="phone,tablet" class="text-center bg-color-teal txt-color-white">Action By</th>
                                    <th style="min-width: 70px" class="text-center bg-color-teal txt-color-white">Submitted Time</th>
                                    <th data-hide="phone,tablet" width="35%" class="text-center bg-color-teal txt-color-white">Message</th>
                                </tr>
                            </thead>
                            <tbody></tbody>									
                        </table>    
                    </div>
                </div>  
                <h6 class="">Attachment Records</h6>
                <div class="row">
                    <div class="col-md-12">             
                        <table id="datatable_mre_viewDoc" class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr>
                                    <th width="40px" class="text-center bg-color-teal txt-color-white">No</th>
                                    <th width="35%" class="text-center bg-color-teal txt-color-white">Title</th>
                                    <th class="text-center bg-color-teal txt-color-white">Filename</th>
                                    <th class="text-center bg-color-teal txt-color-white" width="50px" style="min-width: 50px">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody></tbody>									
                        </table>   
                    </div>  
                </div>  
            </div>           
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mre_btn_modal_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success mre_hide_view" id="mre_btn_save">
                            <span class="btn-label"><i class="fa fa-save"></i></span>Save
                        </button>
                        <button type="button" class="btn btn-labeled btn-warning mre_hide_view" id="mre_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
