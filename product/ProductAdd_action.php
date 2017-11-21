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
$product_no=$_POST['product_no'];
$product_description=$_POST['product_description'];

$database->insert("product_detail", ['product_no'=>$product_no ,'product_description'=>$product_description,'active'=>1]);
$product_id = $database->id(); //หา id ของ row ที่ insert เข้าไป 
$customer=$database->select("customer_detail", ["id"], ["active"=>1]); //จัดทำ list ของสินค้า
for($i=0;$i<count($customer);$i++)
{
    $database->insert("product_price", ["product_id"=>$product_id,"customer_id"=>$customer[$i]['id']]);
}
?>
<meta http-equiv="refresh" content="0; URL='ProductPrice.php?id=<?php echo $product_id; ?>'" />