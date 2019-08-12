<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Quality Assurance</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-gavel fa-fw "></i> 
                Quality Assurance
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">        
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-iqa1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2> Ongoing Quality Assurance Process <span class="font-xs text-danger" id="iqa_table_title"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_iqa" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" id="iqa_dateExpected" class="form-control" readonly></th>
                                            <th><input type="text" id="iqa_dateActual" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th data-hide="phone" width="30px">No.</th>                                       
                                            <th>Transaction No.</th>                 
                                            <th data-hide="phone" width="10%">Stack ID</th>
                                            <th data-hide="phone" width="10%">QA Type</th>                 
                                            <th data-hide="phone,tablet">Consultant</th>
                                            <th  width="85px" style="min-width: 85px">Scheduled Date</th>
                                            <th data-hide="phone,tablet" width="85px" style="min-width: 85px">Actual Date</th>
                                            <th data-hide="phone" width="7%">Status</th>
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
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-iqa2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-collapsed="true">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-history"></i> </span>
                        <h2> Completed Quality Assurance Process &nbsp;<span class="font-xs text-danger" id="iqa2_table_title"></span></h2>     
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_iqa2" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" id="iqa2_dateExpected" class="form-control" readonly></th>
                                            <th><input type="text" id="iqa2_dateActual" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th width="30px">No.</th>                                     
                                            <th>Transaction No.</th>                 
                                            <th data-hide="phone" width="10%">Stack ID</th>
                                            <th data-hide="phone" width="10%">QA Type</th>                 
                                            <th data-hide="phone,tablet">Consultant</th>
                                            <th  width="85px" style="min-width: 85px">Scheduled Date</th>
                                            <th data-hide="phone,tablet" width="85px" style="min-width: 85px">Actual Date</th>
                                            <th data-hide="phone" width="7%">Status</th>
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
            <input type="hidden" id="iqa_wfGroup_id" />
        </div>
    </section>
</div>
<?php 
include 'view/modal/modal_cems.php';
include 'view/modal/modal_pems.php';
include 'view/modal/modal_consultant_cems.php';
include 'view/modal/modal_consultant_pems.php';
include 'view/modal/modal_consultant_mobile.php';
include 'view/modal/modal_cems_rata.php';
include 'view/modal/modal_pems_rata.php';
include 'view/modal/modal_pems_raa.php';
?>

       