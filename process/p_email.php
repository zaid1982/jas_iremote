<?php

session_start();
require_once '../library/db.php';
require_once '../function/f_email.php';
require_once '../function/f_task.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form
try {
    /* Validate the form on the server side - 5700 */
    if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) [' . __LINE__ . '] - Post[funct] empty.');
    } else {
        $fn_email = new Class_email();  
        $fn_task = new Class_task();  
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        $result = '1';
        if (empty($_POST['param'])) {
            throw new Exception('(ErrCode:5701) [' . __LINE__ . '] - Parameter param empty');
        }
        $arrayParam = $_POST['param'];
        log_debug(__LINE__, 'Entering email sender = '.$_POST['funct'], $log_dir);
        if (in_array($_POST['funct'], array('email_assign', 'email_process', 'email_verify', 'email_approval', 'email_revise', 'email_verify_initRATA', 'email_failReport_verify', 'email_certRenewal_verify', 'email_qnf_return_internal', 'email_qnf_reply', 'email_qnf_delegate'), true)) {
            if (empty($arrayParam['wfTask_id'])) {
                throw new Exception('(ErrCode:5705) [' . __LINE__ . '] - Parameter wfTask_id empty');
            }
            $wf_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$arrayParam['wfTask_id']), NULL, 1);
            $wfFlow_id = Class_db::getInstance()->db_select_col('wf_task_type', array('wfTaskType_id'=>$wf_task['wfTaskType_id']), 'wfFlow_id', NULL, 1);
            $app_type = Class_db::getInstance()->db_select_col('wf_flow', array('wfFlow_id'=>$wfFlow_id), 'wfFlow_desc', NULL, 1);
            $wf_transaction = Class_db::getInstance()->db_select_single('wf_transaction', array('wfTrans_id'=>$wf_task['wfTrans_id']), NULL, 1);
            $company_name = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$wf_transaction['wfTrans_createdByGr']), 'wfGroup_name', NULL, 1);
            if ($_POST['funct'] == 'email_process' && empty($wf_transaction['wfTrans_processOfficer'])) {
                throw new Exception('(ErrCode:5709) [' . __LINE__ . '] - Value wfTrans_processOfficer empty');
            }
            try {
                if ($_POST['funct'] == 'email_process') {                    
                    $user = Class_db::getInstance()->db_select_single('user', array('user_id'=>$wf_transaction['wfTrans_processOfficer']), NULL, 1);
                    $profile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$user['profile_id']), NULL, 1);
                    $fn_email->send_email_process($profile['profile_email'], $company_name, $app_type); 
                } else {
                    $arr_user = Class_db::getInstance()->db_select('wf_task_user', array('wfGroup_id'=>$wf_task['wfGroup_id'], 'wfTaskType_id'=>$wf_task['wfTaskType_id'], 'wfTaskUser_status'=>'1'));
                    foreach ($arr_user as $users) {
                        $user = Class_db::getInstance()->db_select_single('user', array('user_id'=>$users['user_id']), NULL, 1);
                        $profile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$user['profile_id']), NULL, 1);
                        if (empty($profile['profile_email']))
                            log_debug(__LINE__, 'Email empty for user_id = '.$users['user_id'], $log_dir);
                        else {
                            if ($_POST['funct'] == 'email_assign')
                                $fn_email->send_email_assign($profile['profile_email'], $company_name, $app_type); 
                            else if ($_POST['funct'] == 'email_verify')
                                $fn_email->send_email_verify($profile['profile_email'], $company_name, $app_type); 
                            else if ($_POST['funct'] == 'email_approval')
                                $fn_email->send_email_approval($profile['profile_email'], $company_name, $app_type); 
                            else if ($_POST['funct'] == 'email_revise')
                                $fn_email->send_email_revise($profile['profile_email'], $company_name, $app_type); 
                            else if ($_POST['funct'] == 'email_verify_initRATA')
                                $fn_email->send_email_verify_initRATA($profile['profile_email'], $company_name, $app_type); 
                            else if ($_POST['funct'] == 'email_failReport_verify') {
                                $company_name = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$wf_task['wfTask_createdByGr']), 'wfGroup_name', NULL, 1);
                                $fn_email->send_email_failReport_verify($profile['profile_email'], $company_name, $app_type); 
                            } else if ($_POST['funct'] == 'email_certRenewal_verify') {
                                $company_name = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$wf_task['wfTask_createdByGr']), 'wfGroup_name', NULL, 1);
                                $fn_email->send_email_certRenewal_verify($profile['profile_email'], $company_name, $app_type); 
                            } else if ($_POST['funct'] == 'email_qnf_return_internal')
                                $fn_email->send_email_qnf_return ($profile['profile_email'], $wf_transaction['wfTrans_regNo']);
                            else if ($_POST['funct'] == 'email_qnf_delegate')
                                $fn_email->send_email_qnf_delegate ($profile['profile_email'], $wf_transaction['wfTrans_regNo']);
                            else if ($_POST['funct'] == 'email_qnf_reply')
                                $fn_email->send_email_qnf_reply ($profile['profile_email'], $wf_transaction['wfTrans_regNo']);
                        }
                    }     
                }
            } catch (Exception $e1) {
                error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, '../logs/error/error_' . date("Ymd") . '.log');
            }
        } else if (in_array($_POST['funct'], array('email_reject', 'email_return', 'email_approve', 'email_initialRATA', 'email_return_initRATA', 'email_redo_initRATA', 'email_failReport_user', 'email_certRenewal_result', 'email_qnf_return', 'email_qnf_resolve', 'email_qnf_feedback'), true)) {      
            $wf_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$arrayParam['wfTask_id']), NULL, 1);
            $wfFlow_id = Class_db::getInstance()->db_select_col('wf_task_type', array('wfTaskType_id'=>$wf_task['wfTaskType_id']), 'wfFlow_id', NULL, 1);
            $app_type = Class_db::getInstance()->db_select_col('wf_flow', array('wfFlow_id'=>$wfFlow_id), 'wfFlow_desc', NULL, 1);
            $wf_transaction = Class_db::getInstance()->db_select_single('wf_transaction', array('wfTrans_id'=>$wf_task['wfTrans_id']), NULL, 1);
            $wf_group = ''; $user = '';
            if (in_array($wfFlow_id, array('6', '7'))) {
                $wf_group = Class_db::getInstance()->db_select_single('wf_group', array('wfGroup_id'=>$wf_task['wfGroup_id']), NULL, 1);
                $user = Class_db::getInstance()->db_select_single('user', array('user_id'=>$wf_task['wfTask_claimedBy']), NULL, 1);
            } else {
                $wf_group = Class_db::getInstance()->db_select_single('wf_group', array('wfGroup_id'=>$wf_transaction['wfTrans_createdByGr']), NULL, 1);
                $user = Class_db::getInstance()->db_select_single('user', array('user_id'=>$wf_transaction['wfTrans_createdBy']), NULL, 1);
            }
            $profile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$user['profile_id']), NULL, 1);
            if (in_array($wfFlow_id, array('1', '2', '3'))) {
                if ($_POST['funct'] == 'email_reject')
                    $fn_email->send_email_reject_consultant($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_no'], $wf_group['wfGroup_name'], $wf_group['wfGroup_regNo'], $wf_task['wfTask_remark']);
                else if ($_POST['funct'] == 'email_return')
                    $fn_email->send_email_return_consultant($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_no'], $wf_group['wfGroup_name'], $wf_group['wfGroup_regNo'], $wf_task['wfTask_remark']);
                else if ($_POST['funct'] == 'email_approve') 
                    $fn_email->send_email_approve_consultant($profile['profile_email'], $profile['profile_name'], $app_type, (!empty($wf_transaction['wfTrans_regNo']) ? $wf_transaction['wfTrans_regNo'] : $wf_transaction['wfTrans_no']), $wf_group['wfGroup_name'], $wf_group['wfGroup_regNo']);          
            } else if (in_array($wfFlow_id, array('4', '5'))) {
                $industrial = Class_db::getInstance()->db_select_single('t_industrial', array('wfGroup_id'=>$wf_group['wfGroup_id']), NULL, 1);
                if ($_POST['funct'] == 'email_reject')
                    $fn_email->send_email_reject($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_no'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo'], $wf_task['wfTask_remark']);
                else if ($_POST['funct'] == 'email_return')
                    $fn_email->send_email_return($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_no'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo'], $wf_task['wfTask_remark']);
                else if ($_POST['funct'] == 'email_approve') 
                    $fn_email->send_email_approve($profile['profile_email'], $profile['profile_name'], $app_type, (!empty($wf_transaction['wfTrans_regNo']) ? $wf_transaction['wfTrans_regNo'] : $wf_transaction['wfTrans_no']), $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo']);
                else if ($_POST['funct'] == 'email_initialRATA')
                    $fn_email->send_email_initialRATA($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_regNo'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo']);
                else if ($_POST['funct'] == 'email_return_initRATA')
                    $fn_email->send_email_return_initialRATA($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_regNo'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo']);
                else if ($_POST['funct'] == 'email_redo_initRATA')
                    $fn_email->send_email_redo_initialRATA($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_regNo'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo']);
            } else if (in_array($wfFlow_id, array('6', '7')) && $_POST['funct'] == 'email_failReport_user') {
                $industrial = Class_db::getInstance()->db_select_single('t_industrial', array('wfGroup_id'=>$wf_group['wfGroup_id']), NULL, 1);
                if ($wf_task['wfTask_status'] == '12')
                    $fn_email->send_email_failReport_return($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_regNo'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo']);
                else if ($wf_task['wfTask_status'] == '18')
                    $fn_email->send_email_failReport_approve($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_regNo'], $wf_group['wfGroup_name'], $industrial['industrial_jasFileNo']);
            } else if ($wfFlow_id == '9' && $_POST['funct'] == 'email_certRenewal_result') {
                if ($wf_task['wfTask_status'] == '12')
                    $fn_email->send_email_return_consultant($profile['profile_email'], $profile['profile_name'], $app_type, $wf_transaction['wfTrans_no'], $wf_group['wfGroup_name'], $wf_group['wfGroup_regNo'], $wf_task['wfTask_remark']);
                else if ($wf_task['wfTask_status'] == '18')
                    $fn_email->send_email_approve_consultant($profile['profile_email'], $profile['profile_name'], $app_type, (!empty($wf_transaction['wfTrans_regNo']) ? $wf_transaction['wfTrans_regNo'] : $wf_transaction['wfTrans_no']), $wf_group['wfGroup_name'], $wf_group['wfGroup_regNo']); 
            }  else if ($wfFlow_id == '8') {
                if ($wf_task['wfTask_status'] == '22' || $wf_task['wfTask_status'] == '44')
                    $fn_email->send_email_qnf_return ($profile['profile_email'], $wf_transaction['wfTrans_regNo']);
                else if ($wf_task['wfTask_status'] == '40')
                    $fn_email->send_email_qnf_resolve ($profile['profile_email'], $wf_transaction['wfTrans_regNo']);
                else if ($wf_task['wfTask_status'] == '39')
                    $fn_email->send_email_qnf_feedback ($profile['profile_email'], $wf_transaction['wfTrans_regNo']);
            }
        } else if ($_POST['funct'] == 'email_qnf_resolve_external') {    
            $wf_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$arrayParam['wfTask_id']), NULL, 1);
            $wf_transaction = Class_db::getInstance()->db_select_single('wf_transaction', array('wfTrans_id'=>$wf_task['wfTrans_id']), NULL, 1);
            $t_qnf = Class_db::getInstance()->db_select_single('t_qnf', array('qnf_id'=>$wf_task['wfTask_refValue']), NULL, 1);
            $fn_email->send_email_qnf_resolve ($t_qnf['qnf_email'], $wf_transaction['wfTrans_regNo']);
        } else if ($_POST['funct'] == 'email_forgot_password') {            
            $user = Class_db::getInstance()->db_select_single('user', array('user_name'=>$arrayParam['user_name']));
            if (empty($user))
                throw new Exception('(ErrCode:5707) [' . __LINE__ . '] - Usename not exist. Please enter valid username / IC No.', 32);
            else if ($arrayParam['secQues_id'] != $user['secQues_id'] || $arrayParam['user_security_answer'] != $user['user_security_answer'])
                throw new Exception('(ErrCode:5708) [' . __LINE__ . '] - Security question / answer is incorrect. Please try again or contact Administrator.', 32);
            $profile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$user['profile_id']), NULL, 1);
            $new_password = $fn_task->generateRandomString(10);
            $fn_email->send_email_reset_password($profile['profile_email'], $profile['profile_name'], $user['user_name'], $new_password);
            Class_db::getInstance()->db_update('user', array('user_password'=>$new_password), array('user_id'=>$user['user_id']));
            $result = $profile['profile_email'];    
        } else {
            if (empty($arrayParam['user_id'])) {
                throw new Exception('(ErrCode:5702) [' . __LINE__ . '] - Parameter user_id empty');
            }
            $user = Class_db::getInstance()->db_select_single('user', array('user_id'=>$arrayParam['user_id']), NULL, 1);
            $profile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$user['profile_id']), NULL, 1);
            if (empty($profile['profile_email'])) {
                throw new Exception('(ErrCode:5703) [' . __LINE__ . '] - Parameter email empty');
            }
            $result = '1';
            // ************** start email *************** \\
