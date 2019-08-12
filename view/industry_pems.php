<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Industrial</li><li>Application of PEMS Installation</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-building fa-fw "></i> 
                Industrial
                <span>> 
                    Application of PEMS Installation
                </span>
            </h1>
        </div>
    </div>
    <div class="alert alert-block alert-danger hide" id="ipm_alert">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
        <p id="ipm_alert_txt"></p>
        <br>
        <a href="#" class="btn btn-primary hide" id="ipm_btn_upd_ind" onclick="f_menu_redirect(11,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Update Industrial Information </strong></a>        
    </div>
    <section id="widget-grid" class=""> 
        <form class="form-horizontal" id="form_ipm">
            <div class="row">
                <article class="col-md-12">
                    <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-ipm1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>PEMS Installation Application List &nbsp;<span class="font-xs text-danger" id="ipm_table_title"></span></h2>
                            <div class="widget-toolbar">
                                <a href="javascript:void(0);" class="btn btn-primary" onclick="f_load_pems(1,ipm_wfGroup_id.value,'','ipm');"><i class="fa fa-plus"></i> Apply New PEMS Installation</a>
                            </div>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <div class="table-responsive">                                
                                    <table id="datatable_ipm" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" id="ipm_dateRegistered" class="form-control" readonly></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th width="30px">No.</th>                      
                                                <th data-class="expand">Application No.</th>                                     
                                                <th width="9%">Stack ID</th>            
                                                <th data-hide="phone,tablet" width="18%">Source</th>                                 
                                                <th data-hide="phone">Consultant</th>
                                                <th data-hide="phone,tablet" width="9%">Modeling Software</th>
                                                <th data-hide="phone,tablet" width="14%">Registered Time</th>
                                                <th width="70px">Status</th>
                                                <th style="min-width: 55px">&nbsp;</th>
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
            <input type="hidden" name="ipm_wfGroup_id" id="ipm_wfGroup_id" />
        </form>
    </section>
</div>       
<?php
include 'view/modal/modal_pems.php';
include 'view/modal/modal_consultant_pems.php';
include 'view/modal/modal_consultant_mobile.php';
include 'view/modal/modal_change_consultant.php';
include 'view/modal/modal_plan_test.php';
include 'view/modal/modal_pems_rata.php';
?>

       