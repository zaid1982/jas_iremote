<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>System Management</li><li>User Management</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-gears fa-fw "></i> 
                System Management
                <span>> 
                    User Management
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">        
        <form class="form-horizontal" id="form_umg">
            <div class="row">
                <article class="col-md-12">
                    <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-umg1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                        <header>
                            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                            <h2>User List &nbsp;<span class="font-xs text-danger" id="umg_table_title"></span></h2>
                            <div class="widget-toolbar">
                                <a href="javascript:void(0);" class="btn btn-primary" onclick="f_load_user(1,'','umg');"><i class="fa fa-user-plus"></i> Add Internal User</a>
                            </div>
                        </header>
                        <div>
                            <div class="widget-body no-padding">
                                <div class="table-responsive">                                
                                    <table id="datatable_umg" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" id="umg_dateRegistered" class="form-control" readonly></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th><input type="text" class="form-control" maxlength="50" /></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th width="30px">No.</th>         
                                                <th data-class="expand">Name</th>               
                                                <th data-hide="phone">IC No.</th>          
                                                <th data-hide="phone">User Type</th>   
                                                <th data-hide="phone,tablet">Company</th>
                                                <th data-hide="phone,tablet">Department</th>
                                                <th data-hide="phone">Role</th>
                                                <th width="15%" data-hide="phone,tablet">Registered Date</th>
                                                <th data-hide="phone,tablet">Mobile No</th>
                                                <th data-hide="phone,tablet">Email</th>
                                                <th width="10%" style="max-width: 50px">Status</th>
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
        </form>
    </section>
</div>
<?php 
include 'view/modal/modal_user.php';
?>