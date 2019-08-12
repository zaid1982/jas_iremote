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
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-qat1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Quality Assurance Task</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_qat" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th>
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th data-hide="phone">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>No.</th>                                                           
                                            <th width="10%">Stack ID</th>
                                            <th width="10%">Installation Type</th>
                                            <th width="13%">Analyzer Model No.</th>
                                            <th>Consultant</th>
                                            <th width="10%">QA Type</th>
                                            <th width="10%">Schedule Date</th>
                                            <th width="10%">QA Date</th>
                                            <th width="60px">Status</th>
                                            <th width="60px">&nbsp;</th>
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
include 'view/modal/modal_analyzer.php';
include 'view/modal/modal_qa_report.php';
?>

       