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
    /* Validate the form on the server side - 5900 */
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) [' . __LINE__ . '] - Post[funct] empty.');
    } else {
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        $fn_task = new Class_task();          
        $fn_upload = new Class_upload();   
        if ($_POST['funct'] == 'add_monitor') {    
            if (empty($_POST['param'])) throw new Exception('(ErrCode:5901) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indParam_id']))  throw new Exception('(ErrCode:5902) [' . __LINE__ . '] - Parameter indParam_id empty.');
            if (Class_db::getInstance()->db_count('t_monitor', array('monitor_status'=>'0')) == 0) {       
                $total_slot = Class_db::getInstance()->db_count('t_monitor');
                throw new Exception('(ErrCode:5903) [' . __LINE__ . '] - All '.$total_slot.' slots for monitoring full. Please stop 1 of current monitoring to give way to this one.', 32);
            }
            if (Class_db::getInstance()->db_count('t_monitor', array('indParam_id'=>$arrayParam['indParam_id'], 'monitor_status'=>'(1,31)')) > 0) 
                throw new Exception('(ErrCode:5904) [' . __LINE__ . '] - This stack and input parameter already in the monitoring slot.', 32);
            $monitor_id = Class_db::getInstance()->db_select_col('t_monitor', array('monitor_status'=>'0'), 'monitor_id', NULL, 1);
            Class_db::getInstance()->db_update('t_monitor', array('indParam_id'=>$arrayParam['indParam_id'], 'monitor_status'=>'1'), array('monitor_id'=>$monitor_id));
            $result = '1';
        } else if ($_POST['funct'] == 'remove_monitor') { 
            if (empty($_POST['param'])) throw new Exception('(ErrCode:5901) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indParam_id']))  throw new Exception('(ErrCode:5902) [' . __LINE__ . '] - Parameter indParam_id empty.');
            if (Class_db::getInstance()->db_count('t_monitor', array('indParam_id'=>$arrayParam['indParam_id'], 'monitor_status'=>'(1,31)')) == 0) 
                throw new Exception('(ErrCode:5905) [' . __LINE__ . '] - This stack and input parameter not exist in the monitoring slot.', 32);            
            Class_db::getInstance()->db_update('t_monitor', array('indParam_id'=>'NULL', 'monitor_status'=>'0'), array('indParam_id'=>$arrayParam['indParam_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_response_doc') {
            if (empty($_POST['mre_response_id']))       throw new Exception('(ErrCode:5902) [' . __LINE__ . '] - Parameter response_id empty.');  
            if (empty($_POST['mre_supDoc_name']))       throw new Exception('(ErrCode:5903) [' . __LINE__ . '] - Parameter supDoc_name empty.'); 
            if (empty($_POST['mre_response_type']))     throw new Exception('(ErrCode:5904) [' . __LINE__ . '] - Parameter response_type empty.'); 
            $documentName_id = $_POST['mre_response_type'] == '1' ? '19' : '20';
            $document_id = !empty($_FILES['mre_supDoc_file']['name']) ? $fn_upload->upload_file('1', $_FILES['mre_supDoc_file'], $_POST['mre_supDoc_name'], $documentName_id, '') : '';
            $result = Class_db::getInstance()->db_insert('t_response_doc', array('response_id'=>$_POST['mre_response_id'], 'documentName_id'=>$documentName_id, 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'delete_response_doc') {
            if (empty($_POST['param']))     throw new Exception('(ErrCode:5901) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['responseDoc_id']))  throw new Exception('(ErrCode:5905) [' . __LINE__ . '] - Parameter responseDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_response_doc', array('responseDoc_id'=>$arrayParam['responseDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_response_doc', array('responseDoc_status'=>'8'), array('responseDoc_id'=>$arrayParam['responseDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_fail_response') {
            if (empty($_POST['mre_response_id']))       throw new Exception('(ErrCode:5902) [' . __LINE__ . '] - Parameter response_id empty.');  
            if (empty($_POST['mre_wfTask_id']))         throw new Exception('(ErrCode:5906) [' . __LINE__ . '] - Parameter wfTask_id empty.');  
            if (empty($_POST['mre_reasonFail_id']))     throw new Exception('(ErrCode:5907) [' . __LINE__ . '] - Field Failure Reason empty.', 32);  
            if (empty($_POST['mre_wfTask_remark']))     throw new Exception('(ErrCode:5908) [' . __LINE__ . '] - Field Message/Feedback empty.', 32);  
            Class_db::getInstance()->db_update('t_response', array('reasonFail_id'=>$_POST['mre_reasonFail_id'], 'response_message'=>$_POST['mre_wfTask_remark']), array('response_id'=>$_POST['mre_response_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['mre_wfTask_remark']), array('wfTask_id'=>$_POST['mre_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_fail_response_verify') {
            if (empty($_POST['mre_response_id']))       throw new Exception('(ErrCode:5902) [' . __LINE__ . '] - Parameter response_id empty.');  
            if (empty($_POST['mre_wfTask_id']))         throw new Exception('(ErrCode:5906) [' . __LINE__ . '] - Parameter wfTask_id empty.');  
            Class_db::getInstance()->db_update('wf_task', array('wfTask_statusSave'=>empty($_POST['mre_result'])?'':$_POST['mre_result'], 'wfTask_remark'=>$_POST['mre_wfTask_verify']), array('wfTask_id'=>$_POST['mre_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'get_old_data') {      
            if (empty($_POST['olc_state_code']))        throw new Exception('(ErrCode:5909) [' . __LINE__ . '] - Field State empty.', 32);  
            if (empty($_POST['olc_data_date']))         throw new Exception('(ErrCode:5910) [' . __LINE__ . '] - Field Date empty.', 32);  
            if (empty($_POST['olc_premise_id']))        throw new Exception('(ErrCode:5911) [' . __LINE__ . '] - Field Industrial Premise empty.', 32); 
            if (empty($_POST['olc_input_param']))       throw new Exception('(ErrCode:5912) [' . __LINE__ . '] - Field Input Parameter empty.', 32);   
            $result = Class_db::getInstance()->db_old_data($_POST['olc_state_code'], $_POST['olc_premise_id'], $_POST['olc_data_date'], $_POST['olc_input_param']);
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
    else if ($e->getCode() == '1049' && $_POST['funct'] == 'get_old_data')
        $form_data['errors'] = 'Requested Data not available!';
    else if ($e->getCode() == '42' && $_POST['funct'] == 'get_old_data')
        $form_data['errors'] = 'Requested Data not available!';
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator!' . substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - [".$e->getCode()."] ". $e->getMessage() . "\r\n", 3, $log_dir.'/error/error_' . date("Ymd") . '.log');
}
Class_db::getInstance()->db_close();

/* Return back the values to form */
echo json_encode($form_data);
?>
