<?php 
session_start();
require '../config/webconfig.php';
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

$user_id=$_POST['user_id'];
$username=$_POST['username'];
$password=$_POST['password'];
$fname=$_POST['fname'];
$lname=$_POST['lname'];

$md5_password= md5(trim($password));

$database->update("user_detail", ['username'=>$username,'password'=>$md5_password,'fname'=>$fname,'lname'=>$lname,'update_id'=>$_SESSION['user_id'],'#update_datetime'=>'NOW()'],['active'=>1,'id'=>$user_id]);
?>
<meta http-equiv="refresh" content="0; URL='../auth/logout.php'" />