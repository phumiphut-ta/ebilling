<?php
session_start();
$customer_id=$_GET['id'];

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
$database->update('customer_detail', ['active' => 0],['id'=> $customer_id]);
?>
<meta http-equiv="refresh" content="0; URL='MasterCustomer.php'" />