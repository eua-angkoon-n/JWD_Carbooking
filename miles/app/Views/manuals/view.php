<?php 
include __DIR__ . "/component/style.php";
include __DIR__ . '/../../../../app/Views/reservationList/frame/v-modal_img.php';
isset($_SESSION['car_class_user']) ? $class = $_SESSION['car_class_user'] : $class = 0;
?>
<!-- Main content -->
<div class="content">
  <div class="container">
    <div class="row">

      <div class="col-lg-12">
        <div class="card">

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
                  <li><strong>ในส่วนของพนักงานรักษาความปลอดภัยระบบสามารถจัดการได้ดังนี้</strong></li>
                  <ul>
                    <li>บันทึกเลขไมล์ออก - เข้า บริษัทได้ </li>
                  </ul>
                </ul>
              </div>
              <!-- /.card-body -->
            </div><!-- /.card collapsed-card -->
            <!-- End Howto 1 -->


            <!-- Howto 2 -->
            <div class="card collapsed-card">
              <div class="card-header" data-card-widget="collapse" title="อ่านวิธีใช้งาน">
                <a href="#" class="link-info"><span class="card-title text-sm"><strong><i
                        class="fas fa-info-circle"></i> คู่มือการใช้งานสำหรับการบันทึกเลขไมล์
                      ระบบจองรถธุรการ</strong></span></a>
                <div class="card-tools"><button type="button" class="btn btn-tool">คลิกอ่าน</button></div>
              </div>
              <div class="card-body">
                <!--style="display:block;"-->
                <div class="row text-center">
                  <div class="col-12">
                    <a class="modal-img" data-id="../dist/img/manuals/sr1.png" data-toggle='modal' data-target='#modal-img'>
                      <img src="../dist/img/manuals/sr1.png" class="w-50 mb-1" />
                      <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
                    </a>
                  </div>
                </div>
                <div class="row">
                  <ul class="howto-style-none">
                    <strong class="d-block mt-2 mb-2">หน้าแรกสำหรับการบันทึกเลขไมล์ระบบจองรถธุรการ
                      โดยจะมีเมนูให้เลือกต่อไปนี้</strong>
                    <ul class="">
                      <li>1. สำหรับกรณีมีรถออกจากบริษัท เลือก “<strong>บันทึกเลขไมล์ ออกบริษัท</strong>” เพื่อทำการบันทึกข้อมูล</li>
                      <li>2. สำหรับกรณีมีรถกลับเข้ามาในบริษัท เลือก “<strong>บันทึกเลขไมล์ เข้าบริษัท</strong>” เพื่อทำการบันทึกข้อมูล</li>
                    </ul>
                  </ul>
                </div>
                <div class="row text-center">
                  <div class="col-12">
                    <a class="modal-img" data-id="../dist/img/manuals/sr2.png" data-toggle='modal' data-target='#modal-img'>
                      <img src="../dist/img/manuals/sr2.png" class="w-50 mb-1" />
                      <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
                    </a>
                  </div>
                </div>
                <div class="row">
                  <ul class="howto-style-none">
                    <strong class="d-block mt-2 mb-2">ขั้นตอนการบันทึกเลขไมล์เข้า - ออกบริษัท มีวิธีดังนี้</strong>
                    <ul class="">
                      <li>1. เลือกค้นหายานพาหนะ และวันที่ยานพาหนะ ออกเดินทางหรือเข้าบริษัท ที่ต้องการบันทึก</li>
                      <li>2. หลังจากนั้นเลือก <strong>บันทึกเลขไมล์</strong> เพื่อทำการบันทึก </li>
                    </ul>
                  </ul>
                </div>
                <div class="row text-center">
                  <div class="col-12">
                    <a class="modal-img" data-id="../dist/img/manuals/sr3.png" data-toggle='modal' data-target='#modal-img'>
                      <img src="../dist/img/manuals/sr3.png" class="w-50 mb-1" />
                      <p class="pointer">คลิกเพื่อดูรูปขนาดใหญ่</p>
                    </a>
                  </div>
                </div>
                <div class="row">
                  <ul class="howto-style-none">
                    <ul>
                      <li>3. ใส่วันที่ และเวลาที่ทำการบันทึกข้อมูลนี้</li>
                      <li>4. ใส่จำนวนเลขไมล์ของยานพาหนะ โดยดูจากเลขไมล์ที่หน้าคอนโซลรถ</li>
                      <li>5. ระบุชื่อของผู้ที่ทำการบันทึกข้อมูล</li>
                      <li>6. ระบุหมายเหตุ (ถ้ามี)</li>
                      <li>7. ใส่ภาพถ่ายของเลขไมล์ที่หน้าคอนโซลรถ (ถ้ามี)</li>
                      <li>8. หลังจากนั้น ทำการบันทึก เป็นการเสร็จขั้นตอน</li>
                    </ul>
                  </ul>
                </div>


              </div><!-- /.card-body -->
            </div><!-- /.card collapsed-card -->
            <!-- End Howto 2 -->

          </div><!-- /.card-body -->

        </div>
      </div>

    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
<?php 
include __DIR__ . '/component/script.php';
?>

