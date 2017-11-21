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
                <h3>ตั้งค่าระบบ</h3>
              </div>             
            </div>
            <div class="clearfix"></div>
            <?php
            $company=$database->get("properties", ['company_fullname','company_shortname','company_address_row1','company_address_row2','company_tel','company_fax','company_email','company_website','company_taxid','billno','vat_rate']);
            
            ?>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel" style="height: auto;">
                  <div class="x_title">
                    <h2>Company Setting <small>รายละเอียดบริษัท</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                    <div class="x_content" style="display: none;">
                     <form id="form-company" data-parsley-validate class="form-horizontal form-label-left" action="setting_action.php" method="POST">
                         <input type="hidden" name="type_submit" value="company">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_fullname">ชื่อเต็มบริษัท <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="company_fullname" type="text" id="company_fullname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_fullname']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_shortname">ชื่อย่อบริษัท <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="company_shortname" type="text" id="company_shortname" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_shortname']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_address_row1">ที่อยู่บริษัท <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input name="company_address_row1" type="text" id="company_address_row1" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_address_row1']; ?>">
                            <input name="company_address_row2" type="text" id="company_address_row2" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_address_row2']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_tel">เบอร์โทร <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="company_tel" type="text" id="company_tel" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_tel']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_fax">เบอร์แฟกซ์ <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="company_fax" type="text" id="company_fax" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_fax']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_email">อีเมล์ <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="company_email" type="text" id="company_email" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_email']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_website">เว็บไซต์ <span class="required">*</span> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="company_website" type="text" id="company_website" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_website']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="company_taxid">เลขที่กำกับภาษี <span class="required">*</span> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="company_taxid" type="text" id="company_taxid" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['company_taxid']; ?>">
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="button" onclick="location.href = 'index.php';" class="btn btn-primary">Cancel</button>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>  
                
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Receipt Setting <small>ค่าตั้งต้นบิล</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>    
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <form id="bill_form" data-parsley-validate class="form-horizontal form-label-left" action="setting_action.php" method="POST">               
                         <input type="hidden" name="type_submit" value="bill">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="billno">เลขที่ใบเสร็จล่าสุด <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="billno" type="text" id="billno" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['billno']; ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vat_rate">หักภาษี ณ ที่จ่าย <span class="required">*</span> 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input name="vat_rate" type="text" id="vat_rate" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $company['vat_rate']; ?>">
                        </div>
                      </div>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="button" onclick="location.href = 'index.php';" class="btn btn-primary">Cancel</button>
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