<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Data Compliance</li><li>Old Data Compliance</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-warning fa-fw "></i> 
                Data Compliance
                <span>> 
                    Old Data Compliance
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-9">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-olc1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-search-plus"></i> </span>
                        <h2>Search Filter</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <form class="form-horizontal" id="form_olc">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">State</label>
                                    <div class="col-md-6 selectContainer">
                                        <select class="form-control" name="olc_state_code" id="olc_state_code"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Industrial Premise</label>
                                    <div class="col-md-9 selectContainer">
                                        <select class="form-control select2" name="olc_premise_id" id="olc_premise_id" disabled=""></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date</label>
                                    <div class="col-md-3">
                                        <div class="input-group">
                                            <input type="text" name="olc_data_date" id="olc_data_date" class="form-control" >
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>       
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Input Parameter</label>
                                    <div class="col-md-3 selectContainer">
                                        <select class="form-control" name="olc_input_param" id="olc_input_param">
                                            <option value=""></option>
                                            <option value="so2">SO2</option>
                                            <option value="no2">NO2</option>
                                            <option value="co">CO</option>
                                            <option value="co2">CO2</option>
                                            <option value="hcl">HCL</option>
                                            <option value="hf">HF</option>
                                            <option value="o2">O2</option>
                                            <option value="nmvoc">NMVOC</option>
                                            <option value="totalpm">Total PM</option>
                                            <option value="opacity">Opacity</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="widget-footer">
                                    <button type="button" class="btn btn-labeled btn-info" id="exr_btn_view">
                                        <span class="btn-label"><i class="fa fa-search"></i></span>View
                                    </button>
                                </div>
                                <input type="hidden" name="funct" value="get_old_data"/>
                            </form>
                        </div>
                    </div>
                </div>
            </article>
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-olc2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-line-chart"></i> </span>
                        <h2>Chart</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">                                
                                <div class="col-md-12">
                                    <div id="olc_chart" style="margin: 0 auto"></div>                                    
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>