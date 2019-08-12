<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>System Management</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bullhorn fa-fw "></i> 
                Announcement Management
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">        
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-anc1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>Announcement List</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <form class="form-horizontal" id="" method="post">
                                <div class="row padding-15">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-2 control-label text-align-left">Broadcast Date <p class="pull-right">:</p></label>
                                            <div class="col-md-2">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </div>
                                            <label class="col-md-1 control-label text-center">to</label>
                                            <div class="col-md-2">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </div> 
                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-labeled btn-primary" id="">
                                                    <div class=""><span class="btn-label"><i class="fa fa-filter"></i></span> Apply</div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_anc" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th data-hide="phone">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th>
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th>No.</th>     
                                            <th style="min-width: 100px">Created Date</th>          
                                            <th width="13%">Created By</th>          
                                            <th width="9%">Category</th>
                                            <th style="min-width: 100px">Broadcast Start</th>  
                                            <th style="min-width: 100px">Broadcast End</th>   
                                            <th>Message</th>             
                                            <th style="min-width: 50px">Status</th>
                                            <th style="min-width: 40px">&nbsp;</th>
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
include 'view/modal/modal_announcement.php';
?>

       