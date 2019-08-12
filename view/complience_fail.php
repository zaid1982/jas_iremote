<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Data Compliance</li><li>Fail Compliance</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-warning fa-fw "></i> 
                Data Compliance
                <span>> 
                    Fail Compliance
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cpf1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Open Fail Compliance Cases <span class="font-xs text-danger" id="cpf_table_title"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_cpf" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="100" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" id="cpf_datePooling" class="form-control" readonly></th>
                                            <th><input type="text" id="cpf_dateReceived" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th data-hide="phone" width="30px">No.</th>
                                            <th data-class="expand">Case No.</th>                      
                                            <th data-hide="phone">Premise</th>                                                  
                                            <th data-hide="phone,tablet" width="15%">Registration No.</th>
                                            <th data-hide="phone" width="6%">Stack ID</th>
                                            <th data-hide="phone" width="6%">Input Parameter</th>
                                            <th width="80px" style="min-width: 80px">Pooling Time</th>
                                            <th data-hide="phone,tablet" width="80px" style="min-width: 80px">Created Time</th>
                                            <th data-hide="phone,tablet" width="7%">State</th>
                                            <th data-hide="phone" width="10%">Failure Type</th>
                                            <th data-hide="phone" width="6%">Status</th>
                                            <th width="52px" style="min-width: 52px">&nbsp;</th>
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
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cpf2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-collapsed="true">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Closed Fail Compliance Cases <span class="font-xs text-danger" id="cpf_table_title2"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_cpf2" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="100" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" id="cpf_datePooling2" class="form-control" readonly></th>
                                            <th><input type="text" id="cpf_dateClose" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th data-hide="phone" width="30px">No.</th>
                                            <th data-class="expand">Case No.</th>                                 
                                            <th data-hide="phone">Premise</th>                                   
                                            <th data-hide="phone,tablet" width="15%">Registration No.</th>
                                            <th data-hide="phone" width="8%">Stack ID</th>
                                            <th data-hide="phone" width="8%">Input Parameter</th>
                                            <th width="80px" style="min-width: 80px">Pooling Time</th>
                                            <th data-hide="phone,tablet" width="80px" style="min-width: 80px">Closed Time</th>
                                            <th data-hide="phone,tablet" width="7%">State</th>
                                            <th data-hide="phone" width="10%">Failure Type</th>
                                            <th width="52px" style="min-width: 52px">&nbsp;</th>
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
include 'view/modal/modal_response.php';
include 'view/modal/modal_cems.php';
include 'view/modal/modal_pems.php';
?>

       