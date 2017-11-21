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
$product_id=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require '../include_page/header_page.php'; ?>
  </head>

  <body class="nav-md menu_fixed footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"><i class="fa fa-money"></i> <span><?php echo PROGRAM_NAME; ?></span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="../images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $_SESSION["fname"].' '.$_SESSION["lname"]; ?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <?php require '../include_page/side_menu.php'; ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <?php require '../include_page/footer_menu.php'; ?>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php require '../include_page/top_navigation.php'; ?>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h5>
                      <nav aria-label="breadcrumb" role="navigation">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../dashboard/index.php">หน้าหลัก</a></li>
                            <li class="breadcrumb-item"><a href="../product/MasterProduct.php">สินค้า</a></li>
                            <li class="breadcrumb-item active">ราคา</li>
                          </ol>
                      </nav>
                  </h5>
              </div>

              <div class="title_right">
                
              </div>
            </div>
            <div class="clearfix"></div>
            
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                      <?php
                      $product_detail=$database->get("product_detail",["product_no","product_description"],["id"=>$product_id]);
                      ?>
                      <h2><?php echo $product_detail['product_no']; ?> <small><?php echo $product_detail['product_description'];?></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                       <div class="table-responsive">
                           <?php
                           $product=$database->select("customer_detail",["[><]product_price"=>["id"=>"customer_id"]],["product_price.id","customer_detail.customer_fullname","product_price.barcode","product_price.price"],["product_price.product_id"=>$product_id,"ORDER" => ["customer_detail.customer_fullname" => "ASC"]]);
                           
                           ?>
                          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive jambo_table nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="headings">
                                  <th class="column-title">#</th>
                                  <th class="column-title">ชื่อร้านค้า</th>
                                  <th class="column-title">รหัสสินค้า</th>
                                  <th class="column-title">ราคา</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  for($i=0;$i<count($product);$i++)
                                  {
                                      ?>
                                        <tr>
                                          <td><?php echo $i+1; ?></td>
                                          <td><?php echo $product[$i]['customer_fullname']; ?></td>
                                          <td><?php echo $product[$i]['barcode']; ?></td>
                                          <td><a href="ProductPriceEdit.php?id=<?php echo $product[$i]["id"]; ?>"><u><?php echo number_format($product[$i]['price'],2)." บาท"; ?></u></a></td>
                                         
                                        </tr>
                                      <?php
                                  }
                                  ?>
                                  
                              </tbody>
                          </table>
                       </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <?php require '../include_page/footer_page.php'; ?>
        </footer>
        <!-- /footer content -->
      </div>
    </div>
        <?php require '../include_page/footer_include.php'; ?>
  </body>
</html>
