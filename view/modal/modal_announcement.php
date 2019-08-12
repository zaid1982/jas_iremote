<!-- Modal -->
<div class="modal fade" id="modal_announcement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-bullhorn'></i>&nbsp; <span id="man_title"></span> Announcement</h4>
            </div>
            <div class="modal-body">   
                <form class="form-horizontal" id="form_man">
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="well">
                                <div class="form-group no-margin">
                                    <label class="col-md-4 control-label"><strong>Announcement ID</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        ANN10001
                                    </div>
                                </div> 
                                <div class="form-group no-margin">
                                    <label class="col-md-4 control-label"><strong>Created By</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        Muhammad Amin bin Muhammad Zaid
                                    </div>
                                </div> 
                                <div class="form-group no-margin">
                                    <label class="col-md-4 control-label"><strong>Created Date</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        12/12/2016 23:21:24
                                    </div>
                                </div>
                                <div class="form-group no-margin margin-bottom-5">
                                    <label class="col-md-4 control-label"><strong>Status</strong></label>
                                    <div class="col-md-8 control-label text-align-left">
                                        New
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="form-group">
                                <label class="col-md-3 control-label">Type</label>
                                <div class="col-md-9 selectContainer">   
                                    <select class="form-control" name="" id="">
                                        <option value="">Announcement</option>
                                        <option value="">News</option>
                                        <option value="">Information</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Broadcast Start</label>
                                <div class="col-md-5">   
                                    <div class="input-group col-md-12">
                                        <input type="text" id="man_datepicker" class="form-control" placeholder="Select date" readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                    </div>
                                </div>
                                <div class="col-md-4">  
                                    <div class="input-group">
                                        <input class="form-control" id="man_timepicker" type="text" placeholder="Select time" readonly>
					<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Broadcast End</label>
                                <div class="col-md-5">   
                                    <div class="input-group col-md-12">
                                        <input type="text" id="man_datepicker2" class="form-control" placeholder="Select date" readonly>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>        
                                    </div>
                                </div>
                                <div class="col-md-4">  
                                    <div class="input-group">
                                        <input class="form-control" id="man_timepicker2" type="text" placeholder="Select time" readonly>
					<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                    </div>
                                </div>                                
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Text</label>
                                <div class="col-md-9">   
                                    <textarea class="form-control" name="" id="" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="man_btn_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-warning" id="man_btn_stop">
                            <span class="btn-label"><i class="fa fa-stop"></i></span>Stop
                        </button>
                        <button type="button" class="btn btn-labeled btn-info" id="man_btn_now">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Broadcast Now
                        </button>
                        <button type="button" class="btn btn-labeled btn-success" id="man_btn_submit">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>