<?php 
include __DIR__ . "/component/style.php";
// include __DIR__ . '/frame/v-modal-detail.php';
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

    <div class="card-body p-1">

    <div id="carouselPage" class="carousel slide" data-ride="carousel" data-touch="false" data-interval="false">
      <div class="carousel-inner">
        <div class="carousel-item active" data-slide-number="0" data-target="#carouselPage">
           <?php include __DIR__ . "/frame/v-list.php";?>
        </div>
        <div class="carousel-item " data-slide-number="1" data-target="#carouselPage">
          <?php include __DIR__ . "/frame/v-reservation_detail.php";?>
        </div>
        <!-- <div class="carousel-item " data-slide-number="2" data-target="#carouselPage">
        </div> -->
        
      </div>
    </div>

    </div>
  </div>
</section>

<?php 
include __DIR__ . '/component/script.php';
// include __DIR__ . '/component/script_map.php';
include __DIR__ . '/component/script_dataTable.php';
?>

