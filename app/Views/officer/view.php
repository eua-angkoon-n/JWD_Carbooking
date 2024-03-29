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

        <div class="card-body p-1">
           
        <div class="col-12 col-sm-12 pt-1">
            <div class="card card-secondary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tab1" data-toggle="pill" href="#custom-tabs-1" role="tab" aria-controls="custom-tabs-1" aria-selected="true">พนักงานขับรถ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tab2" data-toggle="pill" href="#custom-tabs-2" role="tab" aria-controls="custom-tabs-2" aria-selected="false">เจ้าหน้าที่รักษาความปลอดภัย</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-1" role="tabpanel" aria-labelledby="custom-tabs-1">
                      <?php include_once __DIR__ . '/vehicle_driver/v-list.php'; //หน้ารายการ ?>
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-2" role="tabpanel" aria-labelledby="custom-tabs-2">
                    ...TAB-2 Wait process
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>

        </div>
    </div>
</section>

<?php 
include __DIR__ . '/script.php';
?>