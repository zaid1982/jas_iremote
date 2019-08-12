<?php

require_once '../library/db.php';
try {
    Class_db::getInstance()->db_connect();        
    Class_db::getInstance()->db_beginTransaction();
    Class_db::getInstance()->db_update('ref_general', array('general_value'=>'|general_value+1'), array('general_id'=>'1'));
    Class_db::getInstance()->db_commit();
    Class_db::getInstance()->db_close();
} catch (Exception $ex) {
    Class_db::getInstance()->db_rollback();
}
Class_db::getInstance()->db_close();


?>