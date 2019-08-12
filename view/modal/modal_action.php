<!-- Modal -->
<div class="modal fade" id="modal_maw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">  
            <form class="form-horizontal" id="form_maw">
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title"><i class="fa fa-check-square-o maw_titleIcon"></i>&nbsp; <span id="maw_title"></span></h4>
                </div>
                <div class="modal-body modal-fixHeight">  
                    <div class="alert alert-block alert-warning" id="maw_alert_box">
                        <a class="close" data-dismiss="alert" href="#">×</a>
                        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> <span id="lmaw_status_desc"></span> Message</h4>
                        <div class="pull-right text-italic text-align-right" id="maw_alert_date"></div>
                        <p id="maw_alert_message"></p>
                    </div>
                    <div class="row padding-15">
                        <div class="process">
                            <div class="process-row nav nav-tabs" id="maw_steps">
                                <div class="process-step">
                                    <button type="button" class="btn btn-info btn-circle" data-toggle="tab"><i class="fa fa-edit fa-2x"></i></button>
                                    <p><small>Fill<br/>form</small></p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-info btn-circle" data-toggle="tab"><i class="fa fa-group fa-2x"></i></button>
                                    <p><small>Assign<br/>application</small></p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-info btn-circle" data-toggle="tab"><i class="fa fa-check-square-o fa-2x"></i></button>
                                    <p><small>Process<br/>application</small></p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" data-toggle="tab"><i class="fa fa-thumbs-o-up fa-2x"></i></button>
                                    <p><small>Verify<br/>application</small></p>
                                </div>
                                <div class="process-step">
                                    <button type="button" class="btn btn-default btn-circle" data-toggle="tab"><i class="fa fa-check fa-2x"></i></button>
                                    <p><small>Approve<br/>application</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h6>Information</h6>
                    <div class="well">
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Application No.</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_wfTrans_no"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Company Name</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_wfGroup_name"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Registration No.</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_wfGroup_regNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Application Type</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_wfFlow_desc"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Current Status</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_current_status"></span>  
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Application Due Date</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_wfTrans_dateDue"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-3 control-label"><strong>Task Due Date</strong></label>
                            <div class="col-md-9 control-label text-align-left">
                                <span id="lmaw_wfTask_dateExpired"></span>
                            </div>
                        </div>
                    </div>
                    <h6 class="maw_show_checklist">Process Application Checklist</h6>
                    <div class="row maw_show_checklist">
                        <div class="col-md-12">          
                            <table id="datatable_maw_checking_view" class="table table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th width="50px" class="text-center bg-color-teal txt-color-white">Section</th>
                                        <th width="35%" class="text-center bg-color-teal txt-color-white">Description</th>
                                        <th width="70px" class="text-center bg-color-teal txt-color-white">Result</th>
                                        <th class="text-center bg-color-teal txt-color-white">Remark</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>									
                            </table> 
                        </div>
                    </div>
                    <h6 class="maw_hide_action">Action</h6>
                    <div class="well well-light maw_hide_action">
