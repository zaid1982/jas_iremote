<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Industrial</li><li>Process CEMS/PEMS Application</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-user-secret fa-fw "></i> 
                Industrial
                <span>> 
                    Process CEMS / PEMS Application
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-itp1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-sign-in"></i> </span>
                        <h2>Incoming Application &nbsp;<span class="font-xs text-danger" id="itp_table_title"></span></h2>                        
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_itp" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" id="itp_dateReceived" class="form-control" readonly></th>
                                            <th><input type="text" id="itp_dateDue" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th width="30px">No.</th>
                                            <th data-class="expand">Application No.</th> 
                                            <th data-hide="phone" width="12%">Application Type</th>        
                                            <th data-hide="phone">Industrial Name</th>                                            
                                            <th width="10%">JAS File No.</th>                    
                                            <th data-hide="phone,tablet" width="12%">Premise ID</th>                
                                            <th data-hide="phone,tablet" style="min-width: 92px">Received Time</th>
                                            <th data-hide="phone,tablet" style="min-width: 92px">Due Date</th>
                                            <th width="65px" style="min-width: 60px">Status</th>
                                            <th width="55px" style="min-width: 55px">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>									
                                </table>   
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-itp2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-collapsed="true">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-history"></i> </span>
                        <h2>Submission History &nbsp;<span class="font-xs text-danger" id="itp2_table_title"></span></h2>     
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_itp2" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" id="itp2_dateSubmit" class="form-control" readonly></th>
                                            <th><input type="text" id="itp2_dateDue" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th width="30px">No.</th>
                                            <th data-class="expand">Application No.</th> 
                                            <th data-hide="phone" width="10%">Application Type</th>             
                                            <th data-hide="phone">Industrial Name</th>                                            
                                            <th width="10%">JAS File No.</th>                    
                                            <th data-hide="phone,tablet" width="10%">Premise ID</th>               
                                            <th data-hide="phone,tablet" style="min-width: 92px">Submission Time</th>
                                            <th data-hide="phone,tablet" style="min-width: 92px">Due Date</th>
                                            <th width="65px" style="min-width: 60px">Action</th>
                                            <th width="55px" style="min-width: 55px">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>									
                                </table>    
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
<?php 
include 'view/modal/modal_cems.php';
include 'view/modal/modal_pems.php';
include 'view/modal/modal_consultant_cems.php';
include 'view/modal/modal_consultant_pems.php';
include 'view/modal/modal_consultant_mobile.php';
include 'view/modal/modal_action.php';
?>