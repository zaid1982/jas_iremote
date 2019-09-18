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

    public function save_pdf ($wfTask_id) {
        try {
            $wf_task = Class_db::getInstance()->db_select_single('wf_task', array('wfTask_id'=>$wfTask_id), null, 1);
            $industrial_all = Class_db::getInstance()->db_select_single('t_industrial_all', array('wfTrans_id'=>$wf_task['wfTrans_id']), null, 1);
            $industrial = Class_db::getInstance()->db_select_single('t_industrial', array('industrial_id'=>$industrial_all['industrial_id']), null, 1);

            $contactPersonProfileId = Class_db::getInstance()->db_select_col('user', array('user_id'=>$industrial_all['indAll_contactPerson']), 'profile_id', null, 1);
            $contactPersonProfile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$contactPersonProfileId), null, 1);
            $wfGroupName = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$industrial['wfGroup_id']), 'wfGroup_name', null, 1);
            $wfGroupProfile = Class_db::getInstance()->db_select_single('wf_group_profile', array('wfGroupProfile_id'=>$industrial_all['wfGroupProfile_id']), null, 1);
            $address = Class_db::getInstance()->db_select_single('vw_address', array('address_id'=>$wfGroupProfile['wfGroup_address_mail']), null, 1);
            $addressStack = Class_db::getInstance()->db_select_single('vw_address', array('address_id'=>$wfGroupProfile['wfGroup_address']), null, 1);
            $timeSubmitted = Class_db::getInstance()->db_select_col('wf_task', array('wfTrans_id'=>$wf_task['wfTrans_id'], 'wfTaskType_id'=>'31'), 'wfTask_timeSubmitted', null, 1);
            $dateSubmit = new DateTime($timeSubmitted);
            $dateSubmitDisplay = $dateSubmit->format('j/n/Y');

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
                <p style="text-align: justify; line-height: 18px">Saya dengan ini mengesahkan bahawa <b>data pemantauan pelepasan asap dan gas</b> dari premis tuan telah diterima di dalam <b>Sistem Penguatkuasaan dan Pemantauan Jarak Jauh di Jabatan Alam Sekitar Putrajaya</b> mulai daripada '.$dateSubmitDisplay.' sehingga '.$dateSubmitDisplay.' telah diterima melalui <b>DATA INTERFACING SYSTEM (DIS)</b> yang teah dipasang oleh syarikat XXX di premis tuan.</p>
                
                <p><b>TARIKH PENGESAHAN: 24/07/2017</b><br/><br/><br/><br/><br/><br/><br/></p>';
            $pdf->writeHTML($content, true, false, true, false, '');

            $pdf->Line(25, $pdf->GetY(), 90, $pdf->GetY());
            $pdf->SetFont('Helvetica', '', 10);
            $content = '<p>Nama : TUAN HAJI ISMAIL BIN ITHNIN<br/>
                Jawatan : TIMBALAN KETUA PENGARAH (PEMBANGUNAN)<br/>
                Jabatan : JABATAN ALAM SEKITAR PUTRAJAYA</p>';
            $pdf->writeHTML($content, true, false, true, false, '');

            $pdf->SetFont('Helvetica', '', 8);
            $content = '<br/><p>PENAFIAN : Jabatan Alam Sekitar Malaysia tidak akan bertanggungjawab bagi sebarang kehilangan dan kerugian yang disebabkan oleh penggunaan maklumat yang diperoleh dari sistem ini.</p>';
            $pdf->writeHTML($content, true, false, true, false, '');

            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                $pdf->setPage($pdf->getPage());
            }

            $pdf->SetFont('Helvetica', '', 10);
            $content = '<br/><p><b>Salinan Kepada :</b></p>
            <p>Pengarah,<br/>JAS Negeri Sarawak<br/>(u/p : En Fathuddin Bin Mohd Abbas)</p>
            <p>Pengurus,<br/>XXX<br/>(u/p : YYY)</p>';
            $pdf->writeHTML($content, true, false, true, false, '');

            $indAll_id = $industrial_all['indAll_id'];
            $folder_code = floor(intval($indAll_id)/1000);
            $folder = '../pdf/surat_terima_data/'.$folder_code;

            $result = $this->fn_task->folderExist($folder);
            if (!$result) {
                mkdir ($folder,0777, true);
            }
            $filename = 'surat_terima_data_'.(100000+intval($wfTask_id)).'_'.time().'.pdf';
            $filename_src = '\surat_terima_data\\'.$folder_code.'\\'.$filename;

            //$pdf_id = Class_db::getInstance()->db_insert('pdf', array('pdf_filename'=>$filename, 'pdf_type'=>'surat_terima_data', 'pdf_folder'=>$folder));
            //Class_db::getInstance()->db_update('t_industrial_all', array('pdf_suratLulus'=>$pdf_id), array('indAll_id'=>$indAll_id));
            $pdf->Output(dirname(__FILE__). $filename_src, 'F');

            return array('filename'=>$filename, 'attachment'=>$folder.'/'.$filename);
        }
        catch(Exception $ex) {
            //$this->fn_general->log_error(__FUNCTION__, __LINE__, $ex->getMessage());
            throw new Exception($this->get_exception('5001', __FUNCTION__, __LINE__, $ex->getMessage()), $ex->getCode());
        }
    }

}


