<?php

/* Error code range - 5000 */
class Class_surat_tiada_halangan_cems {

    private $fn_general;

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

    public function save_pdf ($certificateId) {
        try {

            //$seminarCompany = Class_db::getInstance()->db_select_single('sem_certificate', array('certificate_id'=>$certificateId), null, 1);
            //$htmlName = $seminarCompany['certificate_name'];
            //$htmlLocation = $seminarCompany['certificate_location'];

            // create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            //$pdf->setPageOrientation('L');
            $pdf->SetTitle('SPDP Sijil');
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
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->SetFont('times', '', 11);
            $pdf->AddPage();

            $content = '
                <br/><br/><br/><br/>
                <br/><br/><br/><br/>
                <br/><br/><br/><br/><br/>
                <table border="0" cellpadding="0" width="100%" align="center">
                    <tr>
                        <td align="center" style="font-size: 33;"><strong>SIJIL PENYERTAAN</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 14;"><i>Dengan ini disahkan bahawa</i></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 16;"><strong>jj</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 14;"><i>Telah Menghadiri</i></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 16;"><strong>PERSIDANGAN PERLINDUNGAN DATA PERIBADI<br/>(AKTA 709)</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 14;"><i>Pada</i></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 14;"><strong>jj</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 14;"><i>Bertempat di</i></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 14;"><strong>jj</strong></td>
                    </tr>
                </table>
                <br/><br/><br/><br/>
                <br/><br/><br/><br/>
                <br/>
                <table border="0" cellpadding="2" width="320px">
                    <tr>
                        <td align="center">...................................................</td>
                    </tr>
                    <tr>
                        <td align="center"><strong>MAZMALEK BIN MOHAMAD</strong></td>
                    </tr>
                    <tr>
                        <td align="center" style="font-size: 10;"><strong>KETUA PENGARAH<br/>PERLINDUNGAN DATA PERIBADI MALAYSIA</strong></td>
                    </tr>
                </table>';

            $pdf->writeHTML($content, true, false, true, false, '');
            $folder_code = floor(intval($certificateId)/1000);
            $folder = 'pdf/surat_tiada_halangan_cems/'.$folder_code;

            //$result = $this->fn_general->folderExist($folder);
            //if (!$result) {
            //    mkdir ($folder,0777, true);
            //}
            $filename = 'surat_tiada_halangan_cems_'.(10000+intval($certificateId)).'_'.time().'.pdf';
            $filename_src = '\surat_tiada_halangan_cems\\'.$folder_code.'\\'.$filename;

            //$pdf_id = Class_db::getInstance()->db_insert('sys_pdf', array('pdf_filename'=>$filename, 'pdf_type'=>'sijil', 'pdf_folder'=>$folder));
            //Class_db::getInstance()->db_update('sem_certificate', array('pdf_id'=>$pdf_id, 'certificate_time_created'=>'Now()', 'certificate_status'=>'15'), array('certificate_id'=>$certificateId));
            //Class_db::getInstance()->db_update('sem_participant', array('participant_status'=>'15'), array('certificate_id'=>$certificateId));
            $pdf->Output(dirname(__FILE__). $filename_src, 'F');

            //return $pdf_id;
        }
        catch(Exception $ex) {
            //$this->fn_general->log_error(__FUNCTION__, __LINE__, $ex->getMessage());
            throw new Exception($this->get_exception('5001', __FUNCTION__, __LINE__, $ex->getMessage()), $ex->getCode());
        }
    }

}


