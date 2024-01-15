<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color:#000043;">
            <!-- Brand Logo -->
            <a href="./" class="brand-link">
                <img src="dist/img/SCGJWDLogo.png" alt="JWD Logo" class="w-100 p-0 m-0">
                <span class="font-weight-bold p-1 mt-2 text-pcs-ct" style="background-color:#f15c22;color:white">
                    <?PHP echo $title; ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar"><br><br>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-1 mb-3 d-flex">
                    <div class="image">
                        <img src="dist/img/user2-160x160.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            <?PHP echo $_SESSION['car_fullname']; ?></a>
                        <span class="text-white">ระดับ:
                            <?PHP echo Setting::$classArr[$_SESSION['car_class_user']]; ?>
                        </span>
                        <br>
                        <span class="text-white">
                            ไซต์งาน: <?PHP echo $_SESSION['car_site_initialname']; ?>
                            แผนก: <?PHP echo $_SESSION['car_dept_initialname']?>
                        </span>
                            
                            </span>
                            
                        <!-- <a href="?module=profile" class="d-block text-yellow">[แก้ไขข้อมูลส่วนตัว]</a> -->
                    </div>
                </div>

                <!-- Sidebar Menu active-->
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <?php 
                            echo Show_Sidebar($nowHref);
                        ?>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                        <li>&nbsp;</li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>