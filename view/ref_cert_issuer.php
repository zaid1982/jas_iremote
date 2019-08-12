<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>System Management</li><li>Reference Date</li><li>Analyzer Certificate Issuer</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-tags fa-fw "></i> 
                System Management
                <span>> 
                    Reference Data
                </span>
                <span style="font-size: 15px">> 
                    Analyzer Certificate Issuer
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">        
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cei1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Analyzer Certificate Issuer List &nbsp;<span class="font-xs text-danger" id="cei_table_title"></span></h2>
                        <div class="widget-toolbar">
                            <a href="javascript:void(0);" class="btn btn-primary" onclick="f_load_reference(1,0,'dt_ref_certIssuer','cei');"><i class="fa fa-plus"></i> Add New Certificate Issuer</a>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_cei" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="150" /></th>
                                            <th><input type="text" id="cei_created_date" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th style="min-width: 40px">No.</th>     
                                            <th data-class="expand" class="text-center">Certificate Issuer</th>     
                                            <th data-hide="phone" width="25%" class="text-center">Created Time</th>
                                            <th style="min-width: 80px">Status</th>
                                            <th style="min-width: 60px">&nbsp;</th>
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
include 'view/modal/modal_reference.php';
?>

       