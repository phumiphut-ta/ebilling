<?php 
session_start();
require '../config/webconfig.php'; 
require('../config/dbconfig.php'); /* To Set Database paramenter */
require '../lib/Medoo.php';

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
$thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"); 

$year=$_GET['year'];
$month=$_GET['month'];
$properties=$database->get("properties", ['company_fullname','company_taxid','vat_rate']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>รายงานภาษีขาย </title>
        <!-- Bootstrap -->
<link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <style>
#table-title{
    border: 0px solid #000000;
}
.inform-blank{
    width: 5%;
}
.inform-front{
    width: 60%;
}
.inform-back{
    width: 35%
}
h4{
    font-size:medium;
}
.table-bordered {
  border-top: 0.5px solid #000000;
  border-left: 0px;
  border-right: 0px;
  border-bottom: 0px;
}
.table-bordered > thead > tr > th{
border: 0.5px solid #000000;
    font-size: small;
    text-align: center;
}
.table-bordered > tbody > tr > td{
    border: 0.5px solid #000000;
    font-size:smaller;
}

#tfoot-label{
   border: 0px solid #000000;
   text-align: right;
   font-size: small;
}
#tfoot-value{
   border: 0.5px solid #000000;
   border-bottom: 6px double black;
}
@media screen {
    #printSection {
        display: none;
    }
}
@media print {
    table {
        page-break-after: auto;
        page-break-inside: auto;
        width:100%;
        border-width: 1px;
        font-size:16px;
        font-family:Arial;
    }

     td{
        padding:2px 5px 2px 5px;
    }

}

    </style>
    <body>
        <div class="content container ">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 text-center"> 
                    <h1>รายงานภาษีขาย</h1>
                </div>
            </div>
            <table id='table-title' width='100%'>
                <tr>
                    <td class="inform-blank">&nbsp;</td>
                    <td class="inform-front"><h4>เดือน <?php echo $thaimonth[$month-1];?></h4></td>
                    <td class="inform-back"><h4>ปี พ.ศ. <?php echo $year+543;?></h4></td>
                </tr>
                <tr>
                    <td class="inform-blank">&nbsp;</td>
                    <td class="inform-front"><h4>ชื่อผู้ประกอบการ <?php echo $properties['company_fullname'];?></h4></td>
                    <td class="inform-back"><h4>เลขประจำตัวผู้เสียภาษีอากร <?php echo $properties['company_taxid'];?></h4></td>
                </tr>
                <tr>
                    <td class="inform-blank">&nbsp;</td>
                    <td class="inform-front"><h4>ชื่อสถานประกอบการ <?php echo $properties['company_fullname'];?></h4></td>
                    <td class="inform-back"><h4>สำนักงานใหญ่</h4></td>
                </tr>
            </table>
        </div>
            <div class="container">
                <table class="table table-bordered">
                    <thead>
                        <tr class="headings">
                            <th class="column-title" colspan="2" class="text-center">ใบกำกับภาษี</th>
                            <th class="column-title" rowspan="2">ชื่อผู้ซื้อสินค้า/ผู้รับบริการ</th>
                            <th class="column-title" rowspan="2">เลขประจำตัวผู้เสียภาษีอากร<br>ของผู้ซื้อสินค้า/ผู้รับบริการ</th>
                            <th class="column-title" colspan="2">สถานประกอบการ</th>
                            <th class="column-title" rowspan="2">มูลค่าสินค้าหรือบริการ</th>
                            <th class="column-title" rowspan="2">จำนวนภาษีมูลค่าเพิ่ม</th>
                        </tr>
                        <tr>
                            <th class="column-title">วัน/เดือน/ปี</th>
                            <th class="column-title">เลขที่</th>
                            <th class="column-title">สำนักงานใหญ่</th>
                            <th class="column-title">สาขาที่</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query="SELECT 
                            bm.id, bm.bill_no,
                            DATE_FORMAT(DATE_ADD(bm.billing_date, INTERVAL 543 YEAR),'%d/%m/%Y') AS billing_date ,
                            cd.customer_fullname,cd.customer_taxid,deleted
                            FROM
                            bill_master bm
                            INNER JOIN customer_detail cd ON bm.customer_id = cd.id 
                            WHERE
                            Year(bm.billing_date)= $year AND
                            Month(bm.billing_date)= $month ORDER BY bm.id";
                        $bills=$database->query($query)->fetchAll();
                        for($i=0;$i<count($bills);$i++)
                        {
                            if($bills[$i]['deleted']==0){
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $bills[$i]['billing_date'];?></td>
                                <td class="text-center"><?php echo $bills[$i]['bill_no'];?></td>
                                <td class="text-left"><?php echo $bills[$i]['customer_fullname'];?></td>
                                <td class="text-center"><?php echo $bills[$i]['customer_taxid'];?></td>
                                <td class="text-center">สนญ.</td>
                                <td class="text-center">-</td>
                                <td class="text-right"><?php $subtotal=getSubtotal($database,$bills[$i]['id']); echo number_format($subtotal, 2, '.', ','); ?></td>
                                <td class="text-right"><?php $vat=getVat($subtotal,$properties['vat_rate']); echo number_format($vat, 2, '.', ','); ?></td>
                            </tr>
                            <?php
                            }
                            else{
                                ?>
                            <tr>
                                <td class="text-center"></td>
                                <td class="text-center"><?php echo $bills[$i]['bill_no'];?></td>
                                <td class="text-left">ยกเลิก</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-right">-</td>
                                <td class="text-right">-</td>
                            </tr> 
                                    
                                    <?php
                            }
                        }
                        ?>
                        <tr>
                            <td id='tfoot-label' colspan="6">รวมเงิน</td>
                            <td id='tfoot-value' class="text-right"><?php $SumOfSubtotal=getSumOfSubtotal($database,$year,$month); echo number_format($SumOfSubtotal, 2, '.', ','); ?></td>
                            <td id='tfoot-value' class="text-right"><?php $SumOfVat=getSumOfVat($database,$year,$month,$properties['vat_rate']); echo number_format($SumOfVat, 2, '.', ','); ?></td>
                        </tr>
                    </tbody>
                    
                </table>
            </div>
        

    </body>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</html>
