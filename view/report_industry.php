<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Reporting</li><li>Industrial Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bar-chart-o fa-fw "></i> 
                Reporting
                <span>> 
                    Industrial Reports
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <h5> Registered <span class="txt-color-blue" id="gid_count_registered"><i class="fa fa-pencil-square-o"></i>&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;</span></h5>
                </li>
                <li class="sparks-info">
                    <h5> Submitted <span class="txt-color-orangeDark" id="gid_count_submitted"><i class="fa fa-toggle-right"></i>&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;</span></h5>
                </li>
                <li class="sparks-info">
                    <h5> Approved <span class="txt-color-greenDark" id="gid_count_approved"><i class="fa fa-toggle-right"></i>&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;</span></h5>
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gid1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total Industrial Registration</h2>
                        <div class="widget-toolbar">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    <span id="gid1_opt_month"><?=date('F')?></span> <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('January');">January</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('February');">February</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('March');">March</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('April');">April</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('May');">May</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('June');">June</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('July');">July</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('August');">August</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('September');">September</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('October');">October</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('November');">November</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="$('#gid1_opt_month').html('December');">December</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-primary" data-toggle="dropdown">
                                    <span id="gid1_opt_year"><?=date('Y')?></span> <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <?php 
                                    for ($i=intval(date('Y'));$i>=2010;$i--) {
                                        echo '<li><a href="javascript:void(0);" onclick="$(\'#gid1_opt_year\').html(\''.$i.'\');">'.$i.'</a></li>';
                                    }        
                                    ?>
                                </ul>
                            </div>
                            <a href="javascript:void(0);" class="btn btn-success" onclick="f_gid_1($('#gid1_opt_year').html(), monthname.indexOf($('#gid1_opt_month').html()));">Go</a>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gid_chart_1" style="max-width: 95%; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-md-7">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gid2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total Industrial by State & City</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gid_chart_2" style="height: 600px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-5">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gid3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Industrial by Plant Sector</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gid_chart_3" ></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
