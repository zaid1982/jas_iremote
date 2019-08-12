<script type="text/javascript">  
    
    var dataMth;
    
    $(document).ready(function () {
        
       // ---- new task ---- \\
        var datatable_mth = undefined;
        dataMth = $('#datatable_mth').DataTable({
            "aaSorting": [[3,'asc']],
            //"scrollX": true,
            "sDom": "<'dt-toolbar'<'col-sm-12 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_mth) {
                    datatable_mth = new ResponsiveDatatablesHelper($('#datatable_mth'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mth.createExpandIcon(nRow);
                var info = dataMth.page.info();
                $('td', nRow).eq(0).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mth.respond();
            },
            "aoColumns":
                [
                    {mData: null, bSortable: false, sClass: 'text-center'},
                    {mData: 'wfTaskType_name'},
                    {mData: 'status_desc', sClass: 'text-center'},
                    {mData: 'claimed_by'},
                    {mData: 'wfTask_timeCreated', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: 'wfTask_dateExpired', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: 'wfTask_timeSubmitted', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: 'day_late', sClass: 'text-center',
                        mRender: function (data, type, row) {
                            if (row.day_late > '0')
                                $label = '<b class="badge bg-color-red" data-toggle="popover" data-trigger="hover" data-placement="left" data-original-title="<i class=\'fa fa-fw fa-warning\'></i> <b>Reason of Lateness</b>" data-content="Still need deeper checking." data-html="true">' + row.day_late + '</b>';
                            else 
                                $label = row.day_late;
                            return $label;
                        }
                    },
                    {mData: 'remarks'}
                ]
        });
        $('#datatable_mth tbody').delegate('tr', 'mouseenter', function (evt) {
            var $cell=$(evt.target).closest('td');
            $cell.css( 'cursor', 'pointer' );             
        });          
        $('#datatable_mth').on('draw.dt', function () {
            $('[data-toggle="popover"]').popover();
        });
        
        datas = [{wfTaskType_name:'CEMS Form Filling', status_desc:'Submitted', wfTask_timeCreated:'2016-10-02 14:03:32', wfTask_dateExpired:'2016-10-15', wfTask_timeSubmitted:'2016-10-10 14:03:30', claimed_by:'Suriati bte Ali', day_process:'10', day_late:'0', remarks:'This application has been verified and checked closely, and site visit also has been done.'},
            {wfTaskType_name:'CEMS Form Process', status_desc:'Processing', wfTask_timeCreated:'2016-10-10 08:33:30', wfTask_dateExpired:'2016-10-18', wfTask_timeSubmitted:'', claimed_by:'Siti Aminah bte Raihan', day_process:'12', day_late:'2', remarks:'Everything fine. Please proceed this application.'}];
        f_dataTable_draw(dataMth, datas, 'datatable_mth', 9);
        
        $('#mth_btn_modal_preview').on('click', function () {
            f_load_company (4, '', $('#mth_v_vendor_id').val(), '', 'mth');
        });
        
    });
    
    var mth_turn = '1';    
    function f_load_task_history (wfTask_id) {
        //var profile = f_get_general_info('dt_track_monitoring', {'wfTask_id':wfTask_id}, 'mth');
        //$('#lmth_wfTask_dateExpired').html(replaceNull(convert_date_to_picker(profile.wfTask_dateExpired, '-')));
        //datas = f_get_general_info_multiple('dt_task_history', {'wfTrans_id':profile.wfTrans_id});
        //f_dataTable_draw(dataMth, datas, 'datatable_mth', 9);     
        //$('#mth_step2,#mth_step3,#mth_step4').removeClass('active');
//        $.each(datas, function(u){
//            mth_turn = datas[u].wfTaskType_turn;
//        });        
//        for (var i=1;i<=mth_turn;i++){
//            $('#mth_step'+i).addClass('active');
//        }
//        var wf_task = f_get_general_info('wf_task', {'wfTask_id':wfTask_id});
//        var v_vendor = f_get_general_info('v_vendor', {'wfTrans_id':wf_task.wfTrans_id});
//        $('#mth_v_vendor_id').val(v_vendor.v_vendor_id);
        $('#modal_task_history').modal('show');
    }
    
</script>