 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                     <a href="./" class="nav-link">
                <img src="dist/img/SCGJWDLogo.png" alt="JWD Logo" class="h-100 p-0 m-0">
            </a>
                </li>
                <!-- <a href="./" class="brand-link">
                <img src="dist/img/SCGJWDLogo.png" alt="JWD Logo" class="w-100 p-0 m-0">
            </a> -->
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="./" class="nav-link">Home</a>
                </li> -->
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="?module=howto" class="nav-link">คู่มือการใช้งาน</a>
                </li> -->
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="ul-datetime-clock">
                        <ul>
                            <li><?php echo Setting::$arr_day_of_weekEN[date('N', strtotime('today'))]; ?> 
                                <?php echo nowDateEN(date('Y-m-d H:i:s')); ?>&nbsp;
                            </li>
                            <li id="currentTime"></li>
                        </ul>
                    </div>
                    <!--clock-->
                </li>
            </ul>

        </nav>
        <!-- /.navbar -->