<?php 
// include __DIR__ . "/component/style.php";
// include __DIR__ . '/frame/v-modal_img.php';
include __DIR__ . "/functions/f-list.php";
$List = new List_Config();
?>

<section class="content">
  <div class="card">
    <div class="card-header">
      <h6 class="display-8 d-inline-block font-weight-bold"><i class="fas fa-chalkboard"></i>
        <?PHP echo PageSetting::$AppPage[$nowHref]['title']; ?>
      </h6>
      <div class="card-tools">
        <ol class="breadcrumb float-sm-right pt-1 pb-1 m-0">
          <li class="breadcrumb-item"><a href="./">Home</a></li>
          <li class="breadcrumb-item active">
            <?PHP echo PageSetting::$AppPage[$nowHref]['title']; ?>
          </li>
        </ol>
      </div>
    </div>

    <div class="card-body">

      <!-- form start -->
      <form id="configForm" class="addform" name="addform" method="POST" enctype="multipart/form-data">

        <div class="row">
          <div class="card card-primary col-sm-12 col-md-6">
            <div class="card-header">
              <h5 class="card-title"><i class="fas fa-book-open"></i> การจองยานพาหนะ (ทุกไซต์งาน)</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="reservation_t">ผู้ใช้งานจองรถก่อนใช้งานอย่างน้อย (ชั่วโมง):</label>
                    <div class="row">
                      <div class="col-4">
                        <input type="number" class="form-control" id="reservation_t" name="reservation_t"
                          placeholder="ชั่วโมง" value="<?php echo $List->getReservation_t() ?>"
                          aria-describedby="inputGroupPrepend" required>
                      </div>

                      <div class="col-3 align-content-center">
                        <h6 class="m-0 mt-1"><b>ชั่วโมง</b></h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="reservation_w">ข้อความแจ้งเตือน:</label>
                    <div class="row">
                      <div class="col-8">
                        <input type="text" class="form-control" id="reservation_txt" name="reservation_txt"
                          placeholder="ข้อความ..." value="<?php echo $List->getReservation_txt() ?>"
                          aria-describedby="inputGroupPrepend" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="reservation_w">การใช้งาน:</label>
                    <div class="form-group clearfix">
                      <?php echo $List->getReservation_w() ?>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="card card-primary col-sm-12 col-md-6">
            <div class="card-header">
              <h5 class="card-title"><i class="fas fa-folder-minus"></i> ระบบการจอง (ทุกไซต์งาน)</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="urgent_reservation">ระบบการจองยานพาหนะด่วน:</label>
                    <div class="form-group clearfix">
                      <?php echo $List->getUrgent_Reservation() ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="handover">ระบบการส่งมอบยานพาหนะหลังใช้งาน:</label>
                    <div class="form-group clearfix">
                      <?php echo $List->getHandOver() ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="form-group">
                    <label for="handover_f">บังคับการส่งมอบยานพาหนะ:</label>
                    <div class="form-group clearfix">
                      <?php echo $List->getHandover_Field() ?>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="handover_l">ผู้ใช้งานไม่สามารถทำการจองได้หากยังไม่ได้ส่งมอบยานพาหนะเกิน:</label>
                    <div class="row">
                      <div class="col-2">
                        <input type="number" class="form-control" id="handover_l" name="handover_l"
                          placeholder="ชั่วโมง" value="<?php echo $List->getHandover_l() ?>"
                          aria-describedby="inputGroupPrepend" required>
                      </div>

                      <div class="col-3 align-content-center">
                        <h6 class="m-0 mt-1"><b>รายการ</b></h6>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="row">
          <div class="card card-primary col-sm-12 col-md-6">
            <div class="card-header">
              <h5 class="card-title"><i class="fab fa-line"></i> การแจ้งเตือนผ่านไลน์ <?php echo $_SESSION['car_site_initialname']?></h5>
            </div>
            <div class="card-body">
            <div class="row">
              <div class="col-sm-12 ">
                <div class="form-group">
                  <label for="reservation_t">Line Access Token กลุ่มที่กำหนด: <?php if($_SESSION['car_ref_id_site'] != 1){?><code><?php echo Setting::$warning_text[4]?></code><?php }?></label>
                  <div class="row">
                    <div class="col-9">
                      <div class="input-group">
                        <input type="password" class="form-control" id="l_token" name="l_token"
                          placeholder="Line Access Token..." value="<?php echo $List->getLineToken() ?>"
                          aria-describedby="inputGroupPrepend">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary form-control" type="button" id="toggleVisibilityBtn">
                            <i class="fa fa-eye-slash justify-content-center align-middle pb-2" id="eyeIcon"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="reservation_w">การแจ้งเตือน:</label>
                    <div class="form-group clearfix">
                      <?php echo $List->getLineNotify() ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <?php if ($_SESSION['car_class_user'] == 2) { ?>
          <div class="card card-primary col-sm-12 col-md-6">
            <div class="card-header">
              <h5 class="card-title"><i class="fab fa-line"></i> การแจ้งเตือนผ่านไลน์กลุ่มหลัก</h5>
            </div>
            <div class="card-body">
            <div class="row">
              <div class="col-sm-12 ">
                <div class="form-group">
                  <label for="reservation_t">Line Access Token กลุ่มหลัก:</label>
                  <div class="row">
                    <div class="col-9">
                      <div class="input-group">
                        <input type="password" class="form-control" id="l_token_main" name="l_token_main"
                          placeholder="Line Access Token..." value="<?php echo $List->getLineTokenMain() ?>"
                          aria-describedby="inputGroupPrepend">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary form-control" type="button" id="toggleVisibilityBtn2">
                            <i class="fa fa-eye-slash justify-content-center align-middle pb-2" id="eyeIcon2"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="reservation_w">การแจ้งเตือน:</label>
                    <div class="form-group clearfix">
                      <?php echo $List->getLineNotifyMain() ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
            <?php }?>
        </div>
        <div class="row">
        <?php if ($_SESSION['car_class_user'] == 2) { ?>
          <div class="card card-primary col-sm-12 col-md-6">
            <div class="card-header">
              <h5 class="card-title"><i class="fas fa-code-branch"></i> เวอร์ชันของระบบ</h5>
            </div>
            <div class="card-body">

              <div class="row">
                <div class="col-sm-12">
                  <div class="row">

                    <div class="col-sm-12 col-md-3">
                      <div class="form-group col-12">
                        <label for="reservation_t">Phase:</label>
                        <input type="number" class="form-control w-100" id="sysPhase" name="sysPhase"
                          placeholder="Phase" value="<?php echo $List->getPhase() ?>"
                          aria-describedby="inputGroupPrepend" required>
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                      <div class="form-group col-8">
                        <label for="reservation_t">Version:</label>
                        <input type="text" class="form-control w-75" id="sysVersion" name="sysVersion"
                          placeholder="Version" value="<?php echo $List->getVersion() ?>"
                          aria-describedby="inputGroupPrepend" required>
                      </div>
                    </div>

                  </div>

                </div>

              </div>

            </div>
          </div>
        <?php } ?>
        </div>

        <div class="row">
          <button type="button" class="btn btn-success btn-submit">บันทึก</button>
        </div>

      </form>

    </div>
  </div>
</section>

<?php 
include __DIR__ . '/component/script.php';
// include __DIR__ . '/component/script_map.php';
// include __DIR__ . '/component/script_dataTable.php';
?>
