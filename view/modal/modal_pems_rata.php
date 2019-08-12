<!-- Modal -->
<div class="modal fade" id="modal_pems_rata" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-file-text-o'></i>&nbsp; Service Report (<span id="lmqk_qa_type_title"></span>)</h4>
            </div>
            <div class="modal-body modal-fixHeight">   
                <div class="alert alert-block alert-warning" id="mqk_alert_box">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Message</h4>
                    <div class="pull-right text-italic text-align-right" id="mqk_alert_date"></div>
                    <p id="mqk_alert_message"></p>
                </div>
                <div class="row padding-15">
                    <div class="process">
                        <div class="process-row nav nav-tabs" id="mqk_steps"></div>
                    </div>
                </div>  
                <h6>Information</h6>
                <div class="well">
                    <form class="form-horizontal">
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Application No.</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqk_wfTrans_regNo"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>QA Type</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqk_qa_type_desc"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Industrial Name</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqk_wfGroup_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Stack ID</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqk_indAll_stackNo"></span>
                            </div>
                        </div>
                        <div class="form-group no-margin">
                            <label class="col-md-2 control-label"><strong>Consultant</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqk_consultant_name"></span>
                            </div>
                            <label class="col-md-2 control-label"><strong>Current Status</strong></label>
                            <div class="col-md-4 control-label text-align-left">
                                <span id="lmqk_qa_status_desc"></span>
                            </div>
                        </div>
                    </form>
                </div>       
                <h6>Test Result</h6>
                <div class="well well-light">
                    <form class="form-horizontal" id="form_mqk_form_2">
                        <div class="row">      
                            <label class="col-md-2 control-label"><font color="red">*</font> RA Test @ Low Load (<50%)</label>
                            <div class="col-md-10">
                                <table class="table table-bordered" id="datatable_mqk_raLow"> 
                                    <thead>
                                        <tr>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Pollutant</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">RA Average</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">PEMS Average</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">Absolute Different</th>
                                            <th class="text-center bg-color-teal txt-color-white">RA</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Result RA</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">      
                            <label class="col-md-2 control-label"><font color="red">*</font> RA Test @ Mid Load (50%-80%)</label>
                            <div class="col-md-10">
                                <table class="table table-bordered" id="datatable_mqk_raNormal"> 
                                    <thead>
                                        <tr>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Pollutant</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">RA Average</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">PEMS Average</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">Absolute Different</th>
                                            <th class="text-center bg-color-teal txt-color-white">RA</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Result RA</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">      
                            <label class="col-md-2 control-label"><font color="red">*</font> RA Test @ High Load (>80%)</label>
                            <div class="col-md-10">
                                <table class="table table-bordered" id="datatable_mqk_raHigh"> 
                                    <thead>
                                        <tr>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Pollutant</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">RA Average</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">PEMS Average</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="20%">Absolute Different</th>
                                            <th class="text-center bg-color-teal txt-color-white">RA</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Result RA</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">      
                            <label class="col-md-2 control-label"><font color="red">*</font> F-Test and Correlation Test</label>
                            <div class="col-md-10">
                                <table class="table table-bordered" id="datatable_mqk_ftest"> 
                                    <thead>
                                        <tr>
                                            <th class="text-center bg-color-teal txt-color-white" width="10%" rowspan="2">Pollutant</th>
                                            <th class="text-center bg-color-teal txt-color-white" colspan="3">F-Value</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="13%" rowspan="2">F-Test Result</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="16%" rowspan="2">Correlation Value</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="13%" rowspan="2">Correlation Result</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center bg-color-teal txt-color-white" width="16%">Low</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="16%">Mid</th>
                                            <th class="text-center bg-color-teal txt-color-white" width="16%">High</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="form_mqk_form">
                        <div class="form-group">      
                            <label class="col-md-2 control-label">Planned Test Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqk_qa_dateExpected" id="mqk_qa_dateExpected" class="form-control mqk_disabled">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                </div>
                            </div>
                        </div>
                        <div class="form-group">      
                            <label class="col-md-2 control-label"><font color="red">*</font> Actual Test Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqk_qa_dateActual" id="mqk_qa_dateActual" class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>          
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="mqk_div_datePoolStart">        
                            <label class="col-md-2 control-label"><font color="red">*</font> Pooling Start Date</label>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" name="mqk_indAll_datePoolStart" id="mqk_indAll_datePoolStart" class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Additional Message</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="mqk_snote_qa_message" id="mqk_snote_qa_message" rows="6"></textarea>
                                <input type="hidden" name="mqk_qa_message" id="mqk_qa_message" />
                            </div>
                        </div>    
                    </form>
                    <form class="form-horizontal" id="form_mqk_doc" method="post" enctype="multipart/form-data">
                        <div class="form-group mqk_hide_view">      
                            <label class="col-md-2 control-label"> Attachment</label>
                            <div class="col-md-6">          
                                <input type="text" class="form-control" name="mqk_supDoc_name" id="mqk_supDoc_name"/>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="file" class="form-control" id="mqk_supDoc_file" name="mqk_supDoc_file" style="width: 100%">
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="mqk_btn_add_supDoc"><i class="fa fa-upload"></i></button>
                                    </span>
                                </div>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label"> <span class="mqk_show_view">Attachment</span></label>
                            <div class="col-md-10">
                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mqk_supportDoc"> 
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
                <h6 class="mqk_div_verify">Verification</h6>
                <div class="well well-light mqk_div_verify">
                    <form class="form-horizontal" id="form_mqk_verify">
                        <div class="form-group">      
                            <label class="col-md-3 control-label"><font color="red">*</font> Verification Result</label>
                            <div class="col-md-9">
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mqk_result" value="17">
                                    <span>Verify</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mqk_result" value="12">
                                    <span>Return for Incompleteness</span>
                                </label>
                                <label class="radio radio-inline">
                                    <input type="radio" class="radiobox" name="mqk_result" value="46">
                                    <span>Reject and Return to Redo Test</span>
                                </label>
                            </div>   
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label"><font color="red">*</font> Message/Feedback</label>
                            <div class="col-md-9">
                                <textarea class="form-control" name="mqk_snote_wfTask_verify" id="mqk_snote_wfTask_verify" rows="6"></textarea>
                                <input type="hidden" name="mqk_wfTask_verify" id="mqk_wfTask_verify" />
                            </div>
                        </div>    
                    </form>
                </div>
                <form class="form-horizontal" id="form_mqk_base">
                    <input type="hidden" name="funct" id="mqk_funct" value="save_qa" /> 
                    <input type="hidden" name="mqk_indAll_id" id="mqk_indAll_id" />
                    <input type="hidden" name="mqk_qa_id" id="mqk_qa_id" />
                    <input type="hidden" name="mqk_qa_type" id="mqk_qa_type" />
                    <input type="hidden" name="mqk_wfTask_id" id="mqk_wfTask_id" />
                    <input type="hidden" name="mqk_wfTaskType_id" id="mqk_wfTaskType_id" />
                    <input type="hidden" name="mqk_wfGroup_id" id="mqk_wfGroup_id" />
                    <input type="hidden" name="mqk_wfTask_status" id="mqk_wfTask_status" />
                    <input type="hidden" name="mqk_wfTask_refName" id="mqk_wfTask_refName" />
                    <input type="hidden" name="mqk_wfTask_refValue" id="mqk_wfTask_refValue" />
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mqk_btn_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success mqk_hide_view" id="mqk_btn_save">
                            <span class="btn-label"><i class="fa fa-save"></i></span>Save
                        </button>
                        <button type="button" class="btn btn-labeled btn-warning mqk_hide_view" id="mqk_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
                
                