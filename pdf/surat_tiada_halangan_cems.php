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
            $pdf->SetMargins(25, 20, 25);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, 15);
            $pdf->SetFont('Helvetica', '', 12);
            $pdf->AddPage();

            $content = '
                <p style="text-align: right; font-weight: bold">LAMPIRAN 2</p>
                <p style="text-align: right">Rujukan: AS91/110/622/1489 (   )<br/>XXX 2015</p>
                <p>Encik Wan M Muzani b Hj Wan Muda<br/>
                Pengurus Besar<br/>
                Jabatan Perkhidmatan Teknikal<br/>
                Malaysia LNG Sdn Bhd<br/>
                Petronas LNG Complex<br/>
                Tanjung Kidurung<br/>
                P.O.BOx 89<br/>
                97007 BINTULU<br/>
                Sarawak
                </p>
                <p>Tuan,</p>
                <p style="text-align: justify; font-weight: bold">PERMOHONAN PEMASANGAN <i>CONTINUOUS EMISSION MONITORING SYSTEM (C.E.M.S)</i> BAGI LOJI XXX DI YYY, BAGI TUJUAN PEMANTAUAN BERTERUSAN OLEH ZZZ. BHD.</p>
                <p style="text-align: justify">Saya dengan hormatnya merujuk kepada permohonan tuan dan Cadangan Pemasangan Continous Emission Monitoring System (CEMS) for XXX, YYY “yang diterima pada XXXXX adalah berkaitan.</p>
                <p style="text-align: justify">2.	Jabatan ini telah meneliti cadangan pemasangan sistem CEMS di loji XXX yang telah dikemukakan, Jabatan ini mendapati skop keperluan minimum seperti di Lampiran 3 bagi pemasangan sistem CEMS telah diambilkira.</p>
                <p style="text-align: justify">3.	Sehubungan dengan ini Jabatan ini tiada halangan untuk pelaksanaan pemasangan sistem CEMS di loji tersebut dalam tempoh BBB bulan. Oleh yang demikian pihak tuan hendaklah memastikan kesemua maklumat seperti di <b>Lampiran 7</b> hendaklah diambil kira bagi pembangunan sistem tersebut dan perlu dilaporkan di dalam Laporan Initial RATA yang akan dikemukakan kelak. </p>
                <p style="text-align: justify">4.	Selain daripada itu, pihak tuan juga hendaklah memaklumkan kepada Jabatan ini tarikh verifikasi yang akan dilaksanakan dalam tempoh 2 minggu sebelum pelaksanaan verikasi tersebut.</p>
                <p style="text-align: justify">5.	Kerjasama tuan dalam menjaga kualiti alam sekeliling kita adalah sangat dihargai.</p>
                <p>Sekian, terima kasih.</p>                
                <br/>
                <p style="font-weight: bold">“BERKHIDMAT UNTUK NEGARA”<br/>
                “INTEGRITI ASAS PENINGKATAN KUALITI”
                </p>
                ';
            $pdf->writeHTML($content, true, false, true, false, '');

            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                $pdf->setPage($pdf->getPage());
            }
            $content = '<p>Saya yang menurut perintah,</p>
                <br/>
                <p><b>(Dato’ Dr. Ahmad Kamarulnajuib bin Che Ibrahim)</b><br/>
                Timbalan Ketua Pengarah (Pembangunan)<br/>
                b.p. Ketua Pengarah Jabatan Alam Sekitar Malaysia<br/>
                </p>
                <p>s.k:</p>
                <table border="0" cellpadding="0">
                    <tr>
                        <td style="width: 25px"></td>
                        <td>Pengarah<br/>Jabatan Alam Sekitar Negeri Sarawak</td>
                    </tr>
                </table>
                ';

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


