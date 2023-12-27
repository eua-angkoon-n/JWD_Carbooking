<div class="modal fade" id="modal-mile" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="exampleModalLabel"><i
                        class="fas fa-angle-double-right"></i> <span>บันทึกเลขไมล์ออกบริษัท</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-0 py-2">

                <!--FORM 1-->
                <form id="needs-validation" class="addform" name="addform" method="POST" enctype="multipart/form-data"
                    autocomplete="off" novalidate="">
                    <div class="container">
                        <div class="row">

                            <div class="offset-md-0 col-md-12 offset-md-0">
                                <div class="card">
                                    <div class="card-header nav-gradient text-white p-2">
                                        <p class="card-title text-size-1" id="modal_vehicle">กรอกรายละเอียด</p>
                                        <p class="card-title text-size-1 float-right" id="modal_date"></p>
                                    </div>
                                    <div class="card-body p-3">

                                        <div class="row text-primary text-center">
                                            <div class="col-sm-12 col-md-4">
                                                <label>เวลาที่ออก:</label> <span id="modal_date_out"></span>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <label>เลขไมล์ตอนออก:</label> <span id="modal_mile_out"></span>
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <label>ผู้บันทึก:</label> <span id="modal_save_out"></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 col-md-6">
                                                <label>เวลาที่เข้าบริษัท</label>
                                                <div class="input-group date" id="date_outPicker"
                                                    data-target-input="nearest">
                                                    <input type="text" class="form-control datetimepicker-input"
                                                        id="date_out" name="date_out" data-target="#date_outPicker"
                                                        aria-describedby="inputGroupPrepend" required />
                                                    <div class="input-group-append" data-target="#date_outPicker"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <label>จำนวนเลขไมล์ตอนเข้าบริษัท</label>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" id="mile_out"
                                                        name="mile_out" aria-describedby="inputGroupPrepend" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label>ผู้บันทึก</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="save_out"
                                                        name="save_out" aria-describedby="inputGroupPrepend" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <label>หมายเหตุ (ถ้ามี)</label>
                                                <div class="form-group">
                                                    <textarea class="form-control" id="remark_out" name="remark_out"
                                                        rows="3" placeholder="หมายเหตุ..."
                                                        aria-describedby="inputGroupPrepend"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6 col-md-12 col-xs-6">
                                                <div class="form-group">
                                                    <label for="img_out"> ภาพถ่ายเลขไมล์:</label>
                                                    <div class="row-fluid">
                                                        <div class="col-md-12">
                                                            <!-- <input type="file" name="files[]" id="img_out"
                                                                multiple="multiple"
                                                                class="border p-1 with-preview w-auto" /> -->
                                                            <input type="file" name="files[]" id="inputFile"
                                                                class="border p-1 w-auto" multiple accept="image/*"
                                                                aria-describedby="inputGroupPrepend">
                                                            <div id="fileErrorMsg" class="text-danger"></div>
                                                            <div class="row">
                                                                <div id="imagePreview" class="col-12 img-thumbnail">
                                                                    <!-- รูปตัวอย่างจะแสดงที่นี่ -->
                                                                </div>
                                                            </div>
                                                            <span class="text-red font-size-sm mt-2 d-block w-100">
                                                                **ไม่เกิน 3 รูป
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--row-4-->

                                        <!-- <div class="row">
                                            <div class="col-sm-6 col-md-6 col-xs-6">
                                                <div class="form-group">
                                                    <label for="firstname">ประเภทยานพาหนะ <span
                                                            class="text-red font-size-sm">(**ต้องไม่ซ้ำกับที่มีในระบบ)</span></label>
                                                    <input type="text" id="vehicle_type" name="vehicle_type"
                                                        maxlength="60" placeholder="ประเภทยานพาหนะ" class="form-control"
                                                        aria-describedby="inputGroupPrepend" required />
                                                    <div class="invalid-feedback">กรอกประเภทยานพาหนะ</div>
                                                </div>
                                            </div>

                                        </div> -->
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
                    <input type="hidden" value="" name="id_res" id="id_res" />
                </form>
                <!--FORM 1-->

            </div>
            <!--modal-body-->
            <div class="modal-footer justify-content-between">
                <input type="submit" class="btn btn-primary btn-success btn-saveMile" value="บันทึก" />
                <input type="reset" class="btn btn-danger" data-dismiss="modal" value="ยกเลิก" />
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->
