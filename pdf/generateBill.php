<?php
session_start();
//require('../vendors/tcpdf/tcpdf.php');
require('../vendors/fpdf/fpdf.php');
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

//$bill_id=Decrypt("PHUMIPHUT",$_GET['id']); echo "aaa:".$bill_id;
$bill_id=$_GET['id'];

 
$bill=$database->get('bill_master',['bill_no','customer_id','branch_id','ref_no','payment_term','billing_date','discount_type','discount_custom','create_id','notice','contact'],['id'=>$bill_id,'deleted'=>0]);

$templates=array('1_invoice_original.jpg','2_invoice_copy.jpg','3_tax_invoice_original.jpg','4_tax_invoice_copy.jpg','4_tax_invoice_copy.jpg','4_tax_invoice_copy.jpg');

$pdf = new FPDF('P','mm','A4'); /* A4 width 210 x 297 mm */
// Add Thai font 
$pdf->AddFont('THSarabunNew','','THSarabunNew.php');
$pdf->AddFont('THSarabunNew','B','THSarabunNew_b.php');

$pdf->SetTitle(iconv( 'UTF-8','cp874' , 'bill no.'.$bill['bill_no'] ));

foreach($templates as $template)
{
    $pdf->AddPage();
    $pdf->Image("template/".$template, 10, 15, 190, ''); //แทรกรูปพื้นหลัง ขอบด้านข้าง 10 mm ขอบแนวตั้ง 20 mm
    $pdf->SetFont('THSarabunNew','B',13);

    $customer=$database->get('customer_detail',['customer_fullname','customer_address_row1','customer_address_row2','customer_tel','customer_fax','customer_taxid'],['id' => $bill['customer_id']]);
    $pdf->Text(15, 63.6, iconv( 'UTF-8','cp874' , $customer['customer_fullname'].' (สำนักงานใหญ่)' )); //ชื่อลูกค้า
    $pdf->Text(15, 73, iconv( 'UTF-8','cp874' , $customer['customer_address_row1'] )); //ชื่อที่อยู่ลูกค้า1
    $pdf->Text(15, 79, iconv( 'UTF-8','cp874' , $customer['customer_address_row2'] )); //ชื่อที่อยู่ลูกค้า2
    $pdf->Text(62, 85.5, iconv( 'UTF-8','cp874' , $customer['customer_taxid'] )); //เลขที่กำกับภาษี
    $pdf->Text(62, 90, iconv( 'UTF-8','cp874' , $customer['customer_tel'] )); //เบอร์ติดต่อ
    $pdf->Text(62, 94.5, iconv( 'UTF-8','cp874' , $bill['contact'] )); //ชื่อผู้ติดต่อ

    $pdf->Text(165, 59.5, iconv( 'UTF-8','cp874' , $bill['bill_no'] )); //เลขที่ใบเสร็จ
    list($year,$month, $day) = split('-', $bill['billing_date']);
    $pdf->Text(165, 64, iconv( 'UTF-8','cp874' , $day.'/'.$month.'/'.($year+543) )); //วันที่ออกบิล
    $pdf->Text(165, 68.5, iconv( 'UTF-8','cp874' , $bill['ref_no'] )); //เลขที่ใบสั่งซื้อ
    if($bill['payment_term']!='')
    {
        $pdf->Text(165, 72.5, iconv( 'UTF-8','cp874' , $bill['payment_term']." วัน" )); //เงื่อนไขการชำระเงิน
    }
    $depart=$database->get('customer_branch',['branch_number','branch_fullname','branch_tel','branch_address_row1','branch_address_row2','branch_address_row3'],['id'=>$bill['branch_id']]);
    $pdf->Text(112, 82.2, iconv( 'UTF-8','cp874' , $depart['branch_fullname'] )); //ชื่อสถานที่ส่ง
    $pdf->Text(112, 88.2, iconv( 'UTF-8','cp874' , $depart['branch_address_row1']." ".$depart['branch_address_row2'] )); //ที่อยู่สถานที่ส่ง 1
    $pdf->Text(112, 94.2, iconv( 'UTF-8','cp874' , $depart['branch_address_row3']." Tel.".$depart['branch_tel'] )); //ที่อยู่สถานที่ส่ง 2


    $sqlCommand="
    SELECT bp.product_no, bp.product_description, bd.quantity,bp.barcode,bp.price
    FROM bill_detail bd
    INNER JOIN bill_master bm ON bd.bill_id = bm.id
    INNER JOIN bill_price bp ON bd.product_id = bp.product_id AND bd.bill_id = bp.bill_id
    WHERE bm.id= $bill_id";
    $product=$database->query($sqlCommand)->fetchAll();

    $x_start=10;
    $y_start=114;
    $debug_frame=0;
    $pdf->SetFont('THSarabunNew','B',12);      
    for($i=0;$i<count($product);$i++)
    {
      $pdf->SetXY($x_start, $y_start);
      $pdf->Cell(12.5,5,$i+1, $debug_frame, 0,'C');
      $pdf->SetX($x_start+12.5);
      $pdf->Cell(25.7,5,iconv( 'UTF-8','cp874' , $product[$i]['barcode'] ), $debug_frame, 0,'C');
      $pdf->SetX($x_start+42);
      $pdf->Cell(58,5,iconv( 'UTF-8','cp874' , $product[$i]['product_description'] ), $debug_frame, 0,'L');
      $pdf->SetX($x_start+100);
      $pdf->Cell(13.8,5,$product[$i]['quantity'], $debug_frame, 0,'C');
      $pdf->SetX($x_start+113.8);  
      $pdf->Cell(10.3,5,iconv( 'UTF-8','cp874' , "ชุด" ), $debug_frame, 0,'C');
      $pdf->SetX($x_start+124.1);
      $pdf->Cell(20.5,5,number_format($product[$i]['price'], 2, '.', ','), $debug_frame, 0,'R');
      if($bill['discount_type']==1)
      {
        $pdf->SetX($x_start+144.1);
        $pdf->Cell(16,5,number_format($bill['discount_custom'], 2, '.', ','), $debug_frame, 0,'R');
        $pdf->SetX($x_start+160);
        $pdf->Cell(30,5,number_format(($product[$i]['price']-$bill['discount_custom'])*$product[$i]['quantity'], 2, '.', ','), $debug_frame, 0,'R');
      }
      if($bill['discount_type']==2) 
      {
        $pdf->SetX($x_start+144.1);
        $pdf->Cell(16,5,number_format(((($bill['discount_custom'])/100)*$product[$i]['price']), 2, '.', ','), $debug_frame, 0,'R');
        $pdf->SetX($x_start+160);
        $pdf->Cell(30,5,number_format(((100-$bill['discount_custom'])/100)*($product[$i]['price']*$product[$i]['quantity']), 2, '.', ','), $debug_frame, 0,'R');
      }
      $y_start+=5;
    }
    $sqlCommand="
    SELECT SUM(bd.quantity*bp.price)SUM FROM bill_detail bd
    INNER JOIN bill_master bm ON bd.bill_id = bm.id
    INNER JOIN bill_price bp ON bd.product_id = bp.product_id AND bd.bill_id = bp.bill_id
    WHERE bm.id= $bill_id";
    $array=$database->query($sqlCommand)->fetchAll();  
    $total_price=$array[0]['SUM'];
    $discount=0;
    switch ($bill['discount_type']) 
    {
        case 1:
            $tmp=$database->query("SELECT SUM(bill_detail.quantity) qty FROM bill_master INNER JOIN bill_detail ON bill_master.id = bill_detail.bill_id WHERE bill_master.id = $bill_id")->fetchAll();
            $qty=$tmp[0]['qty'];
            $discount=$bill['discount_custom']*$qty;
            break;
        case 2:
            $discount=$total_price*($bill['discount_custom']/100);
            break;

        default:
            $discount=0;
            break;
    }
    $x_start=170;
    $y_start=192.2;

    $pdf->SetXY($x_start,$y_start);
    $total_net=$total_price-$discount;
    $pdf->Cell(30,5,number_format($total_net, 2, '.', ','), $debug_frame, 0,'R');

    //if($bill['create_id']!=1)
    //{   
        $temp=$database->get('properties',['vat_rate']);
        $vat_rate=$temp['vat_rate'];
    //}
    $vat=$total_net*($vat_rate/100);
    $pdf->SetXY($x_start,$y_start+5);
    $pdf->Cell(30,5,number_format($vat, 2, '.', ','), $debug_frame, 0,'R');

    $pdf->SetXY($x_start,$y_start+10);
    $total=$total_net+$vat;
    $pdf->Cell(30,5,number_format($total, 2, '.', ','), $debug_frame, 0,'R');

    $pdf->SetXY(10,192.5);
    $pdf->SetFont('THSarabunNew','B',17);
    $pdf->Cell(124.5,15,iconv( 'UTF-8','cp874' , "(".convert(number_format($total, 2, '.', ',')).")" ), $debug_frame, 0,'C');
    
    if(($template=='3_tax_invoice_original.jpg')||($template=='4_tax_invoice_copy.jpg'))
    {
        $pdf->SetXY(30,208);
        $pdf->SetFont('THSarabunNew','B',10);
        $pdf->MultiCell(168,4,iconv( 'UTF-8','cp874' , $bill['notice'] ), 0, 'L');
    }
    
}
$pdf->Output('bill no.'.$bill['bill_no'].".pdf",'I');
?>

