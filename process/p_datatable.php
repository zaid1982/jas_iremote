<?php
session_start(); 
require_once '../library/db.php';

$data = array();
$countData = 0;

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

try {     
    /* Validate the form on the server side */
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) ['.__LINE__.'] - Post[funct] empty.');
    } else if (empty($_POST['sEcho'])) { // Function empty
        throw new Exception('(ErrCode:5002) ['.__LINE__.'] - Post[sEcho] empty.');
    } 
    /* Process message from server side - 5200*/
    else {        
        Class_db::getInstance()->db_connect();
        $sorting = array();
        $columns = array();
        $arrayParam = array();
        if ($_POST['funct'] == 'get_list_general') { 
            $sorting = $_POST['sorting'];
            $columns = !empty($_POST['columns']) ? $_POST['columns'] : array();
            $param = !empty($_POST['param']) ? $_POST['param'] : array();
            $tableLimit = !empty($_POST['iDisplayLength']) ? $_POST['iDisplayLength'] : '10';
            $data = Class_db::getInstance()->db_select_dTable('dt_'.$_POST['tablename'], $columns, $_POST['iDisplayStart'], $sorting[$_POST['iSortCol_0']], $_POST['sSortDir_0'], $sorting[0].' desc', $param, $tableLimit);
            $countData = Class_db::getInstance()->db_count('dt_'.$_POST['tablename'], $columns, $param); 
        } else {
            throw new Exception('(ErrCode:5001) ['.__LINE__.'] - Post[funct] not valid.');
        }
    }
} catch(Exception $e) {
    if ($e->getCode() == 32)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator! ' . substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $log_dir.'/error/error_'.date("Ymd").'.log');
}
Class_db::getInstance()->db_close();

$results = array(
    "sEcho" => intVal($_POST['sEcho']),
    "iTotalRecords" => $countData,
    "iTotalDisplayRecords" => $countData,
    "aaData" => $data);
echo json_encode($results);
?>
