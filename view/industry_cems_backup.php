<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Industrial</li><li>Application of CEMS Installation</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-building fa-fw "></i> 
                Industrial
                <span>> 
                    Application of CEMS Installation
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">     
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Application List</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_icm" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th data-class="expand"><input type="text" class="form-control" maxlength="30" /></th>
                                            <th data-hide="phone"><input type="text" class="form-control" maxlength="30" /></th>
                                            <th data-hide="phone,tablet"><input type="text" class="form-control" maxlength="30" /></th>
                                            <th data-hide="phone,tablet"><input type="text" class="form-control" maxlength="150" /></th>
                                            <th data-hide="phone,tablet"><input type="text" class="form-control" maxlength="30" /></th>
                                            <th data-hide="phone,tablet"><input type="text" class="form-control" maxlength="30" /></th>
                                            <th data-hide="phone,tablet">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="icm_dateRegistered" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th><input type="number" class="form-control" maxlength="4" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>No.</th>
                                            <th data-class="expand" width="10%">Application No</th>
                                            <th data-hide="phone" width="7%">Application Type</th>          
                                            <th data-hide="phone,tablet" width="10%">Stack ID</th>           
                                            <th width="13%">Source</th>
                                            <th data-hide="phone,tablet">Consultant</th>
                                            <th width="12%">Analyzer/Software</th>
                                            <th data-hide="phone,tablet" width="13%">Time Applied</th>
                                            <th width="60px">Status</th>
                                            <th style="min-width: 80px">Action</th>
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
<? 
include 'view/modal/modal_cems.php';
include 'view/modal/modal_pems.php';
include 'view/modal/modal_change_consultant.php';
include 'view/modal/modal_plan_test.php';
include 'view/modal/modal_cems_test.php';
?>

       