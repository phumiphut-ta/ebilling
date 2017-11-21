            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="../dashboard/index.php"><i class="fa fa-home"></i> หน้าหลัก </a></li>
                  <li><a><i class="fa fa-file-pdf-o"></i> รายงาน <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="../report/SaleVatReport.php">รายงานภาษีขาย</a></li>
                        <li><a href="../report/SaleSummaryReport.php">รายงานสรุปยอดขายรายเดือน</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-newspaper-o"></i> ชุดบิล <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="../bill/MasterBill.php">ค้นหาชุดบิล</a></li>
                        <li><a href="../bill/BillAdd.php">ออกชุดบิลใหม่</a></li>
                    </ul>
                  </li>
                  <?php if($_SESSION["user_id"]==1){?>
                  <li><a><i class="fa fa-shopping-cart"></i> คู่ค้า <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="../customer/MasterCustomer.php">ค้นหาคู่ค้า</a></li>
                        <li><a href="../customer/CustomerAdd.php">คู่ค้าใหม่</a></li>
                    </ul>
                  </li>
                  <li><a><i class="fa fa-archive"></i> สินค้า <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="../product/MasterProduct.php">ค้นหาสินค้า</a></li>
                        <li><a href="../product/ProductAdd.php">เพิ่มสินค้าใหม่</a></li>
                    </ul>
                  </li>
                  
                  <li><a href="../setting/MasterSetting.php"><i class="fa fa-gears"></i> ตั้งค่าระบบ </a></li>
                  <?php } ?>
                </ul>
              </div>


            </div>