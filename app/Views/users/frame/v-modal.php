<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel"><i class="fas fa-angle-double-right"></i> <span>แก้ไขผู้ใช้งาน</span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body p-0 py-2">

        <!--FORM 1-->
        <form id="needs-validation" class="addform" name="addform" method="POST" enctype="multipart/form-data" autocomplete="off" novalidate="">
        <div class="container">
            <div class="row">

            <div class="offset-md-0 col-md-12 offset-md-0">  
                <div class="card">  
                    <div class="card-header bg-primary text-white p-2"><p class="card-title text-size-1">กรอกรายละเอียด</p></div>
                    <div class="card-body p-3"> 

                        <div class="row row-1">
                        <div class="col-sm-12 col-md-12 col-xs-12">  
                            <div class="form-group mb-2">
                                <label>สถานะการใช้งาน: </label> 
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="status_use" name="status_user" value="1" aria-describedby="inputGroupPrepend" required>
                                        <label class="custom-control-label text-success" for="status_use">ใช้งาน</label>
                                    </div>
                                </div>
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="status_hold" name="status_user" value="2" aria-describedby="inputGroupPrepend" required>
                                        <label class="custom-control-label text-danger w-auto d-inline" for="status_hold">ระงับใช้งาน</label>
                                        <div class="invalid-feedback float-right w-auto pl-3">เลือกสถานะการใช้งาน</div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        </div><!--row-1-->

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">รหัสพนักงาน:</label>
                                    <input type="text" id="no_user" name="no_user" placeholder="รหัสพนักงาน" maxlength="7" class="form-control numbersOnly" aria-describedby="inputGroupPrepend" required />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">ชื่อ-นามสกุล:</label>  
                                    <input type="text" id="fullname" name="fullname" placeholder="รหัสพนักงาน" class="form-control" aria-describedby="inputGroupPrepend" required/>
                                </div>
                            </div>
                        </div><!--row-4 -->

                        <div class="row row-5">
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">อีเมล์:<span class="text-danger">**</span></label>  
                                    <input type="text" id="email" name="email" placeholder="รหัสพนักงาน" class="form-control" aria-describedby="inputGroupPrepend" value="" autocomplete="off" required />
                                    <div class="invalid-feedback">กรอกอีเมล์</div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">รหัสผ่าน:</label>  
                                    <input type="password" id="password" name="password" placeholder="รหัสพนักงาน" class="form-control" aria-describedby="inputGroupPrepend" />
                                </div>
                            </div>
                        </div><!--row-5 -->

                        <div class="row row-6">
                            <div class="col-sm-12 col-md-12 col-xs-12">  
                                <div class="form-group">  
                                    <label for="firstname">ระดับผู้ใช้งาน:<span class="text-danger">**</span></label>  
                                    <div class="form-group clearfix" id="div_class">
                                    </div>
                                </div>
                            </div>
                        </div><!--row-6 -->
<!-- 
                        <div class="row row-7">
                            <div class="col-sm-12 col-md-12 col-xs-12">
                                <div class="form-group">  
                                    <label for="firstname">ไซต์งาน:<span class="text-danger">**</span></label>  
                                    <div class="form-group clearfix" id="div_site">
                                       
                                        </div>
                                    <div class="invalid-feedback">เลือกไซต์งาน</div>
                                </div>
                            </div>
                        </div>

                        <div class="row row-8">
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">แผนก:<span class="text-danger">**</span></label>  
                                    <div class="form-group clearfix" id="div_dept">
                                        
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!--row-8-->

                    </div><!--card-body-->
                </div><!--card-->
            </div>                

            </div><!--row-->
        </div><!--container-->
            <input type="hidden" value="" name="id_row" id="id_row" />
        </form>
        <!--FORM 1-->

    </div><!--modal-body-->
    <div class="modal-footer justify-content-between">
        <input type="submit" class="btn btn-primary btn-submit btn-success btn-save_user" value="บันทึก" />
        <input type="reset" class="btn btn-cancel btn-danger" data-dismiss="modal" value="ยกเลิก" />
    </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->