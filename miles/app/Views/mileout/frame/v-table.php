<?php 
include(__DIR__ . "/../component/style.php");
include(__DIR__ . "/../functions/f-list.php");

$call = new List_Reservation();
$vehicle = $call->getVehicle();
$save = $call->getSave();
include(__DIR__ . "/../frame/v-modal.php");
?>

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-4">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-6 col-lg-6">
                            กก 1234
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <span class="float-sm-right">ผู้จอง : Eua-angkoon</span>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-lg-12">
                <div class="card">
                    <form id="ListForm" class="addform" name="addform" method="POST" enctype="multipart/form-data"
                        autocomplete="off" novalidate="">
                        <div class="row p-1">

                            <div class="col-sm-12 col-md-8">
                                <div class="form-group">
                                    <label for="datetimepicker">วันที่ออกบริษัท</label>
                                    <div class="row">
                                        
                                        <div class="col-sm-12 col-md-5  col-xl-3 pt-1">
                                            <div class="form-group clearfix">
                                                <div class="icheck-primary d-inline mr-1">
                                                    <input type="radio" id="rAll" value="0" name="r1">
                                                    <label for="rAll">
                                                        ทั้งหมด
                                                    </label>
                                                </div>
                                                <div class="icheck-primary d-inline mr-1">
                                                    <input type="radio" id="rDate" value="1" name="r1" checked>
                                                    <label for="rDate">
                                                        เลือกดู
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <div class="input-group date" id="datetimepicker" name="datetimepicker"
                                                data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input"
                                                    id="date_start" name="date_start" data-target="#datetimepicker" />
                                                <div class="input-group-append" data-target="#datetimepicker"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-10 d-inline">
                                        <span class="badge badge-warning mr-2" style="font-size:100%">ช่วงเช้า</span>
                                        <span class="badge badge-success" style="font-size:100%">ช่วงบ่าย</span>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="res_vehicle" name="res_vehicle" value="<?php echo $vehiclePage ?>">
                    </form>
                </div>
            </div>
        </div>
            

            <div class="col-lg-12">
                <div class="card">
                    <div class="row m-2">
                        <div class="col-sm-12 p-0 ">

                            <table id="miles_table" class="table table-hover dataTable dtr-inline nowrap">
                                <thead>
                                    <tr class="text-center">
                                        <!-- <th class="sorting_disabled" style="width:1%">ลำดับ</th> -->
                                        <!-- <th scope="col" style="width:1%">ลำดับ</th> -->
                                        <th scope="col" style="width:5%">จัดการ</th>
                                        <!-- <th scope="col" style="width:5%">รูปภาพ</th> -->
                                        <!-- <th scope="col" style="width:5%">ยานพาหนะ</th> -->
                                        <!-- <th scope="col" style="width:10%">ผู้จอง</th> -->
                                        <th scope="col" style="width:2%">เวลาเดินทาง</th>
                                        <th scope="col" style="width:5%">ผู้ขับรถ</th>
                                        <th scope="col" style="width:10%">ผู้ร่วมเดินทาง</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<?php 
include(__DIR__ . "/../component/script.php");
include(__DIR__ . "/../component/script_dataTable.php");
?>