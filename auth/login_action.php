<?php
session_start();
require '../lib/Medoo.php';
require('../config/dbconfig.php'); /* To Set Database paramenter */

$username=$_POST['username'];
$password=$_POST['password'];
$md5_password=md5(trim($password));

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
$user=array();
$count=$database->count("user_detail",'*', ["AND" =>['username' => $username,'password' => $md5_password,'active' => 1]]);
if($count==1)
{
    $user=$database->get("user_detail", ['id','username','fname','lname','user_group'], ["AND" =>['username' => $username,'password' => $md5_password,'active' => 1]]);
    $_SESSION["user_id"]=$user["id"];
    $_SESSION["fname"]=$user["fname"];
    $_SESSION["lname"]=$user["lname"];
    $_SESSION["user_group"]=$user["user_group"];
    ?><meta http-equiv="refresh" content="0; url=../bill/MasterBill.php" /><?php
}
 else {
     ?><meta http-equiv="refresh" content="0; url=../login.html" /><?php
}