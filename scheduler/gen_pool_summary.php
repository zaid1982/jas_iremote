<?php

require_once '../library/db.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

try {
    Class_db::getInstance()->db_connect();      
    
    $general_var = Class_db::getInstance()->db_select_single('vw_general_now', array('general_desc'=>'pooling_summary_start'), NULL, 1);
    if (empty($general_var['general_remark']))
        throw new Exception('(ErrCode:8001) [' . __LINE__ . '] - Parameter time_start from ref_general empty');
    $time_start = $general_var['general_remark'];
    $time_end = $general_var['time_now'];
    $yr = substr(date("Y"),2);
    if ($yr != substr($time_start,2,2)) {
        $time_end = $general_var['time_end'];
        $yr = substr($time_start,2,2);
    }
    $table_summary = 'y'.$yr.'_data_daily';    
    if (Class_db::getInstance()->db_count('information_schema.tables', array('TABLE_SCHEMA'=>'cems', 'TABLE_NAME'=>$table_summary)) < 1) {
        log_debug(__LINE__, 'Summary table not exist = '.$table_summary, $log_dir);
        Class_db::getInstance()->db_create_table("CREATE TABLE `y".$yr."_data_daily` (
            `ydaily_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `ydaily_date` date NOT NULL,
            `industrial_id` smallint(5) unsigned NOT NULL,
            `stack_id` varchar(10) NOT NULL,
            `inputParam_id` tinyint(3) unsigned NOT NULL,
            `ydaily_count` smallint(5) unsigned NOT NULL DEFAULT '0',
            `ydaily_timeInsert` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `ydaily_timeUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`ydaily_id`),
            KEY `inputParam_id` (`inputParam_id`) USING BTREE,
            KEY `ydaily_date` (`ydaily_date`),
            KEY `stack_id` (`stack_id`),
            KEY `industrial_id` (`industrial_id`),
            CONSTRAINT `y".$yr."_data_daily_ibfk_1` FOREIGN KEY (`inputParam_id`) REFERENCES `t_input_parameter` (`inputParam_id`),
            CONSTRAINT `y".$yr."_data_daily_ibfk_3` FOREIGN KEY (`industrial_id`) REFERENCES `t_industrial` (`industrial_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;');");
    }        
    
    $arr_industrial = Class_db::getInstance()->db_select('t_industrial', array('industrial_status'=>'1'));
    if (empty($arr_industrial))
        throw new Exception('(ErrCode:8002) [' . __LINE__ . '] - No active industrial premise');
    
    foreach ($arr_industrial as $industrial) {
        try {
            $table_name = 'z'.$yr.'_'.preg_replace("/[^a-zA-Z0-9]/", "", $industrial['industrial_premiseId']);
            if (Class_db::getInstance()->db_count('information_schema.tables', array('TABLE_SCHEMA'=>'cems', 'TABLE_NAME'=>$table_name)) < 1) {
                log_debug(__LINE__, 'Table not exist = '.$table_name, $log_dir);
                continue;
            }        
            log_debug(__LINE__, 'Table name = '.$table_name, $log_dir);
            $arr_data = Class_db::getInstance()->db_select('dt_pool_summary', array(), NULL, NULL, 1, array('tablename'=>$table_name, 'time_start'=>$time_start, 'time_end'=>$time_end));
            foreach ($arr_data as $data) {
                for ($i=1; $i<=10; $i++) {
                    if (intval($data['count_'.$i]) > 0) {
                        echo $data['stack_id'].' '.$data['dates'].' '.$data['count_'.$i].'</br>';
                        if (Class_db::getInstance()->db_update($table_summary, array('ydaily_count'=>'|ydaily_count+'.$data['count_'.$i], 'ydaily_timeUpdate'=>'Now()'), array('ydaily_date'=>$data['dates'], 'industrial_id'=>$industrial['industrial_id'], 'inputParam_id'=>$i, 'stack_id'=>$data['stack_id'])) == 0) {
                            Class_db::getInstance()->db_insert($table_summary, array('ydaily_date'=>$data['dates'], 'industrial_id'=>$industrial['industrial_id'], 'stack_id'=>$data['stack_id'], 'inputParam_id'=>$i, 'ydaily_count'=>$data['count_'.$i]));
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $ex->getMessage() . "\r\n", 3, '../logs/error/error_' . date("Ymd") . '.log');
        }    
    }
    Class_db::getInstance()->db_update('ref_general', array('general_remark'=>$time_end), array('general_desc'=>'pooling_summary_start'));
} catch (Exception $e) {
    error_log(date("Y/m/d h:i:sa") . " [" . __FILE__ . ":" . __LINE__ . "] - " . $e->getMessage() . "\r\n", 3, '../logs/error/error_' . date("Ymd") . '.log');
}
Class_db::getInstance()->db_close();
echo 'Done';
exit;

?>