<!--                        <div class="form-group maw_show_action_chk">      
                            <label class="col-md-2 control-label"><font color="red">*</font> Checklist</label>
                            <div class="col-md-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Jenis industry adalah tertakluk dengan keperluan pemasangan CEMS</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Butiran mengenai cerobong yang terlibat dengan pemasangan CEMS</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Deskripsi mengenai proses industri yang bersambung dengan cerobong</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Parameter bahan pencemar dan nilai kepekatan</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Butiran mengenai punca pelepasan bahan pencemar udara</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Lokasi pemasangan alat CEMS (5D 2Datau 8D 2D)</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Kesesuaian teknik persampelan alat CEMS</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Kesesuaian range alat CEMS yang dipasang dengan nilai kepekatan bahan pencemar</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Normalization. Sekiranya alat tidak mempunyai pakej analyzer oksigen, perlu dinyatakan kaedah bagaimana memastikan aktiviti normalizataion dilaksanakan; dan diagram yang menunjukkan lokasi analyzer oksigen di plant</span>
                                    </label>
                                </div> 
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="checkbox" name="" >
                                        <span>Diagram pemasangan CEMS yang lengkap dari cerobong ke DAS</span>
                                    </label>
                                </div> 
                            </div>
                        </div>-->
                        <div class="form-group maw_show_action_chk">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Process Checklist</label>
                            <div class="col-md-9">  
                                <table id="datatable_maw_checking" class="table table-bordered table-hover table-striped margin-bottom-0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="50px" class="text-center bg-color-teal txt-color-white">Section</th>
                                            <th width="35%" class="text-center bg-color-teal txt-color-white">Description</th>
                                            <th width="70px" class="text-center bg-color-teal txt-color-white">Result</th>
                                            <th class="text-center bg-color-teal txt-color-white">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>									
                                </table> 
                                <small class="txt-color-red"><i>Please go through "icon image" and update verification result</i></small>
                            </div>   
                        </div>
                        <div class="form-group maw_hide_assign">      
                            <label class="col-md-3 control-label"><font color="red">*</font> <span id="maw_lbl_action">Application Action</span></label>
                            <div class="col-md-9">
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="maw_result" value="10">
                                    <span id="maw_result">Complete</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="maw_result" value="11">
                                    <span id="maw_reject">Reject</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="maw_result" value="12">
                                    <span id="maw_return">Return to Previous Officer</span>
                                </label>
                            </div>   
                        </div>
                        <div class="form-group maw_show_assign">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Assign To</label>
                            <div class="col-md-9 selectContainer">
                                <select class="form-control" name="maw_assign_to" id="maw_assign_to"></select>
                            </div>   
                        </div>
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label">Additional Remark / Message</label>
                            <div class="col-md-9 margin-top-10">
                                <textarea class="form-control" name="maw_snote_wfTask_remark" id="maw_snote_wfTask_remark" rows="6"></textarea>
                                <input type="hidden" name="maw_wfTask_remark" id="maw_wfTask_remark" />
                            </div>   
                        </div>
                    </div>
                    <h6 class="maw_hide_return">Task History</h6>
                    <div class="row maw_hide_return">
                        <div class="col-md-12">           
                            <table id="datatable_maw_history" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th data-hide="phone" class="text-center bg-color-teal txt-color-white">No</th>
                                        <th data-class="expand" class="text-center bg-color-teal txt-color-white">Task Name</th>
                                        <th data-hide="phone" class="text-center bg-color-teal txt-color-white">Task Status</th>
                                        <th data-hide="phone,tablet" class="text-center bg-color-teal txt-color-white">Company</th>
                                        <th class="text-center bg-color-teal txt-color-white">Action By</th>
                                        <th style="min-width: 70px" class="text-center bg-color-teal txt-color-white">Received Date</th>
                                        <th style="min-width: 70px" class="text-center bg-color-teal txt-color-white">Submitted Date</th>
                                        <th data-hide="phone,tablet" style="min-width: 70px" class="text-center bg-color-teal txt-color-white">Due Date</th>
                                        <th data-hide="phone,tablet" width="20%" class="text-center bg-color-teal txt-color-white">Message</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>									
                            </table> 
                        </div>
                    </div>       
                    <input type="hidden" name="funct" id="maw_funct" value="submit_task_action" /> 
                    <input type="hidden" name="maw_wfTask_id" id="maw_wfTask_id" />
                    <input type="hidden" name="maw_wfTrans_id" id="maw_wfTrans_id" />
                    <input type="hidden" name="maw_wfTaskType_id" id="maw_wfTaskType_id" />
                    <input type="hidden" name="maw_wfGroup_id" id="maw_wfGroup_id" />
                    <input type="hidden" name="maw_wfTask_refName" id="maw_wfTask_refName" />
                    <input type="hidden" name="maw_wfTask_refValue" id="maw_wfTask_refValue" />
                    <input type="hidden" name="maw_load_type" id="maw_load_type" />
                </div>           
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-labeled btn-danger pull-left hidden-xs" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </button>
                            <button type="button" class="btn btn-labeled btn-success maw_hide_action" id="maw_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                            <button type="button" class="btn btn-labeled btn-warning maw_hide_action" id="maw_btn_submit">
                                <span class="btn-label"><i class="fa fa-sign-in"></i></span>Submit
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
