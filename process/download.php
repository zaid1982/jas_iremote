<?php
require_once '../library/db.php';
Class_db::getInstance()->db_connect(); 
$result = Class_db::getInstance()->db_select_single('document', array('document_id'=>$_GET['doc_id']));
Class_db::getInstance()->db_close();

download($result['document_folder'].'/'.$result['document_filename'].'.'.$result['document_extension'], $result['document_uplname']);
function download($file, $filename) {
    if (file_exists($file)) {
        $file_uplname = str_replace(',', ' ', $filename);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$file_uplname);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}
?>