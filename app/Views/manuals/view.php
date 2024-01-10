<?php 
include __DIR__ . "/component/style.php";
include __DIR__ . '/../reservationList/frame/v-modal_img.php';
isset($_SESSION['car_class_user']) ? $class = $_SESSION['car_class_user'] : $class = 0;
?>

<section class="content">
  <div class="card">
    <div class="card-header">
      <h6 class="display-8 d-inline-block font-weight-bold"><i class="nav-icon fas fa-file-invoice"></i>
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

<!-- Howto 1 -->
<div class="card collapsed-card">
  <div class="card-header card-info" data-card-widget="collapse" title="อ่านวิธีใช้งาน">
    <a href="#" class="link-info"><span class="card-title text-sm"><strong><i
            class="fas fa-info-circle"></i> อธิบายโปรแกรมจองรถธุรการออนไลน์ </strong></span></a>
    <div class="card-tools"><button type="button" class="btn btn-tool">คลิกอ่าน</button></div>
  </div>
  <div class="card-body p-howto">
    โปรแกรมจองรถธุรการออนไลน์ ใช้สำหรับจองยานพาหนะ ภายในบริษัทเพื่อนำยานพาหนะไปใช้งานต่าง ๆ
    <strong class="d-block mt-2 mb-2">ความสามารถของโปรแกรมจองรถธุรการออนไลน์
      <?php echo "Phase ".$_SESSION['phase']." Version ".$_SESSION['version'] ?></strong>
    <ul class="">
      <li>สามารถจองยานพาหนะผ่านทางคอมพิวเตอร์ หรือ โทรศัพท์มือถือได้ (Web Application) </li>
      <li><strong>ระบบจัดการสามารถใช้งานทั่วไปได้ดังนี้</strong></li>
      <ul>
        <li>จองยานพาหนะ ตามช่วงวันเวลาที่ต้องการได้</li>
        <li>ตรวจสอบช่วงเวลาที่ต้องการจองว่า มียานพาหนะใดที่สามารถจองได้ และไม่ได้</li>
        <li>ตรวจสอบ และบันทึกเลขไมล์ออก - เข้าบริษัทได้</li>
        <li>ส่งมอบยานพาหนะเพื่อเป็นข้อมูลต่างๆ และหลักฐานในระบบได้</li>
      </ul>
      <?php if($class == 1 || $class == 2){ ?>
      <li><strong>ในส่วนของฝ่ายธุรการสามารถจัดการได้ดังนี้</strong></li>
      <ul>
        <li>ตรวจสอบ และอนุมัติการจองยานพาหนะได้</li>
        <li>ดูรายการจองทั้งหมด และรายละเอียดการจองยานพาหนะได้</li>
      </ul>
      <?php } 
      if ($class == 2) {?>
       <li><strong>ในส่วนของผู้ดูแลระบบสามารถจัดการได้ดังนี้</strong></li>
      <ul>
        <li>ตั้งค่าจัดการข้อมูลยานพาหนะ, ประเภทยานพาหนะ, ยี่ห้อยานพาหนะ, อุปกรณ์เสริม และพนักงานขับรถ</li>
        <li>จัดการผู้ใช้งาน ปรับระดับ และสถานะการใช้งานได้</li>
        <li>ตั้งค่าต่างๆ เกี่ยวกับภายในระบบจองรถธุรการได้ </li>
      </ul>
      <?php } ?>
    </ul>
  </div>
  <!-- /.card-body -->
</div><!-- /.card collapsed-card -->
<!-- End Howto 1 -->


