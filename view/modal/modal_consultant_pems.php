<div class="modal fade" id="modal_consultant_pems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">   
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-edit'></i>&nbsp; Registration of PEMS Software</h4>
            </div>
            <div class="modal-body modal-fixHeight">
                <section id="widget-grid" class="">
                    <div class="row">
                        <article class="col-sm-12 col-md-12 col-lg-12">
                            <div class="widget-body fuelux">
                                <div class="wizard" id="map_wizard">
                                <ul class="steps">
                                    <li data-target="#map_step1" class="active font-sm">
                                        <span class="badge badge-info">1</span><b>Section A</b> - Company Details<span class="chevron"></span>
                                    </li>
                                    <li data-target="#map_step2" class="font-sm">
                                        <span class="badge">2</span><b>Section B</b> - Information of Analyzer<span class="chevron"></span>
                                    </li>
                                    <li data-target="#map_step3" class="font-sm">
                                        <span class="badge">3</span><b>Section C</b> - Information of Personnel<span class="chevron"></span>
                                    </li>
                                    <li data-target="#map_step5" class="font-sm">
                                        <span class="badge">4</span><b>Section D</b> - Company Working Experience<span class="chevron"></span>
                                    </li>
                                    <li data-target="#map_step6" class="font-sm">
                                        <span class="badge">5</span><b>Section E</b> - Declaration<span class="chevron"></span>
                                    </li>
                                </ul>
                                <div class="actions">
                                    <button type="button" class="btn btn-sm btn-primary btn-prev" id="map_btn_prev">
                                        <i class="fa fa-arrow-left"></i>Prev
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success btn-next" id="map_btn_next" data-last="">
                                        <span id="map_btn_next_label">Next<i class="fa fa-arrow-right"></span></i>
                                    </button>
                                </div>
                            </div>
                            <div class="step-content padding-10 padding-bottom-0 minHeight">                                            
                                <div class="step-pane" id="map_step1" data-step="1">
                                    <form class="form-horizontal" id="form_map_1" method="post">
                                        <div class="alert alert-block alert-danger" id="map_alert_box">
                                            <a class="close" data-dismiss="alert" href="#">×</a>
                                            <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> <span id="lmap_status_desc"></span> Message</h4>
                                            <p id="map_alert_message"></p>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">A. Company Details</h6>                                            
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_13" id="map_check_remark_13">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_13" id="map_check_pass_13">
                                                                    <label class="onoffswitch-label" for="map_check_pass_13"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-2 control-label">Company Name</label>
                                                    <div class="col-md-10">
                                                        <input class="form-control map_disView" name="map_wfGroup_name" id="map_wfGroup_name" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Registration Number</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control map_disView" name="map_wfGroup_regNo" id="map_wfGroup_regNo" />
                                                    </div>
                                                </div>
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Registered Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control map_disView" name="map_address_line1" id="map_address_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control map_disView" name="map_address_postcode" id="map_address_postcode"/>
                                                        </div>
                                                    </div>                                   
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control map_disView" name="map_state_desc" id="map_state_desc"/>
                                                        </div>
                                                    </div>                         
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">City</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control map_disView" name="map_city_desc" id="map_city_desc"/>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Telephone Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="map_wfGroup_phoneNo" id="map_wfGroup_phoneNo" class="form-control map_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Website</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="map_wfGroup_website" id="map_wfGroup_website" class="form-control map_disView"/>
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
                                                            <input type="text" name="map_consultant_dateIncorporate" id="map_consultant_dateIncorporate" class="form-control map_disView" >
                                                            <span class="input-group-addon hidden-sm hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">                                        
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Mailing Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control map_disView" name="map_maddress_line1" id="map_maddress_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control map_disView" name="map_maddress_postcode" id="map_maddress_postcode"/>
                                                        </div>
                                                    </div>                                 
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control map_disView" name="map_mstate_desc" id="map_mstate_desc"/>
                                                        </div>
                                                    </div>                            
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">City</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control map_disView" name="map_mcity_desc" id="map_mcity_desc"/>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Fax Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="map_wfGroup_faxNo" id="map_wfGroup_faxNo" class="form-control map_disView"/>
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
                                                            <input type="text" name="map_profile_name" id="map_profile_name" class="form-control map_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Contact Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="map_profile_mobileNo" id="map_profile_mobileNo" class="form-control map_disView"/>
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
                                                            <input type="text" name="map_wfGroupUser_designation" id="map_wfGroupUser_designation" class="form-control map_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Email Address</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="map_profile_email" id="map_profile_email" class="form-control map_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="step-pane" id="map_step2" data-step="2">
                                    <form class="form-horizontal" id="form_map_2_1" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.1. Information of PEMS Software</h6>                                            
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_14" id="map_check_remark_14">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_14" id="map_check_pass_14">
                                                                    <label class="onoffswitch-label" for="map_check_pass_14"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Modeling Software</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="map_consPems_model" id="map_consPems_model"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Predictive Method</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="map_softwareMethod_id" id="map_softwareMethod_id"></select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Software Development</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="map_consPems_ownerStatus" id="map_consPems_ownerStatus">
                                                            <option value=""></option>
                                                            <option value="1">In House</option>
                                                            <option value="2">Out-source</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Software Version</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="map_consPems_version" id="map_consPems_version"/>
                                                    </div>
                                                </div>     
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Out-sourced Company</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="map_consPems_outsource" id="map_consPems_outsource"/>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12"> 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Mobile-CEMS/Portable Consultant</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="map_consPems_mobileConsultant" id="map_consPems_mobileConsultant"></select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Mobile/Portable Analyzer Model No.</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="map_consPems_mobileCems" id="map_consPems_mobileCems"></select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Security Features of Software</label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control" name="map_consPems_security" id="map_consPems_security" rows="4"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.2. Field of Specialization in PEMS Software</h6>                                       
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_15" id="map_check_remark_15">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_15" id="map_check_pass_15">
                                                                    <label class="onoffswitch-label" for="map_check_pass_15"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>               
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Type of Consultant</label>
                                                    <div class="col-md-9">   
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="map_consultant_type[]" value="1" /><span>Installation</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="map_consultant_type[]" value="2" /><span>Maintenance</span> 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Categories of Emission Monitoring</label>
                                                    <div class="col-md-9">   
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="map_consEmisCate_value[]" value="1" /><span>Gases</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="map_consEmisCate_value[]" value="2" /><span>Particulate</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="map_consEmisCate_value[]" value="3" /><span>Opacity</span> 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Source of Activity</label>
                                                    <div class="col-md-9" id="map_div_sourceActivity"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>                                    
                                    <form class="form-horizontal" id="form_map_2_5" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.3. Information of DAS Software</h6>                                 
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_61" id="map_check_remark_61">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_61" id="map_check_pass_61">
                                                                    <label class="onoffswitch-label" for="map_check_pass_61"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>               
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Probe Software Version</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="map_das_probeSoftware" id="map_das_probeSoftware"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>              
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Probe Software Description</label>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control" name="map_das_probeDesc" id="map_das_probeDesc" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>             
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Analyzer Software Version</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="map_das_analyzerSoftware" id="map_das_analyzerSoftware"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>              
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Analyzer Software Description</label>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control" name="map_das_analyzerDesc" id="map_das_analyzerDesc" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>      
                                        <input type="hidden" name="map_das_id" id="map_das_id" />
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.4. Information of DIS Software</h6>                                 
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_17" id="map_check_remark_17">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_17" id="map_check_pass_17">
                                                                    <label class="onoffswitch-label" for="map_check_pass_17"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>      
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Name of DIS</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="map_dis_name" id="map_dis_name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Status of DIS</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="map_dis_type" id="map_dis_type">
                                                            <option value=""></option>
                                                            <option value="1">In House</option>
                                                            <option value="2">Outsourced</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>                                                
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><font color="red">*</font> Outsourced Company</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" name="map_dis_outsource" id="map_dis_outsource"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Description</label>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control" name="map_dis_description" id="map_dis_description" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="map_dis_id" id="map_dis_id" />
                                    </form>
                                </div>
                                <div class="step-pane" id="map_step3" data-step="3">
                                    <form class="form-horizontal" id="form_map_3" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C. Information of Personnel for PEMS</h6>                                 
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_18" id="map_check_remark_18">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_18" id="map_check_pass_18">
                                                                    <label class="onoffswitch-label" for="map_check_pass_18"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>            
                                        <div class="well margin-bottom-15 padding-bottom-0 map_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Name of Certified Employee</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="map_consPers_name" id="map_consPers_name"/>
                                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Citizenship</label>
                                                        <div class="col-md-6">   
                                                            <div class="radiobox">
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="map_personnel_citizenship" value="1" checked /><span>Malaysian</span> 
                                                                </label>
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="map_personnel_citizenship" value="2" /><span>Others</span> 
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Employee's Status</label>
                                                        <div class="col-md-6">
                                                            <div class="radiobox">
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="map_consPers_workingStatus" value="1" checked /><span>Staff</span> 
                                                                </label>
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="map_consPers_workingStatus" value="2" /><span>Loan / Contracted</span> 
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> IC / Passport No.</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="map_personnel_icNo" id="map_personnel_icNo"/>
                                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Year Working Experience</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="map_consPers_experience" id="map_consPers_experience"/>
                                                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Academic Qualification</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="map_consPers_qualification" id="map_consPers_qualification"/>
                                                                <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Training Cert. from Manufacturer</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="map_consPers_certificate" id="map_consPers_certificate"/>
                                                                <span class="input-group-addon"><i class="fa fa-certificate"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>        
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red" id="map_star_document_name">*</font> Support Document</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="map_consPers_document_name" id="map_consPers_document_name" placeholder="Document Title"/>
                                                        </div>
                                                    </div>    
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-7">
                                                            <input type="file" class="form-control" id="map_consPers_document" name="map_consPers_document" style="width: 100%">
                                                        </div>
                                                    </div>                                                 
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="map_btn_add_personnel">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_map_personnel"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>        
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">IC / Passport No.</th>    
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone">Employee's Name</th>   
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone">Employee's Status</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Academic Qualification</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Working Experience</th>
                                                            <th class="text-center bg-color-teal txt-color-white">Training Certification</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="60px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>   
                                <div class="step-pane" id="map_step5" data-step="5">
                                    <form class="form-horizontal" id="form_map_5" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">D. Information on Company's Working Experience</h6>                                 
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_22" id="map_check_remark_22">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_22" id="map_check_pass_22">
                                                                    <label class="onoffswitch-label" for="map_check_pass_22"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>      
                                        <div class="well margin-bottom-15 padding-bottom-0 map_hideView">
                                            <div class="row">                                                
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Project Title</label>
                                                        <div class="col-md-9"><input type="text" class="form-control" name="map_consProject_title" id="map_consProject_title"/></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label"><font color="red">*</font> Year</label>
                                                        <div class="col-md-7 selectContainer">
                                                            <select class="form-control" name="map_consProject_year" id="map_consProject_year">
                                                                <option value=""></option>
                                                            <?php for ($yr=date('Y'); $yr>=1950; $yr--) { ?>
                                                                <option value="<?=$yr?>"><?=$yr?></option>
                                                            <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Client</label>
                                                        <div class="col-md-10"><input type="text" class="form-control" name="map_consProject_client" id="map_consProject_client"/></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Project Description</label>
                                                        <div class="col-md-10"><input type="text" class="form-control" name="map_consProject_desc" id="map_consProject_desc"/></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Scope of Work</label>
                                                        <div class="col-md-10"><input type="text" class="form-control" name="map_consProject_scope" id="map_consProject_scope"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                                
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Source of Activity</label>
                                                        <div class="col-md-9 selectContainer">
                                                            <select class="form-control" name="map_consProject_source" id="map_consProject_source"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Project Value</label>
                                                        <div class="col-md-7">   
                                                            <div class="input-group">
                                                                <span class="input-group-addon">RM</span>       
                                                                <input type="text" name="map_consProject_value" id="map_consProject_value" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">  
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="map_btn_add_project">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_map_project"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="35px" data-hide="phone">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Project Title</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="40px">Year</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Client</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Project Description</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Scope of Work</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Source of Activity</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="80px">Project Value</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="40px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>    
                                <div class="step-pane" id="map_step6" data-step="6">
                                    <form class="form-horizontal" id="form_map_6" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">E. Declaration</h6>                                 
                                                    <div class="col-md-7 map_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control map_form_check" placeholder="Remark" type="text" name="map_check_remark_23" id="map_check_remark_23">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox map_form_check" name="map_check_pass_23" id="map_check_pass_23">
                                                                    <label class="onoffswitch-label" for="map_check_pass_23"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="Pass" data-swchoff-text="Fail"></span> 
                                                                        <span class="onoffswitch-switch"></span> 
                                                                    </label> 
                                                                </span>
                                                            </span>
                                                        </div>   
                                                    </div>
                                                </div>
                                            </div>                                                                             
                                        </div>      
                                        <div class="well">
                                            <div class="row">
                                                <div class="col-md-12" style="padding-left: 25px">
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="map_declare_1" >
                                                                <span style="line-height: 22px;">I / We hereby declare that all the information furnished in this form and any annexure(s) that comes with it are true, accurate, complete and up-to-date in all respect.</span>
                                                            </label>
                                                        </div> 
                                                    </div>  
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="map_declare_2" >
                                                                <span style="line-height: 22px;">I / We authorize the Malaysian Department of Environment to publish the following information in the Department's website at http://www.doe.gov.my.</span>
                                                            </label>
                                                        </div> 
                                                    </div>  
                                                    <div class="form-group">
                                                        <div class="padding-10 padding-top-0">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <span>- Information furnished in the application form.</span>
                                                                </label>
                                                            </div> 
                                                            <div class="checkbox">
                                                                <label>
                                                                    <span>- Details Information of Analyzers, Equipment and Employee Working Experience.</span>
                                                                </label>
                                                            </div> 
                                                            <div class="checkbox">
                                                                <label>
                                                                    <span>- Details Information of Personnel for PEMS.</span>
                                                                </label>
                                                            </div> 
                                                            <div class="checkbox">
                                                                <label>
                                                                    <span>- Details Information of DIS Software.</span>
                                                                </label>
                                                            </div> 
                                                        </div>  
                                                    </div>  
                                                    <div class="form-group padding-top-15">
                                                        <label class="col-md-2 control-label">Name</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="map_decl_profile_name" class="form-control map_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">NRIC No</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="map_decl_profile_icNo" class="form-control map_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Position</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="map_decl_wfGroupUser_designation" class="form-control map_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Date</label>
                                                        <div class="col-md-3">
                                                            <input type="text" id="map_consAll_dateDeclaration" class="form-control map_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Remark</label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control" name="map_snote_wfTask_remark" id="map_snote_wfTask_remark" rows="6"></textarea>
                                                            <input type="hidden" name="map_wfTask_remark" id="map_wfTask_remark" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                    </form>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
            </div> 
            <div class="modal-footer">
                <form class="form-horizontal" id="form_map" method="post">
                    <input type="hidden" name="map_wfGroup_id" id="map_wfGroup_id" />
                    <input type="hidden" name="map_consAll_id" id="map_consAll_id" />
                    <input type="hidden" name="map_consultant_id" id="map_consultant_id" />
                    <input type="hidden" name="map_wfTask_id" id="map_wfTask_id" />
                    <input type="hidden" name="map_wfTaskType_id" id="map_wfTaskType_id" />
                    <input type="hidden" name="map_wfTask_status" id="map_wfTask_status" />
                    <input type="hidden" name="map_load_type" id="map_load_type" />
                    <input type="hidden" name="funct" id="map_funct" value="save_consultant_pems" />
                    <div class="row">
                        <div class="col-md-12">
                            <a hreh="#" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </a>
                            <button type="button" class="btn btn-labeled btn-success map_hideView" id="map_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                            <button type="button" class="btn btn-labeled btn-warning map_hideView" id="map_btn_submit">
                                <span class="btn-label"><i class="fa fa-sign-in"></i></span>Submit
                            </button>
                        </div>
                    </div>
                </form>                    
            </div>                
        </div>
    </div>
</div>
