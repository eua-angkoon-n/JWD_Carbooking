<?php 
include __DIR__ . "/../functions/f-list.php";

$Call = new List_Reservation();
$status = $Call->getStatus();
$vehicle = $Call->getVehicle();
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
                                <div class="col-12 col-md-12 col-lg-8 order-1 order-md-1 order-lg-1">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-2 ">
                                            <div class="form-group">
                                                <label for="res_user">สถานะ</label>
                                                <select class="form-control select2bs4" id="res_status"
                                                    name="res_status" style="width: 100%;">
                                                    <?php echo $status; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="res_user">ยานพาหนะ</label>
                                                <select class="form-control select2bs4" id="res_vehicle"
                                                    name="res_vehicle" style="width: 100%;">
                                                    <?php echo $vehicle; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-3">
                                            <div class="form-group">
                                                <label for="res_user">วันที่ทำการจอง</label>
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
                                                <th scope="col" style="width:4%">ผู้เดินทาง</th>
                                                <th scope="col" style="width:5%">จุดหมายปลายทาง</th>
                                                <th scope="col" style="width:5%">อุปกรณ์เสริม</th>
                                                <th scope="col" style="width:5%">วันที่จอง</th>
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