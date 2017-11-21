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
$price_id=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require '../include_page/header_page.php'; ?>
  </head>

  <body class="nav-md  menu_fixed footer_fixed">
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
                            <li class="breadcrumb-item active" aria-current="page"><a href="../product/MasterProduct.php">สินค้า</a></li>
                           
                          </ol>
                      </nav>
                  </h5>
              </div>             
            </div>
            <div class="clearfix"></div>
            
           
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: auto;">
                  <div class="x_title">
                    <h2>Edit Price <small>แก้ไขรายละเอียดผลิตภัณฑ์</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content" >
                     <form id="form-company" data-parsley-validate class="form-horizontal form-label-left" action="ProductPriceEdit_action.php" method="POST">
                         <input type="hidden" name="price_id" value="<?php echo $price_id; ?>">
                         <div class="form-group">
                             <?php
                             $product_detail=$database->get("product_price",["[><]product_detail"=>["product_id"=>"id"]],["product_detail.product_no","product_detail.product_description"],["product_price.id"=>$price_id]);
                            ?>
                             <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">ชื่อสินค้า 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="customer_name" type="text" id="customer_name" disabled="disabled" class="form-control col-md-7 col-xs-12" value="<?php echo "(".$product_detail['product_no'].") ".$product_detail['product_description']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                          <?php
                            $customer=$database->get("product_price",["[><]customer_detail"=>["customer_id"=>"id"]],["customer_detail.customer_fullname"],["product_price.id"=>$price_id]);           
                            ?>
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">ชื่อร้านค้า 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="customer_name" type="text" id="customer_name" disabled="disabled" class="form-control col-md-7 col-xs-12" value="<?php echo $customer['customer_fullname']; ?>">
                        </div>
                      </div>
                         <?php
                         $product=$database->get("product_price",["product_id","barcode","price"],["id"=>$price_id]);
                         ?>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="barcode">รหัสสินค้า <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="barcode" type="text" id="barcode" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product['barcode']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="price">ราคาสินค้า <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="price" type="text" id="price" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $product['price']; ?>">
                        </div>
                      </div>
                      <input type="hidden" name="product_id" value="<?php echo $product["product_id"]; ?>">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="button" onclick="location.href = 'ProductPrice.php?id=<?php echo $product["product_id"]; ?>'" class="btn btn-primary">Cancel</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
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