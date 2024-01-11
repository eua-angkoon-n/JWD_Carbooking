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
              <h5 class="card-title">การจองยานพาหนะ</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="reservation_t">ผู้ใช้งานจองรถก่อนใช้งานอย่างน้อย (ชั่วโมง):</label>
                    <div class="row">
                      <div class="col-9">
                        <input type="number" class="form-control" id="reservation_t" name="reservation_t"
                          placeholder="นาที" value="<?php echo $List->getReservation_t() ?>"
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
              <h5 class="card-title">การแจ้งเตือนผ่านไลน์</h5>
            </div>
            <div class="card-body">
            <div class="row">
                <div class="col-sm-12 ">
                  <div class="form-group">
                    <label for="reservation_t">Line Access Token:</label>
                    <div class="row">
                      <div class="col-9">
                        <input type="text" class="form-control" id="l_token" name="l_token"
                          placeholder="Line Access Token..." value="<?php echo $List->getLineToken() ?>"
                          aria-describedby="inputGroupPrepend">
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
        </div>

        <div class="row">
          <div class="card card-primary col-sm-12 col-md-6">
            <div class="card-header">
              <h5 class="card-title">เวอร์ชันของระบบ</h5>
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
