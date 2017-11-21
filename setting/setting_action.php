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
$type_submit=$_POST['type_submit'];

if($type_submit==="company")
{
    $company_fullname=$_POST['company_fullname'];
    $company_shortname=$_POST['company_shortname'];
    $company_address_row1=$_POST['company_address_row1'];
    $company_address_row2=$_POST['company_address_row2'];
    $company_tel=$_POST['company_tel'];
    $company_fax=$_POST['company_fax'];
    $ccompany_email=$_POST['company_email'];
    $company_website=$_POST['company_website'];
    $company_taxid=$_POST['company_taxid'];
    $database->update('properties', 
        [
            'company_fullname' => $company_fullname,
            'company_shortname' => $company_shortname,
            'company_address_row1' => $company_address_row1,
            'company_address_row2' => $company_address_row2,
            'company_tel' => $company_tel,
            'company_fax' => $company_fax,
            'company_email' => $ccompany_email,
            'company_website' => $company_website,
            'company_taxid' => $company_taxid
            ]);
}
if($type_submit==="bill")
{
    $billno=$_POST['billno'];
    $vat_rate=$_POST['vat_rate'];        
    $database->update('properties', 
        [
            'billno' => $billno,
            'vat_rate' => $vat_rate
            ]);
}

?>
<meta http-equiv="refresh" content="0; URL='MasterSetting.php'" />