<!-- Howto 2 -->
<div class="card collapsed-card">
  <div class="card-header" data-card-widget="collapse" title="อ่านวิธีใช้งาน">
    <a href="#" class="link-info"><span class="card-title text-sm"><strong><i
            class="fas fa-info-circle"></i> คู่มือการใช้งานทั่วไป ระบบจองรถธุรการ </strong></span></a>
    <div class="card-tools"><button type="button" class="btn btn-tool">คลิกอ่าน</button></div>
  </div>
  <div class="card-body">
    <!--style="display:block;"-->
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user1.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user1.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <strong class="d-block mt-2 mb-2">เมนูหน้าแรกจะเป็นการโชว์ปฏิทินรายงานการจองรถและแสดงรายการจองของวันนี้ โดยด้านซ้ายจะมีเมนูสำหรับใช้งานดังต่อไปนี้</strong>
        <ul class="">
          <li>1. หน้าหลัก</li>
          <li>2. จองยานพาหนะ</li>
          <li>3. รายการจองของฉัน</li>
          <li>4. ส่งมอบยานพาหนะ</li>
          <li>5. ออกจากระบบ</li>
        </ul>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user2.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user2.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <strong class="d-block mt-2 mb-2">ขั้นตอนการจองยานพาหนะ มีวิธีดังนี้</strong>
        <ul class="">
          <li>1. เลือกช่วงวันเวลาที่ต้องการจะใช้ยานพาหนะ</li>
          <li>2. สามารถเลือกกรองดูยานพาหนะที่ว่างหรือไม่ ได้ในช่วงเวลาที่เลือก</li>
          <li>3. หลังจากเลือกยานพาหนะที่ต้องการได้แล้ว กด <strong>จองยานพาหนะ</strong></li>
        </ul>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user3.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user3.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <ul>
          <li>4. ตรวจสอบช่วงวันเวลาและรายละเอียดของผู้จอง</li>
          <li>5. เลือกจุดหมายที่ท่านต้องการเดินทางไปบนแผนที่ หรือกรอกระบุเองในช่องด้านล่าง</li>
          <li>6. ใส่รายละเอียดที่เหลือในการจอง หลังจากนั้นกด<strong>ยืนยัน</strong></li>
        </ul>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user4.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user4.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <ul>
          <li>7. ตรวจสอบความถูกต้องอีกครั้ง และกด<strong>บันทึก</strong>เพื่อทำการจอง หลังจากนั้นรอฝ่ายธุรการอนุมัติ</li>
          <li>8. เมื่อทำการใช้รถ ก่อนเข้า หรือ ออก บริษัท กรุณาแจ้งเจ้าหน้าที่รักษาความปลอดภัย ให้ทำการกรอกเลขไมล์และถ่ายรูปเพื่อเป็นข้อมูลให้กับฝ่ายธุรการ</li>
        </ul>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user5.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user5.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <li><strong class="mt-2 mb-2">เมนูรายการจองของฉัน</strong> สามารถตรวจสอบรายการจองทั้งหมดของตัวเอง หรือทำการยกเลิกการจองยานพาหนะก่อนใช้งานได้</li>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user6.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user6.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <li><strong class="mt-2 mb-2">เมนูส่งมอบยานพาหนะ</strong> หลังจากทำการใช้ยานพาหนะและคืนเสร็จสิ้น ท่านสามารถทำการส่งมอบยานพาหนะ เพื่อเป็นข้อมูลในการใช้งานยานพาหนะ ให้กับฝ่ายธุรการได้ ด้วยการเลือกที่ปุ่ม<strong>ส่งมอบ</strong> และดำเนินการกรอกข้อมูลต่อไปนี้</li>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/user7.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/user7.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <ul>
          <li>1. ระบุสภาพภายในและภายนอกยานพาหนะ พร้อมแนบรูปถ่าย (ถ้ามี)</li>
          <li>2. ระบุปริมาณน้ำมันที่เหลือของยานพาหนะ พร้อมแนบรูปถ่าย (ถ้ามี)</li>
          <li>3. หากมีค่าใช้จ่ายในการเดินทางที่ต้องการเบิก ระบุค่าใช้จ่ายพร้อมแนบหลักฐาน หากมีมากกว่า 1 อย่าง สามารถเลือกที่ปุ่ม <i class="fas fa-plus-circle text-success"></i> เพื่อเพิ่มช่องในการใส่ข้อมูลได้</li>
          <li>4. เมื่อเสร็จสิ้นและตรวจสอบข้อมูลแล้ว เลือก<strong>บันทึก</strong>เพื่อดำเนินการต่อ</li>
        </ul>
      </ul>
    </div>

  </div><!-- /.card-body -->
</div><!-- /.card collapsed-card -->
<!-- End Howto 2 -->

