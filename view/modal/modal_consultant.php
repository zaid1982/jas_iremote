<div class="modal fade" id="modal_consultant" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">   
            <form class="form-horizontal" id="form_mcs" method="post">     
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <a hreh="#" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </a>
                    <h4 class="modal-title"><i class='fa fa-edit'></i>&nbsp; Consultant Information</h4>
                </div>
                <div class="modal-body modal-fixHeight">                                           
<!--                    <h6>A. Company Details</h6>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Company Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" name="mcs_wfGroup_name" id="mcs_wfGroup_name" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Registration Number</label>
                                <div class="col-md-8">
                                    <input class="form-control" name="mcs_wfGroup_regNo" id="mcs_wfGroup_regNo" />
                                </div>
                            </div>
                            <div class="well well-light margin-bottom-15 padding-bottom-0">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Registered Address</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="mcs_address_line1" id="mcs_address_line1" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Postcode</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mcs_address_postcode" id="mcs_address_postcode"/>
                                    </div>
                                </div>                                   
                                <div class="form-group">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mcs_state_desc" id="mcs_state_desc"/>
                                    </div>
                                </div>                         
                                <div class="form-group">
                                    <label class="col-md-4 control-label">City</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mcs_city_desc" id="mcs_city_desc"/>
                                    </div>
                                </div>    
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Telephone Number</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_wfGroup_phoneNo" id="mcs_wfGroup_phoneNo" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Website</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_wfGroup_website" id="mcs_wfGroup_website" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-internet-explorer"></i></span>       
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Incorporate Date</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="mcs_consultant_dateIncorporate" id="mcs_consultant_dateIncorporate" class="form-control" >
                                        <span class="input-group-addon hidden-sm hidden-xs"><i class="fa fa-calendar"></i></span>        
                                    </div>
                                </div>
                            </div>
                            <div class="well well-light margin-bottom-15 padding-bottom-0">                                        
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Mailing Address</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="mcs_maddress_line1" id="mcs_maddress_line1" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Postcode</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mcs_maddress_postcode" id="mcs_maddress_postcode"/>
                                    </div>
                                </div>                                 
                                <div class="form-group">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mcs_mstate_desc" id="mcs_mstate_desc"/>
                                    </div>
                                </div>                            
                                <div class="form-group">
                                    <label class="col-md-4 control-label">City</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mcs_mcity_desc" id="mcs_mcity_desc"/>
                                    </div>
                                </div>   
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Fax Number</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_wfGroup_faxNo" id="mcs_wfGroup_faxNo" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-fax "></i></span>       
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Contact Person</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_profile_name" id="mcs_profile_name" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Contact Number</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_profile_mobileNo" id="mcs_profile_mobileNo" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-phone-square"></i></span>       
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Position</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_wfGroupUser_designation" id="mcs_wfGroupUser_designation" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email Address</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mcs_profile_email" id="mcs_profile_email" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                    <input type="hidden" name="mcs_consultant_id" id="mcs_consultant_id" />
                    <input type="hidden" name="mcs_load_type" id="mcs_load_type" />
                    <div class="row">
                        <div class="col-md-12">
                            <a hreh="#" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </a>
                        </div>
                    </div>

                </div>       
            </form>  
        </div>
    </div>
</div>
