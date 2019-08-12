<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Home</li><li>Industrial</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-home fa-fw "></i> 
                Home
                <span>> 
                    Dashboard for Industrial
                </span>
            </h1>
        </div>
    </div>
    <div class="alert alert-block alert-danger" id="hm7_alert">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
        <p id="hm7_alert_txt"></p>
        <br>
        <a href="#" class="btn btn-primary hide" id="hm7_btn_upd_ind" onclick="f_menu_redirect(11,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Update Industrial Information </strong></a>        
    </div>
    <div class="alert alert-block alert-info" id="hm7_info_register">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-info-circle fa-fw"></i> Information</h4>
        <p>
            Please choose on the menu to register <strong>CEMS Installation</strong> or <strong>PEMS Installation</strong>. 
        </p>
        <br>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(12,21,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS Installation </strong></a>
        <a href="#" class="btn btn-warning" onclick="f_menu_redirect(12,22,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register PEMS Installation </strong></a>
    </div>      
    <div class="row">
        <article class="col-md-6">
            <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                <header>
                    <span class="widget-icon"> <i class="fa fa-database"></i> </span>
                    <h2>Pending Respond on Fail Data Pooling/Compliance</h2>
                </header>
                <div>
                    <div class="widget-body no-padding">
                        <div class="table-responsive">                                
                            <table id="datatable_hm71" class="table table-striped table-bordered table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>
                                <div class="input-group col-md-12">
                                    <input type="text" id="" class="form-control" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                </div>
                                </th>
                                <th><input type="text" class="form-control" maxlength="30" /></th>
                                <th><input type="text" class="form-control" maxlength="30" /></th>
                                <th><input type="text" class="form-control" maxlength="30" /></th>
                                <th></th>
                                </tr>
                                <tr>
                                    <th width="30px">No.</th>                    
                                    <th>Date & Time</th>                 
                                    <th width="15%">Type</th>                                 
                                    <th width="20%">Stack ID</th>
                                    <th width="15%">Parameter</th>
                                    <th width="30px"></th>
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
        <article class="col-md-6">
            <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false"> 
                <header>
                    <span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
                    <h2> Industrial Schedule & Events </h2>
                    <div class="widget-toolbar">
                        <!-- add: non-hidden - to disable auto hide -->
                        <div class="btn-group">
                            <button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
                                Showing <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu js-status-update pull-right">
                                <li>
                                    <a href="javascript:void(0);" id="mt">Month</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="ag">Agenda</a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" id="td">Today</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </header>
                <div>
                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">
                        <input class="form-control" type="text">
                    </div>
                    <!-- end widget edit box -->
                    <div class="widget-body no-padding">
                        <!-- content goes here -->
                        <div class="widget-body-toolbar">

                            <div id="calendar-buttons">

                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
                                    <a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="calendar"></div>

                        <!-- end content -->
                    </div>

                </div>
            </div>
        </article>
    </div>
    <input type="hidden" name="hm7_wfGroup_id" id="hm7_wfGroup_id" />
</div>
<? 
include 'view/modal/modal_response.php';
?>