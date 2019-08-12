<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>System Management</li><li>Audit Trail</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-gears fa-fw "></i> 
                System Management
                <span>> 
                    Audit Trail
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">        
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-aud1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Audit Trail Logs</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <div class="table-responsive">                                
                                <table id="datatable_aud" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="80" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="150" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="150" /></th>
                                            <th>
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="aud_action_date" class="form-control" readonly>
                                                    <span class="input-group-addon hidden-md hidden-sm hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th><input type="text" class="form-control" maxlength="150" /></th>
                                            <th><input type="text" class="form-control" maxlength="150" /></th>
                                            <!-- <th><input type="text" class="form-control" maxlength="150" /></th> -->
                                        </tr>
                                        <tr>
                                            <th width="30px">No.</th>     
                                            <th data-class="expand">User Name</th>                   
                                            <th data-hide="phone" width="10%">IC No.</th>               
                                            <th data-hide="phone" width="12%">Role</th>         
                                            <th data-hide="phone,tablet" width="8%">IP Address</th>
                                            <th data-hide="phone,tablet" width="10%">Location</th>
                                            <th width="13%">Date and Time</th>
                                            <th width="8%">Category</th>
                                            <th width="8%">Action</th>
                                            <!-- <th data-hide="phone,tablet" width="10%">Remark</th> -->
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
       