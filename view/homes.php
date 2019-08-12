<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Home</li><li>Dashboard</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-home fa-fw "></i> 
                Home
                <span>> 
                    Dashboard 
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid">    
        <div class="row hide" id="hm_row_1">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-star"></i> </span>
                        <h2>Summary</h2>
                    </header>
                    <div>
                        <div class="widget-body" style="min-height: 10px">
                            <div class="row">
                                <div class="col-lg-2 col-md-4 col-xs-6">
                                    <ul id="sparks" class="pull-left">
                                        <li class="sparks-info">
                                            <h5> Total Industrial <span class="txt-color-greenDark" id="lhm1_total_industry"></span></h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-md-4  col-xs-6">
                                    <ul id="sparks" class="pull-left">
                                        <li class="sparks-info">
                                            <h5> Total Consultants <span class="txt-color-redLight" id="lhm1_total_consultant"></span></h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-md-4  col-xs-6">
                                    <ul id="sparks" class="pull-left">
                                        <li class="sparks-info">
                                            <h5> Total CEMS <span class="txt-color-blue" id="lhm1_total_cems"></span></h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-md-4  col-xs-6"> 
                                    <ul id="sparks" class="pull-left">
                                        <li class="sparks-info">
                                            <h5> Total PEMS <span class="txt-color-purple" id="lhm1_total_pems"></span></h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-md-4  col-xs-6">
                                    <ul id="sparks" class="pull-left">
                                        <li class="sparks-info">
                                            <h5> Total CEMS Analyzer <span class="txt-color-magenta" id="lhm1_total_cems_analyzer"></span></h5>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-2 col-md-4  col-xs-6">
                                    <ul id="sparks" class="pull-left">
                                        <li class="sparks-info">
                                            <h5> Total PEMS Software <span class="txt-color-orangeDark" id="lhm1_total_pems_software"></span></h5>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="alert alert-block alert-danger hide" id="hm_div_7_alert">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
            <p id="hm_7_alert_txt"></p>
            <br>
            <a href="#" class="btn btn-primary hm_class_6 hide" onclick="f_menu_redirect(7,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Update Consultant Information </strong></a>  
            <a href="#" class="btn btn-primary hm_class_7 hide" onclick="f_menu_redirect(11,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Update Industrial Information </strong></a>   
        </div>
        <div class="alert alert-block alert-info hide" id="hm_div_7_info">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading"><i class="fa fa-info-circle fa-fw"></i> Information</h4>
            <p id="hm_7_info_txt"></p>
            <br>
            <a href="#" class="btn btn-info hm_class_6 hide" onclick="f_menu_redirect(8,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS Analyzer </strong></a>
            <a href="#" class="btn btn-info hm_class_6 hide" onclick="f_menu_redirect(19,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register PEMS Software </strong></a>
            <a href="#" class="btn btn-info hm_class_6 hide" onclick="f_menu_redirect(20,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS/Portable Analyzer </strong></a>
            <a href="#" class="btn btn-info hm_class_7 hide" onclick="f_menu_redirect(12,21,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS Installation </strong></a>
            <a href="#" class="btn btn-warning hm_class_7 hide" onclick="f_menu_redirect(12,22,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register PEMS Installation </strong></a>
        </div>
        <div class="row hide" id="hm_row_6">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm6" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-tasks"></i> </span>
                        <h2>Certificate Expiry Date</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="hm_6_content"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row hide" id="hm_row_2">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-tasks"></i> </span>
                        <h2>Pending Task</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-5" id="hm_div_2_1">
                                    <div id="hm_chart_2" style="height: 500px"></div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-7" id="hm_div_2_2">
                                    <div class="alert alert-block alert-danger" id="hm_alert_2">
                                        <a class="close" data-dismiss="alert" href="#">×</a>
                                        <h4 class="alert-heading"><i class="fa-fw fa fa-warning"></i> Pending Tasks!</h4>
                                        <p>
                                            You have total of <strong><span id="hm_lbl_total_pending"></span></strong> pending tasks. 
                                        </p>                                            
                                    </div>
                                    <div class="table-responsive bordered no-padding">                                
                                        <table id="datatable_h2" class="table table-bordered table-hover table-condensed" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="30px">No.</th>     
                                                    <th class="text-center" width="17%">Application No</th>          
                                                    <th class="text-center" width="20%">Application Type</th>                        
                                                    <th class="text-center">Applicant</th>
                                                    <th class="text-center" width="15%">Received Time</th>
                                                    <th class="text-center" width="15%">Due Date</th>
                                                </tr>
                                            </thead>								
                                        </table>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row hide" id="hm_row_3">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-tasks"></i> </span>
                        <h2>Pending Tasks Summary</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="hm_chart_3" style="height: 500px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row hide" id="hm_row_4">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-tasks"></i> </span>
                        <h2>Overall Officers' Pending Tasks Summary</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="hm_chart_4" style="height: 500px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row hide" id="hm_row_5">
            <article class="col-md-6">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm51" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-map"></i> </span>
                        <h2>Daily Fail Data Pooling</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="hm_chart_5_1"></div>
                            <hr>
                            <div id="hm_chart_5_3" style="height: 600px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-6">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-hm52" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-map"></i> </span>
                        <h2>Daily Fail Data Compliance</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="hm_chart_5_2"></div>
                            <hr>
                            <div id="hm_chart_5_4" style="height: 600px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>