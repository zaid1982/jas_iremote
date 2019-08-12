<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>PEMS Software</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-hdd-o fa-fw "></i> 
                PEMS Software
            </h1>
        </div>
    </div>
    <div class="alert alert-block alert-danger hide" id="cps_alert">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
        <p id="cps_alert_txt"></p>
        <br>
        <a href="#" class="btn btn-primary hide" id="cps_btn_upd_cons" onclick="f_menu_redirect(7,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Update Consultant Information </strong></a>        
    </div>
    <section id="widget-grid" class="">      
        <form class="form-horizontal" id="form_cps">
            <div class="row">
                <article class="col-md-12">
                    <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cps1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>PEMS Software List &nbsp;<span class="font-xs text-danger" id="cps_table_title"></span></h2>
                            <div class="widget-toolbar">
                                <a href="javascript:void(0);" class="btn btn-primary" onclick="f_load_consultant_pems(1,cps_wfGroup_id.value,'','cps');"><i class="fa fa-plus"></i> Apply New PEMS Software</a>
                            </div>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <div class="table-responsive">                                
                                    <table id="datatable_cps" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" id="cps_dateRegistered" class="form-control" readonly></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th width="30px">No.</th>                      
                                                <th data-class="expand">Application No.</th>                                           
                                                <th data-hide="phone" width="13%">Modeling Software</th>                              
                                                <th data-hide="phone" width="8%">Software Version</th>                                            
                                                <th data-hide="phone,tablet" width="13%">Type of Consultant</th>     
                                                <th data-hide="phone,tablet" width="110px">Predictive Method</th>
                                                <th data-hide="phone,tablet">Software Owner</th>
                                                <th data-hide="phone,tablet" width="14%">Registered Time</th>
                                                <th width="70px">Status</th>
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
            <input type="hidden" name="cps_wfGroup_id" id="cps_wfGroup_id" />
        </form>
    </section>
</div>
<?php 
    include 'view/modal/modal_consultant_pems.php';
?>

       