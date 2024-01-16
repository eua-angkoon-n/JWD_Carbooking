  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-light navbar-white nav-gradient" >
    <div class="container">
      <a href="./" class="navbar-brand">
        <img src="../dist/img/SCGJWDLogo.png" alt="SCGJWD Logo" class="brand-image ">
        
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="./" class="nav-link" style="color:white"><strong>หน้าหลัก</strong></a>
          </li>
          <li class="nav-item">
                    <a href="<?php echo "?".PageSetting::$prefixController."=".PageSetting::$MilePage['manuals']['href']?>" class="nav-link" style="color:white"><strong><?php echo PageSetting::$MilePage['manuals']['title']?></strong></a>
                </li>
          <li class="nav-item">
          <a href="<?php echo "?".PageSetting::$prefixController."=".PageSetting::$MilePage['logout']['href']?>" class="nav-link" style="color:white"><strong><?php echo PageSetting::$MilePage['logout']['title']?></strong></a>
          </li>
        </ul>


      </div>

      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item">
        <div class="ul-datetime-clock" >
                        <ul>
                            <li style="color:white">วัน<?php echo Setting::$arr_day_of_week[date('N', strtotime('today'))]; ?>ที่ 
                                <?php echo nowDate(date('Y-m-d H:i:s')); ?>&nbsp;
                            </li>
                            <li id="currentTime" style="color:white"></li>
                        </ul>
                    </div>
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->