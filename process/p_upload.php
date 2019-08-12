<?php
session_start(); 
require_once '../library/db.php';
require_once '../function/f_upload.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form

try {     
    /* Validate the form on the server side - 5500 */
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) ['.__LINE__.'] - Post[funct] empty.');
    } else {        
        Class_db::getInstance()->db_connect();
        Class_db::getInstance()->db_beginTransaction();
        $fn_upload = new Class_upload();   
        if ($_POST['funct'] == 'upload_file') {    
            $upl_document_name = empty($_POST['upl_document_name']) ? '' : $_POST['upl_document_name'];
            $result = $fn_upload->upload_file('1', $_FILES['file_upload'], $upl_document_name, $_POST['upl_documentName_id'], $_POST['upl_document_remarks']);
            if ($_POST['upl_load_type'] == 'mrc') {
                Class_db::getInstance()->db_insert('vendor_document', array('document_id'=>$result, 'v_vendor_id'=>$_POST['upl_id']));
            } else if (in_array($_POST['upl_load_type'], array('mqf', 'mqv'), true)) {
                Class_db::getInstance()->db_insert('qnf_document', array('document_id'=>$result, 'qnf_id'=>$_POST['upl_id']));
            }
        } else if ($_POST['funct'] == 'delete_file') {
            $arrayParam = $_POST['param'];
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$arrayParam['document_id']));
            if ($arrayParam['flag'] == 'mac_doc_catalogue')
                Class_db::getInstance()->db_update('t_consultant_doc', array('consDoc_status'=>'8'), array('document_id'=>$arrayParam['document_id'], 'consAll_id'=>$arrayParam['param_id']));
            else
                throw new Exception('(ErrCode:5501) ['.__LINE__.'] - Delete flag not valid.');
            $result = '1';
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
    else if ($e->getCode() >= 31)
        $form_data['errors'] = 'Document fail to upload. '.substr($e->getMessage(), strpos($e->getMessage(), ' - '));
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator!'.substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $log_dir.'/error/error_'.date("Ymd").'.log');
} 
Class_db::getInstance()->db_close();
        
/* Return back the values to form */
echo json_encode($form_data);

?>
