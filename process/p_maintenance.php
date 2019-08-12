<?php

session_start();
require_once '../library/db.php';
require_once '../function/f_task.php';
require_once '../function/f_upload.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form

try {
    /* Validate the form on the server side - 5500 -> 6500 */
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) [' . __LINE__ . '] - Post[funct] empty.');
    } else {
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        $fn_task = new Class_task();          
        $fn_upload = new Class_upload();   
        if ($_POST['funct'] == 'create_state') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6515) [' . __LINE__ . '] - Field State empty.', 32);
            else if (Class_db::getInstance()->db_count('ref_state', array('state_desc' => $_POST['mrf_ref_desc'])) > 0)
                throw new Exception('(ErrCode:6516) [' . __LINE__ . '] - State already exist.', 32);
            $result = Class_db::getInstance()->db_insert('ref_state', array('state_desc' => $_POST['mrf_ref_desc']));
        } else if ($_POST['funct'] == 'edit_state') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6515) [' . __LINE__ . '] - Field State empty.', 32);
            else if (Class_db::getInstance()->db_count('ref_state', array('state_desc' => $_POST['mrf_ref_desc'], 'state_id' => '<>'.$_POST['mrf_ref_id'])) > 0) 
                throw new Exception('(ErrCode:6516) [' . __LINE__ . '] - State already exist.', 32);
            $result = Class_db::getInstance()->db_update('ref_state', array('state_desc' => $_POST['mrf_ref_desc']), array('state_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_city') {            
            if (empty($_POST['mrf_ref_desc']))          throw new Exception('(ErrCode:6519) [' . __LINE__ . '] - Field City empty.', 32);
            else if (empty($_POST['mrf_opt_parent']))   throw new Exception('(ErrCode:6515) [' . __LINE__ . '] - Field State empty.', 32);
            else if (Class_db::getInstance()->db_count('ref_city', array('city_desc' => $_POST['mrf_ref_desc'], 'state_id' => $_POST['mrf_opt_parent'])) > 0)
                throw new Exception('(ErrCode:6520) [' . __LINE__ . '] - City already exist.', 32);
            $result = Class_db::getInstance()->db_insert('ref_city', array('city_desc' => $_POST['mrf_ref_desc'], 'state_id' => $_POST['mrf_opt_parent']));
        } else if ($_POST['funct'] == 'edit_city') {
            if (empty($_POST['mrf_ref_id']))            throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc']))     throw new Exception('(ErrCode:6519) [' . __LINE__ . '] - Field City empty.', 32);
            else if (empty($_POST['mrf_opt_parent']))   throw new Exception('(ErrCode:6515) [' . __LINE__ . '] - Field State empty.', 32);
            else if (Class_db::getInstance()->db_count('ref_city', array('city_desc' => $_POST['mrf_ref_desc'], 'state_id' => $_POST['mrf_opt_parent'], 'city_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:5514) [' . __LINE__ . '] - City already exist.', 32);
            $result = Class_db::getInstance()->db_update('ref_city', array('city_desc' => $_POST['mrf_ref_desc'], 'state_id' => $_POST['mrf_opt_parent']), array('city_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_department') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6521) [' . __LINE__ . '] - Field Department empty.', 32);
            else if (Class_db::getInstance()->db_count('ref_department', array('department_desc' => $_POST['mrf_ref_desc'])) > 0) 
                throw new Exception('(ErrCode:6522) [' . __LINE__ . '] - Department already exist.', 32);
            $result = Class_db::getInstance()->db_insert('ref_department', array('department_desc' => $_POST['mrf_ref_desc']));
        } else if ($_POST['funct'] == 'edit_department') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6521) [' . __LINE__ . '] - Field Department empty.', 32);
            else if (Class_db::getInstance()->db_count('ref_department', array('department_desc' => $_POST['mrf_ref_desc'], 'department_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:6522) [' . __LINE__ . '] - Department already exist.', 32);
            $result = Class_db::getInstance()->db_update('ref_department', array('department_desc' => $_POST['mrf_ref_desc']), array('department_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_inquiry_category') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6523) [' . __LINE__ . '] - Field Inquiry Category empty.', 32);
            else if (Class_db::getInstance()->db_count('t_qnf_category', array('qnfCate_desc' => $_POST['mrf_ref_desc'])) > 0)
                throw new Exception('(ErrCode:6524) [' . __LINE__ . '] - Inquiry Category already exist.', 32);
            $result = Class_db::getInstance()->db_insert('t_qnf_category', array('qnfCate_desc' => $_POST['mrf_ref_desc']));
        } else if ($_POST['funct'] == 'edit_inquiry_category') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6523) [' . __LINE__ . '] - Field Inquiry Category empty.', 32);
            else if (Class_db::getInstance()->db_count('t_qnf_category', array('qnfCate_desc' => $_POST['mrf_ref_desc'], 'qnfCate_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:6524) [' . __LINE__ . '] - Inquiry Category already exist.', 32);
            $result = Class_db::getInstance()->db_update('t_qnf_category', array('qnfCate_desc' => $_POST['mrf_ref_desc']), array('qnfCate_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_certificate_issuer') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6525) [' . __LINE__ . '] - Field Certificate Issuer empty.', 32);
            else if (Class_db::getInstance()->db_count('t_certificate_issuer', array('certIssuer_desc' => $_POST['mrf_ref_desc'])) > 0) 
                throw new Exception('(ErrCode:6526) [' . __LINE__ . '] - Certificate Issuer already exist.', 32);
            $result = Class_db::getInstance()->db_insert('t_certificate_issuer', array('certIssuer_desc' => $_POST['mrf_ref_desc']));
        } else if ($_POST['funct'] == 'edit_certificate_issuer') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6525) [' . __LINE__ . '] - Field Certificate Issuer empty.', 32);
            else if (Class_db::getInstance()->db_count('t_certificate_issuer', array('certIssuer_desc' => $_POST['mrf_ref_desc'], 'certIssuer_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:6526) [' . __LINE__ . '] - Certificate Issuer already exist.', 32);
            $result = Class_db::getInstance()->db_update('t_certificate_issuer', array('certIssuer_desc' => $_POST['mrf_ref_desc']), array('certIssuer_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_software_method') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6527) [' . __LINE__ . '] - Field Software Predictive Method empty.', 32);
            else if (Class_db::getInstance()->db_count('t_software_method', array('softwareMethod_desc' => $_POST['mrf_ref_desc'])) > 0)
                throw new Exception('(ErrCode:6528) [' . __LINE__ . '] - Software Predictive Method already exist.', 32);
            $result = Class_db::getInstance()->db_insert('t_software_method', array('softwareMethod_desc' => $_POST['mrf_ref_desc']));
        } else if ($_POST['funct'] == 'edit_software_method') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6527) [' . __LINE__ . '] - Field Software Predictive Method empty.', 32);
            else if (Class_db::getInstance()->db_count('t_software_method', array('softwareMethod_desc' => $_POST['mrf_ref_desc'], 'softwareMethod_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:6528) [' . __LINE__ . '] - Software Predictive Method already exist.', 32);
            $result = Class_db::getInstance()->db_update('t_software_method', array('softwareMethod_desc' => $_POST['mrf_ref_desc']), array('softwareMethod_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_CEMS_description') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6529) [' . __LINE__ . '] - Field CEMS Industrial Process Description empty.', 32);
            else if (Class_db::getInstance()->db_count('document_name', array('documentName_desc' => $_POST['mrf_ref_desc'], 'documentName_type' => 'cems')) > 0)
                throw new Exception('(ErrCode:6530) [' . __LINE__ . '] - CEMS Industrial Process Description already exist.', 32);
            $result = Class_db::getInstance()->db_insert('document_name', array('documentName_desc' => $_POST['mrf_ref_desc'], 'documentName_type' => 'cems'));
        } else if ($_POST['funct'] == 'edit_CEMS_description') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6529) [' . __LINE__ . '] - Field CEMS Industrial Process Description empty.', 32);
            else if (Class_db::getInstance()->db_count('document_name', array('documentName_desc' => $_POST['mrf_ref_desc'], 'documentName_type' => 'cems', 'documentName_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:6530) [' . __LINE__ . '] - CEMS Industrial Process Description already exist.', 32);
            $result = Class_db::getInstance()->db_update('document_name', array('documentName_desc' => $_POST['mrf_ref_desc']), array('documentName_id' => $_POST['mrf_ref_id']));    
        } else if ($_POST['funct'] == 'create_PEMS_description') {            
            if (empty($_POST['mrf_ref_desc']))      throw new Exception('(ErrCode:6531) [' . __LINE__ . '] - Field PEMS Industrial Process Description empty.', 32);
            else if (Class_db::getInstance()->db_count('document_name', array('documentName_desc' => $_POST['mrf_ref_desc'], 'documentName_type' => 'pems')) > 0)
                throw new Exception('(ErrCode:6532) [' . __LINE__ . '] - PEMS Industrial Process Description already exist.', 32);
            $result = Class_db::getInstance()->db_insert('document_name', array('documentName_desc' => $_POST['mrf_ref_desc'], 'documentName_type' => 'pems'));
        } else if ($_POST['funct'] == 'edit_PEMS_description') {
            if (empty($_POST['mrf_ref_id']))        throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            else if (empty($_POST['mrf_ref_desc'])) throw new Exception('(ErrCode:6531) [' . __LINE__ . '] - Field PEMS Industrial Process Description empty.', 32);
            else if (Class_db::getInstance()->db_count('document_name', array('documentName_desc' => $_POST['mrf_ref_desc'], 'documentName_type' => 'pems', 'documentName_id' => '<>'.$_POST['mrf_ref_id'])) > 0)
                throw new Exception('(ErrCode:6532) [' . __LINE__ . '] - PEMS Industrial Process Description already exist.', 32);
            $result = Class_db::getInstance()->db_update('document_name', array('documentName_desc' => $_POST['mrf_ref_desc']), array('documentName_id' => $_POST['mrf_ref_id']));             
        } else if ($_POST['funct'] == 'add_user') {
            if (empty($_POST['mus_profile_mobileNo']))              throw new Exception('(ErrCode:6504) [' . __LINE__ . '] - Field Mobile No. empty.', 32);
            else if (empty($_POST['mus_profile_email']))            throw new Exception('(ErrCode:6505) [' . __LINE__ . '] - Field Email Address empty.', 32);
            else if (empty($_POST['mus_wfGroupUser_designation']))  throw new Exception('(ErrCode:6506) [' . __LINE__ . '] - Field Designation empty.', 32);
            else if (empty($_POST['mus_profile_name']))             throw new Exception('(ErrCode:6510) [' . __LINE__ . '] - Field Name empty.', 32);
            else if (empty($_POST['mus_profile_icNo']))             throw new Exception('(ErrCode:6511) [' . __LINE__ . '] - Field Identification No. empty.', 32);
            else if (empty($_POST['mus_wfGroup_id']))               throw new Exception('(ErrCode:6507) [' . __LINE__ . '] - Field Agency empty.', 32);
            else if (empty($_POST['mus_department_id']))            throw new Exception('(ErrCode:6508) [' . __LINE__ . '] - Field Department empty.', 32);
            else if (empty($_POST['mus_role_comma']))               throw new Exception('(ErrCode:6512) [' . __LINE__ . '] - Field Roles empty.', 32);
            else if (Class_db::getInstance()->db_count('user', array('user_name'=>$_POST['mus_profile_email'])) > 0) 
                throw new Exception('(ErrCode:6513) [' . __LINE__ . '] - Identification No. already exist.', 32);
            $user_id = Class_db::getInstance()->db_insert('user', array('user_name'=>str_replace('@doe.gov.my', '', $_POST['mus_profile_email']), 'user_password'=>$fn_task->generateRandomString(10), 'user_type'=>'1'));
            $profile_id = Class_db::getInstance()->db_insert('profile', array('user_id'=>$user_id, 'profile_name'=>$_POST['mus_profile_name'], 'profile_icNo'=>$_POST['mus_profile_icNo'], 
                'profile_mobileNo'=>$_POST['mus_profile_mobileNo'], 'profile_email'=>$_POST['mus_profile_email'], 'profile_createdBy'=>$_SESSION['user_id'])); 
            Class_db::getInstance()->db_update('user', array('profile_id'=>$profile_id), array('user_id'=>$user_id));
            Class_db::getInstance()->db_insert('wf_group_user', array('wfGroup_id'=>$_POST['mus_wfGroup_id'], 'user_id'=>$user_id, 'department_id'=>$_POST['mus_department_id'], 'wfGroupUser_designation'=>$_POST['mus_wfGroupUser_designation'],
                'wfGroupUser_dateActive'=>'Now()'));
            $arr_role_select = explode(',', $_POST['mus_role_comma']); 
            foreach ($arr_role_select as $key => $value) {
                Class_db::getInstance()->db_insert('user_type', array('user_id'=>$user_id, 'uType_id'=>$value));
                $arr_wfTaskType_id = Class_db::getInstance()->db_select_colm('wf_task_type', array('uType_id'=>$value), 'wfTaskType_id');
                foreach ($arr_wfTaskType_id as $wfTaskType_id) {
                    Class_db::getInstance()->db_insert('wf_task_user', array('user_id'=>$user_id, 'wfTaskType_id'=>$wfTaskType_id, 'wfGroup_id'=>$_POST['mus_wfGroup_id']));
                }
            }                        
            $result = $user_id;
        } else if ($_POST['funct'] == 'update_user') {
            if (empty($_POST['mus_user_id'])) {
                throw new Exception('(ErrCode:6501) [' . __LINE__ . '] - Parameter user_id empty.', 32);
            } else if (empty($_POST['mus_user_type'])) {
                throw new Exception('(ErrCode:6502) [' . __LINE__ . '] - Parameter user_type empty.');
            } else if (empty($_POST['mus_profile_mobileNo'])) {
                throw new Exception('(ErrCode:6504) [' . __LINE__ . '] - Field Mobile No. empty.', 32);
            } else if (empty($_POST['mus_wfGroupUser_designation'])) {
                throw new Exception('(ErrCode:6506) [' . __LINE__ . '] - Field Designation empty.', 32);
            }
            $user_id = $_POST['mus_user_id'];
            $user = Class_db::getInstance()->db_select_single('user', array('user_id'=>$user_id), NULL, 1);            
            $wf_group_user = Class_db::getInstance()->db_select_single('wf_group_user', array('user_id'=>$user_id, 'wfGroupUser_status'=>'1', 'wfGroupUser_isMain'=>'1'), NULL, 1);
            if ($_POST['mus_user_status'] == '0' && $user['user_status'] == '1') {
                log_debug(__LINE__, 'Deactivate active user', $log_dir);
                if (Class_db::getInstance()->db_count('wf_task', array('wfTask_claimedBy'=>$user_id, 'wfGroup_id'=>$wf_group_user['wfGroup_id'], 'wfTask_partition'=>'1')) > 0) {
                    throw new Exception('(ErrCode:6509) [' . __LINE__ . '] - There still tasks owned by this user. Make sure all task delegated from this user before change Agency or Roles.');
                }
                Class_db::getInstance()->db_update('user', array('user_status'=>'0'), array('user_id'=>$user_id));
            } else if ($_POST['mus_user_status'] == '1' && $user['user_status'] == '0') {
                log_debug(__LINE__, 'Active inactive user', $log_dir);
                Class_db::getInstance()->db_update('user', array('user_status'=>'1'), array('user_id'=>$user_id));
            }
            if ($_POST['mus_user_type'] == '1') {
                Class_db::getInstance()->db_update('profile', array('profile_mobileNo'=>$_POST['mus_profile_mobileNo'], 'profile_icNo'=>$_POST['mus_profile_icNo']), array('profile_id'=>$user['profile_id']));
                if (empty($_POST['mus_wfGroup_id']))            throw new Exception('(ErrCode:6507) [' . __LINE__ . '] - Field Agency empty.', 32);
                else if (empty($_POST['mus_department_id']))    throw new Exception('(ErrCode:6508) [' . __LINE__ . '] - Field Department empty.', 32);
                else if (Class_db::getInstance()->db_count('wf_task', array('wfTask_claimedBy'=>$user_id, 'wfGroup_id'=>$wf_group_user['wfGroup_id'], 'wfTask_status'=>'<>2', 'wfTask_partition'=>'1')) > 0) 
                    throw new Exception('(ErrCode:6509) [' . __LINE__ . '] - There still tasks owned by this user. Make sure all task delegated from this user before change Agency or Roles.', 32);
                if ($_POST['mus_wfGroup_id'] == $wf_group_user['wfGroup_id']) {
                    Class_db::getInstance()->db_update('wf_group_user', array('wfGroupUser_designation'=>$_POST['mus_wfGroupUser_designation'], 'department_id'=>$_POST['mus_department_id']), array('wfGroupUser_id'=>$wf_group_user['wfGroupUser_id'])); 
                } else {
                    Class_db::getInstance()->db_update('wf_group_user', array('wfGroupUser_status'=>'3', 'wfGroupUser_timeEnd'=>'Now()'), array('wfGroupUser_id'=>$wf_group_user['wfGroupUser_id'])); 
                    Class_db::getInstance()->db_insert('wf_group_user', array('wfGroup_id'=>$_POST['mus_wfGroup_id'], 'user_id'=>$user_id, 'department_id'=>$_POST['mus_department_id'], 'wfGroupUser_designation'=>$_POST['mus_wfGroupUser_designation'],
                        'wfGroupUser_dateActive'=>'Now()'));
                    Class_db::getInstance()->db_update('wf_task_user', array('wfGroup_id'=>$_POST['mus_wfGroup_id']), array('user_id'=>$user_id, 'wfGroup_id'=>$wf_group_user['wfGroup_id']));
                }
                $arr_role_all = Class_db::getInstance()->db_select_colm('ref_utype', array('uType_cate'=>'1'), 'uType_id', NULL, 1);
                $arr_role_current = Class_db::getInstance()->db_select_colm('user_type', array('user_id'=>$user_id), 'uType_id', NULL, 1);
                $arr_role_select = array();
                if (!empty($_POST['mus_role_comma'])) {        
                    $arr_role_select = explode(',', $_POST['mus_role_comma']); 
                }
                foreach ($arr_role_all as $key => $value) {
                    $arr_wfTaskType_id = Class_db::getInstance()->db_select_colm('wf_task_type', array('uType_id'=>$value), 'wfTaskType_id');
                    if (in_array($value, $arr_role_current) && in_array($value, $arr_role_select)) {
                        log_debug(__LINE__, 'Roles - Exist current and selected', $log_dir);
                    } else if (in_array($value, $arr_role_current) && !in_array($value, $arr_role_select)) {
                        log_debug(__LINE__, 'Roles - Exist current but not selected', $log_dir);
                        Class_db::getInstance()->db_delete('user_type', array('user_id'=>$user_id, 'uType_id'=>$value));
                        if (!empty($arr_wfTaskType_id)) {
                            Class_db::getInstance()->db_delete('wf_task_user', array('user_id'=>$user_id, 'wfTaskType_id'=>'('.implode($arr_wfTaskType_id,',').')', 'wfGroup_id'=>$wf_group_user['wfGroup_id']));
                        }
                    } else if (!in_array($value, $arr_role_current) && in_array($value, $arr_role_select)) {
                        log_debug(__LINE__, 'Roles - Not exist current but selected', $log_dir);
                        Class_db::getInstance()->db_insert('user_type', array('user_id'=>$user_id, 'uType_id'=>$value));
                        foreach ($arr_wfTaskType_id as $wfTaskType_id) {
                            Class_db::getInstance()->db_insert('wf_task_user', array('user_id'=>$user_id, 'wfTaskType_id'=>$wfTaskType_id, 'wfGroup_id'=>$_POST['mus_wfGroup_id']));
                        }                            
                    } else if (!in_array($value, $arr_role_current) && !in_array($value, $arr_role_select)) {
                        log_debug(__LINE__, 'Roles - Not exist current and not selected', $log_dir);
                    }
                }
            } else if ($_POST['mus_user_type'] == '2') {
                Class_db::getInstance()->db_update('profile', array('profile_mobileNo'=>$_POST['mus_profile_mobileNo'], 'profile_email'=>$_POST['mus_profile_email']), array('profile_id'=>$user['profile_id']));
                Class_db::getInstance()->db_update('wf_group_user', array('wfGroupUser_designation'=>$_POST['mus_wfGroupUser_designation']), array('wfGroupUser_id'=>$wf_group_user['wfGroupUser_id'])); 
            } else
                throw new Exception('(ErrCode:6503) [' . __LINE__ . '] - Parameter user_type invalid = '.$_POST['mus_user_type']);
            
            $result = '1';
        } else if ($_POST['funct'] == 'update_status_ref') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:6500) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['tablename']))    throw new Exception('(ErrCode:6517) [' . __LINE__ . '] - Parameter tablename empty.');
            else if (empty($arrayParam['prefix']))  throw new Exception('(ErrCode:6518) [' . __LINE__ . '] - Parameter prefix empty.');
            else if (empty($arrayParam['ref_id']))  throw new Exception('(ErrCode:6514) [' . __LINE__ . '] - Parameter ref_id empty.');
            Class_db::getInstance()->db_update($arrayParam['tablename'], array($arrayParam['prefix'].'_status'=>$arrayParam['status']), array($arrayParam['prefix'].'_id'=>$arrayParam['ref_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'create_qnf_internal') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:6500) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfGroup_id']))   throw new Exception('(ErrCode:6533) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            $wfTask_id = $fn_task->task_create($_SESSION['user_id'], '8', $arrayParam['wfGroup_id'], '72');
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            $qnf_id = Class_db::getInstance()->db_insert('t_qnf', array('wfTrans_id'=>$wfTrans_id, 'qnf_postType'=>'1', 'qnf_status'=>'2'));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_refName'=>'qnf_id', 'wfTask_refValue'=>$qnf_id), array('wfTask_id'=>$wfTask_id));
            $result['qnf_id'] = $qnf_id;
            $result['wfTask_id'] = $wfTask_id;
        } else if ($_POST['funct'] == 'save_qnf_doc') {
            if (empty($_POST['mqf_qnf_id']))        throw new Exception('(ErrCode:6534) [' . __LINE__ . '] - Parameter qnf_id empty.');  
            if (empty($_POST['mqf_supDoc_name']))   throw new Exception('(ErrCode:6535) [' . __LINE__ . '] - Field Supporting Attachment Name empty.', 32); 
            if (empty($_FILES['mqf_supDoc_file']['name']))   throw new Exception('(ErrCode:6536) [' . __LINE__ . '] - File Supporting Attachment empty.', 32); 
            $document_id = !empty($_FILES['mqf_supDoc_file']['name']) ? $fn_upload->upload_file('1', $_FILES['mqf_supDoc_file'], $_POST['mqf_supDoc_name'], '22', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qnf_doc', array('qnf_id'=>$_POST['mqf_qnf_id'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'delete_qnf_doc') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:6500) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['qnfDoc_id']))    throw new Exception('(ErrCode:6537) [' . __LINE__ . '] - Parameter qnfDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_qnf_doc', array('qnfDoc_id'=>$arrayParam['qnfDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_qnf_doc', array('qnfDoc_status'=>'8'), array('qnfDoc_id'=>$arrayParam['qnfDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_qnf_post') {
            if (empty($_POST['mqf_qnf_id']))        throw new Exception('(ErrCode:6534) [' . __LINE__ . '] - Parameter qnf_id empty.');  
            Class_db::getInstance()->db_update('t_qnf', array('qnf_title'=>$_POST['mqf_qnf_title'], 'qnfCate_id'=>$_POST['mqf_qnfCate_id'], 'qnf_message'=>$_POST['mqf_qnf_message']), array('qnf_id'=>$_POST['mqf_qnf_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_qnf_reply') {
            if (empty($_POST['mqf_wfTask_id']))         throw new Exception('(ErrCode:6541) [' . __LINE__ . '] - Parameter wfTask_id empty.');  
            $wfTask_remark = (!empty($_POST['mqf_wfTask_respond'])) ? $_POST['mqf_wfTask_respond'] : '';
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$wfTask_remark), array('wfTask_id'=>$_POST['mqf_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_qnf_delegate') {
            if (empty($_POST['mqf_wfTask_id']))         throw new Exception('(ErrCode:6541) [' . __LINE__ . '] - Parameter wfTask_id empty.');  
            if (empty($_POST['mqf_wfTrans_id']))        throw new Exception('(ErrCode:6542) [' . __LINE__ . '] - Parameter wfTrans_id empty.');    
            $assign_to = (!empty($_POST['mqf_wfTrans_processOfficer'])) ? $_POST['mqf_wfTrans_processOfficer'] : '';
//            if ($assign_to == '')
//                Class_db::getInstance()->db_delete('wf_task_assign', array('wfTrans_id'=>$_POST['mqf_wfTrans_id'], 'wfTaskAssign_from'=>$_POST['mqf_wfTask_id'], 'wfTaskType_id'=>'74'));
//            else {
//                $current_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$_POST['mqf_wfTask_id']), NULL, 1);
//                $arr_task_assign_where = Class_db::getInstance()->db_select('wf_task_assign_where', array('wfTaskType_To'=>'74', 'wfTaskType_From'=>'73', 'uType_id'=>'14'), NULL, NULL, 1);
//                foreach ($arr_task_assign_where as $task_assign_where) {    
//                    if ($task_assign_where['wfTaskAssignWhere_isUser'] == 'S') {                    
//                        if (Class_db::getInstance()->db_count('wf_task_assign', array('wfTrans_id'=>$_POST['mqf_wfTrans_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To'], 'wfTaskAssign_from'=>$_POST['mqf_wfTask_id']))==0) {
//                            $wfGroup_id = Class_db::getInstance()->db_select_col('wf_group_user', array('user_id'=>$assign_to, 'wfGroupUser_status'=>'1', 'wfGroupUser_isMain'=>'1'), 'wfGroup_id', NULL, 1);
//                            Class_db::getInstance()->db_insert('wf_task_assign', array('wfTrans_id'=>$_POST['mqf_wfTrans_id'], 'wfTaskAssign_from'=>$_POST['mqf_wfTask_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To'], 'wfGroup_id'=>$wfGroup_id, 'user_id'=>$assign_to));
//                        } else {
//                            Class_db::getInstance()->db_update('wf_task_assign', array('wfGroup_id'=>$current_task['wfGroup_id'], 'user_id'=>$assign_to), array('wfTrans_id'=>$_POST['mqf_wfTrans_id'], 'wfTaskAssign_from'=>$_POST['mqf_wfTask_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To']));
//                        }
//                    } else
//                        throw new Exception('(ErrCode:6544) [' . __LINE__ . '] - Value wfTaskAssignWhere_isUser is not equal to S.');                    
//                }
//            }
            Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_processOfficer'=>$assign_to), array('wfTrans_id'=>$_POST['mqf_wfTrans_id']));
            $arr_set['wfTask_remark'] = (!empty($_POST['mqf_wfTask_remark'])) ? $_POST['mqf_wfTask_remark'] : '';
            $arr_set['wfTask_statusSave'] = (empty($_POST['mqf_result']) ? '' : $_POST['mqf_result']);
            Class_db::getInstance()->db_update('wf_task', $arr_set, array('wfTask_id'=>$_POST['mqf_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_qnf_feedback') {
            if (empty($_POST['mqf_wfTask_id']))         throw new Exception('(ErrCode:6541) [' . __LINE__ . '] - Parameter wfTask_id empty.');     
            $arr_set['wfTask_remark'] = (!empty($_POST['mqf_wfTask_remark'])) ? $_POST['mqf_wfTask_remark'] : '';
            $arr_set['wfTask_statusSave'] = (empty($_POST['mqf_result']) ? '' : $_POST['mqf_result']);
            Class_db::getInstance()->db_update('wf_task', $arr_set, array('wfTask_id'=>$_POST['mqf_wfTask_id']));
            $result = '1';
        } else {
            throw new Exception('(ErrCode:5001) [' . __LINE__ . '] - Post[funct] not valid.');
        }
        $form_data['result'] = $result;
        $form_data['success'] = true;
        Class_db::getInstance()->db_commit();
    }
} catch (Exception $e) {
    Class_db::getInstance()->db_rollback();
    if ($e->getCode() == 32)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator!' . substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, $log_dir.'/error/error_' . date("Ymd") . '.log');
}
Class_db::getInstance()->db_close();

/* Return back the values to form */
echo json_encode($form_data);
?>
