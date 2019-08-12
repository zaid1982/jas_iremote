<!DOCTYPE html>
<html lang="en-us" id="extr-page">
    <head>
        <meta charset="utf-8">
        <title> Vendor Management System</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- #CSS Links -->
        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/font-awesome.min.css">
    </head>
    <style>
        table, th, td {
            border-collapse: collapse;
        }
        th, td { padding: 8px; }
        #title {
            border: 3px solid black;
        }
        #tdBorder {
            border: 1px solid black;
        }
        p.breakhere {page-break-before: always}
        #wrapper {
            position: absolute;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            border: 3px solid black;
        }
    </style>
    <body onload="window.print();">
        <div>
        <br>
        <center>
        <table width="800" border="0" >
            <tr>
                <td style="text-align: center;" colspan="3">
                    <img src="img/cyberview.png" width="400" >
                    <br><br><br>
                </td>                  
            </tr>
            <tr></tr>
            <tr>
                <td width="20%"></td>
                <td id="title" style="text-align: center; background-color: #00ff33">
                    <h2>VENDOR APPLICATION FORM</h2>                    
                </td> 
                <td width="20%"></td>
            </tr>
            <tr>
                <td colspan="3">
                    <br><br>
                    All information provided will be kept CONFIDENTIAL. Cyberview Sdn Bhd however reserves the right to verify and/or
                    follow up on any information given.<br><br>
                    Where the space is insufficient, please supply the information in separate sheets and where documentation is
                    required, only certified copies will be accepted.<br><br>
                    Incomplete submissions (including submissions with no substantiating documentation) might not be processed.
                    It is the vendor’s responsibility to inform Cyberview Sdn Bhd of any changes information.<br><br>
                    Please print and return completed form, together with substantiating documentation to:
                </td>                
            </tr>
            <tr>
                <td style="text-align: center;" colspan="3">
                    <br><br>
                    <h4>
                    PROCUREMENT DEPARTMENT,<br>
                    MARKETING & CORPORATE SERVICES DIVISION,<br>
                    </h4>
                    <h1>
                    CYBERVIEW SDN BHD<br>
                    </h1>
                    <h4>
                    BLOCK 3750,<br>
                    PERSIARAN APEC, CYBER 8,<br>
                    63000 CYBERJAYA,<br>
                    SELANGOR DARUL EHSAN<br><br>
                    TEL: 03-8315 6111<br>
                    FAX: 03-8315 6155<br><br>
                    Email: procurement@cyberview.com.my
                    </h4>
                </td>
            </tr>
        </table>
        <p class="breakhere">
        <br>
        <table width="800" border="1" >
            <td>
                <b>Type of Registration</b>
                <br><br>
                <table>
                    <tr>
                        <td>New</td>
                        <td id="tdBorder" width="30%"></td>
                        <td>Existing</td>
                        <td id="tdBorder" width="30%"></td>
                    </tr>
                </table>                
            </td>
            <td bgcolor="#00ff33">
                <b>
                <u>Procurement Department only</u><br>
                Ref. no:
                <br>
                Expiry date:
                </b>
            </td>
        </table>        
        <br>
        <table width="800" border="1" >
            <tr bgcolor="#000000">
                <td colspan="2">
                    <b>
                        <font style="color: white;">
                        1. SECTION A – COMPANY DETAIL<br>
                        (This form must be fully completed by VENDOR. Write ‘Nil’ or ‘N/A’ (not applicable) where appropriate)
                        </font>
                    </b>                     
                </td>
            </tr>                 
            <tr>
                <td width='50%'>
                    1. Company Name : <b><span id="lprc_v_vendor_name"></span></b>                
                </td>
                <td rowspan="4">
                    2. Business Operating Address : <br>
                    <b><span id="lprc_full_address"></span></b>   
                </td>
            </tr>
            <tr>
                <td>
                    3. Company Reg. No. : <b><span id="lprc_v_vendor_regNo"></span></b>
                </td>
            </tr>
            <tr>
                <td>
                    4. Contact Person : <b><span id="lprc_v_vendor_contact_person"></span></b>
                </td>
            </tr>
            <tr>
                <td>
                    5. Designation : <b><span id="lprc_v_vendor_designation"></span></b>
                </td>
            </tr>
            <tr>
                <td>
                    6. Phone No. : <b><span id="lprc_v_vendor_phone_no"></span></b>
                </td>
                <td>
                    9. Date of Incorporation : <b><span id="lprc_v_vendor_dateInc"></span></b>
                </td>
            </tr>
            <tr>
                <td>
                    7. Fax No. : <b><span id="lprc_v_vendor_fax_no"></span></b>
                </td>
                <td>
                    10. GST Registration No. : <b><span id="lprc_v_vendor_gst_no"></span></b>
                </td>
            </tr>
            <tr>
                <td>
                    8. H/P No. : <b><span id="lprc_v_vendor_mobile_no"></span></b>
                </td>
                <td>
                    11. Official E-Mail : <b><span id="lprc_v_vendor_email"></span></b>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    12. Website : <b><span id="lprc_v_vendor_website"></span></b>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    13. Nature of Business<br>
                    <ol type="a">
                        <li id="prc_bn_1">Contractor for Works</li>
                        <li id="prc_bn_2">Consultant</li>
                        <li id="prc_bn_3">Supplier</li>
                        <li id="prc_bn_4">Operator/ Facilities Management</li>
                        <li id="prc_bn_5">Others</li>
                    </ol>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    14. Area of Expertise<br>
                    <ol type="i">
                        <li>____________________________________________________________________</li>
                        <li>____________________________________________________________________</li>
                    </ol>
                </td>
            </tr>
        </table>
        <p class="breakhere">
        <br>
        <table width="800" border="1" >
            <tr bgcolor="#000000">
                <td colspan="4">
                    <b>
                        <font style="color: white;">
                        2. SECTION B – SHAREHOLDER DETAIL
                        </font>
                    </b>                     
                </td>
            </tr>                 
            <tr>
                <td rowspan="4" width="30%">
                    15. Shareholding Structure                   
                </td>
                <td>a. Bumiputra Contents</td>
                <td><b><span id="lprc_v_vendor_share_bumi"></span></b></td>
            </tr>
            <tr>
                <td>b. Non-Bumiputra Contents</td>
                <td><b><span id="lprc_v_vendor_share_nonbumi"></span></b></td>
            </tr>
            <tr>
                <td>c. Foreign Contents</td>
                <td><b><span id="lprc_v_vendor_share_foreign"></span></b></td>
            </tr>
            <tr>
                <td>Total</td>
                <td>100%</td>
            </tr>
            <tr>
                <td colspan="4">
                    16. Company Directors :                    
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    17. Organization Type : <b><span id="lprc_orgType_desc"></span></b>                  
                </td>
            </tr>
        </table>
        <br>
        <table width="800" border="1" >
            <tr bgcolor="#000000">
                <td>
                    <b>
                        <font style="color: white;">
                        3. SECTION C – CERTIFICATION OF REGISTRATION / VALIDATION OF THE DOCUMENTS
                        </font>
                    </b>                     
                </td>
            </tr>
            <tr>
                <td>
                    18. Company’s Registration or Registered with.<br><br>
                    <ol type="a">
                        <li>
                            Suruhanjaya Syarikat Malaysia (SSM)<br>
                            Expiry date : ______<b><u><span id="lprc_vendorRegCert_dateExpiry_1"></span></u></b>__________________
                        </li>
                        <br>
                        <li>
                            Kementerian Kewangan Malaysia (MOF)<br>
                            (where applicable)<br>
                            Cert. No. :______<b><u><span id="lprc_vendorRegCert_certNo_2"></span></u></b>__________________<br>
                            Ref. No. :_______________________<br>
                            Expiry date :______<b><u><span id="lprc_vendorRegCert_dateExpiry_2"></span></u></b>__________________
                        </li>
                        <br>
                        <li>
                            Professional Bodies (where applicable).<br>
                            e.g Board of Architect, Board of Engineers,<br>
                            Board of Quantity Surveyor and etc.
                        </li>
                        <br>
                        <li>
                            Bahagian Pembangunan Kontrak dan Usahawan<br>
                            (previously known as Pusat Khidmat Kontraktor(PKK))<br>
                            Reg.Gred :_____<b><u><span id="lprc_vendorRegCert_gredNo_4"></span></u></b>___________________
                        </li>
                        <br>
                        <li>
                            Construction Industry Development Board (CIDB)<br>
                            Gred :_____<b><u><span id="lprc_certGred_id_5"></span></u></b>___________________<br>
                            Category :_____<b><u><span id="lprc_certCategory_desc_5"></span></u></b>___________________<br>
                            Reg. Specialization :____________________<br>
                            Expiry date :_____<b><u><span id="lprc_vendorRegCert_dateExpiry_5"></span></u></b>___________________<br>
                        </li>
                        <br>
                        <li>
                            Others (please specify)<br>
                            ____<b><u><span id="lprc_vendorRegCert_desc_6"></span></u></b>________________<br>
                            ___________________________
                        </li>
                    </ol>
                </td>
            </tr>
        </table> 
        <br>
        <p class="breakhere">
        <table width="800" border="1" >
            <tr bgcolor="#000000">
                <td>
                    <b>
                        <font style="color: white;">
                        4. SECTION D – WORK CATEGORY
                        </font>
                    </b>                     
                </td>
            </tr>
            <tr>
                <td>
                    19. Work Category
                    <br><br>
                    <center>
                    <table width="750" border="1" id="lprc_work_category">
                        <tr bgcolor="#000000">                            
                            <td><font style="color: white;">No</font></td>
                            <td><font style="color: white;">Work Category</font></td>
                            <td><font style="color: white;">Main Category</font></td>
                            <td><font style="color: white;">Sub Category</font></td>
                        </tr>
                        <tbody></tbody>
                    </table>
                    </center>
                    <br>
                </td>
            </tr>
        </table>
        <br>
        <table width="800" border="1" >
            <tr bgcolor="#000000">
                <td>
                    <b>
                        <font style="color: white;">
                        5. SECTION E - GST REGISTRATION DOCUMENTS
                        </font>
                    </b>                     
                </td>
            </tr>
            <tr>
                <td>
                    20. GST Registration<br><br>
                    <center>
                    <table width="95%" border="1">
                        <tr>
                            <td style="text-align: center;">
                                YES
                            </td>
                            <td width="8%">
                                
                            </td>
                            <td>
                                Please provide the GST details<br>
                                (Refer SECTION F - APPENDIX 8)
                            </td>
                        </tr>
                        <tr bgcolor="#000000">
                            <td colspan="3"></td>
                        </tr>
                        <tr>
                            <td rowspan="4" style="text-align: center;">
                                NO
                            </td>
                            <td colspan="2" style="text-align: center;">
                                REASON FOR NON GST REGISTRATION
                            </td>
                        </tr>
                        <tr>
                            <td width="5%">
                                
                            </td>
                            <td width="85%">
                                Our annual turnover is ABOVE RM 500,000.00 and is currently
                                in the process to be GST registered. We will notify you once
                                our GST registration is successful
                            </td>
                        </tr>
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                Even though our annual turnover is BELOW RM 500,000.00 we
                                will register voluntarily and will notify you once the
                                registration is successful
                            </td>
                        </tr>
                        <tr>
                            <td>
                                
                            </td>
                            <td>
                                Our annual turnover is BELOW RM 500,000 and we have no
                                intention to register voluntarily
                            </td>
                        </tr>
                    </table>
                    <br>
                    </center>
                </td>
            </tr>
        </table>
        <br>
        <p class="breakhere">
        <table width="800" border="1" >
            <tr bgcolor="#000000">
                <td>
                    <b>
                        <font style="color: white;">
                        6. SECTION F – MANDATORY SUPPORTING DOCUMENTS
                        </font>
                    </b>                     
                </td>
            </tr>
            <tr>
                <td>
                    **Note: Please attach the document in A4 size as follows.
                    <br><br>
                    <ol type="1.">
                        <li>
                            APPENDIX 1
                            <ul>
                                <li>
                                    Certificate of Registration with Suruhanjaya Syarikat Malaysia (SSM)
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 2
                            <ul>
                                <li>
                                    Certificate of Registration with Kementerian Kewangan Malaysia (MOF)
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 3
                            <ul>
                                <li>
                                    Certificate of Registration with Professional Bodies (where applicable)
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 4
                            <ul>
                                <li>
                                    Certificate of Registration with Bahagian Pembangunan Kontrak dan Usahawan
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 5
                            <ul>
                                <li>
                                    Certificate of Registration with Construction Industry Development Board (CIDB)
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 6
                            <ul>
                                <li>
                                    Certificate of Registration with other specialization e.g SPANS, Safety and etc.
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 7
                            <ul>
                                <li>
                                    List of projects and works experience
                                </li>
                            </ul>
                        </li>
                        <br>
                        <li>
                            APPENDIX 8
                            <ul>
                                <li>
                                    Approval GST Registration Letter from Royal Malaysia Customs Department
                                </li>
                            </ul>
                        </li>
                    </ol>  
                </td>
            </tr>
        </table>
        <br>
        <p class="breakhere">
        <table width="800">
            <tr>
                <td width="5%">
                    21.
                </td>
                <td colspan="2">
                    COMPANY’s DECLARATION
                </td>
            </tr>
            <tr>
                <td></td>
                <td>22.1</td>
                <td>The undersigned hereby declare that all particulars contained in this completed form and all duplicate copies of certificates, letters and document attached herewith are true and accurate, and there has been no deliberate suppression of facts which are required for the completion of this form.</td>
            </tr>
            <tr>
                <td></td>
                <td>22.2</td>
                <td>The undersigned agreed that Cyberview Sdn Bhd be granted the right to contact our clients on our company’s performance and also to verify independently, our company’s financial standings with our banks.</td>
            </tr>
            <tr>
                <td></td>
                <td>22.2</td>
                <td>The undersigned also agreed to allow employees or representative of Cyberview Sdn Bhd to visit our company and inspect all the particulars furnished in the form.</td>
            </tr>
            <tr>
                <td></td>
                <td>22.2</td>
                <td>The undersigned fully understand that no consideration will be granted to our company if any of the particulars are found false and incorrect.</td>
            </tr>
            <tr>
                <td></td>
                <td>22.2</td>
                <td>
                    The undersigned accept that our company will be liable to instant de-registration without notice if:-
                    <ol type="i">
                        <li>Any particulars subsequent to our registration are found to be false and incorrect;</li>
                        <li>Our company fails to notify immediately Cyberview Sdn Bhd on any change in the shareholding and/or any major changes in our company’s organization structure; and</li>
                        <li>Our company generally appears in the market as practicing unprofessional business ethics.</li>
                    </ol>                    
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <table>
                        <tr>
                            <td>AUTHORISED SIGNATORY</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>NAME</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>DESIGNATION</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>DATE</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>COMPANY STAMP</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>            
        </table>
        <br>
        <p class="breakhere">
        <table width="800">
            <tr>
                <td colspan="3">
                    <center><u>VENDOR REGISTRATION CHECKLIST</u><br><i>[Please tick (√) the appropriate box]</i></center>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <u>Mandatory Supporting Documents for Local Company</u>
                    <br><br>
                    <center>
                    <table width="750">
                        <tr>
                            <td width="5%">1</td>
                            <td>Company Profile</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Organisation Chart</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Services Offered</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Product Information</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Catalogue</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table><br>
                    <table width="750">
                        <tr>
                            <td width="5%">2</td>
                            <td colspan="3">
                                Section E (Mandatory Supporting Documents).
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>i.</td>
                            <td>Appendix 1 – Certificate of Registration with Suruhanjaya Syarikat Malaysia.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>ii.</td>
                            <td>Appendix 2 – Certificate of Registration with Kementerian Kewangan Malaysi (MOF).</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>iii.</td>
                            <td>Appendix 3 – Certificate of Registration with Professional Bodies (where applicable).</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>iv.</td>
                            <td>Appendix 4 – Certificate of Registration with Bahagian Pembangunan Kontrak dan Usahawan.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>v.</td>
                            <td>Appendix 5 – Certificate of Registration with Construction Industry Development Board (CIDB).</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>vi.</td>
                            <td>Appendix 6 – Certificate of Registration with other specialization e.g SPANS, Safety and etc.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>vii.</td>
                            <td>Appendix 7 – List of projects and works experience.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>viii.</td>
                            <td>Appendix 8 – Approval GST Registration Letter from Royal Malaysian Customs Department</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table>    
                    </center>
                </td>
            </tr>            
            <tr>                
                <td colspan="3">
                    <br>
                    <u>Additional Documents for Private Limited and Public Limited Company</u>
                    <br><br>
                    <center>
                    <table width="750">
                        <tr>
                            <td width="5%">1</td>
                            <td>Form 9 / Form 13</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Form 24 – Return of Allotment of Shares.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Form 32A – Transfer of Shares</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Form 49 – Latest Particulars of Directors, Managers and Secretaries.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Audited Account for the last Financial Year</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>
        </table>
        <br>
        <p class="breakhere">
        <table width="800">            
            <tr>                
                <td colspan="3">
                    <br>
                    <u>Additional Documents for Sole Proprietor</u>
                    <br><br>
                    <center>
                    <table width="750">
                        <tr>
                            <td width="5%">1</td>
                            <td>Form B - Business Information & Current Owner</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Form D – Registration Confirmation</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Income Statement & Balance Sheet for the last Financial Year</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>
            <tr>                
                <td colspan="3">
                    <br>
                    <u>Additional Documents for Partnership</u>
                    <br><br>
                    <center>
                    <table width="750">
                        <tr>
                            <td width="5%">1</td>
                            <td>Form A or Certificate of Registration</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Income Statement & Balance Sheet for the last Financial Year</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>
            <tr>                
                <td colspan="3">
                    <br>
                    <u>Preferable Supporting Documents for Non Local Company</u>
                    <br><br>
                    <center>
                    <table width="750">
                        <tr>
                            <td width="5%">1</td>
                            <td>Oversea Certificate of Registration.</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Memorandum of Article (M & A)</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td width="5%">3</td>
                            <td>List of directors</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Audited Account for the last Financial Year</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>
            <tr>                
                <td colspan="3">
                    <br>
                    <u>Safety Management System</u>
                    <br><br>
                    <center>
                    <table width="750">
                        <tr>
                            <td width="5%">1</td>
                            <td>Organization chart reflective to the safety commitment</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Safety policy manual</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                        <tr>
                            <td width="5%">3</td>
                            <td>Safety training provided to the staff</td>
                            <td width="10%" id="tdBorder"></td>
                        </tr>
                    </table>
                    </center>
                </td>
            </tr>
        </table>
        </center>
        <br>
    </div>
        
