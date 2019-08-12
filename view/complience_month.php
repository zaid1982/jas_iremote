<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Data Compliance</li><li>Monthly Compliance</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-warning fa-fw "></i> 
                Data Compliance
                <span>> 
                    Monthly Compliance
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-9">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cmn1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-search-plus"></i> </span>
                        <h2>Search Filter</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <form class="form-horizontal" id="form_cmn">
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> State</label>
                                    <div class="col-md-6 selectContainer">
                                        <select class="form-control" name="cmn_state_code" id="cmn_state_code"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Industrial Premise</label>
                                    <div class="col-md-9 selectContainer">
                                        <select class="form-control" name="cmn_industrial_id" id="cmn_industrial_id" disabled></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Stack ID</label>
                                    <div class="col-md-4 selectContainer">
                                        <select class="form-control" name="cmn_indAll_stackNo" id="cmn_indAll_stackNo" disabled></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Input Parameter</label>
                                    <div class="col-md-4 selectContainer">
                                        <select class="form-control" name="cmn_input_param" id="cmn_input_param" disabled>
                                            <option value=""></option>
                                            <option value="1">Total PM</option>
                                            <option value="2">SO2</option>
                                            <option value="3">NO2</option>
                                            <option value="4">HCl</option>
                                            <option value="5">HF</option>
                                            <option value="6">CO</option>
                                            <option value="7">NMVOC</option>
                                            <option value="8">Opacity</option>
                                            <option value="9">O2</option>
                                            <option value="10">CO2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Month</label>
                                    <div class="col-md-3 selectContainer">
                                        <select class="form-control" name="cmn_month" id="cmn_month" disabled>
                                            <option value=""></option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><font color="red">*</font> Year</label>
                                    <div class="col-md-3 selectContainer">
                                        <select class="form-control" name="cmn_year" id="cmn_year" disabled>
                                            <option value=""></option>
                                            <?php
                                                for($x=date('Y');$x>=2017;$x--) {
                                                    echo '<option value="'.$x.'">'.$x.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="widget-footer">
                                    <button type="button" class="btn btn-labeled btn-info" id="cmn_btn_view">
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
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cmn2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-line-chart"></i> </span>
                        <h2>Chart</h2>
                    </header>
                    <div>
                        <div class="widget-body">
                            <div class="row">                                
                                <div class="col-md-12">
                                    <div id="cmn_chart" style="margin: 0 auto"></div>                                    
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>