<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Consultant</li><li>Consultant Information</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-user-secret fa-fw "></i> 
                Consultant
                <span>> 
                    Consultant Information
                </span>
            </h1>
        </div>
    </div>
    <div class="alert alert-block alert-danger hide" id="cin_alert">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
        <p id="cin_alert_txt"></p>
        </br>
    </div>
    <div class="alert alert-block alert-info hide" id="cin_info_register">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-info-circle fa-fw"></i> Information</h4>
        <p>
            Please choose on the menu to add <strong>CEMS Analyzer</strong>, <strong>PEMS Software</strong> or <strong>Mobile/Portable Analyzer</strong>. </br>
            Registered Analyzer / Software will be enabled for Industrial Premises to choose wheb they register <strong>CEMS / PEMS Installation Form</strong>.
        </p>
        <br>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(8,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS Analyzer </strong></a>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(19,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register PEMS Software </strong></a>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(20,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register Mobile/Portable Analyzer </strong></a>
    </div>
    <div class="row padding-gutter">        
        <div class="col-12">						
            <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cin1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                <header>
                    <span class="widget-icon"> <i class="fa fa-info"></i> </span>
                    <h2>Consultant Information</h2>
                </header>
                <div>
                    <div class="widget-body">    
                        <form class="form-horizontal" id="form_cin_form" method="post">    
                            <h6>A. Consultant Information</h6>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label">Company Name</label>
                                        <div class="col-md-10">
                                            <input class="form-control cin_disView" name="cin_wfGroup_name" id="cin_wfGroup_name" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Registration Number</label>
                                        <div class="col-md-8">
                                            <input class="form-control cin_disView" name="cin_wfGroup_regNo" id="cin_wfGroup_regNo" />
                                        </div>
                                    </div>
                                    <div class="well well-light margin-bottom-15 padding-bottom-0">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Registered Address</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="cin_address_line1" id="cin_address_line1" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control" name="cin_address_postcode" id="cin_address_postcode"/>
                                            </div>
                                        </div>                              
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control" name="cin_state_id" id="cin_state_id"></select>
                                            </div>
                                        </div>                   
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control" name="cin_city_id" id="cin_city_id"></select>
                                            </div>
                                        </div>               
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"><font color="red">*</font> Phone Number</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="cin_wfGroup_phoneNo" id="cin_wfGroup_phoneNo" class="form-control"/>
                                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Website</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="cin_wfGroup_website" id="cin_wfGroup_website" class="form-control"/>
                                                <span class="input-group-addon"><i class="fa fa-internet-explorer"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Company's Registered Date <i class="fa fa-info-circle" style="vertical-align: super; color: darkred" rel="tooltip" data-placement="top" data-original-title="Date of company registered"></i></label>
                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" name="cin_consultant_dateIncorporate" id="cin_consultant_dateIncorporate" class="form-control" readonly="">
                                                <span class="input-group-addon hidden-sm hidden-xs"><i class="fa fa-calendar"></i></span>        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="well well-light margin-bottom-15 padding-bottom-0">     
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">&nbsp;</label>
                                            <div class="col-md-8">   
                                                <label class="checkbox checkbox-inline">
                                                    <input type="checkbox" class="checkbox" name="cin_same_address" value="1" /><span>Same address</span> 
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Mailing Address</label>
                                            <div class="col-md-8">
                                                <textarea class="form-control cin_disSameAddress" name="cin_maddress_line1" id="cin_maddress_line1" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Postcode</label>
                                            <div class="col-md-8">
                                                <input type="text" class="form-control cin_disSameAddress" name="cin_maddress_postcode" id="cin_maddress_postcode"/>
                                            </div>
                                        </div>                                
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> State</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control cin_disSameAddress" name="cin_mstate_id" id="cin_mstate_id"></select>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> City</label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control cin_disSameAddress" name="cin_mcity_id" id="cin_mcity_id"></select>
                                            </div>
                                        </div>       
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Fax Number</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="cin_wfGroup_faxNo" id="cin_wfGroup_faxNo" class="form-control"/>
                                                <span class="input-group-addon"><i class="fa fa-fax "></i></span>       
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <hr>
                            <h6>B. Contact Person</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Contact Person</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="cin_profile_name" id="cin_profile_name" class="form-control cin_disView"/>
                                                <span class="input-group-addon"><i class="fa fa-user"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Contact Number</label>
                                        <div class="col-md-8">   
                                            <div class="input-group">
                                                <input type="text" name="cin_profile_mobileNo" id="cin_profile_mobileNo" class="form-control cin_disView"/>
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
                                                <input type="text" name="cin_wfGroupUser_designation" id="cin_wfGroupUser_designation" class="form-control cin_disView"/>
                                                <span class="input-group-addon"><i class="fa fa-briefcase"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Email Address</label>
                                        <div class="col-md-8">                                               
                                            <div class="input-group">
                                                <input type="text" name="cin_profile_email" id="cin_profile_email" class="form-control cin_disView"/>
                                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>       
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form class="form-horizontal" id="form_cin_doc" method="post" enctype="multipart/form-data">   
                            <hr>
                            <h6>C. Supporting Documents</h6>
                            <div class="well well-light margin-bottom-15 padding-bottom-0">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Document Type</label>
                                            <div class="col-md-8">   
                                                <select class="form-control" name="cin_documentName_id" id="cin_documentName_id"></select>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label"><font color="red">*</font> Document Title</label>
                                            <div class="col-md-8">   
                                                <input type="text" name="cin_document_name" id="cin_document_name" class="form-control"/>
                                            </div>
                                        </div>
                                    </div> 
                                </div>        
                                <div class="row">
                                     <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-2 control-label"><font color="red">*</font> Attachment File</label>
                                            <div class="col-md-10">   
                                                <input type="file" class="form-control" id="cin_file_document" name="cin_file_document" style="width: 100%">
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-md-12">   
                                                <button type="button" class="btn btn-labeled btn-primary pull-right" id="cin_btn_add_document">
                                                    <span class="btn-label"><i class="fa fa-plus"></i></span>Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                            </div>
                            <div class="row padding-bottom-10">
                                <div class="col-md-12">
                                    <table class="table table-bordered" id="datatable_cin_doc"> 
                                        <thead>
                                            <tr>
                                                <th class="text-center bg-color-teal txt-color-white" width="40px">No.</th>
                                                <th class="text-center bg-color-teal txt-color-white" width="30%">Document Type</th>
                                                <th class="text-center bg-color-teal txt-color-white">Document Title</th>
                                                <th class="text-center bg-color-teal txt-color-white" width="55px">&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>                                                
                                </div>
                            </div>
                            <div class="widget-footer">  
                                <button type="button" class="btn btn-labeled btn-success" id="cin_btn_update">
                                    <span class="btn-label"><i class="fa fa-save"></i></span>Update
                                </button>
                            </div>
                        </form>
                        <form class="form-horizontal" id="form_cin" method="post">   
                            <input type="hidden" name="cin_user_id" id="cin_user_id" />
                            <input type="hidden" name="cin_wfGroup_id" id="cin_wfGroup_id" />
                            <input type="hidden" name="cin_consultant_id" id="cin_consultant_id" />
                            <input type="hidden" name="funct" id="funct" value="update_consultant" />
                        </form>
                    </div>                        
                </div>                        
            </div>
        </div>        
    </div>
</div>-