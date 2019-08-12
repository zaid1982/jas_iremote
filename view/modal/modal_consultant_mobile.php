<div class="modal fade" id="modal_consultant_mobile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">   
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-edit'></i>&nbsp; Registration of Mobile/Portable Analyzer</h4>
            </div>
            <div class="modal-body modal-fixHeight">
                <section id="widget-grid" class="">  
                    <div class="row">
                        <article class="col-sm-12 col-md-12 col-lg-12">
                            <div class="widget-body fuelux">
                                <div class="wizard" id="mam_wizard">
                                <ul class="steps">
                                    <li data-target="#mam_step1" class="active font-sm">
                                        <span class="badge badge-info">1</span><b>Section A</b> - Company Details<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mam_step2" class="font-sm">
                                        <span class="badge">2</span><b>Section B</b> - Information of Analyzer<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mam_step3" class="font-sm">
                                        <span class="badge">3</span><b>Section C</b> - Information of Personnel<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mam_step5" class="font-sm">
                                        <span class="badge">4</span><b>Section D</b> - Company Working Experience<span class="chevron"></span>
                                    </li>
                                    <li data-target="#mam_step6" class="font-sm">
                                        <span class="badge">5</span><b>Section E</b> - Declaration<span class="chevron"></span>
                                    </li>
                                </ul>
                                <div class="actions">
                                    <button type="button" class="btn btn-sm btn-primary btn-prev" id="mam_btn_prev">
                                        <i class="fa fa-arrow-left"></i>Prev
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success btn-next" id="mam_btn_next" data-last="">
                                        <span id="mam_btn_next_label">Next<i class="fa fa-arrow-right"></span></i>
                                    </button>
                                </div>
                            </div>
                            <div class="step-content padding-10 padding-bottom-0 minHeight">                                            
                                <div class="step-pane" id="mam_step1" data-step="1">
                                    <form class="form-horizontal" id="form_mam_1" method="post">                                                          
                                        <div class="alert alert-block alert-danger" id="mam_alert_box">
                                            <a class="close" data-dismiss="alert" href="#">×</a>
                                            <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> <span id="lmam_status_desc"></span> Message</h4>
                                            <p id="mam_alert_message"></p>
                                        </div>
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">A. Company Details</h6>                                            
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_24" id="mam_check_remark_24">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_24" id="mam_check_pass_24">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_24"> 
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
                                                        <input class="form-control mam_disView" name="mam_wfGroup_name" id="mam_wfGroup_name" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Registration Number</label>
                                                    <div class="col-md-8">
                                                        <input class="form-control mam_disView" name="mam_wfGroup_regNo" id="mam_wfGroup_regNo" />
                                                    </div>
                                                </div>
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Registered Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control mam_disView" name="mam_address_line1" id="mam_address_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mam_disView" name="mam_address_postcode" id="mam_address_postcode"/>
                                                        </div>
                                                    </div>                                   
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mam_disView" name="mam_state_desc" id="mam_state_desc"/>
                                                        </div>
                                                    </div>                         
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">City</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mam_disView" name="mam_city_desc" id="mam_city_desc"/>
                                                        </div>
                                                    </div>    
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Telephone Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="mam_wfGroup_phoneNo" id="mam_wfGroup_phoneNo" class="form-control mam_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Website</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="mam_wfGroup_website" id="mam_wfGroup_website" class="form-control mam_disView"/>
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
                                                            <input type="text" name="mam_consultant_dateIncorporate" id="mam_consultant_dateIncorporate" class="form-control mam_disView" >
                                                            <span class="input-group-addon hidden-sm hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="well well-light margin-bottom-15 padding-bottom-0">                                        
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Mailing Address</label>
                                                        <div class="col-md-8">
                                                            <textarea class="form-control mam_disView" name="mam_maddress_line1" id="mam_maddress_line1" rows="4"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Postcode</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mam_disView" name="mam_maddress_postcode" id="mam_maddress_postcode"/>
                                                        </div>
                                                    </div>                                 
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">State</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mam_disView" name="mam_mstate_desc" id="mam_mstate_desc"/>
                                                        </div>
                                                    </div>                            
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">City</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control mam_disView" name="mam_mcity_desc" id="mam_mcity_desc"/>
                                                        </div>
                                                    </div>   
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Fax Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="mam_wfGroup_faxNo" id="mam_wfGroup_faxNo" class="form-control mam_disView"/>
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
                                                            <input type="text" name="mam_profile_name" id="mam_profile_name" class="form-control mam_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Contact Number</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="mam_profile_mobileNo" id="mam_profile_mobileNo" class="form-control mam_disView"/>
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
                                                            <input type="text" name="mam_wfGroupUser_designation" id="mam_wfGroupUser_designation" class="form-control mam_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 control-label">Email Address</label>
                                                    <div class="col-md-8">   
                                                        <div class="input-group">
                                                            <input type="text" name="mam_profile_email" id="mam_profile_email" class="form-control mam_disView"/>
                                                            <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="step-pane" id="mam_step2" data-step="2">
                                    <form class="form-horizontal" id="form_mam_2_1" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.1. Information of Mobile/Portable Analyzer</h6>                                            
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_25" id="mam_check_remark_25">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_25" id="mam_check_pass_25">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_25"> 
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
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Reference Method</label>
                                                    <div class="col-md-9">   
                                                        <div class="radiobox">
                                                            <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mam_consMobile_refMethod" value="1" /><span>Mobile-CEMS</span> 
                                                            </label>
                                                            <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mam_consMobile_refMethod" value="2" /><span>Portable</span> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Model No.</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="mam_consMobile_modelNo" id="mam_consMobile_modelNo"/>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-md-6">                                    
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Brand</label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" name="mam_consMobile_brand" id="mam_consMobile_brand"/>
                                                    </div>
                                                </div>   
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Manufacturer</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="mam_consMobile_manufacturer" id="mam_consMobile_manufacturer"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Type of Analyzer</label>
                                                    <div class="col-md-6">   
                                                        <div class="checkbox"><label>
                                                            <input type="checkbox" class="checkbox" name="mam_consType_type[]" value="1" /><span>Gas Analyzer</span>  <!--f_mam_refresh_inputParameter(); -->
                                                        </label></div>
                                                        <div class="checkbox"><label>
                                                            <input type="checkbox" class="checkbox" name="mam_consType_type[]" value="2" /><span>Opacity Meter</span> 
                                                        </label></div>
                                                        <div class="checkbox"><label>
                                                            <input type="checkbox" class="checkbox" name="mam_consType_type[]" value="3" /><span>Particulate Monitors</span> 
                                                        </label></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">         
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Technique</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="mam_consMobile_techniqueType" id="mam_consMobile_techniqueType">
                                                            <option value=""></option>
                                                            <option value="1">Extractive Analyzer</option>
                                                            <option value="2">In-Situ Analyzer</option>
                                                        </select>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Normalization</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="mam_consMobile_isNormalize" id="mam_consMobile_isNormalize">
                                                            <option value=""></option>
                                                            <option value="1">Auto</option>
                                                            <option value="2">Manual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Type of Probe</label>
                                                    <div class="col-md-9">                                                  
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mam_consMobile_probeType" id="mam_consMobile_probeType"/>
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" name="mam_consMobile_probeEnabled" class="onoffswitch-checkbox" id="mam_consMobile_probeEnabled" value="1" onchange="f_switch('form_mam_2_1', 'mam_consMobile_probeEnabled', 'mam_consMobile_probeType', 'mam_consMobile_probeLength')">
                                                                    <label class="onoffswitch-label" for="mam_consMobile_probeEnabled"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></span> 
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
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Length of Probe</label>
                                                    <div class="col-md-6">
                                                        <div class="input-group">
                                                            <input type="text" name="mam_consMobile_probeLength" id="mam_consMobile_probeLength" class="form-control"/>
                                                            <span class="input-group-addon">m</span>       
                                                        </div>
                                                    </div>
                                                </div>   
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Correction</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="mam_consMobile_correction" id="mam_consMobile_correction">
                                                            <option value=""></option>
                                                            <option value="1">Auto</option>
                                                            <option value="2">Manual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Heated Sampling Line</label>
                                                    <div class="col-md-9 selectContainer">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="mam_consMobile_samplingLine" id="mam_consMobile_samplingLine"/>
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" name="mam_consMobile_samplingEnabled" class="onoffswitch-checkbox" id="mam_consMobile_samplingEnabled" value="1" onchange="f_switch('form_mam_2_1', 'mam_consMobile_samplingEnabled', 'mam_consMobile_samplingLine')">
                                                                    <label class="onoffswitch-label" for="mam_consMobile_samplingEnabled"> 
                                                                        <span class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></span> 
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
                                                    <label class="col-md-3 control-label">Software</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="mam_consMobile_software" id="mam_consMobile_software"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Controller</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="mam_consMobile_controller" id="mam_consMobile_controller"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>    
                                    <form class="form-horizontal" id="form_mam_2_2" method="post" enctype="multipart/form-data">
                                        <div class="form-group margin-bottom-10 mam_hideView" id="mqf_div_attach">      
                                            <label class="col-md-3 control-label"><font color="red">*</font> Manual / Catalogue</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="mam_cat_document_name" id="mam_cat_document_name" placeholder="Document Title"/>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-10 mam_hideView" id="mqf_div_attach">      
                                            <label class="col-md-3 control-label">&nbsp;</label>
                                            <div class="col-md-5 selectContainer">        
                                                <select class="form-control" name="mam_cat_documentName_id" id="mam_cat_documentName_id"></select>                                                
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="file" class="form-control" id="mam_file_catalogue" name="mam_file_catalogue" style="width: 100%">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info" type="button" id="mam_btn_upload_catalogue"><i class="fa fa-upload"></i></button>
                                                    </span>
                                                </div>
                                            </div>   
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label"> <span id="mam_lbl_catalogue">Manual / Catalogue</span></label>
                                            <div class="col-md-9">
                                                <table class="table table-bordered table-hover margin-bottom-5" id="datatable_mam_catDoc"> 
                                                    <thead>
                                                        <tr>
                                                            <th width="4%" class="text-center bg-color-teal txt-color-white">No.</th>
                                                            <th width="35%" class="text-center bg-color-teal txt-color-white">Document Type</th>
                                                            <th class="text-center bg-color-teal txt-color-white">Title</th>
                                                            <th width="60px" style="max-width: 60px" class="text-center bg-color-teal txt-color-white">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>                    
                                    </form>                                    
                                    <form class="form-horizontal" id="form_mam_2_6" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.2. Field of Specialization in Mobile/Portable Analyzer</h6>                                       
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_26" id="mam_check_remark_26">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_26" id="mam_check_pass_26">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_26"> 
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
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Source of Activity</label>
                                                    <div class="col-md-9" id="mam_div_sourceActivity"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Product Status</label>
                                                    <div class="col-md-9">   
                                                        <div class="radiobox">
                                                            <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mam_consMobile_compStatus" value="1" /><span>Manufacturer</span> 
                                                            </label>
                                                            <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mam_consMobile_compStatus" value="2" /><span>Sole Distributor</span> 
                                                            </label>
                                                            <label class="radio radio-inline">
                                                                <input type="radio" class="radiobox" name="mam_consMobile_compStatus" value="3" /><span>Sub Distributor</span> 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mam_2_7" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.3. Information of Mobile/Portable Analyzer Component</h6>                                       
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_27" id="mam_check_remark_27">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_27" id="mam_check_pass_27">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_27"> 
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
                                        <div class="row mam_div_component_situ">
                                            <div class="col-md-12" style="padding-left: 30px"><i>** Only applicable for 'Extractive Gas Analyzer' technique</i></div>
                                        </div>
                                        <div class="row mam_div_component_gas">
                                            <label class="col-md-3 control-label"><font color="red">*</font> Component Calibration</label>
                                            <div class="col-md-9">
                                                <table class="table table-bordered" id="datatable_mam_component_1" width="100%"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white">Equipment</th>      
                                                            <th class="text-center bg-color-teal txt-color-white" width="70%">Specification</th>             
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mam_div_component_gas">
                                            <label class="col-md-3 control-label"><font color="red">*</font> Component Sampling Line</label>
                                            <div class="col-md-9">
                                                <table class="table table-bordered" id="datatable_mam_component_2" width="100%"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white">Equipment</th>      
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">Model</th>             
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">Manufacturer</th>             
                                                            <th class="text-center bg-color-teal txt-color-white" width="15%">Specification</th>                   
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row mam_div_component_gas">
                                            <label class="col-md-3 control-label"><font color="red">*</font> Component Accessories</label>
                                            <div class="col-md-9">
                                                <table class="table table-bordered" id="datatable_mam_component_3" width="100%"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white">Equipment</th>      
                                                            <th class="text-center bg-color-teal txt-color-white" width="60%">Specification</th>                   
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mam_2_3" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.4. Parameters and Specified Range</h6>                                       
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_28" id="mam_check_remark_28">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_28" id="mam_check_pass_28">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_28"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mam_hideView">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Input Parameters</label>
                                                        <div class="col-md-8 selectContainer">
                                                            <select class="form-control" name="mam_inputParam_id" id="mam_inputParam_id"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Consumable Span Gas</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mam_consParam_reference" id="mam_consParam_reference"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Method</label>
                                                        <div class="col-md-8 selectContainer">
                                                            <select class="form-control" name="mam_consParam_method" id="mam_consParam_method">
                                                                <option value=""></option>
                                                                <option value="1">US-EPA Protocol 1 Method</option>
                                                                <option value="2">NIST Standards</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Data Generation</label>
                                                        <div class="col-md-8">
                                                            <div class="input-group">      
                                                                <input type="text" name="mam_consParam_dataGeneration" id="mam_consParam_dataGeneration" class="form-control"/>
                                                                <span class="input-group-addon">data/sec</span>       
                                                            </div>
                                                        </div>
                                                    </div>                                                    
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Method of Detection</label>
                                                        <div class="col-md-10 selectContainer">
                                                            <select multiple class="form-control select2" name="mam_analyzerTechnique_id[]" id="mam_analyzerTechnique_id"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Analyzer Certified</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">From</span>       
                                                                <input type="text" name="mam_consParamRange_from_0" id="mam_consParamRange_from_0" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">To</span>       
                                                                <input type="text" name="mam_consParamRange_to_0" id="mam_consParamRange_to_0" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-success" title="Add" id="mam_btn_add_range" onclick="f_mam_addRange()"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                 </div>
                                            </div>    
                                            <div class="row mam_div_paramRange" id="mam_div_paramRange_1">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">&nbsp;</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">From</span>       
                                                                <input type="text" name="mam_consParamRange_from_1" id="mam_consParamRange_from_1" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">To</span>       
                                                                <input type="text" name="mam_consParamRange_to_1" id="mam_consParamRange_to_1" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger" title="Delete" onclick="f_mam_deleteRange(1)"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mam_div_paramRange" id="mam_div_paramRange_2">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">&nbsp;</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">From</span>       
                                                                <input type="text" name="mam_consParamRange_from_2" id="mam_consParamRange_from_2" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">To</span>       
                                                                <input type="text" name="mam_consParamRange_to_2" id="mam_consParamRange_to_2" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger" title="Delete" onclick="f_mam_deleteRange(2)"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mam_div_paramRange" id="mam_div_paramRange_3">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">&nbsp;</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">From</span>       
                                                                <input type="text" name="mam_consParamRange_from_3" id="mam_consParamRange_from_3" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">To</span>       
                                                                <input type="text" name="mam_consParamRange_to_3" id="mam_consParamRange_to_3" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger" title="Delete" onclick="f_mam_deleteRange(3)"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mam_div_paramRange" id="mam_div_paramRange_4">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">&nbsp;</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">From</span>       
                                                                <input type="text" name="mam_consParamRange_from_4" id="mam_consParamRange_from_4" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">To</span>       
                                                                <input type="text" name="mam_consParamRange_to_4" id="mam_consParamRange_to_4" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger" title="Delete" onclick="f_mam_deleteRange(4)"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mam_div_paramRange" id="mam_div_paramRange_5">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">&nbsp;</label>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">From</span>       
                                                                <input type="text" name="mam_consParamRange_from_5" id="mam_consParamRange_from_5" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group">
                                                                <span class="input-group-addon bg-color-white">To</span>       
                                                                <input type="text" name="mam_consParamRange_to_5" id="mam_consParamRange_to_5" class="form-control"/>
                                                                <span class="input-group-addon mam_consParam_unit">mg/m<sup>3</sup></span>       
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger" title="Delete" onclick="f_mam_deleteRange(5)"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mam_btn_add_parameter">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mam_consParam"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>                                                            
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Input Parameter</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="14%">Analyzer Certified</th>                                 
                                                            <th class="text-center bg-color-teal txt-color-white" width="12%" data-hide="phone,tablet">Consumable Gas Span</th>                       
                                                            <th class="text-center bg-color-teal txt-color-white" width="12%" data-hide="phone,tablet">Data Generation</th>                                                                  
                                                            <th class="text-center bg-color-teal txt-color-white" width="18%" data-hide="phone,tablet">Method</th> 
                                                            <th class="text-center bg-color-teal txt-color-white" width="20%">Method of Detection</th>                                                         
                                                            <th class="text-center bg-color-teal txt-color-white" width="40px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mam_2_4" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.5. Certification</h6>                                     
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_29" id="mam_check_remark_29">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_29" id="mam_check_pass_29">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_29"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mam_hideView">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Certificate No.</label>
                                                        <div class="col-md-8">
                                                            <input type="text" class="form-control" name="mam_certificate_no" id="mam_certificate_no" />
                                                        </div>
                                                    </div>                      
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Certificate Issuer</label>
                                                        <div class="col-md-8 selectContainer">
                                                            <select class="form-control" name="mam_certIssuer_id" id="mam_certIssuer_id" onchange="f_mam_cert_usepa(this.value);"></select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Expiry Date</label>
                                                        <div class="col-md-8">
                                                            <div class="input-group">
                                                                <input type="text" name="mam_certificate_dateExpired" id="mam_certificate_dateExpired" class="form-control" readonly>
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>          
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">      
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"><font color="red">*</font> Basic of Certification</label>
                                                        <div class="col-md-8">
                                                            <div class="col-md-9" id="mam_div_certBasic_id"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">                                  
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Certificate (PDF)</label>
                                                        <div class="col-md-10">
                                                            <input type="text" class="form-control" id="mam_file_certificate_name" name="mam_file_certificate_name" placeholder="Document Title"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">&nbsp;</label>
                                                        <div class="col-md-6">
                                                            <input type="file" class="form-control" id="mam_file_certificate" name="mam_file_certificate" style="width: 100%">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mam_btn_add_certificate">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mam_cert" width="100%"> 
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center bg-color-teal txt-color-white" width="30px" data-hide="phone">No.</th>                                                            
                                                            <th class="text-center bg-color-teal txt-color-white" data-class="expand">Certificate No.</th>
                                                            <th class="text-center bg-color-teal txt-color-white">Issuer</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Basic</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone">Expiry Date</th>
                                                            <th class="text-center bg-color-teal txt-color-white" data-hide="phone,tablet">Attachment Title</th>
                                                            <th class="text-center bg-color-teal txt-color-white" width="55px">&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="form-horizontal" id="form_mam_2_5" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.6. Information of DAS Software</h6>                                 
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_62" id="mam_check_remark_62">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_62" id="mam_check_pass_62">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_62"> 
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
                                                        <input type="text" class="form-control" name="mam_das_probeSoftware" id="mam_das_probeSoftware"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>              
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Probe Software Description</label>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control" name="mam_das_probeDesc" id="mam_das_probeDesc" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>             
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Analyzer Software Version</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="mam_das_analyzerSoftware" id="mam_das_analyzerSoftware"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>              
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Analyzer Software Description</label>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control" name="mam_das_analyzerDesc" id="mam_das_analyzerDesc" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>      
                                        <input type="hidden" name="mam_das_id" id="mam_das_id" />
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">B.7. Information of DIS Software</h6>                                 
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_30" id="mam_check_remark_30">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_30" id="mam_check_pass_30">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_30"> 
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
                                                        <input type="text" class="form-control" name="mam_dis_name" id="mam_dis_name"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-6 control-label"><font color="red">*</font> Status of DIS</label>
                                                    <div class="col-md-6 selectContainer">
                                                        <select class="form-control" name="mam_dis_type" id="mam_dis_type">
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
                                                        <input type="text" class="form-control" name="mam_dis_outsource" id="mam_dis_outsource"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label"><font color="red">*</font> Description</label>
                                                    <div class="col-md-9">
                                                        <textarea type="text" class="form-control" name="mam_dis_description" id="mam_dis_description" rows="3"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="mam_dis_id" id="mam_dis_id" />
                                    </form>
                                </div>
                                <div class="step-pane" id="mam_step3" data-step="3">
                                    <form class="form-horizontal" id="form_mam_3" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">C. Information of Personnel for CEMS</h6>                                 
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_31" id="mam_check_remark_31">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_31" id="mam_check_pass_31">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_31"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mam_hideView">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Name of Certified Employee</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mam_consPers_name" id="mam_consPers_name"/>
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
                                                                    <input type="radio" class="radiobox" name="mam_personnel_citizenship" value="1" checked /><span>Malaysian</span> 
                                                                </label>
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="mam_personnel_citizenship" value="2" /><span>Others</span> 
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Employee's Status</label>
                                                        <div class="col-md-6">
                                                            <div class="radiobox">
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="mam_consPers_workingStatus" value="1" checked /><span>Staff</span> 
                                                                </label>
                                                                <label class="radio radio-inline">
                                                                    <input type="radio" class="radiobox" name="mam_consPers_workingStatus" value="2" /><span>Loan / Contracted</span> 
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
                                                                <input type="text" class="form-control" name="mam_personnel_icNo" id="mam_personnel_icNo"/>
                                                                <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label"><font color="red">*</font> Year Working Experience</label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mam_consPers_experience" id="mam_consPers_experience"/>
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
                                                                <input type="text" class="form-control" name="mam_consPers_qualification" id="mam_consPers_qualification"/>
                                                                <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Training Cert. from Manufacturer</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="mam_consPers_certificate" id="mam_consPers_certificate"/>
                                                                <span class="input-group-addon"><i class="fa fa-certificate"></i></span>       
                                                            </div>
                                                        </div>
                                                    </div>   
                                                    <div class="form-group margin-bottom-5">
                                                        <label class="col-md-3 control-label"><font color="red" id="mam_star_document_name">*</font> Support Document</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="form-control" name="mam_consPers_document_name" id="mam_consPers_document_name" placeholder="Document Title"/>
                                                        </div>
                                                    </div>    
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">&nbsp;</label>
                                                        <div class="col-md-7">
                                                            <input type="file" class="form-control" id="mam_consPers_document" name="mam_consPers_document" style="width: 100%">
                                                        </div>
                                                    </div>   
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mam_btn_add_personnel">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mam_personnel"> 
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
                                <div class="step-pane" id="mam_step5" data-step="5">
                                    <form class="form-horizontal" id="form_mam_5" method="post">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">D. Information on Company's Working Experience</h6>                                 
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_35" id="mam_check_remark_35">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_35" id="mam_check_pass_35">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_35"> 
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
                                        <div class="well margin-bottom-15 padding-bottom-0 mam_hideView">
                                            <div class="row">                                                
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Project Title</label>
                                                        <div class="col-md-9"><input type="text" class="form-control" name="mam_consProject_title" id="mam_consProject_title"/></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label"><font color="red">*</font> Year</label>
                                                        <div class="col-md-7 selectContainer">
                                                            <select class="form-control" name="mam_consProject_year" id="mam_consProject_year">
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
                                                        <div class="col-md-10"><input type="text" class="form-control" name="mam_consProject_client" id="mam_consProject_client"/></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Project Description</label>
                                                        <div class="col-md-10"><input type="text" class="form-control" name="mam_consProject_desc" id="mam_consProject_desc"/></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label"><font color="red">*</font> Scope of Work</label>
                                                        <div class="col-md-10"><input type="text" class="form-control" name="mam_consProject_scope" id="mam_consProject_scope"/></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">                                                
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label"><font color="red">*</font> Source of Activity</label>
                                                        <div class="col-md-9 selectContainer">
                                                            <select class="form-control" name="mam_consProject_source" id="mam_consProject_source"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Project Value</label>
                                                        <div class="col-md-7">   
                                                            <div class="input-group">
                                                                <span class="input-group-addon">RM</span>       
                                                                <input type="text" name="mam_consProject_value" id="mam_consProject_value" class="form-control" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">  
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="col-md-12">
                                                            <button type="button" class="btn btn-labeled btn-primary pull-right" id="mam_btn_add_project">
                                                                <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-bordered margin-bottom-5" id="datatable_mam_project"> 
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
                                <div class="step-pane" id="mam_step6" data-step="6">
                                    <form class="form-horizontal" id="form_mam_6" method="post" enctype="multipart/form-data">
                                        <div class="row padding-top-15">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <h6 class="col-md-5">E. Declaration</h6>                                 
                                                    <div class="col-md-7 mam_checkView">
                                                        <div class="input-group pull-right">
                                                            <input class="form-control mam_form_check" placeholder="Remark" type="text" name="mam_check_remark_36" id="mam_check_remark_36">
                                                            <span class="input-group-addon">
                                                                <span class="onoffswitch">
                                                                    <input type="checkbox" class="onoffswitch-checkbox mam_form_check" name="mam_check_pass_36" id="mam_check_pass_36">
                                                                    <label class="onoffswitch-label" for="mam_check_pass_36"> 
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
                                                                <input type="checkbox" class="checkbox" name="mam_declare_1" >
                                                                <span style="line-height: 22px;">I / We hereby declare that all the information furnished in this form and any annexure(s) that comes with it are true, accurate, complete and up-to-date in all respect.</span>
                                                            </label>
                                                        </div> 
                                                    </div>  
                                                    <div class="form-group">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" class="checkbox" name="mam_declare_2" >
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
                                                                    <span>- Details Information of Personnel for CEMS.</span>
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
                                                            <input type="text" id="mam_decl_profile_name" class="form-control mam_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">NRIC No</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mam_decl_profile_icNo" class="form-control mam_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Position</label>
                                                        <div class="col-md-4">
                                                            <input type="text" id="mam_decl_wfGroupUser_designation" class="form-control mam_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Date</label>
                                                        <div class="col-md-3">
                                                            <input type="text" id="mam_consAll_dateDeclaration" class="form-control mam_disView" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-2 control-label">Remark</label>
                                                        <div class="col-md-10">
                                                            <textarea class="form-control" name="mam_snote_wfTask_remark" id="mam_snote_wfTask_remark" rows="6"></textarea>
                                                            <input type="hidden" name="mam_wfTask_remark" id="mam_wfTask_remark" />
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
                <form class="form-horizontal" id="form_mam" method="post">
                    <input type="hidden" name="mam_wfGroup_id" id="mam_wfGroup_id" />
                    <input type="hidden" name="mam_consAll_id" id="mam_consAll_id" />
                    <input type="hidden" name="mam_consultant_id" id="mam_consultant_id" />
                    <input type="hidden" name="mam_wfTask_id" id="mam_wfTask_id" />
                    <input type="hidden" name="mam_wfTaskType_id" id="mam_wfTaskType_id" />
                    <input type="hidden" name="mam_wfTask_status" id="mam_wfTask_status" />
                    <input type="hidden" name="mam_load_type" id="mam_load_type" />
                    <input type="hidden" name="funct" id="mam_funct" value="save_consultant_mobile" />
                    <div class="row">
                        <div class="col-md-12">
                            <a hreh="#" class="btn btn-labeled btn-danger pull-left" data-dismiss="modal">
                                <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                            </a>
                            <button type="button" class="btn btn-labeled btn-success mam_hideView" id="mam_btn_save">
                                <span class="btn-label"><i class="fa fa-save"></i></span>Save
                            </button>
                            <button type="button" class="btn btn-labeled btn-warning mam_hideView" id="mam_btn_submit">
                                <span class="btn-label"><i class="fa fa-sign-in"></i></span>Submit
                            </button>
                        </div>
                    </div>
                </form>                    
            </div>                
        </div>
    </div>
</div>
