<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Query and Feedback</li><li>Post Inquiry</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-question-circle fa-fw "></i> 
                Query and Feedback
                <span>> 
                    Post Inquiry
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">        
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-qfp1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Opened Inquiry Cases <span class="font-xs text-danger" id="qfp_table_title"></span></h2>
                        <div class="widget-toolbar">
                            <a href="javascript:void(0);" class="btn btn-primary" onclick="f_load_qnf(1,'','','qfp');"><i class="fa fa-plus"></i> Post New Inquiry</a>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_qfp" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" id="qfp_timestamp" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="255" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th data-hide="phone" width="30px">No.</th>
                                            <th data-class="expand">Case No.</th>                      
                                            <th data-hide="tablet" width="130px" style="min-width: 130px">Date & Time</th>                                                  
                                            <th >Category</th>
                                            <th data-hide="phone">Inquiry Title</th>
                                            <th data-hide="phone" width="6%">Status</th>
                                            <th width="32px" style="min-width: 32px">&nbsp;</th>
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
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-qfp2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-collapsed="true">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Closed Inquiry Cases <span class="font-xs text-danger" id="qfp_table_title2"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_qfp2" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" id="qfp_timestamp2" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="255" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th data-hide="phone" width="30px">No.</th>
                                            <th data-class="expand">Case No.</th>                      
                                            <th data-hide="phone" width="130px" style="min-width: 130px">Date & Time</th>                                                  
                                            <th >Category</th>
                                            <th data-hide="phone">Inquiry Title</th>
                                            <th data-hide="phone" width="6%">Status</th>
                                            <th width="32px" style="min-width: 32px">&nbsp;</th>
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
include 'view/modal/modal_qnf.php';
?>

       