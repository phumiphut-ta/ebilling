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
$bill_id=$_POST['bill_id'];
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
//echo "TYPE: ".$discount_type."<br>"; 
$database->update("bill_master", ['bill_no'=>$bill_no,'customer_id'=>$customer_id,'branch_id'=>$branch_id,'ref_no'=>$ref_no,'payment_term'=>$payment_term,'discount_type'=>$discount_type,'discount_custom'=>$discount_custom,'contact'=>$contact,'notice'=>$notice],['id'=>$bill_id,'deleted'=>0]);
$database->delete('bill_detail', ['bill_id'=>$bill_id]);
$productQty=count($product);
for($i=0;$i<$productQty;$i++)
{
    if($product[$i]!=0)
    {
        $database->insert('bill_detail', ['bill_id'=>$bill_id,'product_id'=>$product[$i],'quantity'=>$qty[$i]]);
    }
}
bill_recommit($database, $bill_id);
?>

<meta http-equiv="refresh" content="0; URL='MasterBill.php'" />
<?php
function bill_recommit($database,$bill_id)
{
    $sql1="DELETE FROM bill_price WHERE bill_id=$bill_id";
    $database->query($sql1)->fetchAll();
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