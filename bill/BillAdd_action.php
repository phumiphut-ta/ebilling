<?php
session_start();
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

$bill_no=$_POST['bill_no'];
$ref_no=$_POST['ref_no'];
$payment_term=$_POST['payment_term'];
$customer_id=$_POST['customer_id'];
$branch_id=$_POST['branch_id'];
$product=$_POST['product'];
$qty=$_POST['qty'];
$discount_type=$_POST['discount_type'];
$discount_custom=$_POST['discount_custom'];
$contact=$_POST['contact'];
$notice=$_POST['notice'];
$database->insert('bill_master', ['bill_no'=>$bill_no,'customer_id'=>$customer_id,'branch_id'=>$branch_id,'ref_no'=>$ref_no,'payment_term'=>$payment_term,'#billing_date'=>'NOW()','discount_type'=>$discount_type,'discount_custom'=>$discount_custom,'contact'=>$contact,'notice'=>$notice,'create_id'=>$_SESSION["user_id"]]);
$bill_id=$database->id();
$database->delete('bill_detail', ['bill_id'=>$bill_id]);
$productQty=count($product);
for($i=0;$i<$productQty;$i++)
{
    if($product[$i]!=0)
    {
        $database->insert('bill_detail', ['bill_id'=>$bill_id,'product_id'=>$product[$i],'quantity'=>$qty[$i]]);
    }
}
bill_commit($database,$bill_id);
$database->update('properties', ['billno'=>$bill_no+1]);
?>

<meta http-equiv="refresh" content="0; URL='MasterBill.php'" />

<?php
function bill_commit($database,$bill_id)
{
    $sqlCommand="INSERT INTO bill_price(bill_id,product_id, barcode, product_no, product_description, price)
SELECT  m.id bill_id,pp.product_id, pp.barcode, pd.product_no, pd.product_description, pp.price
FROM bill_master m
INNER JOIN bill_detail bd ON m.id = bd.bill_id
INNER JOIN product_price pp ON bd.product_id = pp.product_id
INNER JOIN product_detail pd ON pp.product_id = pd.id AND m.customer_id = pp.customer_id
WHERE m.id=$bill_id";
    $database->query($sqlCommand)->fetchAll();
}
?>