<?php
session_start();
require_once '../library/db.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$isAvailable = true;

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) [' . __LINE__ . '] - Post[funct] empty.');
    } else {
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        switch ($_POST['type']) {
            case 'email':
                $email = $_POST['email'];
                // Check the email existence ...
                $isAvailable = true; // or false
                break;

            case 'username':
            default:
                $username = $_POST['username'];
                // Check the username existence ...
                $isAvailable = true; // or false
                break;
        }
        Class_db::getInstance()->db_commit();
        Class_db::getInstance()->db_close();
    }
} catch (Exception $e) {
    Class_db::getInstance()->db_rollback();
    Class_db::getInstance()->db_close();
    if ($e->getCode() == 32)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator!' . substr($e->getMessage(), 0, 14);
    $isAvailable = false;
    error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, $log_dir.'/error/error_' . date("Ymd") . '.log');
}

// Finally, return a JSON
echo json_encode(array(
    'valid' => $isAvailable,
));