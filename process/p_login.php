<?php
session_start(); 
require_once '../library/db.php';
require_once '../library/db2.php';
//$google_page = file_get_contents('http://xtivkids.com/spdp/library/db.php');
//echo $google_page;
require_once '../function/f_user.php';
require_once '../function/f_task.php';
require_once '../function/f_email.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form

try {     
    /* Validate the form on the server side */
    if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) ['.__LINE__.'] - Post[funct] empty.');
    } else {            
        $fn_user = new Class_user();
        $fn_task = new Class_task();
        $fn_email = new Class_email();
        Class_db::getInstance()->db_connect();
        Class_db::getInstance()->db_beginTransaction();
        $result = '';
        log_debug(__LINE__, 'test', $log_dir);
        if ($_POST['funct'] == 'login') {     /* Login */            
            $user_basic = Class_db::getInstance()->db_select_single('user', array('user_name'=>'(\''.$_POST['txt_email'].'\')'), 'user_status');
            $user_type = (empty($_POST['txt_user_type'])?'2':'1');
            if (empty($user_basic)) {
                throw new Exception('(ErrCode:5101) ['.__LINE__.'] - Login attempt fail', 30);
            } else if ($user_basic['user_password'] == $_POST['txt_password'] && $user_type == '2' && $user_basic['user_type'] == '2') {                
                if ($user_basic['user_status'] != '1') 
                    throw new Exception('(ErrCode:5100) ['.__LINE__.'] - User not active', 36);				
                $_SESSION["user_id"] = $user_basic['user_id'];  
                $_SESSION["login_name"] = $user_basic['profile_id'] == '' ? '' : Class_db::getInstance()->db_select_col('profile', array('profile_id'=>$user_basic['profile_id']), 'profile_name');
                $_SESSION["menu_list"] = $fn_user->get_menu_list($_SESSION["user_id"]);   
                $_SESSION["user_type"] = $user_basic['user_type'];
                $result = $fn_user->default_menuId;
                Class_db::getInstance()->db_update('user', array('user_failAttempt'=>'0'), array('user_name'=>'(\''.$_POST['txt_email'].'\')'));
                $fn_task->save_audit('1');
            } else if ($user_type == '1' && $user_basic['user_type'] == '1') {      
                $result_ldap = $fn_user->check_ldap($_POST['txt_email'], $_POST['txt_password']);
                log_debug(__LINE__, 'Result LDAP = '.$result_ldap, $log_dir);
                if ($result_ldap == 0) {
                    Class_db::getInstance()->db_update('user', array('user_failAttempt'=>strval(intval($user_basic['user_failAttempt'])+1)), array('user_name'=>'(\''.$_POST['txt_email'].'\')'));
                    Class_db::getInstance()->db_commit();
                    if (intval($user_basic['user_failAttempt']) >= 3)
                        throw new Exception('(ErrCode:5102) ['.__LINE__.'] - 3rd time login attempt fail', 31);
                    else                     
                        throw new Exception('(ErrCode:5101) ['.__LINE__.'] - Login attempt fail', 32);
                }
                if ($user_basic['user_status'] != '1') 
                    throw new Exception('(ErrCode:5100) ['.__LINE__.'] - User not active', 36);
                $_SESSION["user_id"] = $user_basic['user_id'];  
                $_SESSION["login_name"] = $user_basic['profile_id'] == '' ? '' : Class_db::getInstance()->db_select_col('profile', array('profile_id'=>$user_basic['profile_id']), 'profile_name');
                $_SESSION["menu_list"] = $fn_user->get_menu_list($_SESSION["user_id"]);   
                $_SESSION["user_type"] = $user_basic['user_type'];
                $result = $fn_user->default_menuId;
                Class_db::getInstance()->db_update('user', array('user_failAttempt'=>'0'), array('user_name'=>'(\''.$_POST['txt_email'].'\')'));
            } else {    
                Class_db::getInstance()->db_update('user', array('user_failAttempt'=>strval(intval($user_basic['user_failAttempt'])+1)), array('user_name'=>'(\''.$_POST['txt_email'].'\')'));
                Class_db::getInstance()->db_commit();
                if (intval($user_basic['user_failAttempt']) >= 3)
                    throw new Exception('(ErrCode:5102) ['.__LINE__.'] - 3rd time login attempt fail', 31);
                else                     
                    throw new Exception('(ErrCode:5101) ['.__LINE__.'] - Login attempt fail', 32);
            }
        } else if ($_POST['funct'] == 'register_user'){
            if (empty($_POST['mrg_profile_name']))          throw new Exception('(ErrCode:5116) [' . __LINE__ . '] - Field Name empty.', 35);
            if (empty($_POST['mrg_profile_icNo']))          throw new Exception('(ErrCode:5117) [' . __LINE__ . '] - Field Identification No. empty.', 35);
            if (empty($_POST['mrg_profile_mobileNo']))      throw new Exception('(ErrCode:5118) [' . __LINE__ . '] - Field Mobile No. empty.', 35);
            if (empty($_POST['mrg_profile_email']))         throw new Exception('(ErrCode:5119) [' . __LINE__ . '] - Field Email Address empty.', 35);
            if (empty($_POST['mrg_designation']))           throw new Exception('(ErrCode:5128) [' . __LINE__ . '] - Field Position empty.', 35);
            if (empty($_POST['mrg_user_password']))         throw new Exception('(ErrCode:5120) [' . __LINE__ . '] - Field Confirm Password empty.', 35);
            if (empty($_POST['mrg_secQues_id']))            throw new Exception('(ErrCode:5121) [' . __LINE__ . '] - Field Security Question empty.', 35);
            if (empty($_POST['mrg_user_security_answer']))  throw new Exception('(ErrCode:5122) [' . __LINE__ . '] - Field Security Answer empty.', 35);
            if ($_POST['mrg_jenis_permohonan'] == '0' && empty($_POST['mrg_doeFile_no']))                       throw new Exception('(ErrCode:5124) [' . __LINE__ . '] - DOE File No. empty.', 35);
            if ($_POST['mrg_jenis_permohonan'] == '1' && empty($_POST['mrg_company_name']))                     throw new Exception('(ErrCode:5125) [' . __LINE__ . '] - Company Name empty.', 35);
            if ($_POST['mrg_jenis_permohonan'] == '1' && empty($_POST['mrg_company_regNo']))                    throw new Exception('(ErrCode:5126) [' . __LINE__ . '] - Company Registration No. empty.', 35);
            if ($_POST['mrg_jenis_permohonan'] == '1') {
                if (Class_db::getInstance()->db_count('user', array('user_name'=>$_POST['mrg_company_regNo'])) > 0)  throw new Exception('(ErrCode:5123) [' . __LINE__ . '] - Company Registration No. already registered.', 35);
                if (Class_db::getInstance()->db_count('vw_wfGroup_consultant', array('wfGroup_regNo'=>$_POST['mrg_company_regNo'], 'consultant_status'=>'1')) > 0)
                    throw new Exception('(ErrCode:5127) [' . __LINE__ . '] - Company Registration No. already exist.', 35);
            } else {
                if (Class_db::getInstance()->db_count('user', array('user_name'=>$_POST['mrg_doeFile_no'])) > 0)  throw new Exception('(ErrCode:5123) [' . __LINE__ . '] - DOE File No. already registered.', 35);
                if (Class_db::getInstance()->db_count('t_industrial', array('industrial_jasFileNo'=>$_POST['mrg_doeFile_no'], 'industrial_status'=>'1'))>0) 
                    throw new Exception('(ErrCode:5130) [' . __LINE__ . '] - This DOE File No. already registered in the system.', 35);                
            }
            $user_name = $_POST['mrg_jenis_permohonan'] == '1' ? $_POST['mrg_company_regNo'] : $_POST['mrg_doeFile_no'];
            $user_id = Class_db::getInstance()->db_insert('user', array('user_name'=>$user_name, 'user_password'=>$_POST['mrg_user_password'], 'secQues_id'=>$_POST['mrg_secQues_id'], 'user_security_answer'=>$_POST['mrg_user_security_answer'], 'user_type'=>'2', 'user_status'=>'0'));
            $activation_key = $fn_task->generateRandomString().$user_id;
            $profile_id = Class_db::getInstance()->db_insert('profile', array('user_id'=>$user_id, 'profile_name'=>$_POST['mrg_profile_name'], 'profile_icNo'=>$_POST['mrg_profile_icNo'], 'profile_mobileNo'=>$_POST['mrg_profile_mobileNo'], 
                'profile_email'=>$_POST['mrg_profile_email'], 'profile_createdBy'=>$user_id)); 
            Class_db::getInstance()->db_update('user', array('profile_id'=>$profile_id, 'user_activationKey'=>$activation_key), array('user_id'=>$user_id));            
            $wfGroupProfile_id = '';
            $uType_id = $_POST['mrg_jenis_permohonan'] == '1' ? '8' : '7';
            $wfGroup_regNo = $_POST['mrg_jenis_permohonan'] == '1' ? $_POST['mrg_company_regNo'] : '';
            $wfGroup_type = $_POST['mrg_jenis_permohonan'] == '1' ? 'Consultant' : 'Industry';
            $wfGroop_name = $_POST['mrg_jenis_permohonan'] == '1' ? $_POST['mrg_company_name'] : '';
            Class_db::getInstance()->db_insert('user_type', array('user_id'=>$user_id, 'uType_id'=>$uType_id));
            $wfGroup_id = Class_db::getInstance()->db_insert('wf_group', array('wfGroup_name'=>$wfGroop_name, 'wfGroup_type'=>$wfGroup_type, 'wfGroup_regNo'=>$wfGroup_regNo, 'wfGroup_createdBy'=>$user_id));
            if ($_POST['mrg_jenis_permohonan'] == '1') {
                $result = Class_db::getInstance()->db_insert('t_consultant', array('wfGroup_id'=>$wfGroup_id, 'consultant_createdBy'=>$user_id));
                $wfGroupProfile_id = Class_db::getInstance()->db_insert('wf_group_profile', array('wfGroup_id'=>$wfGroup_id, 'wfGroupProfile_createdBy'=>$user_id));
                Class_db::getInstance()->db_update('wf_group', array('wfGroupProfile_id'=>$wfGroupProfile_id), array('wfGroup_id'=>$wfGroup_id));
            } else {
                $register_result = $fn_user->register_new_industry($user_id, $wfGroup_id, $_POST['mrg_doeFile_no']);
                if ($register_result == '2')
                    throw new Exception('(ErrCode:5135) [' .__LINE__. '] - JAS File No. not exist.', 35);
                else if ($register_result == '3')
                    throw new Exception('(ErrCode:5136) [' .__LINE__. '] - Your premise currently recorded as Closed. Please update your eKAS system profile.', 35);
            }   
            Class_db::getInstance()->db_insert('wf_group_user', array('wfGroup_id'=>$wfGroup_id, 'user_id'=>$user_id, 'wfGroupUser_designation'=>$_POST['mrg_designation'], 'wfGroupUser_dateActive'=>'Curdate()'));
            $arr_wfTaskType_id = Class_db::getInstance()->db_select_colm('wf_task_type', array('uType_id'=>$uType_id), 'wfTaskType_id');
            foreach ($arr_wfTaskType_id as $wfTaskType_id) {
                Class_db::getInstance()->db_insert('wf_task_user', array('user_id'=>$user_id, 'wfTaskType_id'=>$wfTaskType_id, 'wfGroup_id'=>$wfGroup_id));
            }   
            $fn_email->send_email_activation($_POST['mrg_profile_email'], $_POST['mrg_profile_name'], $user_name, $_POST['mrg_user_password'], $activation_key, ($_POST['mrg_jenis_permohonan'] == '1'?'Company Registration No.':'JAS File No.'));
            $result = '1';
        } else if ($_POST['funct'] == 'activate_user'){
            if (empty($_POST['activation_code'])) 
               throw new Exception('(ErrCode:5110) [' . __LINE__ . '] - Parameter activation_code empty.');
            $result = Class_db::getInstance()->db_update('user', array('user_status'=>'1'), array('user_activationKey'=>$_POST['activation_code']));
        } else if ($_POST['funct'] == 'reset_password'){
            if (empty($_POST['username'])) 
                throw new Exception('(ErrCode:5111) [' . __LINE__ . '] - Please enter Username to reset your password.', 35);
            $user_id = Class_db::getInstance()->db_select_col('user', array('user_name'=>$_POST['username']), 'user_id', NULL, 1);
            Class_db::getInstance()->db_update('user', array('user_password'=>$fn_task->generateRandomString(10)), array('user_id'=>$user_id));
            $profile_email = Class_db::getInstance()->db_select_col('profile', array('user_id'=>$user_id), 'profile_email', 'profile_id DESC');
            $result = array('user_id'=>$user_id, 'profile_email'=>$profile_email);
            $fn_task->save_audit('5');
        } else if ($_POST['funct'] == 'submit_qnf_external') {
            if (empty($_POST['miq_qnf_contactNo']))         throw new Exception('(ErrCode:5106) [' . __LINE__ . '] - Field Contact No. empty.', 35);
            if (empty($_POST['miq_qnf_email']))             throw new Exception('(ErrCode:5107) [' . __LINE__ . '] - Field Email Address empty.', 35);
            if (empty($_POST['miq_qnf_name']))              throw new Exception('(ErrCode:5116) [' . __LINE__ . '] - Field Name empty.', 35);
            if (empty($_POST['miq_qnf_title']))             throw new Exception('(ErrCode:5131) [' . __LINE__ . '] - Field Title empty.', 35);
            if (empty($_POST['miq_qnfCate_id']))            throw new Exception('(ErrCode:5132) [' . __LINE__ . '] - Field Category empty.', 35);
            if (empty($_POST['miq_qnf_message']))           throw new Exception('(ErrCode:5133) [' . __LINE__ . '] - Field Message empty.', 35);
            $wfTask_id = $fn_task->task_create('51', '8', '20', '71');
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            $qnf_id = Class_db::getInstance()->db_insert('t_qnf', array('wfTrans_id'=>$wfTrans_id, 'qnf_postType'=>'2', 'qnf_status'=>'4', 'qnf_timeSubmitted'=>'Now()', 'qnf_name'=>$_POST['miq_qnf_name'], 'qnf_contactNo'=>$_POST['miq_qnf_contactNo'],
                'qnf_email'=>$_POST['miq_qnf_email'], 'qnf_title'=>$_POST['miq_qnf_title'], 'qnfCate_id'=>$_POST['miq_qnfCate_id'], 'qnf_message'=>$_POST['miq_qnf_message']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_refName'=>'qnf_id', 'wfTask_refValue'=>$qnf_id), array('wfTask_id'=>$wfTask_id));
            if ($fn_task->task_validate('51', $wfTask_id, 'submit') != 0)
                throw new Exception('(ErrCode:5134) ['.__LINE__.'] - Cannot proceed the transaction.', 35);
            $wfTask_id_new = $fn_task->task_submit('51', $wfTask_id, '71', '10', '', '', '', NULL, '', 'qnf_id', $qnf_id);    
            Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_status'=>'4', 'wfTrans_timeSubmit'=>'Now()'), array('wfTrans_id'=>$wfTrans_id));
            $result = $wfTask_id_new;
        } else if (!isset($_SESSION['user_id'])) {
            throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 35);
        } else if ($_POST['funct'] == 'update_profile'){
            if (empty($_POST['mpfa_user_id']))              throw new Exception('(ErrCode:5105) [' . __LINE__ . '] - Parameter user_id empty.');
            if (empty($_POST['mpfa_profile_mobileNo']))     throw new Exception('(ErrCode:5106) [' . __LINE__ . '] - Field Mobile No. empty.', 35);
            if (empty($_POST['mpfa_profile_email']))        throw new Exception('(ErrCode:5107) [' . __LINE__ . '] - Field Email Address empty.', 35);
            if (empty($_POST['mpfa_profile_name']))         throw new Exception('(ErrCode:5116) [' . __LINE__ . '] - Field Name empty.', 35);
            if (empty($_POST['mpfa_profile_icNo']))         throw new Exception('(ErrCode:5117) [' . __LINE__ . '] - Field Identification No. empty.', 35);
            $profile_id = Class_db::getInstance()->db_select_col('user', array('user_id'=>$_POST['mpfa_user_id']), 'profile_id', NULL, 1);
            $result = Class_db::getInstance()->db_update('profile', array('profile_name'=>$_POST['mpfa_profile_name'], 'profile_icNo'=>$_POST['mpfa_profile_icNo'], 'profile_mobileNo'=>$_POST['mpfa_profile_mobileNo'], 'profile_email'=>$_POST['mpfa_profile_email']), array('profile_id'=>$profile_id));
        } else if ($_POST['funct'] == 'change_password'){
            if (empty($_POST['mpfb_user_id']))              throw new Exception('(ErrCode:5105) [' . __LINE__ . '] - Parameter user_id empty.');
            if (empty($_POST['mpfb_password_confirm']))     throw new Exception('(ErrCode:5113) [' . __LINE__ . '] - Field Confirm Password empty.', 35);
            if (empty($_POST['mpfb_secQues_id']))           throw new Exception('(ErrCode:5114) [' . __LINE__ . '] - Field Security Question empty.', 35);
            if (empty($_POST['mpfb_user_security_answer'])) throw new Exception('(ErrCode:5115) [' . __LINE__ . '] - Field Security Answer empty.', 35);
            $result = Class_db::getInstance()->db_update('user', array('user_password'=>$_POST['mpfb_password_confirm'], 'secQues_id'=>$_POST['mpfb_secQues_id'], 'user_security_answer'=>$_POST['mpfb_user_security_answer']), array('user_id'=>$_POST['mpfb_user_id']));
        } else if ($_POST['funct'] == 'get_notify_task'){
            if (empty($_POST['param']))             throw new Exception('(ErrCode:5129) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfGroup_id']))   throw new Exception('(ErrCode:5130) [' . __LINE__ . '] - Parameter wfGroup_id empty.');  
            $arr_wfTaskType_id = Class_db::getInstance()->db_select_colm('wf_task_user', array('user_id'=>$_SESSION['user_id'], 'wfGroup_id'=>$arrayParam['wfGroup_id']), 'wfTaskType_id');            
            $arr_notify_task = '1';
            if (!empty($arr_wfTaskType_id))
                $arr_notify_task = Class_db::getInstance()->db_select('dt_notify_task', array('wfGroup_id'=>$arrayParam['wfGroup_id']), 'wfTask_timeCreated DESC', NULL, 0, array('wfTaskType_id'=>implode(',', $arr_wfTaskType_id)));
            $result = $arr_notify_task;
        } else if ($_POST['funct'] == 'get_notify_info'){
            if (empty($_POST['param']))             throw new Exception('(ErrCode:5129) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfGroup_id']))   throw new Exception('(ErrCode:5130) [' . __LINE__ . '] - Parameter wfGroup_id empty.');  
            $result = array();
            $result['total_fail_pooling'] =  Class_db::getInstance()->db_count('t_response', array('response_type'=>'1', 'w1'=>'DATE(response_date) >= CURDATE() - INTERVAL 1 DAY'));
            $result['total_fail_compliance'] =  Class_db::getInstance()->db_count('t_response', array('response_type'=>'2', 'w1'=>'DATE(response_date) >= CURDATE() - INTERVAL 1 DAY'));
            $result['total_application_grouped'] = Class_db::getInstance()->db_select('vw_notify_total_application');
        } else {
            throw new Exception('(ErrCode:5001) ['.__LINE__.'] - Post[funct] not valid.');
        }
        $form_data['result'] = $result;
        $form_data['success'] = true;
        Class_db::getInstance()->db_commit();
    }    
} catch(Exception $e) {
    if ($e->getCode() != 31 && $e->getCode() != 32)
        Class_db::getInstance()->db_rollback();
    if ($e->getCode() == 30)
        $form_data['errors'] = 'Fail to login. Please make sure username and password are correct.';
    else if ($e->getCode() == 31)
        $form_data['errors'] = 'You have reach 3 times fail attempt. Please contact Administrator to login.';
    else if ($e->getCode() == 32)
        $form_data['errors'] = 'Fail to login. Please make sure username and password are correct.';
    else if ($e->getCode() == 34)
        $form_data['errors'] = 'Your account is not active. Please contact Administrator.';
    else if ($e->getCode() == 36)
        $form_data['errors'] = 'Your account is not activated yet. Please click the activation link sent to your email.';
    else if ($e->getCode() == 35)
        $form_data['errors'] = substr($e->getMessage(), strpos($e->getMessage(), '] - ') + 3);
    else
        $form_data['errors'] = 'Error on system. Please contact Administrator! '.substr($e->getMessage(), 0, 14);
    $form_data['success'] = false;
    error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $log_dir.'/error/error_'.date("Ymd").'.log');
} 
Class_db::getInstance()->db_close();
        
/* Return back the values to form */
echo json_encode($form_data);
?>
