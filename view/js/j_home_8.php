
<script type="text/javascript">  
    
    $(document).ready(function () {
        
        pageSetUp();
        
        $('#modal_waiting').on('shown.bs.modal', function(e){
            var wf_group = f_get_general_info('wf_group_user', {user_id:$('#user_id').val(), wfGroupUser_status:'1', wfGroupUser_isMain:'1'});
            $('#hm8_wfGroup_id').val(wf_group.wfGroup_id);
            f_hm8_set_alert();
            $('#modal_waiting').modal('hide');
            $(this).unbind(e);
        }).modal('show'); 
        
    });    
    
    function f_hm8_set_alert() {
        var isFirstTime = f_get_value_from_table('wf_group', 'wfGroup_id', $('#hm8_wfGroup_id').val(), 'wfGroup_isFirstTime');         
        if (isFirstTime == '1') {
            $('#hm8_alert').removeClass('hide');
            $('#hm8_btn_upd_cons').removeClass('hide');
            $('#hm8_alert_txt').html('You are 1st time login as <strong>Consultant</strong>. Please complete the <strong>Consultant Information</strong> first before proceed to registration.');

//        } else {
//            $('#hm8_alert_txt').html('You are not registered as <strong>CEMS / PEMS Consultant</strong> yet. Please fill-in or continue <strong>Application of CEMS / PEMS Consultant Form</strong>.');
//            var consultant_all = f_get_general_info_multiple('t_consultant_all', {consultant_id:$('#hm8_consultant_id').val(), consAll_status:'<>1'}); 
//            if (consultant_all.length > 0) {
//                $('#hm8_btn_add_cons_cems,#hm8_btn_add_cons_pems,#hm8_btn_add_mobile_cems').removeClass('hide').addClass('btn-success');
//                $('#hm8_btn_add_cons_cems_txt').html('Register CEMS Consultant');
//                $('#hm8_btn_add_cons_pems_txt').html('Register PEMS Consultant');
//                $('#hm8_btn_add_mobile_cems_txt').html('Register Moible-CEMS');
//                $.each(consultant_all, function(u){
//                    if (consultant_all[u].consAll_status == '2') {
//                        if (consultant_all[u].consAll_type == '1') {
//                            $('#hm8_btn_add_cons_cems').addClass('btn-warning');
//                            $('#hm8_btn_add_cons_cems_txt').html('Continue CEMS Consultant');
//                        } else if (consultant_all[u].consAll_type == '2') {
//                            $('#hm8_btn_add_cons_pems').addClass('btn-warning');
//                            $('#hm8_btn_add_cons_pems_txt').html('Continue PEMS Consultant');
//                        } else if (consultant_all[u].consAll_type == '3') {
//                            $('#hm8_btn_add_mobile_cems').addClass('btn-warning');
//                            $('#hm8_btn_add_mobile_cems_txt').html('Continue Moible-CEMS');
//                        }
//                    }
//                });
        } else {
            $('#hm8_info_register').removeClass('hide');
        }        
    }
    
</script>