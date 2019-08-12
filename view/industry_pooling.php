<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Data Pooling</li><li>Data Pooling Monitoring</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-database fa-fw "></i> 
                Data Pooling
                <span>> 
                    Data Pooling Monitoring
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <div class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-ipo1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-map-o"></i> </span>
                        <h2 class="hidden-xs">Daily Data Pooling Status Monitoring</h2>
                        <div class="widget-toolbar smart-form" style="width: 150px">
                            <label class="input"> 
                                <i class="icon-append fa fa-calendar"></i>
                                <input type="text" id="ipo_dateMap" placeholder="Date" value="<?=date("Y-m-d")?>" readonly>
                                <b class="tooltip tooltip-top-right">
                                    <i class="fa fa-question-circle txt-color-teal"></i> 
                                    Data Pooling on this Date
                                </b> 
                            </label>
                        </div>
                    </header>
                    <div class="widget-body">
                        <div class="row">
                            <div class="col-md-12"><div id="map-canvas"></div></div>                                
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="ipo_div_stack_detail">
            <div class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-ipo2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-building"></i> </span>
                        <h2>Selected Stack Pooling Information</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <form class="form-horizontal" id="form_ipo_selected">
                                <div class="row margin-bottom-10">
                                    <div class="col-md-6">
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Premise Name</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_wfGroup_name"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>JAS File No.</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_industrial_jasFileNo"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Stack ID</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_indAll_stackNo"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Registration No.</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_wfTrans_regNo"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Consultant Name</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_consultant_name">csc</span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Registered Date</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_registered_date">sdvsd sdv</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Pooling Date</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_pooling_date"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Parameter Needed</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_param_needed"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Total Data Needed</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_data_needed"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Total Received</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lipo_data_received"></span>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label"><strong>Status</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <img src="img/maps/3.png" height="20" width="20" id="lipo_image_status"> <span id="lipo_data_status"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>Parameter Status</strong></label>
                                    <div class="col-md-10 margin-top-5">
                                        <div class="bordered no-padding">
                                            <table id="datatable_ipo_status" class="table table-bordered table-striped table-hover table-condensed" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th width="50px" class="text-center">No.</th>
                                                        <th width="20%" class="text-center">Parameter</th>
                                                        <th width="15%" class="text-center">Total Needed</th>
                                                        <th width="15%" class="text-center">Total Received</th>
                                                        <th width="15%" class="text-center">Status</th>
<!--                                                        <th width="10%" class="text-center">Daily Average</th>
                                                        <th width="10%" class="text-center">Limit Value</th>-->
                                                        <th class="text-center">Fail Reason</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>									
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>1-minute Compliance Data</strong></label>
                                    <div class="col-md-10 margin-top-5">
                                        <div class="bordered no-padding">
                                            <div class="table-responsive">          
                                                <table id="datatable_ipo_opacity" class="table table-bordered table-striped table-hover table-condensed" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="150px">Time</th>    
                                                            <th>Total PM</th>                                             
                                                            <th>SO<sub>2</sub></th>
                                                            <th>NO<sub>2</sub></th>                                                    
                                                            <th>HCl</th>
                                                            <th>HF</th>
                                                            <th>CO</th>
                                                            <th>NMVOC</th> 
                                                            <th>Opacity</th>   
                                                            <th>O<sub>2</sub></th>
                                                            <th>CO<sub>2</sub></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>									
                                                </table> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label"><strong>30-minute Compliance Data</strong></label>
                                    <div class="col-md-10 margin-top-5">
                                        <div class="bordered no-padding">
                                            <div class="table-responsive">          
                                                <table id="datatable_ipo_param" class="table table-bordered table-striped table-hover table-condensed" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="150px">Time</th>   
                                                            <th>Total PM</th>                                             
                                                            <th>SO<sub>2</sub></th>
                                                            <th>NO<sub>2</sub></th>                                                    
                                                            <th>HCl</th>
                                                            <th>HF</th>
                                                            <th>CO</th>
                                                            <th>NMVOC</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>									
                                                </table> 
                                            </div>        
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
