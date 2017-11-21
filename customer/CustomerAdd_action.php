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
$customer_fullname=$_POST['customer_fullname'];
$customer_shortname=$_POST['customer_shortname'];
$customer_taxid=$_POST['customer_taxid'];
$customer_address_row1=$_POST['customer_address_row1'];
$customer_address_row2=$_POST['customer_address_row2'];
$customer_tel=$_POST['customer_tel'];
$customer_fax=$_POST['customer_fax'];
$customer_email=$_POST['customer_email'];

$database->insert("customer_detail", ['customer_taxid'=>$customer_taxid ,'customer_fullname'=>$customer_fullname,'customer_shortname'=>$customer_shortname ,'customer_address_row1'=>$customer_address_row1,'customer_address_row2'=>$customer_address_row2,'customer_tel'=>$customer_tel,'customer_fax'=>$customer_fax,'customer_email'=>$customer_email,'active'=>1]);
$customer_id = $database->id(); //หา id ของ row ที่ insert เข้าไป 
$product=$database->select("product_detail", ["id"], ["active"=>1]); //จัดทำ list ของสินค้า
for($i=0;$i<count($product);$i++)
{
    $database->insert("product_price", ["product_id"=>$product[$i]['id'],"customer_id"=>$customer_id]);
}
?>
<meta http-equiv="refresh" content="0; URL='MasterCustomer.php'" />