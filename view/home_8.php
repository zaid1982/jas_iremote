<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Home</li><li>Consultant</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-home fa-fw "></i> 
                Home
                <span>> 
                    Dashboard for Consultant
                </span>
            </h1>
        </div>
    </div>
    <div class="alert alert-block alert-danger hide" id="hm8_alert">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-warning fa-fw"></i> Please Note!</h4>
        <p id="hm8_alert_txt"></p>
        <br>
        <a href="#" class="btn btn-primary hide" id="hm8_btn_upd_cons" onclick="f_menu_redirect(7,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Update Consultant Information </strong></a>        
    </div>
    <div class="alert alert-block alert-info hide" id="hm8_info_register">
        <a class="close" data-dismiss="alert" href="#">×</a>
        <h4 class="alert-heading"><i class="fa fa-info-circle fa-fw"></i> Information</h4>
        <p>
            Please choose on the menu to add <strong>CEMS Analyzer</strong>, <strong>PEMS Software</strong> or <strong>Mobile-CEMS/Portable</strong>. </br>
            Registered Analyzer / Software will be enabled when Industrial register <strong>CEMS / PEMS Installation Form</strong>.
        </p>
        <br>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(8,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register CEMS Analyzer </strong></a>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(19,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register PEMS Software </strong></a>
        <a href="#" class="btn btn-info" onclick="f_menu_redirect(20,0,0);"><strong><i class="fa fa-arrow-circle-right"></i> Register Mobile-CEMS/Portable </strong></a>
    </div>
    <div class="row">
        <article class="col-md-12">
            <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                <header>
                    <span class="widget-icon"> <i class="fa fa-certificate"></i> </span>
                    <h2>Certificate Expiry Date</h2>
                </header>
                <div>
                    <div class="widget-body">
                        <p>
                            Certificate TUV EN1232-23 <span class="txt-color-purple">(Start: 23/12/2014)</span> <span class="txt-color-purple pull-right"><i class="fa fa-warning"></i> Expired in 22/12/2016 (In 2 months)</span>
                        </p>
                        <div class="progress">

                            <div class="progress progress-striped active">
                                <div class="progress-bar bg-color-purple" role="progressbar" style="width: 77%"></div>
                            </div>

                        </div>
                        <p>
                            Certificate MCERT 212111 <span class="txt-color-purple">(Start: 01/02/2014)</span> <span class="txt-color-purple pull-right"><i class="fa fa-warning"></i> Expired in 01/02/2015 (Expired)</span>
                        </p>
                        <div class="progress">

                            <div class="progress progress-striped active">
                                <div class="progress-bar bg-color-redLightd" role="progressbar" style="width: 100%"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>    
    <input type="hidden" name="hm8_wfGroup_id" id="hm8_wfGroup_id" />
</div>
