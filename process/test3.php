<?php
require_once '../library/db.php';
require_once '../function/f_task.php';
require_once '../tcpdf/tcpdf.php';
require_once '../pdf/surat_terima_data.php';

Class_db::getInstance()->db_connect();
$fn_task = new Class_task();
$test = new Class_surat_terima_data();
$test->__set('fn_task', $fn_task);
$result = $test->save_pdf('999');
echo $result['filename'].'<br/>';
echo $result['attachment'];
Class_db::getInstance()->db_close();


