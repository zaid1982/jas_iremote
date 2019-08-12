<!-- Modal -->
<div class="modal fade" id="modal_qnf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">              
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-comments-o'></i>&nbsp; Query and Feedback</h4>
            </div>
            <div class="modal-body modal-fixHeight">  
                <div class="alert alert-block alert-warning" id="mqf_alert_box">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Message</h4>
                    <div class="pull-right text-italic text-align-right" id="mqf_alert_date"></div>
                    <p id="mqf_alert_message"></p>
                </div>
                <div class="row padding-15">
                    <div class="process">
                        <div class="process-row2 nav nav-tabs" id="mqf_steps"></div>
                    </div>
                </div>  
                <h6>Information</h6>
                <div class="well">
                    <form class="form-horizontal">
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Case No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqf_wfTrans_regNo"></span> 
                            </div>
                            <label class="col-md-2 control-label"><strong>Inquiry Time</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqf_qnf_timeSubmitted"></span> 
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Inquiry From</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqf_profile_name"></span> 
                            </div>
                            <label class="col-md-2 control-label"><strong>Department</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqf_wfGroup_name"></span> 
                            </div>
                        </div>
                        <div class="form-group no-margin margin-bottom-5">
                            <label class="col-md-2 control-label"><strong>Inquiry Type</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqf_qnf_type"></span> 
                            </div>
                            <label class="col-md-2 control-label"><strong>Current Status</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqf_status_desc"></span> 
                            </div>
                        </div>
                    </form>
                </div>                
                <h6>Inquiry</h6>
                <div class="well well-light">
                    <form class="form-horizontal" id="form_mqf_form">                        
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Title</label>
                            <div class="col-md-9 selectContainer">
                                <input type="text" class="form-control" name="mqf_qnf_title" id="mqf_qnf_title" />
                            </div>   
                        </div>
                        <div class="form-group mqf_show_qfe">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Category</label>
                            <div class="col-md-9 selectContainer">
                                <select class="form-control" name="mqf_qnfCate_id" id="mqf_qnfCate_id"  disabled="disabled"></select>
                            </div>   
                        </div>
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Name</label>
                            <div class="col-md-9 selectContainer">
                                <input type="text" class="form-control" name="mqf_qnf_name" id="mqf_qnf_name" />
                            </div>   
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">      
                                    <label class="col-md-6 control-label"><font color="red">*</font> Contact No.</label>
                                    <div class="col-md-6 selectContainer">
                                        <input type="text" class="form-control" name="mqf_qnf_contactNo" id="mqf_qnf_contactNo" />
                                    </div>   
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">      
                                    <label class="col-md-4 control-label"><font color="red">*</font> Email</label>
                                    <div class="col-md-8 selectContainer">
                                        <input type="text" class="form-control" name="mqf_qnf_email" id="mqf_qnf_email" />
                                    </div>   
                                </div>
                            </div>
                        </div>
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Inquiry Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mqf_snote_qnf_message" id="mqf_snote_qnf_message" rows="6"></textarea>
                                <input type="hidden" name="mqf_qnf_message" id="mqf_qnf_message" />
                            </div>   
                        </div>
                    </form>
                    <form class="form-horizontal" id="form_mqf_form_2" method="post" enctype="multipart/form-data">
                        <div class="form-group margin-bottom-10" id="mqf_div_attach">      
                            <label class="col-md-3 control-label"> Supporting Attachment</label>
                            <div class="col-md-5">          
                                <input type="text" class="form-control" name="mqf_supDoc_name" id="mqf_supDoc_name"/>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="mqf_supDoc_file" name="mqf_supDoc_file" style="width: 100%">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="mqf_btn_add_supDoc"><i class="fa fa-upload"></i></button>
                                    </span>
                                </div>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span id="mqf_lbl_attach">Supporting Attachment</span></label>
                            <div class="col-md-9">
                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mqf_qnfDoc"> 
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
                <h6 class="mqf_div_action"><span id="mqf_lbl_action"></span></h6>
                <div class="well well-light mqf_div_action">
                    <form class="form-horizontal" id="form_mqf_action">
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Action</label>
                            <div class="col-md-9">
                                <label class="radio radio-inline mqf_show_delegate">
                                    <input type="radio" class="radiobox" name="mqf_result" value="38">
                                    <span>Delegate</span>
                                </label>
                                <label class="radio radio-inline mqf_show_delegate mqf_show_feedback">
                                    <input type="radio" class="radiobox" name="mqf_result" value="40">
                                    <span>Resolve and Close</span>
                                </label>
                                <label class="radio radio-inline mqf_show_delegate mqf_show_feedback">
                                    <input type="radio" class="radiobox" name="mqf_result" value="12">
                                    <span>Request explanation from complainer</span>
                                </label>
                                <label class="radio radio-inline mqf_show_feedback">
                                    <input type="radio" class="radiobox" name="mqf_result" value="45">
                                    <span>Return task to Helpdesk Admin</span>
                                </label>
                            </div>   
                        </div>
                        <div class="form-group mqf_div_delegate_to">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Delegate To</label>
                            <div class="col-md-9 selectContainer">
                                <select class="form-control" name="mqf_wfTrans_processOfficer" id="mqf_wfTrans_processOfficer"><option></option></select>
                            </div>   
                        </div>
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mqf_snote_wfTask_remark" id="mqf_snote_wfTask_remark" rows="6"></textarea>
                                <input type="hidden" name="mqf_wfTask_remark" id="mqf_wfTask_remark" />
                            </div>   
                        </div>
                    </form>    
                </div>   
                <h6 class="mqf_div_respond">Respond</h6>
                <div class="well well-light mqf_div_respond">
                    <form class="form-horizontal" id="form_mqf_respond">
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Reply Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mqf_snote_wfTask_respond" id="mqf_snote_wfTask_respond" rows="6"></textarea>
                                <input type="hidden" name="mqf_wfTask_respond" id="mqf_wfTask_respond" />
                            </div>   
                        </div>
                    </form>    
                </div>   
                <h6>Conversation History</h6>
                <div class="row">
                    <article class="col-md-12">
                        <table id="datatable_mqf_history" class="table table-bordered table-hover" width="100%">
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
                    </article>
                </div>
            </div>           
            <div class="modal-footer">   
                <form class="form-horizontal" id="form_mqf">
                    <input type="hidden" name="funct" id="mqf_funct" value="submit_mqf" /> 
                    <input type="hidden" name="mqf_wfTask_id" id="mqf_wfTask_id" />
                    <input type="hidden" name="mqf_wfTrans_id" id="mqf_wfTrans_id" />
                    <input type="hidden" name="mqf_wfTaskType_id" id="mqf_wfTaskType_id" />
                    <input type="hidden" name="mqf_wfGroup_id" id="mqf_wfGroup_id" />
                    <input type="hidden" name="mqf_wfTask_refName" id="mqf_wfTask_refName" />
                    <input type="hidden" name="mqf_wfTask_refValue" id="mqf_wfTask_refValue" />
                    <input type="hidden" name="mqf_wfTask_status" id="mqf_wfTask_status" />
                    <input type="hidden" name="mqf_qnf_id" id="mqf_qnf_id" /> 
                    <input type="hidden" name="mqf_qnf_postType" id="mqf_qnf_postType" /> 
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mpe_btn_modal_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success mqf_hide_view" id="mqf_btn_save">
                            <span class="btn-label"><i class="fa fa-save"></i></span>Save
                        </button>
                        <button type="button" class="btn btn-labeled btn-warning mqf_hide_view" id="mqf_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
