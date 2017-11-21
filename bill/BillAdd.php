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

  <body class="nav-md  menu_fixed">
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
                            <li class="breadcrumb-item"><a href="../bill/MasterBill.php">บิล</a></li>
                            <li class="breadcrumb-item active">สร้างบิลใหม่</li>
                          </ol>
                      </nav>
                  </h5>
              </div>             
            </div>
            <div class="clearfix"></div>
            
            <form id="form-bill" data-parsley-validate class="form-horizontal form-label-left" action="BillAdd_action.php" method="POST">
                                <!-- Smart Wizard -->
                    
                    <div id="wizard" class="form_wizard wizard_horizontal">
                      <ul class="wizard_steps">
                        <li>
                          <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr">
                                Step 1<br />
                                <small>หัวกระดาษ</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr">
                                Step 2<br />
                                <small>ร้านค้า/สถานที่จัดส่ง</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr">
                                Step 3<br />
                            <small>รายการสินค้า</small>
                            </span>
                          </a>
                        </li>
                        <li>
                          <a href="#step-4">
                            <span class="step_no">4</span>
                            <span class="step_descr">
                                Step 4<br />
                                <small>ส่วนลด</small>
                            </span>
                          </a>
                        </li>
                      </ul>
                      <div id="step-1">
                          <h2 class="StepTitle">Step 1 หัวกระดาษ</h2>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bill_no">เลขที่เอกสาร <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="bill_no" name="bill_no" class="form-control col-md-7 col-xs-12" value="<?php 
                                $properties=$database->get('properties', ['billno']);    
                                echo $properties['billno']; ?>" required readonly>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="billing_date">วันที่ออกบิล <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="billing_date" name="billing_date" class="form-control col-md-7 col-xs-12" value="<?php echo date("Y-m-d");?>" required readonly>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="ref_no">เลขที่ใบสั่งสินค้า 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="ref_no" name="ref_no" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payment_term">เงื่อนไขในการชำระเงิน
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="payment_term" name="payment_term" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                          </div>
                      </div>
                      <div id="step-2">
                        <h2 class="StepTitle">Step 2 ร้านค้า/สถานที่จัดส่ง</h2>
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_id">ชื่อลูกค้า/ผู้ซื้อ <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php 
                            $customer=$database->select('customer_detail', ['id','customer_fullname'],['active'=>1,"ORDER"=>["customer_fullname"=> "ASC"]]);
                            ?>
                            <select name="customer_id" id="customer_id" required="required" class="form-control col-md-7 col-xs-12" onChange="getBranch(this.value);">
                                <option value="">โปรดระบุลูกค้า</option>
                                <?php 
                                for($i=0;$i<count($customer);$i++)
                                {
                                ?>
                                <option value="<?php echo $customer[$i]['id']; ?>" ><?php echo $customer[$i]['customer_fullname']; ?></option>
                                <?php
                                }
                                ?>
                                
                            </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_id">สถานที่ส่งสินค้า <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="branch_id" id="branch_id" required="required" class="form-control col-md-7 col-xs-12">
                                <option value="">โปรดระบุสาขา</option>
                               
                            </select>
                        </div>
                      </div>
                      </div>
                      <div id="step-3">
                        <h2 class="StepTitle">Step 3 รายการสินค้า</h2>
                         <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <td>#</td>
                                <th>รายการสินค้า</th>
                                <th>จำนวน (ชุด)</th>
                              </tr>
                            </thead>
                            <?php 
                            $products=$database->select('product_detail',['[><]product_price'=>['id'=>'product_id']],['product_detail.id','product_detail.product_no','product_detail.product_description','product_price.price'],['product_price.customer_id'=>1,'product_detail.active'=>1,'ORDER'=>['product_detail.product_no' => "ASC"]]);
                          
                            
                            ?>
                            <tbody>
                                <?php
                                for($j=0;$j<14;$j++)
                                {
                                ?>
                              <tr>
                                <td><?php echo $j+1;?></td>
                                <td>
                                    <select name="product[]" id="product<?php echo $j;?>" class="form-control">
                                        <option value="">โปรดระบุ</option>
                                      <?php
                                      for($i=0;$i<count($products);$i++)
                                      {
                                          ?>
                                        <option value="<?php echo $products[$i]['id'];?>"  ><?php echo $products[$i]['product_no'].' '.$products[$i]['product_description'];?></option>
                                        <?php
                                      }
                                      ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="qty[]" class="myspinner" value="0" style="width: 50px; height: 25px; padding: 0px" />
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
                      <div id="step-4">
                        <h2 class="StepTitle">Step 4 ส่วนลด</h2>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">ประเภทส่วนลด</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div id="discount_type" class="btn-group" >
                               
                                  <input type="radio" name="discount_type"  value="1" checked> &nbsp; จำนวนเงิน (บาท) &nbsp; 
                                  <input type="radio" name="discount_type"  value="2" > &nbsp; เปอเซ็นต์ (%) &nbsp;
                           
                              </div>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="discount_custom">ส่วนลด <span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="discount_custom" name="discount_custom" required="required" class="form-control col-md-7 col-xs-12" value="0">
                            </div>
                          </div>
                         <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contact">ผู้ติดต่อ 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="contact" name="contact" class="form-control col-md-7 col-xs-12" value="">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notice">หมายเหตุ 
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="notice" class="form-control col-md-7 col-xs-12" rows="4" cols="4"></textarea>
                            </div>
                          </div>
                      </div>
                      </div>
                    </div>
                    <!-- End SmartWizard Content -->
            </form>
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
function getBranch(val) {
	$.ajax({
	type: "POST",
	url: "getBranch.php",
	data:'customer_id='+val,
	success: function(data){
		$("#branch_id").html(data);
	}
	});
}

</script>
<script>
   $(function(){ 
    $(".myspinner").spinner(); 
});
</script>