<?php if($class == 1 || $class == 2) {?>
  <!-- Howto HR -->
<div class="card collapsed-card">
  <div class="card-header" data-card-widget="collapse" title="อ่านวิธีใช้งาน">
    <a href="#" class="link-info"><span class="card-title text-sm"><strong><i
            class="fas fa-info-circle"></i> คู่มือการใช้งานสำหรับฝ่ายธุรการ ระบบจองรถธุรการ</strong></span></a>
    <div class="card-tools"><button type="button" class="btn btn-tool">คลิกอ่าน</button></div>
  </div>
  <div class="card-body">
    <!--style="display:block;"-->
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/hr1.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/hr1.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
        <strong class="d-block mt-2 mb-2">เมนูหน้าแรกแสดงปฏิทินเหมือนในส่วนของผู้ใช้งานทั่วไป แต่ด้านขวาจะแสดงข้อมูงของการจองยานพาหนะที่มีการรอการอนุมัติ และแถบด้านซ้ายจะมีเมนูสำหรับผู้ดูแลโดยจะมีดังนี้</strong>
        <ul class="">
          <li>1. การอนุมัติ</li>
          <li>2. รายการจองทั้งหมด</li>
        </ul>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/hr2.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/hr2.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
         <li><strong class="mt-2 mb-2">การอนุมัติ </strong>แสดงรายการรออนุมัติการจองยานพาหนะทั้งหมด</li>
      </ul>
    </div>
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/hr3.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/hr3.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none">
         <li><strong class="mt-2 mb-2">รายการจองทั้งหมด </strong> แสดงบันทึกรายการจองยานพาหนะที่มีทั้งหมดภายในระบบ</li>
      </ul>
    </div>

  </div><!-- /.card-body -->
</div><!-- /.card collapsed-card -->
<!-- End Howto HR -->
<?php } ?>

<?php if($class == 2) {?>
  <!-- Howto Admin -->
<div class="card collapsed-card">
  <div class="card-header" data-card-widget="collapse" title="อ่านวิธีใช้งาน">
    <a href="#" class="link-info"><span class="card-title text-sm"><strong><i
            class="fas fa-info-circle"></i> คู่มือการใช้งานสำหรับผู้ดูแลระบบ ระบบจองรถธุรการ</strong></span></a>
    <div class="card-tools"><button type="button" class="btn btn-tool">คลิกอ่าน</button></div>
  </div>
  <div class="card-body">
    <!--style="display:block;"-->
    <div class="row text-center">
      <div class="col-12">
        <a class="modal-img" data-id="dist/img/manuals/adm1.png" data-toggle='modal' data-target='#modal-img'>
          <img src="dist/img/manuals/adm1.png" class="w-50 mb-1" />
          <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
        </a>
      </div>
    </div>
    <div class="row">
      <ul class="howto-style-none mb-0">
        <li><strong class="mt-2 mb-0">1. แถบเมนูสำหรับผู้ดูแลระบบ</strong> อาจมีเพิ่มเติมหากระบบมีการพัฒนาเวอร์ชันใหม่ ๆ โดยใน <strong>Phase <?php echo $_SESSION['phase']."/ Version ".$_SESSION['version'] ?></strong> นี้จะมีแถบเมนูต่อไปนี้</li>
      </ul>
    </div>
    <div class="row">
    <ul class="ul_style_1 mb-0">
      <ul>
        <li>จัดการยานพาหนะ</li>
        <li>จัดการผู้ใช้งาน</li>
        <li>ตั้งค่าระบบ</li>
      </ul>
        </ul>
    </div>
    <div class="row">
      <ul class="howto-style-none mb-0">
        <li><strong class="mt-2 mb-0">2. แถบเมนูสำหรับเลือกรายการต่าง ๆ</strong> เพื่อทำการจัดการ</li>
        <li><strong class="mt-2 mb-0">3. กดเพื่อเพิ่มรายการการจัดการใหม่</strong></li>
        <li><strong class="mt-2 mb-0">4. ปรับสถานะการใช้งาน และ แก้ไขหรือดูรายละเอียดของรายการ</strong></li>
      </ul>
    </div>

  </div><!-- /.card-body -->
</div><!-- /.card collapsed-card -->
<!-- End Howto Admin -->
<?php } ?>

</div><!-- /.card-body -->
  </div>
</section>
<?php 
include __DIR__ . '/component/script.php';
?>

