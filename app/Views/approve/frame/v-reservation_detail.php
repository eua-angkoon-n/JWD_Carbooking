<?php 

?>

<div class="row">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">

        <div class="col-12 p-1">
            <!--FORM 1-->
            <form id="showForm" class="addform" name="addform" method="POST" enctype="multipart/form-data"
                autocomplete="off" novalidate="">
                <div class=" p-0 m-0 w-100 d-flex flex-column">
                    <div class="row p-0 m-0">

                        <div class="offset-md-0 col-md-12 offset-md-0">
                            <div class="card w-100">
                                <div class="card-header bg-primary text-white p-2">
                                    <div class="row">
                                        <button type="button" class="btn btn-xs btn-primary ml-1 backPage">
                                            <i class="fas fa-caret-left"></i>
                                        </button>
                                        <p class="card-title text-size-1">&nbsp;รายละเอียดการจอง</p>
                                    </div>
                                </div>
                                <div class="card-body p-3">

                                    <div class="row">
                                        <div class="col-12 col-md-12 col-lg-8 order-1 order-md-1 order-lg-1">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 ">
                                                    <div class="info-box bg-light">
                                                        <div class="info-box-content">
                                                            <h5 class="info-box-text text-center text-primary">ยานพาหนะ
                                                                </h4>
                                                                <h6 class="info-box-number text-center mb-0 show_vehicle">
                                                                </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="info-box bg-light">
                                                        <div class="info-box-content">
                                                            <h5 class="info-box-text text-center text-primary">
                                                                ช่วงเวลาการจอง</h4>
                                                                <h6 class="info-box-number text-center mb-0" id="show_date">14 ธันวาคม
                                                                    2566 08.00 น. ถึง 14 ธันวาคม 2566 09.00 น.
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4 class="text-primary"><strong>รายละเอียด</strong></h4>
                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">ผู้จอง</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p id="show_user">
                                                            - นายทดสอบ ไว้ก่อน (00000000)
                                                        </p>
                                                    </div>

                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">จุดหมายปลายทาง</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p class="show_place">
                                                            PACS
                                                        </p>
                                                    </div>

                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary" id="show_traveler">ผู้เดินทาง</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <ul class="list-unstyled" id="show_companion">
                                                            <li>
                                                                <a>เต้</a>
                                                            </li>
                                                            <li>
                                                                <a>เอื้ออังกูร</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">เหตุผลในการเดินทาง</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p id="show_reason">
                                                            ไปศึกษางาน
                                                        </p>
                                                    </div>
                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">อุปกรณ์เสริม</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p id="show_acc">
                                                            ไม่มี
                                                        </p>
                                                    </div>
                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">พนักงานขับรถ</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <p id="show_driver">
                                                            ไม่ต้องการ
                                                        </p>
                                                    </div>



                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 order-2 order-md-2 order-lg-2 mb-1">
                                            <div class="card shadow-sm">
                                                <div class="card-header">
                                                    <h3 class="card-title text-primary" style="font-size:1.5rem"><i
                                                            class="fas fa-car"></i> <a class="show_vehicle"></a></h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                    <!-- /.card-tools -->
                                                </div>
                                                <!-- /.card-header -->
                                                <div class="card-body">
                                                    <div class="text-muted">
                                                    <div class="position-relative">
                                                        <img src="dist/temp_img/20231122/4db487a1e559db39b51d4a110f1ebe61.jpg"
                                                            class="img-fluid pad w-50 rounded mx-auto d-block mb-1" id="show_img">
                                                        <div class="ribbon-wrapper ribbon-lg">
                                                            <div class="ribbon text-lg" id="Show_Ribbon">
                                                                Ribbon
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <!-- <img src="dist/temp_img/20231122/4db487a1e559db39b51d4a110f1ebe61.jpg"
                                                            class="img-fluid pad w-50 rounded mx-auto d-block mb-1"
                                                            alt="img-thumbnail" id="show_img"> -->
                                                    </div>

                                                    <div class="row mb-1">
                                                        <h3 class="card-title text-primary"  style="font-size:1.5rem">
                                                            <i class="fas fa-map-marker-alt"></i> <a class="show_place"></a>
                                                        </h3>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-12 col-xs-12  d-flex align-items-stretch">
                                                            <div id="map_olv" class="w-100 h-100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>

                                            <div class="row text-center mt-5" id="show_button">
                                               
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--row-4-->

                            </div>

                        </div>
                        <!--card-->
                    </div>

                </div>
                <!--row-->
        </div>
        <!--container-->

        </form>
        <!--FORM 1-->

    </div>
</div>