<input type="hidden" id="v_vendor_id" value="<?=$_POST['v_vendor_id'] ?>" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script> if (!window.jQuery) {
        document.write('<script src="js/libs/jquery-2.1.1.min.js"><\/script>');
    }</script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script> if (!window.jQuery.ui) {
        document.write('<script src="js/libs/jquery-ui-1.10.3.min.js"><\/script>');
    }</script>
<script src="library/general.js"></script>
    
<script type="text/javascript">	        
    var otherCert = '';
    
    $(document).ready(function() {
        var v_vendor = f_get_general_info('vw_company_detail', {'v_vendor_id':$('#v_vendor_id').val()}, 'prc');
        var address = f_get_general_info('vw_address', {'address_id':v_vendor.address_id}, 'prc');
        $('#lprc_v_vendor_dateInc').html(convert_date_to_picker(v_vendor.v_vendor_dateInc));
        var vendor_business_nature = f_get_general_info_multiple('vendor_business_nature', {'v_vendor_id':$('#v_vendor_id').val()});
        $.each(vendor_business_nature, function(u){
            $('#prc_bn_' + vendor_business_nature[u].businessNature_id).css('font-weight','bold');           
        });
        var vendor_regCert = f_get_general_info_multiple('vw_vendor_regcert', {'v_vendor_id':$('#v_vendor_id').val()});
        $.each(vendor_regCert, function(u){
            if (vendor_regCert[u].regCert_id == '6') {
                otherCert = otherCert == '' ? vendor_regCert[u].vendorRegCert_desc : otherCert+', '+vendor_regCert[u].vendorRegCert_desc;
            } else {
                $('#lprc_vendorRegCert_dateExpiry_' + vendor_regCert[u].regCert_id).html(convert_date_to_picker(vendor_regCert[u].vendorRegCert_dateExpiry));
                $('#lprc_vendorRegCert_certNo_' + vendor_regCert[u].regCert_id).html(vendor_regCert[u].vendorRegCert_certNo);
                $('#lprc_vendorRegCert_gredNo_' + vendor_regCert[u].regCert_id).html(vendor_regCert[u].vendorRegCert_gredNo);
                $('#lprc_certGred_id_' + vendor_regCert[u].regCert_id).html(vendor_regCert[u].certGred_id);
                $('#lprc_certCategory_desc_' + vendor_regCert[u].regCert_id).html(vendor_regCert[u].certCategory_desc);
            }
        });  
        if (otherCert != '')
            $('#lprc_vendorRegCert_desc_6').html(otherCert);
        var work_category = f_get_general_info_multiple('dt_vendor_work_category', {'v_vendor_id':$('#v_vendor_id').val()});
        $.each(work_category, function(u){
            var trs = '<tr><td>'+(u+1)+'</td><td>'+work_category[u].workCate_desc+'</td><td>'+work_category[u].mainCate_desc+'</td><td>'+work_category[u].subCate_desc+'</td></tr>';
            $(trs).appendTo($("#lprc_work_category"));
        });
    }); 
</script>

        
    </body>    
</html>


