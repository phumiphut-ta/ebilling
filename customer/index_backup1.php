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
    'charset' => CHARSET
]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php require '../include_page/header_page.php'; ?>
  </head>

  <body class="nav-md footer_fixed">
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
                <h3>ร้านค้า</h3>
              </div>

              <div class="title_right">
                
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                      <h2>Customer <small>รายการร้านค้า</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                       <div class="table-responsive">
                           <?php
                           $customer=$database->select("customer_detail", ['id','customer_shortname','customer_fullname','logo','customer_address_row1','customer_address_row2','customer_tel','customer_fax',	'customer_taxid'],["ORDER" => ["customer_shortname" => "ASC"]]);
                           for($i=0;$i<count($customer);$i++)
                           {
                               ?>
                                <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
                                    <div class="well profile_view">
                                        <div class="col-sm-12">
                                            <h4 class="brief"><i><?php echo $customer[$i]['customer_shortname'];?></i></h4>
                                            <div class="left col-xs-7">
                                                <h2><?php echo $customer[$i]['customer_fullname'];?></h2>
                                                    <p><strong>Tax Id: </strong> <?php echo $customer[$i]['customer_taxid'];?></p>
                                                    <ul class="list-unstyled">
                                                        <li><i class="fa fa-building"></i> Address: </li>
                                                        <li>
                                                            <?php echo $customer[$i]['customer_address_row1'];?>
                                                            <?php echo $customer[$i]['customer_address_row2'];?>
                                                        <li>
                                                        <li><i class="fa fa-phone"></i> Phone #: <?php echo $customer[$i]['customer_tel'];?></li>
                                                        <li><i class="fa fa-fax"></i> Fax #: <?php echo $customer[$i]['customer_fax'];?></li>
                                                    </ul>
                                            </div>
                                            <div class="right col-xs-5 text-center">
                                                <img src="logo/<?php echo $customer[$i]['logo']; ?>" alt="" class="img-circle img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 bottom text-center">
                                            
                                            <div class="col-xs-12 col-sm-12 emphasis">
                                              <button type="button" class="btn btn-success btn-xs" onclick="window.location.href='../branch/MasterBranch.php?customer=<?php echo $customer[$i]['id'];?>'">  
                                                  <i class="fa fa-list"> สาขา</i> 
                                              </button>
                                              <button type="button" class="btn btn-warning btn-xs">
                                                <i class="fa fa-edit"> แก้ไข</i> 
                                              </button>
                                              <button type="button" class="btn btn-danger btn-xs">
                                                <i class="fa fa-trash"> ลบ</i> 
                                              </button>
                                            </div>
                                          </div>
                                    </div>
                                </div>
                                <?php
                           }
                           ?>
                          
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