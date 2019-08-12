<!-- Modal -->
<div class="modal fade" id="modal_delegate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">  
            <div class="modal-header bg-color-blueLight txt-color-white">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title"><i class='fa fa-share-square-o'></i>&nbsp; Task Delegation</h4>
            </div>
            <div class="modal-body">   
                <form class="form-horizontal" id="form_mdg">
                    <div class="row">
                        <div class="col-md-12">   
                            <div class="well">
                                <div class="form-group no-margin">
                                    <label class="col-md-3 control-label"><strong>Officer Name</strong></label>
                                    <div class="col-md-9 control-label text-align-left">
                                        Muhammad Ali bin Muhammad Zaid
                                    </div>
                                </div> 
                                <div class="form-group no-margin margin-bottom-5">
                                    <label class="col-md-3 control-label"><strong>Application No</strong></label>
                                    <div class="col-md-9 control-label text-align-left">
                                        CEMS/203102-2
                                    </div>
                                </div> 
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Delegate Type</label>
                                <div class="col-md-9">   
                                    <label class="radio radio-inline">
                                        <input type="radio" class="radiobox" name="mct_city_status" value="1" checked>
                                        <span>This Task Only</span> 
                                    </label>
                                    <label class="radio radio-inline">
                                        <input type="radio" class="radiobox" name="mct_city_status" value="0">
                                        <span>All Task</span>  
                                    </label>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-3 control-label">Delegate To</label>
                                <div class="col-md-9 selectContainer">   
                                    <select class="form-control" name="" id="">
                                        <option value="">Fatin binti Raihan</option>
                                        <option value="">Anizah bte Abdul Ghani</option>
                                        <option value="">Nazim bin Ahmad</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-labeled btn-danger pull-left" id="mdg_btn_modal_cancel" data-dismiss="modal">
                            <span class="btn-label"><i class="fa fa-mail-reply "></i></span>Exit
                        </button>
                        <button type="button" class="btn btn-labeled btn-success" id="mdg_btn_modal_post">
                            <span class="btn-label"><i class="fa fa-mail-forward"></i></span>Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>