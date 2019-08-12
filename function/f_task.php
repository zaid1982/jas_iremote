<?php

class Class_task {
     
    public $submission_flag = '';
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
    
     public function task_claim ($user_id, $wfTask_id) {
        try {
            return Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>$user_id, 'wftask_timeClaimed'=>'Now()'), array('wfTask_id'=>$wfTask_id));
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
            
    public function task_unclaim ($wfTask_id) {
        try {
            return Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>'NULL', 'wftask_timeClaimed'=>'NULL'), array('wfTask_id'=>$wfTask_id));
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function save_log ($user_id, $wfTask_id, $activity_text, $document_id=NULL) {
        try {
            $wfGroup_id =  Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfGroup_id');
            $columns = array('user_id'=>$user_id, 'wfTask_id'=>$wfTask_id, 'activity_text'=>$activity_text);
            if ($document_id != NULL && $document_id != '')
                $columns['document_id'] = $document_id;
            if ($wfGroup_id != '')
                $columns['wfGroup_id'] = $wfGroup_id;
            return Class_db::getInstance()->db_insert('activity_log', $columns);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }       
    
    public function get_running_no ($wfFlow_id='') {
        try {
            $run_no_new = '';
            $run_turn = '0';
            if ($wfFlow_id != '') {
                $wfFlow_code = Class_db::getInstance()->db_select_col('wf_flow', array('wfFlow_id'=>$wfFlow_id), 'wfFlow_code', NULL, 1);
                $rows = Class_db::getInstance()->db_select_single('wf_transaction', array('wfFlow_id'=>$wfFlow_id), 'wfTrans_no desc');
                if (empty($rows)) {
                    $run_no_new = 'D'.$wfFlow_code.'/'.substr(date('Ym'),2).'/00001';
                } else {
                    $run_no = $rows['wfTrans_no'];
                    $run_turn = substr(intVal(substr($run_no, -5))+100001,1); 
                    $run_no_new = 'D'.$wfFlow_code.'/'.substr(date('Ym'),2).'/'.$run_turn;
                }
            } else
                throw new Exception('(ErrCode:1309) ['.__LINE__.'] - Get running no parameter $wfFlow_id not valid.');
            return $run_no_new;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function get_registration_no ($wfTask_id='') {   // CPM/169843-1/17/03/01        
        try {
            $reg_no_new = '';
            $reg_company = '';
            if ($wfTask_id == '') 
                throw new Exception('(ErrCode:1310) ['.__LINE__.'] - Function get_registration_no parameter $wfTask_id empty.');
            $wf_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$wfTask_id), NULL, 1);
            $wf_task_type = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$wf_task['wfTaskType_id']), NULL, 1);
            $wfFlow_code = Class_db::getInstance()->db_select_col('wf_flow', array('wfFlow_id'=>$wf_task_type['wfFlow_id']), 'wfFlow_code', NULL, 1);
            if (in_array($wf_task_type['wfFlow_id'], array('1', '2', '3'))) {
                $reg_company = Class_db::getInstance()->db_select_col('vw_wfGroup_consultant', array('wfTrans_id'=>$wf_task['wfTrans_id']), 'wfGroup_regNo', NULL, 1);
            } else if (in_array($wf_task_type['wfFlow_id'], array('4', '5'))) {
                $industrial_id = Class_db::getInstance()->db_select_col('t_industrial_all', array('wfTrans_id'=>$wf_task['wfTrans_id']), 'industrial_id', NULL, 1);
                $reg_company = Class_db::getInstance()->db_select_col('t_industrial', array('industrial_id'=>$industrial_id), 'industrial_premiseId', NULL, 1);
            }  
            $reg_no_syntax = $wfFlow_code.'/'.$reg_company.'/'.substr(date('Y'),2).'/'.substr(date('Ym'),2).'/';
            $rows = Class_db::getInstance()->db_select_single('wf_transaction', array('wfFlow_id'=>$wf_task_type['wfFlow_id'], 'wfTrans_regNo'=>'%'.$reg_no_syntax.'%'), 'wfTrans_regNo desc');
            if (empty($rows)) {
                $reg_no_new = $reg_no_syntax.'01';
            } else {
                $run_no = $rows['wfTrans_regNo'];
                $reg_turn = substr(intVal(substr($run_no, -2))+101,1); 
                $reg_no_new = $reg_no_syntax.$reg_turn;
            }
            return $reg_no_new;
        } 
        catch (Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function task_create ($user_id, $wfFlow_id, $wfGroup_id, $wfTaskType_id) {
        try {
            $wfTrans_no = $this->get_running_no($wfFlow_id);
            $columns = array('wfFlow_id'=>$wfFlow_id, 'wfTrans_no'=>$wfTrans_no, 'wfTrans_createdByGr'=>$wfGroup_id, 'wfTrans_createdBy'=>$user_id, 'wfTrans_status'=>'2');
            if (intval($wfFlow_id) > 5) {
                $columns['wfTrans_no'] = substr($wfTrans_no,1);
                $columns['wfTrans_regNo'] =  substr($wfTrans_no,1);
            }
            $wfTrans_id = Class_db::getInstance()->db_insert('wf_transaction', $columns);            
            $columns = array('wfTrans_id'=>$wfTrans_id, 'wfTaskType_id'=>$wfTaskType_id, 'wfGroup_id'=>$wfGroup_id, 'wfTask_createdByGr'=>$wfGroup_id, 'wfTask_createdBy'=>$user_id, 
                'wfTask_claimedBy'=>$user_id, 'wfTask_timeClaimed'=>'Now()', 'wfTask_status'=>'2');
            return Class_db::getInstance()->db_insert('wf_task', $columns);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function task_return ($user_id, $wfTask_id, $status='21', $remarks='', $wfTask_refName='', $wfTask_refValue='') {
        try {
            $next_wfGroup_id = '';
            $current_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_claimedBy'=>$user_id), NULL, 1);
            $current_taskType = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$current_task['wfTaskType_id']), NULL, 1);
            $process_submit = $this->process_submit ($wfTask_id, $current_task['wfTrans_id'], $current_task['wfTaskType_id'], $status, $user_id, $remarks);
            $wfTask_refValue = $process_submit != '' ? $process_submit : $wfTask_refValue;
            $next_taskType = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$current_taskType['wfTaskType_back']), NULL, 1);
            if ($next_taskType['wfTaskType_isAssigned'] == 'Y') {
                $columns = array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTaskType_id'=>$next_taskType['wfTaskType_id']);
                $next_wfGroup_id = Class_db::getInstance()->db_select_col('wf_task_assign', $columns, 'wfGroup_id', 'wfTaskAssign_id desc', 1);                
                $next_wfGroup_id = Class_db::getInstance()->db_select_col('wf_group',  array('uType_id'=>$next_taskType['uType_id'], 'wfGroup_id'=>$next_wfGroup_id), 'wfGroup_id', NULL, 1);
            } else {
                $next_wfGroup_id = Class_db::getInstance()->db_select_col('wf_group', array('uType_id'=>$next_taskType['uType_id']), 'wfGroup_id', 'wfGroup_id desc', 1);
            }            
            $setArr = array('wfTask_partition'=>'2', 'wfTask_status'=>$status, 'wfTask_timeSubmitted'=>'Now()', 'wfTask_remark'=>$remarks);
            Class_db::getInstance()->db_update('wf_task', $setArr, array('wfTask_id'=>$wfTask_id));
            $columns = array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTask_createdBy'=>$user_id, 'wfTask_createdByGr'=>$current_task['wfGroup_id'], 'wfTask_refName'=>$wfTask_refName, 'wfTask_refValue'=>$wfTask_refValue,
                'wfGroup_id'=>$next_wfGroup_id, 'wfTaskType_id'=>$next_taskType['wfTaskType_id'], 'wfTask_status'=>$status, 'wfTask_dateExpired'=>'|DATE_ADD(CURDATE(),INTERVAL '.$next_taskType['wfTaskType_duration'].' DAY)');
            $next_task_id = Class_db::getInstance()->db_insert('wf_task', $columns);
            return $next_task_id;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    private function process_submit ($wfTask_id, $wfTrans_id, $wfTaskType_id, $status, $wfFlow_id, $user_id) {
        try {
            $this->log_debug(__FUNCTION__, __LINE__, "entering process_submit()");
            $wfTrans_status = '';
            if (in_array($wfFlow_id, array('1', '2', '3'))) {
                if ($status == '10') {  // submit
                    $wfFlow_duration = Class_db::getInstance()->db_select_col('wf_flow', array('wfFlow_id'=>$wfFlow_id), 'wfFlow_duration', NULL, 1);
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4', 'wfTrans_timeSubmit'=>'Now()', 'wfTrans_dateDue'=>'|DATE_ADD(CURDATE(),INTERVAL '.$wfFlow_duration.' DAY)'), array('wfTrans_id'=>$wfTrans_id));
                    $consAll_id = Class_db::getInstance()->db_select_col('t_consultant_all', array('wfTrans_id'=>$wfTrans_id), 'consAll_id', NULL, 1);
                    Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>'4', 'consAll_dateDeclaration'=>'Curdate()'), array('consAll_id'=>$consAll_id));
                    if ($wfTaskType_id == '1') {
                        Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>'4'), array('consAll_id'=>$consAll_id));
                    } else if ($wfTaskType_id == '11') {
                        Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>'4'), array('consAll_id'=>$consAll_id));
                    } else if ($wfTaskType_id == '21') {
                        Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_status'=>'4'), array('consAll_id'=>$consAll_id));
                    }
                    $consultant_id = Class_db::getInstance()->db_select_col('t_consultant_all', array('consAll_id'=>$consAll_id), 'consultant_id', NULL, 1);
                    $wfGroup_id = Class_db::getInstance()->db_select_col('t_consultant', array('consultant_id'=>$consultant_id), 'wfGroup_id', NULL, 1);
                    $arr_consultant_personnel = Class_db::getInstance()->db_select('t_consultant_personnel', array('consAll_id'=>$consAll_id, 'consPers_workingStatus'=>'1'));
                    foreach ($arr_consultant_personnel as $consultant_personnel) {                        
                        $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_id'=>$consultant_personnel['personnel_id']), NULL, 1);
                        if ($personnel['personnel_status'] == '2') {
                            Class_db::getInstance()->db_update('t_personnel', array('personnel_status'=>'4', 'wfGroup_id'=>$wfGroup_id), array('personnel_id'=>$personnel['personnel_id']));
                        }                                               
                    }
                    Class_db::getInstance()->db_update('t_consultant_personnel', array('consPers_status'=>'4'), array('consAll_id'=>$consAll_id));
                } else if ($status == '14') {  // delete draft
                    $consAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'consAll_id'), 'wfTask_refValue', NULL, 1);
                    Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>'8'), array('consAll_id'=>$consAll_id));
                    if ($wfTaskType_id == '1') {
                        Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>'8'), array('consAll_id'=>$consAll_id));
                    } else if ($wfTaskType_id == '11') {
                        Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>'8'), array('consAll_id'=>$consAll_id));
                    } else if ($wfTaskType_id == '21') {
                        Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_status'=>'8'), array('consAll_id'=>$consAll_id));
                    }
                    $this->submission_flag = '8';
                } else if ($status == '11') {   // reject
                    $consAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'consAll_id'), 'wfTask_refValue', NULL, 1);
                    Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>'23'), array('consAll_id'=>$consAll_id));
                    if (in_array($wfTaskType_id, array('3', '4', '5'))) {
                        Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>'23'), array('consAll_id'=>$consAll_id));
                    } else if (in_array($wfTaskType_id, array('13', '14', '15'))) {
                        Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>'23'), array('consAll_id'=>$consAll_id));
                    } else if (in_array($wfTaskType_id, array('23', '24', '25'))) {
                        Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_status'=>'23'), array('consAll_id'=>$consAll_id));
                    }
                    $consultant_id = Class_db::getInstance()->db_select_col('t_consultant_all', array('consAll_id'=>$consAll_id), 'consultant_id', NULL, 1);
                    $wfGroup_id = Class_db::getInstance()->db_select_col('t_consultant', array('consultant_id'=>$consultant_id), 'wfGroup_id', NULL, 1);
                    $arr_consultant_personnel = Class_db::getInstance()->db_select('t_consultant_personnel', array('consAll_id'=>$consAll_id, 'consPers_workingStatus'=>'1'));
                    foreach ($arr_consultant_personnel as $consultant_personnel) {                        
                        $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_id'=>$consultant_personnel['personnel_id']), NULL, 1);
                        if ($personnel['personnel_status'] == '4') {
                            Class_db::getInstance()->db_update('t_personnel', array('personnel_status'=>'2', 'wfGroup_id'=>$wfGroup_id), array('personnel_id'=>$personnel['personnel_id']));
                        }                                               
                    }
                    Class_db::getInstance()->db_update('t_consultant_personnel', array('consPers_status'=>'23'), array('consAll_id'=>$consAll_id));
                    $this->submission_flag = '23';
                } else if ($status == '12') {   // return
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'22'), array('wfTrans_id'=>$wfTrans_id));
                    if (in_array($wfTaskType_id, array('3', '13', '23'))) {                        
                        $consAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'consAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>'22'), array('consAll_id'=>$consAll_id));
                        if ($wfTaskType_id == '3') {
                            Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>'22'), array('consAll_id'=>$consAll_id));
                        } else if ($wfTaskType_id == '13') {
                            Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>'22'), array('consAll_id'=>$consAll_id));
                        } else if ($wfTaskType_id == '23') {
                            Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_status'=>'22'), array('consAll_id'=>$consAll_id));
                        }
                    }
                    $this->submission_flag = '22';
                } else if ($status == '13') {   // resubmit
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4'), array('wfTrans_id'=>$wfTrans_id));
                    if (in_array($wfTaskType_id, array('1', '11', '21'))) {
                        $consAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'consAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>'4'), array('consAll_id'=>$consAll_id));
                        if ($wfTaskType_id == '1') {
                            Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>'4'), array('consAll_id'=>$consAll_id));
                        } else if ($wfTaskType_id == '11') {
                            Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>'4'), array('consAll_id'=>$consAll_id));
                        } else if ($wfTaskType_id == '21') {
                            Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_status'=>'4'), array('consAll_id'=>$consAll_id));
                        }
                    }
                    $this->submission_flag = '21';
                } else if ($status == '18') {   // approve 
                    if (in_array($wfTaskType_id, array('5', '15', '25'))) {
                        $consAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'consAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>'1'), array('consAll_id'=>$consAll_id));
                        if ($wfTaskType_id == '5') {
                            Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>'1'), array('consAll_id'=>$consAll_id));
                        } else if ($wfTaskType_id == '15') {
                            Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>'1'), array('consAll_id'=>$consAll_id));
                        } else if ($wfTaskType_id == '25') {
                            Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_status'=>'1'), array('consAll_id'=>$consAll_id));
                        }
                        $consultant_id = Class_db::getInstance()->db_select_col('t_consultant_all', array('consAll_id'=>$consAll_id), 'consultant_id', NULL, 1);
                        Class_db::getInstance()->db_update('t_consultant', array('consultant_status'=>'1'), array('consultant_id'=>$consultant_id));
                        $wfGroup_id = Class_db::getInstance()->db_select_col('t_consultant', array('consultant_id'=>$consultant_id), 'wfGroup_id', NULL, 1);
                        $arr_consultant_personnel = Class_db::getInstance()->db_select('t_consultant_personnel', array('consAll_id'=>$consAll_id, 'consPers_workingStatus'=>'1'));
                        foreach ($arr_consultant_personnel as $consultant_personnel) {                        
                            $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_id'=>$consultant_personnel['personnel_id']), NULL, 1);
                            if ($personnel['personnel_status'] == '4') {
                                Class_db::getInstance()->db_update('t_personnel', array('personnel_status'=>'1', 'wfGroup_id'=>$wfGroup_id), array('personnel_id'=>$personnel['personnel_id']));
                            }                                               
                        }
                        Class_db::getInstance()->db_update('t_consultant_personnel', array('consPers_status'=>'1'), array('consAll_id'=>$consAll_id));
                        $wfTrans_regNo = $this->get_registration_no($wfTask_id);
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_regNo'=>$wfTrans_regNo), array('wfTrans_id'=>$wfTrans_id));
                    }                    
                    $this->submission_flag = '24';
                }
            } else if (in_array($wfFlow_id, array('4', '5'))) {
                if ($status == '10') {  // submit
                    if (in_array($wfTaskType_id, array('31', '41'))) {
                        $wfFlow_duration = Class_db::getInstance()->db_select_col('wf_flow', array('wfFlow_id'=>$wfFlow_id), 'wfFlow_duration', NULL, 1);
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4', 'wfTrans_timeSubmit'=>'Now()', 'wfTrans_dateDue'=>'|DATE_ADD(CURDATE(),INTERVAL '.$wfFlow_duration.' DAY)'), array('wfTrans_id'=>$wfTrans_id));
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'4', 'indAll_dateDeclaration'=>'Curdate()'), array('wfTrans_id'=>$wfTrans_id));
                    } else if (in_array($wfTaskType_id, array('37', '47'))) {
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4'), array('wfTrans_id'=>$wfTrans_id));
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'29'), array('indAll_id'=>$indAll_id));
                        Class_db::getInstance()->db_update('t_qa', array('qa_status'=>'4'), array('indAll_id'=>$indAll_id, 'wfTask_id'=>$wfTask_id));
                        $qa_id = Class_db::getInstance()->db_select_col('t_qa', array('wfTask_id'=>$wfTask_id), 'qa_id', NULL, 1);
                        $this->calculate_qa(($wfTaskType_id=='47'?'2':'1'), $qa_id);
                    }
                } else if ($status == '14') {  // delete draft
                    $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                    Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'8'), array('indAll_id'=>$indAll_id));
                    $this->submission_flag = '8';
                } else if ($status == '11') {   // reject
                    $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                    Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'23'), array('indAll_id'=>$indAll_id));
                    $this->submission_flag = '23';
                } else if ($status == '12') {   // return                    
                    if (in_array($wfTaskType_id, array('33', '43'))) {     
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'22'), array('wfTrans_id'=>$wfTrans_id));
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'22'), array('indAll_id'=>$indAll_id));
                    } else if (in_array($wfTaskType_id, array('38', '48'))) {
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'28'), array('wfTrans_id'=>$wfTrans_id));
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'28'), array('indAll_id'=>$indAll_id));
                        Class_db::getInstance()->db_update('t_qa', array('qa_status'=>'22'), array('indAll_id'=>$indAll_id, 'qa_status'=>'4'));
                    }                   
                    $this->submission_flag = '22';
                } else if ($status == '13') {   // resubmit
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4'), array('wfTrans_id'=>$wfTrans_id));
                    if (in_array($wfTaskType_id, array('31', '41'))) {
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'4'), array('indAll_id'=>$indAll_id));
                    } else if (in_array($wfTaskType_id, array('37', '47'))) {
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'29'), array('indAll_id'=>$indAll_id));
                        $qa_id = Class_db::getInstance()->db_select_col('vw_qa_task', array('wfTrans_id'=>$wfTrans_id, 'wfTask_id'=>'<='.$wfTask_id), 'qa_id', 'qa_id DESC', 1);
                        Class_db::getInstance()->db_update('t_qa', array('qa_status'=>'4'), array('qa_id'=>$qa_id));
                        $this->calculate_qa(($wfTaskType_id=='47'?'2':'1'), $qa_id);
                    }
                    $this->submission_flag = '21';
                } else if ($status == '17') {   // verify
                    if (in_array($wfTaskType_id, array('38', '48'))) {
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'30'), array('wfTrans_id'=>$wfTrans_id));
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'30'), array('indAll_id'=>$indAll_id));
                        $industrial_id = Class_db::getInstance()->db_select_col('t_industrial_all', array('indAll_id'=>$indAll_id), 'industrial_id', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial', array('industrial_status'=>'1'), array('industrial_id'=>$industrial_id));
                        $qa_id = Class_db::getInstance()->db_select_col('vw_qa_task', array('wfTrans_id'=>$wfTrans_id, 'wfTask_id'=>'<='.$wfTask_id), 'qa_id', 'qa_id DESC', 1);
                        Class_db::getInstance()->db_update('t_qa', array('qa_status'=>'49'), array('qa_id'=>$qa_id));
                        $this->save_qa_schedule($indAll_id);
                        $this->submission_flag = '30';
                    }    
                } else if ($status == '18') {   // approve 
                    if (in_array($wfTaskType_id, array('35', '45'))) {
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'27'), array('indAll_id'=>$indAll_id));
                        $industrial_id = Class_db::getInstance()->db_select_col('t_industrial_all', array('indAll_id'=>$indAll_id), 'industrial_id', NULL, 1);
                        Class_db::getInstance()->db_update('t_industrial', array('industrial_status'=>'24'), array('industrial_id'=>$industrial_id));
                        $wfTrans_regNo = $this->get_registration_no($wfTask_id);
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_regNo'=>$wfTrans_regNo, 'wfTrans_status'=>'27'), array('wfTrans_id'=>$wfTrans_id));
                        $this->submission_flag = '27';
                    }                  
                } else if ($status == '27') {   // Initial RATA set date 
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'28'), array('wfTrans_id'=>$wfTrans_id));
                    $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                    Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'28'), array('indAll_id'=>$indAll_id));
                    $this->submission_flag = '28';
                } else if ($status == '46') {   // return and redo Initial RATA
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'47'), array('wfTrans_id'=>$wfTrans_id));
                    $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                    Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>'47'), array('indAll_id'=>$indAll_id));
                } 
            } else if (in_array($wfFlow_id, array('6', '7'))) {
                $response_status = '';
                $response_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'response_id'), 'wfTask_refValue', NULL, 1);
                if ($wfTaskType_id == '52' || $wfTaskType_id == '62') {
                    $this->submission_flag = $status == '13' ? '21' : '20';
                    $response_status = '32';               
                    Class_db::getInstance()->db_update('t_response_doc', array('responseDoc_status'=>'1'), array('responseDoc_status'=>'2', 'response_id'=>$response_id));
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4', 'wfTrans_timeSubmit'=>'Now()'), array('wfTrans_id'=>$wfTrans_id));
                } else if ($wfTaskType_id == '53' || $wfTaskType_id == '63') {
                    $this->submission_flag = $status == '12' ? '22' : '24';
                    $response_status = $status == '12' ? '22' : '34';
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>$this->submission_flag), array('wfTrans_id'=>$wfTrans_id));
                }
                if ($response_status == '')
                    throw new Exception('(ErrCode:1314) ['.__LINE__.'] - Parameter response_status empty.');
                Class_db::getInstance()->db_update('t_response', array('response_status'=>$response_status, 'response_timeSubmit'=>'Now()'), array('wfTrans_id'=>$wfTrans_id));
            } else if ($wfFlow_id == '8') {
                $qnf_status = '';
                $qnf_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'qnf_id'), 'wfTask_refValue', NULL, 1);
                if ($wfTaskType_id == '72') {
                    $profile = Class_db::getInstance()->db_select_single('profile', array('user_id'=>$user_id, 'profile_status'=>'1'), NULL, 1);                    
                    $this->submission_flag = $status == '42' ? '43' : '20';
                    $qnf_status = '4';
                    if ($status == '10') {
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4', 'wfTrans_timeSubmit'=>'Now()'), array('wfTrans_id'=>$wfTrans_id));
                        Class_db::getInstance()->db_update('t_qnf', array('qnf_status'=>$qnf_status, 'qnf_timeSubmitted'=>'Now()', 'qnf_name'=>$profile['profile_name'], 'qnf_contactNo'=>$profile['profile_mobileNo'], 'qnf_email'=>$profile['profile_email']), array('qnf_id'=>$qnf_id));
                    } else if ($status == '42') {
                        Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4'), array('wfTrans_id'=>$wfTrans_id));
                        Class_db::getInstance()->db_update('t_qnf', array('qnf_status'=>$qnf_status, 'qnf_name'=>$profile['profile_name'], 'qnf_contactNo'=>$profile['profile_mobileNo'], 'qnf_email'=>$profile['profile_email']), array('qnf_id'=>$qnf_id));
                    } else 
                        throw new Exception('(ErrCode:1320) ['.__LINE__.'] - Parameter status not valid = '.$status);
                    Class_db::getInstance()->db_update('t_qnf_doc', array('qnfDoc_status'=>'1'), array('qnfDoc_status'=>'2', 'qnf_id'=>$qnf_id));
                } else if ($wfTaskType_id == '73') {
                    if ($status == '12') {
                        $this->submission_flag = '22';
                        $qnf_status = '22';
                    } else if ($status == '40') {
                        $this->submission_flag = '41';
                        $qnf_status = '41';
                    } else if ($status == '38') {
                        $this->submission_flag = '39';
                        $qnf_status = '4';
                    } else 
                        throw new Exception('(ErrCode:1320) ['.__LINE__.'] - Parameter status not valid = '.$status);
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>$this->submission_flag), array('wfTrans_id'=>$wfTrans_id));
                    Class_db::getInstance()->db_update('t_qnf', array('qnf_status'=>$qnf_status), array('qnf_id'=>$qnf_id));
                } else if ($wfTaskType_id == '74') {
                    if ($status == '12') {
                        $this->submission_flag = '44';
                        $qnf_status = '44';
                    } else if ($status == '40') {
                        $this->submission_flag = '41';
                        $qnf_status = '41';
                    } else if ($status == '45') {
                        $this->submission_flag = '22';
                        $qnf_status = '4';
                    } else 
                        throw new Exception('(ErrCode:1320) ['.__LINE__.'] - Parameter status not valid = '.$status);
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>$this->submission_flag), array('wfTrans_id'=>$wfTrans_id));
                    Class_db::getInstance()->db_update('t_qnf', array('qnf_status'=>$qnf_status), array('qnf_id'=>$qnf_id));                    
                }
            } else if ($wfFlow_id == '9') {
                $certificate_status = '';
                $certificate_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'certificate_id'), 'wfTask_refValue', NULL, 1);
                if ($wfTaskType_id == '81') {
                    $this->submission_flag = $status == '13' ? '21' : '20';
                    $certificate_status = '4';
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4', 'wfTrans_timeSubmit'=>'Now()'), array('wfTrans_id'=>$wfTrans_id));
                    Class_db::getInstance()->db_update('t_certificate', array('certificate_status'=>$certificate_status, 'certificate_timeSubmit'=>'Now()'), array('certificate_id'=>$certificate_id));
                } else if ($wfTaskType_id == '82') {
                    $this->submission_flag = $status == '12' ? '22' : '24';
                    $certificate_status = $status == '12' ? '22' : '1';
                    $timeFinish = $status == '12' ? '' : 'Now()';
                    Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>$this->submission_flag), array('wfTrans_id'=>$wfTrans_id));
                    Class_db::getInstance()->db_update('t_certificate', array('certificate_status'=>$certificate_status, 'certificate_timeFinish'=>$timeFinish), array('certificate_id'=>$certificate_id));
                    if ($status == '18') {
                        $certificate_renewed = Class_db::getInstance()->db_select_col('t_certificate', array('certificate_id'=>$certificate_id), 'certificate_renewed', NULL, 1);
                        Class_db::getInstance()->db_update('t_certificate', array('certificate_status'=>'3'), array('certificate_id'=>$certificate_renewed));
                    }
                }
                if ($certificate_status == '')
                    throw new Exception('(ErrCode:1319) ['.__LINE__.'] - Parameter certificate_status empty.');
            }
            return '';
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function task_submit ($user_id, $wfTask_id, $wfTaskType_id='', $status='10', $remarks='', $condition_no='', $assignedGroup=NULL, $jumpTaskType_id=NULL, $assignedUser=NULL, $wfTask_refName='', $wfTask_refValue='') {
        try {
            $this->log_debug(__FUNCTION__, __LINE__, "entering task_submit()");
            $this->submission_flag = '';
            // checking task current status, claimed by this user
            $status = $status == '' ? '10' : $status;
            if ($user_id == '' || $wfTask_id == '')
                throw new Exception('(ErrCode:1302) ['.__LINE__.'] - Parameter empty.');
            $current_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_claimedBy'=>$user_id), NULL, 1);
            $wfTaskType_id = $current_task['wfTaskType_id'];
            $next_taskType_id = '';
            $current_taskType = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$wfTaskType_id), NULL, 1);
                        
            if ($jumpTaskType_id != NULL) {
                $check_taskType = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$jumpTaskType_id), NULL, 1);
                $next_taskType_id = $jumpTaskType_id;
            } else {                
                $next_taskType_id = $current_taskType['wfTaskType_next'];
                if ($next_taskType_id == '')
                    throw new Exception('(ErrCode:1303) ['.__LINE__.'] - Next task unavailable.');
                else if ($condition_no != '') {
                    if ($condition_no == '1' || $condition_no == '2' || $condition_no == '3') {
                        if ($current_taskType['wfTaskType_condition'.$condition_no] == '')
                            throw new Exception('(ErrCode:1304) ['.__LINE__.'] - Condition No taskType_id unavailable.');
                        $next_taskType_id = $current_taskType['wfTaskType_condition'.$condition_no];
                    } else
                        throw new Exception('(ErrCode:1305) ['.__LINE__.'] - Condition No format error.');
                }           
            }
            $next_taskType = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$next_taskType_id), NULL, 1);            
            
            $process_submit = $this->process_submit($wfTask_id, $current_task['wfTrans_id'], $wfTaskType_id, $status, $current_taskType['wfFlow_id'], $user_id);
            $wfTask_refValue = $process_submit != '' ? $process_submit : $wfTask_refValue;
            if ($current_taskType['wfTaskCate_id'] == '5')
                throw new Exception('(ErrCode:1308) ['.__LINE__.'] - Cannot allow submission, submission trigger by cron by due date.');
            
            if ($next_taskType['wfTaskType_isEnd'] == 'Y') {    // end of process
                $setArr = array('wfTask_partition'=>'2', 'wfTask_status'=>$status, 'wfTask_timeSubmitted'=>'Now()', 'wfTask_remark'=>$remarks);
                Class_db::getInstance()->db_update('wf_task', $setArr, array('wfTask_id'=>$wfTask_id));                
                $trans_status = $this->submission_flag != '' ? $this->submission_flag : '9';
                $wf_transaction = Class_db::getInstance()->db_select_single('wf_transaction', array('wfTrans_id'=>$current_task['wfTrans_id']), NULL, 1);
                Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_timeFinish'=>'Now()', 'wfTrans_status'=>$trans_status), array('wfTrans_id'=>$current_task['wfTrans_id']));  
                $end_status = $this->submission_flag != '' ? $this->submission_flag : '';
                $columns = array('wfTask_partition'=>'1', 'wfTask_status'=>$status, 'wfTask_timeSubmitted'=>'Now()' , 'wfTrans_id'=>$current_task['wfTrans_id'], 'wfTask_createdBy'=>$user_id, 'wfTask_createdByGr'=>$current_task['wfGroup_id'], 'wfTask_claimedBy'=>$wf_transaction['wfTrans_createdBy'],
                    'wfTaskType_id'=>$next_taskType_id, 'wfGroup_id'=>$wf_transaction['wfTrans_createdByGr'], 'wfTask_refName'=>$wfTask_refName, 'wfTask_refValue'=>$wfTask_refValue, 'wfTask_status'=>$end_status);
                $next_task_id = Class_db::getInstance()->db_insert('wf_task', $columns);
                return 'end';
            } else {
//                if ($next_taskType['uType_id'] == '')
//                    throw new Exception('(ErrCode:1306) ['.__LINE__.'] - Next Task uType_id empty.');
                $claimed_user = '';
                $next_wfGroup_id = '';
                if ($assignedGroup != '') {
                    // check and get taskType assigned to  
                    $arr_task_assign_where = Class_db::getInstance()->db_select('wf_task_assign_where', array('wfTaskType_From'=>$wfTaskType_id));
                    foreach ($arr_task_assign_where as $task_assign_where) {    
                        $where_user_id = '';
                        $where_wfGroup_id = '';
                        if ($task_assign_where['wfTaskAssignWhere_isUser'] == 'Y') {
                            $where_user_id = $user_id;
                            $where_wfGroup_id = $current_task['wfGroup_id'];
                        } else if ($task_assign_where['wfTaskAssignWhere_isUser'] == 'S') {
                            if ($current_taskType['wfTaskCate_id'] == '7') {
                                $where_user_id = $assignedUser;
                                $where_wfGroup_id = $assignedGroup;                                
                            } else 
                                throw new Exception('(ErrCode:1311) ['.__LINE__.'] - Current wfTaskCate_id not equal to 7.');
                        } else
                            $where_wfGroup_id = $assignedGroup;     
                        if (Class_db::getInstance()->db_count('wf_task_assign', array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To'], 'wfTaskAssign_from'=>$wfTask_id))==0) {
                            Class_db::getInstance()->db_insert('wf_task_assign', array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTaskAssign_from'=>$wfTask_id, 'wfTaskType_id'=>$task_assign_where['wfTaskType_To'], 'wfGroup_id'=>$where_wfGroup_id, 'user_id'=>$where_user_id));
                        } else {
                            Class_db::getInstance()->db_update('wf_task_assign', array('wfGroup_id'=>$where_wfGroup_id, 'user_id'=>$where_user_id), array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTaskAssign_from'=>$wfTask_id, 'wfTaskType_id'=>$task_assign_where['wfTaskType_To']));
                        }
                        if ($task_assign_where['wfTaskType_To'] == $next_taskType_id) {
                            $claimed_user = $where_user_id;
                            $next_wfGroup_id = $where_wfGroup_id;
                        }
                    }
                }                
                if ($next_taskType['wfTaskType_isAssigned'] == 'Y') {
                    if ($next_wfGroup_id == '') {
                        $columns = array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTaskType_id'=>$next_taskType_id);
                        $task_assign = Class_db::getInstance()->db_select_single('wf_task_assign', $columns, 'wfTaskAssign_id desc', 1);
                        $claimed_user = $task_assign['user_id'];
                        $next_wfGroup_id = $task_assign['wfGroup_id'];
                    }
                } else {
                    $claimed_user = '';
                    if ($next_wfGroup_id == '') {
                        $next_wfGroup_id = $next_taskType['wfGroup_id'] != '' ? $next_taskType['wfGroup_id'] : $assignedGroup;
                    }
                }
                $setArr = array('wfTask_partition'=>'2', 'wfTask_status'=>$status, 'wfTask_timeSubmitted'=>'Now()', 'wfTask_remark'=>$remarks);
                Class_db::getInstance()->db_update('wf_task', $setArr, array('wfTask_id'=>$wfTask_id));
                $columns = array('wfTrans_id'=>$current_task['wfTrans_id'], 'wfTask_createdBy'=>$user_id, 'wfTask_createdByGr'=>$current_task['wfGroup_id'], 'wfTask_refName'=>$wfTask_refName, 'wfTask_refValue'=>$wfTask_refValue,
                    'wfGroup_id'=>$next_wfGroup_id, 'wfTaskType_id'=>$next_taskType_id, 'wfTask_dateExpired'=>'|DATE_ADD(CURDATE(),INTERVAL '.$next_taskType['wfTaskType_duration'].' DAY)', 'wfTask_statusPrevious'=>$status);
                if ($claimed_user != '')    $columns['wfTask_claimedBy'] = $claimed_user;
                if ($this->submission_flag != '')   $columns['wfTask_status'] = $this->submission_flag;
                $next_task_id = Class_db::getInstance()->db_insert('wf_task', $columns);
                $this->process_after_submit($wfTask_id, $current_task['wfTrans_id'], $wfTaskType_id, $status, $current_taskType['wfFlow_id'], $next_taskType, $next_task_id);
                return $next_task_id;
            }
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    private function process_after_submit ($wfTask_id, $wfTrans_id, $wfTaskType_id, $status, $wfFlow_id, $next_taskType, $next_task_id) {
        try {
            $this->log_debug(__FUNCTION__, __LINE__, "entering process_after_submit()");
            if (in_array($wfFlow_id, array('1', '2', '3', '4', '5'))) {
                if ($status == '12') {   // return
                    if (in_array($wfTaskType_id, array('4', '14', '24', '34', '44', '5', '15', '25', '35', '45'))) {                                 
                        $previous_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTrans_id'=>$wfTrans_id, 'wfTaskType_id'=>$next_taskType['wfTaskType_id'], 'wfTask_id'=>'<'.$next_task_id), $orderby='wfTask_id DESC');
                        $arr_checklist_task = Class_db::getInstance()->db_select('t_checklist_task', array('wfTask_id'=>$previous_task['wfTask_id']));
                        foreach ($arr_checklist_task as $checklist_task) {   
                            Class_db::getInstance()->db_insert('t_checklist_task', array('checklist_id'=>$checklist_task['checklist_id'], 'wfTask_id'=>$next_task_id));
                        }
                    } else if ($wfFlow_id == '5' && $wfTaskType_id == '41') {
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        $arr_pemsInput = Class_db::getInstance()->db_select('t_pems_input', array('indAll_id'=>$indAll_id, 'pemsInput_status'=>'1'));
                        foreach ($arr_pemsInput as $pemsInput) {   
                            $pemsInput_id = Class_db::getInstance()->db_insert('t_pems_input', array('indAll_id'=>$indAll_id, 'pemsInput_name'=>$pemsInput['pemsInput_name'], 'pemsInput_desc'=>$pemsInput['pemsInput_desc']));
                            $arr_pemsReading = Class_db::getInstance()->db_select('t_pems_reading', array('pemsInput_id'=>$pemsInput['pemsInput_id'], 'pemsReading_category'=>'1'));
                            foreach ($arr_pemsReading as $pemsReading) {   
                                Class_db::getInstance()->db_insert('t_pems_reading', array('pemsInput_id'=>$pemsInput_id, 'pemsReading_category'=>'1', 'pemsReading_type'=>$pemsReading['pemsReading_type'], 'pemsReading_min'=>$pemsReading['pemsReading_min'],
                                    'pemsReading_max'=>$pemsReading['pemsReading_max'], 'pemsReading_weight'=>$pemsReading['pemsReading_weight'], 'wfTask_id'=>$next_task_id));
                            }
                            Class_db::getInstance()->db_update('t_pems_input', array('pemsInput_status'=>'3'), array('pemsInput_id'=>$pemsInput['pemsInput_id']));
                        }
                    } 
                } else if ($status == '46') { 
                    $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                    $qa_previous = Class_db::getInstance()->db_select_single('vw_qa_task', array('wfTrans_id'=>$wfTrans_id, 'wfTask_id'=>'<='.$wfTask_id), 'qa_id DESC', 1);
                    $this->create_qa($qa_previous['qa_type'], $next_task_id, $indAll_id, '47');
                    Class_db::getInstance()->db_update('t_qa', array('qa_status'=>'23'), array('qa_id'=>$qa_previous['qa_id']));
                } else if ($status == '15' || $status == '13') {   // assign
                    if (in_array($wfTaskType_id, array('2', '12', '22', '32', '42', '1', '11', '21', '31', '41'))) {
                        $arr_checklist = Class_db::getInstance()->db_select('t_checklist', array('wfFlow_id'=>$wfFlow_id, 'checklist_status'=>'1'), 'checklist_id', NULL, 1);
                        foreach ($arr_checklist as $checklist) {
                            Class_db::getInstance()->db_insert('t_checklist_task', array('wfTask_id'=>$next_task_id, 'checklist_id'=>$checklist['checklist_id']));
                        }
                    }
                } else if ($status == '27' && in_array($wfFlow_id, array('4', '5'))) {
                    $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                    $qa_type = $wfFlow_id == '4' ? '2' : '1';
                    $this->create_qa($wfFlow_id=='4'?'1':'2', $next_task_id, $indAll_id);
                } else if ($status == '17' && in_array($wfFlow_id, array('4', '5'))) {   
                    if (in_array($wfTaskType_id, array('38', '48'))) { // verify Initial RATA
                        $indAll_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id, 'wfTask_refName'=>'indAll_id'), 'wfTask_refValue', NULL, 1);
                        $industrial_id = Class_db::getInstance()->db_select_col('t_industrial_all', array('indAll_id'=>$indAll_id), 'industrial_id', NULL, 1);
                        $premise_id = Class_db::getInstance()->db_select_col('t_industrial', array('industrial_id'=>$industrial_id), 'industrial_premise_id', NULL, 1);
                        Class_db::getInstance()->db_create_table('CREATE TABLE `z'.substr(date('Y'),2).'_'.$premise_id.'` (
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
                            UNIQUE KEY `stack_id_2` (`stack_id`,`data_timestamp`) USING BTREE,
                            KEY `stack_id` (`stack_id`) USING BTREE,
                            KEY `data_timestamp` (`data_timestamp`) USING BTREE,
                            KEY `data_timeCreated` (`data_timeCreated`) USING BTREE
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT');
                    }
                }
            } 
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
        
    public function task_validate ($user_id, $wfTask_id, $submit_type) {
        try {
            $error = 1;
            if ($user_id == '' || $wfTask_id == '' || $submit_type == '')
                throw new Exception('(ErrCode:1307) ['.__LINE__.'] - Parameter empty.');
            $wf_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$wfTask_id), NULL, 1);
            if (in_array($wf_task['wfTaskType_id'], array('71', '72'))) {
                Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>$user_id, 'wfTask_timeClaimed'=>'Now()'), array('wfTask_id'=>$wfTask_id));
                $error = 0;
            } else if (empty($wf_task['wfTask_timeClaimed']) && ($submit_type == 'submit' || $submit_type == 'batch_lulus')) {
                $isClaim = Class_db::getInstance()->db_select_col('wf_task_type', array('wfTaskType_id'=>$wf_task['wfTaskType_id']), 'wfTaskType_isClaim', NULL, 1);
                if ($isClaim == 'N' || $submit_type == 'batch_lulus') {
                    Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>$user_id, 'wfTask_timeClaimed'=>'Now()'), array('wfTask_id'=>$wfTask_id));
                    $error = 0;                        
                }   
            } else {
                $taskUser_exist = Class_db::getInstance()->db_count('wf_task_user', array('user_id'=>$user_id, 'wfGroup_id'=>$wf_task['wfGroup_id'], 'wfTaskType_id'=>$wf_task['wfTaskType_id']));
                if ($submit_type == 'claim') {
                    if ($taskUser_exist > 0 && $wf_task['wfTask_claimedBy'] == '' && $wf_task['wfTask_partition'] == '1') 
                        $error = 0;
                } else if ($submit_type == 'unclaim') {
                    if ($taskUser_exist > 0 && $wf_task['wfTask_claimedBy'] == $user_id && $wf_task['wfTask_partition'] == '1') 
                        $error = 0;
                } else if ($submit_type == 'submit' || $submit_type == 'batch_lulus') {
                    if ($taskUser_exist > 0 && $wf_task['wfTask_claimedBy'] == $user_id && $wf_task['wfTask_partition'] == '1') 
                        $error = 0;
                }
            }
            return $error;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email () {
        try {
            mail($to, $subject, $message);
        } 
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function insert_task_user ($uType_id, $user_id, $wfGroup_id='') {
        try {
            if ($wfGroup_id == '')
                throw new Exception('(ErrCode:1321) ['.__LINE__.'] - Parameter wfGroup_id empty.');
            $userType_id = Class_db::getInstance()->db_insert('user_type', array('user_id'=>$user_id, 'uType_id'=>$uType_id));
            $userGroup_id = Class_db::getInstance()->db_insert('wf_group_user', array('user_id'=>$user_id, 'wfGroup_id'=>$wfGroup_id));
            $arr_wf_taskType = Class_db::getInstance()->db_select('wf_task_type', array('uType_id'=>$uType_id));
            foreach ($arr_wf_taskType as $wf_taskType) {
                Class_db::getInstance()->db_insert('wf_task_user', array('user_id'=>$user_id, 'wfGroup_id'=>$wfGroup_id, 'wfTaskType_id'=>$wf_taskType['wfTaskType_id']));
            }
            return '1';
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function delete_task_user ($uType_id, $user_id, $wfGroup_id='') {
        try {
            if ($wfGroup_id == '')
                throw new Exception('(ErrCode:1321) ['.__LINE__.'] - Parameter wfGroup_id empty.');
            Class_db::getInstance()->db_delete('wf_group_user', array('user_id'=>$user_id, 'wfGroup_id'=>$wfGroup_id));
            $arr_wf_taskType = Class_db::getInstance()->db_select('wf_task_type', array('uType_id'=>$uType_id));
            foreach ($arr_wf_taskType as $wf_taskType) {
                Class_db::getInstance()->db_delete('wf_task_user', array('user_id'=>$user_id, 'wfGroup_id'=>$wfGroup_id, 'wfTaskType_id'=>$wf_taskType['wfTaskType_id']));
                // select wf_task, update then insert
                //$wf_task = Class_db::getInstance()->db_select('wf_task', array('wfTask_claimedBy'=>$user_id, 'wfTask_partition'=>'1', 'wfTaskType_id'=>$wf_taskType['wfTaskType_id']));
                Class_db::getInstance()->db_update('wf_task', array('wfTask_claimedBy'=>'NULL', 'wfTask_timeClaimed'=>'NULL'), array('wfTask_claimedBy'=>$user_id, 'wfTask_partition'=>'1', 'wfTaskType_id'=>$wf_taskType['wfTaskType_id']));
            }
            return '1';
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function convert_time_mysql ($dates, $times='') {
        try {
            if ($dates == '')
                return '';
            else if ($times == '')
                return substr($dates, 6, 4).'-'.substr($dates, 3, 2).'-'.substr($dates, 0, 2);
            $j = substr($times, 6, 2) == 'PM' ? 12 : 0;
            $times = strval(intval(substr($times, 0, 2))+$j).substr($times, 2, 3);
            return substr($dates, 6, 4).'-'.substr($dates, 3, 2).'-'.substr($dates, 0, 2).' '.$times;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    
    public function save_audit($auditAction_id='0', $audit_transNo='') {
        try {
            $place = '';
            $ipaddress = '';
            $this->log_debug(__FUNCTION__, __LINE__, 'Audit Trail = '.$auditAction_id);
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
            //if (!in_array($ipaddress, array('', 'UNKNOWN', '::1'), true)) {
            //    $details = json_decode(file_get_contents("http://ipinfo.io/$ipaddress/json"));
            //    $place = $details->city;				
            //}
            return Class_db::getInstance()->db_insert('audit', array('user_id'=>(isset($_SESSION['user_id'])?$_SESSION['user_id']:''), 'auditAction_id'=>$auditAction_id, 'audit_ip'=>$ipaddress, 'audit_place'=>$place, 'audit_transNo'=>$audit_transNo));
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function create_qa($qa_type='', $wfTask_id='', $indAll_id='', $qa_status='2', $qa_quarter='') {
        try {
            if ($qa_type == '')
                throw new Exception('(ErrCode:1315) ['.__LINE__.'] - Parameter qa_type empty.');
            else if ($indAll_id == '')
                throw new Exception('(ErrCode:1316) ['.__LINE__.'] - Parameter indAll_id empty.');
            $qa_dateExpected = '';
            $industrial_all = Class_db::getInstance()->db_select_single('t_industrial_all', array('indAll_id'=>$indAll_id), NULL, 1);
            if ($industrial_all['indAll_dateRataSet'] == '')
                throw new Exception('(ErrCode:1318) ['.__LINE__.'] - Value indAll_dateRataSet empty.');
            if ($qa_type == '1' || $qa_type == '2') {
                $qa_dateExpected = $industrial_all['indAll_dateRataSet'];
                $qa_quarter = '';
            } else {
                $qa_dateExpected = '|DATE_ADD(CURDATE(),INTERVAL '.(intval($qa_quarter)*3).' MONTH)';
                if (intval($qa_quarter) > 4)
                    $qa_quarter = strval(intval($qa_quarter) - 4);
            }
            $qa_id = Class_db::getInstance()->db_insert('t_qa', array('qa_type'=>$qa_type, 'wfTask_id'=>$wfTask_id, 'indAll_id'=>$indAll_id, 'qa_dateExpected'=>$qa_dateExpected, 'qa_quarter'=>$qa_quarter, 'qa_status'=>$qa_status));
            $arr_parameters = Class_db::getInstance()->db_select('dt_pub_param', array('indAll_id'=>$indAll_id, 'inputParam_id'=>'N(1,8)'));
            foreach ($arr_parameters as $parameters) {     
                if ($qa_type == '1' || $qa_type == '3' || $qa_type == '4') {  // Initial RATA & RATA & RAA CEMS                    
                    Class_db::getInstance()->db_insert('t_qa_ra', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id'], 'qaRa_applStandard'=>'5', 'qaRa_loadType'=>'1'));
                    Class_db::getInstance()->db_insert('t_qa_drift', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id']));
                    Class_db::getInstance()->db_insert('t_qa_responseTime', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id']));
                } else if ($qa_type == '2' || $qa_type == '5') {   // Initial RATA & RATA PEMS
                    Class_db::getInstance()->db_insert('t_qa_ra', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id'], 'qaRa_loadType'=>'1'));
                    Class_db::getInstance()->db_insert('t_qa_ra', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id'], 'qaRa_loadType'=>'2'));
                    Class_db::getInstance()->db_insert('t_qa_ra', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id'], 'qaRa_loadType'=>'3'));
                    Class_db::getInstance()->db_insert('t_qa_ftest', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id']));
                } else if ($qa_type == '6') {   // RAA PEMS
                    Class_db::getInstance()->db_insert('t_qa_ra', array('qa_id'=>$qa_id, 'inputParam_id'=>$parameters['inputParam_id'], 'qaRa_loadType'=>'1'));
                }
            }      
            return $qa_id;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    private function calculate_qa($qa_type='', $qa_id='') {
        try {
            if ($qa_type == '')
                throw new Exception('(ErrCode:1315) ['.__LINE__.'] - Parameter qa_type empty.');
            else if ($qa_id == '')
                throw new Exception('(ErrCode:1317) ['.__LINE__.'] - Parameter qa_id empty.');
            if ($qa_type == '1') {           
                $arr_qa_ra = Class_db::getInstance()->db_select('t_qa_ra', array('qa_id'=>$qa_id));
                foreach ($arr_qa_ra as $qa_ra) {     
                    // set all pass, confirm with tini
                    $result = '6';
                    $result = '36';
                    Class_db::getInstance()->db_update('t_qa_ra', array('qaRa_status'=>$result), array('qaRa_id'=>$qa_ra['qaRa_id']));
                }
                $arr_qa_drift = Class_db::getInstance()->db_select('t_qa_drift', array('qa_id'=>$qa_id));
                foreach ($arr_qa_drift as $qa_drift) {     
                    $result = '6';
                    $pass_value = 0;
                    switch ($qa_drift['inputParam_id']) {
                        case '2':
                        case '3':
                            $pass_value = 2.5;
                            break;
                        case '9':
                            $pass_value = 0.5;
                            break;
                        default:
                            $pass_value = 5;
                    }
                    $arr_values = array();
                    for ($i=1;$i<=7;$i++) {
                        array_push($arr_values, floatval($qa_drift['qaDrift_result_'.strval($i)]));
                    }
                    if (((max($arr_values)-min($arr_values))/(array_sum($arr_values)/count($arr_values))*100) < $pass_value)
                        $result = '36';
                    Class_db::getInstance()->db_update('t_qa_drift', array('qaDrift_result'=>$result), array('qaDrift_id'=>$qa_drift['qaDrift_id']));
                }
                $arr_qa_responseTime = Class_db::getInstance()->db_select('t_qa_responseTime', array('qa_id'=>$qa_id));
                foreach ($arr_qa_responseTime as $qa_responseTime) {     
                    $result = '6';
                    if (floatval($qa_responseTime['qaRespTime_value']) < 200)
                        $result = '36';
                    Class_db::getInstance()->db_update('t_qa_responseTime', array('qaRespTime_result'=>$result), array('qaRespTime_id'=>$qa_responseTime['qaRespTime_id']));
                }
            } else if ($qa_type == '2') {
                $arr_qa_ra = Class_db::getInstance()->db_select('t_qa_ra', array('qa_id'=>$qa_id));
                foreach ($arr_qa_ra as $qa_ra) {     
                    // set all pass, confirm with tini
                    $result = '6';
                    $result = '36';
                    Class_db::getInstance()->db_update('t_qa_ra', array('qaRa_status'=>$result), array('qaRa_id'=>$qa_ra['qaRa_id']));
                }
                $arr_qa_ftest = Class_db::getInstance()->db_select('t_qa_ftest', array('qa_id'=>$qa_id));
                foreach($arr_qa_ftest as $qa_ftest) {
                    $result = '36';
                    if (floatval($qa_ftest['qaFtest_low']) >= 3.438 || floatval($qa_ftest['qaFtest_mid']) >= 3.438 || floatval($qa_ftest['qaFtest_high']) >= 3.438)
                        $result = '6';
                    $resultCorr = '6';
                    if (floatval($qa_ftest['qaFtest_corrValue']) < 0.8)
                        $resultCorr = '36';
                    Class_db::getInstance()->db_update('t_qa_ftest', array('qaFtest_result'=>$result, 'qaFtest_corrResult'=>$resultCorr), array('qaFtest_id'=>$qa_ftest['qaFtest_id']));
                }
            }
            
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }    
    }
    
    private function save_qa_schedule($indAll_id='') {
        try {
            if ($indAll_id == '')
                throw new Exception('(ErrCode:1316) ['.__LINE__.'] - Parameter indAll_id empty.');
            $consAll_id = Class_db::getInstance()->db_select_col('t_industrial_all', array('indAll_id'=>$indAll_id), 'consAll_id', NULL, 1);
            $ind_user = Class_db::getInstance()->db_select_single('vw_industrial_user', array('indAll_id'=>$indAll_id), NULL, 1);
            for ($quarter=1;$quarter<=3;$quarter++) {
                if ($ind_user['indAll_type'] == '1')
                    $qa_type = '4';
                else if ($ind_user['indAll_type'] == '2')
                    $qa_type = '6';
                $wfTask_id = $this->task_create($ind_user['user_id'], '10', $ind_user['wfGroup_id'], '91');
                $qa_id = $this->create_qa($qa_type, $wfTask_id, $indAll_id, '50', strval($quarter));
                Class_db::getInstance()->db_update('wf_task', array('wfTask_status'=>'50', 'wfTask_refName'=>'qa_id', 'wfTask_refValue'=>$qa_id), array('wfTask_id'=>$wfTask_id));
                $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
                Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'50'), array('wfTrans_id'=>$wfTrans_id));
                $wfTask_id = $this->task_create($ind_user['user_id'], '10', $ind_user['wfGroup_id'], '91');
                $qa_id = $this->create_qa($qa_type, $wfTask_id, $indAll_id, '50', strval($quarter+4));
                Class_db::getInstance()->db_update('wf_task', array('wfTask_status'=>'50', 'wfTask_refName'=>'qa_id', 'wfTask_refValue'=>$qa_id), array('wfTask_id'=>$wfTask_id));
                $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
                Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'50'), array('wfTrans_id'=>$wfTrans_id));
            }
            if ($ind_user['indAll_type'] == '1')
                $qa_type = '3';
            else if ($ind_user['indAll_type'] == '2')
                $qa_type = '5';
            $wfTask_id = $this->task_create($ind_user['user_id'], '10', $ind_user['wfGroup_id'], '91');
            $qa_id = $this->create_qa($qa_type, $wfTask_id, $indAll_id, '50', '4');
            Class_db::getInstance()->db_update('wf_task', array('wfTask_status'=>'50', 'wfTask_refName'=>'qa_id', 'wfTask_refValue'=>$qa_id), array('wfTask_id'=>$wfTask_id));
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'50'), array('wfTrans_id'=>$wfTrans_id));
            $wfTask_id = $this->task_create($ind_user['user_id'], '10', $ind_user['wfGroup_id'], '91');
            $qa_id = $this->create_qa($qa_type, $wfTask_id, $indAll_id, '50', '8');
            Class_db::getInstance()->db_update('wf_task', array('wfTask_status'=>'50', 'wfTask_refName'=>'qa_id', 'wfTask_refValue'=>$qa_id), array('wfTask_id'=>$wfTask_id));
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'50'), array('wfTrans_id'=>$wfTrans_id));
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1301', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        } 
    }
}

?>
