<?php 
include(__DIR__ . "/frame/v-modal.php");
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

    <div class="card-body content-gradient">
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <!-- /.col -->
            <div class="col-md-12 col-lg-9 order-lg-1 order-md-2 order-sm-2">
              <div class="card card-primary">
                <div class="card-body p-0">
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>

            <div class="col-md-12 col-lg-3 order-lg-2 order-md-1 order-sm-1">

              <div class="card-body p-0 col-md-12 col-lg-12">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fas fa-calendar"></i></span>

                  <div class="info-box-content">
                    <span class="info-box-number">การจองยานพาหนะวันนี้</span>
                    <span class="info-box-text" id="today_res">0</span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
              </div>

              <div id="side_card">
                <div class="card text-center loading">
                  <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                </div>
              </div>


              <!-- <div class="card card-warning">
                <div class="card-header">
                  <h3 class="card-title">รออนุมัติ</h3>
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">

                  <div class="info-box m-0">
                    <span class="info-box-icon">
                      <img src='dist/temp_img/20231122/3b40e191122aaff08b8cc8f25b33a77b.jpg' alt='Vehicle Image'
                        class='img-thumbnail rounded mx-auto d-block'>
                    </span>

                    <div class="info-box-content">
                      <span class="info-box-number">การจองยานพาหนะวันนี้</span>
                      <span class="info-box-text">410</span>
                      <span class="info-box-text">410</span>
                    </div>
                    <!-- /.info-box-content -->
                  <!-- </div>
                </div>
              </div> -->


            




              <!-- /.card -->
            </div>


            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>

    </div>
  </div>
</section>

<?php 
include(__DIR__ . "/component/script_calendar.php");
include(__DIR__ . "/component/script.php");
?>