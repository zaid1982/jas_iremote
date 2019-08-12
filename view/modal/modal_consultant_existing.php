<!-- Modal -->
<div class="modal fade" id="modal_consultant_existing" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-hdd-o'></i>&nbsp; <span id="mcx_title"></span> Old CEMS Analyzer</h4>
            </div>
            <div class="modal-body">   
                <form class="form-horizontal" id="form_mcx">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label text-left text-italic padding-left-15">** Notes: This analyzer and consultant is not registered previously and will not available for new analyzer.</label>
                            </div>   
                        </div>       
                    </div>
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Consultant Name</label>
                                <div class="col-md-9">   
                                    <input type="text" name="mcx_consUnr_consultant" id="mcx_consUnr_consultant" class="form-control">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Model No.</label>
                                <div class="col-md-9">   
                                    <input type="text" name="mcx_consUnr_modelNo" id="mcx_consUnr_modelNo" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Input Parameter</label>
                                <div class="col-md-9">         
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="1" /><span>Total PM</span> 
                                        </label>
                                    </div>   
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="2" /><span>SO<sub>2</sub></span> 
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="3" /><span>NO<sub>2</sub></span> 
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="4" /><span>HCl</span> 
                                        </label>
                                    </div>   
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="5" /><span>HF</span> 
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="6" /><span>CO</span> 
                                        </label>
                                    </div>     
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="7" /><span>NMVOC</span> 
                                        </label>
                                    </div>    
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="8" /><span>Opacity</span> 
                                        </label>
                                    </div>         
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="9" /><span>O<sub>2</sub></span> 
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="mcx_inputParam_id[]" value="10" /><span>CO<sub>2</sub></span> 
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="mcx_indAll_id" id="mcx_indAll_id"/>
                    <input type="hidden" name="mcx_consAll_id" id="mcx_consAll_id"/>
                    <input type="hidden" name="funct" id="mcx_funct" />
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mcx_btn_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success" id="mcx_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>