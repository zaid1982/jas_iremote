<?php
require_once '../library/db.php';

//header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

$form_data = '';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/data/debug_'.date("Ymd").'.log');
}

if (isset($_GET['xyz'])) {
    $str = $_GET['xyz'];
    //echo base64_encode('1|3|2017-08-02|00:20:00|3.223||||||32.32|11.21|6'); exit();   // MXwzfDIwMTctMDgtMDJ8MDA6MjA6MDB8My4yMjN8fHx8fHwzMi4zMnwxMS4yMQ==
    log_debug(__LINE__, 'URL received '.$_GET['xyz'].' - '.base64_decode($str), $log_dir);
	log_debug(__LINE__, 'URL received - '.base64_decode($str), $log_dir);
    $pieces = explode('|', base64_decode($str));
    try {
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        if (count($pieces) == 15) {
            // [reading_id, stack_id, read_date, read_time, total_pm, so2, no2, hcl, hf, co, co2, o2, nmvoc, opacity, industrial_id]
            // 1. check stack_id - numeric
            // 2. check read_date
            // 3. check read_time
            // 4. check all params - numeric if have value
            //if (!is_numeric($pieces[1]) && Class_db::getInstance()->db_count('t_industrial_all', array('indAll_id'=>$pieces[1], 'industrial_id'=>$pieces[12])) < 1)                
            //    throw new Exception('(ErrCode:2001) [' . __LINE__ . '] - Parameter stack_id is not numeric / not available = '.$pieces[1].', industrial_id'.$pieces[12]);
//            if (!(is_numeric($pieces[2]) && ($pieces[2] == '1' || $pieces[2] == '2')))
//                throw new Exception('(ErrCode:2002) [' . __LINE__ . '] - Parameter type is not numeric / outside range = '.$pieces[2]);
            if (!(strlen($pieces[2]) == 10 && substr($pieces[2], 4, 1) == '-' && substr($pieces[2], 7, 1) == '-' && is_numeric(substr($pieces[2], 0, 4))
                && is_numeric(substr($pieces[2], 5, 2)) && is_numeric(substr($pieces[2], 8, 2))))
                throw new Exception('(ErrCode:2003) [' . __LINE__ . '] - Parameter read_date not in date format = '.$pieces[2]);
            if (!(strlen($pieces[3]) == 8 && substr($pieces[3], 2, 1) == ':' && substr($pieces[3], 5, 1) == ':' && is_numeric(substr($pieces[3], 0, 2))
                && is_numeric(substr($pieces[3], 3, 2)) && is_numeric(substr($pieces[3], 6, 2))))
                throw new Exception('(ErrCode:2004) [' . __LINE__ . '] - Parameter read_time not in time format = '.$pieces[3]);
            if ($pieces[4] != '' && !is_numeric($pieces[4]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter total_pm is not numeric = '.$pieces[4]);
            if ($pieces[5] != '' && !is_numeric($pieces[5]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter so2 is not numeric = '.$pieces[5]);
            if ($pieces[6] != '' && !is_numeric($pieces[6]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter no2 is not numeric = '.$pieces[6]);
            if ($pieces[7] != '' && !is_numeric($pieces[7]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter hcl is not numeric = '.$pieces[7]);
            if ($pieces[8] != '' && !is_numeric($pieces[8]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter hf is not numeric = '.$pieces[8]);
            if ($pieces[9] != '' && !is_numeric($pieces[9]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter co is not numeric = '.$pieces[9]);
            if ($pieces[10] != '' && !is_numeric($pieces[10]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter co2 is not numeric = '.$pieces[10]);
            if ($pieces[11] != '' && !is_numeric($pieces[11]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter o2 is not numeric = '.$pieces[11]);
            if ($pieces[12] != '' && !is_numeric($pieces[12]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter nmvoc is not numeric = '.$pieces[12]);
            if ($pieces[13] != '' && !is_numeric($pieces[13]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter opacity is not numeric = '.$pieces[13]);
			if (empty($pieces[1]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter stack_id empty');
            if (empty($pieces[14]))
                throw new Exception('(ErrCode:2005) [' . __LINE__ . '] - Parameter premiseId empty');
            // --- start inserting --- \\
            $yr = substr($pieces[2],2,2);
            $table_name = 'z'.$yr.'_'.preg_replace("/[^a-zA-Z0-9]/", "", $pieces[14]);
			log_debug(__LINE__, 'Check if table exist '.$table_name, $log_dir);
            if (Class_db::getInstance()->db_count('information_schema.tables', array('TABLE_SCHEMA'=>'cems_staging', 'TABLE_NAME'=>$table_name)) < 1) {
                log_debug(__LINE__, 'Table not exist and created = '.$table_name, $log_dir);
                Class_db::getInstance()->db_create_table("CREATE TABLE `".$table_name."` (
                    `data_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                    `stack_id` varchar(10) NOT NULL,
                    `data_timestamp` timestamp NULL DEFAULT NULL,
                    `data_1` decimal(10,3) DEFAULT NULL,
                    `data_2` decimal(10,3) DEFAULT NULL,
                    `data_3` decimal(10,3) DEFAULT NULL,
                    `data_4` decimal(10,3) DEFAULT NULL,
                    `data_5` decimal(10,3) DEFAULT NULL,
                    `data_6` decimal(10,3) DEFAULT NULL,
                    `data_7` decimal(10,3) DEFAULT NULL,
                    `data_8` decimal(10,3) DEFAULT NULL,
                    `data_9` decimal(10,3) DEFAULT NULL,
                    `data_10` decimal(10,3) DEFAULT NULL,
                    `data_timeCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `reading_id` double(9,0) DEFAULT NULL,
                    PRIMARY KEY (`data_id`) USING BTREE,
                    -- UNIQUE KEY `stack_id_2` (`stack_id`,`data_timestamp`) USING BTREE,
                    KEY `stack_id` (`stack_id`) USING BTREE,
                    KEY `data_timestamp` (`data_timestamp`) USING BTREE,
                    KEY `data_timeCreated` (`data_timeCreated`) USING BTREE
                  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;");
            }
            Class_db::getInstance()->db_insert($table_name, array('stack_id'=>$pieces[1], 'data_timestamp'=>$pieces[2].' '.substr($pieces[3], 0, 5).':00', 'data_1'=>$pieces[4], 'data_2'=>$pieces[5], 
                    'data_3'=>$pieces[6], 'data_4'=>$pieces[7], 'data_5'=>$pieces[8], 'data_6'=>$pieces[9], 'data_7'=>$pieces[12], 'data_8'=>$pieces[13], 'data_9'=>$pieces[11], 'data_10'=>$pieces[10], 'reading_id'=>$pieces[0]));
            log_debug(__LINE__, 'Insert '.$table_name.'; data_timestamp = '.$pieces[2].' '.substr($pieces[3], 0, 5).':00'.', stack_id = '.$pieces[1], $log_dir);
				
        } else {            
            throw new Exception('(ErrCode:2000) [' . __LINE__ . '] - Total parameter not correct (supposedly 13) = '.count($pieces));
        }
        Class_db::getInstance()->db_commit();
        $form_data = 'success';
    } catch (Exception $e) {
        Class_db::getInstance()->db_rollback();
        // insert error log        
        $form_data = 'fail';
        error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, $log_dir.'/data/err_' . date("Ymd") . '.log');
    }
    Class_db::getInstance()->db_close();
} else if (isset($_GET['sgn'])) {  // admin|password
    $str = $_GET['sgn'];
    log_debug(__LINE__, 'URL received '.$_GET['sgn'].' - '.base64_decode($str), $log_dir);
    $pieces = explode('|', base64_decode($str));
    try {
        Class_db::getInstance()->db_connect();        
        Class_db::getInstance()->db_beginTransaction();
        if (count($pieces) == 2) {
            if ($pieces[0] != '' && $pieces[1] != '') {
                $user_id = Class_db::getInstance()->db_select_col('user', array('user_name'=>'(\''.$pieces[0].'\')', 'user_password'=>$pieces[1], 'user_status'=>'1', 'user_type'=>'2'), 'user_id');
                if (!empty($user_id)) {
                    $wfGroup_id = Class_db::getInstance()->db_select_col('wf_group_user', array('user_id'=>$user_id, 'wfGroupUser_status'=>'1', 'wfGroupUser_isMain'=>'1'), 'wfGroup_id', NULL, 1);
                    $industrial_id = Class_db::getInstance()->db_select_col('t_industrial', array('wfGroup_id'=>$wfGroup_id), 'industrial_premiseId', NULL, 1);
                    $form_data = $industrial_id;
                } else {
                    $form_data = 'fail';
                }
            }
        } else {            
            throw new Exception('(ErrCode:2013) [' . __LINE__ . '] - Total parameter not correct (supposedly 12) = '.count($pieces));
        }
        Class_db::getInstance()->db_commit();
    } catch (Exception $e) {
        Class_db::getInstance()->db_rollback();
        // insert error log        
        $form_data = 'fail';
        error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, $log_dir.'/data/err_' . date("Ymd") . '.log');
    }
    Class_db::getInstance()->db_close();
} else {
    $form_data = 'fail';
    log_debug(__LINE__, 'Fail URL', $log_dir);
}   

//echo $form_data['result'];
echo json_encode($form_data);

//require_once '../library/db.php';
//- type (1/30)
//- indAll_id 
//- inputParam_id
//- data_timestamp
//- data_value
//- data_count

//if (isset($_GET['xyz'])) {
//    $str = $_GET['xyz'];
//    $pieces = explode('|', base64_decode('M3wxfDIz=='));
//    if (count($pieces) == 6) {
//        Class_db::getInstance()->db_connect();  
//        $data_id = Class_db::getInstance()->db_insert('data'.$pieces[0], array('indAll_id'=>$pieces[1], 'inputParam_id'=>$pieces[2], 'data_timestamp'=>'FROM_UNIXTIME('.$pieces[3].')', 'data_value'=>$pieces[4], 'data_count'=>$pieces[5]));
//        Class_db::getInstance()->db_close();
//        
//    }
//}

?>

