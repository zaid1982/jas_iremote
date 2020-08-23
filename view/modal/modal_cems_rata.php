<!-- Modal -->
<div class="modal fade" id="modal_cems_rata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-file-text-o'></i>&nbsp; Service Report (<span
                            id="lmqj_qa_type_title"></span>)</h4>
            </div>
            <div class="modal-body modal-fixHeight">
                <div class="alert alert-block alert-warning" id="mqj_alert_box">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Message</h4>
                    <div class="pull-right text-italic text-align-right" id="mqj_alert_date"></div>
                    <p id="mqj_alert_message"></p>
                </div>
                <div class="row padding-15">
                    <div class="process">
                        <div class="process-row nav nav-tabs" id="mqj_steps"></div>
                    </div>
                </div>
                <h6>Information</h6>
                <div class="well">
                    <form class="form-horizontal">
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Application No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqj_wfTrans_regNo"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>QA Type</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqj_qa_type_desc"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Industrial Name</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqj_wfGroup_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Stack ID</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqj_indAll_stackNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Consultant</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqj_consultant_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Current Status</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqj_qa_status_desc"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- DOCS UPLOAD/DOWNLOAD -->
                <h6>Test Information</h6>
                <div class="well well-light">
                    <form class="form-horizontal" id="form_mqj_form">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Planned Test Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqj_qa_dateExpected" id="mqj_qa_dateExpected"
                                           class="form-control mqj_disabled">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"><font color="red">*</font> Actual Test Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqj_qa_dateActual" id="mqj_qa_dateActual"
                                           class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                       <!-- <div class="form-group" id="mqj_div_datePoolStart">
                            <label class="col-md-2 control-label"><font color="red">*</font> Pooling Start Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqj_indAll_datePoolStart" id="mqj_indAll_datePoolStart"
                                           class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-md-2 control-label">Additional Message</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="mqj_snote_qa_message" id="mqj_snote_qa_message"
                                          rows="6"></textarea>
                                <input type="hidden" name="mqj_qa_message" id="mqj_qa_message"/>
                            </div>
                        </div>
                    </form>
                </div>
                <h6>Test Result Attachment</h6>
                <form class="form-horizontal" id="form_mqj_attach" method="post" enctype="multipart/form-data">
                    <div class="well margin-bottom-15 padding-bottom-0 mqj_attach_form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label text-left text-italic padding-left-15">* Notes: Please attached all available result test based on the attachment type for gas, total PM and opacity.</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Test Result Attachment Type</label>
                                    <div class="col-md-9 selectContainer">
                                        <select class="form-control" name="mqj_document_type" id="mqj_document_type"></select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group margin-bottom-5">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Attachment File (PDF)</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="mqj_file_document_title" name="mqj_file_document_title" placeholder="Attachment Title">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">&nbsp;</label>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" id="mqj_file_attachment" name="mqj_file_attachment" style="width: 100%">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-labeled btn-primary pull-right" id="mqj_btn_add_attachment">
                                            <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered margin-bottom-15" id="datatable_mqj_attach">
                                <thead>
                                <tr>
                                    <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>
                                    <th class="text-center bg-color-teal txt-color-white" width="40%" data-hide="phone">Type</th>
                                    <th class="text-center bg-color-teal txt-color-white" width="20%" data-hide="phone">Document Title</th>
                                    <th class="text-center bg-color-teal txt-color-white" data-class="expand">File Name</th>
                                    <th class="text-center bg-color-teal txt-color-white" width="52px" style="min-width: 52px">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <!--    <form class="form-horizontal" id="form_mqj_doc" method="post" enctype="multipart/form-data">
                       <div class="form-group mqj_hide_view">
                           <label class="col-md-2 control-label"> Attachment</label>
                           <div class="col-md-6">
                               <input type="text" class="form-control" name="mqj_supDoc_name" id="mqj_supDoc_name"/>
                           </div>
                           <div class="col-md-4">
                               <div class="input-group">
                                   <input type="file" class="form-control" id="mqj_supDoc_file" name="mqj_supDoc_file" style="width: 100%">
                                   <span class="input-group-btn">
                                       <button class="btn btn-info" type="button" id="mqj_btn_add_supDoc"><i class="fa fa-upload"></i></button>
                                   </span>
                               </div>
                           </div>
                       </div>
                       <div class="form-group">
                           <label class="col-md-2 control-label"> <span class="mqj_show_view">Attachment</span></label>
                           <div class="col-md-10">
                               <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mqj_supportDoc">
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
                   </form> -->
                <form class="form-horizontal" id="form_mqj_base">
                    <input type="hidden" name="funct" id="mqj_funct" value="save_qa"/>
                    <input type="hidden" name="mqj_indAll_id" id="mqj_indAll_id"/>
                    <input type="hidden" name="mqj_qa_id" id="mqj_qa_id"/>
                    <input type="hidden" name="mqj_qa_type" id="mqj_qa_type"/>
                    <input type="hidden" name="mqj_wfTask_id" id="mqj_wfTask_id"/>
                    <input type="hidden" name="mqj_wfTaskType_id" id="mqj_wfTaskType_id"/>
                    <input type="hidden" name="mqj_wfGroup_id" id="mqj_wfGroup_id"/>
                    <input type="hidden" name="mqj_wfTask_status" id="mqj_wfTask_status"/>
                    <input type="hidden" name="mqj_wfTask_refName" id="mqj_wfTask_refName"/>
                    <input type="hidden" name="mqj_wfTask_refValue" id="mqj_wfTask_refValue"/>
                </form>

            <h6 class="mqj_div_hardCopy">Hard Copy Submission</h6>
            <div class="well well-light mqj_div_hardCopy">
                <form class="form-horizontal" id="form_mqj_hardCopy">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Hard Copy Received</label>
                        <div class="col-md-9">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox" name="mqj_qa_hardCopy" value="1">
                                <span>Yes</span>
                            </label>
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox" name="mqj_qa_hardCopy" value="2">
                                <span>No</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group padding-top-5">
                        <label class="col-md-3 control-label">Received By</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" name="mqj_qa_hardCopy_receiver" id="mqj_qa_hardCopy_receiver" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Message/Feedback</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="mqj_snote_hardCopy_remark" id="mqj_snote_hardCopy_remark" rows="6"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <h6 class="mqj_div_verify">Verification</h6>
            <div class="well well-light mqj_div_verify">
                <form class="form-horizontal" id="form_mqj_verify">
                    <div class="form-group">
                        <label class="col-md-3 control-label"><font color="red">*</font> Verification Result</label>
                        <div class="col-md-9">
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox" name="mqj_result" value="17">
                                <span>Verify</span>
                            </label>
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox" name="mqj_result" value="12">
                                <span>Return for Incompleteness</span>
                            </label>
                            <label class="radio radio-inline">
                                <input type="radio" class="radiobox" name="mqj_result" value="46">
                                <span>Reject and Return to Redo Test</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label"><font color="red">*</font> Message/Feedback</label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="mqj_snote_wfTask_verify" id="mqj_snote_wfTask_verify"
                                      rows="6"></textarea>
                            <input type="hidden" name="mqj_wfTask_verify" id="mqj_wfTask_verify"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-labeled btn-danger pull-left" id="mqj_btn_cancel"
                            data-dismiss="modal">
                        <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                    </button>
                    <button type="button" class="btn btn-labeled btn-success mqj_hide_view" id="mqj_btn_save">
                        <span class="btn-label"><i class="fa fa-save"></i></span>Save
                    </button>
                    <button type="button" class="btn btn-labeled btn-warning mqj_hide_view" id="mqj_btn_submit">
                        <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>    