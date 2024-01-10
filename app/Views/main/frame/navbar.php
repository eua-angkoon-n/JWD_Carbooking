 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
            <li class="nav-item">
                    <a class="nav-link" id="pushmenu" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-2x fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./" class="nav-link">หน้าหลัก</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?php echo "?".PageSetting::$prefixController."=".PageSetting::$AppPage['manuals']['href']?>" class="nav-link"><?php echo PageSetting::$AppPage['manuals']['title']?></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="?module=howto" class="nav-link">คู่มือการใช้งาน</a>
                </li> -->
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="ul-datetime-clock">
                        <ul>
                            <li>วัน<?php echo Setting::$arr_day_of_week[date('N', strtotime('today'))]; ?>ที่ 
                                <?php echo nowDate(date('Y-m-d H:i:s')); ?>&nbsp;
                            </li>
                            <li id="currentTime"></li>
                        </ul>
                    </div>
                    <!--clock-->
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->