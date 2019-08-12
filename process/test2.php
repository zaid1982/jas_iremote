<?php
require_once '../library/db.php';
require_once '../function/f_task.php';
Class_db::getInstance()->db_connect();  
$fn_task = new Class_task();   
$fn_task->create_qa('1', '192', '3', '4');
echo 'done';
Class_db::getInstance()->db_close();
?>

