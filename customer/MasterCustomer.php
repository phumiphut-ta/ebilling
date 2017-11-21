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
                            <li class="breadcrumb-item active">คู่ค้า</li>
                          </ol>
                      </nav>
                  </h5>
              </div>

              <div class="title_right">
                
              </div>
            </div>
            <div class="clearfix"></div>
            <!-- Confirm Box for Delete Content -->
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                            </div>

                            <div class="modal-body">
                                <p>คุณกำลังดำเนินการลบเนื้อหานี้, ขั้นตอนนี้ไม่สามารถย้อนกลับได้</p>
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
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                      <h2>Customer <small>ค้นหาคู่ค้า</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                       <div class="table-responsive">
                           <?php
                           $customer=$database->select("customer_detail", ['id','customer_shortname','customer_fullname','customer_address_row1','customer_address_row2','customer_tel','customer_fax',	'customer_taxid'],["active" => 1,"ORDER" => ["customer_shortname" => "ASC"]]);
                           
                           ?>
                          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive jambo_table nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr class="headings">
                                  <th class="column-title">#</th>
                                  <th class="column-title">ชื่อย่อ</th>
                                  <th class="column-title">ชื่อบริษัท</th>
                                  <th class="column-title">ที่อยู่</th>
                                  <th class="column-title">เลขประจำตัวผู้เสียภาษี</th>
                                  <th class="column-title">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  <?php
                                  for($i=0;$i<count($customer);$i++)
                                  {
                                      ?>
                                        <tr>
                                          <td><?php echo $i+1; ?></td>
                                          <td><?php echo $customer[$i]['customer_shortname']; ?></td>
                                          <td><?php echo $customer[$i]['customer_fullname']; ?></td>
                                          <td><?php echo $customer[$i]['customer_address_row1'].' '.$customer[$i]['customer_address_row2']; ?></td>
                                          <td><?php echo $customer[$i]['customer_taxid']; ?></td>
                                          <td>
                                            <a href="../branch/MasterBranch.php?customer=<?php echo $customer[$i]['id'];?>" class="btn btn-success btn-xs"><i class="fa fa-list"></i> สาขา </a>
                                            <a href="CustomerEdit.php?id=<?php echo $customer[$i]['id']; ?>" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> แก้ไข </a>
                                            <a data-href="CustomerDelete.php?id=<?php echo $customer[$i]['id']; ?>" data-toggle="modal" data-target="#confirm-delete" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> ลบ </a>
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
</script>