<?php
header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
$form_data = array();
$form_data['result'] = 'test';
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

//require_once '../library/db.php';
//require_once '../function/f_task.php';
//Class_db::getInstance()->db_connect();  
//$fn_task = new Class_task();   
//echo ($fn_task->get_registration_no('191'));
//Class_db::getInstance()->db_close();
?>

