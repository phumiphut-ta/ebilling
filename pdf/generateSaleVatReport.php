<?php
session_start();

require_once('../vendors/tcpdf/tcpdf.php');
require '../lib/Medoo.php';
require('../config/dbconfig.php'); /* To Set Database paramenter */

use Medoo\Medoo;
$database = new Medoo([
    'database_type' => DATABASE_TYPE,
    'database_name' => DATABASENAME,
    'server' => HOSTNAME,
    'username' => USERNAME,
    'password' => PASSWORD,
    'port' => PORT,
    'charset' => CHARSET
]);
$year=$_GET['year'];
$month=$_GET['month'];

class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}
$properties=$database->get("properties", ['company_fullname','company_taxid','vat_rate']);
$debug_frame=0;
$x_start=20;
$y_start=30;

$pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
// Add Thai font 
$THSarabun = TCPDF_FONTS::addTTFfont('../vendors/tcpdf/fonts/THSarabun_PSK/THSarabun.ttf', 'TrueTypeUnicode', '', 96);
$THSarabun_bold = TCPDF_FONTS::addTTFfont('../vendors/tcpdf/fonts/THSarabun_PSK/THSarabun_Bold.ttf', 'TrueTypeUnicode', '', 96);
// set document information
$pdf->SetCreator('ห้างหุ้นส่วนจำกัด เครเดิล เวิลด์');
$pdf->SetAuthor('ห้างหุ้นส่วนจำกัด เครเดิล เวิลด์');
$pdf->SetTitle('รายงานภาษีขาย');
$pdf->SetSubject('รายงานภาษีขาย');
$pdf->SetKeywords('รายางาน, รายงานภาษีขาย');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);

// set default monospaced font
$pdf->SetDefaultMonospacedFont('courier');

// set margins
$pdf->SetMargins('10', '20', '10');

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, "10");

// add a page
$pdf->AddPage();


// print a block of text using Write()
$pdf->SetFont($THSarabun_bold, '', 16, '', false);
$pdf->Write(0,'รายงานภาษีขาย', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont($THSarabun, '', 14, '', false);
$thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
//$pdf->Write(0,'เดือน '.$thaimonth[$month-1], '', 0, 'C', true, 0, false, false, 0);
$pdf->SetXY($x_start+15, $y_start);
$pdf->Cell(35,5,'เดือนภาษี '.$thaimonth[$month-1], $debug_frame, 0,'L');
$pdf->SetX($x_start+110);
$pdf->Cell(30,5,'ปี พ.ศ.'.($year+543), $debug_frame, 0,'L');

$pdf->SetXY($x_start+5,$y_start+7);
$pdf->Cell(80,5,'ชื่อผู้ประกอบการ '.$properties['company_fullname'], $debug_frame, 0,'L');
$pdf->SetX($x_start+110);
$pdf->Cell(70,5,'เลขประจำตัวผู้เสียภาษีอากร '.$properties['company_taxid'], $debug_frame, 0,'L');

$pdf->SetXY($x_start+5,$y_start+15);
$pdf->Cell(80,5,'ชื่อสถานประกอบการ '.$properties['company_fullname'], $debug_frame, 0,'L');
$pdf->SetX($x_start+110);
$pdf->Cell(70,5,'สำนักงานใหญ่', $debug_frame, 0,'L');

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <td rowspan="3">COL 1 - ROW 1<br />COLSPAN 3<br />text line<br />text line<br />text line<br />text line<br />text line<br />text line</td>
        <td>COL 2 - ROW 1</td>
        <td>COL 3 - ROW 1</td>
    </tr>
    <tr>
    	<td rowspan="2">COL 2 - ROW 2 - COLSPAN 2<br />text line<br />text line<br />text line<br />text line</td>
    	 <td>COL 3 - ROW 2<br />text line<br />text line</td>
    </tr>
    <tr>
       <td>COL 3 - ROW 3</td>
    </tr>

</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
//Close and output PDF document
$pdf->Output('Salevatreport.pdf', 'I');
