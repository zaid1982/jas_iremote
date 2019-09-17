<?php
require_once '../library/db.php';
require_once '../tcpdf/tcpdf.php';
require_once '../pdf/surat_tiada_halangan_cems.php';

Class_db::getInstance()->db_connect();
$test = new Class_surat_tiada_halangan_cems();
$test->save_pdf('1');
echo 'done';
Class_db::getInstance()->db_close();


