<?php

/* Error code range - 5000 */
class Class_surat_terima_data {

    private $fn_task;

    function __construct()
    {
        //$this->fn_general = new Class_general();
    }

    private function get_exception($codes, $function, $line, $msg) {
        if ($msg != '') {
            $pos = strpos($msg,'-');
            if ($pos !== false) {
                $msg = substr($msg, $pos+2);
            }
            return "(ErrCode:".$codes.") [".__CLASS__.":".$function.":".$line."] - ".$msg;
        } else {
            return "(ErrCode:".$codes.") [".__CLASS__.":".$function.":".$line."]";
        }
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new Exception($this->get_exception('0001', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
        }
    }

    public function __set( $property, $value ) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception($this->get_exception('0002', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
        }
    }

    public function __isset( $property ) {
        if (property_exists($this, $property)) {
            return isset($this->$property);
        } else {
            throw new Exception($this->get_exception('0003', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
        }
    }

    public function __unset( $property ) {
        if (property_exists($this, $property)) {
            unset($this->$property);
        } else {
            throw new Exception($this->get_exception('0004', __FUNCTION__, __LINE__, 'Get Property not exist ['.$property.']'));
        }
    }

    public function save_pdf ($indAll_id) {
        try {
            $industrial_all = Class_db::getInstance()->db_select_single('t_industrial_all', array('indAll_id'=>$indAll_id), null, 1);
            $industrial = Class_db::getInstance()->db_select_single('t_industrial', array('industrial_id'=>$industrial_all['industrial_id']), null, 1);

            $wfGroupName = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$industrial['wfGroup_id']), 'wfGroup_name', null, 1);
            $wfGroupProfile = Class_db::getInstance()->db_select_single('wf_group_profile', array('wfGroupProfile_id'=>$industrial_all['wfGroupProfile_id']), null, 1);
            $address = Class_db::getInstance()->db_select_single('vw_address', array('address_id'=>$wfGroupProfile['wfGroup_address_mail']), null, 1);
            $consultantName = '[Consultant Name]';
            if (!empty($industrial_all['consultant_id'])) {
                $consultantGroupId = Class_db::getInstance()->db_select_col('t_consultant', array('consultant_id'=>$industrial_all['consultant_id']), 'wfGroup_id', null, 1);
                $consultantName = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$consultantGroupId), 'wfGroup_name', null, 1);
                $consultantName = ucwords(strtolower($consultantName));
            }
            $datePengesahan = new DateTime();
            $datePengesahanDisplay = $datePengesahan->format('j/n/Y');

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            //$pdf->setPageOrientation('L');
            $pdf->SetTitle('Surat tiada halangan CEMS');
            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // remove default header/footer
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            // set margins
            $pdf->SetMargins(25, 10, 25);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->AddPage();

            $pdf->SetFont('times', '', 9);
            $pdf->Image('../pdf/images/logo_negara.png', 10, 8, '', 23, 'PNG', '', '', true, 150, '', false, false, 0, false, false, false);
            $pdf->Image('../pdf/images/logo_jas.jpg', 170, 8, '', 20, 'JPG', '', '', true, 150, '', false, false, 0, false, false, false);
            $content = '<table border="0" cellpadding="0">
                    <tr>
                        <td width="50px"></td>
                        <td width="350px">JABATAN ALAM SEKITAR,KEMENTERIAN SUMBER ASLI & ALAM SEKITAR,<br/>
                            ARAS 1 – 4, PODIUM 2 & 3, WISMA SUMBER ASLI,<br/> 
                            NO. 25, PERSIARAN PERDANA, PRESINT 4,<br/>
                            PUSAT PENTADBIRAN KERAJAAN PERSEKUTUAN,<br/>
                            <b>62574 PUTRAJAYA.</b><br/>
                            http://www.doe.gov.my
                        </td>
                        <td width="28px"><br/><br/><br/><br/><br/><br/>Telefon<br/>Faks</td>
                        <td width="5px"><br/><br/><br/><br/><br/><br/>:<br/>:</td>
                        <td><br/><br/><br/><br/><br/><br/>03 - 8871 2000<br/>03 - 8888 9964</td>
                    </tr>
                </table>';
            $pdf->writeHTML($content, true, false, true, false, '');
            $pdf->Line(1, 42, 209, 42);

            $pdf->SetFont('Helvetica', '', 11);
            $content = '<br/> <p style="font-weight: bold">PREMIS INDUSTRI:</p>';
            $pdf->writeHTML($content, true, false, true, false, '');

            $boxTop = $pdf->GetY();
            $content = '<br/><br/><table border="0" cellpadding="0">
                    <tr>
                        <td style="width: 8px"></td>
                        <td style="line-height: 18px">'.ucwords(strtolower($wfGroupName)).'<br/>
                            '.ucwords(strtolower($address['address_line1'])).'<br/>
                            '.$address['address_postcode'].' '.$address['city_desc'].'<br/>
                            '.$address['state_desc'].'
                        </td>
                    </tr>
                </table>';
            $pdf->writeHTML($content, true, false, true, false, '');
            $boxBottom = $pdf->GetY();
            $pdf->Line(25, $boxTop+2, 130, $boxTop+2);
            $pdf->Line(25, $boxBottom-2, 130, $boxBottom-2);
            $pdf->Line(25, $boxTop+2, 25, $boxBottom-2);
            $pdf->Line(130, $boxTop+2, 130, $boxBottom-2);

            $content = '<br/><p>Kepada yang berkenaan,</p>
                <p style="text-align: justify; font-weight: bold">SISTEM PEMANTAUAN JARAK JAUH - PENGESAHAN PENERIMAAN DATA</p>
                <p style="text-align: justify; line-height: 18px">Saya dengan ini mengesahkan bahawa <b>data pemantauan pelepasan asap dan gas</b> dari premis tuan telah diterima di dalam <b>Sistem Penguatkuasaan dan Pemantauan Jarak Jauh di Jabatan Alam Sekitar Putrajaya</b> telah diterima melalui <b>DATA INTERFACING SYSTEM (DIS)</b> yang telah dipasang oleh syarikat <b>'.$consultantName.'</b> di premis tuan.</p>                
                <p><b>TARIKH PENGESAHAN: '.$datePengesahanDisplay.'</b></p>';
            $pdf->writeHTML($content, true, false, true, false, '');

            $content = '<p></p>
                <p></p>
                <p style="font-size: small">PENAFIAN : Jabatan Alam Sekitar Malaysia tidak akan bertanggungjawab bagi sebarang kehilangan dan kerugian yang disebabkan oleh penggunaan maklumat yang diperoleh dari sistem ini.</p>                       
                <p></p>                       
                <p></p>               
                <p></p>                       
                <p></p>                       
                <p></p>                       
                <p></p>                       
                <p></p>                    
                <p></p>                    
                <p></p>                     
                <p></p>                    
                <p></p>                     
                <p></p>                    
                <p></p>                    
                <p></p>          
                <p style="font-size: smaller"><i>* This is computer generated invoice no signature required.</i></p>
                ';
            $pdf->writeHTML($content, true, false, true, false, '');

            $folder_code = floor(intval($indAll_id)/1000);
            $folder = '../pdf/surat_terima_data/'.$folder_code;

            $result = $this->fn_task->folderExist($folder);
            if (!$result) {
                mkdir ($folder,0777, true);
            }
            $filename = 'surat_terima_data_'.(100000+intval($indAll_id)).'.pdf';
            $filename_src = '\surat_terima_data\\'.$folder_code.'\\'.$filename;

            $pdf->Output(dirname(__FILE__). $filename_src, 'F');
            if (empty($industrial_all['pdf_suratTerimaData'])) {
                $pdf_id = Class_db::getInstance()->db_insert('pdf', array('pdf_filename'=>$filename, 'pdf_type'=>'surat_terima_data', 'pdf_folder'=>$folder_code));
                Class_db::getInstance()->db_update('t_industrial_all', array('pdf_suratTerimaData'=>$pdf_id), array('indAll_id'=>$indAll_id));
            } else {
                $pdf_id = $industrial_all['pdf_suratTerimaData'];
                Class_db::getInstance()->db_update('pdf', array('pdf_filename'=>$filename, 'pdf_folder'=>$folder_code), array('pdf_id'=>$pdf_id));
            }

            return array('pdf_id'=>$pdf_id, 'filename'=>$filename, 'attachment'=>$folder.'/'.$filename);
        }
        catch(Exception $ex) {
            //$this->fn_general->log_error(__FUNCTION__, __LINE__, $ex->getMessage());
            throw new Exception($this->get_exception('5001', __FUNCTION__, __LINE__, $ex->getMessage()), $ex->getCode());
        }
    }

}


