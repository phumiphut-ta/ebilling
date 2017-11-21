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
    'charset' => CHARSET
]);
$user=array();
$count=$database->count("user_detail",'*', ["AND" =>['username' => $username,'password' => $md5_password,'active' => 1]]);
if($count==1)
{
    $user=$database->select("user_detail", ['id','username','fname','lname','user_group'], ["AND" =>['username' => $username,'password' => $md5_password,'active' => 1]]);
    $_SESSION["user_id"]=$user[0]["id"];
    $_SESSION["fname"]=$user[0]["fname"];
    $_SESSION["lname"]=$user[0]["lname"];
    $_SESSION["user_group"]=$user[0]["user_group"];
    ?><meta http-equiv="refresh" content="0; url=../dashboard/index.php" /><?php
}
 else {
     ?><meta http-equiv="refresh" content="0; url=../login.php?error=1" /><?php
}