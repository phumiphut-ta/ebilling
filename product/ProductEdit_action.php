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
$product_id=$_POST['product_id'];
$product_no=$_POST['product_no'];
$product_description=$_POST['product_description'];

$database->update("product_detail", ['product_no'=>$product_no ,'product_description'=>$product_description],['active'=>1,'id'=>$product_id]);

?>
<meta http-equiv="refresh" content="0; URL='MasterProduct.php'" />