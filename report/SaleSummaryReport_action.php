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
$year=$_GET['year'];
$month=$_GET['month'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>รายงานสรุปยอดขายรายเดือน </title>
        <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <table class="table table-bordered">
                <thead>
                    <?php 
                    $customers=$database->select("customer_detail", ["id","customer_fullname"],['active'=>1]);
                    ?>
                    <tr>
                        <th rowspan="1"></th>
                        <th class="text-center" colspan="<?php echo (count($customers));?>">จำนวน (ตัว)</th>
                    </tr>
                    <tr>
                        <th>รหัสสินค้า</th>
                        <?php
                        
                        foreach ($customers as $customer) 
                        {
                            ?>
                            <th><?php echo $customer['customer_fullname']; ?></th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <?php 
                $products=$database->select("product_detail", ["id","product_no"],["active"=>1]);
                ?>
                <tbody>
                    <?php
                    foreach ($products as $product) 
                    {
                        ?>
                        <tr>
                            <th><?php echo $product['product_no'];?></th>
                            <?php
                            $customers=$database->select("customer_detail", ["id","customer_fullname"],['active'=>1]);         
                                for ($i=0;$i<count($customers);$i++)
                                {
                                    $query="SELECT 
                                    if(Sum(bd.quantity)<>0,Sum(bd.quantity),0) sum_qty
                                    FROM bill_price bp
                                    INNER JOIN bill_master bm ON bp.bill_id = bm.id
                                    INNER JOIN bill_detail bd ON bm.id = bd.bill_id AND bd.product_id = bp.product_id
                                    WHERE 
                                    bm.customer_id = ".$customers[$i]['id']." AND
                                    bm.deleted = 0 AND
                                    Year(bm.billing_date) = $year AND
                                    Month(bm.billing_date) = $month AND
                                    bd.product_id = ".$product['id'];
                                   
                                    $x=$database->query($query)->fetchAll(); 
                                    ?>
                            <td><?php echo $x[0]['sum_qty']; ?></td>
                                    <?php
                                }
                            ?>
                        </tr>
                    <?php
                    }
                    ?>
                   
                </tbody>
            </table>
        </div>
    </body>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</html>