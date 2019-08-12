<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Reporting</li><li>Quality Assurance Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-bar-chart-o fa-fw "></i> 
                Reporting
                <span>> 
                    Quality Assurance Reports
                </span>
            </h1>
        </div>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
            <ul id="sparks" class="">
                <li class="sparks-info">
                    <h5> Pending RAA <span class="txt-color-blue"><i class="fa fa-gavel"></i>&nbsp;56</span></h5>
                </li>
                <li class="sparks-info">
                    <h5> Pending RATA <span class="txt-color-greenDark"><i class="fa fa-gavel"></i>&nbsp;201</span></h5>
                </li>
            </ul>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-qcl1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false"> 
                    <header>
                        <span class="widget-icon"> <i class="fa fa-calendar"></i> </span>
                        <h2> Quality Assurance Calendar </h2>
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
    </section>
</div>
