<div class="modal fade" id="modal_pdf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header bg-color-blueLight txt-color-white">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                &times;
            </button>
            <h4 class="modal-title"><i class='fa fa-print'></i>&nbsp; Print Preview</h4>
        </div>
        <!-- ./modal-header -->
        <div class="modal-body" style="max-height: calc(100vh - 210px); overflow-y: auto;"> 
          <!-- Default box -->          
          <div class="box-body">
            <div class="row">
                <div class="col-md-12" style="height: calc(100vh - 270px); ">
                    <iframe type="application/pdf" id="mpdf_iframe" name="mpdf_iframe_<?=time()?>" src="pdf/test.pdf" height="100%" width="100%"></iframe>
                </div>                                    
            </div>
          </div>
        </div>
        <!-- ./modal-body -->
        <div class="modal-footer">
            <div class="pull-left">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
      </div>
      <!-- ./modal-content --> 
    </div>
  <!-- ./modal-dialog --> 
</div>