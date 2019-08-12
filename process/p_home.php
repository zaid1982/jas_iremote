<?php

session_start();
require_once '../library/db.php';
require_once '../function/f_task.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form

try {
    /* Validate the form on the server side - 6000 */
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) [' . __LINE__ . '] - Post[funct] empty.');
    } else {
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        $fn_task = new Class_task();       
        if ($_POST['funct'] == 'get_summary_total') {
            $total_industry = Class_db::getInstance()->db_count('t_industrial', array('industrial_status'=>'1'));
            $total_consultant = Class_db::getInstance()->db_count('t_consultant', array('consultant_status'=>'1'));            
            $total_cems = Class_db::getInstance()->db_count('t_industrial_all', array('indAll_type'=>'1', 'indAll_status'=>'1'));
            $total_pems = Class_db::getInstance()->db_count('t_industrial_all', array('indAll_type'=>'2', 'indAll_status'=>'1'));
            $total_cems_analyzer = Class_db::getInstance()->db_count('t_consultant_all', array('consAll_type'=>'1', 'consAll_status'=>'1'));
            $total_cems_software = Class_db::getInstance()->db_count('t_consultant_all', array('consAll_type'=>'2', 'consAll_status'=>'1'));
            $result = array('total_industry'=>$total_industry, 'total_consultant'=>$total_consultant, 'total_cems'=>$total_cems, 'total_pems'=>$total_pems, 'total_cems_analyzer'=>$total_cems_analyzer, 'total_cems_software'=>$total_cems_software);
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
