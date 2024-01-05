<?php 
include(__DIR__."/../functions/f-detail.php");

$Call = new HandOver();
$Expense = $Call->getExpense();
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
                                        <p class="card-title text-size-1">&nbsp;ส่งมอบยานพาหนะ</p>
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
                                                                </h5>
                                                                <h6 class="info-box-number text-center mb-0 show_vehicle">
                                                                </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="info-box bg-light">
                                                        <div class="info-box-content">
                                                            <h5 class="info-box-text text-center text-primary">
                                                                ช่วงเวลาการจอง</h5>
                                                                <h6 class="info-box-number text-center mb-0" id="show_date">14 ธันวาคม
                                                                    2566 08.00 น. ถึง 14 ธันวาคม 2566 09.00 น.
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h4 class="text-primary"><strong>รายละเอียดการส่งมอบ</strong></h4>
                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">สภาพภายในรถ</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <div class="form-group clearfix">
                                                                    <div class="icheck-success d-inline mr-2">
                                                                        <input type="radio" id="condition_in1" name="condition_in" value="1" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="condition_in1">
                                                                            ดี
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-danger d-inline">
                                                                        <input type="radio" id="condition_in2" name="condition_in" value="2" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="condition_in2">
                                                                            ไม่ดี
                                                                        </label>
                                                                    </div>
                                                                    <div class="d-inline" id="conditionInWarning">
                                                                        <code>**</code>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-group">
                                                                    <label for=""> แนบรูปภาพ (ถ้ามี): </label>
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-12">
                                                                            <input type="file" name="condition_inFile[]" id="condition_inFile"
                                                                                class="border p-1 w-auto" multiple
                                                                                accept="image/*"
                                                                                aria-describedby="inputGroupPrepend">
                                                                            <div id="condition_inErrMsg" class="text-danger">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div id="condition_inPreview"
                                                                                    class="col-12 img-thumbnail">
                                                                                    <!-- รูปตัวอย่างจะแสดงที่นี่ -->
                                                                                </div>
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">สภาพภายนอกรถ</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <div class="form-group clearfix">
                                                                    <div class="icheck-success d-inline mr-2">
                                                                        <input type="radio" id="condition_out1" name="condition_out" value="1" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="condition_out1">
                                                                            ดี
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-danger d-inline">
                                                                        <input type="radio" id="condition_out2" name="condition_out" value="2" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="condition_out2">
                                                                            ไม่ดี
                                                                        </label>
                                                                    </div>
                                                                    <div class="d-inline" id="conditionOutWarning">
                                                                        <code>**</code>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-group">
                                                                    <label for=""> แนบรูปภาพ (ถ้ามี): </label>
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-12">
                                                                            <input type="file" name="condition_outFile[]" id="condition_outFile"
                                                                                class="border p-1 w-auto" multiple
                                                                                accept="image/*"
                                                                                aria-describedby="inputGroupPrepend">
                                                                            <div id="condition_outErrMsg" class="text-danger">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div id="condition_outPreview"
                                                                                    class="col-12 img-thumbnail">
                                                                                    <!-- รูปตัวอย่างจะแสดงที่นี่ -->
                                                                                </div>
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>

                                        

                                                    <div class="post p-0" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">ปริมาณน้ำมันที่เหลือ</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <ul class="list-unstyled" id="show_companion">
                                                            <li>
                                                                <div class="form-group clearfix">
                                                                    <div class="icheck-success d-inline mr-2">
                                                                        <input type="radio" id="fuel1" name="fuel" value="1" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="fuel1">
                                                                            เต็ม
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-success d-inline mr-2">
                                                                        <input type="radio" id="fuel2" name="fuel" value="2" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="fuel2">
                                                                            เกือบเต็ม
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-warning d-inline mr-2">
                                                                        <input type="radio" id="fuel3" name="fuel" value="3" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="fuel3">
                                                                            ปานกลาง
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-warning d-inline mr-2">
                                                                        <input type="radio" id="fuel4" name="fuel" value="4" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="fuel4">
                                                                            ใกล้หมด
                                                                        </label>
                                                                    </div>
                                                                    <div class="icheck-danger d-inline">
                                                                        <input type="radio" id="fuel5" name="fuel" value="5" aria-describedby="inputGroupPrepend" required>
                                                                        <label for="fuel5">
                                                                            หมด
                                                                        </label>
                                                                    </div>
                                                                    <div class="d-inline" id="fuelWarning" >
                                                                        <code>**</code>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-group">
                                                                    <label for=""> แนบรูปภาพ (ถ้ามี): </label>
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-12">
                                                                            <input type="file" name="fuelFile[]" id="fuelFile"
                                                                                class="border p-1 w-auto" multiple
                                                                                accept="image/*"
                                                                                aria-describedby="inputGroupPrepend">
                                                                            <div id="fuelErrMsg" class="text-danger">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div id="fuelPreview"
                                                                                    class="col-12 img-thumbnail">
                                                                                    <!-- รูปตัวอย่างจะแสดงที่นี่ -->
                                                                                </div>
                                                                            </div>
                                                                          
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="post p-0 div-expense" style="color:#000000;">
                                                        <div>
                                                            <h5 class="text-primary">ค่าใช้จ่าย</h5>
                                                        </div>
                                                        <!-- /.user-block -->
                                                        <div class="row expense-group">
                                                            <div class="col-sm-12 col-md-2 order-2 order-md-1">
                                                                <div class="form-group">
                                                                    <select class="form-control select2bs4" id="expense" name="expense" style="width: 100%;">
                                                                    <?php echo $Expense;?> 
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3 order-3 order-md-2">
                                                                <div class="form-group">
                                                                        <input type="number" min="0" id="expenseAmount" name="expenseAmount" placeholder="จำนวน...(บาท)" class="form-control"/>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3 order-4 order-md-3">
                                                                <div class="form-group">
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-12">
                                                                            <input type="file" name="expenseFile[]" id="expenseFile"
                                                                                class="border p-1 w-100"
                                                                                accept="image/*"
                                                                                aria-describedby="inputGroupPrepend">
                                                                            <!-- <div class="row">
                                                                                <div id="expressPreview"
                                                                                    class="col-12 img-thumbnail">
                                                                              
                                                                                 </div>
                                                                            </div>  -->
                                                                          
                                                                       </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 col-md-3 order-1 order-md-4">
                                                                &nbsp;
                                                                <a class='btn btn-expense-add'><i class='nav-icon fas fa-plus-circle fa-lg' style="color:#4cae4c"></i></a>
                                                                <a class='btn btn-expense-remove'><i class='nav-icon fas fa-minus-circle fa-lg' style="color:#d43f3a"></i></a>
                                                            </div>

                                                        </div>

                                                        <!-- <ul class="list-unstyled" id="show_companion">
                                                            <li>
                                                                <div class="row">
                                                                    <div class="col-2">
                                                                        <input type="number" min="0" id="expressway" name="expressway" class="form-control"/>
                                                                    </div>
                                                                    <div class="col-2 ">
                                                                        <p class="m-0 mt-1"><strong>บาท</strong></p>
                                                                    </div>

                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="form-group">
                                                                    <label for=""> แนบรูปภาพ (ถ้ามี): </label>
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-12">
                                                                            <input type="file" name="expressFile[]" id="expressFile"
                                                                                class="border p-1 w-auto" multiple
                                                                                accept="image/*"
                                                                                aria-describedby="inputGroupPrepend">
                                                                            <div id="expressErrMsg" class="text-danger">
                                                                            </div>
                                                                            <div class="row">
                                                                                <div id="expressPreview"
                                                                                    class="col-12 img-thumbnail">
                                                                                    <!-- รูปตัวอย่างจะแสดงที่นี่ -->
                                                                                <!-- </div>
                                                                            </div> -->
                                                                          
                                                                        <!-- </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul> --> 
                                                    </div>

                                                    <div class="post p-0" style="color:#000000;">
                                                        <div class="row text left">
                                                            <div class="col-lg-2 col-md-12 mb-1">
                                                                <input type="button"
                                                                    class="btn btn-submit btn-success w-100"
                                                                    value="บันทึก" />
                                                            </div>
                                                            <div class="col-lg-2 col-md-12">
                                                                <input type="button"
                                                                    class="btn btn-cancel btn-danger w-100"
                                                                    value="ยกเลิก" />
                                                            </div>
                                                            <input type="hidden" id="id_res" name="id_res" />
                                                            <input type="hidden" id="action" name="action" value="save" />
                                                        </div>
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

<?php include(__DIR__ . "/../component/script_detail.php"); ?>