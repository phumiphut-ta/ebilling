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
                            <li class="breadcrumb-item active">รายงานสรุปยอดขายรายเดือน</li>
                          </ol>
                      </nav>
                  </h5>
              </div>      
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>รายงานสรุปยอดขายรายเดือน</h2>
                    <ul class="nav navbar-right panel_toolbox">
                     <button type="button" class="btn btn-danger btn-sm">ตั้งค่ารายงาน</button>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="table-responsive">
                          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive jambo_table nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="headings">
                                  <th class="column-title">ปี พ.ศ.</th>
                                  <th class="column-title">เดือน</th>
                                  <th class="column-title">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  $thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"); 
                                  $reports=$database->query("SELECT DISTINCT Month(billing_date) Month,Year(billing_date) Year FROM bill_master  ORDER BY id DESC")->fetchAll();
                                  for($i=0;$i<count($reports);$i++)
                                  {
                                      ?>
                                        <tr>
                                            <td><?php echo $reports[$i]['Year']+543; ?></td>
                                            <td><?php echo $thaimonth[($reports[$i]['Month']-1)]; ?></td>
                                            <td>
                                                <div class="btn-group  btn-group-xs">
                                                    <a href="SaleSummaryReport_action.php?year=<?php echo $reports[$i]['Year']; ?>&month=<?php echo $reports[$i]['Month']; ?>" target="report" class="btn btn-success btn-xs"><i class="fa fa-search"></i> ดูข้อมูล </a>
                                                </div>
                                            </td>
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
<script>
$('#datatable-responsive').dataTable( {
    "order": []
</script>