<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Reporting</li><li>CEMS Analyzer Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bar-chart-o fa-fw "></i> 
                Reporting
                <span>> 
                    CEMS Analyzer Reports
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <h5> Total Active Analyzer <span class="txt-color-greenDark" id="gca_count_active"><i class="fa fa-hdd-o"></i>&nbsp;&nbsp;0&nbsp;&nbsp;&nbsp;</span></h5>
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-6">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gan1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Analyzer by Type</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gca_chart_1" style="height: 450px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-6">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gan5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Analyzer by Certificate Expiry</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gca_chart_5" style="height: 450px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="row">
            <article class="col-md-4">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gan3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Analyzer by Technique</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gca_chart_3" style="height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gan4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Analyzer by Normalization Type</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gca_chart_4" style="height: 400px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-8">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-gan2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-pie-chart"></i> </span>
                        <h2>Total Analyzer by Method of Detection</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div id="gca_chart_2" style="height: 892px; margin: 0 auto"></div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
