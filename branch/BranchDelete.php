<?php
session_start();
$branch_id=$_GET['id'];
$customer=$_GET['customer'];

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
$database->update('customer_branch', ['active' => 0],['id'=> $branch_id]);
?>
<meta http-equiv="refresh" content="0; URL='MasterBranch.php?customer=<?php echo $customer; ?>'" />