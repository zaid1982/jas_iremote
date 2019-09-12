<?php
//session_start(); 
require_once '../library/db.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form

try {     
    /* Validate the form on the server side - 5400 */
//    if (!isset($_SESSION['user_id'])) {
//        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
//    } else 
    if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) ['.__LINE__.'] - Post[funct] empty.');
    } else {        
        Class_db::getInstance()->db_connect();
        if ($_POST['funct'] == 'ref_general') {         
            if ($_POST['tablename'] == 'audit_action_grp') {
                $result = Class_db::getInstance()->db_select('vw_opt_audit_action', array());
            } else if ($_POST['tablename'] == 'task_delegate_to') {
                $result = Class_db::getInstance()->db_select('vw_opt_delegate_to', array('ref_id'=>'<>'.$_POST['id_name'], 'wfTaskType_id'=>$_POST['status']));
            } else if ($_POST['tablename'] == 'task_assign') {
                $result = Class_db::getInstance()->db_select('vw_opt_delegate_to', array('wfTaskType_id'=>$_POST['status'], 'wfGroup_id'=>$_POST['status_name']));
            } else if ($_POST['tablename'] == 'mobile_cems') {
                $result = Class_db::getInstance()->db_select('vw_opt_mobile_consultant', array(), NULL, NULL, NULL, array('where_status'=>$_POST['status']));
            } else if ($_POST['tablename'] == 'consultant_cems') {
                $result = Class_db::getInstance()->db_select('vw_opt_cems_consultant', array(), NULL, NULL, NULL, array('where_status'=>$_POST['status']));
            } else if ($_POST['tablename'] == 'consultant_pems') {
                $result = Class_db::getInstance()->db_select('vw_opt_pems_consultant', array(), NULL, NULL, NULL, array('where_status'=>$_POST['status']));
            } else if ($_POST['tablename'] == 'industrial_active') {
                $result = Class_db::getInstance()->db_select('vw_opt_industrial', array('state_id'=>$_POST['status']));
            } else if ($_POST['tablename'] == 'stack_complience') {
                $result = Class_db::getInstance()->db_select('vw_opt_stack_complience', array(), NULL, NULL, NULL, array('industrial_id'=>$_POST['status'], 'date_pool_start'=>$_POST['id_name']));
            } else {
                $columns = array($_POST['status_name']=>$_POST['status']);
                $sqlParam = array('tablename'=>$_POST['tablename'], 'id_name'=>$_POST['id_name'], 'desc_name'=>$_POST['desc_name'], 'status_name'=>$_POST['status_name'], 'extra_name'=>'');
                if (!empty($_POST['extra_name']) && !empty($_POST['extra_value'])) {
                    $columns[$_POST['extra_name']] = $_POST['extra_value'];
                    $sqlParam['extra_name'] = ', '.$_POST['extra_name'];                
                }
                $result = Class_db::getInstance()->db_select('vw_ref_general', $columns, $_POST['sorts'], NULL, NULL, $sqlParam);
            }
        } else if ($_POST['funct'] == 'ref_general_group') {  
            $columns = array();
            $sqlParam = array('tablename'=>$_POST['tablename'], 'desc_name'=>$_POST['desc_name']);
            if (!empty($_POST['extra_name']) && !empty($_POST['extra_value'])) {
                $columns[$_POST['extra_name']] = $_POST['extra_value'];
                $sqlParam['extra_name'] = ', '.$_POST['extra_name'];                
            } else {
                $sqlParam['extra_name'] = '';
            }
            $result = Class_db::getInstance()->db_select('vw_ref_general_group', $columns, $_POST['sorts'], NULL, 1, $sqlParam);
        } else if ($_POST['funct'] == 'ref_general_statusGroup') {  
            $result = Class_db::getInstance()->db_select('vw_ref_general_statusGroup', array(), 'status_desc', NULL, 1);
        } else if ($_POST['funct'] == 'get_ref_dokumen_daftar') {  
            $columns = array('jenisPerniagaan_id'=>$_POST['jenisPerniagaan_id'], 'subGolongan_id'=>$_POST['subGolongan_id']);
            $result = Class_db::getInstance()->db_select('vw_ref_document_daftar', $columns, 'documentName_id');
        } else if ($_POST['funct'] == 'get_date_diff') { 
            $result = Class_db::getInstance()->db_select_col('vw_get_date_diff', array(), 'date_out', NULL, NULL, array('date_in'=>$_POST['date_in'], 'expression'=>$_POST['expression']));
        } else if ($_POST['funct'] == 'get_address') { 
            $result = Class_db::getInstance()->db_select_single('vw_address', array('address_id'=>$_POST['address_id']), NULL, 1);
        } else if ($_POST['funct'] == 'get_profile') { 
            $result = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$_POST['profile_id']), NULL, 1);        
        } else if ($_POST['funct'] == 'validate_count_table') { 
            $result = Class_db::getInstance()->db_count($_POST['table_name'], array($_POST['column_name']=>$_POST['column_value']));
        } else {
            throw new Exception('(ErrCode:5001) ['.__LINE__.'] - Post[funct] not valid.');
        }
        $form_data['result'] = $result;
        $form_data['success'] = true;
    }    
} catch(Exception $e) {
    if ($e->getCode() == 32)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else
        $form_data['errors']  = 'Error on system. Please contact Administrator! '.substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $log_dir.'/error/error_'.date("Ymd").'.log');
} 
Class_db::getInstance()->db_close();
        
/* Return back the values to form */
echo json_encode($form_data);
?>