<?php
function getSubtotal($database,$bill_id)
{
    $tmp=$database->query("SELECT Sum(bd.quantity*bp.price) SUM FROM bill_detail bd
    INNER JOIN bill_master bm ON bd.bill_id = bm.id
    INNER JOIN bill_price bp ON bd.product_id = bp.product_id AND bd.bill_id = bp.bill_id
    WHERE bm.id=$bill_id")->fetchAll();
    $total_not_discount=$tmp[0]['SUM'];
    
    $bill=$database->get('bill_master',['discount_type','discount_custom'],['id'=>$bill_id,'deleted'=>0]);
    $discount=0;
    switch ($bill['discount_type']) 
    {
        case 1:
            $tmp=$database->query("SELECT SUM(bill_detail.quantity) qty FROM bill_master INNER JOIN bill_detail ON bill_master.id = bill_detail.bill_id WHERE bill_master.id = $bill_id")->fetchAll();
            $qty=$tmp[0]['qty'];
            $discount=$bill['discount_custom']*$qty;
            break;
        case 2:
            $discount=$total_not_discount*($bill['discount_custom']/100);
            break;

        default:
            $discount=0;
            break;
    }
    $subtotal=$total_not_discount-$discount;
    return $subtotal;
}
function getVat($subtotal,$vat_rate)
{
    return $subtotal*($vat_rate/100);
}
function getSumOfSubtotal($database,$year,$month)
{
    $query="SELECT 
        bm.id
        FROM
        bill_master bm
        INNER JOIN customer_detail cd ON bm.customer_id = cd.id 
        WHERE
        Year(bm.billing_date)= $year AND
        Month(bm.billing_date)= $month ORDER BY bm.id";
    $bills=$database->query($query)->fetchAll();
    $sum=0;
    foreach ($bills as $bill)
    {
        $sum+=getSubtotal($database,$bill['id']);
    }
    return $sum;
}
function getSumOfVat($database,$year,$month,$vat_rate)
{
    $query="SELECT 
        bm.id
        FROM
        bill_master bm
        INNER JOIN customer_detail cd ON bm.customer_id = cd.id 
        WHERE
        Year(bm.billing_date)= $year AND
        Month(bm.billing_date)= $month ORDER BY bm.id";
    $bills=$database->query($query)->fetchAll();
    $sum=0;
    foreach ($bills as $bill)
    {
        $sum+= getVat(getSubtotal($database,$bill['id']),$vat_rate);
    }
    return $sum;
}
?>