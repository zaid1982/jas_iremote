<script type="text/javascript">  
    
    var mpc_otable;
    var dataMpc;
    var arr_wfGroupUser_id = [];
    var arrAll_wfGroupUser_id = [];
    
    $(document).ready(function () {
        
        $("#mpc_dateActive").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            prevText: '<i class="fa fa-chevron-left"></i>',
            nextText: '<i class="fa fa-chevron-right"></i>',
            showButtonPanel: true,
            closeText:'Clear',
            beforeShow: function( input ) {
		setTimeout(function() {
                    var clearButton = $(input ).datepicker( "widget" ).find( ".ui-datepicker-close" );
                    clearButton.unbind("click").bind("click",function(){$.datepicker._clearDate( input );});
                    }, 1 );
            },
            onSelect: function( input ) {
                dataMpc.column('7:visible').search(input).draw();
            }
        });
        
        get_option('mpc_status', '(0,1)', 'ref_status', 'status_desc', 'status_desc', 'status_id', ' ');
        
       // ---- new task ---- \\
        var datatable_mpc = undefined;
        dataMpc = $('#datatable_mpc').DataTable({
            "aaSorting": [[3,'asc']],
            "sDom": "<'dt-toolbar'<'col-sm-6 col-xs-12'<'toolbar_mpc'>><'col-sm-6 hidden-xs'T>r>" + "t" +
                    "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth": true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback": function () {
                if (!datatable_mpc) {
                    datatable_mpc = new ResponsiveDatatablesHelper($('#datatable_mpc'), breakpointDefinition);
                }
            },
            "rowCallback": function (nRow, aData, index) {
                datatable_mpc.createExpandIcon(nRow);
                var info = dataMpc.page.info();
                $('td', nRow).eq(1).html(info.page * info.length + (index + 1));
            },
            "drawCallback": function (oSettings) {
                datatable_mpc.respond();
                $(".check_wfGroupUser_id").prop('checked', false); 
                $.each(arr_wfGroupUser_id, function(u){
                    $("#check_wfGroupUser_id_"+arr_wfGroupUser_id[u]).prop("checked",true);
                });
            },
            "aoColumns":
                [
                    {mData: null, bSortable: false, sClass: 'text-center',
                        mRender: function (data, type, row) {
                            $label = '<label class="checkbox" style="transform: scale(0.8);"><input type="checkbox" name="check_wfGroupUser_id[]" id="check_wfGroupUser_id_'+row.wfGroupUser_id+'" value="'+row.wfGroupUser_id+'" onclick="f_check_wfGroupUser_id(this, \''+row.wfGroupUser_id+'\', \'mrc_btn_delete_wfGroupUser\');" class="check_wfGroupUser" /><i></i></label>';
                            return $label;
                        }
                    },
                    {mData: null, bSortable: false, sClass: 'text-center'},
                    {mData: 'profile_name'},
                    {mData: 'profile_icNo', sClass: 'text-center'},
                    {mData: 'profile_email'},
                    {mData: 'profile_mobileNo', sClass: 'text-center'},
                    {mData: 'wfGroupUser_designation'},
                    {mData: 'wfGroupUser_dateActive', sClass: 'text-center', mRender: function(data) { return convert_date_to_picker(data);}},
                    {mData: 'status_desc', sClass: 'text-center'}
                ]
        });
        $("div.toolbar_mpc").html('<div style="padding-bottom:5px"><button type="button" class="btn btn-info btn-sm" id="mpc_btn_add_wfGroupUser"><i class="fa fa-plus"></i><span class="hidden-mobile">&nbsp;Add</span></button>&nbsp;'
            + '<button type="button" class="btn btn-warning btn-sm" id="mrc_btn_delete_wfGroupUser" disabled><i class="fa fa-minus"></i><span class="hidden-mobile">&nbsp;Delete</span></button></div>');
        $('#datatable_mpc tbody').delegate('tr', 'click', function (evt) {
            var data = dataMpc.row( this ).data();
            var $cell=$(evt.target).closest('td');
            if( $cell.index()>0)
                f_load_edit_pic (2, data['wfGroupUser_id'], data['wfGroup_id'], 'mpc');
        });
        $('#datatable_mpc tbody').delegate('tr', 'mouseenter', function (evt) {
            var $cell=$(evt.target).closest('td');
            $cell.css( 'cursor', 'pointer' );             
        });  
        //filter
        $("#datatable_mpc thead th input[type=text], #datatable_mpc thead th input[type=number]").on('keyup change', function () {
            if ($(this).parent().index() > 0)
                dataMpc.column($(this).parent().index() + ':visible').search(this.value).draw();
        });
        $("#datatable_mpc thead th select").on('change', function () {
            if (this.value == '')
                dataMpc.column($(this).parent().index() + ':visible').search(this.value).draw();
            else
                dataMpc.column($(this).parent().index() + ':visible').search('^'+this.value+'$', true, false, true).draw();
        });     
        
        $('#mpc_btn_add_wfGroupUser').click(function (e) {
            e.preventDefault();
            f_load_edit_pic (1, '', $('#mpc_wfGroup_id').val(), 'mpc');
        });
        
        $('#mrc_btn_delete_wfGroupUser').click(function (e) {
            e.preventDefault();
            if (f_submit_normal('delete_pic', {arr_checked: arr_wfGroupUser_id}, 'p_registration')) {
                f_notify(1, 'Success', result_submit);
                datas = f_get_general_info_multiple('dt_pic', {'wfGroup_id':$('#mpc_wfGroup_id').val()});
                f_setAll_arr_wfGroupUser(datas, 'wfGroupUser_id');
                f_dataTable_draw(dataMpc, datas, 'datatable_mpc', 9);    
                $('#mrc_btn_delete_wfGroupUser').attr('disabled', true);
                if (mpc_otable == 'ccp') {
                    datas = f_get_general_info_multiple('dt_company_pic');
                    f_dataTable_draw(dataNew, datas);
                } else if (mpc_otable == 'vcp') {
                    datas = f_get_general_info_multiple('dt_company_pic_ext');
                    f_dataTable_draw(dataNew, datas);
                }
            }
        });
        
        datas = '';
        f_dataTable_draw(dataMpc, datas, 'datatable_mpc', 9);
        
    });
       
    function f_load_pic (wfGroup_id, vendor_name, otable) {
        mpc_otable = otable;
        $('#form_mpc').trigger('reset');
        $('#mpc_wfGroup_id').val(wfGroup_id);
        $('#lmpc_title').html(vendor_name);
        datas = f_get_general_info_multiple('dt_pic', {'wfGroup_id':wfGroup_id});
        f_setAll_arr_wfGroupUser(datas, 'wfGroupUser_id');
        f_dataTable_draw(dataMpc, datas, 'datatable_mpc', 9);    
        $('#mrc_btn_delete_wfGroupUser').attr('disabled', true); 
        $('#modal_pic').modal('show');
    }
    
    function f_check_wfGroupUser_all(checkbox, field, butDelete) { 
        arr_wfGroupUser_id = [];
        if (checkbox.checked) {
            for (i = 0; i < arrAll_wfGroupUser_id.length; i++){
                arr_wfGroupUser_id.push(arrAll_wfGroupUser_id[i]);
            }
            $("." + field).prop('checked', true);     
            $('#'+butDelete).attr('disabled', false);
        } else {
            $("." + field).prop('checked', false); 
            $('#'+butDelete).attr('disabled', true);
        }
    }

    function f_check_wfGroupUser_id(check, check_id, butDelete){
        check.checked ? arr_wfGroupUser_id.push(check_id) : arr_wfGroupUser_id.splice(arr_wfGroupUser_id.indexOf(check_id),1);
        arr_wfGroupUser_id.length === 0 ? $('#'+butDelete).attr('disabled', true) : $('#'+butDelete).attr('disabled', false);
    }

    function f_setAll_arr_wfGroupUser(data, ids) {
        arr_wfGroupUser_id = [];
        arrAll_wfGroupUser_id = [];
        $("#checkAll_"+ids).prop('checked', false);
        $.each(data, function(u){
            arrAll_wfGroupUser_id.push(data[u][ids]);
        });
    }
    
</script>