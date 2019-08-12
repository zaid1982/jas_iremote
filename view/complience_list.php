<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your fields." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>    
    <ol class="breadcrumb">
        <li>Data Compliance</li><li>List of Data Compliance</li>
    </ol>
</div>

<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-5">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa fa-warning fa-fw "></i> 
                Data Compliance
                <span>> 
                    List of Data Compliance
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-md-12">
                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-cmn1" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">                
                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>List of Data Compliance</h2>
                    </header>
                    <div>
                        <div class="widget-body no-padding">
                            <form class="form-horizontal" id="" method="post">
                                <div class="row padding-15">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-2 control-label text-align-left">State <p class="pull-right">:</p></label>
                                            <div class="col-md-5 selectContainer">
                                                <select class="form-control" name="" id="">
                                                    <option>-- All State --</option>                                                    
                                                    <option>Kedah</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-2 control-label text-align-left">City <p class="pull-right">:</p></label>
                                            <div class="col-md-5 selectContainer">
                                                <select class="form-control" name="" id="">
                                                    <option>-- All City --</option>                                                    
                                                    <option>Alor Star</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group margin-bottom-0">
                                            <label class="col-md-2 control-label text-align-left">Date <p class="pull-right">:</p></label>
                                            <div class="col-md-2">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </div>
                                            <label class="col-md-1 control-label text-center">to</label>
                                            <div class="col-md-2">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon hidden-xs"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </div> 
                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-labeled btn-primary" id="">
                                                    <div class=""><span class="btn-label"><i class="fa fa-filter"></i></span> Apply</div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </form>
                            <hr class="no-margin">
                            <div class="table-responsive">                                
                                <table id="datatable_cmn" class="table table-striped table-bordered table-hover table-condensed" width="100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><i class="fa fa-search-plus fa-2x txt-color-magenta"></i></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th data-hide="phone">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="" class="form-control" readonly>
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                                </div>
                                            </th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th><input type="text" class="form-control" maxlength="30" /></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th width="50px">No.</th>
                                            <th>Industrial Name</th>                                            
                                            <th width="10%">Registration No.</th>
                                            <th width="15%">Stack ID</th> 
                                            <th width="14%">Date/Time</th>                                                       
                                            <th width="8%">Parameter</th>
                                            <th width="8%">Limit</th>       
                                            <th width="8%">Data</th>         
                                            <th width="40px">Status</th>                                            
                                            <th width="60px">&nbsp;</th>
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
        </div>
    </section>
</div>
<?php 
include 'view/modal/modal_cems.php';
include 'view/modal/modal_pems.php';
include 'view/modal/modal_response.php';
?>

       