<?php

function convert($number){ 
$txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
$txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
$number = str_replace(",","",$number); 
$number = str_replace(" ","",$number); 
$number = str_replace("บาท","",$number); 
$number = explode(".",$number); 
if(sizeof($number)>2){ 
return 'ทศนิยมหลายตัวนะจ๊ะ'; 
exit; 
} 
$strlen = strlen($number[0]); 
$convert = ''; 
for($i=0;$i<$strlen;$i++){ 
	$n = substr($number[0], $i,1); 
	if($n!=0){ 
		if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
		elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
		elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
		else{ $convert .= $txtnum1[$n]; } 
		$convert .= $txtnum2[$strlen-$i-1]; 
	} 
} 

$convert .= 'บาท'; 
if($number[1]=='0' OR $number[1]=='00' OR 
$number[1]==''){ 
$convert .= 'ถ้วน'; 
}else{ 
$strlen = strlen($number[1]); 
for($i=0;$i<$strlen;$i++){ 
$n = substr($number[1], $i,1); 
	if($n!=0){ 
	if($i==($strlen-1) AND $n==1){$convert 
	.= 'เอ็ด';} 
	elseif($i==($strlen-2) AND 
	$n==2){$convert .= 'ยี่';} 
	elseif($i==($strlen-2) AND 
	$n==1){$convert .= '';} 
	else{ $convert .= $txtnum1[$n];} 
	$convert .= $txtnum2[$strlen-$i-1]; 
	} 
} 
$convert .= 'สตางค์'; 
} 
return $convert; 
} 

?>