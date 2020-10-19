<?php

/* Error code range - 5000 */
class Class_surat_tiada_halangan_cems {

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

            $designation = Class_db::getInstance()->db_select_col('wf_group_user', array('user_id'=>$industrial_all['indAll_contactPerson'], 'wfGroup_id'=>$industrial['wfGroup_id']), 'wfGroupUser_designation');
            if (!empty($designation)) {
                $designation = ucwords(strtolower($designation)).'<br/>';
            }
            $dateLetter = new DateTime();
            $dateLetterDisplay = $dateLetter->format('j M, Y');

            $contactPersonProfileId = Class_db::getInstance()->db_select_col('user', array('user_id'=>$industrial_all['indAll_contactPerson']), 'profile_id', null, 1);
            $contactPersonProfile = Class_db::getInstance()->db_select_single('profile', array('profile_id'=>$contactPersonProfileId), null, 1);
            $wfGroupName = Class_db::getInstance()->db_select_col('wf_group', array('wfGroup_id'=>$industrial['wfGroup_id']), 'wfGroup_name', null, 1);
            $wfGroupProfile = Class_db::getInstance()->db_select_single('wf_group_profile', array('wfGroupProfile_id'=>$industrial_all['wfGroupProfile_id']), null, 1);
            $address = Class_db::getInstance()->db_select_single('vw_address', array('address_id'=>$wfGroupProfile['wfGroup_address_mail']), null, 1);
            $addressStack = Class_db::getInstance()->db_select_single('vw_address', array('address_id'=>$wfGroupProfile['wfGroup_address']), null, 1);
            $timeSubmitted = Class_db::getInstance()->db_select_col('wf_task', array('wfTrans_id'=>$industrial_all['wfTrans_id'], 'wfTaskType_id'=>'31'), 'wfTask_timeSubmitted', null, 1);
            $dateSubmit = new DateTime($timeSubmitted);
            $dateSubmitDisplay = $dateSubmit->format('j M, Y');

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
            $pdf->SetMargins(25, 20, 25);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->SetFont('Helvetica', '', 12);
            $pdf->AddPage();

            $content = '
                <p style="text-align: right; font-weight: bold">LAMPIRAN 2</p>
                <p style="text-align: right">Rujukan: '.$industrial['industrial_jasFileNo'].' (   )<br/>'.$this->fn_task->replace_month_bm($dateLetterDisplay).'</p>
                <p>'.ucwords(strtolower($contactPersonProfile['profile_name'])).'<br/>
                '.$designation.ucwords(strtolower($wfGroupName)).'<br/>
                '.ucwords(strtolower($address['address_line1'])).'<br/>
                '.$address['address_postcode'].' '.$address['city_desc'].'<br/>
                '.$address['state_desc'].'
                </p>
                <p>Tuan,</p>
                <p style="text-align: justify; font-weight: bold">PERMOHONAN PEMASANGAN <i>CONTINUOUS EMISSION MONITORING SYSTEM (C.E.M.S)</i> BAGI LOJI '.$industrial_all['indAll_stackNo'].' DI '.strtoupper($addressStack['city_desc']).', BAGI TUJUAN PEMANTAUAN BERTERUSAN OLEH '.strtoupper($wfGroupName).'</p>
                <p style="text-align: justify">Saya dengan hormatnya merujuk kepada permohonan tuan dan Cadangan Pemasangan "Continous Emission Monitoring System (CEMS) for Stack '.$industrial_all['indAll_stackNo'].', '.$addressStack['city_desc'].'" yang diterima pada '.$this->fn_task->replace_month_bm($dateSubmitDisplay).' adalah berkaitan.</p>
                <p style="text-align: justify">2.	Jabatan ini telah meneliti cadangan pemasangan sistem CEMS di Loji '.$industrial_all['indAll_stackNo'].' yang telah dikemukakan, Jabatan ini mendapati skop keperluan minimum seperti di Lampiran 3 bagi pemasangan sistem CEMS telah diambilkira.</p>
                <p style="text-align: justify">3.	Sehubungan dengan ini Jabatan ini tiada halangan untuk pelaksanaan pemasangan sistem CEMS di loji tersebut dalam tempoh BBB bulan. Oleh yang demikian pihak tuan hendaklah memastikan kesemua maklumat seperti di <b>Lampiran 7</b> hendaklah diambil kira bagi pembangunan sistem tersebut dan perlu dilaporkan di dalam Laporan Initial Quality Assurance yang akan dikemukakan kelak. </p>
                <p style="text-align: justify">4.	Selain daripada itu, pihak tuan juga hendaklah memaklumkan kepada Jabatan ini tarikh verifikasi yang akan dilaksanakan dalam tempoh 2 minggu sebelum pelaksanaan verikasi tersebut.</p>
                <p style="text-align: justify">5.	Kerjasama tuan dalam menjaga kualiti alam sekeliling kita adalah sangat dihargai.</p>
                <p>Sekian, terima kasih.</p>  
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
            $folder = '../pdf/surat_lulus_cems/'.$folder_code;

            $result = $this->fn_task->folderExist($folder);
            if (!$result) {
                mkdir ($folder,0777, true);
            }
            $filename = 'surat_lulus_cems_'.(100000+intval($indAll_id)).'.pdf';
            $filename_src = '\surat_lulus_cems\\'.$folder_code.'\\'.$filename;

            $pdf->Output(dirname(__FILE__). $filename_src, 'F');
            if (empty($industrial_all['pdf_suratLulus'])) {
                $pdf_id = Class_db::getInstance()->db_insert('pdf', array('pdf_filename'=>$filename, 'pdf_type'=>'surat_lulus_cems', 'pdf_folder'=>$folder_code));
                Class_db::getInstance()->db_update('t_industrial_all', array('pdf_suratLulus'=>$pdf_id), array('indAll_id'=>$indAll_id));
            } else {
                $pdf_id = $industrial_all['pdf_suratLulus'];
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


