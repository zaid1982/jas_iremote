<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Installed CEMS / PEMS</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-dashboard fa-fw "></i> 
                Installed CEMS / PEMS at Industrial Premise
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-ccp1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>List of Installed CEMS / PEMS at Industrial Premise &nbsp;<span class="font-xs text-danger" id="ccp_table_title"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_ccp" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="100" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>                                            
                                            <th><input type="text" class="form-control" maxlength="30" /></th>                                           
                                            <th><input type="text" id="ccp_dateRegistered" class="form-control" readonly /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>No.</th>            
                                            <th data-class="expand">Installation No</th>     
                                            <th data-hide="phone">Industrial Name</th>             
                                            <th width="7%">Stack ID</th>                                                              
                                            <th data-hide="phone" width="5%">Type</th> 
                                            <th data-hide="phone,tablet" width="6%">Consultant Type</th> 
                                            <th data-hide="phone,tablet" width="10%">Application No.</th>
                                            <th data-hide="phone,tablet" width="10%">Model No.</th>
                                            <th data-hide="phone,tablet" width="10%">City</th>
                                            <th data-hide="phone,tablet" width="10%">State</th>
                                            <th data-hide="phone,tablet" width="10%">Registered Time</th>
                                            <th width="60px">Status</th>
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
?>

       