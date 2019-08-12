<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Data Compliance</li><li>Limit Exceeding Reports</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-warning fa-fw "></i> 
                Data Compliance
                <span>> 
                    Limit Exceeding Reports
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-5">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-exi1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-search-plus"></i> </span>
                        <h2>Search Filter</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <form class="form-horizontal" id="form_exi">
                                <div class="form-group padding-top-10">
                                    <label class="col-md-4 control-label">Date</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" name="exi_data_timestamp" id="exi_data_timestamp" class="form-control" >
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>       
                                        </div>
                                    </div>
                                </div>
                                <div class="widget-footer">
                                    <button type="button" class="btn btn-labeled btn-info" id="exi_btn_view">
                                        <span class="btn-label"><i class="fa fa-search"></i></span>View
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight" id="exi_widget_stack" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2><span id="exi_widget_0_title_data"></span></h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <form class="form-horizontal" id="" method="post">
                                <div class="row padding-gutter">
                                    <div class="col-md-12">
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label padding-right-5"><strong>Stack ID</strong></label>
                                            <div class="col-md-8 selectContainer">
                                                <select class="form-control" name="exi_indAll_id" id="exi_indAll_id"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label padding-right-5"><strong>Registration No</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <a href="#" onclick="f_exi_link(exi_indAll_id.value, exi_wfFlow_id.value, 'industrial');"><span id="lexi_wfTrans_regNo"></span></a>
                                            </div>
                                        </div>                   
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label padding-right-5"><strong>JAS File No</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lexi_industrial_jasFileNo"></span>
                                            </div>
                                        </div>                                      
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label padding-right-5"><strong>Consultant Name</strong></label>
                                            <div class="col-md-8 control-label text-align-left padding-right-0">
                                                <a href="#" onclick="f_exi_link(exi_conAll_id.value, exi_wfFlow_id.value, 'consultant');"><span id="lexi_consultant_name"></span></a>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-4 control-label padding-right-5"><strong>Location</strong></label>
                                            <div class="col-md-8 control-label text-align-left">
                                                <span id="lexi_city_desc"></span>, <span id="lexi_state_desc"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="exi_conAll_id" id="exi_conAll_id" />
                                <input type="hidden" name="exi_wfFlow_id" id="exi_wfFlow_id" />
                            </form>
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_exi" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Time</th>          
                                            <th>T. PM</br>(<span id="exi_tblheader_1"></span>)</th>                                             
                                            <th>SO<sub>2</sub></br>(<span id="exi_tblheader_2"></span>)</th>
                                            <th>NO<sub>2</sub></br>(<span id="exi_tblheader_3"></span>)</th>                                                    
                                            <th>HCl</br>(<span id="exi_tblheader_4"></span>)</th>
                                            <th>HF</br>(<span id="exi_tblheader_5"></span>)</th>
                                            <th>CO</br>(<span id="exi_tblheader_6"></span>)</th>
                                            <th>NMvoc</br>(<span id="exi_tblheader_7"></span>)</th>     
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>									
                                </table>    
                            </div>
                            <hr class="no-margin">
                            <div class="row padding-gutter"><div class="col-md-12"></div></div>
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_exi_opa" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Time</th>       
                                            <th>Opacity</br>(<span id="exi_tblheader_8"></span>)</th>                                  
                                            <th>O<sub>2</sub></br>(<span id="exi_tblheader_9"></span>)</th>                                  
                                            <th>CO<sub>2</sub></br>(<span id="exi_tblheader_10"></span>)</th>
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
            <article class="col-md-7">
                <div class="jarviswidget jarviswidget-color-blueLight" id="exi_widget_0" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_0_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_0" id="exi_indParam_id_0"/>
                    </header>
                    <div>
                        <div class="widget-body">                            
                            <div class="row">                                
                                <div class="col-md-12">
                                    <div id="exi_chart_0_1" style="margin: 0 auto"></div>                                    
                                </div>
                            </div> 
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1 exi_hideView" id="exi_div_bar_0"></div>
                            </div>   
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_1_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_1" id="exi_indParam_id_1"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_1_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_1"></div>
                            </div>
<!--                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_1_4" style="margin: 0 auto"></div>
                                </div>
                            </div>                            -->
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_2_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_2" id="exi_indParam_id_2"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_2_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_2"></div>
                            </div>                         
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_3" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_3_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_3" id="exi_indParam_id_3"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_3_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_3"></div>
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_4" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_4_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_4" id="exi_indParam_id_4"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_4_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_4"></div>
                            </div>                         
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_5" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_5_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_5" id="exi_indParam_id_5"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_5_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_5"></div>
                            </div>                       
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_6" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_6_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_6" id="exi_indParam_id_6"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_6_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_6"></div>
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_7" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_7_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_7" id="exi_indParam_id_7"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_7_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_7"></div>
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_8" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_8_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_8" id="exi_indParam_id_8"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_8_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_8"></div>
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_9" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_9_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_9" id="exi_indParam_id_9"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_9_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_9"></div>
                            </div>                        
                        </div>
                    </div>
                </div>
                <div class="jarviswidget jarviswidget-color-blueLight exi_hideView" id="exi_widget_10" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
                        <h2><span id="exi_widget_8_title"></span></h2>
                        <input type="hidden" name="exi_indParam_id_10" id="exi_indParam_id_10"/>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="exi_chart_10_1" style="margin: 0 auto"></div>
                                </div>
                            </div>    
                            <div class="row padding-bottom-10">                                
                                <div class="col-md-11 col-md-offset-1" id="exi_div_bar_10"></div>
                            </div>                        
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
<?php
    include 'view/modal/modal_cems.php';
    include 'view/modal/modal_pems.php';
    include 'view/modal/modal_consultant_cems.php';
    include 'view/modal/modal_consultant_pems.php';
    include 'view/modal/modal_consultant_mobile.php';    
?>
       