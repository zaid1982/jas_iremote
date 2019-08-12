<!-- Modal -->
<div class="modal fade" id="modal_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <form class="form-horizontal" id="form_mus">
            <div class="modal-content">  
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title"><i class='fa fa-user'></i>&nbsp; User Information</h4>
                </div>
                <div class="modal-body modal-fixHeight">   
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Name</label>
                                <div class="col-md-9">   
                                    <div class="input-group">
                                        <input type="text" name="mus_profile_name" id="mus_profile_name" class="form-control mus_viewOnly"/>
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Identification No</label>
                                <div class="col-md-9">   
                                    <div class="input-group">
                                        <input type="text" name="mus_profile_icNo" id="mus_profile_icNo" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="mus_grp_company">
                                <label class="col-md-3 control-label"><font color="red">*</font> Company</label>
                                <div class="col-md-9">   
                                    <div class="input-group">
                                        <input type="text" name="mus_wfGroup_name" id="mus_wfGroup_name" class="form-control mus_viewOnly"/>
                                        <span class="input-group-addon"><i class="fa fa-building"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="mus_grp_agency">
                                <label class="col-md-3 control-label"><font color="red">*</font> Agency</label>
                                <div class="col-md-9 selectContainer">   
                                    <select name="mus_wfGroup_id" id="mus_wfGroup_id" class="form-control"></select>
                                </div>
                            </div> 
                            <div class="form-group" id="mus_grp_department">
                                <label class="col-md-3 control-label"><font color="red">*</font> Department</label>
                                <div class="col-md-9">   
                                    <select name="mus_department_id" id="mus_department_id" class="form-control"><option value=""></option><option value="fwe">32</option></select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Designation</label>
                                <div class="col-md-9">   
                                    <div class="input-group">
                                        <input type="text" name="mus_wfGroupUser_designation" id="mus_wfGroupUser_designation" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Contact No</label>
                                <div class="col-md-9">   
                                    <div class="input-group">
                                        <input type="text" name="mus_profile_mobileNo" id="mus_profile_mobileNo" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Email</label>
                                <div class="col-md-9">   
                                    <div class="input-group">
                                        <input type="text" name="mus_profile_email" id="mus_profile_email" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Roles</label>
                                <div class="col-md-9">   
                                    <select multiple="multiple" name="mus_roles" id="mus_roles" class="form-control custom-scroll" ></select>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label"><font color="red">*</font> Status</label>
                                <div class="col-md-9">   
                                    <label class="radio radio-inline">
                                        <input type="radio" class="radiobox" name="mus_user_status" value="1" checked>
                                        <span>Active</span> 
                                    </label>
                                    <label class="radio radio-inline">
                                        <input type="radio" class="radiobox" name="mus_user_status" value="0">
                                        <span>Off</span>  
                                    </label>
                                </div>
                            </div> 
                        </div>
                    </div>                
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <a hreh="#" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </a>
                            <button type="button" class="btn btn-labeled btn-success" id="mus_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="mus_user_id" id="mus_user_id" />
                <input type="hidden" name="mus_user_type" id="mus_user_type" />
                <input type="hidden" name="mus_role_comma" id="mus_role_comma" />
                <input type="hidden" name="funct" id="funct" value="add_user" />
            </form>
        </div>
    </div>
</div>