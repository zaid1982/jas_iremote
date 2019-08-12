<?php
session_start(); 
require_once '../library/db.php';
require_once '../function/f_task.php';
require_once '../function/f_email.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

// Function to get the client ip address
function get_client_ip_server() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP']!='')
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR']!='')
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']) && $_SERVER['HTTP_X_FORWARDED']!='')
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']) && $_SERVER['HTTP_FORWARDED_FOR']!='')
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']) && $_SERVER['HTTP_FORWARDED']!='')
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR']!='')
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}
    
$form_data = array(); // Pass back the data to form

try {     
    /* Validate the form on the server side - 5200 */
    if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) ['.__LINE__.'] - Post[funct] empty.');
    } else {        
        $fn_task = new Class_task();  
        $fn_email = new Class_email();
        Class_db::getInstance()->db_connect();
        Class_db::getInstance()->db_beginTransaction();
        if ($_POST['funct'] == 'task_create') {  
            $result = $fn_task->task_create($_SESSION["user_id"], $_POST['wfFlow_id'], $_POST['wfGroup_id'], $_POST['wfTaskType_id']);
        } else if ($_POST['funct'] == 'task_unclaim') {  
            if ($fn_task->task_validate($_SESSION["user_id"], $_POST['wfTask_id'], 'unclaim') != 0)
                throw new Exception('(ErrCode:5200) ['.__LINE__.'] - Task already unclaimed.', 32);
            $result = $fn_task->task_unclaim($_POST['wfTask_id']);
        } else if ($_POST['funct'] == 'task_claim') {  
            if ($fn_task->task_validate($_SESSION["user_id"], $_POST['wfTask_id'], 'claim') != 0)
                throw new Exception('(ErrCode:5200) ['.__LINE__.'] - Task already claimed by other user.', 32);
            $result = $fn_task->task_claim($_SESSION["user_id"], $_POST['wfTask_id']);
        } else if ($_POST['funct'] == 'task_submit') {  
            log_debug(__LINE__, 'wfTask_id'.$_POST['wfTask_id'], $log_dir);            
            if ($fn_task->task_validate($_SESSION["user_id"], $_POST['wfTask_id'], 'submit') != 0)
                throw new Exception('(ErrCode:5201) ['.__LINE__.'] - Cannot proceed the transaction.', 32);
            $result = $fn_task->task_submit($_SESSION["user_id"], $_POST['wfTask_id'], $_POST['wfTaskType_id'], $_POST['status'], $_POST['remarks'], $_POST['condition_no'], $_POST['assigned_group'], NULL, $_POST['assigned_user'], $_POST['refName'], $_POST['refValue']);    
//            if (in_array($_POST['wfTaskType_id'], array('1','13'), true))
//                $fn_task->save_audit('7', $_SESSION["user_id"]);
//            else if ($_POST['wfTaskType_id'] == '5')
//                $fn_task->save_audit('8', $_SESSION["user_id"]);
//            else if ($_POST['wfTaskType_id'] == '9')
//                $fn_task->save_audit('9', $_SESSION["user_id"]);
//            else if (in_array($_POST['wfTaskType_id'], array('3', '7', '11', '15'), true) && $_POST['status'] == '17')
//                $fn_task->save_audit('16', $_SESSION["user_id"]);    
        } else if ($_POST['funct'] == 'task_batch_approve') {  
            if (empty($_POST['status']))          throw new Exception('(ErrCode:5203) [' . __LINE__ . '] - Parameter status empty.');
            if (empty($_POST['wfTaskType_id']))   throw new Exception('(ErrCode:5205) [' . __LINE__ . '] - Parameter wfTaskType_id empty.');
            if (Class_db::getInstance()->db_count('wf_task_user', array('wfTaskType_id'=>$_POST['wfTaskType_id'], 'user_id'=>$_SESSION['user_id'], 'wfTaskUser_status'=>'1')) == 0)
                throw new Exception('(ErrCode:5206) [' . __LINE__ . '] - You are not authorized to perform this approval. Please contact Administrator.', 32);
            $arr_task = array();
            if ($_POST['wfTaskType_id'] == '(5,15,25)') {
                $arr_task = Class_db::getInstance()->db_select('vw_consultant_email_batch', array('wfTaskType_id'=>$_POST['wfTaskType_id']));
                foreach ($arr_task as $task) {
                    try {  
                        Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>$_SESSION['user_id'], 'wfTask_timeClaimed'=>'Now()'), array('wfTask_id'=>$task['wfTask_id']));
                        $fn_task->task_submit($_SESSION["user_id"], $task['wfTask_id'], $task['wfTaskType_id'], $_POST['status'], '', '', '', NULL, '', 'consAll_id', $task['consAll_id']);  
                        $fn_email->send_email_approve_consultant($task['profile_email'], $task['profile_name'], $task['wfFlow_desc'], (!empty($task['wfTrans_regNo']) ? $task['wfTrans_regNo'] : $task['wfTrans_no']), $task['wfGroup_name'], $task['wfGroup_regNo']);
                    } catch (Exception $e) {
                        error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, '../logs/error/error_' . date("Ymd") . '.log');
                    } 
                }
            } else if ($_POST['wfTaskType_id'] == '(35,45)') {
                $arr_task = Class_db::getInstance()->db_select('vw_industry_email_batch', array('wfTaskType_id'=>$_POST['wfTaskType_id']));
                foreach ($arr_task as $task) {
                    try {  
                        Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>$_SESSION['user_id'], 'wfTask_timeClaimed'=>'Now()'), array('wfTask_id'=>$task['wfTask_id']));
                        $fn_task->task_submit($_SESSION["user_id"], $task['wfTask_id'], $task['wfTaskType_id'], $_POST['status'], '', '', '', NULL, '', 'indAll_id', $task['indAll_id']); 
                        $fn_email->send_email_approve($task['profile_email'], $task['profile_name'], $task['wfFlow_desc'], (!empty($task['wfTrans_regNo']) ? $task['wfTrans_regNo'] : $task['wfTrans_no']), $task['wfGroup_name'], $task['industrial_jasFileNo']);
                    } catch (Exception $e) {
                        error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, '../logs/error/error_' . date("Ymd") . '.log');
                    } 
                }
            } else
                throw new Exception('(ErrCode:5207) [' . __LINE__ . '] - Parameter wfTaskType_id not valid = '.$_POST['wfTaskType_id']);
            $result = '1';
        } else if ($_POST['funct'] == 'task_return') {  
            $result = $fn_task->task_return($_SESSION["user_id"], $_POST['wfTask_id'], $_POST['status'], $_POST['remarks'], $_POST['refName'], $_POST['refValue']);
            $wfTaskType_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$_POST['wfTask_id']), 'wfTaskType_id', NULL, 1);
            //$fn_email->setup_email_cp(1, $result, array($_POST['remarks']), $wfTaskType_id, '11');
        } else if ($_POST['funct'] == 'get_wfGroup_id') {  
            $result = Class_db::getInstance()->db_select_col('wf_task_user', array('wfTaskType_id'=>$_POST['wfTaskType_id'], 'user_id'=>$_SESSION["user_id"]), 'wfGroup_id', NULL, 1);
        } else if ($_POST['funct'] == 'get_task_info') {   
            $result = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$_POST['wfTask_id']), NULL, 1);
            $result['wfTask_status_desc'] = Class_db::getInstance()->db_select_col('ref_status', array('status_id'=>$result['wfTask_status']), 'status_desc', NULL, 1);
            $result['wfTask_claimedBy_name'] = Class_db::getInstance()->db_select_col('user', array('user_id'=>$result['wfTask_claimedBy']), 'user_fullname', NULL, 1);
        } else if ($_POST['funct'] == 'get_task_previous') {
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$_POST['wfTask_id']), 'wfTrans_id', NULL, 1); 
            if (empty($_POST['wfTaskType_id']))
                $result = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>'<'.$_POST['wfTask_id'],'wfTrans_id'=>$wfTrans_id, 'wfTask_partition'=>'2', 'wfTask_claimedBy'=>'is not NULL'), 'wfTask_id', 'wfTask_id desc', 1);
            else
                $result = Class_db::getInstance()->db_select_col('wf_task', array('wfTrans_id'=>$wfTrans_id, 'wfTask_partition'=>'2', 'wfTask_claimedBy'=>'is not NULL', 'wfTaskType_id'=>$_POST['wfTaskType_id']), 'wfTask_id', 'wfTask_id desc', 1);
        } else if ($_POST['funct'] == 'save_task_info') {   
            $result = Class_db::getInstance()->db_update('wf_task', array('wfTask_status'=>$_POST['wfTask_status'], 'wfTask_remark'=>$_POST['wfTask_remark']), array('wfTask_id'=>$_POST['wfTask_id']));
        } else if ($_POST['funct'] == 'get_is_return') { 
            $wfTaskType_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$_POST['wfTask_id']), 'wfTaskType_id', NULL, 1);
            $result = Class_db::getInstance()->db_select_col('wf_task_type', array('wfTaskType_id'=>$wfTaskType_id), 'wfTaskType_isReturn', NULL, 1);
        } else if ($_POST['funct'] == 'get_list_taskType') { 
            $columns = array('wfFlow_id'=>$_POST['wfFlow_id'], 'uType_cate'=>$_POST['uType_cate'], 'wfGroup_id'=>$_POST['wfGroup_id']);
            $result = Class_db::getInstance()->db_select('vw_task_assign', $columns, 'wfTaskType_id');  
        } else if ($_POST['funct'] == 'get_user_assigned') { 
            $columns = array('wfTaskUser_id'=>'is not NULL', 'wfGroup_id'=>$_POST['wfGroup_id']);
            $result = Class_db::getInstance()->db_select('vw_user_assigned', $columns, 'user_fullname', NULL, NULL, array('wfTaskType_id'=>$_POST['wfTaskType_id']));
        } else if ($_POST['funct'] == 'get_user_notAssigned') { 
            $columns = array('wfTaskUser_id'=>'is NULL', 'wfGroup_id'=>$_POST['wfGroup_id']);
            $result = Class_db::getInstance()->db_select('vw_user_assigned', $columns, 'user_fullname', NULL, NULL, array('wfTaskType_id'=>$_POST['wfTaskType_id']));
        } else if ($_POST['funct'] == 'save_task_user') { 
            Class_db::getInstance()->db_insert('wf_task_user', array('wfGroup_id'=>$_POST['wfGroup_id'], 'wfTaskType_id'=>$_POST['wfTaskType_id'], 'user_id'=>$_POST['user_id']));
            $result = 'User Task successfully saved'; 
        } else if ($_POST['funct'] == 'remove_task_user') { 
            // unclaim task claimed by this user
            $setArr = array('wfTask_claimedBy'=>'NULL', 'wfTask_timeClaimed'=>'NULL');
            Class_db::getInstance()->db_update('wf_task', $setArr, array('wfGroup_id'=>$_POST['wfGroup_id'], 'wfTaskType_id'=>$_POST['wfTaskType_id'], 'wfTask_claimedBy'=>$_POST['user_id']));
            Class_db::getInstance()->db_delete('wf_task_user', array('wfGroup_id'=>$_POST['wfGroup_id'], 'wfTaskType_id'=>$_POST['wfTaskType_id'], 'user_id'=>$_POST['user_id']));
            $result = 'User Task successfully deleted'; 
        } else if ($_POST['funct'] == 'get_task_history_info') {
            $wfTrans_id = empty($_POST['wfTask_id']) ? '' : Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$_POST['wfTask_id']), 'wfTrans_id');
            $result = Class_db::getInstance()->db_select_single('dt_task_history_info', array('wfTrans_id'=>$wfTrans_id), 'wfTask_id desc');
            $result['train'] = Class_db::getInstance()->db_select_col('dt_task_type', array('wfTrans_id'=>$wfTrans_id, 'wfTaskType_isEnd'=>'N'), 'wfTaskType_id', 'wfTask_id desc');
        } else if ($_POST['funct'] == 'get_value_from_table') {
            $result = Class_db::getInstance()->db_select_col($_POST['tablename'], array($_POST['column_name']=>$_POST['column_value']), $_POST['column_out']);
        } else if ($_POST['funct'] == 'save_audit') {
            log_debug(__LINE__, 'save_audit = '.$_POST['auditModule_id'].' - '.$_POST['auditAction_id'], $log_dir);
            $result = $_POST['auditAction_id'] != '0' ? $fn_task->save_audit($_POST['auditAction_id'], $_POST['audit_transNo']) : '0';
        } else if ($_POST['funct'] == 'get_general_info') {
            $columns = !empty($_POST['columns']) ? $_POST['columns'] : array();
            $param = array('table_name'=>$_POST['tablename'], 'status_name'=>$_POST['status_name']);
            if (!empty($_POST['param']))
                $param = array_merge($param, $_POST['param']);
            if (!empty($_POST['status_name']))
                $result = Class_db::getInstance()->db_select_single('vw_join_status', $columns, NULL, NULL, $param);
            else
                $result = Class_db::getInstance()->db_select_single($_POST['tablename'], $columns, NULL, NULL, $param);
        } else if ($_POST['funct'] == 'get_general_info_multiple') {
            $columns = !empty($_POST['columns']) ? $_POST['columns'] : array();
            $param = array('table_name'=>$_POST['tablename'], 'status_name'=>$_POST['status_name']);
            if (!empty($_POST['param']))
                $param = array_merge($param, $_POST['param']);
            if (!empty($_POST['status_name']))
                $result = Class_db::getInstance()->db_select('vw_join_status', $columns, NULL, NULL, NULL, $param);
            else 
                $result = Class_db::getInstance()->db_select($_POST['tablename'], $columns, (!empty($_POST['order']) ? $_POST['order'] : NULL), NULL, NULL, $param);
        } else {
            throw new Exception('(ErrCode:5001) ['.__LINE__.'] - Post[funct] not valid.');
        }
        $form_data['result'] = $result;
        $form_data['success'] = true;
        Class_db::getInstance()->db_commit();
    }    
} catch(Exception $e) {
    Class_db::getInstance()->db_rollback();
    if ($e->getCode() == 32)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else if ($e->getCode() == 31)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator! ' . substr($e->getMessage(), 0, 14);   
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $log_dir.'/error/error_'.date("Ymd").'.log');
} 
Class_db::getInstance()->db_close();
        
/* Return back the values to form */
//$input = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($form_data));
$json = json_encode($form_data);
switch (json_last_error()){
    case JSON_ERROR_CTRL_CHAR:
        log_debug(__LINE__, 'JSON_ERROR_CTRL_CHAR', $log_dir);
        break;
    case JSON_ERROR_UTF8:
        log_debug(__LINE__, 'JSON_ERROR_UTF8', $log_dir);
        break;
    case JSON_ERROR_SYNTAX:
        log_debug(__LINE__, 'JSON_ERROR_SYNTAX', $log_dir);
        break;
    case JSON_ERROR_DEPTH:
        log_debug(__LINE__, 'JSON_ERROR_DEPTH', $log_dir);
        break;
    case JSON_ERROR_STATE_MISMATCH:
        log_debug(__LINE__, 'JSON_ERROR_STATE_MISMATCH', $log_dir);
        break;
    default:
        //log_debug(__LINE__, 'others', $log_dir);
        break;
}
echo $json;

?>
