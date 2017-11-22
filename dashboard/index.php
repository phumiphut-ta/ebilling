<?php 
session_start();
require '../config/webconfig.php'; 
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
                <h3>Home</h3>
              </div>

              <div class="title_right">
                
              </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Dashboard <small>แดชบอร์ด</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZjYxNGZiNzUtNDM0NC00M2QwLWExYjMtODUzMGE5ZWNiNTU0IiwidCI6ImEzMzU2M2FlLWUxNTUtNDA0OS05N2UwLTY4MTg3NWFiZmY5NSIsImMiOjEwfQ%3D%3D" frameborder="0" allowFullScreen="true"></iframe>       
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