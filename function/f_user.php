<?php

class Class_user {
     
    public $default_menuId = '';
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
    
    public function get_menu_list ($user_id) {
        try {
            $arrayMenu = array();
            $menu_id = '';
            $submenu_id = '';
            $result = Class_db::getInstance()->db_select('vw_menu_list', array(), 'userMenu_turn, menu_id, menu2nd_id, menu3rd_id', NULL, 2, array('user_id'=>$user_id));
            foreach ($result as $key => $value) {
                if ($menu_id != $value['menu_id']) {                     
                    if ($menu_id == '')
                        $this->default_menuId = $value['menu_id'];
                    $menu_id = $value['menu_id'];
                    $arrayMenu[$menu_id] = array('menu_name'=>$value['menu_name'], 'userMenu_page'=>$value['userMenu_page'], 'userMenu_icons'=>$value['userMenu_icons'], 'sub_menu'=>array());
                    $submenu_id = '';
                }
                if ($value['menu2nd_id'] != '') {  
                    if ($submenu_id != $value['menu2nd_id']) {
                        $submenu_id = $value['menu2nd_id'];
                        $arrayMenu[$menu_id]['sub_menu'][$submenu_id] = array('menu2nd_name'=>$value['menu2nd_name'], 'userMenu_page'=>$value['userMenu_page'], 'sub_menu'=>array());
                    }
                    if ($value['menu3rd_id'] != '') { 
                        $submenu3rd_id = $value['menu3rd_id'];
                        $arrayMenu[$menu_id]['sub_menu'][$submenu_id]['sub_menu'][$submenu3rd_id] = array('menu3rd_name'=>$value['menu3rd_name'], 'userMenu_page'=>$value['userMenu_page']);
                    }
                }
            }
            return $arrayMenu;
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1001', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function register_new_industry($user_id, $wfGroup_id, $jasFileNo) {
        try {
            Class_db2::getInstance()->db_connect();
            $premise = Class_db2::getInstance()->db_select_single('premis', array('nofailjas'=>$jasFileNo));
            Class_db2::getInstance()->db_close();
            if (empty($premise)) 
                return '2';
            else if ($premise['STATUSPREMIS'] == 'Tutup') 
                return '3';
            $city_id_p = $premise['PKODBANDAR'] != '' && $premise['PKODNEGERI'] != '' ? Class_db::getInstance()->db_select_col('vw_city_state', array('state_code'=>$premise['PKODNEGERI'], 'city_desc'=>$premise['PKODBANDAR']), 'city_id') : '';
            $city_id_s = $premise['SKODBANDAR'] != '' && $premise['SKODNEGERI'] != '' ? Class_db::getInstance()->db_select_col('vw_city_state', array('state_code'=>$premise['SKODNEGERI'], 'city_code'=>$premise['SKODBANDAR']), 'city_id') : '';
            $location_id = Class_db::getInstance()->db_insert('location', array('location_type'=>'1', 'city_id'=>$city_id_p, 'location_longitude'=>$premise['LONGITUDE'], 'location_latitude'=>$premise['LATITUDE']));
            $address_id_p = Class_db::getInstance()->db_insert('address', array('city_id'=>$city_id_p, 'address_line1'=>$premise['PALAMAT'], 'address_postcode'=>$premise['PPOSKOD']));
            $address_id_s = Class_db::getInstance()->db_insert('address', array('city_id'=>$city_id_p, 'address_line1'=>$premise['SALAMAT'], 'address_postcode'=>$premise['SPOSKOD']));
            $subSic_id = Class_db::getInstance()->db_select_col('ref_sub_sic', array('subSic_code'=>$premise['SUB_SIC']), 'subSic_id');
            $parlimen_id = Class_db::getInstance()->db_select_col('ref_parlimen', array('parlimen_code'=>$premise['PARLIMEN']), 'parlimen_id');
            Class_db::getInstance()->db_insert('t_industrial', array('wfGroup_id'=>$wfGroup_id, 'industrial_createdBy'=>$user_id, 'industrial_jasFileNo'=>$jasFileNo, 'location_id'=>$location_id, 'subSic_id'=>$subSic_id, 'parlimen_id'=>$parlimen_id,
                'industrial_premiseId'=>$premise['IDPREMIS']));
            $wfGroupProfile_id = Class_db::getInstance()->db_insert('wf_group_profile', array('wfGroup_id'=>$wfGroup_id, 'wfGroupProfile_createdBy'=>$user_id, 'wfGroup_address'=>$address_id_p, 'wfGroup_address_mail'=>$address_id_s,
                'wfGroup_phoneNo'=>$premise['PNOTELEFON'], 'wfGroup_faxNo'=>$premise['PNOFAKS']));                     
            Class_db::getInstance()->db_update('wf_group', array('wfGroupProfile_id'=>$wfGroupProfile_id, 'wfGroup_name'=>ucwords(strtolower($premise['NAMAPREMIS']))), array('wfGroup_id'=>$wfGroup_id));
            return '1';            
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1001', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
    public function check_ldap($user_name, $user_password) {
        try {
            $this->log_debug(__FUNCTION__, __LINE__, 'Entering check_ldap...');
            $results = 0;
            $adServer = "ldap://10.19.158.15";
            //$ldap = ldap_connect($adServer) or die("Could not connect to {$adServer}");
			//$this->log_debug(__FUNCTION__, __LINE__, 'Connected to ldap..');
            $domain = "@doe.gov.my";
            $username = $user_name; //"cemsadmin";
            $password = $user_password; //"cems2020";
            //------------------------------------------------------------------------------
            // Connect to the LDAP server.
            //------------------------------------------------------------------------------
            $ldap_connection = ldap_connect($adServer);
            if (FALSE === $ldap_connection){
                throw new Exception('(ErrCode:2001) ['.__LINE__.'] - Failed to connect to the LDAP server: '.$adServer);
            }            
            $this->log_debug(__FUNCTION__, __LINE__, 'Connected to ldap..');
            $results = 1;
            if (TRUE !== ldap_bind($ldap_connection, $username.$domain, $password)){
                $results = 0;
            } 
            ldap_unbind($ldap_connection); // Clean up after ourselves.
            $this->log_debug(__FUNCTION__, __LINE__, 'Exiting check_ldap...');        
            return $results;
        }
        catch(Exception $e) {
            return 0;
        }
    }
    
}

?>