//            if ($_POST['funct'] == 'email_activation') {
//                $fn_email->send_email_activation($profile['profile_email'], $profile['profile_name'], $user['user_name'], $user['user_password'], $user['user_activationKey']);
//            } else 
            if ($_POST['funct'] == 'email_user_creation') {            
                $role_list = Class_db::getInstance()->db_select_col('vw_user_types', array('user_id'=>$arrayParam['user_id']), 'role_list');
                $fn_email->send_email_user_creation($profile['profile_email'], $profile['profile_name'], $user['user_name'], $user['user_password'], $role_list);
            } else if ($_POST['funct'] == 'email_reset_password') {    
                $new_password = $fn_task->generateRandomString(10);
                $fn_email->send_email_reset_password($profile['profile_email'], $profile['profile_name'], $user['user_name'], $new_password);
                Class_db::getInstance()->db_update('user', array('user_password'=>$new_password, 'user_failAttempt'=>'0'), array('user_id'=>$arrayParam['user_id']));
            } else {
                throw new Exception('(ErrCode:5001) [' . __LINE__ . '] - Post[funct] not valid.');
            }            
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
        $form_data['errors'] = 'Error on system. Please contact Administrator! ' . substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, $log_dir.'/error/error_' . date("Ymd") . '.log');
}
Class_db::getInstance()->db_close();

/* Return back the values to form */
echo json_encode($form_data);
?>