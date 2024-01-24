<?php 
include(__DIR__ . "/functions/f-view.php");
$Call = new MainView();
$out = $Call->getOutCount();
$in  = $Call->getInCount();
?>

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0 card-primary card-outline">
                        <a type="button" href="?<?php echo PageSetting::$prefixController ?>=mileout" class="btn btn-default btn-block btn-lg p-5" style="border-radius:0;">
                            <div class="row d-flex align-items-center ">
                                <div class="col-md-12 col-lg-2 ">
                                    <i class="fa fa-tachometer-alt fa-3x text-primary"></i>
                                    <i class="fa fa-caret-right fa-3x text-primary"></i> 
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-8 ">
                                    <h2 class="responsive-font text-primary"> บันทึกเลขไมล์ <strong>ออก</strong>บริษัท</h2>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-2  ">
                                    <span class="badge p-2" style="background-color:#F15C22;color:white;"><?php echo $out;?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body p-0 card-primary card-outline">
                        <a type="button" href="?<?php echo PageSetting::$prefixController ?>=milein" class="btn btn-default btn-block btn-lg p-5" style="border-radius:0;">
                            <div class="row d-flex align-items-center ">
                                <div class="col-md-12 col-lg-2 ">
                               
                                    <i class="fa fa-tachometer-alt fa-3x text-primary"></i>
                                    <i class="fa fa-caret-left fa-3x text-primary"></i> 
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-8 ">
                                    <h2 class="responsive-font text-primary"> บันทึกเลขไมล์ <strong>เข้า</strong>บริษัท</h2>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-2  ">
                                    <span class="badge p-2" style="background-color:#F15C22;color:white;"><?php echo $in;?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- <div class="card">
                    <div class="card-body p-0 card-primary card-outline">
                        <a type="button" href="?<?php echo PageSetting::$prefixController ?>=editMile" class="btn btn-default btn-block btn-lg p-5" style="border-radius:0;">
                            <div class="row d-flex align-items-center ">
                                <div class="col-md-12 col-lg-2 ">
                                    <i class="fa fa-edit fa-2x text-primary"></i> 
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-8 ">
                                    <h2 class="responsive-font text-primary"> แก้ไขเลขไมล์</h2>
                                </div> -->
                                <!-- <div class="col-sm-12 col-md-6 col-lg-2  ">
                                    <span class="badge p-2" style="background-color:#F15C22;color:white;">65</span>
                                </div> -->
                            <!-- </div>
                        </a>
                    </div>
                </div> -->

                <!-- <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>

                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>/.card -->
            </div>
            <!-- /.col-md-6 -->
            <!-- <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>

                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="card-title m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>

                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div> -->
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->