<div class="modal fade" id="modal_industrial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">   
            <form class="form-horizontal" id="form_mid">
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <a hreh="#" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </a>
                    <h4 class="modal-title"><i class='fa fa-edit'></i>&nbsp; Industrial Information</h4>
                </div>
                <div class="modal-body modal-fixHeight">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Industrial Name</label>
                                <div class="col-md-10">
                                    <div class="input-group">
                                        <input type="text" name="mid_wfGroup_name" id="mid_wfGroup_name" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-industry"></i></span>         
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row">                                
                        <div class="col-md-6">    
                            <div class="form-group">
                                <label class="col-md-4 control-label">JAS File No</label>
                                <div class="col-md-8">
                                    <input type="text" name="mid_industrial_jasFileNo" id="mid_industrial_jasFileNo" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Plant Sector</label>
                                <div class="col-md-8">
                                    <input class="form-control" name="mid_sic_desc" id="mid_sic_desc" />
                                </div>
                            </div> 
                            <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> Plant Address</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="mid_address_line1" id="mid_address_line1" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mid_address_postcode" id="mid_address_postcode"/>
                                    </div>
                                </div>                        
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                    <div class="col-md-8">
                                        <input type="text"  class="form-control" name="mid_city_desc" id="mid_city_desc"/>
                                    </div>
                                </div>                                  
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mid_state_desc" id="mid_state_desc"/>
                                    </div>
                                </div>      
                            </div>     
                            <div class="form-group">
                                <label class="col-md-4 control-label">Parliament</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="mid_parlimen_desc" id="mid_parlimen_desc" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-building"></i></span>         
                                    </div>
                                </div>
                            </div>   
                            <div class="form-group">
                                <label class="col-md-4 control-label">Plant Longitude</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="mid_location_longitude" id="mid_location_longitude" class="form-control"/>
                                        <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                    </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label">Plant Latitude</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="mid_location_latitude" id="mid_location_latitude" class="form-control"/>
                                        <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                    </div>
                                </div>
                            </div>     
                            <div class="form-group">
                                <label class="col-md-4 control-label"><font color="red">*</font> Total Stacks</label>
                                <div class="col-md-8">
                                    <input class="form-control" name="mid_industrial_totalStack" id="mid_industrial_totalStack" />
                                </div>
                            </div>                        
                        </div>
                        <div class="col-md-6"> 
                            <div class="form-group">
                                <label class="col-md-4 control-label">JAS Premise ID</label>
                                <div class="col-md-8">
                                    <input type="text" name="mid_industrial_premiseId" id="mid_industrial_premiseId" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Plant Sub Sector</label>
                                <div class="col-md-8">
                                    <input class="form-control" name="mid_subSic_desc" id="mid_subSic_desc" />
                                </div>
                            </div>    
                            <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> Mailing Address</label>
                                    <div class="col-md-8">
                                        <textarea class="form-control" name="mid_maddress_line1" id="mid_maddress_line1" rows="4"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mid_maddress_postcode" id="mid_maddress_postcode"/>
                                    </div>
                                </div>                        
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                    <div class="col-md-8">
                                        <input type="text"  class="form-control" name="mid_mcity_desc" id="mid_mcity_desc"/>
                                    </div>
                                </div>                                  
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="mid_mstate_desc" id="mid_mstate_desc"/>
                                    </div>
                                </div>      
                            </div>   
                            <div class="form-group">
                                <label class="col-md-4 control-label"><font color="red">*</font> Phone Number</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mid_wfGroup_phoneNo" id="mid_wfGroup_phoneNo" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-phone"></i></span>         
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Fax Number</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mid_wfGroup_faxNo" id="mid_wfGroup_faxNo" class="form-control"/>
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
                                        <input type="text" name="mid_profile_name" id="mid_profile_name" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Contact Number</label>
                                <div class="col-md-8">   
                                    <div class="input-group">
                                        <input type="text" name="mid_profile_mobileNo" id="mid_profile_mobileNo" class="form-control"/>
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
                                        <input type="text" name="mid_wfGroupUser_designation" id="mid_wfGroupUser_designation" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email Address</label>
                                <div class="col-md-8">                                               
                                    <div class="input-group">
                                        <input type="text" name="mid_profile_email" id="mid_profile_email" class="form-control"/>
                                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="modal-footer">
                    <input type="hidden" name="mid_consultant_id" id="mid_consultant_id" />
                    <input type="hidden" name="mid_load_type" id="mid_load_type" />
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
