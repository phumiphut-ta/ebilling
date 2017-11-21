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
$price_id=$_POST['price_id'];
$barcode=$_POST['barcode'];
$price=$_POST['price'];
$product_id=$_POST['product_id'];

$database->update("product_price", ['barcode'=>$barcode,'price'=>$price],['id'=>$price_id]);

?>
<meta http-equiv="refresh" content="0; URL='ProductPrice.php?id=<?php echo $product_id; ?>'" />