<?php 
include __DIR__ . "/../functions/f-list.php";

$Call = new List_Reservation();
$vehicle = $Call->getVehicle();
$user = $Call->getUser();
?>

<div class="row">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

        <div class="col-12 p-1">
            <!--FORM 1-->
            <form id="ListForm" class="addform" name="addform" method="POST" enctype="multipart/form-data"
                autocomplete="off" novalidate="">
                <div class=" p-0 m-0 w-100 d-flex flex-column">
                    <div class="row p-0 m-0">

                        <div class="offset-md-0 col-md-12 offset-md-0 w-100 p-1">

                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12 order-1 order-md-1 order-lg-1">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="res_date">วันที่ทำการจอง</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="far fa-clock"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control float-right" id="res_date"
                                                        name="res_date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-9 ">
                                            <label for="">สถานะ</label>
                                            <div class="form-group clearfix ">
                                                <div class="icheck-primary d-inline ">
                                                    <input type="checkbox" id="res_status1" name="res_status[]" value="all"
                                                        checked>
                                                    <label for="res_status1">
                                                        ทั้งหมด
                                                    </label>
                                                </div>
                                                <div class="icheck-warning d-inline">
                                                    <input type="checkbox" id="res_status2" name="res_status[]" value="0" checked>
                                                    <label for="res_status2">
                                                        <?php echo Setting::$reservationStatus[0] ?>
                                                    </label>
                                                </div>
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="res_status3" name="res_status[]" value="1" checked>
                                                    <label for="res_status3">
                                                        <?php echo Setting::$reservationStatus[1] ?>
                                                    </label>
                                                </div>
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="res_status4" name="res_status[]" value="3" checked>
                                                    <label for="res_status4">
                                                        <?php echo Setting::$reservationStatus[3] ?>
                                                    </label>
                                                </div>
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="res_status5" name="res_status[]" value="4" checked>
                                                    <label for="res_status5">
                                                        <?php echo Setting::$reservationStatus[4] ?>
                                                    </label>
                                                </div>
                                                <?php if($_SESSION['handover'] != 0) { ?>
                                                <div class="icheck-success d-inline">
                                                    <input type="checkbox" id="res_status6" name="res_status[]" value="6" checked>
                                                    <label for="res_status6">
                                                        <?php echo Setting::$reservationStatus[6] ?>
                                                    </label>
                                                </div>
                                                <?php } ?>
                                                <div class="icheck-danger d-inline">
                                                    <input type="checkbox" id="res_status7" name="res_status[]" value="2" checked>
                                                    <label for="res_status7">
                                                        <?php echo Setting::$reservationStatus[2] ?>
                                                    </label>
                                                </div>
                                                <div class="icheck-secondary d-inline">
                                                    <input type="checkbox" id="res_status8" name="res_status[]" value="5" checked>
                                                    <label for="res_status8">
                                                        <?php echo Setting::$reservationStatus[5] ?>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="res_vehicle">ยานพาหนะ</label>
                                                <select class="form-control select2bs4" id="res_vehicle" 
                                                    multiple="multiple" name="res_vehicle[]" style="width: 100%;">
                                                    <?php echo $vehicle; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-4">
                                            <div class="form-group">
                                                <label for="res_user">ผู้จองรถ</label>
                                                <select class="form-control select2bs4" id="res_user"
                                                    multiple="multiple" name="res_user[]" style="width: 100%;">
                                                    <?php echo $user; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
            </form>
        <!--FORM 1-->

                            <div class="row">
                                <div class="col-sm-12 p-0 m-0">

                                    <table id="reservation_table"
                                        class="table table-bordered table-hover dataTable dtr-inline nowrap">
                                        <thead>
                                            <tr class="bg-light text-center">
                                                <th class="sorting_disabled" style="width:2%">No</th>
                                                <th scope="col" style="width:2%">รูปภาพ</th>
                                                <th scope="col" style="width:2%">ยานพาหนะ</th>
                                                <th scope="col" style="width:4%">ผู้จอง</th>
                                                <th scope="col" style="width:4%">ผู้ขับรถ</th>
                                                <th scope="col" style="width:4%">ผู้ร่วมเดินทาง</th>
                                                <th scope="col" style="width:5%">จุดหมายปลายทาง</th>
                                                <th scope="col" style="width:5%">อุปกรณ์เสริม</th>
                                                <th scope="col" style="width:5%">วันที่เดินทาง</th>
                                                <th scope="col" style="width:5%">เลขไมล์</th>
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
                        <!--card-->
                    </div>

                </div>
                <!--row-->
        </div>
        <!--container-->

        

    </div>
</div>