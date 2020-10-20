<?php

session_start();
require_once '../library/db.php';
require_once '../function/f_task.php';
require_once '../function/f_upload.php';
require_once '../tcpdf/tcpdf.php';
require_once '../pdf/surat_tiada_halangan_cems.php';
require_once '../pdf/surat_tiada_halangan_pems.php';
require_once '../pdf/surat_terima_data.php';

$config = parse_ini_file('../library/config.ini');
$log_dir = $config['log_dir'];

function log_debug($line, $msg, $log_dir) {
    $debugMsg = date("Y/m/d h:i:sa")." [".__FILE__.":".$line."] - ".$msg."\r\n";
    error_log($debugMsg, 3, $log_dir.'/debug/debug_'.date("Ymd").'.log');
}

$form_data = array(); // Pass back the data to form

try {
    /* Validate the form on the server side - 5800 */
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('(ErrCode:0001) [' . __LINE__ . '] - Session expired. Please logout and login back.', 32);
    } else if (empty($_POST['funct'])) { // Function empty
        throw new Exception('(ErrCode:5000) [' . __LINE__ . '] - Post[funct] empty.');
    } else {
        Class_db::getInstance()->db_connect();
        Class_db::getInstance()->db_beginTransaction();
        $fn_task = new Class_task();
        $fn_upload = new Class_upload();
        if ($_POST['funct'] == 'update_consultant') {
            if (empty($_POST['cin_user_id']))                      throw new Exception('(ErrCode:5801) [' . __LINE__ . '] - Parameter user_id empty.');
            if (empty($_POST['cin_wfGroup_id']))                   throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['cin_address_line1']))                throw new Exception('(ErrCode:5803) [' . __LINE__ . '] - Field Registered Address empty.', 32);
            if (empty($_POST['cin_address_postcode']))             throw new Exception('(ErrCode:5804) [' . __LINE__ . '] - Field Registered Postcode empty.', 32);
            if (empty($_POST['cin_city_id']))                      throw new Exception('(ErrCode:5805) [' . __LINE__ . '] - Field Registered City empty.', 32);
            if (empty($_POST['cin_wfGroup_phoneNo']))              throw new Exception('(ErrCode:5809) [' . __LINE__ . '] - Field Phone No. empty.', 32);
            if (empty($_POST['cin_consultant_id']))                throw new Exception('(ErrCode:5810) [' . __LINE__ . '] - Parameter consultant_id empty.', 32);
            $wf_group = Class_db::getInstance()->db_select_single('wf_group', array('wfGroup_id'=>$_POST['cin_wfGroup_id']), NULL, 1);
            $wf_group_profile = Class_db::getInstance()->db_select_single('wf_group_profile', array('wfGroupProfile_id'=>$wf_group['wfGroupProfile_id']), NULL, 1);
            $wfGroup_address = '';
            if ($wf_group_profile['wfGroup_address'] == '') {
                $wfGroup_address = Class_db::getInstance()->db_insert('address', array('address_line1'=>$_POST['cin_address_line1'], 'address_postcode'=>$_POST['cin_address_postcode'], 'city_id'=>$_POST['cin_city_id']));
            } else {
                $wfGroup_address = $wf_group_profile['wfGroup_address'];
                Class_db::getInstance()->db_update('address', array('address_line1'=>$_POST['cin_address_line1'], 'address_postcode'=>$_POST['cin_address_postcode'], 'city_id'=>$_POST['cin_city_id']), array('address_id'=>$wf_group_profile['wfGroup_address']));
            }
            $same_address = empty($_POST['cin_same_address']) ? '' : $_POST['cin_same_address'];
            $mail_address_line1 = '';
            $mail_address_postcode = '';
            $mail_city_id = '';
            if ($same_address == '1') {
                $mail_address_line1 = $_POST['cin_address_line1'];
                $mail_address_postcode = $_POST['cin_address_postcode'];
                $mail_city_id = $_POST['cin_city_id'];
            } else {
                if (empty($_POST['cin_maddress_line1']))        throw new Exception('(ErrCode:5806) [' . __LINE__ . '] - Field Mail Address empty.', 32);
                if (empty($_POST['cin_maddress_postcode']))     throw new Exception('(ErrCode:5807) [' . __LINE__ . '] - Field Mail Postcode empty.', 32);
                if (empty($_POST['cin_mcity_id']))              throw new Exception('(ErrCode:5808) [' . __LINE__ . '] - Field Mail City empty.', 32);
                $mail_address_line1 = $_POST['cin_maddress_line1'];
                $mail_address_postcode = $_POST['cin_maddress_postcode'];
                $mail_city_id = $_POST['cin_mcity_id'];
            }
            $wfGroup_address_mail = '';
            if ($wf_group_profile['wfGroup_address_mail'] == '') {
                $wfGroup_address_mail = Class_db::getInstance()->db_insert('address', array('address_line1'=>$mail_address_line1, 'address_postcode'=>$mail_address_postcode, 'city_id'=>$mail_city_id));
            } else {
                $wfGroup_address_mail = $wf_group_profile['wfGroup_address_mail'];
                Class_db::getInstance()->db_update('address', array('address_line1'=>$mail_address_line1, 'address_postcode'=>$mail_address_postcode, 'city_id'=>$mail_city_id), array('address_id'=>$wf_group_profile['wfGroup_address_mail']));
            }
            Class_db::getInstance()->db_update('t_consultant', array('consultant_dateIncorporate'=>$_POST['cin_consultant_dateIncorporate']), array('consultant_id'=>$_POST['cin_consultant_id']));
            if ($wf_group['wfGroup_isFirstTime'] == '1') {
                Class_db::getInstance()->db_update('wf_group_profile', array('wfGroup_address'=>$wfGroup_address, 'wfGroup_address_mail'=>$wfGroup_address_mail, 'wfGroup_phoneNo'=>$_POST['cin_wfGroup_phoneNo'],
                    'wfGroup_faxNo'=>$_POST['cin_wfGroup_faxNo'], 'wfGroup_website'=>$_POST['cin_wfGroup_website'], 'wfGroup_address_same'=>$same_address), array('wfGroupProfile_id'=>$wf_group['wfGroupProfile_id']));
                Class_db::getInstance()->db_update('wf_group', array('wfGroup_isFirstTime'=>'0'), array('wfGroup_id'=>$wf_group['wfGroup_id']));
            } else {
                Class_db::getInstance()->db_update('wf_group_profile', array('wfGroupProfile_status'=>'3', 'wfGroupProfile_timeEnd'=>'Now()'), array('wfGroupProfile_id'=>$wf_group['wfGroupProfile_id']));
                $wfGroupProfile_id = Class_db::getInstance()->db_insert('wf_group_profile', array('wfGroup_address'=>$wfGroup_address, 'wfGroup_address_mail'=>$wfGroup_address_mail, 'wfGroup_phoneNo'=>$_POST['cin_wfGroup_phoneNo'],
                    'wfGroup_faxNo'=>$_POST['cin_wfGroup_faxNo'], 'wfGroup_website'=>$_POST['cin_wfGroup_website'], 'wfGroup_id'=>$wf_group['wfGroup_id'], 'wfGroupProfile_createdBy'=>$_POST['cin_user_id'], 'wfGroup_address_same'=>$same_address));
                Class_db::getInstance()->db_update('wf_group', array('wfGroupProfile_id'=>$wfGroupProfile_id), array('wfGroup_id'=>$wf_group['wfGroup_id']));
            }
            $result = '1';
        } else if ($_POST['funct'] == 'create_consultant') {
            if (empty($_POST['param']))                throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfGroup_id']))      throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($arrayParam['wfTaskType_id']))   throw new Exception('(ErrCode:5812) [' . __LINE__ . '] - Parameter wfTaskType_id empty.');
            if (empty($arrayParam['wfFlow_id']))       throw new Exception('(ErrCode:5813) [' . __LINE__ . '] - Parameter wfFlow_id empty.');
            if (empty($arrayParam['consAll_type']))    throw new Exception('(ErrCode:5814) [' . __LINE__ . '] - Parameter consAll_type empty.');
            $wfTask_id = $fn_task->task_create($_SESSION['user_id'], $arrayParam['wfFlow_id'], $arrayParam['wfGroup_id'], $arrayParam['wfTaskType_id']);
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            $wfGroupProfile_id = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$arrayParam['wfGroup_id']), 'wfGroupProfile_id', NULL, 1);
            $consultant_id = Class_db::getInstance()->db_select_col('t_consultant', array('wfGroup_id'=>$arrayParam['wfGroup_id']), 'consultant_id', NULL, 1);
            $consAll_id = Class_db::getInstance()->db_insert('t_consultant_all', array('consultant_id'=>$consultant_id, 'wfTrans_id'=>$wfTrans_id, 'consAll_type'=>$arrayParam['consAll_type'], 'wfGroupProfile_id'=>$wfGroupProfile_id));
            if ($arrayParam['consAll_type'] == '1') {
                $dis_id = Class_db::getInstance()->db_insert('t_dis', array());
				$das_id = Class_db::getInstance()->db_insert('t_das', array());
                Class_db::getInstance()->db_insert('t_consultant_cems', array('consAll_id'=>$consAll_id, 'consultant_id'=>$consultant_id, 'wfTrans_id'=>$wfTrans_id, 'consCems_contactPerson'=>$_SESSION['user_id'], 'consCems_createdBy'=>$_SESSION['user_id'], 'dis_id'=>$dis_id, 'das_id'=>$das_id));
            } else if ($arrayParam['consAll_type'] == '2') {
                $dis_id = Class_db::getInstance()->db_insert('t_dis', array());
				$das_id = Class_db::getInstance()->db_insert('t_das', array());
                Class_db::getInstance()->db_insert('t_consultant_pems', array('consAll_id'=>$consAll_id, 'consultant_id'=>$consultant_id, 'wfTrans_id'=>$wfTrans_id, 'consPems_contactPerson'=>$_SESSION['user_id'], 'consPems_createdBy'=>$_SESSION['user_id'], 'dis_id'=>$dis_id, 'das_id'=>$das_id));
            } else if ($arrayParam['consAll_type'] == '3') {
                $dis_id = Class_db::getInstance()->db_insert('t_dis', array());
				$das_id = Class_db::getInstance()->db_insert('t_das', array());
                Class_db::getInstance()->db_insert('t_consultant_mobile', array('consAll_id'=>$consAll_id, 'consultant_id'=>$consultant_id, 'wfTrans_id'=>$wfTrans_id, 'consMobile_contactPerson'=>$_SESSION['user_id'], 'consMobile_createdBy'=>$_SESSION['user_id'], 'dis_id'=>$dis_id, 'das_id'=>$das_id));
            }
            Class_db::getInstance()->db_update('wf_task', array('wfTask_refName'=>'consAll_id', 'wfTask_refValue'=>$consAll_id), array('wfTask_id'=>$wfTask_id));
            $result = $consAll_id;
        } else if ($_POST['funct'] == 'upload_analyzer_catalogue') {
            if (empty($_POST['consAll_id']))                    throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mac_cat_documentName_id']))       throw new Exception('(ErrCode:5885) [' . __LINE__ . '] - Field Document Type empty.', 32);
            if (empty($_POST['mac_cat_document_name']))         throw new Exception('(ErrCode:5886) [' . __LINE__ . '] - Field Document Title empty.', 32);
            if (empty($_FILES['mac_file_catalogue']['name']))   throw new Exception('(ErrCode:5887) [' . __LINE__ . '] - Manual / Catalogue Attachment File empty.', 32);
            $document_id = $fn_upload->upload_file('1', $_FILES['mac_file_catalogue'], $_POST['mac_cat_document_name'], $_POST['mac_cat_documentName_id'], '');
            $result = Class_db::getInstance()->db_insert('t_consultant_doc', array('document_id'=>$document_id, 'documentName_id'=>$_POST['mac_cat_documentName_id'], 'consAll_id'=>$_POST['consAll_id']));
        } else if ($_POST['funct'] == 'upload_analyzer_catalogue_mobile') {
            if (empty($_POST['consAll_id']))                    throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mam_cat_documentName_id']))       throw new Exception('(ErrCode:5885) [' . __LINE__ . '] - Field Document Type empty.', 32);
            if (empty($_POST['mam_cat_document_name']))         throw new Exception('(ErrCode:5886) [' . __LINE__ . '] - Field Document Title empty.', 32);
            if (empty($_FILES['mam_file_catalogue']['name']))   throw new Exception('(ErrCode:5887) [' . __LINE__ . '] - Manual / Catalogue Attachment File empty.', 32);
            $document_id = $fn_upload->upload_file('1', $_FILES['mam_file_catalogue'], $_POST['mam_cat_document_name'], $_POST['mam_cat_documentName_id'], '');
            $result = Class_db::getInstance()->db_insert('t_consultant_doc', array('document_id'=>$document_id, 'documentName_id'=>$_POST['mam_cat_documentName_id'], 'consAll_id'=>$_POST['consAll_id']));
        } else if ($_POST['funct'] == 'delete_analyzer_catalogue') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consDoc_id']))      throw new Exception('(ErrCode:5888) [' . __LINE__ . '] - Parameter consDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_consultant_doc', array('consDoc_id'=>$arrayParam['consDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_consultant_doc', array('consDoc_status'=>'8'), array('consDoc_id'=>$arrayParam['consDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_cems') {
            if (empty($_POST['mac_wfGroup_id']))       throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['mac_consultant_id']))    throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consultant_id empty.');
            if (empty($_POST['mac_wfTask_id']))        throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mac_consAll_id']))       throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mac_dis_id']))           throw new Exception('(ErrCode:5818) [' . __LINE__ . '] - Parameter dis_id empty.');
            $arr_consType = Class_db::getInstance()->db_select_colm ('t_consultant_type', array('consAll_id'=>$_POST['mac_consAll_id']), 'consType_type');
            $arrPost_consType = (!empty($_POST['mac_consType_type'])) ? $_POST['mac_consType_type'] : array();
            if ($arr_consType != $arrPost_consType) {
                $arrDiff_consType1 = array_diff($arrPost_consType, $arr_consType);
                foreach($arrDiff_consType1 as $value) {
                    Class_db::getInstance()->db_insert('t_consultant_type', array('consAll_id'=>$_POST['mac_consAll_id'], 'consType_type'=>$value));
                }
                $arrDiff_consType2 = array_diff($arr_consType, $arrPost_consType);
                if (count($arrDiff_consType2) > 0) {
                    Class_db::getInstance()->db_delete('t_consultant_type', array('consAll_id'=>$_POST['mac_consAll_id'], 'consType_type'=>'('.  implode(',', $arrDiff_consType2).')'));
                }
            }
            $arr_consSource = Class_db::getInstance()->db_select_colm ('t_consultant_source', array('consAll_id'=>$_POST['mac_consAll_id']), 'sourceActivity_id');
            $arrPost_consSource = (!empty($_POST['mac_sourceActivity_id'])) ? $_POST['mac_sourceActivity_id'] : array();
            if ($arr_consSource != $arrPost_consSource) {
                $arrDiff_consSource1 = array_diff($arrPost_consSource, $arr_consSource);
                foreach($arrDiff_consSource1 as $value) {
                    Class_db::getInstance()->db_insert('t_consultant_source', array('consAll_id'=>$_POST['mac_consAll_id'], 'sourceActivity_id'=>$value));
                }
                $arrDiff_consSource2 = array_diff($arr_consSource, $arrPost_consSource);
                if (count($arrDiff_consSource2) > 0) {
                    Class_db::getInstance()->db_delete('t_consultant_source', array('consAll_id'=>$_POST['mac_consAll_id'], 'sourceActivity_id'=>'('.  implode(',', $arrDiff_consSource2).')'));
                }
            }
            $consCems_isInstall = '0';
            $consCems_isMaintain = '0';
            if (!empty($_POST['mac_consultant_type'])) {
                foreach ($_POST['mac_consultant_type'] as $value) {
                    if ($value == '1')      $consCems_isInstall = '1';
                    else if ($value == '2') $consCems_isMaintain = '1';
                }
            }
            $consCems_probeEnabled = (isset($_POST['mac_consCems_probeEnabled'])) ? '1' : '0';
            $consCems_probeType = (!empty($_POST['mac_consCems_probeType'])) ? $_POST['mac_consCems_probeType'] : '';
            $consCems_probeLength = (!empty($_POST['mac_consCems_probeLength'])) ? $_POST['mac_consCems_probeLength'] : '';
            $consCems_compStatus = (!empty($_POST['mac_consCems_compStatus'])) ? $_POST['mac_consCems_compStatus'] : '';
            $consCems_samplingEnabled = (isset($_POST['mac_consCems_samplingEnabled'])) ? '1' : '0';
            $consCems_samplineLine = (!empty($_POST['mac_consCems_samplingLine'])) ? $_POST['mac_consCems_samplingLine'] : '';
            Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_isInstall'=>$consCems_isInstall, 'consCems_isMaintain'=>$consCems_isMaintain, 'consCems_compStatus'=>$consCems_compStatus,
                'consCems_modelNo'=>$_POST['mac_consCems_modelNo'], 'consCems_isNormalize'=>$_POST['mac_consCems_isNormalize'], 'consCems_correction'=>$_POST['mac_consCems_correction'], 'consCems_brand'=>$_POST['mac_consCems_brand'],
                'consCems_manufacturer'=>$_POST['mac_consCems_manufacturer'], 'consCems_probeEnabled'=>$consCems_probeEnabled, 'consCems_probeType'=>$consCems_probeType, 'consCems_probeLength'=>$consCems_probeLength, 'consCems_techniqueType'=>$_POST['mac_consCems_techniqueType'],
                'consCems_samplingEnabled'=>$consCems_samplingEnabled, 'consCems_samplingLine'=>$consCems_samplineLine, 'consCems_software'=>$_POST['mac_consCems_software']), array('consAll_id'=>$_POST['mac_consAll_id']));
            $dis_outsource = (isset($_POST['mac_dis_outsource'])) ? $_POST['mac_dis_outsource'] : '';
            Class_db::getInstance()->db_update('t_dis', array('dis_name'=>$_POST['mac_dis_name'], 'dis_type'=>$_POST['mac_dis_type'], 'dis_outsource'=>$dis_outsource, 'dis_description'=>$_POST['mac_dis_description']), array('dis_id'=>$_POST['mac_dis_id']));
            Class_db::getInstance()->db_update('t_das', array('das_probeSoftware'=>$_POST['mac_das_probeSoftware'], 'das_probeDesc'=>$_POST['mac_das_probeDesc'], 'das_analyzerSoftware'=>$_POST['mac_das_analyzerSoftware'], 'das_analyzerDesc'=>$_POST['mac_das_analyzerDesc']), array('das_id'=>$_POST['mac_das_id']));
            Class_db::getInstance()->db_update('t_consultant_all', array('consAll_remark'=>$_POST['mac_wfTask_remark']), array('consAll_id'=>$_POST['mac_consAll_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['mac_wfTask_remark']), array('wfTask_id'=>$_POST['mac_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_pems') {
            if (empty($_POST['map_wfGroup_id']))       throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['map_consultant_id']))    throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consultant_id empty.');
            if (empty($_POST['map_wfTask_id']))        throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['map_consAll_id']))       throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['map_dis_id']))           throw new Exception('(ErrCode:5818) [' . __LINE__ . '] - Parameter dis_id empty.');
            $arr_consSource = Class_db::getInstance()->db_select_colm ('t_consultant_source', array('consAll_id'=>$_POST['map_consAll_id']), 'sourceActivity_id');
            $arrPost_consSource = (!empty($_POST['map_sourceActivity_id'])) ? $_POST['map_sourceActivity_id'] : array();
            if ($arr_consSource != $arrPost_consSource) {
                $arrDiff_consSource1 = array_diff($arrPost_consSource, $arr_consSource);
                foreach($arrDiff_consSource1 as $value) {
                    Class_db::getInstance()->db_insert('t_consultant_source', array('consAll_id'=>$_POST['map_consAll_id'], 'sourceActivity_id'=>$value));
                }
                $arrDiff_consSource2 = array_diff($arr_consSource, $arrPost_consSource);
                if (count($arrDiff_consSource2) > 0) {
                    Class_db::getInstance()->db_delete('t_consultant_source', array('consAll_id'=>$_POST['map_consAll_id'], 'sourceActivity_id'=>'('.  implode(',', $arrDiff_consSource2).')'));
                }
            }
            $consPems_isInstall = '0';
            $consPems_isMaintain = '0';
            if (!empty($_POST['map_consultant_type'])) {
                foreach ($_POST['map_consultant_type'] as $value) {
                    if ($value == '1')      $consPems_isInstall = '1';
                    else if ($value == '2') $consPems_isMaintain = '1';
                }
            }
            $consPems_outsource = $_POST['map_dis_type'] == '2' ? $_POST['map_consPems_outsource'] : '';
            Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_isInstall'=>$consPems_isInstall, 'consPems_isMaintain'=>$consPems_isMaintain, 'consPems_outsource'=>$consPems_outsource, 'consPems_model'=>$_POST['map_consPems_model'],
                'consPems_version'=>$_POST['map_consPems_version'], 'softwareMethod_id'=>$_POST['map_softwareMethod_id'], 'consPems_security'=>$_POST['map_consPems_security'], 'consPems_ownerStatus'=>$_POST['map_consPems_ownerStatus'],
                ), array('consAll_id'=>$_POST['map_consAll_id']));
            $dis_outsource = (isset($_POST['map_dis_outsource'])) ? $_POST['map_dis_outsource'] : '';
            Class_db::getInstance()->db_update('t_dis', array('dis_name'=>$_POST['map_dis_name'], 'dis_type'=>$_POST['map_dis_type'], 'dis_outsource'=>$dis_outsource, 'dis_description'=>$_POST['map_dis_description']), array('dis_id'=>$_POST['map_dis_id']));
            Class_db::getInstance()->db_update('t_das', array('das_probeSoftware'=>$_POST['map_das_probeSoftware'], 'das_probeDesc'=>$_POST['map_das_probeDesc'], 'das_analyzerSoftware'=>$_POST['map_das_analyzerSoftware'], 'das_analyzerDesc'=>$_POST['map_das_analyzerDesc']), array('das_id'=>$_POST['map_das_id']));
            Class_db::getInstance()->db_update('t_consultant_all', array('consAll_remark'=>$_POST['map_wfTask_remark']), array('consAll_id'=>$_POST['map_consAll_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['map_wfTask_remark']), array('wfTask_id'=>$_POST['map_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_mobile') {
            if (empty($_POST['mam_wfGroup_id']))       throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['mam_consultant_id']))    throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consultant_id empty.');
            if (empty($_POST['mam_wfTask_id']))        throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mam_consAll_id']))       throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mam_dis_id']))           throw new Exception('(ErrCode:5818) [' . __LINE__ . '] - Parameter dis_id empty.');
            $arrPost_mobileEquip = array();
            $arr_mobileEquip = Class_db::getInstance()->db_select('dt_mobile_cems_equipment', array('mobileEquip_status'=>'1'), NULL, NULL, 1, array('consAll_id'=>$_POST['mam_consAll_id']));
            if ($_POST['mam_consMobile_techniqueType'] == '1') {
                foreach ($arr_mobileEquip as $mobileEquip) {
                    if (in_array($mobileEquip['mobileEquip_type'], array('1', '3'))) {
                        log_debug(__LINE__, 'mobileEquip_ids = '.$mobileEquip['mobileEquip_ids'], $log_dir);
                        log_debug(__LINE__, 'consMobileEquip_id = '.$mobileEquip['consMobileEquip_id'], $log_dir);
                        if (!isset($_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']]))
                            throw new Exception('(ErrCode:5866) [' . __LINE__ . '] - Mobile-CEMS Equipment Field not exist.');
                        if (!empty($_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']])) {
                            if (!empty($mobileEquip['consMobileEquip_id']))
                                Class_db::getInstance()->db_update('t_consultant_mobile_equipment', array('consMobileEquip_spec'=>$_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']]), array('consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>$mobileEquip['mobileEquip_ids']));
                            else
                                Class_db::getInstance()->db_insert('t_consultant_mobile_equipment', array('consMobileEquip_spec'=>$_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']], 'consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>$mobileEquip['mobileEquip_ids']));
                            array_push($arrPost_mobileEquip, $mobileEquip['mobileEquip_ids']);
                        } else {
                            if (!empty($mobileEquip['consMobileEquip_id']))
                                Class_db::getInstance()->db_delete('t_consultant_mobile_equipment', array('consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>$mobileEquip['mobileEquip_ids']));
                        }
                    } else if ($mobileEquip['mobileEquip_type'] == '2') {
                        if (!isset($_POST['mam_consMobileEquip_model_'.$mobileEquip['mobileEquip_ids']]) || !isset($_POST['mam_consMobileEquip_manufacturer_'.$mobileEquip['mobileEquip_ids']]) || !isset($_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']]))
                            throw new Exception('(ErrCode:5866) [' . __LINE__ . '] - Mobile-CEMS Equipment Field not exist.');
                        if (!empty($_POST['mam_consMobileEquip_model_'.$mobileEquip['mobileEquip_ids']]) && !empty($_POST['mam_consMobileEquip_manufacturer_'.$mobileEquip['mobileEquip_ids']]) && !empty($_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']])) {
                            if (!empty($mobileEquip['consMobileEquip_id']))
                                Class_db::getInstance()->db_update('t_consultant_mobile_equipment', array('consMobileEquip_model'=>$_POST['mam_consMobileEquip_model_'.$mobileEquip['mobileEquip_ids']], 'consMobileEquip_manufacturer'=>$_POST['mam_consMobileEquip_manufacturer_'.$mobileEquip['mobileEquip_ids']], 'consMobileEquip_spec'=>$_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']]),
                                    array('consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>$mobileEquip['mobileEquip_ids']));
                            else
                                Class_db::getInstance()->db_insert('t_consultant_mobile_equipment', array('consMobileEquip_model'=>$_POST['mam_consMobileEquip_model_'.$mobileEquip['mobileEquip_ids']], 'consMobileEquip_manufacturer'=>$_POST['mam_consMobileEquip_manufacturer_'.$mobileEquip['mobileEquip_ids']], 'consMobileEquip_spec'=>$_POST['mam_consMobileEquip_spec_'.$mobileEquip['mobileEquip_ids']],
                                    'consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>$mobileEquip['mobileEquip_ids']));
                            array_push($arrPost_mobileEquip, $mobileEquip['mobileEquip_ids']);
                        } else {
                            if (!empty($mobileEquip['consMobileEquip_id']))
                                Class_db::getInstance()->db_delete('t_consultant_mobile_equipment', array('consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>$mobileEquip['mobileEquip_ids']));
                        }
                    } else
                        throw new Exception('(ErrCode:5867) [' . __LINE__ . '] - Mobile-CEMS Equipment Type not valid.');
                }
                if (count($arrPost_mobileEquip) > 0)
                    Class_db::getInstance()->db_delete('t_consultant_mobile_equipment', array('consAll_id'=>$_POST['mam_consAll_id'], 'mobileEquip_id'=>'N('.  implode(',', $arrPost_mobileEquip).')'));
            } else {
                if (count($arr_mobileEquip) > 0)
                    Class_db::getInstance()->db_delete('t_consultant_mobile_equipment', array('consAll_id'=>$_POST['mam_consAll_id']));
            }
            $arr_consType = Class_db::getInstance()->db_select_colm ('t_consultant_type', array('consAll_id'=>$_POST['mam_consAll_id']), 'consType_type');
            $arrPost_consType = (!empty($_POST['mam_consType_type'])) ? $_POST['mam_consType_type'] : array();
            if ($arr_consType != $arrPost_consType) {
                $arrDiff_consType1 = array_diff($arrPost_consType, $arr_consType);
                foreach($arrDiff_consType1 as $value) {
                    Class_db::getInstance()->db_insert('t_consultant_type', array('consAll_id'=>$_POST['mam_consAll_id'], 'consType_type'=>$value));
                }
                $arrDiff_consType2 = array_diff($arr_consType, $arrPost_consType);
                if (count($arrDiff_consType2) > 0) {
                    Class_db::getInstance()->db_delete('t_consultant_type', array('consAll_id'=>$_POST['mam_consAll_id'], 'consType_type'=>'('.  implode(',', $arrDiff_consType2).')'));
                }
            }
            $arr_consSource = Class_db::getInstance()->db_select_colm ('t_consultant_source', array('consAll_id'=>$_POST['mam_consAll_id']), 'sourceActivity_id');
            $arrPost_consSource = (!empty($_POST['mam_sourceActivity_id'])) ? $_POST['mam_sourceActivity_id'] : array();
            if ($arr_consSource != $arrPost_consSource) {
                $arrDiff_consSource1 = array_diff($arrPost_consSource, $arr_consSource);
                foreach($arrDiff_consSource1 as $value) {
                    Class_db::getInstance()->db_insert('t_consultant_source', array('consAll_id'=>$_POST['mam_consAll_id'], 'sourceActivity_id'=>$value));
                }
                $arrDiff_consSource2 = array_diff($arr_consSource, $arrPost_consSource);
                if (count($arrDiff_consSource2) > 0) {
                    Class_db::getInstance()->db_delete('t_consultant_source', array('consAll_id'=>$_POST['mam_consAll_id'], 'sourceActivity_id'=>'('.  implode(',', $arrDiff_consSource2).')'));
                }
            }
            $consMobile_probeEnabled = (isset($_POST['mam_consMobile_probeEnabled'])) ? '1' : '0';
            $consMobile_probeType = (!empty($_POST['mam_consMobile_probeType'])) ? $_POST['mam_consMobile_probeType'] : '';
            $consMobile_probeLength = (!empty($_POST['mam_consMobile_probeLength'])) ? $_POST['mam_consMobile_probeLength'] : '';
            $consMobile_samplingEnabled = (isset($_POST['mam_consMobile_samplingEnabled'])) ? '1' : '0';
            $consMobile_samplineLine = (!empty($_POST['mam_consMobile_samplingLine'])) ? $_POST['mam_consMobile_samplingLine'] : '';
            $consMobile_refMethod = (!empty($_POST['mam_consMobile_refMethod'])) ? $_POST['mam_consMobile_refMethod'] : '';
            $consMobile_compStatus = (!empty($_POST['mam_consMobile_compStatus'])) ? $_POST['mam_consMobile_compStatus'] : '';
            Class_db::getInstance()->db_update('t_consultant_mobile', array('consMobile_refMethod'=>$consMobile_refMethod, 'consMobile_compStatus'=>$consMobile_compStatus, 'consMobile_correction'=>$_POST['mam_consMobile_correction'],
                'consMobile_modelNo'=>$_POST['mam_consMobile_modelNo'], 'consMobile_isNormalize'=>$_POST['mam_consMobile_isNormalize'], 'consMobile_brand'=>$_POST['mam_consMobile_brand'],
                'consMobile_manufacturer'=>$_POST['mam_consMobile_manufacturer'], 'consMobile_probeEnabled'=>$consMobile_probeEnabled, 'consMobile_probeType'=>$consMobile_probeType, 'consMobile_probeLength'=>$consMobile_probeLength, 'mobileTechnique_id'=>$_POST['mam_consMobile_techniqueType'],
                'consMobile_samplingEnabled'=>$consMobile_samplingEnabled, 'consMobile_samplingLine'=>$consMobile_samplineLine, 'consMobile_software'=>$_POST['mam_consMobile_software']), array('consAll_id'=>$_POST['mam_consAll_id']));
            $dis_outsource = (isset($_POST['mam_dis_outsource'])) ? $_POST['mam_dis_outsource'] : '';
            Class_db::getInstance()->db_update('t_dis', array('dis_name'=>$_POST['mam_dis_name'], 'dis_type'=>$_POST['mam_dis_type'], 'dis_outsource'=>$dis_outsource, 'dis_description'=>$_POST['mam_dis_description']), array('dis_id'=>$_POST['mam_dis_id']));
            Class_db::getInstance()->db_update('t_das', array('das_probeSoftware'=>$_POST['mam_das_probeSoftware'], 'das_probeDesc'=>$_POST['mam_das_probeDesc'], 'das_analyzerSoftware'=>$_POST['mam_das_analyzerSoftware'], 'das_analyzerDesc'=>$_POST['mam_das_analyzerDesc']), array('das_id'=>$_POST['mam_das_id']));
            Class_db::getInstance()->db_update('t_consultant_all', array('consAll_remark'=>$_POST['mam_wfTask_remark']), array('consAll_id'=>$_POST['mam_consAll_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['mam_wfTask_remark']), array('wfTask_id'=>$_POST['mam_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_parameter') {
            if (empty($_POST['mac_consAll_id']))                throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mac_inputParam_id']))             throw new Exception('(ErrCode:5819) [' . __LINE__ . '] - Field Input Parameter empty.', 32);
            if (empty($_POST['mac_consParam_dataGeneration']))  throw new Exception('(ErrCode:5847) [' . __LINE__ . '] - Field Data Generation empty.', 32);
            if (Class_db::getInstance()->db_count('t_consultant_parameter', array('inputParam_id'=>$_POST['mac_inputParam_id'], 'consAll_id'=>$_POST['mac_consAll_id'])) > 0)
                throw new Exception('(ErrCode:5845) [' . __LINE__ . '] - Input Parameter already exist.', 32);
            $consParam_reference = (isset($_POST['mac_consParam_reference'])) ? $_POST['mac_consParam_reference'] : '';
            $consParam_method = (isset($_POST['mac_consParam_method'])) ? $_POST['mac_consParam_method'] : '';
            $consParam_id = Class_db::getInstance()->db_insert('t_consultant_parameter', array('consAll_id'=>$_POST['mac_consAll_id'], 'inputParam_id'=>$_POST['mac_inputParam_id'], 'consParam_reference'=>$consParam_reference, 'consParam_dataGeneration'=>$_POST['mac_consParam_dataGeneration'], 'consParam_method'=>$consParam_method, 'consParam_volume'=>$_POST['mac_consParam_volume']));
            Class_db::getInstance()->db_insert('t_consultant_param_range', array('consParam_id'=>$consParam_id, 'consParamRange_from'=>$_POST['mac_consParamRange_from_0'], 'consParamRange_to'=>$_POST['mac_consParamRange_to_0']));
            Class_db::getInstance()->db_insert('t_consultant_param_measure', array('consParam_id'=>$consParam_id, 'consParamMeasure_from'=>$_POST['mac_consMeasureRange_from_0'], 'consParamMeasure_to'=>$_POST['mac_consMeasureRange_to_0']));
            for ($i=1; $i<=5; $i++){
                if (isset($_POST['mac_consParamRange_from_'.$i]) && !empty($_POST['mac_consParamRange_to_'.$i])) {
                    Class_db::getInstance()->db_insert('t_consultant_param_range', array('consParam_id'=>$consParam_id, 'consParamRange_from'=>$_POST['mac_consParamRange_from_'.$i], 'consParamRange_to'=>$_POST['mac_consParamRange_to_'.$i]));
                }
                if (isset($_POST['mac_consMeasureRange_from_'.$i]) && !empty($_POST['mac_consMeasureRange_to_'.$i])) {
                    Class_db::getInstance()->db_insert('t_consultant_param_measure', array('consParam_id'=>$consParam_id, 'consParamMeasure_from'=>$_POST['mac_consMeasureRange_from_'.$i], 'consParamMeasure_to'=>$_POST['mac_consMeasureRange_to_'.$i]));
                }
            }
            foreach ($_POST['mac_analyzerTechnique_id'] as $analyzerTechnique_id) {
                Class_db::getInstance()->db_insert('t_consultant_param_method', array('consParam_id'=>$consParam_id, 'analyzerTechnique_id'=>$analyzerTechnique_id));
            }
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_parameter_mobile') {
            if (empty($_POST['mam_consAll_id']))                throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mam_inputParam_id']))             throw new Exception('(ErrCode:5819) [' . __LINE__ . '] - Field Input Parameter empty.', 32);
            if (empty($_POST['mam_consParam_dataGeneration']))  throw new Exception('(ErrCode:5847) [' . __LINE__ . '] - Field Data Generation empty.', 32);
            if (Class_db::getInstance()->db_count('t_consultant_parameter', array('inputParam_id'=>$_POST['mam_inputParam_id'], 'consAll_id'=>$_POST['mam_consAll_id'])) > 0)
                throw new Exception('(ErrCode:5845) [' . __LINE__ . '] - Input Parameter already exist.', 32);
            $consParam_reference = (isset($_POST['mam_consParam_reference'])) ? $_POST['mam_consParam_reference'] : '';
            $consParam_method = (isset($_POST['mam_consParam_method'])) ? $_POST['mam_consParam_method'] : '';
            $consParam_id = Class_db::getInstance()->db_insert('t_consultant_parameter', array('consAll_id'=>$_POST['mam_consAll_id'], 'inputParam_id'=>$_POST['mam_inputParam_id'], 'consParam_reference'=>$consParam_reference, 'consParam_dataGeneration'=>$_POST['mam_consParam_dataGeneration'], 'consParam_method'=>$consParam_method));
            Class_db::getInstance()->db_insert('t_consultant_param_range', array('consParam_id'=>$consParam_id, 'consParamRange_from'=>$_POST['mam_consParamRange_from_0'], 'consParamRange_to'=>$_POST['mam_consParamRange_to_0']));
            for ($i=1; $i<=5; $i++){
                if (!isset($_POST['mam_consParamRange_from_'.$i]) && !empty($_POST['mam_consParamRange_to_'.$i])) {
                    Class_db::getInstance()->db_insert('t_consultant_param_range', array('consParam_id'=>$consParam_id, 'consParamRange_from'=>$_POST['mam_consParamRange_from_'.$i], 'consParamRange_to'=>$_POST['mam_consParamRange_to_'.$i]));
                }
            }
            foreach ($_POST['mam_analyzerTechnique_id'] as $analyzerTechnique_id) {
                Class_db::getInstance()->db_insert('t_consultant_param_method', array('consParam_id'=>$consParam_id, 'analyzerTechnique_id'=>$analyzerTechnique_id));
            }
            $result = '1';
        } else if ($_POST['funct'] == 'delete_certificate') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['certificate_id']))   throw new Exception('(ErrCode:5826) [' . __LINE__ . '] - Parameter certificate_id empty.');
            Class_db::getInstance()->db_delete('t_certificate_basic_list', array('certificate_id'=>$arrayParam['certificate_id']));
            Class_db::getInstance()->db_delete('t_certificate', array('certificate_id'=>$arrayParam['certificate_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_certificate') {
            if (empty($_POST['mac_consAll_id']))                throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mac_certificate_no']))            throw new Exception('(ErrCode:5822) [' . __LINE__ . '] - Field Certificate No. empty.', 32);
            if (empty($_POST['mac_certIssuer_id']))             throw new Exception('(ErrCode:5823) [' . __LINE__ . '] - Field Certificate Issuer empty.', 32);
            if (empty($_POST['mac_file_certificate_name']))     throw new Exception('(ErrCode:5890) [' . __LINE__ . '] - Field Document Title empty.', 32);
            $document_id = !empty($_FILES['mac_file_certificate']['name']) ? $fn_upload->upload_file('1', $_FILES['mac_file_certificate'], $_POST['mac_file_certificate_name'], '10', '') : '';
            $certificate_id = Class_db::getInstance()->db_insert('t_certificate', array('consAll_id'=>$_POST['mac_consAll_id'], 'certificate_no'=>$_POST['mac_certificate_no'], 'certIssuer_id'=>$_POST['mac_certIssuer_id'],
                'certificate_dateExpired'=>(isset($_POST['mac_certificate_dateExpired'])?$_POST['mac_certificate_dateExpired']:''), 'certificate_timeSubmit'=>'Now()', 'certificate_timeFinish'=>'Now()', 'document_id'=>$document_id));
            $arrPost_certBasic = (!empty($_POST['mac_certBasic_id'])) ? $_POST['mac_certBasic_id'] : array();
            foreach($arrPost_certBasic as $value) {
                Class_db::getInstance()->db_insert('t_certificate_basic_list', array('certificate_id'=>$certificate_id, 'certBasic_id'=>$value));
            }
            $certificate_id = Class_db::getInstance()->db_update('t_certificate', array('certificate_main'=>$certificate_id), array('certificate_id'=>$certificate_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_certificate_mobile') {
            if (empty($_POST['mam_consAll_id']))                throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mam_certificate_no']))            throw new Exception('(ErrCode:5822) [' . __LINE__ . '] - Field Certificate No. empty.', 32);
            if (empty($_POST['mam_certIssuer_id']))             throw new Exception('(ErrCode:5823) [' . __LINE__ . '] - Field Certificate Issuer empty.', 32);
            if (empty($_POST['mam_file_certificate_name']))     throw new Exception('(ErrCode:5890) [' . __LINE__ . '] - Field Document Title empty.', 32);
            $document_id = !empty($_FILES['mam_file_certificate']['name']) ? $fn_upload->upload_file('1', $_FILES['mam_file_certificate'], $_POST['mam_file_certificate_name'], '10', '') : '';
            $certificate_id = Class_db::getInstance()->db_insert('t_certificate', array('consAll_id'=>$_POST['mam_consAll_id'], 'certificate_no'=>$_POST['mam_certificate_no'], 'certIssuer_id'=>$_POST['mam_certIssuer_id'],
                'certificate_dateExpired'=>(isset($_POST['mam_certificate_dateExpired'])?$_POST['mam_certificate_dateExpired']:''), 'certificate_timeSubmit'=>'Now()', 'certificate_timeFinish'=>'Now()', 'document_id'=>$document_id));
            $arrPost_certBasic = (!empty($_POST['mam_certBasic_id'])) ? $_POST['mam_certBasic_id'] : array();
            foreach($arrPost_certBasic as $value) {
                Class_db::getInstance()->db_insert('t_certificate_basic_list', array('certificate_id'=>$certificate_id, 'certBasic_id'=>$value));
            }
            $certificate_id = Class_db::getInstance()->db_update('t_certificate', array('certificate_main'=>$certificate_id), array('certificate_id'=>$certificate_id));
            $result = '1';
        } else if ($_POST['funct'] == 'delete_consultant_parameter') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consParam_id']))     throw new Exception('(ErrCode:5827) [' . __LINE__ . '] - Parameter consParam_id empty.');
            Class_db::getInstance()->db_delete('t_consultant_param_range', array('consParam_id'=>$arrayParam['consParam_id']));
            Class_db::getInstance()->db_delete('t_consultant_param_measure', array('consParam_id'=>$arrayParam['consParam_id']));
            Class_db::getInstance()->db_delete('t_consultant_param_method', array('consParam_id'=>$arrayParam['consParam_id']));
            Class_db::getInstance()->db_delete('t_consultant_parameter', array('consParam_id'=>$arrayParam['consParam_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_personnel') {
            if (empty($_POST['mac_consAll_id']))               throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mac_wfGroup_id']))               throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['mac_consPers_name']))            throw new Exception('(ErrCode:5828) [' . __LINE__ . '] - Name of Certified Employee empty.', 32);
            if (empty($_POST['mac_personnel_icNo']))           throw new Exception('(ErrCode:5849) [' . __LINE__ . '] - IC. / Passport No empty.', 32);
            if (empty($_POST['mac_consPers_qualification']))   throw new Exception('(ErrCode:5829) [' . __LINE__ . '] - Academic Qualification empty.', 32);
            if (empty($_POST['mac_consPers_experience']))      throw new Exception('(ErrCode:5830) [' . __LINE__ . '] - Working Experience empty.', 32);
            if (empty($_POST['mac_consPers_certificate']))     throw new Exception('(ErrCode:5831) [' . __LINE__ . '] - Training Certification empty.', 32);
            if (empty($_POST['mac_personnel_citizenship']))    throw new Exception('(ErrCode:5850) [' . __LINE__ . '] - Citizenship empty.', 32);
            if (empty($_POST['mac_consPers_workingStatus']))   throw new Exception('(ErrCode:5851) [' . __LINE__ . '] - Employee\'s Status empty.', 32);
            $personnel_id = '';
            $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_icNo'=>$_POST['mac_personnel_icNo']));
            if (!empty($personnel)) {
                if (Class_db::getInstance()->db_count('t_consultant_personnel', array('personnel_id'=>$personnel['personnel_id'], 'consAll_id'=>$_POST['mac_consAll_id'])) > 0)
                    throw new Exception('(ErrCode:5850) [' . __LINE__ . '] - IC / Passport No. already exist in your list.', 32);
                if ($personnel['wfGroup_id'] != $_POST['mac_wfGroup_id'] && $_POST['mac_consPers_workingStatus'] == '1') {
                    if ($personnel['personnel_status'] == '1' || $personnel['personnel_status'] == '4')
                        throw new Exception('(ErrCode:5851) [' . __LINE__ . '] - IC / Passport No. already exist in other company\'s personnel list. If this personnel is working with this company, please contact Administrator to update and enable this personnel.', 32);
                }
                $personnel_id = $personnel['personnel_id'];
            } else
                $personnel_id = Class_db::getInstance()->db_insert('t_personnel', array('personnel_icNo'=>$_POST['mac_personnel_icNo'], 'personnel_citizenship'=>$_POST['mac_personnel_citizenship']));
            $document_id = !empty($_FILES['mac_consPers_document']['name']) ? $fn_upload->upload_file('1', $_FILES['mac_consPers_document'], $_POST['mac_consPers_document_name'], '12', '') : '';
            $result = Class_db::getInstance()->db_insert('t_consultant_personnel', array('personnel_id'=>$personnel_id, 'consAll_id'=>$_POST['mac_consAll_id'], 'consPers_name'=>$_POST['mac_consPers_name'], 'consPers_qualification'=>$_POST['mac_consPers_qualification'],
                'consPers_experience'=>$_POST['mac_consPers_experience'], 'consPers_certificate'=>$_POST['mac_consPers_certificate'], 'consPers_document'=>$document_id, 'consPers_workingStatus'=>$_POST['mac_consPers_workingStatus']));
        } else if ($_POST['funct'] == 'save_consultant_personnel_pems') {
            if (empty($_POST['map_consAll_id']))               throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['map_wfGroup_id']))               throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['map_consPers_name']))            throw new Exception('(ErrCode:5828) [' . __LINE__ . '] - Name of Certified Employee empty.', 32);
            if (empty($_POST['map_personnel_icNo']))           throw new Exception('(ErrCode:5849) [' . __LINE__ . '] - IC. / Passport No empty.', 32);
            if (empty($_POST['map_consPers_qualification']))   throw new Exception('(ErrCode:5829) [' . __LINE__ . '] - Academic Qualification empty.', 32);
            if (empty($_POST['map_consPers_experience']))      throw new Exception('(ErrCode:5830) [' . __LINE__ . '] - Working Experience empty.', 32);
            if (empty($_POST['map_personnel_citizenship']))    throw new Exception('(ErrCode:5850) [' . __LINE__ . '] - Citizenship empty.', 32);
            if (empty($_POST['map_consPers_workingStatus']))   throw new Exception('(ErrCode:5851) [' . __LINE__ . '] - Employee\'s Status empty.', 32);
            $personnel_id = '';
            $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_icNo'=>$_POST['map_personnel_icNo']));
            if (!empty($personnel)) {
                if (Class_db::getInstance()->db_count('t_consultant_personnel', array('personnel_id'=>$personnel['personnel_id'], 'consAll_id'=>$_POST['map_consAll_id'])) > 0)
                    throw new Exception('(ErrCode:5850) [' . __LINE__ . '] - IC / Passport No. already exist in your list.', 32);
                if ($personnel['wfGroup_id'] != $_POST['map_wfGroup_id'] && $_POST['map_consPers_workingStatus'] == '1') {
                    if ($personnel['personnel_status'] == '1' || $personnel['personnel_status'] == '4')
                        throw new Exception('(ErrCode:5851) [' . __LINE__ . '] - IC / Passport No. already exist in other company\'s personnel list. If this personnel is working with this company, please contact Administrator to update and enable this personnel.', 32);
                }
                $personnel_id = $personnel['personnel_id'];
            } else
                $personnel_id = Class_db::getInstance()->db_insert('t_personnel', array('personnel_icNo'=>$_POST['map_personnel_icNo'], 'personnel_citizenship'=>$_POST['map_personnel_citizenship']));
            $certificate = !empty($_POST['map_consPers_certificate'])?$_POST['map_consPers_certificate']:'';
            $document_id = !empty($_FILES['map_consPers_document']['name']) ? $fn_upload->upload_file('1', $_FILES['map_consPers_document'], $_POST['map_consPers_document_name'], '12', '') : '';
            $result = Class_db::getInstance()->db_insert('t_consultant_personnel', array('personnel_id'=>$personnel_id, 'consAll_id'=>$_POST['map_consAll_id'], 'consPers_name'=>$_POST['map_consPers_name'], 'consPers_qualification'=>$_POST['map_consPers_qualification'],
                'consPers_experience'=>$_POST['map_consPers_experience'], 'consPers_certificate'=>$certificate, 'consPers_document'=>$document_id, 'consPers_workingStatus'=>$_POST['map_consPers_workingStatus']));
        } else if ($_POST['funct'] == 'save_consultant_personnel_mobile') {
            if (empty($_POST['mam_consAll_id']))               throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mam_wfGroup_id']))               throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['mam_consPers_name']))            throw new Exception('(ErrCode:5828) [' . __LINE__ . '] - Name of Certified Employee empty.', 32);
            if (empty($_POST['mam_personnel_icNo']))           throw new Exception('(ErrCode:5849) [' . __LINE__ . '] - IC. / Passport No empty.', 32);
            if (empty($_POST['mam_consPers_qualification']))   throw new Exception('(ErrCode:5829) [' . __LINE__ . '] - Academic Qualification empty.', 32);
            if (empty($_POST['mam_consPers_experience']))      throw new Exception('(ErrCode:5830) [' . __LINE__ . '] - Working Experience empty.', 32);
            if (empty($_POST['mam_consPers_certificate']))     throw new Exception('(ErrCode:5831) [' . __LINE__ . '] - Training Certification empty.', 32);
            if (empty($_POST['mam_personnel_citizenship']))    throw new Exception('(ErrCode:5850) [' . __LINE__ . '] - Citizenship empty.', 32);
            if (empty($_POST['mam_consPers_workingStatus']))   throw new Exception('(ErrCode:5851) [' . __LINE__ . '] - Employee\'s Status empty.', 32);
            $personnel_id = '';
            $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_icNo'=>$_POST['mam_personnel_icNo']));
            if (!empty($personnel)) {
                if (Class_db::getInstance()->db_count('t_consultant_personnel', array('personnel_id'=>$personnel['personnel_id'], 'consAll_id'=>$_POST['mam_consAll_id'])) > 0)
                    throw new Exception('(ErrCode:5850) [' . __LINE__ . '] - IC / Passport No. already exist in your list.', 32);
                if ($personnel['wfGroup_id'] != $_POST['mam_wfGroup_id'] && $_POST['mam_consPers_workingStatus'] == '1') {
                    if ($personnel['personnel_status'] == '1' || $personnel['personnel_status'] == '4')
                        throw new Exception('(ErrCode:5851) [' . __LINE__ . '] - IC / Passport No. already exist in other company\'s personnel list. If this personnel is working with this company, please contact Administrator to update and enable this personnel.', 32);
                }
                $personnel_id = $personnel['personnel_id'];
            } else
                $personnel_id = Class_db::getInstance()->db_insert('t_personnel', array('personnel_icNo'=>$_POST['mam_personnel_icNo'], 'personnel_citizenship'=>$_POST['mam_personnel_citizenship']));
            $document_id = !empty($_FILES['mam_consPers_document']['name']) ? $fn_upload->upload_file('1', $_FILES['mam_consPers_document'], $_POST['mam_consPers_document_name'], '12', '') : '';
            $result = Class_db::getInstance()->db_insert('t_consultant_personnel', array('personnel_id'=>$personnel_id, 'consAll_id'=>$_POST['mam_consAll_id'], 'consPers_name'=>$_POST['mam_consPers_name'], 'consPers_qualification'=>$_POST['mam_consPers_qualification'],
                'consPers_experience'=>$_POST['mam_consPers_experience'], 'consPers_certificate'=>$_POST['mam_consPers_certificate'], 'consPers_document'=>$document_id, 'consPers_workingStatus'=>$_POST['mam_consPers_workingStatus']));
        } else if ($_POST['funct'] == 'delete_consultant_personnel') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consPers_id']))  throw new Exception('(ErrCode:5832) [' . __LINE__ . '] - Parameter consPers_id empty.');
            if (empty($arrayParam['wfGroup_id']))   throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            $consultant_personnel = Class_db::getInstance()->db_select_single('t_consultant_personnel', array('consPers_id'=>$arrayParam['consPers_id']), NULL, 1);
            Class_db::getInstance()->db_delete('t_consultant_personnel', array('consPers_id'=>$arrayParam['consPers_id']));
            $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_id'=>$consultant_personnel['personnel_id']), NULL, 1);
            if ($personnel['personnel_status'] == '2' || $personnel['personnel_status'] == '4') {
                if (Class_db::getInstance()->db_count('t_consultant_personnel', array('personnel_id'=>$personnel['personnel_id'])) == 0)
                    Class_db::getInstance()->db_delete('t_personnel', array('personnel_icNo'=>$personnel['personnel_icNo']));
                else if ($personnel['personnel_status'] == '4') {
                    if (Class_db::getInstance()->db_count('t_consultant_personnel', array('personnel_id'=>$personnel['personnel_id'], 'consPers_status'=>'(1,4)')) == 0) {
                        if (Class_db::getInstance()->db_count('t_consultant_personnel', array('personnel_id'=>$personnel['personnel_id'], 'consPers_status'=>'(2,23)')) > 0)
                            Class_db::getInstance()->db_update('t_personnel', array('personnel_status'=>'2', 'wfGroup_id'=>'NULL'), array('personnel_icNo'=>$personnel['personnel_icNo']));
                    }
                }
            }
            $result = '1';
        } else if ($_POST['funct'] == 'check_consultant_personnel') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consAll_id']))   throw new Exception('(ErrCode:5817) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($arrayParam['wfGroup_id']))   throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            $arr_consultant_personnel = Class_db::getInstance()->db_select('t_consultant_personnel', array('consAll_id'=>$arrayParam['consAll_id']), NULL, NULL, 1);
            foreach ($arr_consultant_personnel as $consultant_personnel) {
                if ($consultant_personnel['consPers_workingStatus'] == '1') {
                    $personnel = Class_db::getInstance()->db_select_single('t_personnel', array('personnel_id'=>$consultant_personnel['personnel_id']), NULL, 1);
                    if ($personnel['wfGroup_id'] != $arrayParam['wfGroup_id'] && ($personnel['personnel_status'] == '1' || $personnel['personnel_status'] == '4'))
                        throw new Exception('(ErrCode:5852) [' . __LINE__ . '] - The personnel listed with IC / Passport No. '.$personnel['personnel_icNo'].' already being used by another company. Please make sure the information is correct or contact administrator if the personnel belong to your company.', 32);
                }
            }
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_project') {
            if (empty($_POST['mac_consultant_id']))            throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consultant_id empty.');
            if (empty($_POST['mac_consProject_title']))        throw new Exception('(ErrCode:5832) [' . __LINE__ . '] - Project Title empty.', 32);
            if (empty($_POST['mac_consProject_year']))         throw new Exception('(ErrCode:5833) [' . __LINE__ . '] - Year empty.', 32);
            if (empty($_POST['mac_consProject_client']))       throw new Exception('(ErrCode:5834) [' . __LINE__ . '] - Client empty.', 32);
            if (empty($_POST['mac_consProject_desc']))         throw new Exception('(ErrCode:5835) [' . __LINE__ . '] - Project Description empty.', 32);
            if (empty($_POST['mac_consProject_scope']))        throw new Exception('(ErrCode:5836) [' . __LINE__ . '] - Scope of Work empty.', 32);
            if (empty($_POST['mac_consProject_value']))        throw new Exception('(ErrCode:5838) [' . __LINE__ . '] - Project Value empty.', 32);
            $result = Class_db::getInstance()->db_insert('t_consultant_project', array('consultant_id'=>$_POST['mac_consultant_id'], 'consProject_title'=>$_POST['mac_consProject_title'], 'consProject_year'=>$_POST['mac_consProject_year'],
                'consProject_client'=>$_POST['mac_consProject_client'], 'consProject_desc'=>$_POST['mac_consProject_desc'], 'consProject_scope'=>$_POST['mac_consProject_scope'], 'consProject_value'=>$_POST['mac_consProject_value']));
        } else if ($_POST['funct'] == 'save_consultant_project_pems') {
            if (empty($_POST['map_consultant_id']))            throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consultant_id empty.');
            if (empty($_POST['map_consProject_title']))        throw new Exception('(ErrCode:5832) [' . __LINE__ . '] - Project Title empty.', 32);
            if (empty($_POST['map_consProject_year']))         throw new Exception('(ErrCode:5833) [' . __LINE__ . '] - Year empty.', 32);
            if (empty($_POST['map_consProject_client']))       throw new Exception('(ErrCode:5834) [' . __LINE__ . '] - Client empty.', 32);
            if (empty($_POST['map_consProject_desc']))         throw new Exception('(ErrCode:5835) [' . __LINE__ . '] - Project Description empty.', 32);
            if (empty($_POST['map_consProject_scope']))        throw new Exception('(ErrCode:5836) [' . __LINE__ . '] - Scope of Work empty.', 32);
            if (empty($_POST['map_consProject_value']))        throw new Exception('(ErrCode:5838) [' . __LINE__ . '] - Project Value empty.', 32);
            $result = Class_db::getInstance()->db_insert('t_consultant_project', array('consultant_id'=>$_POST['map_consultant_id'], 'consProject_title'=>$_POST['map_consProject_title'], 'consProject_year'=>$_POST['map_consProject_year'],
                'consProject_client'=>$_POST['map_consProject_client'], 'consProject_desc'=>$_POST['map_consProject_desc'], 'consProject_scope'=>$_POST['map_consProject_scope'], 'consProject_value'=>$_POST['map_consProject_value']));
        } else if ($_POST['funct'] == 'save_consultant_project_mobile') {
            if (empty($_POST['mam_consultant_id']))            throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consultant_id empty.');
            if (empty($_POST['mam_consProject_title']))        throw new Exception('(ErrCode:5832) [' . __LINE__ . '] - Project Title empty.', 32);
            if (empty($_POST['mam_consProject_year']))         throw new Exception('(ErrCode:5833) [' . __LINE__ . '] - Year empty.', 32);
            if (empty($_POST['mam_consProject_client']))       throw new Exception('(ErrCode:5834) [' . __LINE__ . '] - Client empty.', 32);
            if (empty($_POST['mam_consProject_desc']))         throw new Exception('(ErrCode:5835) [' . __LINE__ . '] - Project Description empty.', 32);
            if (empty($_POST['mam_consProject_scope']))        throw new Exception('(ErrCode:5836) [' . __LINE__ . '] - Scope of Work empty.', 32);
            if (empty($_POST['mam_consProject_value']))        throw new Exception('(ErrCode:5838) [' . __LINE__ . '] - Project Value empty.', 32);
            $result = Class_db::getInstance()->db_insert('t_consultant_project', array('consultant_id'=>$_POST['mam_consultant_id'], 'consProject_title'=>$_POST['mam_consProject_title'], 'consProject_year'=>$_POST['mam_consProject_year'],
                'consProject_client'=>$_POST['mam_consProject_client'], 'consProject_desc'=>$_POST['mam_consProject_desc'], 'consProject_scope'=>$_POST['mam_consProject_scope'], 'consProject_value'=>$_POST['mam_consProject_value']));
        } else if ($_POST['funct'] == 'delete_consultant_project') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consProject_id']))   throw new Exception('(ErrCode:5839) [' . __LINE__ . '] - Parameter consProject_id empty.');
            Class_db::getInstance()->db_delete('t_consultant_project', array('consProject_id'=>$arrayParam['consProject_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'check_consultant_active') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfGroup_id']))   throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            $wf_group = Class_db::getInstance()->db_select_single('wf_group', array('wfGroup_id'=>$arrayParam['wfGroup_id']), NULL, 1);
            if (Class_db::getInstance()->db_count('vw_wfGroup_consultant', array('wfGroup_regNo'=>$wf_group['wfGroup_regNo'], 'wfGroup_id'=>'<>'.$wf_group['wfGroup_id'])) > 0)
                throw new Exception('(ErrCode:5854) [' . __LINE__ . '] - This company has already activated by other user based on Company Registration No. Please reject if true or deactivate other company if want to proceed with this application.', 32);
            $result = '1';
        } else if ($_POST['funct'] == 'check_industrial_active') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['industrial_id']))    throw new Exception('(ErrCode:5843) [' . __LINE__ . '] - Parameter industrial_id empty.');
            $industrial = Class_db::getInstance()->db_select_single('t_industrial', array('industrial_id'=>$arrayParam['industrial_id']), NULL, 1);
            if (Class_db::getInstance()->db_count('t_industrial', array('industrial_jasFileNo'=>'(\''.$industrial['industrial_jasFileNo'].'\')', 'industrial_id'=>'<>'.$industrial['industrial_id'])) > 0)
                throw new Exception('(ErrCode:5855) [' . __LINE__ . '] - This premise has already activated by other user based on JAS File No. Please reject if true or deactivate other premise if want to proceed with this application.', 32);
            $result = '1';
        } else if ($_POST['funct'] == 'save_task_action' || $_POST['funct'] == 'submit_task_action') {
            if (empty($_POST['maw_wfTask_id']))        throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['maw_wfTaskType_id']))    throw new Exception('(ErrCode:5812) [' . __LINE__ . '] - Parameter wfTaskType_id empty.');
            if (empty($_POST['maw_wfTrans_id']))       throw new Exception('(ErrCode:5840) [' . __LINE__ . '] - Parameter wfTrans_id empty.');
            $wf_task_type = Class_db::getInstance()->db_select_single('wf_task_type', array('wfTaskType_id'=>$_POST['maw_wfTaskType_id']), NULL, 1);
            if ($_POST['funct'] == 'submit_task_action' && !empty($_POST['maw_result']) && $_POST['maw_result'] != '11' && $_POST['maw_result'] != '26') {
                if (in_array($wf_task_type['wfFlow_id'], array('1', '2', '3'))) {
                    $wf_group = Class_db::getInstance()->db_select_single('vw_wfGroup_consultant', array('wfTrans_id'=>$_POST['maw_wfTrans_id']), NULL, 1);
                    if (Class_db::getInstance()->db_count('vw_wfGroup_consultant', array('wfGroup_regNo'=>$wf_group['wfGroup_regNo'], 'wfGroup_id'=>'<>'.$wf_group['wfGroup_id'])) > 0)
                        throw new Exception('(ErrCode:5854) [' . __LINE__ . '] - This company has already activated by other user based on Company Registration No. Please reject if true or deactivate other company if want to proceed with this application.', 32);
                } else if (in_array($wf_task_type['wfFlow_id'], array('4', '5'))) {
                    $industrial_id = Class_db::getInstance()->db_select_col('t_industrial_all', array('wfTrans_id'=>$_POST['maw_wfTrans_id']), 'industrial_id', NULL, 1);
                    $industrial = Class_db::getInstance()->db_select_single('t_industrial', array('industrial_id'=>$industrial_id), NULL, 1);
                    if (Class_db::getInstance()->db_count('t_industrial', array('industrial_jasFileNo'=>'(\''.$industrial['industrial_jasFileNo'].'\')', 'industrial_id'=>'<>'.$industrial_id)) > 0)
                        throw new Exception('(ErrCode:5855) [' . __LINE__ . '] - This premise has already activated by other user based on JAS File No. Please reject if true or deactivate other premise if want to proceed with this application.', 32);
                }
            }
            $wfTask_status = '';
            if (in_array($_POST['maw_wfTaskType_id'], array('2', '12', '22', '32', '42'))) {
                if (empty($_POST['maw_assign_to']) && $_POST['funct'] == 'submit_task_action')  throw new Exception('(ErrCode:5842) [' . __LINE__ . '] - Parameter maw_assign_to empty.');
                $assign_to = (!empty($_POST['maw_assign_to'])) ? $_POST['maw_assign_to'] : '';
                $current_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$_POST['maw_wfTask_id']), NULL, 1);
                $arr_task_assign_where = Class_db::getInstance()->db_select('wf_task_assign_where', array('wfTaskType_From'=>$_POST['maw_wfTaskType_id'], 'uType_id'=>'3'), NULL, NULL, 1);
                foreach ($arr_task_assign_where as $task_assign_where) {
                    if ($task_assign_where['wfTaskAssignWhere_isUser'] == 'S') {
                        if (Class_db::getInstance()->db_count('wf_task_assign', array('wfTrans_id'=>$_POST['maw_wfTrans_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To'], 'wfTaskAssign_from'=>$_POST['maw_wfTask_id']))==0) {
                            Class_db::getInstance()->db_insert('wf_task_assign', array('wfTrans_id'=>$_POST['maw_wfTrans_id'], 'wfTaskAssign_from'=>$_POST['maw_wfTask_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To'], 'wfGroup_id'=>$current_task['wfGroup_id'], 'user_id'=>$assign_to));
                        } else {
                            Class_db::getInstance()->db_update('wf_task_assign', array('wfGroup_id'=>$current_task['wfGroup_id'], 'user_id'=>$assign_to), array('wfTrans_id'=>$_POST['maw_wfTrans_id'], 'wfTaskAssign_from'=>$_POST['maw_wfTask_id'], 'wfTaskType_id'=>$task_assign_where['wfTaskType_To']));
                        }
                    } else
                        throw new Exception('(ErrCode:5841) [' . __LINE__ . '] - Value wfTaskAssignWhere_isUser is not equal to S.');
                }
                Class_db::getInstance()->db_update('wf_transaction', array('wfTrans_processOfficer'=>$assign_to), array('wfTrans_id'=>$_POST['maw_wfTrans_id']));
                $wfTask_status = '15';
            }
            $arr_set['wfTask_remark'] = (!empty($_POST['maw_wfTask_remark'])) ? $_POST['maw_wfTask_remark'] : '';
            if ($_POST['funct'] == 'save_task_action')
                $arr_set['wfTask_statusSave'] = $wfTask_status == '' ? (empty($_POST['maw_result'])?'':$_POST['maw_result']) : $wfTask_status;
            Class_db::getInstance()->db_update('wf_task', $arr_set, array('wfTask_id'=>$_POST['maw_wfTask_id']));
            $arr_set2['wfTrans_hardCopy'] = (empty($_POST['maw_wfTrans_hardCopy'])?'':$_POST['maw_wfTrans_hardCopy']);
            $arr_set2['wfTrans_hardCopy_receiver'] = (!empty($_POST['maw_wfTrans_hardCopy_receiver'])) ? $_POST['maw_wfTrans_hardCopy_receiver'] : '';
            $arr_set2['wfTrans_hardCopy_remark'] = (!empty($_POST['maw_snote_hardCopy_remark'])) ? $_POST['maw_snote_hardCopy_remark'] : '';
            Class_db::getInstance()->db_update('wf_transaction', $arr_set2, array('wfTrans_id'=>$_POST['maw_wfTrans_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'update_industrial') {
            if (empty($_POST['iin_user_id']))               throw new Exception('(ErrCode:5801) [' . __LINE__ . '] - Parameter user_id empty.');
            if (empty($_POST['iin_wfGroup_id']))            throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            $wf_group = Class_db::getInstance()->db_select_single('wf_group', array('wfGroup_id'=>$_POST['iin_wfGroup_id']), NULL, 1);
            $wf_group_profile = Class_db::getInstance()->db_select_single('wf_group_profile', array('wfGroupProfile_id'=>$wf_group['wfGroupProfile_id']), NULL, 1);
            $address_main = Class_db::getInstance()->db_select_single('address', array('address_id'=>$wf_group_profile['wfGroup_address']), NULL, 1);
            $same_address = empty($_POST['iin_same_address']) ? '' : $_POST['iin_same_address'];
            $mail_address_line1 = '';
            $mail_address_postcode = '';
            $mail_city_id = '';
            if ($same_address == '1') {
                $mail_address_line1 = $address_main['address_line1'];
                $mail_address_postcode = $address_main['address_postcode'];
                $mail_city_id = $address_main['city_id'];
            } else {
                if (empty($_POST['iin_maddress_line1']))        throw new Exception('(ErrCode:5806) [' . __LINE__ . '] - Field Mail Address empty.', 32);
                if (empty($_POST['iin_maddress_postcode']))     throw new Exception('(ErrCode:5807) [' . __LINE__ . '] - Field Mail Postcode empty.', 32);
                if (empty($_POST['iin_mcity_id']))              throw new Exception('(ErrCode:5808) [' . __LINE__ . '] - Field Mail City empty.', 32);
                $mail_address_line1 = $_POST['iin_maddress_line1'];
                $mail_address_postcode = $_POST['iin_maddress_postcode'];
                $mail_city_id = $_POST['iin_mcity_id'];
            }
            Class_db::getInstance()->db_update('address', array('address_line1'=>$mail_address_line1, 'address_postcode'=>$mail_address_postcode, 'city_id'=>$mail_city_id), array('address_id'=>$wf_group_profile['wfGroup_address_mail']));
            Class_db::getInstance()->db_update('t_industrial', array('subSic_id'=>$_POST['iin_subSic_id'], 'parlimen_id'=>$_POST['iin_parlimen_id'], 'industrial_totalStack'=>$_POST['iin_industrial_totalStack']), array('industrial_id'=>$_POST['iin_industrial_id']));
            Class_db::getInstance()->db_update('wf_group_profile', array('wfGroupProfile_status'=>'3', 'wfGroupProfile_timeEnd'=>'Now()'), array('wfGroupProfile_id'=>$wf_group['wfGroupProfile_id']));
            $wfGroupProfile_id = Class_db::getInstance()->db_insert('wf_group_profile', array('wfGroup_address'=>$wf_group_profile['wfGroup_address'], 'wfGroup_address_mail'=>$wf_group_profile['wfGroup_address_mail'], 'wfGroup_phoneNo'=>$_POST['iin_wfGroup_phoneNo'],
                'wfGroup_faxNo'=>$_POST['iin_wfGroup_faxNo'], 'wfGroup_id'=>$wf_group['wfGroup_id'], 'wfGroupProfile_createdBy'=>$_POST['iin_user_id'], 'wfGroup_address_same'=>$same_address));
            Class_db::getInstance()->db_update('wf_group', array('wfGroupProfile_id'=>$wfGroupProfile_id, 'wfGroup_isFirstTime'=>'0'), array('wfGroup_id'=>$wf_group['wfGroup_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_process_checking') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfTask_id']))        throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($arrayParam['wfFlow_id']))        throw new Exception('(ErrCode:5813) [' . __LINE__ . '] - Parameter wfFlow_id empty.');
            $arr_checklist = Class_db::getInstance()->db_select('t_checklist', array('wfFlow_id'=>$arrayParam['wfFlow_id']), NULL, NULL, 1);
            foreach ($arr_checklist as $checklist) {
                if (isset($arrayParam['check_pass_'.$checklist['checklist_id']]) && isset($arrayParam['check_remark_'.$checklist['checklist_id']]))
                    Class_db::getInstance()->db_update('t_checklist_task', array('checklistTask_result'=>$arrayParam['check_pass_'.$checklist['checklist_id']], 'checklistTask_remark'=>$arrayParam['check_remark_'.$checklist['checklist_id']]), array('wfTask_id'=>$arrayParam['wfTask_id'], 'checklist_id'=>$checklist['checklist_id']));
            }
            $result = '1';
        } else if ($_POST['funct'] == 'create_installation') {
            if (empty($_POST['param']))                throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['wfGroup_id']))      throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($arrayParam['wfTaskType_id']))   throw new Exception('(ErrCode:5812) [' . __LINE__ . '] - Parameter wfTaskType_id empty.');
            if (empty($arrayParam['wfFlow_id']))       throw new Exception('(ErrCode:5813) [' . __LINE__ . '] - Parameter wfFlow_id empty.');
            if (empty($arrayParam['indAll_type']))     throw new Exception('(ErrCode:5858) [' . __LINE__ . '] - Parameter indAll_type empty.');
            $wfTask_id = $fn_task->task_create($_SESSION['user_id'], $arrayParam['wfFlow_id'], $arrayParam['wfGroup_id'], $arrayParam['wfTaskType_id']);
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            $wfGroupProfile_id = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$arrayParam['wfGroup_id']), 'wfGroupProfile_id', NULL, 1);
            $industrial_id = Class_db::getInstance()->db_select_col('t_industrial', array('wfGroup_id'=>$arrayParam['wfGroup_id']), 'industrial_id', NULL, 1);
            $indAll_id = Class_db::getInstance()->db_insert('t_industrial_all', array('industrial_id'=>$industrial_id, 'wfTrans_id'=>$wfTrans_id, 'indAll_type'=>$arrayParam['indAll_type'], 'wfGroupProfile_id'=>$wfGroupProfile_id, 'indAll_contactPerson'=>$_SESSION['user_id'], 'indAll_createdBy'=>$_SESSION['user_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_refName'=>'indAll_id', 'wfTask_refValue'=>$indAll_id), array('wfTask_id'=>$wfTask_id));
            if ($arrayParam['wfFlow_id'] == '5') {
                Class_db::getInstance()->db_insert('t_industrial_pollution', array('indAll_id'=>$indAll_id, 'pollutionMonitored_id'=>'1'));
            }
            $result = $indAll_id;
        } else if ($_POST['funct'] == 'save_installation_cems') {
            if (empty($_POST['mce_wfGroup_id']))        throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['mce_industrial_id']))     throw new Exception('(ErrCode:5843) [' . __LINE__ . '] - Parameter mce_industrial_id empty.');
            if (empty($_POST['mce_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mce_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_indAll_installType']))    throw new Exception('(ErrCode:58xx) [' . __LINE__ . '] - Please select Type of Installation.', 32);
            $arr_indReason = Class_db::getInstance()->db_select_colm ('t_industrial_reason', array('indAll_id'=>$_POST['mce_indAll_id']), 'indReason_id');
            $arrPost_indReason = (!empty($_POST['mce_indReason_id'])) ? $_POST['mce_indReason_id'] : array();
            if ($arr_indReason != $arrPost_indReason) {
                $arrDiff_indReason1 = array_diff($arrPost_indReason, $arr_indReason);
                foreach($arrDiff_indReason1 as $value) {
                    Class_db::getInstance()->db_insert('t_industrial_reason', array('indAll_id'=>$_POST['mce_indAll_id'], 'indReason_id'=>$value));
                }
                $arrDiff_indReason2 = array_diff($arr_indReason, $arrPost_indReason);
                if (count($arrDiff_indReason2) > 0) {
                    Class_db::getInstance()->db_delete('t_industrial_reason', array('indAll_id'=>$_POST['mce_indAll_id'], 'indReason_id'=>'('.  implode(',', $arrDiff_indReason2).')'));
                }
            }
            if (isset($_POST['mce_indReason_other'])) {
                Class_db::getInstance()->db_update('t_industrial_reason', array('indReason_other'=>$_POST['mce_indReason_other']), array('indAll_id'=>$_POST['mce_indAll_id'], 'indReason_id'=>'4'));
            }
            $arr_indPollution = Class_db::getInstance()->db_select_colm ('t_industrial_pollution', array('indAll_id'=>$_POST['mce_indAll_id']), 'pollutionMonitored_id');
            $arrPost_indPollution = (!empty($_POST['mce_pollutionMonitored_id'])) ? $_POST['mce_pollutionMonitored_id'] : array();
            if ($arr_indPollution != $arrPost_indPollution) {
                $arrDiff_indPollution1 = array_diff($arrPost_indPollution, $arr_indPollution);
                foreach($arrDiff_indPollution1 as $value) {
                    Class_db::getInstance()->db_insert('t_industrial_pollution', array('indAll_id'=>$_POST['mce_indAll_id'], 'pollutionMonitored_id'=>$value));
                }
                $arrDiff_indPollution2 = array_diff($arr_indPollution, $arrPost_indPollution);
                if (count($arrDiff_indPollution2) > 0) {
                    Class_db::getInstance()->db_delete('t_industrial_pollution', array('indAll_id'=>$_POST['mce_indAll_id'], 'pollutionMonitored_id'=>'('.  implode(',', $arrDiff_indPollution2).')'));
                }
            }
            $arr_indParam = Class_db::getInstance()->db_select('t_industrial_parameter', array('indAll_id'=>$_POST['mce_indAll_id']));
            foreach ($arr_indParam as $indParam) {
                if (isset($_POST['mce_indParam_concentration_'.$indParam['indParam_id']])) {
                    Class_db::getInstance()->db_update ('t_industrial_parameter', array('indParam_concentration'=>$_POST['mce_indParam_concentration_'.$indParam['indParam_id']]), array('indParam_id'=>$indParam['indParam_id']));
                }
            }
            $indAll_qaFreqDaily = (!empty($_POST['mce_indAll_qaFreqDaily'])) ? $_POST['mce_indAll_qaFreqDaily'] : '';
            $indAll_qaMethod = ($indAll_qaFreqDaily != '' && !empty($_POST['mce_indAll_qaMethod'])) ? $_POST['mce_indAll_qaMethod'] : '';
            $indAll_qaFreqQuarterly = (!empty($_POST['mce_indAll_qaFreqQuarterly'])) ? $_POST['mce_indAll_qaFreqQuarterly'] : '';
            $indAll_qaFreqYearly = (!empty($_POST['mce_indAll_qaFreqYearly'])) ? $_POST['mce_indAll_qaFreqYearly'] : '';
            if ($indAll_qaFreqQuarterly != '') {
                $arr_indQa = Class_db::getInstance()->db_select_colm ('t_industrial_quarter', array('indAll_id'=>$_POST['mce_indAll_id'], 'indQuarter_type'=>'1'), 'indQuarter_no');
                $arrPost_indQa = (!empty($_POST['mce_q_indQuarter_no'])) ? $_POST['mce_q_indQuarter_no'] : array();
                if ($arr_indQa != $arrPost_indQa) {
                    $arrDiff_indQa1 = array_diff($arrPost_indQa, $arr_indQa);
                    foreach($arrDiff_indQa1 as $value) {
                        Class_db::getInstance()->db_insert('t_industrial_quarter', array('indAll_id'=>$_POST['mce_indAll_id'], 'indQuarter_type'=>'1', 'indQuarter_no'=>$value));
                    }
                    $arrDiff_indQa2 = array_diff($arr_indQa, $arrPost_indQa);
                    if (count($arrDiff_indQa2) > 0) {
                        Class_db::getInstance()->db_delete('t_industrial_quarter', array('indAll_id'=>$_POST['mce_indAll_id'], 'indQuarter_type'=>'1', 'indQuarter_no'=>'('.  implode(',', $arrDiff_indQa2).')'));
                    }
                }
            } else {
                 Class_db::getInstance()->db_delete('t_industrial_quarter', array('indAll_id'=>$_POST['mce_indAll_id']));
            }
            Class_db::getInstance()->db_delete('t_industrial_quarter', array('indAll_id'=>$_POST['mce_indAll_id'], 'indQuarter_type'=>'2'));
            if ($indAll_qaFreqYearly != '' && !empty($_POST['mce_y_indQuarter_no']))
                Class_db::getInstance()->db_insert('t_industrial_quarter', array('indAll_id'=>$_POST['mce_indAll_id'], 'indQuarter_type'=>'2', 'indQuarter_no'=>$_POST['mce_y_indQuarter_no']));
            Class_db::getInstance()->db_update('t_industrial_all', array('indAll_installType'=>$_POST['mce_indAll_installType'], 'sourceActivity_id'=>$_POST['mce_sourceActivity_id'], 'sourceCapacity_id'=>(isset($_POST['mce_sourceCapacity_id'])?$_POST['mce_sourceCapacity_id']:''), 'fuelType_id'=>(isset($_POST['mce_fuelType_id'])?$_POST['mce_fuelType_id']:''),
                'indAll_fuelQuantity'=>$_POST['mce_indAll_fuelQuantity'], 'metalType_id'=>(isset($_POST['mce_metalType_id'])?$_POST['mce_metalType_id']:''), 'indAll_sourceCapacity'=>$_POST['mce_indAll_sourceCapacity'],
                'indAll_stackNo'=>$_POST['mce_indAll_stackNo'], 'indAll_stackHeight'=>$_POST['mce_indAll_stackHeight'], 'indAll_stackDiameter'=>$_POST['mce_indAll_stackDiameter'], 'indAll_stackLongitude'=>$_POST['mce_indAll_stackLongitude'], 'indAll_stackLatitude'=>$_POST['mce_indAll_stackLatitude'],
                'indAll_gasTemperature'=>$_POST['mce_indAll_gasTemperature'], 'indAll_airFlowRate'=>$_POST['mce_indAll_airFlowRate'], 'indAll_stackVelocity'=>$_POST['mce_indAll_stackVelocity'], 'indAll_moistureContect'=>$_POST['mce_indAll_moistureContect'],
                'indAll_pressure'=>$_POST['mce_indAll_pressure'], 'indAll_remark'=>$_POST['mce_wfTask_remark'],
                'indAll_qaFreqDaily'=>$indAll_qaFreqDaily, 'indAll_qaMethod'=>$indAll_qaMethod, 'indAll_qaFreqQuarterly'=>$indAll_qaFreqQuarterly, 'indAll_qaFreqYearly'=>$indAll_qaFreqYearly), array('indAll_id'=>$_POST['mce_indAll_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['mce_wfTask_remark']), array('wfTask_id'=>$_POST['mce_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_installation_pems') {
            if (empty($_POST['mpe_wfGroup_id']))        throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter wfGroup_id empty.');
            if (empty($_POST['mpe_industrial_id']))     throw new Exception('(ErrCode:5843) [' . __LINE__ . '] - Parameter mpe_industrial_id empty.');
            if (empty($_POST['mpe_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mpe_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mpe_indAll_installType']))    throw new Exception('(ErrCode:58xx) [' . __LINE__ . '] - Please select Type of Installation.', 32);
            $arr_indReason = Class_db::getInstance()->db_select_colm ('t_industrial_reason', array('indAll_id'=>$_POST['mpe_indAll_id']), 'indReason_id');
            $arrPost_indReason = (!empty($_POST['mpe_indReason_id'])) ? $_POST['mpe_indReason_id'] : array();
            if ($arr_indReason != $arrPost_indReason) {
                $arrDiff_indReason1 = array_diff($arrPost_indReason, $arr_indReason);
                foreach($arrDiff_indReason1 as $value) {
                    Class_db::getInstance()->db_insert('t_industrial_reason', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indReason_id'=>$value));
                }
                $arrDiff_indReason2 = array_diff($arr_indReason, $arrPost_indReason);
                if (count($arrDiff_indReason2) > 0) {
                    Class_db::getInstance()->db_delete('t_industrial_reason', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indReason_id'=>'('.  implode(',', $arrDiff_indReason2).')'));
                }
            }
            if (isset($_POST['mpe_indReason_other'])) {
                Class_db::getInstance()->db_update('t_industrial_reason', array('indReason_other'=>$_POST['mpe_indReason_other']), array('indAll_id'=>$_POST['mpe_indAll_id'], 'indReason_id'=>'4'));
            }
//            $arr_indPollution = Class_db::getInstance()->db_select_colm ('t_industrial_pollution', array('indAll_id'=>$_POST['mpe_indAll_id']), 'pollutionMonitored_id');
//            $arrPost_indPollution = (!empty($_POST['mpe_pollutionMonitored_id'])) ? $_POST['mpe_pollutionMonitored_id'] : array();
//            if ($arr_indPollution != $arrPost_indPollution) {
//                $arrDiff_indPollution1 = array_diff($arrPost_indPollution, $arr_indPollution);
//                foreach($arrDiff_indPollution1 as $value) {
//                    Class_db::getInstance()->db_insert('t_industrial_pollution', array('indAll_id'=>$_POST['mpe_indAll_id'], 'pollutionMonitored_id'=>$value));
//                }
//                $arrDiff_indPollution2 = array_diff($arr_indPollution, $arrPost_indPollution);
//                if (count($arrDiff_indPollution2) > 0) {
//                    Class_db::getInstance()->db_delete('t_industrial_pollution', array('indAll_id'=>$_POST['mpe_indAll_id'], 'pollutionMonitored_id'=>'('.  implode(',', $arrDiff_indPollution2).')'));
//                }
//            }
            $arr_indParam = Class_db::getInstance()->db_select('t_industrial_parameter', array('indAll_id'=>$_POST['mpe_indAll_id']));
            foreach ($arr_indParam as $indParam) {
                if (isset($_POST['mpe_indParam_concentration_'.$indParam['indParam_id']])) {
                    Class_db::getInstance()->db_update ('t_industrial_parameter', array('indParam_concentration'=>$_POST['mpe_indParam_concentration_'.$indParam['indParam_id']]), array('indParam_id'=>$indParam['indParam_id']));
                }
            }
            $arr_pemsInput = Class_db::getInstance()->db_select('dt_pems_reading', array(), '', '', 0, array('indAll_id'=>$_POST['mpe_indAll_id'], 'wfTask_id'=>$_POST['mpe_wfTask_id']));
            foreach ($arr_pemsInput as $pemsInput) {
                if (isset($_POST['mpe_low_min_'.$pemsInput['pemsInput_id']]) && isset($_POST['mpe_low_max_'.$pemsInput['pemsInput_id']]) && isset($_POST['mpe_low_weight_'.$pemsInput['pemsInput_id']])) {
                    Class_db::getInstance()->db_update ('t_pems_reading', array('pemsReading_min'=>$_POST['mpe_low_min_'.$pemsInput['pemsInput_id']], 'pemsReading_max'=>$_POST['mpe_low_max_'.$pemsInput['pemsInput_id']], 'pemsReading_weight'=>$_POST['mpe_low_weight_'.$pemsInput['pemsInput_id']]),
                        array('pemsInput_id'=>$pemsInput['pemsInput_id'], 'pemsReading_type'=>'1', 'wfTask_id'=>$_POST['mpe_wfTask_id']));
                }
                if (isset($_POST['mpe_normal_min_'.$pemsInput['pemsInput_id']]) && isset($_POST['mpe_normal_max_'.$pemsInput['pemsInput_id']]) && isset($_POST['mpe_normal_weight_'.$pemsInput['pemsInput_id']])) {
                    Class_db::getInstance()->db_update ('t_pems_reading', array('pemsReading_min'=>$_POST['mpe_normal_min_'.$pemsInput['pemsInput_id']], 'pemsReading_max'=>$_POST['mpe_normal_max_'.$pemsInput['pemsInput_id']], 'pemsReading_weight'=>$_POST['mpe_normal_weight_'.$pemsInput['pemsInput_id']]),
                        array('pemsInput_id'=>$pemsInput['pemsInput_id'], 'pemsReading_type'=>'2', 'wfTask_id'=>$_POST['mpe_wfTask_id']));
                }
                if (isset($_POST['mpe_high_min_'.$pemsInput['pemsInput_id']]) && isset($_POST['mpe_high_max_'.$pemsInput['pemsInput_id']]) && isset($_POST['mpe_high_weight_'.$pemsInput['pemsInput_id']])) {
                    Class_db::getInstance()->db_update ('t_pems_reading', array('pemsReading_min'=>$_POST['mpe_high_min_'.$pemsInput['pemsInput_id']], 'pemsReading_max'=>$_POST['mpe_high_max_'.$pemsInput['pemsInput_id']], 'pemsReading_weight'=>$_POST['mpe_high_weight_'.$pemsInput['pemsInput_id']]),
                        array('pemsInput_id'=>$pemsInput['pemsInput_id'], 'pemsReading_type'=>'3', 'wfTask_id'=>$_POST['mpe_wfTask_id']));
                }
            }
            $indAll_qaFreqDaily = (!empty($_POST['mpe_indAll_qaFreqDaily'])) ? $_POST['mpe_indAll_qaFreqDaily'] : '';
            $indAll_qaMethod = ($indAll_qaFreqDaily != '' && !empty($_POST['mpe_indAll_qaMethod'])) ? $_POST['mpe_indAll_qaMethod'] : '';
            $indAll_qaFreqQuarterly = (!empty($_POST['mpe_indAll_qaFreqQuarterly'])) ? $_POST['mpe_indAll_qaFreqQuarterly'] : '';
            $indAll_qaFreqYearly = (!empty($_POST['mpe_indAll_qaFreqYearly'])) ? $_POST['mpe_indAll_qaFreqYearly'] : '';
            if ($indAll_qaFreqQuarterly != '') {
                $arr_indQa = Class_db::getInstance()->db_select_colm ('t_industrial_quarter', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indQuarter_type'=>'1'), 'indQuarter_no');
                $arrPost_indQa = (!empty($_POST['mpe_q_indQuarter_no'])) ? $_POST['mpe_q_indQuarter_no'] : array();
                if ($arr_indQa != $arrPost_indQa) {
                    $arrDiff_indQa1 = array_diff($arrPost_indQa, $arr_indQa);
                    foreach($arrDiff_indQa1 as $value) {
                        Class_db::getInstance()->db_insert('t_industrial_quarter', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indQuarter_type'=>'1', 'indQuarter_no'=>$value));
                    }
                    $arrDiff_indQa2 = array_diff($arr_indQa, $arrPost_indQa);
                    if (count($arrDiff_indQa2) > 0) {
                        Class_db::getInstance()->db_delete('t_industrial_quarter', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indQuarter_type'=>'1', 'indQuarter_no'=>'('.  implode(',', $arrDiff_indQa2).')'));
                    }
                }
            } else {
                 Class_db::getInstance()->db_delete('t_industrial_quarter', array('indAll_id'=>$_POST['mpe_indAll_id']));
            }
            Class_db::getInstance()->db_delete('t_industrial_quarter', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indQuarter_type'=>'2'));
            if ($indAll_qaFreqYearly != '' && !empty($_POST['mpe_y_indQuarter_no']))
                Class_db::getInstance()->db_insert('t_industrial_quarter', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indQuarter_type'=>'2', 'indQuarter_no'=>$_POST['mpe_y_indQuarter_no']));
            Class_db::getInstance()->db_update('t_industrial_all', array('indAll_installType'=>$_POST['mpe_indAll_installType'], 'sourceActivity_id'=>$_POST['mpe_sourceActivity_id'], 'sourceCapacity_id'=>(isset($_POST['mpe_sourceCapacity_id'])?$_POST['mpe_sourceCapacity_id']:''), 'fuelType_id'=>(isset($_POST['mpe_fuelType_id'])?$_POST['mpe_fuelType_id']:''),
                'indAll_fuelQuantity'=>$_POST['mpe_indAll_fuelQuantity'], 'metalType_id'=>(isset($_POST['mpe_metalType_id'])?$_POST['mpe_metalType_id']:''), 'indAll_sourceCapacity'=>$_POST['mpe_indAll_sourceCapacity'],
                'indAll_stackNo'=>$_POST['mpe_indAll_stackNo'], 'indAll_stackHeight'=>$_POST['mpe_indAll_stackHeight'], 'indAll_stackDiameter'=>$_POST['mpe_indAll_stackDiameter'], 'indAll_stackLongitude'=>$_POST['mpe_indAll_stackLongitude'], 'indAll_stackLatitude'=>$_POST['mpe_indAll_stackLatitude'],
                'indAll_gasTemperature'=>$_POST['mpe_indAll_gasTemperature'], 'indAll_airFlowRate'=>$_POST['mpe_indAll_airFlowRate'], 'indAll_stackVelocity'=>$_POST['mpe_indAll_stackVelocity'], 'indAll_moistureContect'=>$_POST['mpe_indAll_moistureContect'],
                'indAll_pressure'=>$_POST['mpe_indAll_pressure'], 'consultant_id'=>$_POST['mpe_consultant_id'], 'consAll_id'=>(isset($_POST['mpe_consAll_id'])?$_POST['mpe_consAll_id']:''), 'indAll_remark'=>$_POST['mpe_wfTask_remark'],
                'indAll_qaFreqDaily'=>$indAll_qaFreqDaily, 'indAll_qaMethod'=>$indAll_qaMethod, 'indAll_qaFreqQuarterly'=>$indAll_qaFreqQuarterly, 'indAll_qaFreqYearly'=>$indAll_qaFreqYearly), array('indAll_id'=>$_POST['mpe_indAll_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['mpe_wfTask_remark']), array('wfTask_id'=>$_POST['mpe_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'insert_industrial_parameter') {
            if (empty($_POST['param']))                     throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indAll_id']))            throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');

            $arr_indPollution = Class_db::getInstance()->db_select_colm ('t_industrial_pollution', array('indAll_id'=>$arrayParam['indAll_id']), 'pollutionMonitored_id');
            $arrPost_indPollution = (!empty($arrayParam['pollutions'])) ? $arrayParam['pollutions'] : array();
            if ($arr_indPollution != $arrPost_indPollution) {
                $arrDiff_indPollution1 = array_diff($arrPost_indPollution, $arr_indPollution);
                foreach($arrDiff_indPollution1 as $value) {
                    Class_db::getInstance()->db_insert('t_industrial_pollution', array('indAll_id'=>$arrayParam['indAll_id'], 'pollutionMonitored_id'=>$value));
                }
                $arrDiff_indPollution2 = array_diff($arr_indPollution, $arrPost_indPollution);
                if (count($arrDiff_indPollution2) > 0) {
                    Class_db::getInstance()->db_delete('t_industrial_pollution', array('indAll_id'=>$arrayParam['indAll_id'], 'pollutionMonitored_id'=>'('.  implode(',', $arrDiff_indPollution2).')'));
                }
            }
            Class_db::getInstance()->db_delete('t_industrial_parameter', array('indAll_id'=>$arrayParam['indAll_id']));
            Class_db::getInstance()->db_delete('t_industrial_exclude', array('indAll_id'=>$arrayParam['indAll_id']));
            $results = '1';
            if (!empty($arrayParam['sourceCapacity_id']) && !empty($arrPost_indPollution)) {
                if ($arrayParam['sourceCapacity_id'] == '1' || $arrayParam['sourceCapacity_id'] == '2') {
                    if (!empty($arrayParam['fuelType_id'])) {
                        $arr_pub = Class_db::getInstance()->db_select('t_pub', array('sourceCapacity_id'=>$arrayParam['sourceCapacity_id'], 'fuelType_id'=>$arrayParam['fuelType_id'], 'pub_status'=>'1'));
                        foreach($arr_pub as $pub) {
                            if (Class_db::getInstance()->db_count('t_input_parameter', array('inputParam_id'=>$pub['inputParam_id'], 'inputParam_type'=>'('.  implode(',', $arrPost_indPollution).')')) > 0) {
                                Class_db::getInstance()->db_insert('t_industrial_parameter', array('indAll_id'=>$arrayParam['indAll_id'], 'pub_id'=>$pub['pub_id'], 'indParam_limitValue'=>$pub['pub_limitValue']));
                            }
                        }
                        $results = '2';
                    }
                } else {
                    $arr_pub = Class_db::getInstance()->db_select('t_pub', array('sourceCapacity_id'=>$arrayParam['sourceCapacity_id'], 'pub_status'=>'1'));
                    foreach($arr_pub as $pub) {
                        if (Class_db::getInstance()->db_count('t_input_parameter', array('inputParam_id'=>$pub['inputParam_id'], 'inputParam_type'=>'('.  implode(',', $arrPost_indPollution).')')) > 0) {
                            Class_db::getInstance()->db_insert('t_industrial_parameter', array('indAll_id'=>$arrayParam['indAll_id'], 'pub_id'=>$pub['pub_id'], 'indParam_limitValue'=>$pub['pub_limitValue']));
                        }
                    }
                    $results = '2';
                }
            }
            Class_db::getInstance()->db_update('t_industrial_all', array('sourceActivity_id'=>$arrayParam['sourceActivity_id'], 'sourceCapacity_id'=>$arrayParam['sourceCapacity_id'], 'fuelType_id'=>$arrayParam['fuelType_id']),
                array('indAll_id'=>$arrayParam['indAll_id']));
            $result = $results;
        } else if ($_POST['funct'] == 'save_industrial_exclude') {
            if (empty($_POST['mce_indAll_id']))             throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_exclude_param_id']))      throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Field Parameter to be Excluded empty.', 32);
            if (empty($_POST['mce_exclude_reason']))        throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Field Reason empty.', 32);
            if (Class_db::getInstance()->db_count('t_industrial_exclude', array('indAll_id'=>$_POST['mce_indAll_id'], 'pub_id'=>$_POST['mce_indAll_id'])) > 0) {
                throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter already been excluded.', 32);
            }
            $document_id = !empty($_FILES['mce_file_exclude']['name']) ? $fn_upload->upload_file('1', $_FILES['mce_file_exclude'], 'Supportive Document for Excluded Parameter', '41', $_POST['mce_exclude_reason']) : '';
            $inputParam_id = Class_db::getInstance()->db_select_col('t_pub', array('pub_id'=>$_POST['mce_exclude_param_id']), 'inputParam_id', NULL, 1);
            Class_db::getInstance()->db_delete('t_industrial_parameter', array('indAll_id'=>$_POST['mce_indAll_id'], 'pub_id'=>$_POST['mce_exclude_param_id']));
            $result = Class_db::getInstance()->db_insert('t_industrial_exclude', array('indAll_id'=>$_POST['mce_indAll_id'], 'inputParam_id'=>$inputParam_id, 'pub_id'=>$_POST['mce_exclude_param_id'], 'indExclude_reason'=>$_POST['mce_exclude_reason'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'save_industrial_written_cems') {
            if (empty($_POST['mce_indAll_id']))                 throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_written_type']))              throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            if (empty($_POST['mce_indWritten_equipmentName']))  throw new Exception('(ErrCode:5889) [' . __LINE__ . '] - Field Equipment Name empty.', 32);
            if (empty($_POST['mce_indWritten_referenceNo']))    throw new Exception('(ErrCode:5861) [' . __LINE__ . '] - Field Reference No. empty.', 32);
            if (empty($_POST['mce_indWritten_dateReference']))  throw new Exception('(ErrCode:5862) [' . __LINE__ . '] - Field Reference Date empty.', 32);
            $document_id = !empty($_FILES['mce_file_written']['name']) ? $fn_upload->upload_file('1', $_FILES['mce_file_written'], $_POST['mce_file_written_name'], $_POST['mce_written_type'], '') : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_written', array('indAll_id'=>$_POST['mce_indAll_id'], 'documentName_id'=>$_POST['mce_written_type'], 'indWritten_referenceNo'=>$_POST['mce_indWritten_referenceNo'],
                'indWritten_dateReference'=>$_POST['mce_indWritten_dateReference'], 'document_id'=>$document_id, 'indWritten_equipmentName'=>$_POST['mce_indWritten_equipmentName']));
        } else if ($_POST['funct'] == 'save_industrial_written_pems') {
            if (empty($_POST['mpe_indAll_id']))                 throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mpe_written_type']))              throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            if (empty($_POST['mpe_indWritten_equipmentName']))  throw new Exception('(ErrCode:5889) [' . __LINE__ . '] - Field Equipment Name empty.', 32);
            if (empty($_POST['mpe_indWritten_referenceNo']))    throw new Exception('(ErrCode:5861) [' . __LINE__ . '] - Field Reference No. empty.', 32);
            if (empty($_POST['mpe_indWritten_dateReference']))  throw new Exception('(ErrCode:5862) [' . __LINE__ . '] - Field Reference Date empty.', 32);
            $document_id = !empty($_FILES['mpe_file_written']['name']) ? $fn_upload->upload_file('1', $_FILES['mpe_file_written'], $_POST['mpe_file_written_name'], $_POST['mpe_written_type'], '') : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_written', array('indAll_id'=>$_POST['mpe_indAll_id'], 'documentName_id'=>$_POST['mpe_written_type'], 'indWritten_referenceNo'=>$_POST['mpe_indWritten_referenceNo'],
                'indWritten_dateReference'=>$_POST['mpe_indWritten_dateReference'], 'document_id'=>$document_id, 'indWritten_equipmentName'=>$_POST['mpe_indWritten_equipmentName']));
        } else if ($_POST['funct'] == 'delete_industrial_written') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indWritten_id']))    throw new Exception('(ErrCode:5863) [' . __LINE__ . '] - Parameter indWritten_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_industrial_written', array('indWritten_id'=>$arrayParam['indWritten_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_industrial_written', array('indWritten_status'=>'8'), array('indWritten_id'=>$arrayParam['indWritten_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_industrial_document_cems') {
            if (empty($_POST['mce_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_document_type']))     throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            $document_id = !empty($_FILES['mce_file_document']['name']) ? $fn_upload->upload_file('1', $_FILES['mce_file_document'], $_POST['mce_file_document_name'], $_POST['mce_document_type'], $_POST['mce_document_remarks']) : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_doc', array('indAll_id'=>$_POST['mce_indAll_id'], 'documentName_id'=>$_POST['mce_document_type'], 'indDoc_others'=>$_POST['mce_indDoc_others'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'save_industrial_document_pems') {
            if (empty($_POST['mpe_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mpe_document_type']))     throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            $document_id = !empty($_FILES['mpe_file_document']['name']) ? $fn_upload->upload_file('1', $_FILES['mpe_file_document'], $_POST['mpe_file_document_name'], $_POST['mpe_document_type'], $_POST['mpe_document_remarks']) : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_doc', array('indAll_id'=>$_POST['mpe_indAll_id'], 'documentName_id'=>$_POST['mpe_document_type'], 'indDoc_others'=>$_POST['mpe_indDoc_others'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'delete_industrial_exclude') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indExclude_id']))    throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter indExclude_id empty.');
            $exclude = Class_db::getInstance()->db_select_single('t_industrial_exclude', array('indExclude_id'=>$arrayParam['indExclude_id']), NULL, 1);
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$exclude['document_id']));
            $pub = Class_db::getInstance()->db_select_single('t_pub', array('pub_id'=>$exclude['pub_id']), NULL, 1);
            Class_db::getInstance()->db_insert('t_industrial_parameter', array('indAll_id'=>$exclude['indAll_id'], 'pub_id'=>$exclude['pub_id'], 'indParam_limitValue'=>$pub['pub_limitValue']));
            Class_db::getInstance()->db_delete('t_industrial_exclude', array('indExclude_id'=>$arrayParam['indExclude_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'delete_industrial_document') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indDoc_id']))        throw new Exception('(ErrCode:5864) [' . __LINE__ . '] - Parameter indDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_industrial_doc', array('indDoc_id'=>$arrayParam['indDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_industrial_doc', array('indDoc_status'=>'8'), array('indDoc_id'=>$arrayParam['indDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_industrial_docNormalize_cems') {
            if (empty($_POST['mce_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_docNormalize_type'])) throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            $document_id = !empty($_FILES['mce_file_docNormalize']['name']) ? $fn_upload->upload_file('1', $_FILES['mce_file_docNormalize'], $_POST['mce_file_docNormalize_name'], $_POST['mce_docNormalize_type'], '') : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_doc', array('indAll_id'=>$_POST['mce_indAll_id'], 'documentName_id'=>$_POST['mce_docNormalize_type'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'delete_industrial_docNormalize_cems') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indDoc_id']))        throw new Exception('(ErrCode:5864) [' . __LINE__ . '] - Parameter indDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_industrial_doc', array('indDoc_id'=>$arrayParam['indDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_industrial_doc', array('indDoc_status'=>'8'), array('indDoc_id'=>$arrayParam['indDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_industrial_docNormalize_pems') {
            if (empty($_POST['mpe_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mpe_docNormalize_type'])) throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            $document_id = !empty($_FILES['mpe_file_docNormalize']['name']) ? $fn_upload->upload_file('1', $_FILES['mpe_file_docNormalize'], $_POST['mce_file_docNormalize_name'], $_POST['mpe_docNormalize_type'], '') : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_doc', array('indAll_id'=>$_POST['mpe_indAll_id'], 'documentName_id'=>$_POST['mpe_docNormalize_type'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'save_initial_rata_attach_cems') {
            if (empty($_POST['mqj_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mqj_document_type'])) throw new Exception('(ErrCode:5860) [' . __LINE__ . '] - Field Attachment Type empty.', 32);
            $document_id = !empty($_FILES['mqj_file_attachment']['name']) ? $fn_upload->upload_file('1', $_FILES['mqj_file_attachment'], $_POST['mqj_file_document_title'], $_POST['mqj_document_type'], $_POST['mqj_document_date']) : '';
            $result = Class_db::getInstance()->db_insert('t_industrial_doc', array('indAll_id'=>$_POST['mqj_indAll_id'], 'documentName_id'=>$_POST['mqj_document_type'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'save_industrial_personnel_cems') {
            if (empty($_POST['mce_indAll_id']))                 throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_indPers_name']))              throw new Exception('(ErrCode:5868) [' . __LINE__ . '] - Field Name empty.', 32);
            if (empty($_POST['mce_indPers_icNo']))              throw new Exception('(ErrCode:5869) [' . __LINE__ . '] - Field MyKad No. empty.', 32);
            if (empty($_POST['mce_indPers_position']))          throw new Exception('(ErrCode:5870) [' . __LINE__ . '] - Field Position empty.', 32);
            if (empty($_POST['mce_indPers_contactNo']))         throw new Exception('(ErrCode:5871) [' . __LINE__ . '] - Field Contact No. empty.', 32);
            if (empty($_POST['mce_indPers_email']))             throw new Exception('(ErrCode:5872) [' . __LINE__ . '] - Field Email empty.', 32);
            if (empty($_POST['mce_indPers_qualification']))     throw new Exception('(ErrCode:5873) [' . __LINE__ . '] - Field Academic Qualification empty.', 32);
            if (empty($_POST['mce_indPers_certificate']))       throw new Exception('(ErrCode:5874) [' . __LINE__ . '] - Field Certificate empty.', 32);
            if (Class_db::getInstance()->db_count('t_industrial_personnel', array('indAll_id'=>$_POST['mce_indAll_id'], 'indPers_icNo'=>$_POST['mce_indPers_icNo'])) > 0)
                throw new Exception('(ErrCode:5875) [' . __LINE__ . '] - MyKad No. already exist.', 32);
            $result = Class_db::getInstance()->db_insert('t_industrial_personnel', array('indAll_id'=>$_POST['mce_indAll_id'], 'indPers_icNo'=>$_POST['mce_indPers_icNo'], 'indPers_name'=>$_POST['mce_indPers_name'],
                'indPers_position'=>$_POST['mce_indPers_position'], 'indPers_qualification'=>$_POST['mce_indPers_qualification'], 'indPers_certificate'=>$_POST['mce_indPers_certificate'], 'indPers_contactNo'=>$_POST['mce_indPers_contactNo'], 'indPers_email'=>$_POST['mce_indPers_email']));
        } else if ($_POST['funct'] == 'save_industrial_personnel_pems') {
            if (empty($_POST['mpe_indAll_id']))                 throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mpe_indPers_name']))              throw new Exception('(ErrCode:5868) [' . __LINE__ . '] - Field Name empty.', 32);
            if (empty($_POST['mpe_indPers_icNo']))              throw new Exception('(ErrCode:5869) [' . __LINE__ . '] - Field MyKad No. empty.', 32);
            if (empty($_POST['mpe_indPers_position']))          throw new Exception('(ErrCode:5870) [' . __LINE__ . '] - Field Position empty.', 32);
            if (empty($_POST['mpe_indPers_contactNo']))         throw new Exception('(ErrCode:5871) [' . __LINE__ . '] - Field Contact No. empty.', 32);
            if (empty($_POST['mpe_indPers_email']))             throw new Exception('(ErrCode:5872) [' . __LINE__ . '] - Field Email empty.', 32);
            if (empty($_POST['mpe_indPers_qualification']))     throw new Exception('(ErrCode:5873) [' . __LINE__ . '] - Field Academic Qualification empty.', 32);
            if (empty($_POST['mpe_indPers_certificate']))       throw new Exception('(ErrCode:5874) [' . __LINE__ . '] - Field Certificate empty.', 32);
            if (Class_db::getInstance()->db_count('t_industrial_personnel', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indPers_icNo'=>$_POST['mpe_indPers_icNo'])) > 0)
                throw new Exception('(ErrCode:5875) [' . __LINE__ . '] - MyKad No. already exist.', 32);
            $result = Class_db::getInstance()->db_insert('t_industrial_personnel', array('indAll_id'=>$_POST['mpe_indAll_id'], 'indPers_icNo'=>$_POST['mpe_indPers_icNo'], 'indPers_name'=>$_POST['mpe_indPers_name'],
                'indPers_position'=>$_POST['mpe_indPers_position'], 'indPers_qualification'=>$_POST['mpe_indPers_qualification'], 'indPers_certificate'=>$_POST['mpe_indPers_certificate'], 'indPers_contactNo'=>$_POST['mpe_indPers_contactNo'], 'indPers_email'=>$_POST['mpe_indPers_email']));
        } else if ($_POST['funct'] == 'delete_industrial_personnel') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indPers_id']))       throw new Exception('(ErrCode:5876) [' . __LINE__ . '] - Parameter indPers_id empty.');
            Class_db::getInstance()->db_delete('t_industrial_personnel', array('indPers_id'=>$arrayParam['indPers_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_initial_rata_date') {
            if (empty($_POST['mpt_indAll_id']))             throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mpt_indAll_dateRataSet']))    throw new Exception('(ErrCode:5865) [' . __LINE__ . '] - Field Initial Quality Assurance Date empty.', 32);
            $result = Class_db::getInstance()->db_update('t_industrial_all', array('indAll_dateRataSet'=>$_POST['mpt_indAll_dateRataSet']), array('indAll_id'=>$_POST['mpt_indAll_id']));












        } else if ($_POST['funct'] == 'save_qa_doc_j') {
            if (empty($_POST['mqj_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            if (empty($_POST['mqj_supDoc_name']))       throw new Exception('(ErrCode:5878) [' . __LINE__ . '] - Parameter supDoc_name empty.');
            $document_id = !empty($_FILES['mqj_supDoc_file']['name']) ? $fn_upload->upload_file('1', $_FILES['mqj_supDoc_file'], $_POST['mqj_supDoc_name'], '21', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qa_doc', array('qa_id'=>$_POST['mqj_qa_id'], 'document_id'=>$document_id));

        } else if ($_POST['funct'] == 'save_qa_doc_dct_report') {
            if (empty($_POST['mqj_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            $mqj_qa_doc_name = $_FILES['mqj_doc_cdt']['name'];
            $mqj_qa_doc_name = 'DCT_' . $mqj_qa_doc_name;
            $document_id = !empty($_FILES['mqj_doc_cdt']['name']) ? $fn_upload->upload_file('1', $_FILES['mqj_doc_cdt'], $mqj_qa_doc_name, '21', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qa_doc', array('qa_id'=>$_POST['mqj_qa_id'], 'document_id'=>$document_id));

        } else if ($_POST['funct'] == 'save_qa_doc_rata_report') {
            if (empty($_POST['mqj_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            $mqj_qa_doc_name = $_FILES['mqj_doc_rata']['name'];
            $document_id = !empty($_FILES['mqj_doc_rata']['name']) ? $fn_upload->upload_file('1', $_FILES['mqj_doc_rata'], $mqj_qa_doc_name, '21', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qa_doc', array('qa_id'=>$_POST['mqj_qa_id'], 'document_id'=>$document_id));

        } else if ($_POST['funct'] == 'save_qa_doc_rca_report') {
            if (empty($_POST['mqj_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            $mqj_qa_doc_name = $_FILES['mqj_doc_rca']['name'];
            $document_id = !empty($_FILES['mqj_doc_rca']['name']) ? $fn_upload->upload_file('1', $_FILES['mqj_doc_rca'], $mqj_qa_doc_name, '21', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qa_doc', array('qa_id'=>$_POST['mqj_qa_id'], 'document_id'=>$document_id));

        } else if ($_POST['funct'] == 'save_qa_doc_fapt_report') {
            if (empty($_POST['mqj_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            $mqj_qa_doc_name = $_FILES['mqj_doc_fapt']['name'];
            $document_id = !empty($_FILES['mqj_doc_fapt']['name']) ? $fn_upload->upload_file('1', $_FILES['mqj_doc_fapt'], $mqj_qa_doc_name, '21', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qa_doc', array('qa_id'=>$_POST['mqj_qa_id'], 'document_id'=>$document_id));











        } else if ($_POST['funct'] == 'save_qa_doc_k') {
            if (empty($_POST['mqk_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            if (empty($_POST['mqk_supDoc_name']))       throw new Exception('(ErrCode:5878) [' . __LINE__ . '] - Parameter supDoc_name empty.');
            $document_id = !empty($_FILES['mqk_supDoc_file']['name']) ? $fn_upload->upload_file('1', $_FILES['mqk_supDoc_file'], $_POST['mqk_supDoc_name'], '21', '') : '';
            $result = Class_db::getInstance()->db_insert('t_qa_doc', array('qa_id'=>$_POST['mqk_qa_id'], 'document_id'=>$document_id));
        } else if ($_POST['funct'] == 'delete_qa_doc') {
            if (empty($_POST['param']))     throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['qaDoc_id']))  throw new Exception('(ErrCode:5879) [' . __LINE__ . '] - Parameter qaDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_qa_doc', array('qaDoc_id'=>$arrayParam['qaDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_qa_doc', array('qaDoc_status'=>'8'), array('qaDoc_id'=>$arrayParam['qaDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'save_qa_j') {
            if (empty($_POST['mqj_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            if (empty($_POST['mqj_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mqj_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mqj_wfTaskType_id']))     throw new Exception('(ErrCode:5812) [' . __LINE__ . '] - Parameter wfTaskType_id empty.');
            Class_db::getInstance()->db_update('t_qa', array('qa_dateActual'=>$_POST['mqj_qa_dateActual'], 'qa_message'=>$_POST['mqj_qa_message']), array('qa_id'=>$_POST['mqj_qa_id']));
            if ($_POST['mqj_wfTaskType_id'] == '37')
                Class_db::getInstance()->db_update('t_industrial_all', array('indAll_datePoolStart'=>$_POST['mqj_qa_dateActual'], 'indAll_dateRataActual'=>$_POST['mqj_qa_dateActual']), array('indAll_id'=>$_POST['mqj_indAll_id']));
            /*$arr_qa_ra = Class_db::getInstance()->db_select('t_qa_ra', array('qa_id'=>$_POST['mqj_qa_id']));
            foreach($arr_qa_ra as $qa_ra) {
                $qaRa_rmAverage = (isset($_POST['mqj_qaRa_rmAverage_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqj_qaRa_rmAverage_'.$qa_ra['qaRa_id']])) ? $_POST['mqj_qaRa_rmAverage_'.$qa_ra['qaRa_id']] : '';
                $qaRa_average = (isset($_POST['mqj_qaRa_average_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqj_qaRa_average_'.$qa_ra['qaRa_id']])) ? $_POST['mqj_qaRa_average_'.$qa_ra['qaRa_id']] : '';
                $qaRa_difference = (isset($_POST['mqj_qaRa_difference_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqj_qaRa_difference_'.$qa_ra['qaRa_id']])) ? $_POST['mqj_qaRa_difference_'.$qa_ra['qaRa_id']] : '';
                $qaRa_confCoeff = (isset($_POST['mqj_qaRa_confCoeff_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqj_qaRa_confCoeff_'.$qa_ra['qaRa_id']])) ? $_POST['mqj_qaRa_confCoeff_'.$qa_ra['qaRa_id']] : '';
                $qaRa_ra = '';
                if (isset($_POST['mqj_qaRa_ra_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqj_qaRa_ra_'.$qa_ra['qaRa_id']]) && $_POST['mqj_qaRa_ra_'.$qa_ra['qaRa_id']] != '0')
                    $qaRa_ra = $_POST['mqj_qaRa_ra_'.$qa_ra['qaRa_id']];
                Class_db::getInstance()->db_update('t_qa_ra', array('qaRa_rmAverage'=>$qaRa_rmAverage, 'qaRa_average'=>$qaRa_average, 'qaRa_difference'=>$qaRa_difference, 'qaRa_confCoeff'=>$qaRa_confCoeff, 'qaRa_ra'=>$qaRa_ra), array('qaRa_id'=>$qa_ra['qaRa_id']));
            }
            $arr_qa_drift = Class_db::getInstance()->db_select('t_qa_drift', array('qa_id'=>$_POST['mqj_qa_id']));
            foreach($arr_qa_drift as $qa_drift) {
                $qaDrift_date_1 = (isset($_POST['mqj_qaDrift_date_1_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_1_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_1_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_date_2 = (isset($_POST['mqj_qaDrift_date_2_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_2_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_2_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_date_3 = (isset($_POST['mqj_qaDrift_date_3_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_3_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_3_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_date_4 = (isset($_POST['mqj_qaDrift_date_4_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_4_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_4_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_date_5 = (isset($_POST['mqj_qaDrift_date_5_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_5_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_5_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_date_6 = (isset($_POST['mqj_qaDrift_date_6_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_6_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_6_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_date_7 = (isset($_POST['mqj_qaDrift_date_7_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_date_7_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_date_7_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_1 = (isset($_POST['mqj_qaDrift_time_1_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_1_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_1_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_2 = (isset($_POST['mqj_qaDrift_time_2_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_2_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_2_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_3 = (isset($_POST['mqj_qaDrift_time_3_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_3_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_3_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_4 = (isset($_POST['mqj_qaDrift_time_4_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_4_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_4_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_5 = (isset($_POST['mqj_qaDrift_time_5_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_5_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_5_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_6 = (isset($_POST['mqj_qaDrift_time_6_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_6_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_6_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_time_7 = (isset($_POST['mqj_qaDrift_time_7_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_time_7_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_time_7_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_1 = (isset($_POST['mqj_qaDrift_result_1_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_1_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_1_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_2 = (isset($_POST['mqj_qaDrift_result_2_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_2_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_2_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_3 = (isset($_POST['mqj_qaDrift_result_3_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_3_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_3_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_4 = (isset($_POST['mqj_qaDrift_result_4_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_4_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_4_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_5 = (isset($_POST['mqj_qaDrift_result_5_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_5_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_5_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_6 = (isset($_POST['mqj_qaDrift_result_6_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_6_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_6_'.$qa_drift['qaDrift_id']] : '';
                $qaDrift_result_7 = (isset($_POST['mqj_qaDrift_result_7_'.$qa_drift['qaDrift_id']]) && !empty($_POST['mqj_qaDrift_result_7_'.$qa_drift['qaDrift_id']])) ? $_POST['mqj_qaDrift_result_7_'.$qa_drift['qaDrift_id']] : '';
                Class_db::getInstance()->db_update('t_qa_drift', array('qaDrift_date_1'=>$qaDrift_date_1, 'qaDrift_date_2'=>$qaDrift_date_2, 'qaDrift_date_3'=>$qaDrift_date_3, 'qaDrift_date_4'=>$qaDrift_date_4, 'qaDrift_date_5'=>$qaDrift_date_5,
                    'qaDrift_date_6'=>$qaDrift_date_6, 'qaDrift_date_7'=>$qaDrift_date_7, 'qaDrift_time_1'=>$qaDrift_time_1, 'qaDrift_time_2'=>$qaDrift_time_2, 'qaDrift_time_3'=>$qaDrift_time_3, 'qaDrift_time_4'=>$qaDrift_time_4,
                    'qaDrift_time_5'=>$qaDrift_time_5, 'qaDrift_time_6'=>$qaDrift_time_6, 'qaDrift_time_7'=>$qaDrift_time_7, 'qaDrift_result_1'=>$qaDrift_result_1, 'qaDrift_result_2'=>$qaDrift_result_2, 'qaDrift_result_3'=>$qaDrift_result_3,
                    'qaDrift_result_4'=>$qaDrift_result_4, 'qaDrift_result_5'=>$qaDrift_result_5, 'qaDrift_result_6'=>$qaDrift_result_6, 'qaDrift_result_7'=>$qaDrift_result_7), array('qaDrift_id'=>$qa_drift['qaDrift_id']));
            }
            $arr_qa_responseTime = Class_db::getInstance()->db_select('t_qa_responsetime', array('qa_id'=>$_POST['mqj_qa_id']));
            foreach($arr_qa_responseTime as $qa_responseTime) {
                $qaRespTime_value = (isset($_POST['mqj_qaRespTime_value_'.$qa_responseTime['qaRespTime_id']]) && !empty($_POST['mqj_qaRespTime_value_'.$qa_responseTime['qaRespTime_id']])) ? $_POST['mqj_qaRespTime_value_'.$qa_responseTime['qaRespTime_id']] : '';
                Class_db::getInstance()->db_update('t_qa_responsetime', array('qaRespTime_value'=>$qaRespTime_value), array('qaRespTime_id'=>$qa_responseTime['qaRespTime_id']));
            }*/
            $result = '1';
        } else if ($_POST['funct'] == 'save_qa_k') {
            if (empty($_POST['mqk_qa_id']))             throw new Exception('(ErrCode:5877) [' . __LINE__ . '] - Parameter qa_id empty.');
            if (empty($_POST['mqk_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mqk_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mqk_wfTaskType_id']))     throw new Exception('(ErrCode:5812) [' . __LINE__ . '] - Parameter wfTaskType_id empty.');
            Class_db::getInstance()->db_update('t_qa', array('qa_dateActual'=>$_POST['mqk_qa_dateActual'], 'qa_message'=>$_POST['mqk_qa_message']), array('qa_id'=>$_POST['mqk_qa_id']));
            if ($_POST['mqk_wfTaskType_id'] == '47')
                Class_db::getInstance()->db_update('t_industrial_all', array('indAll_datePoolStart'=>$_POST['mqk_qa_dateActual'], 'indAll_dateRataActual'=>$_POST['mqk_qa_dateActual']), array('indAll_id'=>$_POST['mqk_indAll_id']));
            $arr_qa_ra = Class_db::getInstance()->db_select('t_qa_ra', array('qa_id'=>$_POST['mqk_qa_id']));
            foreach($arr_qa_ra as $qa_ra) {
                $qaRa_rmAverage = (isset($_POST['mqk_qaRa_rmAverage_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqk_qaRa_rmAverage_'.$qa_ra['qaRa_id']])) ? $_POST['mqk_qaRa_rmAverage_'.$qa_ra['qaRa_id']] : '';
                $qaRa_average = (isset($_POST['mqk_qaRa_average_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqk_qaRa_average_'.$qa_ra['qaRa_id']])) ? $_POST['mqk_qaRa_average_'.$qa_ra['qaRa_id']] : '';
                $qaRa_ra = (isset($_POST['mqk_qaRa_ra_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqk_qaRa_ra_'.$qa_ra['qaRa_id']])) ? $_POST['mqk_qaRa_ra_'.$qa_ra['qaRa_id']] : '';
                $qaRa_difference = '';
                if (isset($_POST['mqk_qaRa_ra_'.$qa_ra['qaRa_id']]) && !empty($_POST['mqk_qaRa_ra_'.$qa_ra['qaRa_id']]) && $qaRa_rmAverage != '' && $qaRa_average != '')
                    $qaRa_difference = $_POST['mqk_qaRa_difference_'.$qa_ra['qaRa_id']];
                Class_db::getInstance()->db_update('t_qa_ra', array('qaRa_rmAverage'=>$qaRa_rmAverage, 'qaRa_average'=>$qaRa_average, 'qaRa_difference'=>$qaRa_difference, 'qaRa_ra'=>$qaRa_ra), array('qaRa_id'=>$qa_ra['qaRa_id']));
            }
            $arr_qa_ftest = Class_db::getInstance()->db_select('t_qa_ftest', array('qa_id'=>$_POST['mqk_qa_id']));
            foreach($arr_qa_ftest as $qa_ftest) {
                $qaFtest_low = (isset($_POST['mqk_qaFtest_low_'.$qa_ftest['qaFtest_id']]) && !empty($_POST['mqk_qaFtest_low_'.$qa_ftest['qaFtest_id']])) ? $_POST['mqk_qaFtest_low_'.$qa_ftest['qaFtest_id']] : '';
                $qaFtest_mid = (isset($_POST['mqk_qaFtest_mid_'.$qa_ftest['qaFtest_id']]) && !empty($_POST['mqk_qaFtest_mid_'.$qa_ftest['qaFtest_id']])) ? $_POST['mqk_qaFtest_mid_'.$qa_ftest['qaFtest_id']] : '';
                $qaFtest_high = (isset($_POST['mqk_qaFtest_high_'.$qa_ftest['qaFtest_id']]) && !empty($_POST['mqk_qaFtest_high_'.$qa_ftest['qaFtest_id']])) ? $_POST['mqk_qaFtest_high_'.$qa_ftest['qaFtest_id']] : '';
                $qaFtest_corrValue = (isset($_POST['mqk_qaFtest_corrValue_'.$qa_ftest['qaFtest_id']]) && !empty($_POST['mqk_qaFtest_corrValue_'.$qa_ftest['qaFtest_id']])) ? $_POST['mqk_qaFtest_corrValue_'.$qa_ftest['qaFtest_id']] : '';
                Class_db::getInstance()->db_update('t_qa_ftest', array('qaFtest_low'=>$qaFtest_low, 'qaFtest_mid'=>$qaFtest_mid, 'qaFtest_high'=>$qaFtest_high, 'qaFtest_corrValue'=>$qaFtest_corrValue), array('qaFtest_id'=>$qa_ftest['qaFtest_id']));
            }
            $result = '1';
        } else if ($_POST['funct'] == 'save_pems_input_reading') {
            if (empty($_POST['mpe_indAll_id']))         throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
//            if (empty($_POST['mpe_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
//            if (empty($_POST['mpe_pemsInput_name']))    throw new Exception('(ErrCode:5880) [' . __LINE__ . '] - Field Input empty.', 32);
//            if (empty($_POST['mpe_pemsInput_desc']))    throw new Exception('(ErrCode:5881) [' . __LINE__ . '] - Field Description empty.', 32);
//            $pemsInput_id = Class_db::getInstance()->db_insert('t_pems_input', array('indAll_id'=>$_POST['mpe_indAll_id'], 'pemsInput_name'=>$_POST['mpe_pemsInput_name'], 'pemsInput_desc'=>$_POST['mpe_pemsInput_desc']));
//            Class_db::getInstance()->db_insert('t_pems_reading', array('pemsInput_id'=>$pemsInput_id, 'wfTask_id'=>$_POST['mpe_wfTask_id'], 'pemsReading_type'=>'1', 'pemsReading_category'=>'1'));
//            Class_db::getInstance()->db_insert('t_pems_reading', array('pemsInput_id'=>$pemsInput_id, 'wfTask_id'=>$_POST['mpe_wfTask_id'], 'pemsReading_type'=>'2', 'pemsReading_category'=>'1'));
//            Class_db::getInstance()->db_insert('t_pems_reading', array('pemsInput_id'=>$pemsInput_id, 'wfTask_id'=>$_POST['mpe_wfTask_id'], 'pemsReading_type'=>'3', 'pemsReading_category'=>'1'));
//            $result = '1';
            $result = Class_db::getInstance()->db_insert('t_industrial_pems_reading', array('indAll_id'=>$_POST['mpe_indAll_id'], 'pemsReading_desc'=>$_POST['mpe_pemsReading_desc'], 'pemsReading_idd'=>$_POST['mpe_pemsReading_idd'],
                'pemsReading_unit'=>$_POST['mpe_pemsReading_unit'], 'pemsReading_min'=>$_POST['mpe_pemsReading_min'], 'pemsReading_max'=>$_POST['mpe_pemsReading_max']));
        } else if ($_POST['funct'] == 'delete_pems_input_reading') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
//            if (empty($arrayParam['pemsInput_id']))     throw new Exception('(ErrCode:5882) [' . __LINE__ . '] - Parameter pemsInput_id empty.');
//            Class_db::getInstance()->db_delete('t_pems_reading', array('pemsInput_id'=>$arrayParam['pemsInput_id']));
//            Class_db::getInstance()->db_delete('t_pems_input', array('pemsInput_id'=>$arrayParam['pemsInput_id']));
//            $result = '1';
            if (empty($arrayParam['pemsReading_id']))     throw new Exception('(ErrCode:5882) [' . __LINE__ . '] - Parameter pemsReading_id empty.');
            $result = Class_db::getInstance()->db_delete('t_industrial_pems_reading', array('pemsReading_id'=>$arrayParam['pemsReading_id']));
        } else if ($_POST['funct'] == 'save_verify_initial_RATA_j') {
            if (empty($_POST['mqj_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mqj_qa_id']))         throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter qa_id empty.');
            $arr_set['wfTask_remark'] = (!empty($_POST['mqj_wfTask_verify'])) ? $_POST['mqj_wfTask_verify'] : '';
            $arr_set['wfTask_statusSave'] = (empty($_POST['mqj_result'])?'':$_POST['mqj_result']);
            Class_db::getInstance()->db_update('wf_task', $arr_set, array('wfTask_id'=>$_POST['mqj_wfTask_id']));
            $arr_set2['qa_hardCopy'] = (empty($_POST['mqj_qa_hardCopy'])?'':$_POST['mqj_qa_hardCopy']);
            $arr_set2['qa_hardCopy_receiver'] = (!empty($_POST['mqj_qa_hardCopy_receiver'])) ? $_POST['mqj_qa_hardCopy_receiver'] : '';
            $arr_set2['qa_hardCopy_remark'] = (!empty($_POST['mqj_snote_hardCopy_remark'])) ? $_POST['mqj_snote_hardCopy_remark'] : '';
            Class_db::getInstance()->db_update('t_qa', $arr_set2, array('qa_id'=>$_POST['mqj_qa_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_verify_initial_RATA_k') {
            if (empty($_POST['mqk_wfTask_id']))         throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            $arr_set['wfTask_remark'] = (!empty($_POST['mqk_wfTask_verify'])) ? $_POST['mqk_wfTask_verify'] : '';
            $arr_set['wfTask_statusSave'] = (empty($_POST['mqk_result'])?'':$_POST['mqk_result']);
            Class_db::getInstance()->db_update('wf_task', $arr_set, array('wfTask_id'=>$_POST['mqk_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'create_certificate_renewal') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['certificate_id']))   throw new Exception('(ErrCode:5883) [' . __LINE__ . '] - Parameter certificate_id empty.');
            $wfGroup_id = Class_db::getInstance()->db_select_col('wf_group_user', array('user_id'=>$_SESSION['user_id'], 'wfGroupUser_status'=>'1', 'wfGroupUser_isMain'=>'1'), 'wfGroup_id', NULL, 1);
            $wfTask_id = $fn_task->task_create($_SESSION['user_id'], '9', $wfGroup_id, '81');
            $wfTrans_id = Class_db::getInstance()->db_select_col('wf_task', array('wfTask_id'=>$wfTask_id), 'wfTrans_id', NULL, 1);
            $certificate = Class_db::getInstance()->db_select_single('t_certificate', array('certificate_id'=>$arrayParam['certificate_id']), NULL, 1);
            $certificate_id = Class_db::getInstance()->db_insert('t_certificate', array('wfTrans_id'=>$wfTrans_id, 'certificate_renewed'=>$arrayParam['certificate_id'], 'certificate_main'=>$certificate['certificate_main'], 'consAll_id'=>$certificate['consAll_id'], 'certificate_status'=>'2'));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_refName'=>'certificate_id', 'wfTask_refValue'=>$certificate_id), array('wfTask_id'=>$wfTask_id));
            $result['certificate_id'] = $certificate_id;
            $result['wfTask_id'] = $wfTask_id;
        } else if ($_POST['funct'] == 'save_certificate_renewal') {
            if (empty($_POST['mbc_wfTask_id']))             throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            if (empty($_POST['mbc_certificate_id']))        throw new Exception('(ErrCode:5883) [' . __LINE__ . '] - Parameter certificate_id empty.');
            $arr_certBasic = Class_db::getInstance()->db_select_colm ('t_certificate_basic_list', array('certificate_id'=>$_POST['mbc_certificate_id']), 'certBasic_id');
            $arrPost_certBasic = (!empty($_POST['mbc_certBasic_id'])) ? $_POST['mbc_certBasic_id'] : array();
            if ($arr_certBasic != $arrPost_certBasic) {
                $arrDiff_certBasic1 = array_diff($arrPost_certBasic, $arr_certBasic);
                foreach($arrDiff_certBasic1 as $value) {
                    Class_db::getInstance()->db_insert('t_certificate_basic_list', array('certificate_id'=>$_POST['mbc_certificate_id'], 'certBasic_id'=>$value));
                }
                $arrDiff_certBasic2 = array_diff($arr_certBasic, $arrPost_certBasic);
                if (count($arrDiff_certBasic2) > 0) {
                    Class_db::getInstance()->db_delete('t_certificate_basic_list', array('certificate_id'=>$_POST['mbc_certificate_id'], 'certBasic_id'=>'('.  implode(',', $arrDiff_certBasic2).')'));
                }
            }
            Class_db::getInstance()->db_update('t_certificate', array('certificate_no'=>$_POST['mbc_certificate_no'], 'certIssuer_id'=>$_POST['mbc_certIssuer_id'], 'certificate_dateExpired'=>$_POST['mbc_certificate_dateExpired'], 'certificate_remark'=>$_POST['mbc_wfTask_remark']),
                array('certificate_id'=>$_POST['mbc_certificate_id']));
            Class_db::getInstance()->db_update('wf_task', array('wfTask_remark'=>$_POST['mbc_wfTask_remark']), array('wfTask_id'=>$_POST['mbc_wfTask_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_certificate_doc') {
            if (empty($_POST['mbc_certificate_id']))    throw new Exception('(ErrCode:5883) [' . __LINE__ . '] - Parameter certificate_id empty.');
            if (empty($_FILES['mbc_file_certificate']['name']))  throw new Exception('(ErrCode:5884) [' . __LINE__ . '] - File file_certificate empty.');
            $current_doc = Class_db::getInstance()->db_select_col('t_certificate', array('certificate_id'=>$_POST['mbc_certificate_id']), 'document_id');
            if (!empty($current_doc))
                Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$current_doc));
            $document_id = $fn_upload->upload_file('1', $_FILES['mbc_file_certificate'], 'Analyzer Certificate', '10', '');
            Class_db::getInstance()->db_update('t_certificate', array('document_id'=>$document_id), array('certificate_id'=>$_POST['mbc_certificate_id']));
            $result['document_id'] = $document_id;
            $result['document_uplname'] = $_FILES['mbc_file_certificate']['name'];
        } else if ($_POST['funct'] == 'save_certificate_verify') {
            if (empty($_POST['mbc_wfTask_id']))      throw new Exception('(ErrCode:5816) [' . __LINE__ . '] - Parameter wfTask_id empty.');
            $result = Class_db::getInstance()->db_update('wf_task', array('wfTask_statusSave'=>empty($_POST['mbc_result'])?'':$_POST['mbc_result'], 'wfTask_remark'=>$_POST['mbc_wfTask_verify']), array('wfTask_id'=>$_POST['mbc_wfTask_id']));
        } else if ($_POST['funct'] == 'save_industrial_consultant') {
            if (empty($_POST['mce_indAll_id']))     throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mce_consAll_id']))    throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (Class_db::getInstance()->db_count('t_industrial_consultant', array('indAll_id'=>$_POST['mce_indAll_id'], 'consAll_id'=>$_POST['mce_consAll_id'])) > 0)
                throw new Exception('(ErrCode:5892) [' . __LINE__ . '] - Analyzer already exist.', 32);
            $result = Class_db::getInstance()->db_insert('t_industrial_consultant', array('indAll_id'=>$_POST['mce_indAll_id'], 'consAll_id'=>$_POST['mce_consAll_id']));
        } else if ($_POST['funct'] == 'delete_industrial_consultant') {
            if (empty($_POST['param']))             throw new Exception('(ErrCode:5802) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indCons_id']))   throw new Exception('(ErrCode:5891) [' . __LINE__ . '] - Parameter indCons_id empty.');
            $result = Class_db::getInstance()->db_delete('t_industrial_consultant', array('indCons_id'=>$arrayParam['indCons_id']));
        } else if ($_POST['funct'] == 'upload_consultant_supportDoc') {
            if (empty($_POST['consultant_id']))                 throw new Exception('(ErrCode:5810) [' . __LINE__ . '] - Parameter consultant empty.');
            if (empty($_POST['cin_documentName_id']))           throw new Exception('(ErrCode:5885) [' . __LINE__ . '] - Field Document Type empty.', 32);
            if (empty($_POST['cin_document_name']))             throw new Exception('(ErrCode:5886) [' . __LINE__ . '] - Field Document Title empty.', 32);
            if (empty($_FILES['cin_file_document']['name']))    throw new Exception('(ErrCode:5887) [' . __LINE__ . '] - Attachment File empty.', 32);
            $document_id = $fn_upload->upload_file('1', $_FILES['cin_file_document'], $_POST['cin_document_name'], $_POST['cin_documentName_id'], '');
            $result = Class_db::getInstance()->db_insert('t_consultant_docsupport', array('document_id'=>$document_id, 'documentName_id'=>$_POST['cin_documentName_id'], 'consultant_id'=>$_POST['consultant_id']));
        } else if ($_POST['funct'] == 'delete_consultant_doc') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consultantDoc_id'])) throw new Exception('(ErrCode:5893) [' . __LINE__ . '] - Parameter consultantDoc_id empty.');
            $document_id = Class_db::getInstance()->db_select_col('t_consultant_docsupport', array('consultantDoc_id'=>$arrayParam['consultantDoc_id']), 'document_id', NULL, 1);
            Class_db::getInstance()->db_update('t_consultant_docsupport', array('consultantDoc_status'=>'8'), array('consultantDoc_id'=>$arrayParam['consultantDoc_id']));
            Class_db::getInstance()->db_update('document', array('document_status'=>'8'), array('document_id'=>$document_id));
            $result = '1';
        } else if ($_POST['funct'] == 'create_consultant_unregistered') {
            if (empty($_POST['mcx_indAll_id']))             throw new Exception('(ErrCode:5859) [' . __LINE__ . '] - Parameter indAll_id empty.');
            if (empty($_POST['mcx_consUnr_consultant']))    throw new Exception('(ErrCode:5894) [' . __LINE__ . '] - Field Consultant Name empty.', 32);
            if (empty($_POST['mcx_consUnr_modelNo']))       throw new Exception('(ErrCode:5895) [' . __LINE__ . '] - Field Model No. empty.', 32);
            $consAll_id = Class_db::getInstance()->db_insert('t_consultant_all', array('consAll_type'=>'4', 'consAll_status'=>'54'));
            Class_db::getInstance()->db_insert('t_consultant_unregistered', array('consAll_id'=>$consAll_id, 'consUnr_consultant'=>$_POST['mcx_consUnr_consultant'], 'consUnr_modelNo'=>$_POST['mcx_consUnr_modelNo'], 'consUnr_status'=>'1', 'consUnr_createdBy'=>$_SESSION['user_id']));
            foreach ($_POST['mcx_inputParam_id'] as $inputParam_id) {
                Class_db::getInstance()->db_insert('t_consultant_parameter', array('consAll_id'=>$consAll_id, 'inputParam_id'=>$inputParam_id));
            }
            Class_db::getInstance()->db_insert('t_industrial_consultant', array('consAll_id'=>$consAll_id, 'indAll_id'=>$_POST['mcx_indAll_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'save_consultant_unregistered') {
            if (empty($_POST['mcx_consAll_id']))            throw new Exception('(ErrCode:5815) [' . __LINE__ . '] - Parameter consAll_id empty.');
            if (empty($_POST['mcx_consUnr_consultant']))    throw new Exception('(ErrCode:5894) [' . __LINE__ . '] - Field Consultant Name empty.', 32);
            if (empty($_POST['mcx_consUnr_modelNo']))       throw new Exception('(ErrCode:5895) [' . __LINE__ . '] - Field Model No. empty.', 32);
            Class_db::getInstance()->db_update('t_consultant_unregistered', array('consUnr_consultant'=>$_POST['mcx_consUnr_consultant'], 'consUnr_modelNo'=>$_POST['mcx_consUnr_modelNo']), array('consAll_id'=>$_POST['mcx_consAll_id']));
            $arr_consParam = Class_db::getInstance()->db_select_colm ('t_consultant_parameter', array('consAll_id'=>$_POST['mcx_consAll_id']), 'inputParam_id');
            $arrPost_consParam = (!empty($_POST['mcx_inputParam_id'])) ? $_POST['mcx_inputParam_id'] : array();
            if ($arr_consParam != $arrPost_consParam) {
                $arrDiff_consParam1 = array_diff($arrPost_consParam, $arr_consParam);
                foreach($arrDiff_consParam1 as $value) {
                    Class_db::getInstance()->db_insert('t_consultant_parameter', array('consAll_id'=>$_POST['mcx_consAll_id'], 'inputParam_id'=>$value));
                }
                $arrDiff_consParam2 = array_diff($arr_consParam, $arrPost_consParam);
                if (count($arrDiff_consParam2) > 0) {
                    Class_db::getInstance()->db_delete('t_consultant_parameter', array('consAll_id'=>$_POST['mcx_consAll_id'], 'inputParam_id'=>'('.  implode(',', $arrDiff_consParam2).')'));
                }
            }
            $result = '1';
        } else if ($_POST['funct'] == 'delete_consultant_unregistered') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indCons_id']))       throw new Exception('(ErrCode:5891) [' . __LINE__ . '] - Parameter indCons_id empty.');
            $consAll_id = Class_db::getInstance()->db_select_col('t_industrial_consultant', array('indCons_id'=>$arrayParam['indCons_id']), 'consAll_id', NULL, 1);
            Class_db::getInstance()->db_delete('t_industrial_consultant', array('indCons_id'=>$arrayParam['indCons_id']));
            Class_db::getInstance()->db_delete('t_consultant_parameter', array('consAll_id'=>$consAll_id));
            Class_db::getInstance()->db_delete('t_consultant_unregistered', array('consAll_id'=>$consAll_id));
            Class_db::getInstance()->db_delete('t_consultant_all', array('consAll_id'=>$consAll_id));
            $result = '1';
        } else if ($_POST['funct'] == 'activation_analyzer') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consAll_id']))       throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter consAll_id empty');
            if ($arrayParam['consCems_status'] !== '0' && $arrayParam['consCems_status'] !== '1')    throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter consCems_status invalid');
            Class_db::getInstance()->db_update('t_consultant_cems', array('consCems_status'=>$arrayParam['consCems_status']), array('consAll_id'=>$arrayParam['consAll_id']));
            Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>$arrayParam['consCems_status']), array('consAll_id'=>$arrayParam['consAll_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'activation_software') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consAll_id']))       throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter consAll_id empty');
            if ($arrayParam['consPems_status'] !== '0' && $arrayParam['consPems_status'] !== '1')    throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter consPems_status invalid');
            Class_db::getInstance()->db_update('t_consultant_pems', array('consPems_status'=>$arrayParam['consPems_status']), array('consAll_id'=>$arrayParam['consAll_id']));
            Class_db::getInstance()->db_update('t_consultant_all', array('consAll_status'=>$arrayParam['consPems_status']), array('consAll_id'=>$arrayParam['consAll_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'activation_consultant') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['consultant_id']))       throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter consultant_id empty');
            if ($arrayParam['consultant_status'] !== '0' && $arrayParam['consultant_status'] !== '1')    throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter consultant_status invalid');
            Class_db::getInstance()->db_update('t_consultant', array('consultant_status'=>$arrayParam['consultant_status']), array('consultant_id'=>$arrayParam['consultant_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'activation_stack') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indAll_id']))       throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter indAll_id empty');
            if ($arrayParam['indAll_status'] !== '0' && $arrayParam['indAll_status'] !== '1')    throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter indAll_status invalid');
            Class_db::getInstance()->db_update('t_industrial_all', array('indAll_status'=>$arrayParam['indAll_status']), array('indAll_id'=>$arrayParam['indAll_id']));
            $result = '1';
        } else if ($_POST['funct'] == 'generate_pdf') {
            if (empty($_POST['param']))                 throw new Exception('(ErrCode:5800) [' . __LINE__ . '] - Parameter param empty');
            $arrayParam = $_POST['param'];
            if (empty($arrayParam['indAll_id']))        throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter indAll_id empty');
            if (empty($arrayParam['pdf_type']))         throw new Exception('(ErrCode:xxxx) [' . __LINE__ . '] - Parameter pdf_type empty');

            if ($arrayParam['pdf_type'] === 'surat_lulus_cems') {
                $pdfCemsApprove = new Class_surat_tiada_halangan_cems();
                $pdfCemsApprove->__set('fn_task', $fn_task);
                $returnAttachment = $pdfCemsApprove->save_pdf($arrayParam['indAll_id']);
                $result = $returnAttachment['pdf_id'];
            } else if ($arrayParam['pdf_type'] === 'surat_lulus_cems') {
                $pdfPemsApprove = new Class_surat_tiada_halangan_pems();
                $pdfPemsApprove->__set('fn_task', $fn_task);
                $returnAttachment = $pdfPemsApprove->save_pdf($arrayParam['indAll_id']);
                $result = $returnAttachment['pdf_id'];
            } else if ($arrayParam['pdf_type'] === 'surat_terima_data') {
                $pdfTerimaData = new Class_surat_terima_data();
                $pdfTerimaData->__set('fn_task', $fn_task);
                $returnAttachment = $pdfTerimaData->save_pdf($arrayParam['indAll_id']);
                $result = $returnAttachment['pdf_id'];
            }
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
