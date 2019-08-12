<!-- Modal -->
<div class="modal fade" id="modal_qa_report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-check-square-o'></i>&nbsp; Service Report for <span id="mqa_label_title"></span></h4>
            </div>
            <div class="modal-body modal-fixHeight">   
                <div class="alert alert-block alert-warning" id="mqa_alert_box">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Message</h4>
                    <div class="pull-right text-italic text-align-right" id="mqa_alert_date"></div>
                    <p id="mqa_alert_message"></p>
                </div>
                <div class="row padding-15">
                    <div class="process">
                        <div class="process-row nav nav-tabs" id="mqa_steps"></div>
                    </div>
                </div>  
                <h6>Information</h6>
                <div class="well">
                    <form class="form-horizontal">
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Application No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqa_wfTrans_regNo"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>QA Type</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqa_qaType_desc"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Industrial Name</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqa_wfGroup_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Stack ID</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqa_indAll_stackNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Consultant</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqa_consultant_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Current Status</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqa_status_desc"></span>
                            </div>
                        </div>
                    </form>
                </div>
                <h6>Test Result</h6>
                <div class="well well-light">
                    <form class="form-horizontal" id="form_mqa">
                        <div class="form-group">      
                            <label class="col-md-3 control-label">Planned Test Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqa_qa_dateExpected" id="mqa_qa_dateExpected" class="form-control mqa_disabled" disabled>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                </div>
                            </div>
                        </div>
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Actual Test Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqa_qa_dateActual" id="mqa_qa_dateActual" class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>          
                                </div>
                            </div>
                        </div>
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Alignment and Cleanliness</label>
                            <div class="col-md-9 control-label text-align-left">
                                Visual check:
                            </div> 
                        </div>        
                        <div class="form-group">      
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9" id="mqa_div_qaCheck_1"></div> 
                        </div>    
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label"></label>
                            <div class="col-md-9 control-label text-align-left">
                                After re-assembly at the measurement location, the following shall be checked:
                            </div> 
                        </div>    
                        <div class="form-group">      
                            <label class="col-md-3 control-label">&nbsp;</label>
                            <div class="col-md-9" id="mqa_div_qaCheck_2"></div> 
                        </div> 
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Documentation and Records</label>
                            <div class="col-md-9" id="mqa_div_qaCheck_3"></div> 
                        </div>    
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Serviceability</label>
                            <div class="col-md-9" id="mqa_div_qaCheck_4"></div>
                        </div>
                        <div class="row padding-top-5">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Zero Check</label>
                            <div class="col-md-9">
                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mqa_calibrate_1" width="100%"> 
                                    <thead>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Gas</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Concentration Reference</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="2">Calibration</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="10%">Result</th>
                                        </tr>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white">Before</th>
                                            <th class="text-center bg-color-teal txt-color-white">After</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row padding-top-15">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Span Check</label>
                            <div class="col-md-9">  
                                <table class="table table-bordered table-hover table-condensed margin-bottom-5" id="datatable_mqa_calibrate_2" width="100%"> 
                                    <thead>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Gas</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Concentration Reference</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="2">Calibration</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="2" >Traceability</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="10%">Result</th>
                                        </tr>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white">Before</th>
                                            <th class="text-center bg-color-teal txt-color-white">After</th>
                                            <th class="text-center bg-color-teal txt-color-white">Reference</th>
                                            <th class="text-center bg-color-teal txt-color-white">Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row padding-top-15">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Zero Drift (Audit)</label>
                            <div class="col-md-9">
                                <table class="table table-bordered table-hover table-condensed margin-bottom-5" id="datatable_mqa_calibrate_3" width="100%"> 
                                    <thead>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Gas</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Concentration Reference</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="2">Calibration</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="10%">Result</th>
                                        </tr>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white">Before</th>
                                            <th class="text-center bg-color-teal txt-color-white">After</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row padding-top-15">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Span Drift (Audit)</label>
                            <div class="col-md-9">
                                <table class="table table-bordered table-hover table-condensed margin-bottom-5" id="datatable_mqa_calibrate_4" width="100%"> 
                                    <thead>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Gas</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="15%">Concentration Reference</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="2">Calibration</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="2" >Traceability</th>
                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="10%">Result</th>
                                        </tr>
                                        <tr>                                                        
                                            <th class="text-center bg-color-teal txt-color-white">Before</th>
                                            <th class="text-center bg-color-teal txt-color-white">After</th>
                                            <th class="text-center bg-color-teal txt-color-white">Reference</th>
                                            <th class="text-center bg-color-teal txt-color-white">Actual</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>                        
                        <div class="row padding-top-15">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Response Time</label>
                            <div class="col-md-5">
                                <table class="table table-bordered margin-bottom-5" id=""> 
                                    <tbody>
                                        <tr>
                                            <td>Less than 200 s</td>
                                            <td class="padding-5">
                                                <div class="form-group margin-bottom-0"><div class="col-md-12">
                                                    <input type="text" class="form-control" name="mqa_qa_responseTime_less200" id="mqa_qa_responseTime_less200"/>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>More than 200 s</td>
                                            <td class="padding-5">
                                                <div class="form-group margin-bottom-0"><div class="col-md-12">
                                                    <input type="text" class="form-control" name="mqa_qa_responseTime_more200" id="mqa_qa_responseTime_more200"/>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group padding-top-15">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Pooling Start Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqa_indAll_datePoolStart" id="mqa_indAll_datePoolStart" class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> Additional Message</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mqa_snote_wfTask_remark" id="mqa_snote_wfTask_remark" rows="6"></textarea>
                                <input type="hidden" name="mqa_wfTask_verify" id="mqa_wfTask_remark" />
                            </div>
                        </div>    
                    </form>
                    <form class="form-horizontal" id="form_mqa_base">
                        <input type="hidden" name="funct" id="mqa_funct" value="save_qa" /> 
                        <input type="hidden" name="mqa_indAll_id" id="mqa_indAll_id" />
                        <input type="hidden" name="mqa_qa_id" id="mqa_qa_id" />
                        <input type="hidden" name="mqa_qa_type" id="mqa_qa_type" />
                        <input type="hidden" name="mqa_wfTask_id" id="mqa_wfTask_id" />
                        <input type="hidden" name="mqa_wfTaskType_id" id="mqa_wfTaskType_id" />
                        <input type="hidden" name="mqa_wfGroup_id" id="mqa_wfGroup_id" />
                        <input type="hidden" name="mqa_wfTask_status" id="mqa_wfTask_status" />
                        <input type="hidden" name="mqa_wfTask_refName" id="mqa_wfTask_refName" />
                        <input type="hidden" name="mqa_wfTask_refValue" id="mqa_wfTask_refValue" />
                    </form>
                    <form class="form-horizontal" id="form_mqa_doc" method="post" enctype="multipart/form-data">
                        <div class="form-group mqa_hide_view">      
                            <label class="col-md-3 control-label"> Attachment</label>
                            <div class="col-md-5">          
                                <input type="text" class="form-control" name="mqa_supDoc_name" id="mqa_supDoc_name"/>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="mqa_supDoc_file" name="mqa_supDoc_file" style="width: 100%">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="mqa_btn_add_supDoc"><i class="fa fa-upload"></i></button>
                                    </span>
                                </div>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"> <span class="mqa_show_view">Attachment</span></label>
                            <div class="col-md-9">
                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mqa_supportDoc"> 
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
                <h6 class="mqa_div_verify">Test Verification</h6>
                <div class="well well-light mqa_div_verify">
                    <form class="form-horizontal" id="form_mqa_verify">
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Verification Result</label>
                            <div class="col-md-9">
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mqa_result" value="18">
                                    <span>Approve</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mqa_result" value="12">
                                    <span>Return</span>
                                </label>
                            </div> 
                        </div>
                        <div class="form-group margin-bottom-0">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Additional Remark / Message</label>
                            <div class="col-md-9 margin-top-10">
                                <textarea class="form-control" name="mqa_snote_wfTask_verify" id="mqa_snote_wfTask_verify" rows="6"></textarea>
                                <input type="hidden" name="mqa_wfTask_verify" id="mqa_wfTask_verify" />
                            </div>   
                        </div>
                    </form>
                </div>
            </div>                
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mqa_btn_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success mqa_hide_view" id="mqa_btn_save">
                            <span class="btn-label"><i class="fa fa-save"></i></span>Save
                        </button>
                        <button type="button" class="btn btn-labeled btn-warning mqa_hide_view" id="mqa_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>