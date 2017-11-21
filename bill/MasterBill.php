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

  <body class="nav-md menu_fixed">
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
                            <li class="breadcrumb-item active">บิล</li>
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
                      <h2>Bill list <small>ค้นหาชุดบิล</small></h2>
                    <div class="clearfix"></div>
                    <!-- Confirm Box for Delete Content -->
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">ยืนยันการยกเลิกชุดบิล</h4>
                            </div>

                            <div class="modal-body">
                                <p>คุณกำลังดำเนินการยกเลิกชุดบิลนี้, ขั้นตอนนี้ไม่สามารถย้อนกลับได้</p>
                                <p>ต้องการดำเนินการต่อหรือไม่?</p>
                                <p class="debug-url"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-danger btn-ok">Delete</a>
                            </div>
                        </div>
                    </div> 
                </div>
            <!-- Confirm Box for Delete Content -->
                  </div>
                  <div class="x_content">
                       <div class="table-responsive">
                          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive jambo_table nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="headings">
                                  <th class="column-title">เลขที่ชุดบิล</th>
                                  <th class="column-title">ชื่อคู่ค้า</th>
                                  <th class="column-title">เลขที่ใบสั่งซื้อ</th>
                                  <th class="column-title">วันที่สั่งสินค้า</th>
                                  <th class="column-title">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  if($_SESSION["user_id"]==1)
                                  {
                                    $bill=$database->select("bill_master", ["[><]customer_detail"=>["customer_id"=>"id"]], ["bill_master.id","bill_master.bill_no","customer_detail.customer_fullname","bill_master.ref_no","bill_master.billing_date"], ["deleted"=>0,"ORDER"=>['bill_master.id'=>'DESC']]);
                                  }
                                  if($_SESSION["user_id"]==2)
                                  {
                                      $bill=$database->select("bill_master", ["[><]customer_detail"=>["customer_id"=>"id"]], ["bill_master.id","bill_master.bill_no","customer_detail.customer_fullname","bill_master.ref_no","bill_master.billing_date"], ["deleted"=>0,"ORDER"=>['bill_master.id'=>'DESC']]);
                                  }
                                  for($i=0;$i<count($bill);$i++)
                                  {
                                      ?>
                                  <tr>
                                      <td><?php echo $bill[$i]['bill_no']; ?></td>
                                      <td><?php echo $bill[$i]['customer_fullname']; ?></td>
                                      <td><?php echo $bill[$i]['ref_no']; ?></td>
                                      <td><?php echo $bill[$i]['billing_date']; ?></td>
                                      <td>
                                          <div class="btn-group  btn-group-sm">
                                              <a target="billpage" href="../pdf/generateBill.php?id=<?php echo $bill[$i]['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-print"></i> พิมพ์ </a>
                                            <a href="BillEdit.php?id=<?php echo $bill[$i]['id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> แก้ไข </a>
                                            <a data-href="BillDelete.php?id=<?php echo $bill[$i]['id']; ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ยกเลิก </a>
                                          </div>
                                      </td>
                                  </tr>
                                  <?php } ?>
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
<script>
    $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
        
        
    $('#datatable-responsive').dataTable( {
    "order": []
} );
</script>