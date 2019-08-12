<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Reporting</li><li>Data Pooling Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bar-chart-o fa-fw "></i> 
                Reporting
                <span>> 
                    Data Pooling Reports
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <!-- <h5> Dec 16 Fail Pooling <span class="txt-color-greenDark"><i class="fa fa-warning"></i>&nbsp;26.4%</span></h5> -->
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-6">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gpo1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Pooling by Status</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gpo_chart_1" style="height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-6">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gpo2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Fail Pooling by Respond Status</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gpo_chart_2" style="height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gpo3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total Fail Pooling by State & City</h2>
                        <div class="widget-toolbar">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
                                    Type <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0);">Total</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Percentage</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gpo_chart_4" style="height: 600px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gpo4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart"></i> </span>
                        <h2>Total Fail Pooling by Time</h2>
                        <div class="widget-toolbar">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle btn-xs btn-success" data-toggle="dropdown">
                                    Type <i class="fa fa-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="javascript:void(0);">Daily</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Monthly</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">Yearly</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gpo_chart_5" style="max-width: 95%; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>