<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Industrial</li><li>Industrial Information</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-building fa-fw "></i> 
                Industrial
                <span>> 
                    Industrial Information
                </span>
            </h1>
        </div>
    </div>
    <div class="alert alert-block alert-danger hide" id="iin_alert">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
        <p id="iin_alert_txt"></p>
        </br>
    </div>
    <div class="alert alert-block alert-info hide" id="iin_info_register">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-info-circle fa-fw"></i> Information</h4>
        <p>
            Please choose on the menu to register <strong>CEMS Installation</strong> or <strong>PEMS Installation</strong>. 
        </p>
        <br>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(12,21,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS Installation </strong></a>
        <a href="#" class="btn btn-warning" onclick="f_menu_redirect(12,22,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register PEMS Installation </strong></a>
    </div>
    <div class="row padding-gutter">
        <form class="form-horizontal" id="form_iin" method="post">
            <div class="col-12">              
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-iin1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">      
                    <header>
                        <span class="widget-icon"> <i class="fa fa-info-circle"></i> </span>
                        <h2>Industrial Information</h2>
                    </header>
                    <div>
                        <div class="widget-body">      
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Industrial Name</label>
                                        <div class="col-md-10">
                                            <div class="input-group">
                                                <input type="text" name="iin_wfGroup_name" id="iin_wfGroup_name" class="form-control iin_disView"/>
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
                                            <input type="text" name="iin_industrial_jasFileNo" id="iin_industrial_jasFileNo" class="form-control iin_disView" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Plant Sector</label>
                                        <div class="col-md-8 selectContainer">
                                            <select class="form-control" name="iin_sic_id" id="iin_sic_id"></select>
                                        </div>
                                    </div> 
                                    <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Plant Address</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control iin_disView" name="iin_address_line1" id="iin_address_line1" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control iin_disView" name="iin_address_postcode" id="iin_address_postcode"/>
                                            </div>
                                        </div>                                  
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control iin_disView" name="iin_state_id" id="iin_state_id"></select>
                                            </div>
                                        </div>                        
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control iin_disView" name="iin_city_id" id="iin_city_id"></select>
                                            </div>
                                        </div>      
                                    </div>     
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Parliament</label>
                                        <div class="col-md-8 selectContainer">
                                            <select class="form-control" name="iin_parlimen_id" id="iin_parlimen_id"></select>
                                        </div>
                                    </div>   
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Plant Longitude</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" name="iin_location_longitude" id="iin_location_longitude" class="form-control iin_disView"/>
                                                <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Plant Latitude</label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" name="iin_location_latitude" id="iin_location_latitude" class="form-control iin_disView"/>
                                                <span class="input-group-addon">&nbsp;&deg;&nbsp;</span>         
                                            </div>
                                        </div>
                                    </div>        
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><font color="red">*</font> Total Stacks</label>
                                        <div class="col-md-8">
                                            <input class="form-control" name="iin_industrial_totalStack" id="iin_industrial_totalStack" />
                                        </div>
                                    </div>                     
                                </div>
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">JAS Premise ID</label>
                                        <div class="col-md-8">
                                            <input type="text" name="iin_industrial_premiseId" id="iin_industrial_premiseId" class="form-control iin_disView" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Plant Sub Sector</label>
                                        <div class="col-md-8 selectContainer">
                                            <select class="form-control" name="iin_subSic_id" id="iin_subSic_id"></select>
                                        </div>
                                    </div>    
                                    <div class="well well-light margin-bottom-15 padding-bottom-0">   
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">&nbsp;</label>
                                            <div class="col-md-8">   
                                                <label class="checkbox checkbox-inline">
                                                    <input type="checkbox" class="checkbox" name="iin_same_address" value="1" /><span>Same address</span> 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Mailing Address</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control iin_disSameAddress" name="iin_maddress_line1" id="iin_maddress_line1" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control iin_disSameAddress" name="iin_maddress_postcode" id="iin_maddress_postcode"/>
                                            </div>
                                        </div>                                  
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control iin_disSameAddress" name="iin_mstate_id" id="iin_mstate_id"></select>
                                            </div>
                                        </div>                 
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control iin_disSameAddress" name="iin_mcity_id" id="iin_mcity_id"></select>
                                            </div>
                                        </div>             
                                    </div>   
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><font color="red">*</font> Phone Number</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="iin_wfGroup_phoneNo" id="iin_wfGroup_phoneNo" class="form-control"/>
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>         
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Fax Number</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="iin_wfGroup_faxNo" id="iin_wfGroup_faxNo" class="form-control"/>
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
                                                <input type="text" name="iin_profile_name" id="iin_profile_name" class="form-control iin_disView"/>
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Contact Number</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="iin_profile_mobileNo" id="iin_profile_mobileNo" class="form-control iin_disView"/>
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
                                                <input type="text" name="iin_wfGroupUser_designation" id="iin_wfGroupUser_designation" class="form-control iin_disView"/>
                                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Email Address</label>
                                        <div class="col-md-8">                                               
                                            <div class="input-group">
                                                <input type="text" name="iin_profile_email" id="iin_profile_email" class="form-control iin_disView"/>
                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-footer">  
                                <button type="button" class="btn btn-labeled btn-success" id="iin_btn_update" >
                                    <span class="btn-label"><i class="fa fa-save"></i></span>Update
                                </button>
                            </div>
                            <input type="hidden" name="iin_user_id" id="iin_user_id" />
                            <input type="hidden" name="iin_wfGroup_id" id="iin_wfGroup_id" />
                            <input type="hidden" name="iin_industrial_id" id="iin_industrial_id" />
                            <input type="hidden" name="funct" id="funct" value="update_industrial" />
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
