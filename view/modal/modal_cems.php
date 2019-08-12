<div class="modal fade" id="modal_cems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">   
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-edit'></i>&nbsp; <span id='lmce_title'></span> Application of CEMS Installation</h4>
            </div>
            <div class="modal-body modal-fixHeight">
                <section id="widget-grid" class="">
                    <div class="row">
                        <article class="col-sm-12 col-md-12 col-lg-12">
                            <div class="widget-body fuelux">
                                <div class="wizard" id="mce_wizard">
                                    <ul class="steps">
                                        <li data-target="#mce_step1" class="active font-sm">
                                            <span class="badge badge-info">1</span><b>Section A</b> - Industrial Details<span class="chevron"></span>
                                        </li>
                                        <li data-target="#mce_step2" class="font-sm">
                                            <span class="badge">2</span><b>Section B</b> - Source of Emission<span class="chevron"></span>
                                        </li>
                                        <li data-target="#mce_step3" class="font-sm">
                                            <span class="badge">3</span><b>Section C</b> - CEMS Equipment<span class="chevron"></span>
                                        </li>
                                        <li data-target="#mce_step4" class="font-sm">
                                            <span class="badge">4</span><b>Section D</b> - CEMS Personel<span class="chevron"></span>
                                        </li>
                                        <li data-target="#mce_step5" class="font-sm">
                                            <span class="badge">5</span><b>Section E</b> - Declaration<span class="chevron"></span>
                                        </li>
                                    </ul>
                                    <div class="actions">
                                        <button type="button" class="btn btn-sm btn-primary btn-prev" id="mce_btn_prev">
                                            <i class="fa fa-arrow-left"></i>Prev
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success btn-next" id="mce_btn_next" data-last="Finish">
                                            <span id="mce_btn_next_label">Next<i class="fa fa-arrow-right"></span></i>
                                        </button>
                                    </div>
                                </div>
                            
                            <div class="step-content padding-10 padding-bottom-0 minHeight">                                            
                                <div class="step-pane" id="mce_step1" data-step="1">
                                    <form class="form-horizontal" id="form_mce_1" method="post">                                                          
                                        <div class="alert alert-block alert-danger" id="mce_alert_box">
                                            <a class="close" data-dismiss="alert" href="#">×</a>
                                            <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> <span id="lmce_status_desc"></span> Message</h4>
                                            <p id="mce_alert_message"></p>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">A. Industrial Details</h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_37" id="mce_check_remark_37">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_37" id="mce_check_pass_37">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_37"> 
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
                                                    <label class="col-md-2 control-label">Industrial Name</label>
                                                    <div class="col-md-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_wfGroup_name" id="mce_wfGroup_name"/>
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
                                                        <input type="text" class="form-control mce_disView" name="mce_industrial_jasFileNo" id="mce_industrial_jasFileNo" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Sector</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mce_disView" name="mce_sic_desc" id="mce_sic_desc" />
                                                    </div>
                                                </div> 
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Plant Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control mce_disView" name="mce_address_line1" id="mce_address_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mce_disView" name="mce_address_postcode" id="mce_address_postcode"/>
                                                        </div>
                                                    </div>                        
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                                        <div class="col-md-8">
                                                            <input type="text"  class="form-control mce_disView" name="mce_city_desc" id="mce_city_desc"/>
                                                        </div>
                                                    </div>                                  
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mce_disView" name="mce_state_desc" id="mce_state_desc"/>
                                                        </div>
                                                    </div>      
                                                </div>     
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Parliament</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_parlimen_desc" id="mce_parlimen_desc"/>
                                                            <span class="input-group-addon"><i class="fa fa-building"></i></span>         
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Longitude</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_location_longitude" id="mce_location_longitude"/>
                                                            <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Latitude</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_location_latitude" id="mce_location_latitude"/>
                                                            <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                                        </div>
                                                    </div>
                                                </div>     
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><font color="red">*</font> Total Stacks</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mce_disView" name="mce_industrial_totalStack" id="mce_industrial_totalStack" />
                                                    </div>
                                                </div>                        
                                            </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">JAS Premise ID</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mce_disView" name="mce_industrial_premiseId" id="mce_industrial_premiseId" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Sub Sector</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mce_disView" name="mce_subSic_desc" id="mce_subSic_desc" />
                                                    </div>
                                                </div>    
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Mailing Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control mce_disView" name="mce_maddress_line1" id="mce_maddress_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mce_disView" name="mce_maddress_postcode" id="mce_maddress_postcode"/>
                                                        </div>
                                                    </div>                        
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                                        <div class="col-md-8">
                                                            <input type="text"  class="form-control mce_disView" name="mce_mcity_desc" id="mce_mcity_desc"/>
                                                        </div>
                                                    </div>                                  
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mce_disView" name="mce_mstate_desc" id="mce_mstate_desc"/>
                                                        </div>
                                                    </div>      
                                                </div>   
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><font color="red">*</font> Phone Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_wfGroup_phoneNo" id="mce_wfGroup_phoneNo"/>
                                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>         
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Fax Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_wfGroup_faxNo" id="mce_wfGroup_faxNo"/>
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
                                                            <input type="text" class="form-control mce_disView" name="mce_profile_name" id="mce_profile_name"/>
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Contact Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_profile_mobileNo" id="mce_profile_mobileNo"/>
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
                                                            <input type="text" class="form-control mce_disView" name="mce_wfGroupUser_designation" id="mce_wfGroupUser_designation"/>
                                                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Email Address</label>
                                                    <div class="col-md-8">                                               
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mce_disView" name="mce_profile_email" id="mce_profile_email"/>
                                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>                                    
                                </div>                                  
                                <div class="step-pane" id="mce_step2" data-step="2">
                                    <form class="form-horizontal" id="form_mce_2_1" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.1. Source of Emission</h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_38" id="mce_check_remark_38">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_38" id="mce_check_pass_38">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_38"> 
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
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Reasons of CEMS Installation</label>
                                                    <div class="col-md-9">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_indReason_id[]" value="1">
                                                                <span>EIA Condition Requirement</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_indReason_id[]" value="2">
                                                                <span>CAR, 2014</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_indReason_id[]" value="3">
                                                                <span>License under Prescribe Premises</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_indReason_id[]" value="4">
                                                                <span>Other (please specify)</span> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>                                            
                                                <div class="form-group padding-top-0">
                                                    <label class="col-md-3 control-label text-align-left"></label>
                                                    <div class="col-md-5" style="padding-left: 33px">                                                    
                                                        <input type="text" name="mce_indReason_other" id="mce_indReason_other" class="form-control mce_disReason" placeholder="Other Reason"/>                                               
                                                    </div>
                                                </div>                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Source of Activity</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="mce_sourceActivity_id" id="mce_sourceActivity_id"></select>
                                                    </div>
                                                </div>                                             
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Source</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="mce_sourceCapacity_id" id="mce_sourceCapacity_id"></select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Type of Fuel</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control mce_disView" name="mce_fuelType_id" id="mce_fuelType_id">
                                                            <option value=""></option>
                                                            <option value="1">Solid & Liquid Fuels</option>
                                                            <option value="2">Gaseous Fuels</option>
                                                            <option value="3">Liquid Fuels</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label">Fuel Quantity</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_fuelQuantity" id="mce_indAll_fuelQuantity"/>
                                                            <span class="input-group-addon">kg/h</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Type of Metal</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control mce_disView" name="mce_metalType_id" id="mce_metalType_id">
                                                            <option value=""></option>
                                                            <option value="1">Cadmium</option>
                                                            <option value="2">Lead (PB)</option>
                                                            <option value="3">Other Metal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label">Source Capacity</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_sourceCapacity" id="mce_indAll_sourceCapacity"/>
                                                            <span class="input-group-addon">MW<sub>e</sub></span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">                                                 
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Pollution Monitored</label>
                                                    <div class="col-md-9">
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="mce_pollutionMonitored_id[]" value="1" /><span>Gases</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="mce_pollutionMonitored_id[]" value="2" /><span>Opacity</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="mce_pollutionMonitored_id[]" value="3" /><span>Particulates / Dust</span> 
                                                        </label>
                                                    </div>
                                                </div>      
                                                <div class="row padding-top-5">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Parameters to be Monitored</label>
                                                    <div class="col-md-9">
                                                        <table class="table table-bordered" id="datatable_mce_parameter"> 
                                                            <thead>
                                                                <tr>
                                                                    <th width="5%" class="text-center bg-color-teal txt-color-white">No.</th>
                                                                    <th class="text-center bg-color-teal txt-color-white">Parameters</th>
                                                                    <th width="20%" class="text-center bg-color-teal txt-color-white">Gas Reference</th>
                                                                    <th width="20%" class="text-center bg-color-teal txt-color-white">Limit Value *</th>
                                                                    <th width="20%" class="text-center bg-color-teal txt-color-white">Concentration **</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                        <p class="margin-bottom-0"><i>* Notes: Limit value for each parameter may subjects to the limits mentioned in CAR 2014 and/or EIA Approval Condition</i></p>
                                                        <p><i>** Concentration Refer to ISO Kinetic Sampling</i></p>
                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.2. Stack Information</h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_39" id="mce_check_remark_39">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_39" id="mce_check_pass_39">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_39"> 
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack ID</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="mce_indAll_stackNo" id="mce_indAll_stackNo"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Height</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_stackHeight" id="mce_indAll_stackHeight"/>
                                                            <span class="input-group-addon">m</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Diameter</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_stackDiameter" id="mce_indAll_stackDiameter"/>
                                                            <span class="input-group-addon">m</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Longitude</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_stackLongitude" id="mce_indAll_stackLongitude" step="any" min="-180" max="180" maxlength="10"/>
                                                            <span class="input-group-addon"><sup>o</sup></span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Latitude</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_stackLatitude" id="mce_indAll_stackLatitude" step="any" min="-180" max="180" maxlength="10"/>
                                                            <span class="input-group-addon"><sup>o</sup></span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.3. Flue Gas Information <small>(During normal plant operation)</small></h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_40" id="mce_check_remark_40">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_40" id="mce_check_pass_40">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_40"> 
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
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Temperature</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_gasTemperature" id="mce_indAll_gasTemperature"/>
                                                            <span class="input-group-addon"><sup>o</sup>C</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Air Flow Rate</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_airFlowRate" id="mce_indAll_airFlowRate"/>
                                                            <span class="input-group-addon">m<sup>3</sup>/h</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Velocity</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_stackVelocity" id="mce_indAll_stackVelocity"/>
                                                            <span class="input-group-addon">m/s</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Moisture Content</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_moistureContect" id="mce_indAll_moistureContect"/>
                                                            <span class="input-group-addon">%</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Pressure</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mce_indAll_pressure" id="mce_indAll_pressure"/>
                                                            <span class="input-group-addon">kPA</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mce_2_2" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.4. Written Approval or Notification Status of Specified Equipment</h6>                                                                                 
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_41" id="mce_check_remark_41">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_41" id="mce_check_pass_41">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_41"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mce_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label text-left text-italic padding-left-15">* Notes: Please attached at least 1 Written Approval or Notification Status of Specified Equipment.</label>
                                                    </div>   
                                                </div>       
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 margin-bottom-5">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment Type</label>
                                                        <div class="col-md-9">
                                                            <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mce_written_type" value="13">
                                                                <span>Fuel Burning Equipment</span>
                                                            </label>
                                                             <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mce_written_type" value="14">
                                                                <span>Air Pollution Control</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Equipment Name</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="mce_indWritten_equipmentName" id="mce_indWritten_equipmentName" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Reference No.</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="mce_indWritten_referenceNo" id="mce_indWritten_referenceNo" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Reference Date</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" name="mce_indWritten_dateReference" id="mce_indWritten_dateReference" class="form-control" readonly >
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">                            
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment File (PDF)</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="mce_file_written_name" name="mce_file_written_name" placeholder="Document Title">
                                                        </div>
                                                    </div>                      
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mce_file_written" name="mce_file_written" style="width: 100%">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mce_btn_add_written">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mce_written"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Equipment Name</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="19%">Type</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">Reference No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet" width="14%">Date</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30%" data-hide="phone">Document Title</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="55px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mce_2_3" method="post" enctype="multipart/form-data">     
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.5. Industrial Process Description <small>(Related to the Specified Chimney for this purpose of CEMS Installation)</small></h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_42" id="mce_check_remark_42">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_42" id="mce_check_pass_42">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_42"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mce_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label text-left text-italic padding-left-15">* Notes: Please attached all types of documents related to the specified chimney.</label>
                                                    </div>   
                                                </div>       
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment Type</label>
                                                        <div class="col-md-9 selectContainer">
                                                            <select class="form-control" name="mce_document_type" id="mce_document_type"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="mce_div_doc_other">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Other Type</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="mce_indDoc_others" id="mce_indDoc_others" class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>       
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">                            
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment File (PDF)</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="mce_file_document_name" name="mce_file_document_name" placeholder="Document Title">
                                                        </div>
                                                    </div>                      
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mce_file_document" name="mce_file_document" style="width: 100%">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mce_btn_add_document">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mce_document"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30%" data-hide="phone">Type</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Document Title</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="55px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>                                                
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="step-pane" id="mce_step3" data-step="3">        
                                    <form class="form-horizontal" id="form_mce_3_3" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.1. Information of CEMS Equipment</h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_43" id="mce_check_remark_43">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_43" id="mce_check_pass_43">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_43"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mce_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label text-left text-italic padding-left-15">* Notes: Please make sure all analyzers can monitor emission of these input parameter: <strong><span id="mce_lbl_listInput"></span></strong></label>
                                                    </div>   
                                                </div>       
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> CEMS Consultant</label>
                                                        <div class="col-md-9 selectContainer">
                                                            <select class="form-control" name="mce_consultant_id" id="mce_consultant_id"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Analyzer Model</label>
                                                        <div class="col-md-5 selectContainer">
                                                            <select class="form-control" name="mce_consAll_id" id="mce_consAll_id"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">Analyzer Registration No.</label>
                                                        <div class="col-md-9 control-label text-left" id="mce_divAnalyzerDetails"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <div class="pull-right">
                                                                <button type="button" class="btn btn-labeled btn-warning" onclick="f_load_mcx(1,mce_indAll_id.value,'','mce');">
                                                                    <span class="btn-label"><i class="fa fa-plus-square-o"></i></span>Add Unregistered Analyzer
                                                                </button>
                                                                <button type="button" class="btn btn-labeled btn-primary" id="mce_btn_add_consultant">
                                                                    <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mce_consultant"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Analyzer Registration No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,table">Analyzer Model</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30%" data-hide="phone,table">Consultant</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="20%" data-hide="phone">Input Parameter</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="60px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mce_3_1" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.2. Quality Assurance Plan</h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_44" id="mce_check_remark_44">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_44" id="mce_check_pass_44">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_44"> 
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
                                                    <label class="col-md-3 control-label">Zero / Span Check (daily)</label>
                                                    <div class="col-md-1">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox style-3" name="mce_indAll_qaFreqDaily" value="1" ><span>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label class="col-md-1 control-label mce_q_daily">Method</label>
                                                    <div class="col-md-5 mce_q_daily">
                                                        <label class="radio radio-inline">
                                                            <input type="radio" class="radiobox" name="mce_indAll_qaMethod" value="1" /><span>Automatic</span> 
                                                        </label>
                                                        <label class="radio radio-inline">
                                                            <input type="radio" class="radiobox" name="mce_indAll_qaMethod" value="2" /><span>Manual</span> 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">RAA (quarterly)</label>
                                                    <div class="col-md-1">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox style-3" name="mce_indAll_qaFreqQuarterly" value="1" ><span>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                    <label class="col-md-1 control-label mce_q_quarter">Schedule</label>
                                                    <div class="col-md-5 mce_q_quarter">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_q_indQuarter_no[]" value="1" ><span>Quarter 1</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_q_indQuarter_no[]" value="2" ><span>Quarter 2</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_q_indQuarter_no[]" value="3" ><span>Quarter 3</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mce_q_indQuarter_no[]" value="4" ><span>Quarter 4</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">RATA (yearly)</label>
                                                    <div class="col-md-1">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox style-3" name="mce_indAll_qaFreqYearly" value="1" ><span>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                    <label class="col-md-1 control-label mce_q_year">Schedule</label>
                                                    <div class="col-md-5 mce_q_year">
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mce_y_indQuarter_no" value="1" ><span>Quarter 1</span>
                                                            </label>
                                                        </div>
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mce_y_indQuarter_no" value="2" ><span>Quarter 2</span>
                                                            </label>
                                                        </div>
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mce_y_indQuarter_no" value="3" ><span>Quarter 3</span>
                                                            </label>
                                                        </div>
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mce_y_indQuarter_no" value="4" ><span>Quarter 4</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mce_3_2" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.3. Normalization / Correction of STP Attachment Plan</h6>                                            
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_45" id="mce_check_remark_45">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_45" id="mce_check_pass_45">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_45"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mce_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label text-left text-italic padding-left-15">* Notes: Please attached all types of attachment type on Normalization Attachment Plan.</label>
                                                    </div>   
                                                </div>       
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment Type</label>
                                                        <div class="col-md-9 selectContainer">
                                                            <select class="form-control" name="mce_docNormalize_type" id="mce_docNormalize_type"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">                            
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment File (PDF)</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="mce_file_docNormalize_name" name="mce_file_docNormalize_name" placeholder="Document Title">
                                                        </div>
                                                    </div>                          
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mce_file_docNormalize" name="mce_file_docNormalize" style="width: 100%">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mce_btn_add_docNormalize">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mce_docNormalize"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30%" data-hide="phone">Type</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Document Title</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="75px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="step-pane" id="mce_step4" data-step="4">
                                    <form class="form-horizontal" id="form_mce_4" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">D. Information of CEMS Personnel</h6>                                 
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_46" id="mce_check_remark_46">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_46" id="mce_check_pass_46">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_46"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mce_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Name</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mce_indPers_name" id="mce_indPers_name"/>
                                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> MyKad No.</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mce_indPers_icNo" id="mce_indPers_icNo"/>
                                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Contact No.</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mce_indPers_contactNo" id="mce_indPers_contactNo"/>
                                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Position</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="mce_indPers_position" id="mce_indPers_position"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Email</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mce_indPers_email" id="mce_indPers_email"/>
                                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
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
                                                                <input type="text" class="form-control" name="mce_indPers_qualification" id="mce_indPers_qualification"/>
                                                                <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Certification</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" name="mce_indPers_certificate" id="mce_indPers_certificate" rows="3"></textarea>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mce_btn_add_personnel">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mce_personnel"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>        
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Name</th>    
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone">MyKad No.</th>   
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Position</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Contact No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Email</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Academic Qualification</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Certification</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="35px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="step-pane" id="mce_step5" data-step="5">
                                    <form class="form-horizontal" id="form_mce_5" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">E. Declaration</h6>                                 
                                                    <div class="col-md-7 mce_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mce_form_check" placeholder="Remark" type="text" name="mce_check_remark_47" id="mce_check_remark_47">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mce_form_check" name="mce_check_pass_47" id="mce_check_pass_47">
                                                                    <label class="onoffswitch-label" for="mce_check_pass_47"> 
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
                                                        <div class="col-md-12">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input type="checkbox" class="checkbox" name="mce_declare" >
                                                                    <span style="line-height: 30px;">I, the owner / occupier / authorized consultant of the owner / occupier, hereby declare that all the information given in this application is to the best of my knowledge and belief true and correct.</span>
                                                                </label>
                                                            </div> 
                                                        </div>
                                                    </div>       
                                                    <div class="form-group padding-top-15">
                                                        <label class="col-md-2 control-label">Name</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mce_decl_profile_name" class="form-control mce_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">NRIC No</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mce_decl_profile_icNo" class="form-control mce_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Position</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mce_decl_wfGroupUser_designation" class="form-control mce_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Date</label>
                                                        <div class="col-md-3">
                                                            <input type="text" id="mce_indAll_dateDeclarations" class="form-control mce_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Remark</label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control" name="mce_snote_wfTask_remark" id="mce_snote_wfTask_remark" rows="6"></textarea>
                                                            <input type="hidden" name="mce_wfTask_remark" id="mce_wfTask_remark" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </article>
                    </div>
                </section>
            </div> 
            <div class="modal-footer">
                <form class="form-horizontal" id="form_mce" method="post">
                    <input type="hidden" name="mce_wfGroup_id" id="mce_wfGroup_id" />
                    <input type="hidden" name="mce_indAll_id" id="mce_indAll_id" />
                    <input type="hidden" name="mce_industrial_id" id="mce_industrial_id" />
                    <input type="hidden" name="mce_wfTask_id" id="mce_wfTask_id" />
                    <input type="hidden" name="mce_wfTaskType_id" id="mce_wfTaskType_id" />
                    <input type="hidden" name="mce_wfTask_status" id="mce_wfTask_status" />
                    <input type="hidden" name="mce_load_type" id="mce_load_type" />
                    <input type="hidden" name="funct" id="mce_funct" value="save_installation_cems" />
                    <div class="row">
                        <div class="col-md-12">
                            <a hreh="#" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </a>
                            <button type="button" class="btn btn-labeled btn-success mce_hideView" id="mce_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                            <button type="button" class="btn btn-labeled btn-warning mce_hideView" id="mce_btn_submit">
                                <span class="btn-label"><i class="fa fa-sign-in"></i></span>Submit
                            </button>
                        </div>
                    </div>
                </form>                    
            </div>                
        </div>
    </div>
</div>
