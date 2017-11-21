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

$customer=$_POST['customer'];
$branch_number=$_POST['branch_number'];
$branch_fullname=$_POST['branch_fullname'];
$branch_shortname=$_POST['branch_shortname'];
$branch_address_row1=$_POST['branch_address_row1'];
$branch_address_row2=$_POST['branch_address_row2'];
$branch_address_row3=$_POST['branch_address_row3'];
$branch_tel=$_POST['branch_tel'];

$database->insert("customer_branch", ['customer_id'=>$customer,'branch_number'=>$branch_number ,'branch_fullname'=>$branch_fullname,'branch_shortname'=>$branch_shortname ,'branch_address_row1'=>$branch_address_row1,'branch_address_row2'=>$branch_address_row2,'branch_address_row3'=>$branch_address_row3,'branch_tel'=>$branch_tel,'active'=>1]);

?>
<meta http-equiv="refresh" content="0; URL='MasterBranch.php?customer=<?php echo $customer; ?>'" />