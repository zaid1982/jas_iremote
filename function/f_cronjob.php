<?php

require_once 'f_task.php';

class Class_cronjob {   // 16++
    
    private $log_dir = '';
     
    function __construct()
    {
        $config = parse_ini_file('../library/config.ini');
        $this->log_dir = $config['log_dir'];
    }
    
    private function get_exception($codes, $function, $line, $msg) {
        if ($msg != '') {            
            $pos = strpos($msg,'-');
            if ($pos !== false)   
                $msg = substr($msg, $pos+2); 
            return "(ErrCode:".$codes.") [".__CLASS__.":".$function.":".$line."] - ".$msg;
        } else
            return "(ErrCode:".$codes.") [".__CLASS__.":".$function.":".$line."]";
    }
    
    private function log_debug($function, $line, $msg) {
        //$this->log_debug(__FUNCTION__, __LINE__, $sql);
        $debugMsg = date("Y/m/d h:i:sa")." [".__CLASS__.":".$function.":".$line."] - ".$msg."\r\n";
        error_log($debugMsg, 3, $this->log_dir.'/debug/debug_'.date("Ymd").'.log');
    }
    
    public function __get($property) {
        if (property_exists($this, $property)) 
            return $this->$property;
        else
            throw new Exception($this->get_exception('0001', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
    }

    public function __set( $property, $value ) {
        if (property_exists($this, $property)) 
            $this->$property = $value;        
        else
            throw new Exception($this->get_exception('0002', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
    }
    
    public function __isset( $property ) {
        if (property_exists($this, $property)) 
            return isset($this->$property);
        else
            throw new Exception($this->get_exception('0003', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
    }
    
    public function __unset( $property ) {
        if (property_exists($this, $property)) 
            unset($this->$property);
        else
            throw new Exception($this->get_exception('0004', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
    }
    
    public function run_cronjob () {
        try {
            $cronjob = Class_db::getInstance()->db_select_single('cronjob', array('cron_date'=>'Curdate()', 'cron_status'=>'1'));
            if (empty($cronjob)) {
                $this->run_cron_forum_ditutup();
            }
            
            //Class_db::getInstance()->db_insert('cronjob', array('cron_date'=>'Curdate()'));
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function run_cron_forum_ditutup () {
        try {
            $fn_task = new Class_task();  
            $result = Class_db::getInstance()->db_select('forum', array('forum_dateEnd'=>'<=Curdate()', 'forum_status'=>'32'), 'forum_dateEnd');
            foreach ($result as $key => $value) {
                echo $value['forum_id'];
                // submit tasktype 63 to appear 64 status 32
                $wfTask_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTrans_id'=>$value['wfTrans_id'], 'wfTaskType_id'=>'63', 'wfTask_partition'=>'1'), 'wfTask_id');
                if ($wfTask_id != '') {  
                    $user_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTask_claimedBy');
                    $fn_task->task_submit($user_id, $wfTask_id, '63', '32');
                }
                // update tasktype 62 to close where wfTrans_id
                $whereArr = array('wfTaskType_id'=>'62', 'wfTrans_id'=>$value['wfTrans_id'], 'wfTask_partition'=>'1');
                $setArr = array('wfTask_partition'=>'2', 'wfTask_status'=>'31', 'wfTask_timeSubmitted'=>'Now()');
                Class_db::getInstance()->db_update('wf_task', $setArr, $whereArr);
                // update status forum
                Class_db::getInstance()->db_update('forum', array('forum_status'=>'35'), array('forum_id'=>$value['forum_id']));
            }
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
}

?>
