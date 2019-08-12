<?php

class Class_upload {
     
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
    
    public function folder_exist($folder) {
        // Get canonicalized absolute pathname
        $path = realpath($folder);
        // If it exist, check if it's a directory
        return ($path !== false AND is_dir($path)) ? $path : false;
    }
    
    public function upload_file ($type, $files=array(), $title='', $docName_id='', $remark='') {
        try {
            $this->log_debug(__FUNCTION__, __LINE__, "entering upload_file()");
            if (!empty($files)){
                $result = 0;
                if ( 0 < $files['error'] ) {
                    throw new Exception('(ErrCode:1106) ['.__LINE__.'] - Upload error - '.$files['error']);
                } else {
                    $new_name = '';
                    $userfile_name = $files['name'];
                    $userfile_extn = substr($userfile_name, strrpos($userfile_name, '.')+1);
                    if ($type == 1) {
                        $this->log_debug(__FUNCTION__, __LINE__, 'Extension : '.$userfile_extn);
                        if ($userfile_extn == 'xls' || $userfile_extn == 'xlsx' || $userfile_extn == 'jpg' || $userfile_extn == 'pdf' || $userfile_extn == 'xls' || $userfile_extn == 'doc' 
                            || $userfile_extn == 'docx' || $userfile_extn == 'jpeg' || $userfile_extn == 'png' || $userfile_extn == 'ppt' || $userfile_extn == 'pptx') {                            
                            $document_id = Class_db::getInstance()->db_insert('document', array('document_name'=>$title, 'documentName_id'=>$docName_id, 'document_extension'=>$userfile_extn, 'document_timeUpload'=>'Now()', 'document_remarks'=>$remark, 'document_uplname'=>$userfile_name));
                            $new_name = 'f_'.(10000+$document_id);
                            $this->log_debug(__FUNCTION__, __LINE__, 'new_name : '.$new_name);
                            $folder = '../upload/logs/'.(floor($document_id/1000));
                            $this->log_debug(__FUNCTION__, __LINE__, 'folder to upload : '.$folder);
                            $result = $this->folder_exist($folder);
                            if (!$result)
                                mkdir ($folder,0777, true);                                 
                        } else                                 
                            throw new Exception('(ErrCode:1104) ['.__LINE__.'] - Jenis dokumen tidak dibenarkan untuk dimuatnaik.', 31);
                    } else {
                        throw new Exception('(ErrCode:1104) ['.__LINE__.'] - Upload type error.');
                    }   
                    if (move_uploaded_file($files['tmp_name'], $folder.'/'.$new_name.'.'.$userfile_extn)) {                        
                        $result = Class_db::getInstance()->db_update('document', array('document_status'=>'1', 'document_filename'=>$new_name, 'document_folder'=>$folder), array('document_id'=>$document_id));
                    } else
                        throw new Exception('(ErrCode:1103) ['.__LINE__.'] - Move uploaded file error.');
                    
                }
                if ($result == 0 )
                    throw new Exception('(ErrCode:1105) ['.__LINE__.'] - Upload error.');
                return $document_id;
            } else {
                throw new Exception($this->get_exception('1101', __FUNCTION__, __LINE__, 'Parameter $files empty.'));
            }
        }
        catch(Exception $e) {
            error_log(date("Y/m/d h:i:sa")." [".__FILE__.":".__LINE__."] - ".$e->getMessage()."\r\n", 3, $this->log_dir.'/error/error_'.date("Ymd").'.log');
            throw new Exception($this->get_exception('1101', __FUNCTION__, __LINE__, $e->getMessage()), $e->getCode());
        }
    }
    
}

?>
