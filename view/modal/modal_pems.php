<div class="modal fade" id="modal_pems" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">   
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-edit'></i>&nbsp; <span id='lmpe_title'></span> Application of PEMS Installation</h4>
            </div>
            <div class="modal-body modal-fixHeight">
                <section id="widget-grid" class="">
                    <div class="row">
                        <article class="col-sm-12 col-md-12 col-lg-12">
                            <div class="widget-body fuelux">
                                <div class="wizard" id="mpe_wizard">
                                <ul class="steps">
                                    <li data-target="#mpe_step1" class="active font-sm">
                                        <span class="badge badge-info">1</span><b>Section A</b> - Industrial Details<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mpe_step2" class="font-sm">
                                        <span class="badge">2</span><b>Section B</b> - Source of Emission<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mpe_step3" class="font-sm">
                                        <span class="badge">3</span><b>Section C</b> - PEMS Software<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mpe_step4" class="font-sm">
                                        <span class="badge">4</span><b>Section D</b> - PEMS Personel<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mpe_step5" class="font-sm">
                                        <span class="badge">5</span><b>Section E</b> - Declaration<span class="chevron"></span>
                                    </li>
                                </ul>
                                <div class="actions">
                                    <button type="button" class="btn btn-sm btn-primary btn-prev" id="mpe_btn_prev">
                                        <i class="fa fa-arrow-left"></i>Prev
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success btn-next" id="mpe_btn_next" data-last="Finish">
                                        <span id="mpe_btn_next_label">Next<i class="fa fa-arrow-right"></span></i>
                                    </button>
                                </div>
                            </div>
                            <div class="step-content padding-10 padding-bottom-0 minHeight">                                            
                                <div class="step-pane" id="mpe_step1" data-step="1">
                                    <form class="form-horizontal" id="form_mpe_1" method="post">                                                          
                                        <div class="alert alert-block alert-danger" id="mpe_alert_box">
                                            <a class="close" data-dismiss="alert" href="#">×</a>
                                            <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> <span id="lmpe_status_desc"></span> Message</h4>
                                            <p id="mpe_alert_message"></p>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">A. Industrial Details</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_48" id="mpe_check_remark_48">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_48" id="mpe_check_pass_48">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_48"> 
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
                                                            <input type="text" class="form-control mpe_disView" name="mpe_wfGroup_name" id="mpe_wfGroup_name"/>
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
                                                        <input type="text" class="form-control mpe_disView" name="mpe_industrial_jasFileNo" id="mpe_industrial_jasFileNo" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Sector</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mpe_disView" name="mpe_sic_desc" id="mpe_sic_desc" />
                                                    </div>
                                                </div> 
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Plant Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control mpe_disView" name="mpe_address_line1" id="mpe_address_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_address_postcode" id="mpe_address_postcode"/>
                                                        </div>
                                                    </div>                        
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                                        <div class="col-md-8">
                                                            <input type="text"  class="form-control mpe_disView" name="mpe_city_desc" id="mpe_city_desc"/>
                                                        </div>
                                                    </div>                                  
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_state_desc" id="mpe_state_desc"/>
                                                        </div>
                                                    </div>      
                                                </div>     
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Parliament</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_parlimen_desc" id="mpe_parlimen_desc"/>
                                                            <span class="input-group-addon"><i class="fa fa-building"></i></span>         
                                                        </div>
                                                    </div>
                                                </div>   
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Longitude</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_location_longitude" id="mpe_location_longitude"/>
                                                            <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Latitude</label>
                                                    <div class="col-md-8">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_location_latitude" id="mpe_location_latitude"/>
                                                            <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                                        </div>
                                                    </div>
                                                </div>     
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><font color="red">*</font> Total Stacks</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mpe_disView" name="mpe_industrial_totalStack" id="mpe_industrial_totalStack" />
                                                    </div>
                                                </div>                        
                                            </div>
                                            <div class="col-md-6"> 
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">JAS Premise ID</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mpe_disView" name="mpe_industrial_premiseId" id="mpe_industrial_premiseId" />
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Plant Sub Sector</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control mpe_disView" name="mpe_subSic_desc" id="mpe_subSic_desc" />
                                                    </div>
                                                </div>    
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Mailing Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control mpe_disView" name="mpe_maddress_line1" id="mpe_maddress_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_maddress_postcode" id="mpe_maddress_postcode"/>
                                                        </div>
                                                    </div>                        
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                                        <div class="col-md-8">
                                                            <input type="text"  class="form-control mpe_disView" name="mpe_mcity_desc" id="mpe_mcity_desc"/>
                                                        </div>
                                                    </div>                                  
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_mstate_desc" id="mpe_mstate_desc"/>
                                                        </div>
                                                    </div>      
                                                </div>   
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label"><font color="red">*</font> Phone Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_wfGroup_phoneNo" id="mpe_wfGroup_phoneNo"/>
                                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>         
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Fax Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_wfGroup_faxNo" id="mpe_wfGroup_faxNo"/>
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
                                                            <input type="text" class="form-control mpe_disView" name="mpe_profile_name" id="mpe_profile_name"/>
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Contact Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_profile_mobileNo" id="mpe_profile_mobileNo"/>
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
                                                            <input type="text" class="form-control mpe_disView" name="mpe_wfGroupUser_designation" id="mpe_wfGroupUser_designation"/>
                                                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Email Address</label>
                                                    <div class="col-md-8">                                               
                                                        <div class="input-group">
                                                            <input type="text" class="form-control mpe_disView" name="mpe_profile_email" id="mpe_profile_email"/>
                                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>                                    
                                </div>                                  
                                <div class="step-pane" id="mpe_step2" data-step="2">
                                    <form class="form-horizontal" id="form_mpe_2_1" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.1. Source of Emission</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_49" id="mpe_check_remark_49">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_49" id="mpe_check_pass_49">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_49"> 
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
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Reasons of PEMS Installation</label>
                                                    <div class="col-md-9">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_indReason_id[]" value="1">
                                                                <span>EIA Condition Requirement</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_indReason_id[]" value="2">
                                                                <span>CAR, 2014</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_indReason_id[]" value="3">
                                                                <span>License under Prescribe Premises</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_indReason_id[]" value="4">
                                                                <span>Other (please specify)</span> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>                                            
                                                <div class="form-group padding-top-0">
                                                    <label class="col-md-3 control-label text-align-left"></label>
                                                    <div class="col-md-5" style="padding-left: 33px">                                                    
                                                        <input type="text" name="mpe_indReason_other" id="mpe_indReason_other" class="form-control mpe_disReason" placeholder="Other Reason"/>                                               
                                                    </div>
                                                </div>                                                
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Source of Activity</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="mpe_sourceActivity_id" id="mpe_sourceActivity_id"></select>
                                                    </div>
                                                </div>                                             
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Source</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="mpe_sourceCapacity_id" id="mpe_sourceCapacity_id"></select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Type of Fuel</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="mpe_fuelType_id" id="mpe_fuelType_id">
                                                            <option value=""></option>
                                                            <option value="1">Solid & Liquid Fuels</option>
                                                            <option value="2">Gaseous Fuels</option>
                                                            <option value="3">Liquid Fuels</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Fuel Quantity</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_fuelQuantity" id="mpe_indAll_fuelQuantity"/>
                                                            <span class="input-group-addon">kg/h</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Type of Metal</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control mpe_disView" name="mpe_metalType_id" id="mpe_metalType_id">
                                                            <option value=""></option>
                                                            <option value="1">Cadmium</option>
                                                            <option value="2">Lead (PB)</option>
                                                            <option value="3">Other Metal</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Source Capacity</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_sourceCapacity" id="mpe_indAll_sourceCapacity"/>
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
                                                            <input type="checkbox" class="checkbox" name="mpe_pollutionMonitored_id[]" value="1" /><span>Gases</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="mpe_pollutionMonitored_id[]" value="2" /><span>Opacity</span> 
                                                        </label>
                                                        <label class="checkbox checkbox-inline">
                                                            <input type="checkbox" class="checkbox" name="mpe_pollutionMonitored_id[]" value="3" /><span>Particulates / Dust</span> 
                                                        </label>
                                                    </div>
                                                </div>      
                                                <div class="row padding-top-5">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Parameters to be Monitored</label>
                                                    <div class="col-md-9">
                                                        <table class="table table-bordered" id="datatable_mpe_parameter"> 
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
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_50" id="mpe_check_remark_50">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_50" id="mpe_check_pass_50">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_50"> 
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
                                                        <input type="text" class="form-control" name="mpe_indAll_stackNo" id="mpe_indAll_stackNo"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Height</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_stackHeight" id="mpe_indAll_stackHeight"/>
                                                            <span class="input-group-addon">m</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Diameter</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_stackDiameter" id="mpe_indAll_stackDiameter"/>
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
                                                            <input type="text" class="form-control" name="mpe_indAll_stackLongitude" id="mpe_indAll_stackLongitude" step="any" min="-180" max="180" maxlength="10"/>
                                                            <span class="input-group-addon"><sup>o</sup></span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Latitude</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_stackLatitude" id="mpe_indAll_stackLatitude" step="any" min="-180" max="180" maxlength="10"/>
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
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_51" id="mpe_check_remark_51">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_51" id="mpe_check_pass_51">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_51"> 
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
                                                            <input type="text" class="form-control" name="mpe_indAll_gasTemperature" id="mpe_indAll_gasTemperature"/>
                                                            <span class="input-group-addon"><sup>o</sup>C</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Air Flow Rate</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_airFlowRate" id="mpe_indAll_airFlowRate"/>
                                                            <span class="input-group-addon">m<sup>3</sup>/h</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Stack Velocity</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_stackVelocity" id="mpe_indAll_stackVelocity"/>
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
                                                            <input type="text" class="form-control" name="mpe_indAll_moistureContect" id="mpe_indAll_moistureContect"/>
                                                            <span class="input-group-addon">%</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Pressure</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mpe_indAll_pressure" id="mpe_indAll_pressure"/>
                                                            <span class="input-group-addon">kPA</span>    
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mpe_2_2" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.4. Written Approval or Notification Status of Specified Equipment</h6>                                                                                 
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_52" id="mpe_check_remark_52">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_52" id="mpe_check_pass_52">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_52"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mpe_hideView">
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
                                                                <input type="radio" class="radiobox" name="mpe_written_type" value="13">
                                                                <span>Fuel Burning Equipment</span>
                                                            </label>
                                                             <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mpe_written_type" value="14">
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
                                                            <input type="text" class="form-control" name="mpe_indWritten_equipmentName" id="mpe_indWritten_equipmentName" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Reference No.</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="mpe_indWritten_referenceNo" id="mpe_indWritten_referenceNo" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                                    
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Reference Date</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" name="mpe_indWritten_dateReference" id="mpe_indWritten_dateReference" class="form-control" >
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
                                                            <input type="text" class="form-control" id="mpe_file_written_name" name="mpe_file_written_name" placeholder="Document Title">
                                                        </div>
                                                    </div>                      
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mpe_file_written" name="mpe_file_written" style="width: 100%">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mpe_btn_add_written">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mpe_written"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Equipment Name</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="19%">Type</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">Reference No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet" width="14%">Date</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30%" data-hide="phone,tablet">Document Title</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="55px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mpe_2_3" method="post" enctype="multipart/form-data">     
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.5. Industrial Process Description <small>(Related to the Specified Chimney for this purpose of PEMS Installation)</small></h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_53" id="mpe_check_remark_53">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_53" id="mpe_check_pass_53">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_53"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mpe_hideView">
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
                                                            <select class="form-control" name="mpe_document_type" id="mpe_document_type"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="mpe_div_doc_other">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Other Type</label>
                                                        <div class="col-md-9">
                                                            <input type="text" name="mpe_indDoc_others" id="mpe_indDoc_others" class="form-control" >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">                                    
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment File (PDF)</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="mpe_file_document_name" name="mpe_file_document_name" placeholder="Document Title">
                                                        </div>
                                                    </div>                      
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mpe_file_document" name="mpe_file_document" style="width: 100%">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mpe_btn_add_document">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mpe_document"> 
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
                                                <i>* Notes: Please attached all types of documents related to the specified chimney.</i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="step-pane" id="mpe_step3" data-step="3">
                                    <form class="form-horizontal" id="form_mpe_3_1" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.1. Information of PEMS Software</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_54" id="mpe_check_remark_54">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_54" id="mpe_check_pass_54">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_54"> 
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
                                                    <label class="col-md-3 control-label"><font color="red">*</font> PEMS Consultant</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <select class="form-control" name="mpe_consultant_id" id="mpe_consultant_id"></select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Modeling Software</label>
                                                    <div class="col-md-5 selectContainer">
                                                        <select class="form-control" name="mpe_consAll_id" id="mpe_consAll_id"></select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Analyzer Registration No.</label>
                                                    <div class="col-md-9 control-label text-left" id="mpe_divAnalyzerDetails"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Predictive Method</label>
                                                    <div class="col-md-9 control-label text-left" id="mpe_divSoftwareMethod"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mpe_3_3" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.2. PEMS Input Parameter</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_55" id="mpe_check_remark_55">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_55" id="mpe_check_pass_55">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_55"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mpe_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
