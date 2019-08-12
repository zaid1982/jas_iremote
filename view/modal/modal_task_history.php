<!-- Modal -->
<div class="modal fade" id="modal_task_history" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="form-horizontal" id="form_mth">
                <div class="modal-header bg-color-blueLight txt-color-white">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-history fa-fw "></i> Transaction History</h4>
                </div>
                <div class="modal-body modal-fixHeight">
                    <!-- widget grid -->
                    <section id="widget-grid" class="">                        
                        <div class="row padding-15">
                            <div class="process">
                                <div class="process-row nav nav-tabs">
                                    <div class="process-step">
                                        <button type="button" class="btn btn-info btn-circle" data-toggle="tab"><i class="fa fa-info fa-2x"></i></button>
                                        <p><small>Fill<br />information</small></p>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn btn-info btn-circle" data-toggle="tab"><i class="fa fa-file-text-o fa-2x"></i></button>
                                        <p><small>Fill<br />description</small></p>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn btn-info btn-circle" data-toggle="tab"><i class="fa fa-image fa-2x"></i></button>
                                        <p><small>Upload<br />images</small></p>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn btn-default btn-circle" data-toggle="tab"><i class="fa fa-cogs fa-2x"></i></button>
                                        <p><small>Configure<br />display</small></p>
                                    </div>
                                    <div class="process-step">
                                        <button type="button" class="btn btn-default btn-circle" data-toggle="tab"><i class="fa fa-check fa-2x"></i></button>
                                        <p><small>Save<br />result</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6>Information</h6>
                        <div class="well">
                            <div class="form-group no-margin">
                                <label class="col-md-2 control-label"><strong>Application No.</strong></label>
                                <div class="col-md-10 control-label text-align-left">
                                    CEMS2014-232
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label class="col-md-2 control-label"><strong>Company Name</strong></label>
                                <div class="col-md-10 control-label text-align-left">
                                    Bujang Senang Sdn Bhd
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label class="col-md-2 control-label"><strong>Registration No.</strong></label>
                                <div class="col-md-10 control-label text-align-left">
                                    433-FE
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label class="col-md-2 control-label"><strong>Application Type</strong></label>
                                <div class="col-md-10 control-label text-align-left">
                                    <span id="maw_app_type"></span>
                                </div>
                            </div>
                            <div class="form-group no-margin margin-bottom-5">
                                <label class="col-md-2 control-label"><strong>Current Status</strong></label>
                                <div class="col-md-10 control-label text-align-left">
                                    <span id="maw_current_status"></span> Application 
                                </div>
                            </div>
                        </div>
                        <h6 class="maw_hide_checklist_ind_cems">Process Application Checklist</h6>
                        <div class="well h-scroll maw_hide_checklist_ind_cems">
                            <div class="form-group">
                                <div class="col-md-12 padding-bottom-0">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Jenis industry adalah tertakluk dengan keperluan pemasangan CEMS</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Butiran mengenai cerobong yang terlibat dengan pemasangan CEMS</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Deskripsi mengenai proses industri yang bersambung dengan cerobong</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Parameter bahan pencemar dan nilai kepekatan</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Butiran mengenai punca pelepasan bahan pencemar udara</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Lokasi pemasangan alat CEMS (5D 2Datau 8D 2D)</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Kesesuaian teknik persampelan alat CEMS</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Kesesuaian range alat CEMS yang dipasang dengan nilai kepekatan bahan pencemar</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Normalization. Sekiranya alat tidak mempunyai pakej analyzer oksigen, perlu dinyatakan kaedah bagaimana memastikan aktiviti normalizataion dilaksanakan; dan diagram yang menunjukkan lokasi analyzer oksigen di plant</span>
                                        </label>
                                    </div> 
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="checkbox" name="" disabled checked>
                                            <span>Diagram pemasangan CEMS yang lengkap dari cerobong ke DAS</span>
                                        </label>
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="row padding-top-15">
                            <article class="col-sm-12 col-md-12 col-lg-12">
                                <div class="jarviswidget jarviswidget-color-blueLight" id="wid-id-1" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">                
                                    <header>
                                        <span class="widget-icon"> <i class="fa fa-list-alt"></i> </span>
                                        <h2>History</h2>
                                    </header>
                                    <!-- widget div-->
                                    <div>
                                        <!-- widget content -->
                                        <div class="widget-body no-padding">
                                            <div class="table-responsive">              
                                                <table id="datatable_mth" class="table table-striped table-bordered table-hover" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th style="min-width: 120px">Task Name</th>
                                                            <th>Task Status</th>
                                                            <th style="min-width: 125px">Action By</th>
                                                            <th style="min-width: 70px">Start Date</th>
                                                            <th style="min-width: 70px">Due Date</th>
                                                            <th style="min-width: 70px">Completed Date</th>
                                                            <th style="min-width: 40px">Day Delay</th>
                                                            <th>Remark</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>									
                                                </table>    
                                            </div>
                                        </div>
                                        <!-- end widget content -->
                                    </div>
                                </div>
                            </article>
                            <!-- WIDGET END -->
                        </div>
                        <!-- end row -->
                    </section>
                    <!-- end widget grid -->     
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="mth_v_vendor_id" id="mth_v_vendor_id" />
                    <button type="button" class="btn btn-labeled btn-danger pull-left" id="mth_btn_modal_cancel" data-dismiss="modal">
                        <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->