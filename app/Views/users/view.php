<?php 
// include __DIR__ . "/component/style.php";
// include __DIR__ . '/../reservationList/frame/v-modal_img.php';
// include __DIR__ . '/frame/v-modal-edit.php';
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

            <div class="row">

                <div class="col-sm-12 p-2 m-0">

                    <table id="user_table" class="table table-bordered table-hover dataTable dtr-inline nowrap">
                        <thead>
                            <tr class="bg-light text-center">
                                <th class="sorting_disabled" style="width:2%">No</th>
                                <th scope="col" style="width:2%">รหัสพนักงาน</th>
                                <th scope="col" style="width:10%">อีเมล์</th>
                                <th scope="col" style="width:5%">ชื่อ-นามสกุล</th>
                                <th scope="col" style="width:5%">ไซต์</th>
                                <th scope="col" style="width:5%">แผนก</th>
                                <th scope="col" style="width:2%">ระดับผู้ใช้งาน</th>
                                <th scope="col" style="width:2%">สถานะ</th>
                                <th scope="col" style="width:8%">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</section>

<?php 
include __DIR__ . '/component/script.php';
//include __DIR__ . '/component/script_map.php';
include __DIR__ . '/component/script_dataTable.php';
?>
