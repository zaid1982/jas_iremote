<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Analyzer Certificates</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-certificate fa-fw "></i> 
                Analyzer Certificates
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cac1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-tasks"></i> </span>
                        <h2>Certificate Expiry Date</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="cac_div_certBar"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cac2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>List of Analyzer Certificates &nbsp;<span class="font-xs text-danger" id="cac_table_title"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_cac" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" id="cac_dateExpiry" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th width="50px">No.</th>
                                            <th>Certificate No.</th>                                   
                                            <th width="8%">Issued By</th> 
                                            <th data-hide="phone" width="20%">Basic of Certification</th>                        
                                            <th width="12%">Analyzer Model No.</th>                                       
                                            <th data-hide="phone,tablet" width="12%">Analyzer Type</th> 
                                            <th data-hide="phone,tablet" width="74px" style="min-width: 74px">Expiry Date</th>
                                            <th width="65px" style="min-width: 65px">Status</th>
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
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cac3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-collapsed="true">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-history"></i> </span>
                        <h2>Certificate History &nbsp;<span class="font-xs text-danger" id="cac_table_title2"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_cac_history" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" id="cac_dateExpiry2" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th width="50px">No.</th>
                                            <th>Certificate No.</th>                                   
                                            <th width="10%">Issued By</th> 
                                            <th data-hide="phone" width="10%">Basic of Certification</th>                
                                            <th width="12%">Analyzer Model No.</th>                                       
                                            <th data-hide="phone,tablet" width="15%">Analyzer Type</th> 
                                            <th data-hide="phone,tablet" style="min-width: 92px">Expiry Date</th>
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
    </section>
    <input type="hidden" name="cac_wfGroup_id" id="cac_wfGroup_id" />
</div>
<?php 
include 'view/modal/modal_consultant_cems.php';
include 'view/modal/modal_consultant_pems.php';
include 'view/modal/modal_consultant_mobile.php';
include 'view/modal/modal_renew_cert.php';
?>

       