<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Reporting</li><li>CEMS/PEMS Installation Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bar-chart-o fa-fw"></i> 
                Reporting
                <span>> 
                    CEMS/PEMS Installation Reports
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <h5> Registration Submitted <span class="txt-color-blue" id="gcp_count_registered"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;</span></h5>
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-8">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total CEMS/PEMS Registration</h2>
                        <div class="widget-toolbar">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    <span id="gcp1_opt_month"><?=date('F')?></span> <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('January');">January</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('February');">February</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('March');">March</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('April');">April</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('May');">May</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('June');">June</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('July');">July</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('August');">August</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('September');">September</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('October');">October</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('November');">November</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gcp1_opt_month').html('December');">December</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    <span id="gcp1_opt_year"><?=date('Y')?></span> <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <?php 
                                    for ($i=intval(date('Y'));$i>=2010;$i--) {
                                        echo '<li><a href="javascript:void(0);" onclick="$(\'#gcp1_opt_year\').html(\''.$i.'\');">'.$i.'</a></li>';
                                    }        
                                    ?>
                                </ul>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-success" onclick="f_gcp_1($('#gcp1_opt_year').html(), monthname.indexOf($('#gcp1_opt_month').html()));">Go</a>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gcp_chart_1" style="height: 600px; max-width: 95%; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total CEMS/PEMS by State & City</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gcp_chart_2" style="height: 600px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-4">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total Installation by Category</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gcp_chart_3" style="height: 340px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total CEMS/PEMS by Pollution Monitored</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gcp_chart_4" style="height: 340px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total CEMS/PEMS by Source Activity</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gcp_chart_5" style="height: 428px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total CEMS/PEMS Monthly Registration by State</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="table-responsive bordered no-padding">
                                <table id="datatable_gcp_state" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">Johor</th>
                                        <th class="text-center">Kedah</th>
                                        <th class="text-center">Kelantan</th>
                                        <th class="text-center">KL</th>
                                        <th class="text-center">Labuan</th>
                                        <th class="text-center">Melaka</th>
                                        <th class="text-center">NS</th>
                                        <th class="text-center">Pahang</th>
                                        <th class="text-center">Perak</th>
                                        <th class="text-center">Perlis</th>
                                        <th class="text-center">PP</th>
                                        <th class="text-center">Putrajaya</th>
                                        <th class="text-center">Sabah</th>
                                        <th class="text-center">Sarawak</th>
                                        <th class="text-center">Selangor</th>
                                        <th class="text-center">Terengganu</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gcp5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total CEMS/PEMS Monthly Registration by Type of Industry</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="table-responsive bordered no-padding">
                                <table id="datatable_gcp_sic" class="table table-bordered table-hover" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Year</th>
                                        <th class="text-center">Month</th>
                                        <th class="text-center">Type of Industry</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>