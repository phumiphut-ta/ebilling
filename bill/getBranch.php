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
if(!empty($_POST["customer_id"])) 
{
    $customer_id=$_POST["customer_id"];
    $branchs=$database->select("customer_branch", ['id','branch_shortname','branch_number'], ['customer_id'=>$customer_id,'active'=>1,"ORDER" => ["branch_number" => "ASC"]]);
    ?>
    <option value="">โปรดระบุสาขา</option>
    <?php
    foreach ($branchs as $branch) 
    {
        ?>
        <option value="<?php echo $branch['id']; ?>"><?php echo $branch['branch_number'].' '.$branch['branch_shortname']; ?></option>
        <?php
    }
}
?>