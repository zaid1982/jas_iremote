<!-- Modal -->
<div class="modal fade" id="modal_renew_cert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-certificate'></i>&nbsp; Analyzer Certificate Renewal</h4>
            </div>
            <div class="modal-body modal-fixHeight">         
                <div class="alert alert-block alert-warning" id="mbc_alert_box">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Message</h4>
                    <div class="pull-right text-italic text-align-right" id="mbc_alert_date"></div>
                    <p id="mbc_alert_message"></p>
                </div>
                <div class="row padding-15">
                    <div class="process">
                        <div class="process-row2 nav nav-tabs" id="mbc_steps"></div>
                    </div>
                </div>  
                <h6>Information</h6>
                <div class="well">
                    <form class="form-horizontal">
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Certificate No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_certificate_no"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Application No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_wfTrans_no"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Certificate Issuer</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_certIssuer_desc"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Expiry Date</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_certificate_dateExpired"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Basic of Certification</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_certificate_basic"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Attachment</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_document_uplname_link"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Analyzer Model No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_model_no"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Analyzer Type</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_analyzer_type"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Consultant Name</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_wfGroup_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Registration No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_cons_regNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin margin-bottom-5">
                            <label class="col-md-2 control-label"><strong>Status</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_status_desc"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Submission Time</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmbc_certificate_timeSubmit"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <h6>Certificate Details</h6>
                <div class="well well-light">
                    <form class="form-horizontal" id="form_mbc_form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-6 control-label"><font color="red">*</font> Certificate No.</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="mbc_certificate_no" id="mbc_certificate_no" />
                                    </div>
                                </div>                      
                                <div class="form-group">
                                    <label class="col-md-6 control-label"><font color="red">*</font> Certificate Issuer</label>
                                    <div class="col-md-6 selectContainer">
                                        <select class="form-control" name="mbc_certIssuer_id" id="mbc_certIssuer_id"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-6 control-label"><font color="red">*</font> Expiry Date</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="text" name="mbc_certificate_dateExpired" id="mbc_certificate_dateExpired" class="form-control" readonly>
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>          
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">      
                                <div class="form-group">
                                    <label class="col-md-6 control-label"><font color="red">*</font> Basic of Certification</label>
                                    <div class="col-md-6">
                                        <div class="col-md-9" id="mbc_div_certBasic_id"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="form_mbc_form_2" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">       
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Certificate (PDF)</label>
                                    <div class="col-md-9 control-label text-left" id="mbc_div_certDoc"></div>
                                </div>
                                <div class="form-group" id="mbc_div_certDocField">
                                    <label class="col-md-3 control-label">&nbsp;</label>
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="mbc_file_certificate" name="mbc_file_certificate" style="width: 100%">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="button" id="mbc_btn_add_certificate"><i class="fa fa-upload"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="form_mbc_form_3">
                        <div class="row">
                            <div class="col-md-12">  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Additional Message</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="mbc_snote_wfTask_remark" id="mbc_snote_wfTask_remark" rows="6"></textarea>
                                        <input type="hidden" name="mbc_wfTask_remark" id="mbc_wfTask_remark" />
                                    </div>
                                </div>  
                            </div>
                        </div>     
                    </form>
                </div>
                <h6 class="mbc_div_verify">Verification</h6>
                <div class="well well-light mbc_div_verify">
                    <form class="form-horizontal" id="form_mbc_verify">
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Verification Result</label>
                            <div class="col-md-9">
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mbc_result" value="18">
                                    <span>Approve</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mbc_result" value="12">
                                    <span>Reject and Return</span>
                                </label>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> Message/Feedback</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mbc_snote_wfTask_verify" id="mbc_snote_wfTask_verify" rows="6"></textarea>
                                <input type="hidden" name="mbc_wfTask_verify" id="mbc_wfTask_verify" />
                            </div>
                        </div>    
                    </form>
                </div>
                <h6>Transaction History</h6>
                <div class="row">
                    <div class="col-md-12">             
                        <table id="datatable_mbc_history" class="table table-bordered table-hover" width="100%">
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
            </div>           
            <div class="modal-footer">
                <form class="form-horizontal" id="form_mbc">
                    <input type="hidden" name="funct" id="mbc_funct" value="save_certificate_renewal" /> 
                    <input type="hidden" name="mbc_wfTask_id" id="mbc_wfTask_id" />
                    <input type="hidden" name="mbc_wfTaskType_id" id="mbc_wfTaskType_id" />
                    <input type="hidden" name="mbc_wfGroup_id" id="mbc_wfGroup_id" />
                    <input type="hidden" name="mbc_wfTask_refName" id="mbc_wfTask_refName" />
                    <input type="hidden" name="mbc_wfTask_refValue" id="mbc_wfTask_refValue" />
                    <input type="hidden" name="mbc_wfTask_status" id="mbc_wfTask_status" />
                    <input type="hidden" name="mbc_certificate_id" id="mbc_certificate_id" />
                    <input type="hidden" name="mbc_load_type" id="mbc_load_type" />
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mbc_btn_modal_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success mbc_hide_view" id="mbc_btn_save">
                            <span class="btn-label"><i class="fa fa-save"></i></span>Save
                        </button>
                        <button type="button" class="btn btn-labeled btn-warning mbc_hide_view" id="mbc_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
