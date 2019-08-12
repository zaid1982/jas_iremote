<?php

//require_once 'f_task.php';

class Class_email {     // 17++
     
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
            
    private function insert_emailSend ($emailType_id, $arr_param=array(), $emailSend_to='', $emailSend_email='', $timeSet='') {
        try {            
            $columns = array('emailType_id'=>$emailType_id, 'emailSend_to'=>$emailSend_to, 'emailSend_timeSet'=>$timeSet, 'emailSend_email'=>$emailSend_email);
            $emailSend_id = Class_db::getInstance()->db_insert('email_send', $columns);
            if (is_array($arr_param) && !empty($arr_param)) {
                foreach ($arr_param as $key => $value) {
                    $columns = array('emailSend_id'=>$emailSend_id, 'emailParam_no'=>$key, 'emailParam_text'=>$value);
                    Class_db::getInstance()->db_insert('email_param', $columns);
                }
            }
            return 1;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email() {
        try {            
            $result = 0;
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $email_header = "<html><body>";
            $email_footer = "<i>Note: This is an automail from iRemote System. Please do not reply to the email.</i></html></body>";
            $arr_email_send = Class_db::getInstance()->db_select('vw_email_send', array(), NULL, '10');
            foreach ($arr_email_send as $email_send) {
                $emailSend_id = $email_send['emailSend_id'];
                if ($email_send['emailSend_email'] == '' || $email_send['emailType_title'] == '') {
                    Class_db::getInstance()->db_update('email_send', array('emailSend_status'=>'102'), array('emailSend_id'=>$emailSend_id));
                    continue;
                }
                $email_text = $email_send['emailType_text'];
                foreach ($email_send as $key => $value) {
                    if (strpos($email_text,"[".$key."]") !== false)
                        $email_text = str_replace ("[".$key."]", $value, $email_text);
                }
                $arr_email_param = Class_db::getInstance()->db_select('email_param', array('emailSend_id'=>$emailSend_id));
                foreach ($arr_email_param as $email_param) {
                    if (strpos($email_text, "[param".$email_param['emailParam_no']."]") !== false)
                        $email_text = str_replace ("[param".$email_param['emailParam_no']."]", $email_param['emailParam_text'], $email_text);
                    if (strpos($email_send['emailType_title'], "[param".$email_param['emailParam_no']."]") !== false)
                        $email_send['emailType_title'] = str_replace ("[param".$email_param['emailParam_no']."]", $email_param['emailParam_text'], $email_send['emailType_title']);
                }
                $message = $email_header.$email_text.$email_footer;                            
//                if ($email_send['emailType_id'] == '8') {
//                    $arr_wf_task = Class_db::getInstance()->db_select('wf_task', array('wfTrans_id'=>$email_send['emailSend_email'], 'wfTaskType_id'=>'62'));
//                    foreach ($arr_wf_task as $wf_task) {
//                        $wfGroup_name = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$wf_task['wfGroup_id']), 'wfGroup_name');
//                        $message = str_replace('[param5]', $wfGroup_name, $message);
//                        $arr_wf_task_user = Class_db::getInstance()->db_select('wf_task_user', array('wfTaskType_id'=>'62', 'wfGroup_id'=>$wf_task['wfGroup_id']));
//                        foreach ($arr_wf_task_user as $wf_task_user) {
//                            $profile_id = Class_db::getInstance()->db_select_col('user', array('user_id'=>$wf_task_user['user_id']), 'profile_id'); if ($profile_id == '')  continue;     
//                            $email_address = Class_db::getInstance()->db_select_col('profile', array('profile_id'=>$profile_id), 'profile_email');  if ($email_address == '')  continue;    
//                            mail($email_address, $email_send['emailType_title'], $message, $headers);   
//                            echo ($email_address.' - '.$email_send['emailType_title'].'</br>'.$message.'</br>'); 
//                        }
//                    }
//                } else {
                    mail($email_send['emailSend_email'], 'iRemote System - '.$email_send['emailType_title'], $message, $headers);
                    //echo ($email_send['emailSend_email'].' - '.$email_send['emailType_title'].'</br>'.$message.'</br>'); 
//                }
                Class_db::getInstance()->db_update('email_send', array('emailSend_status'=>'101', 'emailSend_timeSent'=>'Now()'), array('emailSend_id'=>$emailSend_id));
                
            }
            return $result;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_activation($pic, $name, $user_name, $user_password, $activationKey, $user_desc) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - Account Activation.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>In order to prevent unauthorized sign-up, please click link to activate your account.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my/login.php?activationCode=".$activationKey."\">http://iremote.doe.gov.my/login.php?activationCode=".$activationKey."</a></p>"; 
            $message .= "<p>If you experience problems with the provided link, simply copy and paste the link below into the address field within your browser.</p>";
            $message .= "<p>Your ".$user_desc." is <strong>".$user_name."</strong></p>";
            $message .= "<p>Your Password is <strong>".$user_password."</strong></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_reset_password($pic, $name, $user_name, $user_password) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - Notification of Reset Password.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>Your password has successfully reset. Please log in to the system and make sure do not forget to update with your new password.</p>";
            $message .= "<p>Your User Id is <strong>".$user_name."</strong><br>";
            $message .= "Your Temporary Password is <strong>".$user_password."</strong></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_user_creation($pic, $name, $user_name, $user_password, $roles) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - Appointment as System User.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>You have been appointed as system user.</p>";            
            $message .= "<p>Kindly login to iRemote System - <a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a> as stated below.</p>";
            $message .= "<p>User Id : <strong>".$user_name."</strong><br>";
            $message .= "Role : <strong>".$roles."</strong></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
        
    public function send_email_assign($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - New Application of ".$app_type." to be assigned.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Penyelia</i>,</p>";
            $message .= "<p>Please be informed that you have a new ".$app_type." application to be assigned from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to assign the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_process($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application to be processed.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Proses</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." application to be processed from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to process the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_verify($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application to be verified.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Penyelia</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." application to be verified from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to verify the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_approval($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application to be approved.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Penyelia</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." application to be approved from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to approve the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_revise($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application returned";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Proses</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." returned application to be processed from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to process the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_reject_consultant($pic, $name, $app_type, $trans_no, $company_name, $reg_no, $remark) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application rejected.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are sorry that the ".$app_type." for application no. ".$trans_no." has been rejected.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Company Name : <strong>".$company_name."</strong><br>";
            $message .= "Co. Registration No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Rejected</strong><br>";
            $message .= "Remark : <strong>".$remark."</strong></p>";
            $message .= "<p>Kindly login to iRemote System to re-apply the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_reject($pic, $name, $app_type, $trans_no, $company_name, $reg_no, $remark) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application rejected.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are sorry that the ".$app_type." for application no. ".$trans_no." has been rejected.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Premise Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Rejected</strong><br>";
            $message .= "Remark : <strong>".$remark."</strong></p>";
            $message .= "<p>Kindly login to iRemote System to re-apply the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_approve_consultant($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application approved.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are glad to inform that the ".$app_type." for application no. ".$trans_no." has been approved.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Company Name : <strong>".$company_name."</strong><br>";
            $message .= "Co. Registration No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Approved</strong><br>";
            $message .= "<p>Kindly login to iRemote System to review the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
			//$message .= "<p>To download agent execution file. Please click <a href=\"http://iremote.doe.gov.my/agent/JabatanAlamSekitar.exe\">here.</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_approve($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application approved.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are glad to inform that the ".$app_type." for application no. ".$trans_no." has been approved.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Premise Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Approved</strong><br>";
            $message .= "<p>Kindly login to iRemote System to review the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
			$message .= "<p>To download the agent execution file, please click <a href=\"http://iremote.doe.gov.my/agent\">here</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_return_consultant($pic, $name, $app_type, $trans_no, $company_name, $reg_no, $remark) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application returned.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are sorry that the ".$app_type." for application no. ".$trans_no." has been returned for revision.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Company Name : <strong>".$company_name."</strong><br>";
            $message .= "Co. Registration No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Return</strong><br>";
            $message .= "Remark : <strong>".$remark."</strong></p>";
            $message .= "<p>Kindly login to iRemote System to revise the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_return($pic, $name, $app_type, $trans_no, $company_name, $reg_no, $remark) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application returned.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are sorry that the ".$app_type." for application no. ".$trans_no." has been returned for revision.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Premise Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Return</strong><br>";
            $message .= "Remark : <strong>".$remark."</strong></p>";
            $message .= "<p>Kindly login to iRemote System to revise the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_initialRATA($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application Initial RATA date.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>The initial RATA date for the ".$app_type.", application no. ".$trans_no." has been set.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Premise Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Initial RATA</strong><br>";
            $message .= "<p>Please perform the initial RATA and submit the report through system.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_failReport_verify($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application to be processed.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Penilaian</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." to be verified from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to verify the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_failReport_return($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." returned.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>Please be informed that the ".$app_type." for Case No. ".$trans_no." has been returned for revision.</p>";            
            $message .= "<p>Case No. : <strong>".$trans_no."</strong><br>";
            $message .= "Company Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Returned</strong><br>";
            $message .= "<p>Kindly login to iRemote System to revise the case report.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_failReport_approve($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." approved.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>We are glad to inform that the ".$app_type." for Case No. ".$trans_no." has been approved.</p>";            
            $message .= "<p>Case No. : <strong>".$trans_no."</strong><br>";
            $message .= "Company Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Approved</strong><br>";
            $message .= "<p>Kindly login to iRemote System to review the case.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_verify_initRATA($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application - Initial RATA report to be verified.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Penyelia</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." Application - Initial RATA report to be verified from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to verify the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_return_initialRATA($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application Initial RATA returned to be revised.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>The initial RATA for the ".$app_type.", application no. ".$trans_no." has been returned for your revision.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Premise Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Initial RATA (returned)</strong><br>";
            $message .= "<p>Please review and complete the report as commented by the JAS Officer in the system.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_redo_initialRATA($pic, $name, $app_type, $trans_no, $company_name, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application Initial RATA fail to be redo.";
            $message = "<html><body>";
            $message .= "<p>Dear ".$name.",</p>";
            $message .= "<p>Unfortunately the result initial RATA for the ".$app_type.", application no. ".$trans_no." is fail and need to be redone.</p>";            
            $message .= "<p>Application No. : <strong>".$trans_no."</strong><br>";
            $message .= "Premise Name : <strong>".$company_name."</strong><br>";
            $message .= "JAS File No. : <strong>".$reg_no."</strong><br>";
            $message .= "Status : <strong>Initial RATA (fail, need to redo)</strong><br>";
            $message .= "<p>Please redone the Initial RATA as commented by the JAS Officer in the system.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_certRenewal_verify($pic, $company_name, $app_type) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - ".$app_type." Application to be processed.";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Pegawai Pemproses</i>,</p>";
            $message .= "<p>Please be informed that you have a new incoming ".$app_type." to be verified from <strong>".$company_name."</strong>.</p>";            
            $message .= "<p>Kindly login to iRemote System to verify the application.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_qnf_delegate($pic, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - New Incoming Inquiry to be delegated (Case No. = ".$reg_no.")";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Sir</i>,</p>";
            $message .= "<p>Please be informed that you have incoming inquiry (Case No. = ".$reg_no.") to be delegated.</p>";            
            $message .= "<p>Kindly login to iRemote System to delegate the inquiry.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_qnf_reply($pic, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - Replied Inquiry (Case No. = ".$reg_no.")";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Sir</i>,</p>";
            $message .= "<p>Please be informed that you have received replied inquiry (Case No. = ".$reg_no.").</p>";            
            $message .= "<p>Kindly login to iRemote System to continue.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_qnf_return($pic, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - Returned Inquiry (Case No. = ".$reg_no.")";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Sir</i>,</p>";
            $message .= "<p>Please be informed that you have received returned inquiry (Case No. = ".$reg_no.").</p>";            
            $message .= "<p>Kindly login to iRemote System to continue.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_qnf_resolve($pic, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - Resolved Inquiry (Case No. = ".$reg_no.")";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Sir</i>,</p>";
            $message .= "<p>Please be informed that you inquiry (Case No. = ".$reg_no.") has been resolved.</p>";            
            $message .= "<p>Kindly login to iRemote System to read the details.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function send_email_qnf_feedback($pic, $reg_no) {
        try {     
            $headers = "From: iremote@doe.gov.my\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; 
            $to = $pic; 
            $subject = "JAS iRemote System - New Delegated Inquiry (Case No. = ".$reg_no.")";
            $message = "<html><body>";
            $message .= "<p>Dear <i>Sir</i>,</p>";
            $message .= "<p>Please be informed that you have new delegated inquiry (Case No. = ".$reg_no.") to be resolved.</p>";            
            $message .= "<p>Kindly login to iRemote System to resolved the inquiry.</p>";
            $message .= "<p><a href=\"http://iremote.doe.gov.my\">http://iremote.doe.gov.my</a></p>";
            $message .= "<br><br><br>";
            $message .= "<i>Note: This is and automail from iRemote System. Please do not reply to the email.</i>";
            $message .= "</html></body>";
            $this->log_debug(__FUNCTION__, __LINE__, $pic.' - '.$message);
            mail($to, $subject, $message, $headers);
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1501', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
}

?>
