<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Consultant</li><li>List of Consultant</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-user-secret fa-fw "></i> 
                Consultant
                <span>> 
                    Consultant List
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cnl1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Consultant List &nbsp;<span class="font-xs text-danger" id="cca_table_title"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_cnl" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th>
                                                <select class="form-control" name="" id="">
                                                    <option></option>                                                    
                                                    <option value="CEMS">CEMS</option>                                              
                                                    <option value="PEMS">PEMS</option>                                              
                                                    <option value="Mobile-CEMS">Mobile-CEMS</option>
                                                </select>
                                            </th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th><input type="text" id="cnl_dateRegistered" class="form-control" readonly></th>
                                            <th><input type="text" class="form-control" maxlength="50" /></th>
                                            <th></th>
                                        </tr>
                                        <tr> 
                                            <th width="30px">No.</th>
                                            <th data-class="expand">Consultant Name</th>                                            
                                            <th data-hide="phone" width="13%">Registration No.</th>
                                            <th data-hide="phone,tablet" width="10%">Type</th>
                                            <th data-hide="phone,tablet" width="12%">City</th>                                            
                                            <th data-hide="phone,tablet" width="10%">State</th>
                                            <th data-hide="phone,tablet" width="14%">Registered Time</th>
                                            <th data-hide="phone" width="75px">Status</th>
                                            <th width="35px" style="min-width: 35px">&nbsp;</th>
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
include 'view/modal/modal_consultant.php';
?>

       