<!--                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Input</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="mpe_pemsInput_name" id="mpe_pemsInput_name" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Description</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="mpe_pemsInput_desc" id="mpe_pemsInput_desc" />
                                                        </div>
                                                    </div>-->
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Description</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" name="mpe_pemsReading_desc" id="mpe_pemsReading_desc" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> ID</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mpe_pemsReading_idd" id="mpe_pemsReading_idd" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Min</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mpe_pemsReading_min" id="mpe_pemsReading_min" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Unit</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mpe_pemsReading_unit" id="mpe_pemsReading_unit" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Max</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mpe_pemsReading_max" id="mpe_pemsReading_max" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mpe_btn_add_inputReading">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </form>
                                    <form class="form-horizontal" id="form_mpe_3_4" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mpe_inputReading" width="100%"> 
                                                    <thead>       
                                                        <tr>
                                                            <th width="4%" class="text-center bg-color-teal txt-color-white">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white">Description</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">ID</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">Weight</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Min</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="10%">Max</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="26px">&nbsp;</th>
                                                        </tr>
<!--                                                        <tr>
                                                            <th width="4%" class="text-center bg-color-teal txt-color-white" rowspan="2">No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2">Input</th>
                                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2">Description</th>
                                                            <th class="text-center bg-color-teal txt-color-white" colspan="3">Low</th>
                                                            <th class="text-center bg-color-teal txt-color-white" colspan="3">Normal</th>
                                                            <th class="text-center bg-color-teal txt-color-white" colspan="3">High</th>
                                                            <th class="text-center bg-color-teal txt-color-white" rowspan="2" width="35px"></th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="48px">Min</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="48px">Max</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="60px">Weight</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="48px">Min</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="48px">Max</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="60px">Weight</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="48px">Min</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="48px">Max</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="60px">Weight</th>
                                                        </tr>-->
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                                <!--<i>* Notes: Industrial need to insert 3 loaded reading on all the input parameters.</i>-->
                                            </div>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.3. Quality Assurance Plan</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_56" id="mpe_check_remark_56">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_56" id="mpe_check_pass_56">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_56"> 
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
                                                    <label class="col-md-3 control-label">Sensor Evaluation Check (daily)</label>
                                                    <div class="col-md-1">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox style-3" name="mpe_indAll_qaFreqDaily" value="1" ><span>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label class="col-md-1 control-label mpe_q_daily">Method</label>
                                                    <div class="col-md-5 mpe_q_daily">
                                                        <label class="radio radio-inline">
                                                            <input type="radio" class="radiobox" name="mpe_indAll_qaMethod" value="1" /><span>Automatic</span> 
                                                        </label>
                                                        <label class="radio radio-inline">
                                                            <input type="radio" class="radiobox" name="mpe_indAll_qaMethod" value="2" /><span>Manual</span> 
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">RAA (quarterly)</label>
                                                    <div class="col-md-1">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox style-3" name="mpe_indAll_qaFreqQuarterly" value="1" ><span>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                    <label class="col-md-1 control-label mpe_q_quarter">Schedule</label>
                                                    <div class="col-md-5 mpe_q_quarter">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_q_indQuarter_no[]" value="1" ><span>Quarter 1</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_q_indQuarter_no[]" value="2" ><span>Quarter 2</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_q_indQuarter_no[]" value="3" ><span>Quarter 3</span>
                                                            </label>
                                                        </div>
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mpe_q_indQuarter_no[]" value="4" ><span>Quarter 4</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">RATA (yearly)</label>
                                                    <div class="col-md-1">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox style-3" name="mpe_indAll_qaFreqYearly" value="1" ><span>Yes</span>
                                                            </label>
                                                        </div>
                                                    </div>                                                    
                                                    <label class="col-md-1 control-label mpe_q_year">Schedule</label>
                                                    <div class="col-md-5 mpe_q_year">
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mpe_y_indQuarter_no" value="1" ><span>Quarter 1</span>
                                                            </label>
                                                        </div>
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mpe_y_indQuarter_no" value="2" ><span>Quarter 2</span>
                                                            </label>
                                                        </div>
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mpe_y_indQuarter_no" value="3" ><span>Quarter 3</span>
                                                            </label>
                                                        </div>
                                                        <div class="radiobox">
                                                            <label>
                                                                <input type="radio" class="radiobox" name="mpe_y_indQuarter_no" value="4" ><span>Quarter 4</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mpe_3_2" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C.4. Normalization / Correction of STP Attachment Plan</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_57" id="mpe_check_remark_57">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_57" id="mpe_check_pass_57">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_57"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mpe_hideView">
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
                                                            <select class="form-control" name="mpe_docNormalize_type" id="mpe_docNormalize_type"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">                             
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Attachment File (PDF)</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" id="mpe_file_docNormalize_name" name="mpe_file_docNormalize_name" placeholder="Document Title">
                                                        </div>
                                                    </div>                          
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mpe_file_docNormalize" name="mpe_file_docNormalize" style="width: 100%">
                                                        </div>
                                                    </div> 
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mpe_btn_add_docNormalize">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mpe_docNormalize"> 
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
                                <div class="step-pane" id="mpe_step4" data-step="4">
                                    <form class="form-horizontal" id="form_mpe_4" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">D. Information of PEMS Personnel</h6>                                            
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_58" id="mpe_check_remark_58">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_58" id="mpe_check_pass_58">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_58"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mpe_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Name</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mpe_indPers_name" id="mpe_indPers_name"/>
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
                                                                <input type="text" class="form-control" name="mpe_indPers_icNo" id="mpe_indPers_icNo"/>
                                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Contact No.</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mpe_indPers_contactNo" id="mpe_indPers_contactNo"/>
                                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Position</label>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" name="mpe_indPers_position" id="mpe_indPers_position"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Email</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mpe_indPers_email" id="mpe_indPers_email"/>
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
                                                                <input type="text" class="form-control" name="mpe_indPers_qualification" id="mpe_indPers_qualification"/>
                                                                <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Certification</label>
                                                        <div class="col-md-9">
                                                            <textarea class="form-control" name="mpe_indPers_certificate" id="mpe_indPers_certificate" rows="3"></textarea>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mpe_btn_add_personnel">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mpe_personnel"> 
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
                                <div class="step-pane" id="mpe_step5" data-step="5">
                                    <form class="form-horizontal" id="form_mpe_5" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">E. Declaration</h6>                                 
                                                    <div class="col-md-7 mpe_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mpe_form_check" placeholder="Remark" type="text" name="mpe_check_remark_59" id="mpe_check_remark_59">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mpe_form_check" name="mpe_check_pass_59" id="mpe_check_pass_59">
                                                                    <label class="onoffswitch-label" for="mpe_check_pass_59"> 
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
                                                                    <input type="checkbox" class="checkbox" name="mpe_declare" >
                                                                    <span style="line-height: 30px;">I, the owner / occupier / authorized consultant of the owner / occupier, hereby declare that all the information given in this application is to the best of my knowledge and belief true and correct.</span>
                                                                </label>
                                                            </div> 
                                                        </div>
                                                    </div>       
                                                    <div class="form-group padding-top-15">
                                                        <label class="col-md-2 control-label">Name</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mpe_decl_profile_name" class="form-control mpe_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">NRIC No</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mpe_decl_profile_icNo" class="form-control mpe_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Position</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mpe_decl_wfGroupUser_designation" class="form-control mpe_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Date</label>
                                                        <div class="col-md-3">
                                                            <input type="text" id="mpe_indAll_dateDeclarations" class="form-control mpe_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Remark</label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control" name="mpe_snote_wfTask_remark" id="mpe_snote_wfTask_remark" rows="6"></textarea>
                                                            <input type="hidden" name="mpe_wfTask_remark" id="mpe_wfTask_remark" />
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
                <form class="form-horizontal" id="form_mpe" method="post">
                    <input type="hidden" name="mpe_wfGroup_id" id="mpe_wfGroup_id" />
                    <input type="hidden" name="mpe_indAll_id" id="mpe_indAll_id" />
                    <input type="hidden" name="mpe_industrial_id" id="mpe_industrial_id" />
                    <input type="hidden" name="mpe_wfTrans_id" id="mpe_wfTrans_id" />
                    <input type="hidden" name="mpe_wfTask_id" id="mpe_wfTask_id" />
                    <input type="hidden" name="mpe_wfTaskType_id" id="mpe_wfTaskType_id" />
                    <input type="hidden" name="mpe_wfTask_status" id="mpe_wfTask_status" />
                    <input type="hidden" name="mpe_load_type" id="mpe_load_type" />
                    <input type="hidden" name="funct" id="mpe_funct" value="save_installation_pems" />
                    <div class="row">
                        <div class="col-md-12">
                            <a hreh="#" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </a>
                            <button type="button" class="btn btn-labeled btn-success mpe_hideView" id="mpe_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                            <button type="button" class="btn btn-labeled btn-warning mpe_hideView" id="mpe_btn_submit">
                                <span class="btn-label"><i class="fa fa-sign-in"></i></span>Submit
                            </button>
                        </div>
                    </div>
                </form>                    
            </div>                
        </div>
    </div>
</div>
