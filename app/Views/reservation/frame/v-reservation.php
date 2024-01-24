<?php 
include __DIR__ . "/../functions/f-reservation.php"; 

$r = new Reservation();
$acc  = $r->getAcc();
$drv  = $r->getDriver();
$user = $r->getUser();
?>

<div class="row">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

        <div class="col-12 p-1">
            <!--FORM 1-->
            <form id="sendForm" class="addform" name="addform" method="POST" enctype="multipart/form-data"
                autocomplete="off" novalidate="">
                <div class=" p-0 m-0 w-100 d-flex flex-column">
                    <div class="row p-0 m-0">

                        <div class="offset-md-0 col-md-12 offset-md-0">
                            <div class="card w-100">
                                <div class="card-header bg-primary text-white p-2">
                                    <div class="row">
                                        <button type="button" class="btn btn-xs btn-primary ml-1 Reservation-cancel">
                                            <i class="fas fa-caret-left"></i>
                                        </button>
                                        <p class="card-title text-size-1">&nbsp;กรอกรายละเอียด</p>
                                    </div>
                                </div>
                                <div class="card-body p-3">


                                    <div class="row">
                                        <div class="col-sm-12 col-xs-2 col-md-2 ">
                                            <div class="form-group">
                                                <label for="res_vehicle">ยานพาหนะ</label>
                                                <input type="text" id="res_vehicle" name="res_vehicle" maxlength="60"
                                                    placeholder="เลขทะเบียน" class="form-control"
                                                    aria-describedby="inputGroupPrepend" required disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-4 col-md-4 ">
                                            <div class="form-group">
                                                <label for="res_date">วันที่/เวลาการจอง</label>
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
                                        <div class="col-sm-12 col-xs-4 col-md-2">
                                            <div class="form-group">
                                                <label for="res_user">ชื่อผู้จอง</label>
                                                <input type="text" id="res_user" name="res_user" maxlength="60"
                                                    placeholder="ชื่อผู้จอง" class="form-control"
                                                    aria-describedby="inputGroupPrepend" required disabled />
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-4 col-md-2">
                                            <div class="form-group">
                                                <label for="res_tel">เบอร์โทรศัพท์</label>
                                                <input type="tel" id="res_tel" name="res_tel" class="form-control"
                                                    aria-describedby="inputGroupPrepend" />
                                            </div>
                                        </div>
                                    </div>
                                    <!--row-4-->

                                    <div class="row">
                                        <div class="col-12">
                                            <label for="res_user">เลือกจุดหมายปลายทางบนแผนที่</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12  d-flex align-items-stretch"
                                            style="height: 450px">
                                            <div id="map_canvas" class="w-100 h-100"></div>
                                        </div>
                                    </div>

                                    <div class="row mt-1">
                                        <div class="col-sm-12 col-xs-4 col-md-4 ">
                                            <div class="form-group">
                                                <label for="seat">หรือ ระบุจุดหมายปลายทางเอง</label>
                                                <input type="text" id="map_place" name="map_place" maxlength="60"
                                                    placeholder="จุดหมายปลายทาง" class="form-control"
                                                    aria-describedby="inputGroupPrepend" required />
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-3 col-md-3 ">
                                            <div class="form-group">
                                                <label for="res_companion">ผู้เดินทาง</label><code> *ค้นหาหรือระบุเอง</code>
                                                <select class="select2bs4 " multiple="multiple" rows="3"
                                                    id="res_companion" name="res_companion[]"
                                                    data-placeholder="ค้นหาหรือระบุเอง..." style="width: 100%;"
                                                    aria-describedby="inputGroupPrepend" required>
                                                    <?php echo $user; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-1 col-md-1 ">
                                            <div class="form-group">
                                                <label for="count_travel">จำนวนผู้เดินทาง</label>
                                                <input type="number" id="count_travel" name="count_travel"
                                                    placeholder="1" class="form-control"
                                                    aria-describedby="inputGroupPrepend" disabled />
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-sm-12 col-xs-4 col-md-4 ">
                                            <div class="form-group">
                                                <label for="res_reason">เหตุผลในการเดินทาง</label>
                                                <textarea class="form-control" id="res_reason" name="res_reason"
                                                    rows="3" placeholder="เหตุผล..."
                                                    aria-describedby="inputGroupPrepend" required></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-2 col-md-2 ">
                                            <div class="form-group">
                                                <label>อุปกรณ์เสริม</label><code> *เว้นว่างหากไม่ต้องการ</code>
                                                <select class="select2bs4" multiple="multiple" id="res_acc"
                                                    name="res_acc[]" data-placeholder="เลือกอุปกรณ์เสริม"
                                                    style="width: 100%;">
                                                    <?php echo $acc; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-2 col-md-2 ">
                                            <div class="form-group">
                                                <label>พนักงานขับรถ</label>
                                                <select class="form-control select2bs4" id="res_driver"
                                                    name="res_driver" style="width: 100%;">
                                                    <?php echo $drv; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($_SESSION['urgent'] == 1){?>
                                    <div class="row">
                                        <div class="col-sm-12 col-xs-2 col-md-2 ">
                                            <div class="form-group clearfix">
                                                <div class="icheck-danger ">
                                                    <input type="checkbox" id="urgent" name="urgent" val="1">
                                                    <label for="urgent">
                                                        จองยานพาหนะด่วน
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="col-sm-6 col-md-2 col-lg-1">
                                            <div class="form-group">
                                                <input type="button" class="btn btn-confirm btn-success btn-block"
                                                    value="ยืนยัน" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-2 col-lg-1">
                                            <div class="form-group">
                                                <input type="button" class="btn Reservation-cancel btn-danger btn-block"
                                                    value="ยกเลิก" />
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--row-4-->

                            </div>
                            <!--card-body id_mt_type, name_mt_type, ref_id_dept, mt_type_remark, status_mt_type-->
                        </div>
                        <!--card-->
                    </div>

                </div>
                <!--row-->
        </div>
        <!--container-->
        <input type="hidden" value="" name="id_vehicle" id="id_vehicle" />
        <input type="hidden" value="" name="id_user" id="id_user" />
        <input type="hidden" value="" name="res_travel" id="res_travel" />
        <input type="hidden" value="<?php echo $_SESSION['car_ref_id_site'] ?>" name="site" id="site" />
        <input type="hidden" value="" name="map_place_id" id="map_place_id" />
        <input type="hidden" value="" name="map_lat" id="map_lat" />
        <input type="hidden" value="" name="map_lon" id="map_lon" />
        <input type="hidden" value="" name="map_zoom" id="map_zoom" />
        </form>
        <!--FORM 1-->
    </div>
</div>