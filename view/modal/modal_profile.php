<!-- Modal -->
<div class="modal fade" id="modal_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-user'></i>&nbsp; User Information</h4>
            </div>
            <div class="modal-body">   
                <div id="tabs">
                    <ul>
                        <li>
                            <a href="#mpf_tabs-a">User Profile</a>
                        </li>
                        <li id="mpf_li_b">
                            <a href="#mpf_tabs-b">Change Password</a>
                        </li>
                    </ul>                        
                    <div id="mpf_tabs-a">                            
                        <form class="form-horizontal" id="form_mpfa">
                            <div class="row">
                                <div class="col-md-12">   
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Name</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_profile_name" id="mpfa_profile_name" class="form-control" />
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Identification No</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_profile_icNo" id="mpfa_profile_icNo" class="form-control" />
                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Company/Agency</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_wfGroup_name" id="mpfa_wfGroup_name" class="form-control" disabled/>
                                                <span class="input-group-addon"><i class="fa fa-building"></i></span>       
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Department</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_department_desc" id="mpfa_department_desc" class="form-control" disabled/>
                                                <span class="input-group-addon"><i class="fa fa-building"></i></span>       
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Designation</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_wfGroupUser_designation" id="mpfa_wfGroupUser_designation" class="form-control" disabled/>
                                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Contact No</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_profile_mobileNo" id="mpfa_profile_mobileNo" class="form-control" />
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Email</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfa_profile_email" id="mpfa_profile_email" class="form-control" />
                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Roles</label>
                                        <div class="col-md-9">   
                                            <textarea class="form-control" rows="3" name="mpfa_list_role" id="mpfa_list_role" disabled></textarea>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" name="mpfa_user_id" id="mpfa_user_id" />                            
                            <input type="hidden" name="funct" id="funct" value="update_profile" />
                            <div class="form-actions">
                                <button type="button" class="btn btn-labeled btn-danger pull-left" id="mpfa_btn_cancel" data-dismiss="modal">
                                    <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                                </button>
                                <button type="button" class="btn btn-labeled btn-success" id="mpfa_btn_update">
                                    <span class="btn-label"><i class="fa fa-save"></i></span>Update
                                </button>
                            </div>
                        </form>
                    </div>
                    <div id="mpf_tabs-b">
                        <form class="form-horizontal" id="form_mpfb">
                            <div class="row">
                                <div class="col-md-12">   
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Current Password</label>
                                        <div class="col-md-9">   
                                            <input type="password" name="mpfb_password_current" id="mpfb_password_current" class="form-control" />
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> New Password</label>
                                        <div class="col-md-9">   
                                            <input type="password" name="mpfb_password_new" id="mpfb_password_new" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Confirm Password</label>
                                        <div class="col-md-9">   
                                            <input type="password" name="mpfb_password_confirm" id="mpfb_password_confirm" class="form-control" />
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Security Question</label>
                                        <div class="col-md-9 selectContainer">
                                            <select name="mpfb_secQues_id" id="mpfb_secQues_id" class="form-control"></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><font color="red">*</font> Security Answer</label>
                                        <div class="col-md-9">   
                                            <div class="input-group">
                                                <input type="text" name="mpfb_user_security_answer" id="mpfb_user_security_answer" class="form-control" />
                                                <span class="input-group-addon"><i class="fa fa-key"></i></span>       
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <input type="hidden" name="mpfb_user_id" id="mpfb_user_id" />    
                            <input type="hidden" name="mpfb_user_password" id="mpfb_user_password" />    
                            <input type="hidden" name="funct" id="funct" value="change_password" />
                            <div class="form-actions bordered">
                                <button type="button" class="btn btn-labeled btn-danger pull-left" id="mpfb_btn_cancel" data-dismiss="modal">
                                    <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                                </button>
                                <button type="button" class="btn btn-labeled btn-success" id="mpfb_btn_update">
                                    <span class="btn-label"><i class="fa fa-save"></i></span>Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>