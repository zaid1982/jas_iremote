<?php

class Class_sql {
    
    private $prm_user_role = "select user_role.user_id AS user_id,group_concat(ref_role.role_desc order by ref_role.role_id ASC separator ', ') AS role_list from user_role left join ref_role on ref_role.role_id = user_role.role_id group by user_role.user_id";
    private $prm_user_type = "select user_type.user_id AS user_id,group_concat(ref_uType.uType_desc order by ref_uType.uType_id ASC separator ', ') AS userType_list from user_type left join ref_uType on ref_uType.uType_id = user_type.uType_id group by user_type.user_id";
    private $log_dir = '';

    function __construct()
    {
        $config = parse_ini_file('../library/config.ini');
        $this->log_dir = $config['log_dir'];
    }
    
    private function get_exception($codes, $function, $line, $msg) {
        if ($msg != '') {            
            $pos = strpos($msg,'-');
            if ($pos !== false)   
                $msg = substr($msg, $pos+2); 
            return "(ErrCode:".$codes.") [".__CLASS__.":".$function.":".$line."] - ".$msg;
        } else
            return "(ErrCode:".$codes.") [".__CLASS__.":".$function.":".$line."]";
    }
    
    public function get_sql ($title) {
        try {     
            if ($title == 'vw_user_basic') { 
                $sql = "select 
                    user.user_id AS user_id,
                    user_role.role_id AS role_id,
                    user.user_name AS user_name,
                    user.user_password AS user_password,
                    user.user_status AS user_status,
                    user.profile_id AS profile_id,
                    `profile`.profile_firstName AS profile_name 
                from user 
                left join `profile` on `profile`.profile_id = user.profile_id 
                left join user_role on user_role.user_id=user.user_id
                order by user_role.role_id";
            } else if ($title == 'vw_menu_list') {
                $sql = "SELECT 
                    user_menu.*,
                    ref_menu.menu_name AS menu_name,
                    ref_menu2nd.menu2nd_name AS menu2nd_name,
                    ref_menu3rd.menu3rd_name AS menu3rd_name
                FROM user_menu 
                INNER JOIN (
                    SELECT 
                        DISTINCT(role_menu.userMenu_id) AS userMenu_id
                    FROM role_menu 
                    LEFT JOIN user_role ON user_role.role_id = role_menu.role_id
                    LEFT JOIN user_type ON user_type.uType_id = role_menu.uType_id
                    WHERE (user_role.user_id = [user_id] OR user_type.user_id = [user_id])) role_menus ON role_menus.userMenu_id = user_menu.userMenu_id 
                INNER JOIN ref_menu ON ref_menu.menu_id = user_menu.menu_id 
                LEFT JOIN ref_menu2nd ON ref_menu2nd.menu2nd_id = user_menu.menu2nd_id
                LEFT JOIN ref_menu3rd ON ref_menu3rd.menu3rd_id = user_menu.menu3rd_id";      
            } else if ($title == 'vw_general_now') {
                $sql = "SELECT CONCAT(YEAR(TIMESTAMP(general_remark)) + 1, '-01-01 00:00:00') AS time_end, ref_general.*, NOW() AS time_now FROM ref_general";
            } else if ($title == 'dt_task_history') {
                $sql = "SELECT 
                    wf_task_type.wfTaskType_name AS wfTaskType_name,
                    ref_status.status_desc AS status_desc,
                    `profile`.profile_name AS claimed_by,
                    wf_task.wfTask_timeCreated AS wfTask_timeCreated,                      
                    wf_task.wfTask_dateExpired AS wfTask_dateExpired,
                    wf_task.wfTask_timeSubmitted AS wfTask_timeSubmitted, 
                    IF(DATEDIFF(DATE(wf_task.wfTask_timeSubmitted),DATE(wf_task.wfTask_dateExpired))>0,DATEDIFF(DATE(wf_task.wfTask_timeSubmitted),DATE(wf_task.wfTask_dateExpired)),0) AS day_late,
                    wf_task.wfTask_remark AS wfTask_remark,
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task.wfTrans_id AS wfTrans_id,
                    wf_task_type.wfTaskType_turn AS wfTaskType_turn,
                    wf_group.wfGroup_name AS wfGroup_name
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                LEFT JOIN `user` ON `user`.user_id = wf_task.wfTask_claimedBy
                LEFT JOIN `profile` ON `profile`.profile_id = `user`.profile_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_task.wfGroup_id
                LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                WHERE wf_task_type.wfTaskType_isEnd = 'N'";         
            } else if ($title == 'dt_task_history_info') {
                $sql = "SELECT 
                    wf_flow.wfFlow_module AS modul,
                    wf_flow.wfFlow_desc AS sub_modul,
                    wf_task_type.wfTaskType_name AS tugas_semasa,
                    `user`.user_fullname AS pengguna_semasa,
                    DATE(wf_task.wfTask_timeCreated) AS tarikh_terima,                      
                    wf_task.wfTask_dateExpired AS tarikh_akhir,
                    wf_task.wfTrans_id AS wfTrans_id,
                    wf_task.wfTask_id AS wfTask_id
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN `user` ON `user`.user_id = wf_task.wfTask_claimedBy 
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id";  
            } else if ($title == 'vw_email_send') {
                $sql = "SELECT 
                    email_send.emailSend_id AS emailSend_id,
                    email_send.emailType_id AS emailType_id,
                    IF(ISNULL(email_send.emailSend_email),`profile`.profile_email,email_send.emailSend_email) AS emailSend_email,
                    email_send.emailSend_to AS emailSend_to,
                    ref_email_type.emailType_desc AS emailType_desc,
                    ref_email_type.emailType_title AS emailType_title,
                    ref_email_type.emailType_text AS emailType_text,
                    ref_email_type.emailType_status AS emailType_status,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_icno AS profile_icno
                FROM email_send
                INNER JOIN ref_email_type ON ref_email_type.emailType_id = email_send.emailType_id
                LEFT JOIN `profile` ON `profile`.profile_id = email_send.emailSend_to 
                WHERE email_send.emailSend_status = 100 AND email_send.emailSend_timeSet < NOW()";
            } else if ($title == 'dt_task_type') {
                $sql = "SELECT 
                    wf_task.*, wf_task_type.wfTaskType_isEnd AS wfTaskType_isEnd
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id";
            } else if ($title == 'vw_ref_general') {
                $sql = "SELECT [id_name] AS ref_id, [desc_name] AS ref_desc, [status_name] AS [status_name] [extra_name] FROM [tablename]";
            } else if ($title == 'vw_ref_general_group') {
                $sql = "SELECT [desc_name] AS ref_id, [desc_name] AS ref_desc [extra_name] FROM [tablename] GROUP BY [desc_name] [extra_name]";
            } else if ($title == 'vw_opt_audit_action') {
                $sql = "SELECT auditAction_desc AS ref_id, auditAction_desc AS ref_desc FROM audit_action GROUP BY auditAction_desc";
            } else if ($title == 'vw_opt_delegate_to') {
                $sql = "SELECT 
                    `profile`.profile_name AS ref_desc,
                    wf_task_user.user_id AS ref_id,
                    wf_task_user.wfTaskType_id AS wfTaskType_id,
                    wf_task_user.wfGroup_id AS wfGroup_id
                FROM wf_task_user 
                LEFT JOIN `profile` ON `profile`.user_id = wf_task_user.user_id AND `profile`.profile_status = 1";
            } else if ($title == 'vw_opt_mobile_consultant') {
                $sql = "SELECT 
                    t_consultant.consultant_id AS ref_id,
                    wf_group.wfGroup_name AS ref_desc
                FROM t_consultant_mobile
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_mobile.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                WHERE t_consultant.consultant_status <> 19 [where_status] 
                GROUP BY ref_id";
            } else if ($title == 'vw_opt_cems_consultant') {
                $sql = "SELECT 
                    t_consultant.consultant_id AS ref_id,
                    wf_group.wfGroup_name AS ref_desc
                FROM t_consultant_cems
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_cems.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                WHERE t_consultant.consultant_status NOT IN (0,19) [where_status] 
                GROUP BY ref_id";
            } else if ($title == 'vw_opt_pems_consultant') {
                $sql = "SELECT 
                    t_consultant.consultant_id AS ref_id,
                    wf_group.wfGroup_name AS ref_desc
                FROM t_consultant_pems
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_pems.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                WHERE t_consultant.consultant_status NOT IN (0,19) [where_status] 
                GROUP BY ref_id";
            } else if ($title == 'vw_opt_industrial') {
                $sql = "SELECT 
                    t_industrial.industrial_id AS ref_id,
                    wf_group.wfGroup_name AS ref_desc,
                    ref_city.state_id, ref_state.state_code
                FROM t_industrial
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN location ON location.location_id = t_industrial.location_id
                LEFT JOIN ref_city ON ref_city.city_id = location.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                WHERE t_industrial.industrial_status IN (1,24)";
            } else if ($title == 'vw_opt_stack_complience') {
                $sql = "SELECT 
                    t_industrial_all.indAll_id AS ref_id,
                    t_industrial_all.indAll_stackNo AS ref_desc
                FROM t_industrial_all
                LEFT JOIN t_industrial_parameter ON t_industrial_parameter.indAll_id = t_industrial_all.indAll_id
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                WHERE t_industrial_all.industrial_id = [industrial_id] AND t_industrial_all.indAll_status IN (1,27,28,29,30) AND t_industrial_all.indAll_stackNo IS NOT NULL AND t_industrial_parameter.indParam_status = 1 
                AND t_pub.pub_id IS NOT NULL 
                GROUP BY ref_id";
            } else if ($title == 'vw_opt_parameter_to_be_excluded') {
                $sql = "SELECT 
                    t_industrial_parameter.pub_id AS ref_id,
                    t_input_parameter.inputParam_desc AS ref_desc,
                    t_industrial_parameter.indAll_id AS indAll_id
                FROM t_industrial_parameter
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id";
            } else if ($title == 'vw_address') {
                $sql = "SELECT 
                    CONCAT('&nbsp;&nbsp;&nbsp;&nbsp;',address_line1,'<br>&nbsp;&nbsp;&nbsp;&nbsp;',IFNULL(address_line2,''),IF(address_line2 IS NOT NULL,'<br>&nbsp;&nbsp;&nbsp;&nbsp;',''),IFNULL(address_line3,''),IF(address_line3 IS NOT NULL,'<br>&nbsp;&nbsp;&nbsp;&nbsp;',''),
                        address.address_postcode,'<br>&nbsp;&nbsp;&nbsp;&nbsp;',city_desc,'<br>&nbsp;&nbsp;&nbsp;&nbsp;',state_desc) AS full_address,
                    address.*,
                    ref_city.city_desc,
                    ref_state.state_id,
                    ref_state.state_desc
                FROM address 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id";
            } else if ($title == 'vw_get_date_diff') {  
                $sql = "SELECT '[date_in]' + INTERVAL [expression] AS date_out";    
            } else if ($title == 'dt_audit') {
                $sql = "SELECT 
                    audit.*,
                    user.user_name AS user_name,
                    profile.profile_name AS profile_name,
                    profile.profile_icNo AS profile_icNo,
                    vws_user_type.role_list AS role_list,
                    audit_module.auditModule_desc AS auditModule_desc,
                    audit_action.auditAction_desc AS auditAction_desc
                FROM audit
                LEFT JOIN user ON user.user_id = audit.user_id
                LEFT JOIN profile ON profile.profile_id = user.profile_id
                INNER JOIN (select user_type.user_id AS user_id,group_concat(ref_utype.uType_desc order by ref_utype.uType_id ASC separator ', ') AS role_list from user_type left join ref_utype on ref_utype.uType_id = user_type.uType_id group by user_type.user_id) vws_user_type ON vws_user_type.user_id = user.user_id
                LEFT JOIN audit_action ON audit_action.auditAction_id = audit.auditAction_id
                LEFT JOIN audit_module ON audit_module.auditModule_id = audit_action.auditAction_id";         
            } else if ($title == 'vw_menu_akses_list') {
                $sql = "SELECT 
                    user_menu.userMenu_turn,
                    ref_menu.menu_name AS menu_name,
                    ref_menu2nd.menu2nd_name AS menu2nd_name,
                    ref_menu3rd.menu3rd_name AS menu3rd_name, 
                    role_menu.uType_id AS uType_id,
                    user_menu.menu_id AS menu_id,
                    user_menu.menu2nd_id AS menu2nd_id,
                    user_menu.menu3rd_id AS menu3rd_id
                FROM role_menu
                INNER JOIN user_menu ON user_menu.userMenu_id = role_menu.userMenu_id
                LEFT JOIN ref_menu ON ref_menu.menu_id = user_menu.menu_id 
                LEFT JOIN ref_menu2nd ON ref_menu2nd.menu2nd_id = user_menu.menu2nd_id
                LEFT JOIN ref_menu3rd ON ref_menu3rd.menu3rd_id = user_menu.menu3rd_id";   
            } else if ($title == 'vw_get_current_utype') {
                $sql = "SELECT
                    user_type.user_id AS user_id,
                    ref_uType.uType_cate AS uType_cate
                FROM user_type 
                LEFT JOIN ref_uType ON ref_uType.uType_id = user_type.uType_id
                GROUP BY uType_cate, user_id";   
            } else if ($title == 'dt_user_mgmt') {  
                $sql = "SELECT     
                    `profile`.*,                           
                    ref_department.department_desc AS department_desc,
                    wf_group.wfGroup_name AS wfGroup_name,
                    vws_user_type.role_list AS role_list,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    IF(user.user_type=1,'Internal','Public') AS user_type
                FROM `user`
                LEFT JOIN `profile` ON `profile`.profile_id = `user`.profile_id
                INNER JOIN (select user_type.user_id AS user_id,group_concat(ref_utype.uType_desc order by ref_utype.uType_id ASC separator ', ') AS role_list from user_type left join ref_utype on ref_utype.uType_id = user_type.uType_id group by user_type.user_id) vws_user_type ON vws_user_type.user_id = `user`.user_id
                LEFT JOIN ref_status ON ref_status.status_id = `user`.user_status 
                LEFT JOIN wf_group_user ON wf_group_user.user_id = `user`.user_id AND wf_group_user.wfGroupUser_status = 1 AND wf_group_user.wfGroupUser_isMain = 1
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_group_user.wfGroup_id
                LEFT JOIN ref_department ON ref_department.department_id = wf_group_user.department_id";            
            } else if ($title == 'dt_ref_state') {  
                $sql = "SELECT ref_state.*, ref_status.status_desc, ref_status.status_color 
                FROM ref_state 
                LEFT JOIN ref_status ON ref_status.status_id = ref_state.state_status";
            } else if ($title == 'dt_ref_city') {  
                $sql = "SELECT ref_city.*, ref_state.state_desc, ref_status.status_desc, ref_status.status_color 
                FROM ref_city 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_status ON ref_status.status_id = ref_city.city_status";
            } else if ($title == 'dt_ref_department') {  
                $sql = "SELECT ref_department.*, ref_status.status_desc, ref_status.status_color  
                FROM ref_department 
                LEFT JOIN ref_status ON ref_status.status_id = ref_department.department_status";       
            } else if ($title == 'dt_ref_qnfCate') {  
                $sql = "SELECT t_qnf_category.*, ref_status.status_desc, ref_status.status_color  
                FROM t_qnf_category 
                LEFT JOIN ref_status ON ref_status.status_id = t_qnf_category.qnfCate_status";     
            } else if ($title == 'dt_ref_certIssuer') {  
                $sql = "SELECT t_certificate_issuer.*, ref_status.status_desc, ref_status.status_color  
                FROM t_certificate_issuer 
                LEFT JOIN ref_status ON ref_status.status_id = t_certificate_issuer.certIssuer_status";     
            } else if ($title == 'dt_ref_softwareMethod') {  
                $sql = "SELECT t_software_method.*, ref_status.status_desc, ref_status.status_color  
                FROM t_software_method 
                LEFT JOIN ref_status ON ref_status.status_id = t_software_method.softwareMethod_status";
            } else if ($title == 'dt_analyzer_technique') {
                $sql = "SELECT t_analyzer_technique.*, ref_status.status_desc, ref_status.status_color 
                FROM t_analyzer_technique 
                LEFT JOIN ref_status ON ref_status.status_id = t_analyzer_technique.analyzerTechnique_status";
            } else if ($title == 'dt_ref_cemsDesc') {  
                $sql = "SELECT document_name.*, ref_status.status_desc, ref_status.status_color  
                FROM document_name 
                LEFT JOIN ref_status ON ref_status.status_id = document_name.documentName_status
                WHERE documentName_type = 'cems'"; 
            } else if ($title == 'dt_ref_pemsDesc') {  
                $sql = "SELECT document_name.*, ref_status.status_desc, ref_status.status_color  
                FROM document_name 
                LEFT JOIN ref_status ON ref_status.status_id = document_name.documentName_status
                WHERE documentName_type = 'pems'";
            } else if ($title == 'dt_ref_mobile_technique') {
                $sql = "SELECT t_mobile_technique.*, ref_status.status_desc, ref_status.status_color 
                FROM t_mobile_technique 
                LEFT JOIN ref_status ON ref_status.status_id = t_mobile_technique.mobileTechnique_status";
            } else if ($title == 'dt_ref_mobile_cataloque') {
                $sql = "SELECT document_name.*, ref_status.status_desc, ref_status.status_color  
                FROM document_name 
                LEFT JOIN ref_status ON ref_status.status_id = document_name.documentName_status
                WHERE documentName_type = 'analyz_man'";
            } else if ($title == 'dt_document_name') {
                $sql = "SELECT document_name.*, ref_status.status_desc 
                FROM document_name 
                LEFT JOIN ref_status ON ref_status.status_id = document_name.documentName_status";
            } else if ($title == 'vw_profile') {  
                $sql = "SELECT 
                    `user`.user_id AS user_id, 
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_icNo AS profile_icNo,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    ref_department.department_desc AS department_desc,
                    ref_department.department_id AS department_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_id AS wfGroup_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    user_types.list_role AS list_role,
                    `user`.user_password AS user_password,
                    `user`.user_status AS user_status,
                    `user`.user_type AS user_type,
                    `user`.secQues_id AS secQues_id,
                    `user`.user_security_answer AS user_security_answer
                FROM `user` 
                INNER JOIN `profile` ON `user`.profile_id = `profile`.profile_id
                LEFT JOIN wf_group_user ON wf_group_user.user_id = `user`.user_id AND wf_group_user.wfGroupUser_status = 1 AND wf_group_user.wfGroupUser_isMain = 1
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_group_user.wfGroup_id
                LEFT JOIN ref_department ON ref_department.department_id = wf_group_user.department_id
                LEFT JOIN ( 
                    SELECT user_type.user_id AS user_id, GROUP_CONCAT(ref_utype.uType_desc ORDER BY user_type.uType_id SEPARATOR '\n') AS list_role 
                    FROM user_type 
                    LEFT JOIN ref_utype ON ref_utype.uType_id = user_type.uType_id 
                    GROUP BY user_id  				
                ) user_types ON user_types.user_id = `user`.user_id";
            } else if ($title == 'vw_join_status') {  
                $sql = "SELECT [table_name].*, ref_status.status_desc 
                FROM [table_name] 
                LEFT JOIN ref_status ON ref_status.status_id = [table_name].[status_name]";
            } else if ($title == 'vw_user_role') {  
                $sql = "SELECT user_role.*, ref_role.role_desc, ref_status.status_desc 
                FROM user_role 
                LEFT JOIN ref_role ON ref_role.role_id = user_role.role_id
                LEFT JOIN ref_status ON ref_status.status_id = user_role.userRole_status
                ORDER BY user_role.role_id";
            } else if ($title == 'vw_roles') { 
                $sql = "SELECT 
                    user_role.*, ref_role.role_desc, ref_status.status_desc
                FROM user_role
                LEFT JOIN ref_role ON ref_role.role_id = user_role.role_id
                LEFT JOIN ref_status ON ref_status.status_id = user_role.userRole_status";            
            } else if ($title == 'dt_task_comment') {
                $sql = "SELECT
                    wf_task.*,
                    wf_group.wfGroup_name AS wfGroup_name,
                    `profile`.profile_name AS profile_name
                FROM wf_task
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_task.wfGroup_id 
                LEFT JOIN `user` ON `user`.user_id = wf_task.wfTask_claimedBy 
                LEFT JOIN `profile` ON `profile`.profile_id = `user`.profile_id
                WHERE wfTask_remark IS NOT NULL AND wf_task.wfTask_claimedBy IS NOT NULL 
                ORDER BY wfTask_id";            
            } else if ($title == 'dt_track_monitoring') {
                $sql = "SELECT 
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_flow.wfFlow_id AS wfFlow_id,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    wf_task_type.wfTaskType_name AS wfTaskType_name,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    `profile`.profile_name AS profile_name,
                    wf_transaction.wfTrans_timeCreated AS wfTrans_timeCreated,
                    wf_transaction.wfTrans_dateDue AS wfTrans_dateDue,
                    wf_task_type.uType_id AS uType_ids,
                    wf_task.*
                FROM wf_transaction 
                LEFT JOIN wf_task ON wf_task.wfTrans_id = wf_transaction.wfTrans_id AND wf_task.wfTask_partition = 1 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id 
                LEFT JOIN ref_status ON ref_status.status_id = wf_transaction.wfTrans_status
                LEFT JOIN `profile` ON `profile`.user_id = wf_transaction.wfTrans_processOfficer AND `profile`.profile_status = 1
                WHERE wf_transaction.wfTrans_status NOT IN (2,8)";            
            } else if ($title == 'vw_user_types') {  
                $sql = "SELECT 
                    user_type.user_id AS user_id,
                    group_concat(ref_utype.uType_desc ORDER BY ref_utype.uType_id ASC SEPARATOR ', ') AS role_list 
                FROM user_type 
                LEFT JOIN ref_utype ON ref_utype.uType_id = user_type.uType_id 
                GROUP BY user_type.user_id";
            } else if ($title == 'dt_list_to_delegate') { 
                $sql = "SELECT 
                    wf_task_type.wfTaskType_name AS wfTaskType_name,
                    ref_utype.uType_desc AS uType_desc,
                    wf_task.*
                FROM wf_task
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN ref_utype ON ref_utype.uType_id = wf_task_type.uType_id
                WHERE wf_task.wfTask_partition = 1 AND wfTask_timeClaimed IS NOT NULL AND wf_task_type.uType_id IN (2,3)";
            } else if ($title == 'vw_consultant_info') {
                $sql = "SELECT 
                    wf_group.*,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    address.city_id AS city_id,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    address_m.city_id AS mcity_id,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    t_consultant.consultant_dateIncorporate AS consultant_dateIncorporate,
                    t_consultant.consultant_id AS consultant_id,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website,
                    wf_group_profile.wfGroup_address_same AS wfGroup_address_same,
                    ref_city.state_id AS state_id,
                    ref_city_m.state_id AS mstate_id
                FROM wf_group_user
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_group_user.wfGroup_id 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                INNER JOIN t_consultant ON t_consultant.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address_m.city_id
                WHERE wf_group_user.wfGroupUser_isMain = 1 AND wf_group_user.user_id = [user_id] AND wf_group_user.wfGroup_id = [wfGroup_id]";
            } else if ($title == 'vw_consultant_info_view') {
                $sql = "SELECT 
                    wf_group.*,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    ref_state.state_desc AS state_desc,
                    ref_city.city_desc AS city_desc,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    ref_state_m.state_desc AS mstate_desc,
                    ref_city_m.city_desc AS mcity_desc,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    t_consultant.consultant_dateIncorporate AS consultant_dateIncorporate,
                    t_consultant.consultant_id AS consultant_id,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website
                FROM t_consultant
                LEFT JOIN wf_group ON t_consultant.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address.city_id
                LEFT JOIN `profile` ON `profile`.user_id = t_consultant.consultant_createdBy AND `profile`.profile_status = 1 
                LEFT JOIN wf_group_user ON wf_group_user.user_id = t_consultant.consultant_createdBy AND wf_group_user.wfGroupUser_isMain = 1
                    AND wf_group_user.wfGroupUser_status = 1 AND wf_group_user.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_state ref_state_m ON ref_state_m.state_id = ref_city_m.state_id";
            } else if ($title == 'vw_consultant_cems_details') {
                $sql = "SELECT
                    t_consultant_cems.*,
                    wf_group.wfGroup_id AS wfGroup_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    ref_state.state_desc AS state_desc,
                    ref_city.city_desc AS city_desc,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    ref_state_m.state_desc AS mstate_desc,
                    ref_city_m.city_desc AS mcity_desc,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    `profile`.profile_name AS decl_profile_name,
                    `profile`.profile_icNo AS decl_profile_icNo,
                    t_consultant.consultant_dateIncorporate AS consultant_dateIncorporate,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroupProfile_id AS wfGroupProfile_id,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website,
                    wf_group_user.wfGroupUser_designation AS decl_wfGroupUser_designation,
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task.wfTaskType_id AS wfTaskType_id,
                    wf_task.wfTask_status AS wfTask_status,
                    wf_task.wfTask_remark AS wfTask_remark,
                    t_dis.dis_name AS dis_name,
                    t_dis.dis_type AS dis_type,
                    t_dis.dis_outsource AS dis_outsource,
                    t_dis.dis_description AS dis_description,
                    t_das.das_probeSoftware AS das_probeSoftware,
                    t_das.das_probeDesc AS das_probeDesc,
                    t_das.das_analyzerSoftware AS das_analyzerSoftware,
                    t_das.das_analyzerDesc AS das_analyzerDesc,
                    t_consultant_all.consAll_remark AS consAll_remark,
                    CASE WHEN t_consultant_all.consAll_dateDeclaration IS NULL THEN CURDATE() ELSE t_consultant_all.consAll_dateDeclaration END AS consAll_dateDeclaration,
                    ref_status.status_desc AS status_desc
                FROM t_consultant_cems
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_consultant_cems.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_cems.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN wf_group_user ON wf_group_user.user_id = t_consultant_cems.consCems_contactPerson AND wf_group_user.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = t_consultant_all.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address_m.city_id
                LEFT JOIN ref_state ref_state_m ON ref_state_m.state_id = ref_city_m.state_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_consultant_cems.wfTrans_id AND wfTask_partition = 1
                LEFT JOIN t_das ON t_das.das_id = t_consultant_cems.das_id
                LEFT JOIN t_dis ON t_dis.dis_id = t_consultant_cems.dis_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_cems.consCems_status";
            } else if ($title == 'vw_consultant_doc') {
                $sql = "SELECT 
                    document.*,
                    t_consultant_doc.consAll_id AS param_id
                FROM t_consultant_doc 
                LEFT JOIN document ON document.document_id = t_consultant_doc.document_id
                WHERE t_consultant_doc.consDoc_status = 1";
            } else if ($title == 'dt_consultant_doc') {
                $sql = "SELECT 
                    document.*,
                    document_name.documentName_desc AS documentName_desc,
                    document_name.documentName_type AS documentName_type,
                    t_consultant_doc.consDoc_id AS consDoc_id,
                    t_consultant_doc.consAll_id AS consAll_id,
                    t_consultant_doc.consDoc_status AS consDoc_status
                FROM t_consultant_doc 
                LEFT JOIN document ON document.document_id = t_consultant_doc.document_id
                LEFT JOIN document_name ON document_name.documentName_id = document.documentName_id
                WHERE consDoc_status <> 8";
            } else if ($title == 'dt_consultant_docSupport') {
                $sql = "SELECT 
                    document.*,
                    document_name.documentName_desc AS documentName_desc,
                    document_name.documentName_type AS documentName_type,
                    t_consultant_docSupport.consultantDoc_id AS consultantDoc_id,
                    t_consultant_docSupport.consultant_id AS consultant_id,
                    t_consultant_docSupport.consultantDoc_status AS consultantDoc_status
                FROM t_consultant_docSupport 
                LEFT JOIN document ON document.document_id = t_consultant_docSupport.document_id
                LEFT JOIN document_name ON document_name.documentName_id = document.documentName_id
                WHERE consultantDoc_status <> 8";
            } else if ($title == 'dt_certificate') {
                $sql = "SELECT 
                    t_certificate.*,
		GROUP_CONCAT(t_certificate_basic.certBasic_desc SEPARATOR ', ') AS certBasic_desc,
                    t_certificate_issuer.certIssuer_desc AS certIssuer_desc,
                    document.document_name AS document_name
                FROM t_certificate 
                LEFT JOIN t_certificate_issuer ON t_certificate_issuer.certIssuer_id = t_certificate.certIssuer_id
                LEFT JOIN t_certificate_basic_list ON t_certificate_basic_list.certificate_id = t_certificate.certificate_id
                LEFT JOIN t_certificate_basic ON t_certificate_basic.certBasic_id = t_certificate_basic_list.certBasic_id
                LEFT JOIN document ON document.document_id = t_certificate.document_id
                WHERE t_certificate.certificate_status IN (1,2)
                GROUP BY certificate_id";
            } else if ($title == 'dt_consultant_parameter') {
                $sql = "SELECT 
                    t_consultant_parameter.*,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    GROUP_CONCAT(DISTINCT(CONCAT(consParamRange_from, ' - ', consParamRange_to)) SEPARATOR ',</br>') AS parameter_range,
                    GROUP_CONCAT(DISTINCT(CONCAT(consParamMeasure_from, ' - ', consParamMeasure_to)) SEPARATOR ',</br>') AS measurement_range,
                    GROUP_CONCAT(DISTINCT(CONCAT(analyzerTechnique_desc)) SEPARATOR ', ') AS consParam_methodDetection
                FROM t_consultant_parameter 
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_consultant_parameter.inputParam_id
                LEFT JOIN t_consultant_param_range ON t_consultant_param_range.consParam_id = t_consultant_parameter.consParam_id
                LEFT JOIN t_consultant_param_measure ON t_consultant_param_measure.consParam_id = t_consultant_param_measure.consParam_id
                LEFT JOIN t_consultant_param_method ON t_consultant_param_method.consParam_id = t_consultant_parameter.consParam_id
                LEFT JOIN t_analyzer_technique ON t_analyzer_technique.analyzerTechnique_id = t_consultant_param_method.analyzerTechnique_id
                GROUP BY consParam_id";
            } else if ($title == 'dt_consultant_personnel') {
                $sql = "SELECT 
                    t_consultant_personnel.*,
                    t_personnel.personnel_icNo AS personnel_icNo,
                    t_personnel.personnel_citizenship AS personnel_citizenship,
                    document.document_name AS document_name
                FROM t_consultant_personnel 
                LEFT JOIN t_personnel ON t_personnel.personnel_id = t_consultant_personnel.personnel_id
                LEFT JOIN document ON document.document_id = t_consultant_personnel.consPers_document";
            } else if ($title == 'dt_consultant_cems_cons') {
                $sql = "SELECT 
                    t_consultant_cems.*,
                    t_consultant.wfGroup_id AS wfGroup_id,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    cons_type.consType_type AS consType_type,
                    CONCAT(IF(consCems_isInstall=1,'Installation',''), IF(consCems_isInstall=1 AND consCems_isMaintain=1,' and ',''), IF(consCems_isMaintain=1,'Maintenance','')) AS cons_type,
                    wf_transaction.wfTrans_timeSubmit AS wfTrans_timeSubmit,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    wf_task.wfTask_id AS wfTask_id
                FROM t_consultant_cems
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_cems.consultant_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_consultant_cems.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_consultant_cems.wfTrans_id
                LEFT JOIN (
                    SELECT 
                        consAll_id,
                        GROUP_CONCAT(
                            CASE WHEN consType_type = 1 THEN 'Gas  Analyzer'
                                WHEN consType_type = 2 THEN 'Dust Monitor'
                                WHEN consType_type = 3 THEN 'Opacity Meter' 
                            END
                        SEPARATOR ', ') AS consType_type
                    FROM t_consultant_type 
                    GROUP BY consAll_id
                ) AS cons_type ON cons_type.consAll_id = t_consultant_cems.consAll_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_cems.consCems_status
                WHERE t_consultant_cems.consCems_status <> 8";
            } else if ($title == 'dt_consultant_pems_cons') {   
                $sql = "SELECT 
                    t_consultant_pems.*,
                    t_consultant.wfGroup_id AS wfGroup_id,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    CONCAT(IF(consPems_isInstall=1,'Installation',''), IF(consPems_isInstall=1 AND consPems_isMaintain=1,' and ',''), IF(consPems_isMaintain=1,'Maintenance','')) AS cons_type,
                    t_software_method.softwareMethod_desc AS softwareMethod_desc,
                    wf_transaction.wfTrans_timeSubmit AS wfTrans_timeSubmit,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    wf_task.wfTask_id AS wfTask_id
                FROM t_consultant_pems
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_pems.consultant_id
                LEFT JOIN t_software_method ON t_software_method.softwareMethod_id = t_consultant_pems.softwareMethod_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_consultant_pems.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_consultant_pems.wfTrans_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_pems.consPems_status
                WHERE t_consultant_pems.consPems_status <> 8";
             } else if ($title == 'dt_consultant_mobile_cons') {   
                $sql = "SELECT 
                    t_consultant_mobile.*,
                    t_consultant.wfGroup_id AS wfGroup_id,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_transaction.wfTrans_timeSubmit AS wfTrans_timeSubmit,
                    cons_type.consType_type AS consType_type,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    wf_task.wfTask_id AS wfTask_id
                FROM t_consultant_mobile
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_mobile.consultant_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_consultant_mobile.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_consultant_mobile.wfTrans_id
                LEFT JOIN (
                    SELECT 
                        consAll_id,
                        GROUP_CONCAT(
                            CASE WHEN consType_type = 1 THEN 'Gas  Analyzer'
                                WHEN consType_type = 2 THEN 'Dust Monitor'
                                WHEN consType_type = 3 THEN 'Opacity Meter' 
                            END
                        SEPARATOR ', ') AS consType_type
                    FROM t_consultant_type 
                    GROUP BY consAll_id
                ) AS cons_type ON cons_type.consAll_id = t_consultant_mobile.consAll_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_mobile.consMobile_status
                WHERE t_consultant_mobile.consMobile_status <> 8";
            } else if ($title == 'vw_consultant_pems_details') {
                $sql = "SELECT
                    t_consultant_pems.*,
                    wf_group.wfGroup_id AS wfGroup_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    ref_state.state_desc AS state_desc,
                    ref_city.city_desc AS city_desc,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    ref_state_m.state_desc AS mstate_desc,
                    ref_city_m.city_desc AS mcity_desc,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    `profile`.profile_name AS decl_profile_name,
                    `profile`.profile_icNo AS decl_profile_icNo,
                    t_consultant.consultant_dateIncorporate AS consultant_dateIncorporate,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroupProfile_id AS wfGroupProfile_id,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website,
                    wf_group_user.wfGroupUser_designation AS decl_wfGroupUser_designation,
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task.wfTaskType_id AS wfTaskType_id,
                    wf_task.wfTask_status AS wfTask_status,
                    wf_task.wfTask_remark AS wfTask_remark,
                    t_dis.dis_name AS dis_name,
                    t_dis.dis_type AS dis_type,
                    t_dis.dis_outsource AS dis_outsource,
                    t_dis.dis_description AS dis_description,
                    t_das.das_probeSoftware AS das_probeSoftware,
                    t_das.das_probeDesc AS das_probeDesc,
                    t_das.das_analyzerSoftware AS das_analyzerSoftware,
                    t_das.das_analyzerDesc AS das_analyzerDesc,
                    t_consultant_all.consAll_remark AS consAll_remark,
                    CASE WHEN t_consultant_all.consAll_dateDeclaration IS NULL THEN CURDATE() ELSE t_consultant_all.consAll_dateDeclaration END AS consAll_dateDeclaration,
                    ref_status.status_desc AS status_desc
                FROM t_consultant_pems
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_consultant_pems.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_pems.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN wf_group_user ON wf_group_user.user_id = t_consultant_pems.consPems_contactPerson AND wf_group_user.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = t_consultant_all.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address_m.city_id
                LEFT JOIN ref_state ref_state_m ON ref_state_m.state_id = ref_city_m.state_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_consultant_pems.wfTrans_id AND wfTask_partition = 1
                LEFT JOIN t_das ON t_das.das_id = t_consultant_pems.das_id
                LEFT JOIN t_dis ON t_dis.dis_id = t_consultant_pems.dis_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_pems.consPems_status";
            } else if ($title == 'dt_task_consultant') {
                $sql = "SELECT
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,	
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    CASE WHEN wf_flow.wfFlow_id = 1 THEN 
                        CONCAT(IF(consCems_isInstall=1,'Installation',''), IF(consCems_isInstall=1 AND consCems_isMaintain=1,' and ',''), IF(consCems_isMaintain=1,'Maintenance','')) 
                    WHEN wf_flow.wfFlow_id = 2 THEN
                        CONCAT(IF(consPems_isInstall=1,'Installation',''), IF(consPems_isInstall=1 AND consPems_isMaintain=1,' and ',''), IF(consPems_isMaintain=1,'Maintenance',''))
                    END AS cons_type,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    wf_flow.wfFlow_id AS wfFlow_id,
                    profile.profile_name AS profile_name,
                    ref_status_previous.status_desc AS status_previous,
                    ref_status_previous.status_color AS status_previous_color,
                    wf_task.*
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task_type.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                LEFT JOIN profile ON profile.user_id = wf_transaction.wfTrans_processOfficer AND profile.profile_status = 1 
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.wfTrans_id = wf_transaction.wfTrans_id 
                LEFT JOIN t_consultant_pems ON t_consultant_pems.wfTrans_id = wf_transaction.wfTrans_id 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr 
                LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                LEFT JOIN ref_status ref_status_previous ON ref_status_previous.status_id = wf_task.wfTask_statusPrevious";
            } else if ($title == 'vw_task_info') {
                $sql = "SELECT 
                    wf_task.*,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,
                    wf_flow.wfFlow_id AS wfFlow_id,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    cur_task.status_desc AS status_desc,
                    cur_task.current_status AS current_status,
                    cur_task.wfTaskType_turn AS wfTaskType_turn,
                    cur_task.wfTaskType_statusName AS wfTaskType_statusName,
                    wf_transaction.wfTrans_dateDue AS wfTrans_dateDue,
                    wf_transaction.wfTrans_hardCopy,
                    wf_transaction.wfTrans_hardCopy_receiver,
                    wf_transaction.wfTrans_hardCopy_remark                    
                FROM wf_task 
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_transaction.wfFlow_id 
                LEFT JOIN 
                (
                    SELECT 	
                        wfTrans_id, 
                        IF(wf_task_type.wfTaskType_isEnd='Y',ref_status.status_desc,wf_task_type.wfTaskType_name) AS current_status,
                        IF(wf_task_type.wfTaskType_isEnd='Y',0,wfTaskType_turn) AS wfTaskType_turn,
                        wf_task_type.wfTaskType_statusName AS wfTaskType_statusName,
                        ref_status.status_desc
                    FROM wf_task 		
                    LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                    LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                    WHERE wfTask_partition = 1
                ) cur_task ON cur_task.wfTrans_id = wf_transaction.wfTrans_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr";
            } else if ($title == 'dt_consultant_list') {
                $sql = "SELECT
                    wf_group.*,
                    t_consultant_alls.cons_type AS cons_type,
                    t_consultant_alls.totals AS totals,
                    ref_city.city_desc AS city_desc,
                    ref_state.state_desc AS state_desc,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    t_consultant.consultant_id AS consultant_id
                FROM t_consultant
                LEFT JOIN 
                    (SELECT
                        consultant_id, 
                        GROUP_CONCAT(DISTINCT 
                            CASE 
                                WHEN consAll_type = 1 THEN 'CEMS' 
                                WHEN consAll_type = 2 THEN 'PEMS' 
                                WHEN consAll_type = 3 THEN 'Mobile-CEMS' 
                            END
                        ORDER BY consAll_type ASC SEPARATOR ', ') AS cons_type,
                        COUNT(*) AS totals
                    FROM t_consultant_all 
                    WHERE t_consultant_all.consAll_status = 1
                    GROUP BY consultant_id) t_consultant_alls ON t_consultant_alls.consultant_id = t_consultant.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id 
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant.consultant_status";
            } else if ($title == 'dt_analyzer') {
                $sql = "SELECT 
                    t_consultant_cems.*,
                    t_consultant.wfGroup_id AS wfGroup_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    CONCAT(IF(consCems_isInstall=1,'Installation',''), IF(consCems_isInstall=1 AND consCems_isMaintain=1,' and ',''), IF(consCems_isMaintain=1,'Maintenance','')) AS cons_type,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color
                FROM t_consultant_cems
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_cems.consultant_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_cems.consCems_status
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id";
            } else if ($title == 'dt_software') {
                $sql = "SELECT 
                    t_consultant_pems.*,
                    t_consultant.wfGroup_id AS wfGroup_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    CONCAT(IF(consPems_isInstall=1,'Installation',''), IF(consPems_isInstall=1 AND consPems_isMaintain=1,' and ',''), IF(consPems_isMaintain=1,'Maintenance','')) AS cons_type,
                    t_software_method.softwareMethod_desc AS softwareMethod_desc,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color
                FROM t_consultant_pems
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_pems.consultant_id
                LEFT JOIN t_software_method ON t_software_method.softwareMethod_id = t_consultant_pems.softwareMethod_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_pems.consPems_status
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id";
            } else if ($title == 'vw_city_state') {
                $sql = "SELECT ref_city.*, ref_state.state_desc, ref_state.state_code 
                    FROM ref_city
                INNER JOIN ref_state ON ref_state.state_id = ref_city.state_id";
            } else if ($title == 'vw_sic_sub') {
                $sql = "SELECT ref_sub_sic.*, ref_sic.sic_desc, ref_sic.sic_code 
                    FROM ref_sub_sic
                INNER JOIN ref_sic ON ref_sic.sic_id = ref_sub_sic.sic_id";
            } else if ($title == 'vw_parlimen_state') {
                $sql = "SELECT ref_parlimen.*, ref_state.state_desc, ref_state.state_code, CONCAT(parlimen_code, ' ', parlimen_desc) AS parlimen_view 
                    FROM ref_parlimen
                INNER JOIN ref_state ON ref_state.state_id = ref_parlimen.state_id";
            } else if ($title == 'vw_industrial_info') {
                $sql = "SELECT 
                    wf_group.*,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    address.city_id AS city_id,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    address_m.city_id AS mcity_id,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    t_industrial.industrial_id AS industrial_id,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    t_industrial.industrial_premiseId AS industrial_premiseId,
                    t_industrial.industrial_branch AS industrial_branch,
                    t_industrial.parlimen_id AS parlimen_id,
                    t_industrial.industrial_totalStack AS industrial_totalStack,
                    location.location_longitude AS location_longitude,
                    location.location_latitude AS location_latitude,
                    ref_sub_sic.subSic_id AS subSic_id,
                    ref_sub_sic.sic_id AS sic_id,
                    ref_sic.sic_desc AS sic_desc,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website,
                    wf_group_profile.wfGroup_address_same AS wfGroup_address_same,
                    ref_city.state_id AS state_id,
                    ref_city_m.state_id AS mstate_id
                FROM wf_group_user
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_group_user.wfGroup_id 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                INNER JOIN t_industrial ON t_industrial.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address_m.city_id
                LEFT JOIN location ON location.location_id = t_industrial.location_id
                LEFT JOIN ref_sub_sic ON ref_sub_sic.subSic_id = t_industrial.subSic_id                
                LEFT JOIN ref_sic ON ref_sic.sic_id = ref_sub_sic.sic_id                
                WHERE wf_group_user.wfGroupUser_isMain = 1 AND wf_group_user.user_id = [user_id] AND wf_group_user.wfGroup_id = [wfGroup_id]";
            } else if ($title == 'dt_industrial_list') {
                $sql = "SELECT
                    wf_group.*,
                    ref_city.city_desc AS city_desc,
                    ref_state.state_desc AS state_desc,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    t_industrial.industrial_id AS industrial_id,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    t_industrial.industrial_premiseId AS industrial_premiseId,
                    t_industrial.industrial_totalStack AS industrial_totalStack                   
                FROM t_industrial
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id 
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_status ON ref_status.status_id = t_industrial.industrial_status";
            } else if ($title == 'vw_industrial_info_view') {
                $sql = "SELECT 
                    wf_group.*,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    ref_state.state_desc AS state_desc,
                    ref_city.city_desc AS city_desc,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    ref_state_m.state_desc AS mstate_desc,
                    ref_city_m.city_desc AS mcity_desc,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    t_industrial.industrial_id AS industrial_id,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    t_industrial.industrial_premiseId AS industrial_premiseId,
                    t_industrial.industrial_totalStack AS industrial_totalStack,
                    location.location_longitude AS location_longitude,
                    location.location_latitude AS location_latitude,
                    ref_sub_sic.subSic_desc AS subSic_desc,
                    ref_sic.sic_desc AS sic_desc,
                    ref_parlimen.parlimen_desc AS parlimen_desc,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website
                FROM t_industrial
                LEFT JOIN wf_group ON t_industrial.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address.city_id
                LEFT JOIN `profile` ON `profile`.user_id = t_industrial.industrial_createdBy AND `profile`.profile_status = 1 
                LEFT JOIN wf_group_user ON wf_group_user.user_id = t_industrial.industrial_createdBy AND wf_group_user.wfGroupUser_isMain = 1
                    AND wf_group_user.wfGroupUser_status = 1 AND wf_group_user.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_state ref_state_m ON ref_state_m.state_id = ref_city_m.state_id
                LEFT JOIN location ON location.location_id = t_industrial.location_id
                LEFT JOIN ref_sub_sic ON ref_sub_sic.subSic_id = t_industrial.subSic_id                
                LEFT JOIN ref_sic ON ref_sic.sic_id = ref_sub_sic.sic_id  
                LEFT JOIN ref_parlimen ON ref_parlimen.parlimen_id = t_industrial.parlimen_id";
            } else if ($title == 'vw_pub_group_inputParam') {
                $sql = "SELECT
                    t_pub.inputParam_id AS inputParam_id,
                    t_input_parameter.inputParam_desc AS inputParam_desc
                FROM t_pub
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id 
                WHERE t_input_parameter.inputParam_type IN (0[arr_inputParam_type]) AND sourceActivity_id in (0[arr_sourceActivity_id]) AND pub_status = 1 AND inputParam_status = 1
                GROUP BY inputParam_id";
            } else if ($title == 'vw_consultant_docs') {
                $sql = "SELECT
                    t_consultant_doc.*,
                    document.document_uplname AS document_uplname
                FROM t_consultant_doc
                LEFT JOIN document ON document.document_id = t_consultant_doc.document_id";
            } else if ($title == 'vw_consultant_email_batch') {
                $sql = "SELECT 
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task_type.wfTaskType_id AS wfTaskType_id,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    t_consultant_all.consAll_id AS consAll_id,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,
                    `profile`.profile_email AS profile_email,
                    `profile`.profile_name AS profile_name
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_consultant_all ON t_consultant_all.wfTrans_id = wf_transaction.wfTrans_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN wf_group_user ON wf_group_user.wfGroup_id = wf_group.wfGroup_id AND wf_group_user.wfGroupUser_status = 1
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1
                WHERE wfTask_partition = 1";            
            } else if ($title == 'vw_industry_email_batch') {
                $sql = "SELECT 
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task_type.wfTaskType_id AS wfTaskType_id,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    t_industrial_all.indAll_id AS indAll_id,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    `profile`.profile_email AS profile_email,
                    `profile`.profile_name AS profile_name
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_industrial_all ON t_industrial_all.wfTrans_id = wf_transaction.wfTrans_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_group_user ON wf_group_user.wfGroup_id = wf_group.wfGroup_id AND wf_group_user.wfGroupUser_status = 1
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1
                WHERE wfTask_partition = 1";
            } else if ($title == 'vw_wfGroup_consultant') {
                $sql = "SELECT
                    wf_group.*, 
                    t_consultant_all.wfTrans_id AS wfTrans_id,
                    t_consultant.consultant_status AS consultant_status
                FROM t_consultant_all 
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id";
            } else if ($title == 'vw_checklist_task') {
                $sql = "SELECT 
                    t_checklist_task.*, 
                    t_checklist.checklist_section AS checklist_section,
                    t_checklist.checklist_desc AS checklist_desc,
                    t_checklist.checklist_status AS checklist_status
                FROM t_checklist_task 
                LEFT JOIN t_checklist ON t_checklist.checklist_id = t_checklist_task.checklist_id";
            } else if ($title == 'vw_consultant_mobile_details') {
                $sql = "SELECT
                    t_consultant_mobile.*,
                    t_consultant_mobile.mobileTechnique_id AS consMobile_techniqueType,
                    wf_group.wfGroup_id AS wfGroup_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    ref_state.state_desc AS state_desc,
                    ref_city.city_desc AS city_desc,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    ref_state_m.state_desc AS mstate_desc,
                    ref_city_m.city_desc AS mcity_desc,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    `profile`.profile_name AS decl_profile_name,
                    `profile`.profile_icNo AS decl_profile_icNo,
                    t_consultant.consultant_dateIncorporate AS consultant_dateIncorporate,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroupProfile_id AS wfGroupProfile_id,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website,
                    wf_group_user.wfGroupUser_designation AS decl_wfGroupUser_designation,
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task.wfTaskType_id AS wfTaskType_id,
                    wf_task.wfTask_status AS wfTask_status,
                    wf_task.wfTask_remark AS wfTask_remark,
                    t_dis.dis_name AS dis_name,
                    t_dis.dis_type AS dis_type,
                    t_dis.dis_outsource AS dis_outsource,
                    t_dis.dis_description AS dis_description,
                    t_das.das_probeSoftware AS das_probeSoftware,
                    t_das.das_probeDesc AS das_probeDesc,
                    t_das.das_analyzerSoftware AS das_analyzerSoftware,
                    t_das.das_analyzerDesc AS das_analyzerDesc,
                    t_consultant_all.consAll_remark AS consAll_remark,
                    CASE WHEN t_consultant_all.consAll_dateDeclaration IS NULL THEN CURDATE() ELSE t_consultant_all.consAll_dateDeclaration END AS consAll_dateDeclaration,
                    ref_status.status_desc AS status_desc
                FROM t_consultant_mobile
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_consultant_mobile.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_mobile.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN wf_group_user ON wf_group_user.user_id = t_consultant_mobile.consMobile_contactPerson AND wf_group_user.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = t_consultant_all.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address_m.city_id
                LEFT JOIN ref_state ref_state_m ON ref_state_m.state_id = ref_city_m.state_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_consultant_mobile.wfTrans_id AND wfTask_partition = 1
                LEFT JOIN t_das ON t_das.das_id = t_consultant_mobile.das_id
                LEFT JOIN t_dis ON t_dis.dis_id = t_consultant_mobile.dis_id
                LEFT JOIN ref_status ON ref_status.status_id = t_consultant_mobile.consMobile_status";
            } else if ($title == 'dt_industrial_all') {
                $sql = "SELECT 
                    t_industrial_all.*,
                    t_industrial.wfGroup_id AS wfGroup_id,
                    t_source_activity.sourceActivity_desc AS sourceActivity_desc,
                    wf_group_consultant.wfGroup_name AS consultant_name,
                    t_consultant_cems.consCems_modelNo AS consCems_modelNo,
                    t_consultant_pems.consPems_model AS consPems_model,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_transaction.wfTrans_timeSubmit AS wfTrans_timeSubmit,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    wf_task.wfTask_id AS wfTask_id
                FROM t_industrial_all
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_industrial_all.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN ref_status ON ref_status.status_id = t_industrial_all.indAll_status
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_industrial_all.consultant_id
                LEFT JOIN wf_group wf_group_consultant ON wf_group_consultant.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_consultant_pems ON t_consultant_pems.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_source_activity ON t_source_activity.sourceActivity_id = t_industrial_all.sourceActivity_id
                WHERE t_industrial_all.indAll_status <> 8";
            } else if ($title == 'vw_installation_all_details') {
                $sql = "SELECT
                    t_industrial_all.*,
                    wf_group.wfGroup_id AS wfGroup_id,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    t_industrial.industrial_premiseId AS industrial_premiseId,                    
                    t_industrial.industrial_totalStack AS industrial_totalStack, 
                    ref_sic.sic_desc AS sic_desc,
                    ref_sub_sic.subSic_desc AS subSic_desc,
                    ref_parlimen.parlimen_desc AS parlimen_desc,
                    location.location_longitude AS location_longitude,
                    location.location_latitude AS location_latitude,
                    address.address_id AS address_id,
                    address.address_line1 AS address_line1,
                    address.address_postcode AS address_postcode,
                    ref_state.state_desc AS state_desc,
                    ref_city.city_desc AS city_desc,
                    address_m.address_id AS maddress_id,
                    address_m.address_line1 AS maddress_line1,
                    address_m.address_postcode AS maddress_postcode,
                    ref_state_m.state_desc AS mstate_desc,
                    ref_city_m.city_desc AS mcity_desc,
                    `profile`.profile_name AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    `profile`.profile_name AS decl_profile_name,
                    `profile`.profile_icNo AS decl_profile_icNo,
                    wf_group_user.user_id AS user_id,
                    wf_group_user.wfGroupUser_designation AS wfGroupUser_designation,
                    wf_group_profile.wfGroup_phoneNo AS wfGroup_phoneNo,
                    wf_group_profile.wfGroup_faxNo AS wfGroup_faxNo,
                    wf_group_profile.wfGroup_website AS wfGroup_website,
                    wf_group_user.wfGroupUser_designation AS decl_wfGroupUser_designation,
                    wf_task.wfTask_id AS wfTask_id,
                    wf_task.wfTaskType_id AS wfTaskType_id,
                    wf_task.wfTask_status AS wfTask_status,
                    wf_task.wfTask_remark AS wfTask_remark,
                    CASE WHEN t_industrial_all.indAll_dateDeclaration IS NULL THEN CURDATE() ELSE t_industrial_all.indAll_dateDeclaration END AS indAll_dateDeclarations,
                    ref_status.status_desc AS status_desc
                FROM t_industrial_all 
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_group_user ON wf_group_user.user_id = t_industrial_all.indAll_contactPerson AND wf_group_user.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN `profile` ON `profile`.user_id = wf_group_user.user_id AND `profile`.profile_status = 1 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = t_industrial_all.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address 
                LEFT JOIN address address_m ON address_m.address_id = wf_group_profile.wfGroup_address_mail 
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_city ref_city_m ON ref_city_m.city_id = address_m.city_id
                LEFT JOIN ref_state ref_state_m ON ref_state_m.state_id = ref_city_m.state_id
                LEFT JOIN location ON location.location_id = t_industrial.location_id
                LEFT JOIN ref_sub_sic ON ref_sub_sic.subSic_id = t_industrial.subSic_id                
                LEFT JOIN ref_sic ON ref_sic.sic_id = ref_sub_sic.sic_id  
                LEFT JOIN ref_parlimen ON ref_parlimen.parlimen_id = t_industrial.parlimen_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_industrial_all.wfTrans_id AND wfTask_partition = 1
                LEFT JOIN ref_status ON ref_status.status_id = t_industrial_all.indAll_status";
            } else if ($title == 'dt_pub_param') {
                $sql = "SELECT
                    t_pub.*,
                    t_industrial_parameter.indParam_id AS indParam_id,
                    t_industrial_parameter.indAll_id AS indAll_id,
                    t_industrial_parameter.indParam_concentration AS indParam_concentration,
                    t_industrial_parameter.indParam_limitValue AS indParam_limitValue,
                    t_industrial_parameter.indParam_status AS indParam_status,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    t_input_parameter.inputParam_unit AS inputParam_unit,
                    t_input_parameter.inputParam_type AS inputParam_type,
                    t_monitor.monitor_id AS monitor_id,
                    t_monitor.monitor_status AS monitor_status
                FROM t_industrial_parameter
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id
                LEFT JOIN t_monitor ON t_monitor.indParam_id = t_industrial_parameter.indParam_id
                WHERE t_pub.pub_status = 1";
            } else if ($title == 'dt_industrial_exclude') {
                $sql = "SELECT 
                    document.*,
                    t_industrial_exclude.indExclude_id,
                    t_industrial_exclude.indAll_id,
                    t_industrial_exclude.inputParam_id,
                    t_industrial_exclude.indExclude_reason,
                    t_industrial_exclude.pub_id,
                    t_input_parameter.inputParam_desc AS inputParam_desc
                FROM t_industrial_exclude
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_industrial_exclude.inputParam_id
                LEFT JOIN document ON document.document_id = t_industrial_exclude.document_id";
            } else if ($title == 'dt_written_approval') {
                $sql = "SELECT 
                    document.*,
                    t_industrial_written.indAll_id AS indAll_id,
                    t_industrial_written.indWritten_id AS indWritten_id,
                    t_industrial_written.indWritten_equipmentName AS indWritten_equipmentName,
                    t_industrial_written.indWritten_referenceNo AS indWritten_referenceNo,
                    t_industrial_written.indWritten_dateReference AS indWritten_dateReference,
                    document_name.documentName_desc AS documentName_desc
                FROM t_industrial_written
                LEFT JOIN document ON document.document_id = t_industrial_written.document_id
                LEFT JOIN document_name ON document_name.documentName_id = t_industrial_written.documentName_id
                WHERE t_industrial_written.indWritten_status = 1";
            } else if ($title == 'dt_industrial_document') {
                $sql = "SELECT 
                    document.*,
                    t_industrial_doc.indAll_id AS indAll_id,
                    t_industrial_doc.indDoc_id AS indDoc_id,
                    IF(t_industrial_doc.documentName_id IN (25,18),t_industrial_doc.indDoc_others,document_name.documentName_desc) AS documentName_desc,
                    document_name.documentName_type
                FROM t_industrial_doc
                LEFT JOIN document ON document.document_id = t_industrial_doc.document_id
                LEFT JOIN document_name ON document_name.documentName_id = t_industrial_doc.documentName_id
                WHERE t_industrial_doc.indDoc_status = 1";
            } else if ($title == 'dt_task_industrial') {
                $sql = "SELECT
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,	
                    t_industrial.industrial_premiseId AS industrial_premiseId,	
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    DATEDIFF(DATE(wf_task.wfTask_timeSubmitted), wf_task.wfTask_dateExpired) AS datediff2,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    wf_flow.wfFlow_id AS wfFlow_id,
                    profile.profile_name AS profile_name,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_industrial_all.indAll_dateRataActual AS indAll_dateRataActual,
                    ref_status_previous.status_desc AS status_previous,
                    ref_status_previous.status_color AS status_previous_color,
                    t_qa.qa_hardCopy,
                    wf_task.*
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task_type.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id             
                LEFT JOIN profile ON profile.user_id = wf_transaction.wfTrans_processOfficer AND profile.profile_status = 1 
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr 
                LEFT JOIN t_industrial ON t_industrial.wfGroup_id = wf_group.wfGroup_id
                LEFT JOIN t_industrial_all ON t_industrial_all.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_qa ON t_qa.indAll_id = t_industrial_all.indAll_id AND t_qa.qa_status <> 22
                LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                LEFT JOIN ref_status ref_status_previous ON ref_status_previous.status_id = wf_task.wfTask_statusPrevious";
            } else if ($title == 'vw_industrial_short') {
                $sql = "SELECT
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial_all.*
                FROM t_industrial_all 
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id ";
            } else if ($title == 'vw_data_30') {
                $sql = "SELECT 
                    * 
                FROM ref_data_30 
                LEFT JOIN 
                (SELECT * 
                    FROM data30_[data_year] 
                    WHERE indAll_id = [indAll_id] AND inputParam_id = [inputParam_id] AND date(data_timestamp) = '[data_date]'
                ) data30
                ON ref_data_30.rdata_time = TIME(data30.data_timestamp)";
//            } else if ($title == 'vw_data_daily') {
//                $sql = "SELECT 
//                    DATE(data_timestamp) AS d_date, 
//                    COUNT(*) AS d_count, 
//                    DATEDIFF(DATE(data_timestamp), '20[data_year]-01-01') AS index_date,
//                    SUM(data_value)/COUNT(*) AS d_avg
//                FROM data[data_type]_[data_year] 
//                WHERE indAll_id = [indAll_id] AND inputParam_id = [inputParam_id] AND data_value NOT IN (-998,-999)
//                GROUP BY d_date";
            } else if ($title == 'dt_industrial_all_list') {
                $sql = "SELECT 
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    consGroup.wfGroup_name AS consultant_name, 
                    t_consultant_cems.consCems_modelNo AS consCems_modelNo,
                    t_consultant_pems.consPems_model AS consPems_model, 
                    wf_transaction.wfTrans_timeCreated AS wfTrans_timeCreated,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    t_industrial.wfGroup_id AS wfGroup_id,
                    ref_state.state_desc,
                    t_industrial_all.*
                FROM t_industrial_all 
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_industrial_all.consultant_id
                LEFT JOIN wf_group consGroup ON consGroup.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_consultant_pems ON t_consultant_pems.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = t_industrial_all.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_status ON ref_status.status_id = t_industrial_all.indAll_status";
            } else if ($title == 'dt_installed_CEMS_PEMS') {
                $sql = "SELECT 
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_consultant_all.consAll_type AS consAll_type,
                    t_consultant_cems.consCems_modelNo AS consCems_modelNo,
                    t_consultant_pems.consPems_model AS consPems_model, 
                    wf_trans_cons.wfTrans_regNo AS cons_regNo,
                    ref_city.city_desc AS city_desc,
                    ref_state.state_desc AS state_desc,
                    wf_task.wfTask_timeSubmitted AS wfTask_timeSubmitted,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    t_industrial.wfGroup_id AS wfGroup_id,
                    t_industrial_all.*
                FROM t_industrial_all 
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN wf_transaction wf_trans_cons ON wf_trans_cons.wfTrans_id = t_consultant_all.wfTrans_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_consultant_pems ON t_consultant_pems.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_industrial_all.wfTrans_id AND wf_task.wfTaskType_id IN (35,45) AND wf_task.wfTask_status = 18
                LEFT JOIN ref_status ON ref_status.status_id = t_industrial_all.indAll_status";
            } else if ($title == 'vw_monitor_compliance') {
                $sql = "SELECT 
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial_parameter.indParam_id AS indParam_id,
                    t_industrial_parameter.indAll_id AS indAll_id,
                    t_industrial_parameter.indParam_concentration AS indParam_concentration,
                    t_industrial_parameter.indParam_limitValue AS indParam_limitValue,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    t_input_parameter.inputParam_id AS inputParam_id,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    ref_city.city_desc AS city_desc,
                    ref_state.state_desc AS state_desc,
                    t_monitor.monitor_id AS monitor_id,
                    t_monitor.monitor_status AS monitor_status,
                    t_industrial.industrial_premiseId AS industrial_premiseId
                FROM t_monitor
                LEFT JOIN t_industrial_parameter ON t_industrial_parameter.indParam_id = t_monitor.indParam_id
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id 
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_industrial_parameter.indAll_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                WHERE t_monitor.monitor_status IN (1,31)";
            } else if ($title == 'dt_pooling_list') {
                $sql = "SELECT 
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    ref_state.state_desc AS state_desc,
                    ref_parlimen.parlimen_desc AS parlimen_desc,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    date_list.list_date AS list_date,
                    t_reason_fail.reasonFail_desc AS reasonFail_desc,
                    t_industrial_parameter.indParam_id AS indParam_id,
                    t_industrial_parameter.indAll_id AS indAll_id,
                    t_input_parameter.inputParam_id AS inputParam_id,
                    data_table.total AS total,
                    data_table_01.total AS total_01,
                    t_response.response_id AS response_id,
                    t_industrial_all.industrial_id AS industrial_id,
                    CASE WHEN t_pub.inputParam_id = 8 AND data_table_01.total >= 1440 THEN 1
                        WHEN t_pub.inputParam_id = 8 AND data_table_01.total IS NULL THEN 3
                        WHEN t_pub.inputParam_id = 8 AND data_table_01.total >= 0 THEN 2
                        WHEN t_pub.inputParam_id <> 8 AND data_table.total >= 48 THEN 1
                        WHEN t_pub.inputParam_id <> 8 AND data_table.total IS NULL THEN 3
                        WHEN t_pub.inputParam_id <> 8 AND data_table.total >= 0 THEN 2
                        END AS pool_result
                FROM t_industrial_parameter
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_industrial_parameter.indAll_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN ref_parlimen ON ref_parlimen.parlimen_id = t_industrial.parlimen_id
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id
                JOIN (
                    SELECT ADDDATE('[pool_year]-01-01', INTERVAL @i:=@i+1 DAY) AS list_date 
                    FROM (
                        SELECT a.a
                        FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
                        ) a
                    JOIN (SELECT @i := -1) r1
                    WHERE 
                    @i < DATEDIFF('[pool_until]', '[pool_year]-01-01')
                ) date_list 
                LEFT JOIN t_response ON t_response.indParam_id = t_industrial_parameter.indParam_id AND t_response.response_date = date_list.list_date AND t_response.response_status = 32 
                LEFT JOIN t_reason_fail ON t_reason_fail.reasonFail_id = t_response.reasonFail_id
                LEFT JOIN (
                    SELECT 
                        indAll_id, inputParam_id, DATE(data_timestamp) AS data_date, COUNT(*) AS total 
                    FROM data30_[short_year] 
                    GROUP BY indAll_id, inputParam_id, data_date
                ) data_table ON data_table.indAll_id = t_industrial_parameter.indAll_id AND data_table.inputParam_id = t_input_parameter.inputParam_id AND data_table.data_date = date_list.list_date
                LEFT JOIN (
                    SELECT 
                        indAll_id, inputParam_id, DATE(data_timestamp) AS data_date, COUNT(*) AS total 
                    FROM data01_[short_year] 
                    GROUP BY indAll_id, inputParam_id, data_date
                ) data_table_01 ON data_table_01.indAll_id = t_industrial_parameter.indAll_id AND data_table_01.inputParam_id = t_input_parameter.inputParam_id AND data_table_01.data_date = date_list.list_date
                WHERE t_industrial_all.indAll_status IN (1,27,28,29,30) AND YEAR(list_date) = [pool_year]";
            } else if ($title == 'vw_map_pooling_status') {
                $sql = "SELECT 
                    t_industrial_all.indAll_id AS indAll_id,
                    t_industrial_all.indAll_stackLatitude AS indAll_stackLatitude,
                    t_industrial_all.indAll_stackLongitude AS indAll_stackLongitude,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial_all.indAll_datePoolStart AS indAll_datePoolStart,
                    IFNULL(input_01, 0) AS total_needed,
                    IFNULL(data_summaries.total_data, 0) AS total_data,
                    ref_city.state_id AS state_id,
                    t_industrial.parlimen_id AS parlimen_id,
                    t_industrial_all.industrial_id AS industrial_id
                FROM t_industrial_all 
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id 
                LEFT JOIN (
                        SELECT 
                            indAll_id, COUNT(*) AS total_param,
                            SUM(1440) AS input_01
                        FROM t_industrial_parameter 
                        LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                        GROUP BY indAll_id
                    ) industrial_parameter ON industrial_parameter.indAll_id = t_industrial_all.indAll_id
                LEFT JOIN (
                    SELECT industrial_id, stack_id, SUM(ydaily_count) AS total_data 
                    FROM y[short_year]_data_daily 
                    WHERE ydaily_date = '[pool_date]' 
                    GROUP BY industrial_id, stack_id
                ) data_summaries ON data_summaries.industrial_id = t_industrial_all.industrial_id AND data_summaries.stack_id = t_industrial_all.indAll_stackNo
                WHERE indAll_datePoolStart <= '[pool_date]' AND indAll_status IN (1,27,28,29,30)";
            } else if ($title == 'dt_pooling_by_state') {
                $sql = "SELECT ref_state.state_id AS state_id, ref_state.state_desc AS state_desc,
                    SUM(IF(total_data = 0,1,0)) AS data_red, 
                    SUM(IF(total_data > 0 AND total_data < total_needed,1,0))  AS data_orange, 
                    SUM(IF(total_data >= total_needed,1,0))  AS data_green 
                FROM ref_state 
                LEFT JOIN (
                    SELECT 
                        IFNULL(input_01, 0) AS total_needed,
                        IFNULL(data_summaries.total_data, 0) AS total_data,
                        ref_city.state_id AS state_id
                    FROM t_industrial_all 
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id 
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id 
                    LEFT JOIN (
                            SELECT 
                                indAll_id, COUNT(*) AS total_param,
                                SUM(1440) AS input_01
                            FROM t_industrial_parameter 
                            LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                            GROUP BY indAll_id
                        ) industrial_parameter ON industrial_parameter.indAll_id = t_industrial_all.indAll_id
                    LEFT JOIN (
                        SELECT industrial_id, stack_id, SUM(ydaily_count) AS total_data 
                        FROM y[short_year]_data_daily 
                        WHERE ydaily_date = '[pool_date]' 
                        GROUP BY industrial_id, stack_id
                    ) data_summaries ON data_summaries.industrial_id = t_industrial_all.industrial_id AND data_summaries.stack_id = t_industrial_all.indAll_stackNo
                    WHERE indAll_datePoolStart <= '[pool_date]' AND indAll_status IN (1,27,28,29,30)) 
                as data_table ON data_table.state_id = ref_state.state_id
                GROUP BY state_id";
            } else if ($title == 'dt_mobile_cems_equipment') {
                $sql = "SELECT 
                    t_consultant_mobile_equipment.*,
                    t_mobile_equipment.mobileEquip_id AS mobileEquip_ids,
                    t_mobile_equipment.mobileEquip_type AS mobileEquip_type,
                    t_mobile_equipment.mobileEquip_desc AS mobileEquip_desc,
                    t_mobile_equipment.mobileEquip_mandatory AS mobileEquip_mandatory,
                    t_mobile_equipment.mobileEquip_status AS mobileEquip_status
                FROM t_mobile_equipment
                LEFT JOIN t_consultant_mobile_equipment ON t_consultant_mobile_equipment.mobileEquip_id = t_mobile_equipment.mobileEquip_id AND t_consultant_mobile_equipment.consAll_id = [consAll_id]";
            } else if ($title == 'vw_pooling_selected_stack') {
                $sql = "SELECT
                    t_industrial_all.*,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    t_industrial.industrial_premiseId AS industrial_premiseId,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_transaction.wfFlow_id AS wfFlow_id,
                    wf_task.wfTask_timeSubmitted AS registered_date,
                    consultant.consultant_list AS consultant_name,
                    ref_city.city_desc AS city_desc,
                    ref_state.state_desc AS state_desc
                FROM t_industrial_all
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_industrial_all.wfTrans_id AND wf_task.wfTaskType_id IN (35,45) AND wf_task.wfTask_status = 18
                LEFT JOIN (
                    SELECT 
                        t_industrial_consultant.indAll_id AS indAll_id, 
                        GROUP_CONCAT(DISTINCT(wf_group.wfGroup_name) SEPARATOR ', ') AS consultant_list
                    FROM t_industrial_consultant 
                    LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_industrial_consultant.consAll_id
                    LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id 
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                    GROUP BY indAll_id) consultant ON consultant.indAll_id = t_industrial_all.indAll_id
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id";                
            } else if ($title == 'vw_pooling_selected_param') {
                $sql = "SELECT 
                    GROUP_CONCAT(t_input_parameter.inputParam_desc ORDER BY t_input_parameter.inputParam_id ASC SEPARATOR ', ') AS param_list
               FROM t_industrial_parameter 
               LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
               LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id 
               WHERE t_industrial_parameter.indAll_id = [indAll_id]";
            } else if ($title == 'dt_pooling_selected_param_summary') {
                $sql = "SELECT  
                    t_pub.inputParam_id AS inputParam_id,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    IFNULL(ydaily_count, 0) AS input_01,
                    t_industrial_parameter.indParam_limitValue AS indParam_limitValue,
                    t_input_parameter.inputParam_unit AS inputParam_unit,
                    t_reason_fail.reasonFail_desc
                FROM t_industrial_parameter                
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_industrial_parameter.indAll_id
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id 
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id
                LEFT JOIN y[short_year]_data_daily ON y[short_year]_data_daily.industrial_id = t_industrial_all.industrial_id AND y[short_year]_data_daily.stack_id = t_industrial_all.indAll_stackNo 
                    AND y[short_year]_data_daily.inputParam_id = t_pub.inputParam_id AND y[short_year]_data_daily.ydaily_date = '[pool_date]' 
                LEFT JOIN t_response ON t_response.indParam_id = t_industrial_parameter.indParam_id AND t_response.response_status = 32 AND t_response.response_date = '[pool_date]' 
                LEFT JOIN t_reason_fail ON t_reason_fail.reasonFail_id = t_response.reasonFail_id
                WHERE t_industrial_parameter.indAll_id = [indAll_id]";
            } else if ($title == 'vw_compliance_param_list') {
                $sql = "SELECT
                    t_pub.*,
                    t_industrial_parameter.indParam_id AS indParam_id,
                    t_industrial_parameter.indAll_id AS indAll_id,
                    t_industrial_parameter.indParam_concentration AS indParam_concentration,
                    t_industrial_parameter.indParam_limitValue AS indParam_limitValue,
                    t_industrial_parameter.indParam_status AS indParam_status,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    IFNULL(t_monitor.monitor_status, 0) AS monitor_status,
                    0 AS total_rows,
                    0 AS sum_rows,
                    0 AS total_not_comply
                FROM t_industrial_parameter
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_industrial_parameter.indAll_id
                LEFT JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_pub.inputParam_id 
                LEFT JOIN t_monitor ON t_monitor.indParam_id = t_industrial_parameter.indParam_id 
                WHERE inputParam_status = 1";   // AND t_pub.inputParam_id <= 8
//            } else if ($title == 'vw_compliance_stack_data_summary') {
//                $sql = "SELECT 
//                    IFNULL(SUM(IF(data_[inputParam_id]>=0&&data_[inputParam_id]<=[limit_value],1,0)), 0) AS total_pass,
//                    IFNULL(SUM(IF(data_[inputParam_id]<0,1,0)), 0) AS total_wrong,
//                    IFNULL(SUM(IF(data_[inputParam_id]>[limit_value],1,0)), 0) AS total_fail,
//                    IFNULL(SUM(IF(data_[inputParam_id]>=0,data_[inputParam_id],0))/COUNT(*), 0) AS daily_average,
//                    COUNT(*) AS total_data
//                FROM data_30_[short_year] WHERE DATE(data_timestamp) = '[data_date]' 
//                    AND indAll_id = [indAll_id] ";
//            } else if ($title == 'vw_compliance_stack_opacity_summary') {
//                $sql = "SELECT 
//                    IFNULL(SUM(IF(data_value>=0&&data_value<=20,1,0)), 0) AS total_pass,
//                    IFNULL(SUM(IF(data_value<0,1,0)), 0) AS total_wrong,
//                    IFNULL(SUM(IF(data_value>20,1,0)), 0) AS total_fail,
//                    IFNULL(SUM(IF(data_value>=0,data_value,0))/COUNT(*), 0) AS daily_average,
//                    COUNT(*) AS total_data
//                FROM data_01_[short_year]_[indAll_id] WHERE DATE(data_timestamp) = '[data_date]'";
            } else if ($title == 'dt_data_01') {
                $sql = "SELECT
                    DATE_FORMAT(time_list.list_time, '%T') AS list_time, 
                    z[short_year]_[premise_no].*
                FROM 
                (	
                    SELECT ADDDATE('[data_date]', INTERVAL @i:=@i+1 MINUTE) AS list_time 
                    FROM (
                        SELECT a.a
                        FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
                        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS d
                        ) a
                    JOIN (SELECT @i := -1) r1
                    WHERE 
                    @i < 1439
                ) time_list 
                LEFT JOIN z[short_year]_[premise_no] ON DATE(data_timestamp) = '[data_date]' AND stack_id = '[indAll_stackNo]' AND data_timestamp = time_list.list_time";
            } else if ($title == 'dt_data_30') {
                $sql = "SELECT
                    DATE_FORMAT(time_list.list_time, '%T') AS list_time, 
                    [indAll_stackNo] AS stack_id,
                    z_data.*
                FROM 
                (	
                    SELECT ADDDATE('[data_date]', INTERVAL (@i:=@i+1)*30 MINUTE) AS list_time 
                    FROM (
                        SELECT a.a
                        FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                        CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                        ) a
                    JOIN (SELECT @i := -1) r1
                    WHERE 
                    @i < 47
                ) time_list 
                LEFT JOIN (
                    SELECT 
                        FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(data_timestamp)/(30* 60)) * (30*60)) AS thirtyHourInterval,
                        SUM(IF(data_1 IS NOT NULL, data_1, 0)) AS sum_1,
                        SUM(IF(data_1 IS NOT NULL, 1, 0)) AS count_1,
                        SUM(IF(data_2 IS NOT NULL, data_2, 0)) AS sum_2,
                        SUM(IF(data_2 IS NOT NULL, 1, 0)) AS count_2,
                        SUM(IF(data_3 IS NOT NULL, data_3, 0)) AS sum_3,
                        SUM(IF(data_3 IS NOT NULL, 1, 0)) AS count_3,
                        SUM(IF(data_4 IS NOT NULL, data_4, 0)) AS sum_4,
                        SUM(IF(data_4 IS NOT NULL, 1, 0)) AS count_4,
                        SUM(IF(data_5 IS NOT NULL, data_5, 0)) AS sum_5,
                        SUM(IF(data_5 IS NOT NULL, 1, 0)) AS count_5,
                        SUM(IF(data_6 IS NOT NULL, data_6, 0)) AS sum_6,
                        SUM(IF(data_6 IS NOT NULL, 1, 0)) AS count_6,
                        SUM(IF(data_7 IS NOT NULL, data_7, 0)) AS sum_7,
                        SUM(IF(data_7 IS NOT NULL, 1, 0)) AS count_7
                    FROM z[short_year]_[premise_no] 
                    WHERE DATE(data_timestamp) = '[data_date]' AND stack_id = '[indAll_stackNo]'
                    GROUP BY thirtyHourInterval
                    ORDER BY data_timestamp
                ) z_data ON z_data.thirtyHourInterval = time_list.list_time";
            } else if ($title == 'dt_fail_response_list') {
                $sql = "SELECT
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    date(t_response.response_date) AS response_dates,
                    t_response.response_date AS response_date,
                    t_reason_fail.reasonFail_desc AS reasonFail_desc,
                    t_response.response_id AS response_id,
                    t_response.response_dataNeeded AS response_dataNeeded,
                    t_response.response_dataReceived AS response_dataReceived,
                    t_response.response_averageLimit AS response_averageLimit,
                    t_response.response_averageValue AS response_averageValue,
                    t_response.response_timeCreated AS response_timeCreated,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    wf_task_type.wfFlow_id AS wfFlow_id,
                    t_industrial_all.industrial_id AS industrial_id,
                    t_industrial_all.indAll_type AS indAll_type,
                    t_industrial_all.indAll_id AS indAll_id,
                    ind_app.wfTrans_regNo AS ind_regNo,
                    wf_task_user.wfTaskUser_id AS wfTaskUser_id,
                    t_compliance_type.complianceType_desc AS complianceType_desc,
                    wf_task.*
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                LEFT JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task_type.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                INNER JOIN t_response ON t_response.wfTrans_id = wf_transaction.wfTrans_id 
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_response.inputParam_id
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                LEFT JOIN wf_transaction ind_app ON ind_app.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN t_reason_fail ON t_reason_fail.reasonFail_id = t_response.reasonFail_id
                LEFT JOIN t_compliance_type ON t_compliance_type.complianceType_id = t_response.complianceType_id
                LEFT JOIN ref_status ON ref_status.status_id = t_response.response_status               
                WHERE wf_task_type.wfFlow_id IN (6,7) AND wf_task.wfTask_partition = 1";
            } else if ($title == 'dt_fail_response_list_veriy') {
                $sql = "SELECT
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    ref_state.state_desc AS state_desc,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    t_response.response_date AS response_date,
                    t_reason_fail.reasonFail_desc AS reasonFail_desc,
                    t_response.response_id AS response_id,
                    t_response.response_dataNeeded AS response_dataNeeded,
                    t_response.response_dataReceived AS response_dataReceived,
                    t_response.response_averageLimit AS response_averageLimit,
                    t_response.response_averageValue AS response_averageValue,
                    t_response.response_timeCreated AS response_timeCreated,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,	
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    wf_task_type.wfFlow_id AS wfFlow_id,
                    t_industrial.industrial_id AS industrial_id,
                    t_industrial_all.indAll_type AS indAll_type,
                    t_industrial_all.indAll_id AS indAll_id,
                    ind_app.wfTrans_regNo AS ind_regNo,
                    wf_task_type.wfTaskType_statusName AS wfTaskType_statusName,
                    wf_task_user.wfTaskUser_id AS wfTaskUser_id,
                    t_compliance_type.complianceType_desc AS complianceType_desc,
                    wf_task.*
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                LEFT JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task_type.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                INNER JOIN t_response ON t_response.wfTrans_id = wf_transaction.wfTrans_id 
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_response.inputParam_id
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                LEFT JOIN wf_transaction ind_app ON ind_app.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                LEFT JOIN t_reason_fail ON t_reason_fail.reasonFail_id = t_response.reasonFail_id
                LEFT JOIN t_compliance_type ON t_compliance_type.complianceType_id = t_response.complianceType_id
                LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                WHERE wf_task_type.wfFlow_id IN (6,7) AND wf_task.wfTask_partition = 1";
            } else if ($title == 'dt_fail_response_list_all') {
                $sql = "SELECT
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    ref_state.state_desc AS state_desc,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    t_response.response_date AS response_date,
                    t_reason_fail.reasonFail_desc AS reasonFail_desc,
                    t_response.response_id AS response_id,
                    t_response.response_dataNeeded AS response_dataNeeded,
                    t_response.response_dataReceived AS response_dataReceived,
                    t_response.response_averageLimit AS response_averageLimit,
                    t_response.response_averageValue AS response_averageValue,
                    t_response.response_timeCreated AS response_timeCreated,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,	
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    wf_task_type.wfFlow_id AS wfFlow_id,
                    t_industrial.industrial_id AS industrial_id,
                    t_industrial_all.indAll_type AS indAll_type,
                    t_industrial_all.indAll_id AS indAll_id,
                    ind_app.wfTrans_regNo AS ind_regNo,
                    wf_task_type.wfTaskType_statusName AS wfTaskType_statusName,
                    t_compliance_type.complianceType_desc AS complianceType_desc,
                    wf_task.*
                FROM t_response 
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_response.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_response.inputParam_id
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                LEFT JOIN wf_transaction ind_app ON ind_app.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                LEFT JOIN t_reason_fail ON t_reason_fail.reasonFail_id = t_response.reasonFail_id
                LEFT JOIN t_compliance_type ON t_compliance_type.complianceType_id = t_response.complianceType_id
                LEFT JOIN ref_status ON ref_status.status_id = t_response.response_status
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id";
            } else if ($title == 'vw_response_info') {
                $sql = "SELECT 
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_industrial.industrial_jasFileNo AS industrial_jasFileNo,
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    ref_status.status_desc AS status_desc,
                    wf_transaction.wfTrans_regNo AS ind_regNo,
                    t_reason_fail.reasonFail_desc AS reasonFail_desc,
                    t_compliance_type.complianceType_desc AS complianceType_desc,
                    t_response.*
                FROM t_response 
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_industrial_all.wfTrans_id
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_response.inputParam_id
                LEFT JOIN t_reason_fail ON t_reason_fail.reasonFail_id = t_response.reasonFail_id
                LEFT JOIN t_compliance_type ON t_compliance_type.complianceType_id = t_response.complianceType_id
                LEFT JOIN ref_status ON ref_status.status_id = t_response.response_status";
            } else if ($title == 'dt_response_document') {
                $sql = "SELECT 
                    document.*,
                    t_response_doc.responseDoc_id AS responseDoc_id,
                    t_response_doc.response_id AS response_id,
                    t_response_doc.responseDoc_status AS responseDoc_status
                FROM t_response_doc 
                LEFT JOIN document ON document.document_id = t_response_doc.document_id";
            } else if ($title == 'vw_qa_details') {
                $sql = "SELECT 
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    consultant_group.wfGroup_name AS consultant_name,
                    ref_status.status_desc AS qa_status_desc,
                    ref_status.status_color AS qa_status_color,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_industrial_all.indAll_datePoolStart AS indAll_datePoolStart,
                    CASE WHEN t_qa.qa_type = 1 THEN 'CEMS Initial Quality Assurance'
                        WHEN t_qa.qa_type = 2 THEN 'PEMS Initial Quality Assurance'
                        WHEN t_qa.qa_type = 3 THEN 'CEMS Quality Assurance'
                        WHEN t_qa.qa_type = 4 THEN 'CEMS RAA'
                        WHEN t_qa.qa_type = 5 THEN 'PEMS Quality Assurance'
                        WHEN t_qa.qa_type = 6 THEN 'PEMS RAA'
                    END AS qa_type_desc,
                    t_qa.*
                FROM t_qa
                LEFT JOIN wf_task ON wf_task.wfTask_id = t_qa.wfTask_id  
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_qa.indAll_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN ref_status ON ref_status.status_id = t_qa.qa_status
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_industrial_all.consultant_id 
                LEFT JOIN wf_group consultant_group ON consultant_group.wfGroup_id = t_consultant.wfGroup_id";
            } else if ($title == 'dt_qa_check') {
                $sql = "SELECT 
                    t_qa_checklist.qaChecklist_desc AS qaChecklist_desc,
                    t_qa_checklist.qaChecklist_type AS qaChecklist_type,
                    t_qa_check.*
                FROM t_qa_check 
                LEFT JOIN t_qa_checklist ON t_qa_checklist.qaChecklist_id = t_qa_check.qaChecklist_id";
            } else if ($title == 'dt_qa_calibrate') {
                $sql = "SELECT 
                    t_input_parameter.inputParam_desc AS inputParam_desc,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    t_qa_calibrate.*
                FROM t_qa_calibrate 
                LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_qa_calibrate.inputParam_id
                LEFT JOIN t_qa ON t_qa.qa_id = t_qa_calibrate.qa_id 
                LEFT JOIN ref_status ON ref_status.status_id = t_qa_calibrate.qaCalibrate_result";
            } else if ($title == 'dt_qa_document') {
                $sql = "SELECT 
                    document.*,
                    t_qa_doc.qaDoc_id AS qaDoc_id,
                    t_qa_doc.qa_id AS qa_id
                FROM t_qa_doc 
                LEFT JOIN document ON document.document_id = t_qa_doc.document_id 
                WHERE t_qa_doc.qaDoc_status = 1";
            } else if ($title == 'dt_pems_reading') {
                $sql = "SELECT 
                    t_pems_input.pemsInput_id AS pemsInput_id,
                    t_pems_input.pemsInput_name AS pemsInput_name,
                    t_pems_input.pemsInput_desc AS pemsInput_desc,
                    MAX(IF(t_pems_reading.pemsReading_type=1, t_pems_reading.pemsReading_min, 0)) AS low_min,
                    MAX(IF(t_pems_reading.pemsReading_type=1, t_pems_reading.pemsReading_max, 0)) AS low_max,
                    MAX(IF(t_pems_reading.pemsReading_type=1, t_pems_reading.pemsReading_weight, 0)) AS low_weight,
                    MAX(IF(t_pems_reading.pemsReading_type=2, t_pems_reading.pemsReading_min, 0)) AS normal_min,
                    MAX(IF(t_pems_reading.pemsReading_type=2, t_pems_reading.pemsReading_max, 0)) AS normal_max,
                    MAX(IF(t_pems_reading.pemsReading_type=2, t_pems_reading.pemsReading_weight, 0)) AS normal_weight,
                    MAX(IF(t_pems_reading.pemsReading_type=3, t_pems_reading.pemsReading_min, 0)) AS high_min,
                    MAX(IF(t_pems_reading.pemsReading_type=3, t_pems_reading.pemsReading_max, 0)) AS high_max,
                    MAX(IF(t_pems_reading.pemsReading_type=3, t_pems_reading.pemsReading_weight, 0)) AS high_weight
                FROM t_pems_input
                INNER JOIN t_pems_reading ON t_pems_reading.pemsInput_id = t_pems_input.pemsInput_id AND t_pems_reading.wfTask_id = [wfTask_id] AND t_pems_reading.pemsReading_category = 1
                WHERE t_pems_input.indAll_id = [indAll_id] 
                GROUP BY pemsInput_id, pemsInput_name, pemsInput_desc";
            } else if ($title == 'dt_notify_task') {
                $sql = "SELECT 
                    wf_task.*,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    wf_flow.wfFlow_icon AS wfFlow_icon,
                    wf_flow.wfFlow_color AS wfFlow_color,
                    wf_task_type.wfTaskType_name AS wfTaskType_name,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr 
                LEFT JOIN t_industrial_all ON t_industrial_all.wfTrans_id = wf_task.wfTrans_id AND wf_task.wfTask_refName = 'indAll_id'
                WHERE wf_task.wfTaskType_id IN ([wfTaskType_id]) AND wf_task_type.wfTaskType_isEnd = 'N' AND wf_task.wfTask_partition = 1
                    AND (wf_task.wfTask_claimedBy = [user_id] OR wf_task.wfTask_claimedBy IS NULL)";
            } else if ($title == 'vw_notify_total_application') {
                $sql = "SELECT
                    wfFlow_desc, wfFlow_icon, wfFlow_color, COUNT(*) AS total
                FROM wf_transaction 
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_transaction.wfFlow_id
                WHERE wfTrans_status NOT IN (2,8) AND MONTH(wfTrans_timeSubmit) = MONTH(CURDATE())
                GROUP BY wfFlow_desc, wfFlow_icon, wfFlow_color";
            } else if ($title == 'vw_widget_no') {
                $sql = "SELECT 
                    user_type.uType_id AS uType_id,
                    user_type.user_id AS user_id,
                    user_type.userType_status AS userType_status,
                    t_widget.widget_no AS widget_no
                FROM user_type 
                LEFT JOIN t_widget ON t_widget.uType_id = user_type.uType_id";  
            } else if ($title == 'vw_hm_chart_2') {
                $sql = "SELECT
                    wfFlow_desc, wfFlow_short, COUNT(*) AS total
                FROM wf_task
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_transaction.wfFlow_id
                WHERE wf_transaction.wfTrans_status <> 8 AND wf_task.wfTask_partition = 1
                AND (wf_task.wfTaskType_id NOT IN (3,13,23,33,43) OR (wf_task.wfTaskType_id IN (3,13,23,33,43) AND (wf_task.wfTask_claimedBy = 3 OR wf_task.wfTask_claimedBy IS NULL)))
                GROUP BY wfFlow_desc, wfFlow_short";
            } else if ($title == 'dt_hm_2') {
                $sql = "SELECT
                    wf_task.wfTask_id AS wfTask_id,
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_task.wfTask_timeCreated AS wfTask_timeCreated,
                    wf_task.wfTask_dateExpired AS wfTask_dateExpired,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff 
                FROM wf_task
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_transaction.wfFlow_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                WHERE wf_transaction.wfTrans_status <> 8 AND wf_task.wfTask_partition = 1 
                AND (wf_task.wfTaskType_id NOT IN (3,13,23,33,43) OR (wf_task.wfTaskType_id IN (3,13,23,33,43) AND (wf_task.wfTask_claimedBy = [user_id] OR wf_task.wfTask_claimedBy IS NULL)))";
            } else if ($title == 'vw_hm_chart_3') {
                $sql = "SELECT
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    SUM(IF(DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired)>0, 1, 0)) AS late, 
                    SUM(IF(DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired)<=0, 1, 0)) AS ontime
                FROM wf_task
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_transaction.wfFlow_id
                WHERE wf_transaction.wfTrans_status <> 8 AND wf_task.wfTask_partition = 1 
                AND (wf_task.wfTaskType_id NOT IN (3,13,23,33,43) OR (wf_task.wfTaskType_id IN (3,13,23,33,43) AND (wf_task.wfTask_claimedBy = [user_id] OR wf_task.wfTask_claimedBy IS NULL)))
                GROUP BY wfFlow_desc";
            } else if ($title == 'vw_hm_chart_4') {
                $sql = "SELECT
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    SUM(IF(DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired)>0, 1, 0)) AS late, 
                    SUM(IF(DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired)<=0, 1, 0)) AS ontime
                FROM wf_task
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                WHERE wf_task.wfTask_partition = 1 AND wf_task_type.wfTaskType_isEnd = 'N' AND wf_task_type.wfGroup_id = 1
                GROUP BY wfFlow_desc";
            } else if ($title == 'vw_hm_map_5') {
                $sql = "SELECT 
                    ref_state.state_hc_key AS state_hc_key, COUNT(*) AS total
                FROM t_response 
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                WHERE t_response.response_date = '[response_date]' AND t_response.response_type = [response_type]
                GROUP BY state_hc_key";
            } else if ($title == 'vw_hm_bar_6') {
                $sql = "SELECT 
                    t_consultant.wfGroup_id AS wfGroup_id,
                    t_certificate_issuer.certIssuer_desc AS certIssuer_desc,
                    IF(ISNULL(t_consultant_cems.consCems_modelNo), t_consultant_mobile.consMobile_modelNo, t_consultant_cems.consCems_modelNo) AS model_no,
                    DATE(t_certificate.certificate_timeFinish) AS certificate_dateStart,
                    CASE WHEN t_consultant_all.consAll_type = 1 THEN 'CEMS'
                            WHEN t_consultant_all.consAll_type = 2 THEN 'PEMS'
                            WHEN t_consultant_all.consAll_type = 3 THEN 'Mobile-CEMS' END AS consType,
                    DATEDIFF(certificate_dateExpired,DATE(certificate_timeFinish)) AS diff_e_s,
                    DATEDIFF(CURDATE(),DATE(certificate_timeFinish)) AS diff_t_s,
                    DATEDIFF(CURDATE(),certificate_dateExpired) AS diff_t_e,
                    t_certificate.*
                FROM t_consultant_all
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_consultant_all.consAll_id AND t_consultant_all.consAll_type = 1
                LEFT JOIN t_consultant_mobile ON t_consultant_mobile.consAll_id = t_consultant_all.consAll_id AND t_consultant_all.consAll_type = 3
                INNER JOIN t_certificate ON t_certificate.consAll_id = t_consultant_all.consAll_id
                LEFT JOIN t_certificate_issuer ON t_certificate_issuer.certIssuer_id = t_certificate.certIssuer_id
                WHERE consAll_status = 1 AND t_certificate.certificate_status IN (1,37)";
            } else if ($title == 'dt_certificate_cons') {
                $sql = "SELECT 
                    IF(t_consultant_all.consAll_type=3,t_consultant_mobile.consMobile_modelNo,t_consultant_cems.consCems_modelNo) AS model_no,
                    cert_basic.cert_desc AS certificate_basic,
                    t_certificate_issuer.certIssuer_desc AS certIssuer_desc,
                    IF(t_consultant_all.consAll_type=3,'Mobile-CEMS','CEMS') AS analyzer_type,
                    t_consultant_all.consAll_type,
                    t_certificate.*,
                    t_consultant.wfGroup_id AS wfGroup_id,
                    ref_status.status_id AS status_id,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    cert_task.wfTask_id AS renew_task,
                    cert_renew.certificate_id AS renew_id,
                    cert_renew.certificate_status AS renew_status,
                    cert_task.wfTaskType_id AS renew_taskType
                FROM t_certificate
                LEFT JOIN
                    (SELECT 
                        t_certificate_basic_list.certificate_id AS certificate_id,
                        GROUP_CONCAT(t_certificate_basic.certBasic_desc  SEPARATOR ', ') AS cert_desc
                    FROM t_certificate_basic_list 
                    LEFT JOIN t_certificate_basic ON t_certificate_basic.certBasic_id = t_certificate_basic_list.certBasic_id
                    GROUP BY certificate_id
                    ) cert_basic ON cert_basic.certificate_id = t_certificate.certificate_id
                LEFT JOIN t_certificate_issuer ON t_certificate_issuer.certIssuer_id = t_certificate.certIssuer_id
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_certificate.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_certificate.consAll_id
                LEFT JOIN t_consultant_mobile ON t_consultant_mobile.consAll_id = t_certificate.consAll_id
                LEFT JOIN wf_task ON wf_task.wfTrans_id = t_certificate.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN ref_status ON ref_status.status_id = IF(DATEDIFF(certificate_dateExpired,CURDATE())<0,37,t_certificate.certificate_status)
                LEFT JOIN t_certificate cert_renew ON cert_renew.certificate_renewed = t_certificate.certificate_id 
                LEFT JOIN wf_task cert_task ON cert_task.wfTrans_id = cert_renew.wfTrans_id AND cert_task.wfTask_partition = '1'
                WHERE t_consultant_all.consAll_status = 1";
            } else if ($title == 'vw_certificate_details') {
                $sql = "SELECT
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    IF(t_consultant_all.consAll_type=3,t_consultant_mobile.consMobile_modelNo,t_consultant_cems.consCems_modelNo) AS model_no,
                    cert_basic.cert_desc AS certificate_basic,
                    t_certificate_issuer.certIssuer_desc AS certIssuer_desc,
                    wf_group.wfGroup_name AS wfGroup_name,
                    IF(t_consultant_all.consAll_type=3,'Mobile-CEMS','CEMS') AS analyzer_type,
                    cons_transaction.wfTrans_regNo AS cons_regNo,
                    ref_status.status_desc AS status_desc,
                    document.document_uplname AS document_uplname,
                    t_certificate.*
                FROM t_certificate
                LEFT JOIN
                    (SELECT 
                        t_certificate_basic_list.certificate_id AS certificate_id,
                        GROUP_CONCAT(t_certificate_basic.certBasic_desc  SEPARATOR ', ') AS cert_desc
                    FROM t_certificate_basic_list 
                    LEFT JOIN t_certificate_basic ON t_certificate_basic.certBasic_id = t_certificate_basic_list.certBasic_id
                    GROUP BY certificate_id
                    ) cert_basic ON cert_basic.certificate_id = t_certificate.certificate_id
                LEFT JOIN t_certificate_issuer ON t_certificate_issuer.certIssuer_id = t_certificate.certIssuer_id
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_certificate.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_certificate.consAll_id
                LEFT JOIN t_consultant_mobile ON t_consultant_mobile.consAll_id = t_certificate.consAll_id
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_certificate.wfTrans_id
                LEFT JOIN wf_transaction cons_transaction ON cons_transaction.wfTrans_id = t_consultant_all.wfTrans_id 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN document ON document.document_id = t_certificate.document_id
                LEFT JOIN ref_status ON ref_status.status_id = t_certificate.certificate_status";
            } else if ($title == 'dt_certificate_verify') {
                $sql = "SELECT
                    wf_transaction.wfTrans_no AS wfTrans_no,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,
                    wf_group.wfGroup_name AS wfGroup_name,
                    wf_group.wfGroup_regNo AS wfGroup_regNo,	
                    t_consultant_all.consAll_id AS consAll_id,
                    t_consultant_all.consAll_type AS consAll_type,
                    IF(t_consultant_all.consAll_type=3,t_consultant_mobile.consMobile_modelNo,t_consultant_cems.consCems_modelNo) AS model_no,
                    t_certificate.certificate_no AS certificate_no,
                    t_certificate_issuer.certIssuer_desc AS certIssuer_desc,
                    t_certificate.certificate_dateExpired AS certificate_dateExpired,
                    DATEDIFF(CURDATE(), t_certificate.certificate_dateExpired) AS certdiff,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    wf_flow.wfFlow_id AS wfFlow_id,
                    profile.profile_name AS profile_name,
                    ref_status_previous.status_desc AS status_previous,
                    ref_status_previous.status_color AS status_previous_color,
                    wf_task.*
                FROM wf_task 
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id 
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task_type.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = 3
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                LEFT JOIN profile ON profile.user_id = wf_transaction.wfTrans_processOfficer AND profile.profile_status = 1 
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id
                LEFT JOIN t_certificate ON t_certificate.certificate_id = wf_task.wfTask_refValue AND t_certificate.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_certificate_issuer ON t_certificate_issuer.certIssuer_id = t_certificate.certIssuer_id
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_certificate.consAll_id 
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_consultant_all.consAll_id 
                LEFT JOIN t_consultant_mobile ON t_consultant_mobile.consAll_id = t_consultant_all.consAll_id 
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr 
                LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                LEFT JOIN ref_status ref_status_previous ON ref_status_previous.status_id = wf_task.wfTask_statusPrevious
                WHERE wf_task.wfTaskType_id = 82";
            } else if ($title == 'dt_qnf_post') {
                $sql = "SELECT 
                    t_qnf.qnf_id AS qnf_id,
                    t_qnf.qnf_timeSubmitted AS qnf_timeSubmitted,
                    t_qnf.qnf_title AS qnf_title,
                    t_qnf.qnf_status AS qnf_status,
                    IFNULL(wf_transaction.wfTrans_regNo,wf_transaction.wfTrans_No) AS wfTrans_regNo,
                    t_qnf_category.qnfCate_desc AS qnfCate_desc,
                    ref_status.status_desc AS status_desc,
                    ref_status.status_color AS status_color,
                    wf_task.*
                FROM wf_task
                INNER JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN t_qnf ON t_qnf.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_qnf_category ON t_qnf_category.qnfCate_id = t_qnf.qnfCate_id
                LEFT JOIN ref_status ON ref_status.status_id = t_qnf.qnf_status
                WHERE wf_transaction.wfTrans_createdBy = [user_id] AND wf_task.wfTask_partition = 1 AND wf_transaction.wfFlow_id = 8 AND wf_task_type.wfTaskType_isEnd = '[is_end]'";
            } else if ($title == 'vw_qnf_details') {
                $sql = "SELECT
                    t_qnf.*,
                    IF(qnf_postType=2,'External','Internal') AS qnf_type,
                    ref_status.status_desc AS status_desc,
                    IF(qnf_postType=2,t_qnf.qnf_name,`profile`.profile_name) AS profile_name,
                    `profile`.profile_mobileNo AS profile_mobileNo,
                    `profile`.profile_email AS profile_email,
                    wf_group.wfGroup_name AS wfGroup_name,
                    IFNULL(wf_transaction.wfTrans_regNo, wf_transaction.wfTrans_no) AS wfTrans_regNo,
                    wf_transaction.wfTrans_processOfficer AS wfTrans_processOfficer
                FROM t_qnf
                LEFT JOIN ref_status ON ref_status.status_id = t_qnf.qnf_status
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_qnf.wfTrans_id
                LEFT JOIN `user` ON `user`.user_id = wf_transaction.wfTrans_createdBy
                LEFT JOIN `profile` ON `profile`.profile_id = `user`.profile_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = wf_transaction.wfTrans_createdByGr";
            } else if ($title == 'dt_qnf_document') {
                $sql = "SELECT 
                    document.*,
                    t_qnf_doc.qnfDoc_id AS qnfDoc_id,
                    t_qnf_doc.qnf_id AS qnf_id,
                    t_qnf_doc.qnfDoc_status AS qnfDoc_status
                FROM t_qnf_doc 
                LEFT JOIN document ON document.document_id = t_qnf_doc.document_id
                WHERE qnfDoc_status <> 8";
            } else if ($title == 'dt_qnf_task') {
                $sql = "SELECT 
                    t_qnf.qnf_id AS qnf_id,
                    t_qnf.qnf_timeSubmitted AS qnf_timeSubmitted,
                    t_qnf.qnf_title AS qnf_title,
                    t_qnf.qnf_status AS qnf_status,
                    t_qnf.qnf_postType AS qnf_postType,
                    IFNULL(wf_transaction.wfTrans_regNo,wf_transaction.wfTrans_No) AS wfTrans_regNo,
                    t_qnf_category.qnfCate_desc AS qnfCate_desc,
                    ref_status.status_desc AS action_desc,
                    ref_status.status_color AS action_color,
                    ref_status2.status_desc AS status_desc,
                    ref_status2.status_color AS status_color,
                    DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired) AS datediff,
                    DATEDIFF(DATE(wf_task.wfTask_timeSubmitted), wf_task.wfTask_dateExpired) AS datediff2,
                    wf_task_excuse.wfExcuse_desc AS wfExcuse_desc,
                    profile.profile_name AS processOfficer,
                    wf_task.*
                FROM wf_task
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task_type.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                INNER JOIN wf_transaction ON wf_transaction.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_qnf ON t_qnf.wfTrans_id = wf_task.wfTrans_id
                LEFT JOIN t_qnf_category ON t_qnf_category.qnfCate_id = t_qnf.qnfCate_id
                LEFT JOIN profile ON profile.user_id = wf_transaction.wfTrans_processOfficer AND profile.profile_status = 1 
                LEFT JOIN ref_status ON ref_status.status_id = wf_task.wfTask_status
                LEFT JOIN ref_status ref_status2 ON ref_status2.status_id = wf_transaction.wfTrans_status
                LEFT JOIN wf_task_excuse ON wf_task_excuse.wfTask_id = wf_task.wfTask_id";
            } else if ($title == 'vw_qa_task') {
                $sql = "SELECT t_qa.*,wf_task.wfTrans_id AS wfTrans_id FROM t_qa
                    INNER JOIN wf_task ON wf_task.wfTask_id = t_qa.wfTask_id";
            } else if ($title == 'vw_industrial_user') {
                $sql = "SELECT 
                    t_industrial_all.indAll_id AS indAll_id,
                    t_industrial_all.indAll_type AS indAll_type,
                    t_industrial.wfGroup_id AS wfGroup_id,
                    wf_group_user.user_id AS user_id
                FROM t_industrial_all
                LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                LEFT JOIN wf_group_user ON wf_group_user.wfGroup_id = t_industrial.wfGroup_id";
            } else if ($title == 'dt_qa') {
                $sql = "SELECT 
                    t_qa.qa_id AS qa_id,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,	
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_industrial_all.indAll_type AS indAll_type,
                    t_industrial_all.indAll_id AS indAll_id,
                    t_qa.qa_type AS qa_type,
                    CASE WHEN t_qa.qa_type = 1 THEN 'CEMS Initial Quality Assurance'
                        WHEN t_qa.qa_type = 2 THEN 'PEMS Initial Quality Assurance'
                        WHEN t_qa.qa_type = 3 THEN 'CEMS Quality Assurance'
                        WHEN t_qa.qa_type = 4 THEN 'CEMS RAA'
                        WHEN t_qa.qa_type = 5 THEN 'PEMS Quality Assurance'
                        WHEN t_qa.qa_type = 6 THEN 'PEMS RAA'
                        END AS qa_types,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_qa.qa_dateExpected AS qa_dateExpected,
                    t_qa.qa_dateActual AS qa_dateActual,
                    ref_status2.status_desc AS action_desc,
                    ref_status2.status_color AS action_color,
                    t_qa.qa_status AS qa_status,
                    CASE 
                        WHEN t_qa.qa_status = '50' THEN 
                            (CASE 
                                WHEN TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected) < 0 THEN CONCAT('Late ',TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected)*-1,'-month')
                                WHEN TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected) > 0 THEN CONCAT('In ',TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected),'-month')			
                                ELSE IF(TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected) < 0, CONCAT('Late ',TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected)*-1,'-day'), CONCAT('In ',TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected),'-day')) END)
                        ELSE ref_status.status_desc END AS status_desc,
                    CASE 
                        WHEN t_qa.qa_status = '50' THEN 
                            IF(TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected) < 0, 'red', 'orange')
                        ELSE ref_status.status_color END AS status_color,
                    wf_task.*
                FROM t_qa
                LEFT JOIN wf_task task_ref ON task_ref.wfTask_id = t_qa.wfTask_id 
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = task_ref.wfTrans_id
                INNER JOIN wf_task ON wf_task.wfTrans_id = wf_transaction.wfTrans_id AND wf_task.wfTask_partition = 1
                INNER JOIN wf_task_user ON wf_task_user.wfTaskType_id = wf_task.wfTaskType_id AND wf_task_user.wfGroup_id = wf_task.wfGroup_id AND wf_task_user.user_id = [user_id]
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_qa.indAll_id
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN ref_status ON ref_status.status_id = t_qa.qa_status
                LEFT JOIN ref_status ref_status2 ON ref_status2.status_id = wf_task.wfTask_status
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                WHERE wf_task.wfGroup_id = [wfGroup_id]";
            } else if ($title == 'dt_qa_list') {
                $sql = "SELECT 
                    t_qa.qa_id AS qa_id,
                    wf_transaction.wfTrans_regNo AS wfTrans_regNo,	
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_industrial_all.indAll_type AS indAll_type,
                    t_industrial_all.indAll_id AS indAll_id,
                    t_qa.qa_type AS qa_type,
                    CASE WHEN t_qa.qa_type = 1 THEN 'CEMS Initial Quality Assurance'
                        WHEN t_qa.qa_type = 2 THEN 'PEMS Initial Quality Assurance'
                        WHEN t_qa.qa_type = 3 THEN 'CEMS Quality Assurance'
                        WHEN t_qa.qa_type = 4 THEN 'CEMS RAA'
                        WHEN t_qa.qa_type = 5 THEN 'PEMS Quality Assurance'
                        WHEN t_qa.qa_type = 6 THEN 'PEMS RAA'
                        END AS qa_types,
                    wf_group.wfGroup_name AS wfGroup_name,
                    t_qa.qa_dateExpected AS qa_dateExpected,
                    t_qa.qa_dateActual AS qa_dateActual,
                    ref_status2.status_desc AS action_desc,
                    ref_status2.status_color AS action_color,
                    t_qa.qa_status AS qa_status,
                    CASE 
                        WHEN t_qa.qa_status = '50' THEN 
                            (CASE 
                                WHEN TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected) < 0 THEN CONCAT('Late ',TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected)*-1,'-month')
                                WHEN TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected) > 0 THEN CONCAT('In ',TIMESTAMPDIFF(MONTH,CURDATE(),t_qa.qa_dateExpected),'-month')			
                                ELSE IF(TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected) < 0, CONCAT('Late ',TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected)*-1,'-day'), CONCAT('In ',TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected),'-day')) END)
                        ELSE ref_status.status_desc END AS status_desc,
                    CASE 
                        WHEN t_qa.qa_status = '50' THEN 
                            IF(TIMESTAMPDIFF(DAY,CURDATE(),t_qa.qa_dateExpected) < 0, 'red', 'orange')
                        ELSE ref_status.status_color END AS status_color,
                    wf_task.*
                FROM t_qa
                LEFT JOIN wf_task task_ref ON task_ref.wfTask_id = t_qa.wfTask_id 
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = task_ref.wfTrans_id
                INNER JOIN wf_task ON wf_task.wfTrans_id = wf_transaction.wfTrans_id AND wf_task.wfTask_partition = 1
                LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_qa.indAll_id
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN ref_status ON ref_status.status_id = t_qa.qa_status
                LEFT JOIN ref_status ref_status2 ON ref_status2.status_id = wf_task.wfTask_status
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id";
            } else if ($title == 'vw_gid_count_registered') {
                $sql = "SELECT COUNT(*) AS total FROM t_industrial";
            } else if ($title == 'vw_gid_count_submitted') {
                $sql = "SELECT COUNT(*) AS total FROM t_industrial WHERE industrial_status IN (32, 24)";
            } else if ($title == 'vw_gid_count_approved') {
                $sql = "SELECT COUNT(*) AS total FROM t_industrial WHERE industrial_status = 24";
            } else if ($title == 'vw_gid_chart_1') {
                $sql = "SELECT 
                    list_time, 
                    DAY(list_time) AS list_day,
                    IFNULL(totals, 0) AS total,
                    (
                        SELECT COUNT(industrial_id) FROM t_industrial WHERE DATE(industrial_timeCreated) <= list_time
                    ) AS total_sum
                FROM 
                (SELECT DATE(industrial_timeCreated) AS dates, COUNT(*) AS totals FROM t_industrial GROUP BY dates) industy 
                RIGHT JOIN 
                (	
                    SELECT ADDDATE(MAKEDATE([year],1)+INTERVAL ([month]) MONTH, INTERVAL (@i:=@i+1) DAY) AS list_time 
                    FROM (
                        SELECT a.a
                            FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                            CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                        ) a
                    JOIN (SELECT @i := -1) r1
                    WHERE 
                    @i < 30 
                ) time_list ON time_list.list_time = industy.dates
                WHERE MONTH(list_time) = [month]+1
                ORDER BY list_time";
            } else if ($title == 'vw_gid_chart_2') {
                $sql = "SELECT 
                    ref_state.state_id AS state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_state 
                LEFT JOIN (
                    SELECT ref_state.state_id AS state_id, COUNT(*) AS total
                    FROM t_industrial 
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id 
                    GROUP BY state_id
                ) table_data ON table_data.state_id = ref_state.state_id ";
            } else if ($title == 'vw_gid_chart_2_sub') {
                $sql = "SELECT 
                    ref_city.city_id, city_report, ref_state.state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_city 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN (
                    SELECT ref_city.city_id AS city_id, COUNT(*) AS total
                    FROM t_industrial 
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    GROUP BY city_id
                ) table_data ON table_data.city_id = ref_city.city_id 
                WHERE city_status = 1";
            } else if ($title == 'vw_gid_chart_3') {
                $sql = "SELECT 
                    ref_sic.sic_id AS sic_id,
                    ref_sic.sic_desc AS sic_desc,
                    COUNT(*) AS total
                FROM t_industrial
                LEFT JOIN ref_sub_sic ON ref_sub_sic.subSic_id = t_industrial.subSic_id
                LEFT JOIN ref_sic ON ref_sic.sic_id = ref_sub_sic.sic_id
                GROUP BY sic_id, sic_desc";
            } else if ($title == 'vw_gcs_count_registered') {
                $sql = "SELECT COUNT(*) AS total FROM t_consultant";
            } else if ($title == 'vw_gcs_count_approved') {
                $sql = "SELECT COUNT(*) AS total FROM t_consultant WHERE consultant_status = 1";
            } else if ($title == 'vw_gcs_chart_1') {
                $sql = "SELECT 
                    list_time, 
                    DAY(list_time) AS list_day,
                    IFNULL(totals, 0) AS total,
                    (
                        SELECT COUNT(consultant_id) FROM (
                            SELECT consultant_id, MIN(DATE(wf_transaction.wfTrans_timeFinish)) AS date_active FROM t_consultant_all 
                            LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_consultant_all.wfTrans_id
                            WHERE consAll_status = 1 
                            GROUP BY consultant_id
                        ) consAll
                        WHERE date_active <= list_time
                    ) AS total_sum
                FROM 
                (SELECT DATE(consultant_timeCreated) AS dates, COUNT(*) AS totals FROM t_consultant GROUP BY dates) consultant 
                RIGHT JOIN 
                (	
                    SELECT ADDDATE(MAKEDATE(2017,1)+INTERVAL ([month]) MONTH, INTERVAL (@i:=@i+1) DAY) AS list_time 
                    FROM (
                        SELECT a.a
                            FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                            CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                        ) a
                    JOIN (SELECT @i := -1) r1
                    WHERE 
                    @i < 30 
                ) time_list ON time_list.list_time = consultant.dates
                WHERE MONTH(list_time) = [month]+1
                ORDER BY list_time";
            } else if ($title == 'vw_gcs_chart_2') {
                $sql = "SELECT 
                    consAll_type, 
                    CASE WHEN consAll_type = 1 THEN 'CEMS'
                        WHEN consAll_type = 2 THEN 'PEMS'
                        WHEN consAll_type = 3 THEN 'Mobile-CEMS'
                    END AS consAll_type_desc, 
                    COUNT(*) AS total 
                FROM
                (
                    SELECT
                        consultant_id,
                        consAll_type
                    FROM t_consultant_all 
                    WHERE consAll_status = 1
                    GROUP BY consultant_id, consAll_type
                ) consAll
                GROUP BY consAll_type";
            } else if ($title == 'vw_gcs_chart_4') {
                $sql = "SELECT 
                    consType_type AS type,
                    CASE WHEN consType_type = 1 THEN 'Gases'
                        WHEN consType_type = 2 THEN 'Particulate'
                        WHEN consType_type = 3 THEN 'Opacity'
                    END AS type_desc, 
                    COUNT(*) AS total
                FROM (SELECT 
                        t_consultant_all.consultant_id AS consultant_id,
                        consType_type 
                    FROM t_consultant_type 
                    LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_consultant_type.consAll_id
                    WHERE t_consultant_all.consAll_status IN (1, 30)
                    GROUP BY consType_type,consultant_id) as xxx 
                GROUP BY type";
            } else if ($title == 'vw_gcs_chart_5') {
                $sql = "SELECT 
                    ref_state.state_id AS state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_state 
                LEFT JOIN (
                    SELECT ref_state.state_id AS state_id, COUNT(*) AS total
                    FROM t_consultant 
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id 
                    GROUP BY state_id
                ) table_data ON table_data.state_id = ref_state.state_id";
            } else if ($title == 'vw_gcs_chart_5_sub') {
                $sql = "SELECT 
                    ref_city.city_id, city_report, ref_state.state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_city 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN (
                    SELECT ref_city.city_id AS city_id, COUNT(*) AS total
                    FROM t_consultant 
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    GROUP BY city_id
                ) table_data ON table_data.city_id = ref_city.city_id 
                WHERE city_status = 1";
            } else if ($title == 'vw_gcs_chart_6') { 
                $sql = "SELECT 
                    t_industrial_all.consultant_id AS consultant_id, 
                    wf_group.wfGroup_name AS wfGroup_name, 
                    SUM(IF(t_consultant_all.consAll_type=1,1,0)) AS total_cems,
                    SUM(IF(t_consultant_all.consAll_type=2,1,0)) AS total_pems,
                    COUNT(*) AS total 
                FROM t_industrial_all 
                LEFT JOIN t_consultant_all ON t_consultant_all.consAll_id = t_industrial_all.consAll_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_all.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                WHERE indAll_status IN (1,27,28,29,30)
                GROUP BY consultant_id, wfGroup_name";
            } else if ($title == 'vw_gcp_count_registered') {
                $sql = "SELECT COUNT(*) AS total FROM t_industrial_all WHERE indAll_status NOT IN (2, 8)";
            } else if ($title == 'vw_gcp_chart_1') {
                $sql = "SELECT 
                    list_time, 
                    DAY(list_time) AS list_day,
                    IFNULL(totals, 0) AS total,
                    (
                        SELECT COUNT(indAll_id) FROM t_industrial_all WHERE DATE(indAll_dateDeclaration) <= list_time AND indAll_status NOT IN (2, 8)
                    ) AS total_sum
                FROM 
                (SELECT DATE(indAll_dateDeclaration) AS dates, COUNT(*) AS totals FROM t_industrial_all WHERE indAll_status NOT IN (2, 8) GROUP BY dates) industy 
                RIGHT JOIN 
                (	
                    SELECT ADDDATE(MAKEDATE([year],1)+INTERVAL ([month]) MONTH, INTERVAL (@i:=@i+1) DAY) AS list_time 
                    FROM (
                        SELECT a.a
                            FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                            CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                        ) a
                    JOIN (SELECT @i := -1) r1
                    WHERE 
                    @i < 30 
                ) time_list ON time_list.list_time = industy.dates
                WHERE MONTH(list_time) = [month]+1
                ORDER BY list_time";
            } else if ($title == 'vw_gcp_chart_2') {
                $sql = "SELECT 
                    ref_state.state_id AS state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_state 
                LEFT JOIN (
                    SELECT ref_state.state_id AS state_id, COUNT(*) AS total
                    FROM t_industrial_all 
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id 
                    WHERE indAll_status NOT IN (2, 8)
                    GROUP BY state_id
                ) table_data ON table_data.state_id = ref_state.state_id ";
            } else if ($title == 'vw_gcp_chart_2_sub') {
                $sql = "SELECT 
                    ref_city.city_id, city_report, ref_state.state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_city 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN (
                    SELECT ref_city.city_id AS city_id, COUNT(*) AS total
                    FROM t_industrial_all 
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    WHERE indAll_status NOT IN (2, 8)
                    GROUP BY city_id
                ) table_data ON table_data.city_id = ref_city.city_id 
                WHERE city_status = 1";
            } else if ($title == 'vw_gcp_chart_3') {
                $sql = "SELECT 
                    indAll_type, 
                    CASE WHEN indAll_type = 1 THEN 'CEMS'
                        WHEN indAll_type = 2 THEN 'PEMS'
                    END AS indAll_type_desc, 
                    COUNT(*) AS total
                FROM t_industrial_all
                WHERE indAll_status NOT IN (2, 8)
                GROUP BY indAll_type";
            } else if ($title == 'vw_gcp_chart_4') {
                $sql = "SELECT 
                    pollutionMonitored_id, 
                    CASE WHEN pollutionMonitored_id = 1 THEN 'Gases'
                        WHEN pollutionMonitored_id = 2 THEN 'Particulate'
                        WHEN pollutionMonitored_id = 3 THEN 'Opacity'
                    END AS pollutionMonitored_desc, 
                    COUNT(*) AS total 
                FROM t_industrial_all 	
                LEFT JOIN t_industrial_pollution ON t_industrial_pollution.indAll_id = t_industrial_all.indAll_id
                WHERE indAll_status NOT IN (2, 8)
                GROUP BY pollutionMonitored_id";
            } else if ($title == 'vw_gcp_chart_5') {
                $sql = "SELECT 
                    t_source_activity.sourceActivity_id AS sourceActivity_id, sourceActivity_desc, IFNULL(table_data.total, 0) AS total 
                FROM t_source_activity 
                LEFT JOIN (
                    SELECT sourceActivity_id, COUNT(*) AS total
                    FROM t_industrial_all 
                    WHERE indAll_status NOT IN (2, 8)
                    GROUP BY sourceActivity_id
                ) table_data ON table_data.sourceActivity_id = t_source_activity.sourceActivity_id";
            } else if ($title == 'vw_gcp_chart_5_sub') {
                $sql = "SELECT 
                    t_source_capacity.sourceCapacity_id AS sourceCapacity_id, 
                    t_source_activity.sourceActivity_id AS sourceActivity_id, 
                    sourceCapacity_desc, 
                    sourceActivity_desc,
                    IFNULL(table_data.total, 0) AS total 
                FROM t_source_capacity 
                LEFT JOIN t_source_activity ON t_source_activity.sourceActivity_id = t_source_capacity.sourceActivity_id
                LEFT JOIN (
                    SELECT sourceCapacity_id, COUNT(*) AS total 
                    FROM t_industrial_all 
                    WHERE indAll_status NOT IN (2, 8)
                    GROUP BY sourceCapacity_id 
                ) table_data ON table_data.sourceCapacity_id = t_source_capacity.sourceCapacity_id";
            } else if ($title == 'vw_gcp_chart_6') {
                $sql = "SELECT 
                        YEAR(indAll_dateDeclaration) AS years, 
                        MONTH(indAll_dateDeclaration) AS months, 
                        ref_city.state_id AS state_id,
                        ref_state.state_desc AS state_desc,
                        COUNT(*) AS totals 
                    FROM t_industrial_all 
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                    LEFT JOIN location ON location.location_id = t_industrial.location_id
                    LEFT JOIN ref_city ON ref_city.city_id = location.city_id
                    LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                    WHERE indAll_status NOT IN (2, 8) 
                    GROUP BY years, months, state_id
                    ORDER BY years DESC, months DESC";
            } else if ($title == 'vw_gcp_chart_7') {
                $sql = "SELECT 
                        YEAR(indAll_dateDeclaration) AS years, 
                        MONTH(indAll_dateDeclaration) AS months, 
                        ref_sic.sic_id AS sic_id,
                        ref_sic.sic_desc AS sic_desc,
                        COUNT(*) AS totals 
                    FROM t_industrial_all 
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                    LEFT JOIN ref_sub_sic ON ref_sub_sic.subSic_id = t_industrial.subSic_id                
                    LEFT JOIN ref_sic ON ref_sic.sic_id = ref_sub_sic.sic_id 
                    WHERE indAll_status NOT IN (2, 8) 
                    GROUP BY years, months, sic_id
                    ORDER BY years DESC, months DESC";
            } else if ($title == 'vw_gca_count_active') {
                $sql = "SELECT COUNT(*) AS total FROM t_consultant_cems WHERE consCems_status = 1";
            } else if ($title == 'vw_gca_chart_1') {
                $sql = "SELECT 
                    t_consultant_type.consType_type AS consType_type,
                    COUNT(*) AS total
                FROM t_consultant_cems
                LEFT JOIN t_consultant_type ON t_consultant_type.consAll_id = t_consultant_cems.consAll_id 
                WHERE consCems_status IN (1,30)
                GROUP BY consType_type";
            } else if ($title == 'vw_gca_chart_2') {
                $sql = "SELECT 
                    t_analyzer_technique.analyzerTechnique_id AS analyzerTechnique_id,
                    t_analyzer_technique.analyzerTechnique_desc AS analyzerTechnique_desc,
                    IFNULL(consultant_cems.total, 0) AS total
                FROM t_analyzer_technique
                LEFT JOIN (
                    SELECT t_consultant_param_method.analyzerTechnique_id AS analyzerTechnique_id, COUNT(*) AS total 
                    FROM t_consultant_param_method
                    LEFT JOIN t_consultant_parameter ON t_consultant_parameter.consParam_id = t_consultant_param_method.consParam_id
                    LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_consultant_parameter.consAll_id
                    WHERE consCems_status IN (1,30)
                    GROUP BY analyzerTechnique_id
                ) consultant_cems ON consultant_cems.analyzerTechnique_id = t_analyzer_technique.analyzerTechnique_id";
            } else if ($title == 'vw_gca_chart_3') {
                $sql = "SELECT 
                    consCems_techniqueType AS consCems_techniqueType,
                    COUNT(*) AS total
                FROM t_consultant_cems
                WHERE consCems_techniqueType IS NOT NULL AND consCems_status = 1
                GROUP BY consCems_techniqueType";
             } else if ($title == 'vw_gca_chart_4') {
                $sql = "SELECT 
                    consCems_isNormalize AS consCems_isNormalize,
                    COUNT(*) AS total
                FROM t_consultant_cems
                WHERE consCems_isNormalize IS NOT NULL AND consCems_status = 1
                GROUP BY consCems_isNormalize";
            } else if ($title == 'vw_gca_chart_5') {
                $sql = "SELECT 
                    SUM(IF(max_expired < CURDATE(), 1, 0)) AS total_expired,  
                    SUM(IF(max_expired >= CURDATE() AND max_expired < CURDATE() + INTERVAL 1 WEEK, 1, 0)) AS total_week,  
                    SUM(IF(max_expired >= CURDATE() + INTERVAL 1 WEEK AND max_expired < CURDATE() + INTERVAL 1 MONTH, 1, 0)) AS total_month,	
                    SUM(IF(max_expired >= CURDATE() + INTERVAL 1 MONTH, 1, 0)) AS total_active
                FROM (
                    SELECT 
                        t_consultant_cems.consAll_id AS consAll_id,
                        MAX(t_certificate.certificate_dateExpired) AS max_expired
                    FROM t_consultant_cems 
                    LEFT JOIN t_certificate ON t_certificate.consAll_id = t_consultant_cems.consAll_id
                    WHERE consCems_status = 1 AND certificate_status = 1
                    GROUP BY consAll_id
                ) expiry";
            } else if ($title == 'dt_industrial_consultant') {
                $sql = "SELECT 
                    t_industrial_consultant.*,
                    IF(t_consultant_unregistered.consAll_id IS NOT NULL, t_consultant_unregistered.consUnr_modelNo, t_consultant_cems.consCems_modelNo) as consCems_modelNo,
                    IF(t_consultant_unregistered.consAll_id IS NOT NULL, '<i>(Unregistered)</i>', wf_transaction.wfTrans_regNo)  AS wfTrans_regNo,
                    IF(t_consultant_unregistered.consAll_id IS NOT NULL, t_consultant_unregistered.consUnr_consultant, wf_group.wfGroup_name) AS wfGroup_name,
                    IF(t_consultant_unregistered.consAll_id IS NOT NULL, 'u', 'c') AS consultant_type,
                    cons_param.list_param AS list_param
                FROM t_industrial_consultant 
                LEFT JOIN t_consultant_cems ON t_consultant_cems.consAll_id = t_industrial_consultant.consAll_id 
                LEFT JOIN t_consultant_unregistered ON t_consultant_unregistered.consAll_id = t_industrial_consultant.consAll_id 
                LEFT JOIN wf_transaction ON wf_transaction.wfTrans_id = t_consultant_cems.wfTrans_id
                LEFT JOIN t_consultant ON t_consultant.consultant_id = t_consultant_cems.consultant_id
                LEFT JOIN wf_group ON wf_group.wfGroup_id = t_consultant.wfGroup_id
                LEFT JOIN (
                    SELECT consAll_id, GROUP_CONCAT(t_input_parameter.inputParam_desc ORDER BY t_input_parameter.inputParam_id ASC SEPARATOR ', ') AS list_param
                    FROM t_consultant_parameter 
                    LEFT JOIN t_input_parameter ON t_input_parameter.inputParam_id = t_consultant_parameter.inputParam_id
                    GROUP BY consAll_id
                    ) cons_param ON cons_param.consAll_id = t_industrial_consultant.consAll_id";
            } else if ($title == 'vw_industial_param_covered') {
                $sql = "SELECT 
                    DISTINCT(inputParam_id) AS param_list
                FROM t_industrial_consultant 
                LEFT JOIN t_consultant_parameter ON t_consultant_parameter.consAll_id = t_industrial_consultant.consAll_id
                WHERE t_industrial_consultant.indAll_id = [indAll_id]";
            } else if ($title == 'vw_hm_chart_5') {
                $sql = "SELECT 
                    ref_state.state_id AS state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_state 
                LEFT JOIN (	
                    SELECT 
                        ref_city.state_id AS state_id, COUNT(*) AS total
                    FROM t_response 
                    LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    LEFT JOIN ref_city ON ref_city.city_id = address.city_id
                    WHERE t_response.response_date = '[response_date]' AND t_response.response_type = [response_type]
                    GROUP BY state_id
                ) table_data ON table_data.state_id = ref_state.state_id";
            } else if ($title == 'vw_hm_chart_5_sub') {
                $sql = "SELECT 
                    ref_city.city_id, city_report, ref_state.state_id, state_desc, IFNULL(table_data.total, 0) AS total 
                FROM ref_city 
                LEFT JOIN ref_state ON ref_state.state_id = ref_city.state_id
                LEFT JOIN (
                    SELECT 
                        address.city_id AS city_id, COUNT(*) AS total
                    FROM t_response 
                    LEFT JOIN t_industrial_all ON t_industrial_all.indAll_id = t_response.indAll_id
                    LEFT JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                    LEFT JOIN wf_group ON wf_group.wfGroup_id = t_industrial.wfGroup_id 
                    LEFT JOIN wf_group_profile ON wf_group_profile.wfGroupProfile_id = wf_group.wfGroupProfile_id
                    LEFT JOIN address ON address.address_id = wf_group_profile.wfGroup_address
                    WHERE t_response.response_date = '[response_date]' AND t_response.response_type = [response_type]
                    GROUP BY city_id
                ) table_data ON table_data.city_id = ref_city.city_id 
                WHERE city_status = 1";
            } else if ($title == 'dt_30_minute') {
                $sql = "SELECT 
                    stack_id,
                    FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(data_timestamp)/(30* 60)) * (30*60)) AS thirtyHourInterval,
                    SUM(IF(data_1 IS NOT NULL, data_1, 0)) AS sum_1,
                    SUM(IF(data_1 IS NOT NULL, 1, 0)) AS count_1,
                    SUM(IF(data_2 IS NOT NULL, data_2, 0)) AS sum_2,
                    SUM(IF(data_2 IS NOT NULL, 1, 0)) AS count_2,
                    SUM(IF(data_3 IS NOT NULL, data_3, 0)) AS sum_3,
                    SUM(IF(data_3 IS NOT NULL, 1, 0)) AS count_3,
                    SUM(IF(data_4 IS NOT NULL, data_4, 0)) AS sum_4,
                    SUM(IF(data_4 IS NOT NULL, 1, 0)) AS count_4,
                    SUM(IF(data_5 IS NOT NULL, data_5, 0)) AS sum_5,
                    SUM(IF(data_5 IS NOT NULL, 1, 0)) AS count_5,
                    SUM(IF(data_6 IS NOT NULL, data_6, 0)) AS sum_6,
                    SUM(IF(data_6 IS NOT NULL, 1, 0)) AS count_6,
                    SUM(IF(data_7 IS NOT NULL, data_7, 0)) AS sum_7,
                    SUM(IF(data_7 IS NOT NULL, 1, 0)) AS count_7
                FROM [tablename] 
                WHERE DATE(data_timestamp) = '[data_timestamp]'
                GROUP BY stack_id, thirtyHourInterval
                ORDER BY stack_id, data_timestamp";
            } else if ($title == 'dt_pool_summary') {
                $sql = "SELECT 
                    stack_id, DATE(data_timestamp) AS dates,
                    SUM(IF(data_1 IS NOT NULL AND data_1<>0, 1, 0)) AS count_1,
                    SUM(IF(data_2 IS NOT NULL AND data_2<>0, 1, 0)) AS count_2,
                    SUM(IF(data_3 IS NOT NULL AND data_3<>0, 1, 0)) AS count_3,
                    SUM(IF(data_4 IS NOT NULL AND data_4<>0, 1, 0)) AS count_4,
                    SUM(IF(data_5 IS NOT NULL AND data_5<>0, 1, 0)) AS count_5,
                    SUM(IF(data_6 IS NOT NULL AND data_6<>0, 1, 0)) AS count_6,
                    SUM(IF(data_7 IS NOT NULL AND data_7<>0, 1, 0)) AS count_7,
                    SUM(IF(data_8 IS NOT NULL AND data_8<>0, 1, 0)) AS count_8,
                    SUM(IF(data_9 IS NOT NULL AND data_9<>0, 1, 0)) AS count_9,
                    SUM(IF(data_10 IS NOT NULL AND data_10<>0, 1, 0)) AS count_10,
                    COUNT(*) 
                FROM [tablename] 
                WHERE data_timeCreated >= '[time_start]' AND data_timeCreated < '[time_end]'
                GROUP BY stack_id, dates";
            } else if ($title == 'dt_compliance_month') {
                $sql = "SELECT 
                    UNIX_TIMESTAMP(CONVERT_TZ(data_timestamp, '+00:00', '+08:00'))*1000 AS time_utc,
                    TIMESTAMPDIFF(MINUTE,'[yr]-01-01 00:00:00',data_timestamp) AS minute_index,
                    data_[input_param] AS data_value 
                FROM [tablename] 
                WHERE YEAR(data_timestamp) = [yr] AND MONTH(data_timestamp) = [mnth] AND stack_id = [stack_id]";
            } else if ($title == 'dt_compliance_summary') {
                $sql = "SELECT 
                    t_industrial.industrial_premiseId AS industrial_premiseId,
                    t_industrial.industrial_id AS industrial_id,
                    t_industrial_all.indAll_id AS indAll_id,
                    t_industrial_all.indAll_stackNo AS indAll_stackNo,
                    t_industrial_parameter.indParam_limitValue AS indParam_limitValue,
                    t_pub.inputParam_id AS inputParam_id
                FROM t_industrial_parameter
                INNER JOIN t_industrial_all ON t_industrial_all.indAll_id = t_industrial_parameter.indAll_id
                INNER JOIN t_industrial ON t_industrial.industrial_id = t_industrial_all.industrial_id
                INNER JOIN t_pub ON t_pub.pub_id = t_industrial_parameter.pub_id 
                INNER JOIN [table_summary] ydata ON ydata.industrial_id = t_industrial.industrial_id AND ydata.stack_id = t_industrial_all.indAll_stackNo AND 
                    ydata.inputParam_id = t_pub.inputParam_id AND ydata.ydaily_date = '[date_pool_start]' AND ydata.ydaily_result = 2
                WHERE t_industrial_all.indAll_status IN (1, 30) AND t_pub.inputParam_id <= 8
                    AND t_industrial_all.indAll_datePoolStart <= '[date_pool_start]'";
            } else if ($title == 'dt_list_date') {
                $sql = "SELECT ADDDATE('[date_start]', INTERVAL @i:=@i+1 DAY) AS DAY
                FROM (
                    SELECT a.a
                    FROM (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS a
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS b
                    CROSS JOIN (SELECT 0 AS a UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9) AS c
                    ) a
                JOIN (SELECT @i := -1) r1
                WHERE 
                @i < DATEDIFF([date_end], '[date_start]')";     
            } else if ($title == 'dt_30min_by_stack') {
                $sql = "SELECT 
                    FROM_UNIXTIME(FLOOR(UNIX_TIMESTAMP(data_timestamp)/(30* 60)) * (30*60)) AS thirtyHourInterval,
                    SUM(IF(data_[inputParam_id] IS NOT NULL, data_[inputParam_id], 0)) AS sums,
                    SUM(IF(data_[inputParam_id] IS NOT NULL, 1, 0)) AS counts
                FROM [tablename]
                WHERE DATE(data_timestamp) = '[data_timestamp]' AND stack_id = '[stack_id]'
                GROUP BY thirtyHourInterval
                ORDER BY data_timestamp";
            } else if ($title == 'vw_kpi_chart_1') {
                $sql = "SELECT
                    wf_task_type.wfTaskType_id AS wfTaskType_id,
                    wf_flow.wfFlow_desc AS wfFlow_desc,
                    wf_task_type.wfTaskType_name AS wfTaskType_name,
                    SUM(IF(DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired)>0, 1, 0)) AS late, 
                    SUM(IF(DATEDIFF(CURDATE(), wf_task.wfTask_dateExpired)<=0, 1, 0)) AS ontime
                FROM wf_task
                LEFT JOIN wf_task_type ON wf_task_type.wfTaskType_id = wf_task.wfTaskType_id
                LEFT JOIN wf_flow ON wf_flow.wfFlow_id = wf_task_type.wfFlow_id
                WHERE wf_task.wfTask_partition = 1 AND wf_task_type.wfTaskType_isEnd = 'N' AND wf_task_type.wfGroup_id = 1
                GROUP BY wfTaskType_id ORDER BY wfTaskType_id";
            } else if ($title == 'vw_data_dates_by_month') {
                $sql = "SELECT
                    DATE(data_timestamp) AS dates, COUNT(*) AS total
                FROM [tablename]
                WHERE YEAR(data_timestamp) = [data_year] AND MONTH(data_timestamp) = [data_month] 
                GROUP BY dates";
            } else
                throw new Exception($this->get_exception('0098', __FUNCTION__, __LINE__, 'Sql not exist : '.$title)); 
            return $sql;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            if ($e->getCode() == 30) { $errCode = 32; } else { $errCode = $e->getCode(); }
            throw new Exception($this->get_exception('0099', __FUNCTION__, __LINE__, $e->getMessage()), $errCode);
        }
    }
    
}

?>
