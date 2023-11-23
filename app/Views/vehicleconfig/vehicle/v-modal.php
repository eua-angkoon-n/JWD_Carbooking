<?php require_once __DIR__ . "/f-select.php"; 
$Select = new Select(); ?>

<div class="modal fade" id="modal-vehicle" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel"><i class="fas fa-angle-double-right"></i> <span>เพิ่มยานพาหนะ</span></h5>
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
                                        <input type="radio" class="custom-control-input" id="status_use-vehicle" name="vehicle_status" value="1" aria-describedby="inputGroupPrepend" required>
                                        <label class="custom-control-label text-success" for="status_use-vehicle">ใช้งาน</label>
                                    </div>
                                </div>
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="status_hold-vehicle" name="vehicle_status" value="0" aria-describedby="inputGroupPrepend" required>
                                        <label class="custom-control-label text-danger w-auto d-inline" for="status_hold-vehicle">ระงับใช้งาน</label>
                                        <div class="invalid-feedback float-right w-auto pl-3">เลือกสถานะการใช้งาน</div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        </div><!--row-1-->

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">เลขทะเบียน <span class="text-red font-size-sm">(**ต้องไม่ซ้ำกับที่มีในระบบ)</span></label>  
                                    <input type="text" id="vehicle" name="vehicle" maxlength="60" placeholder="เลขทะเบียน" class="form-control" aria-describedby="inputGroupPrepend" required />
                                    <div class="invalid-feedback">กรอกเลขทะเบียน</div>
                                </div>
                            </div>
                        </div><!--row-4-->

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="reg_date">วันที่จดทะเบียนรถ</label>
                                    <div class="input-group date"  data-target-input="nearest">
                                        <input type="text" class="form-control datetimepicker-input" id="reg_date" name="reg_date" data-target="#reg_date" aria-describedby="inputGroupPrepend" required />
                                        <div class="input-group-append" data-target="#reg_date" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--row-4-->

                        <?php echo $Select->getType(); echo $Select->getBrand(); ?>

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="seat">จำนวนที่นั่ง</label>  
                                    <input type="number" id="seat" name="seat" min="1" oninput="validity.valid||(value='');" placeholder="จำนวนที่นั่ง" class="form-control" aria-describedby="inputGroupPrepend" required />
                                    <div class="invalid-feedback">กรอกจำนวนที่นั่ง</div>
                                </div>
                            </div>
                        </div><!--row-4-->

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="seat">หมายเหตุ</label>  
                                    <textarea class="form-control" id="vehicle_remark" name="vehicle_remark" rows="3" placeholder="หมายเหตุ..."  aria-describedby="inputGroupPrepend"></textarea>
                                </div>
                            </div>
                        </div><!--row-4-->

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="files">รูปภาพ</label>  
                                    <div class="custom-file mb-1">
                                        <input type="file" class="custom-file-input" data-maxsize="6000" id="vehicle_files" name="vehicle_files" accept="image/*" aria-describedby='inputGroupPrepend'>
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-xs-6"><span class="alert"></span>
                            <label>ตัวอย่างรูป:</label>  
                            
                            <div id="preview-container">
                                <img src="dist/img/SCGJWDLogo.png" id="image-preview" class="border p-2 w-50 d-block" alt="Image Preview" style="max-width:300px; max-height:300px;">
                            </div>
                                    <!-- <img src="uploads-temp/default.png?ver=1" id="preview" class="border p-2 w-50 d-block" /> -->
                                    <!-- <a class="chk-remove pt-2 d-block text-danger" ><i class="fas fa-trash-alt"></i> ลบรูป</a> -->
                                </div>
                        </div><!--row-4-->

                    </div><!--card-body id_mt_type, name_mt_type, ref_id_dept, mt_type_remark, status_mt_type-->
                </div><!--card-->
            </div>                

            </div><!--row-->
        </div><!--container-->
            <input type="hidden" value="" name="id_vehicle" id="id_vehicle" />
            <input type="hidden" value="" name="action" id="action" />
            <input type="hidden" value="<?php echo 1 ?>" name="site" id="site" />
        </form>
        <!--FORM 1-->

    </div><!--modal-body-->
    <div class="modal-footer justify-content-between">
        <input type="submit" class="btn btn-primary btn-submit-vehicle btn-success" value="บันทึก" />
        <input type="reset" class="btn btn-cancel btn-danger" data-dismiss="modal" value="ยกเลิก" />
    </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->

<script type="text/javascript"> 
 $(function () {
     $('#reg_date').datetimepicker({
         format: 'L',
         defaultDate: new Date()
     });
 });

 $(document).off('change', '#vehicle_files').on('change', '#vehicle_files', function (e) {
     var file = e.target.files[0];
     var reader = new FileReader();
     reader.onload = function (event) {
         var img = new Image();
         img.src = event.target.result;
         img.onload = function () {
             var maxWidth = 300; // Set the maximum width for the image preview
             var maxHeight = 300; // Set the maximum height for the image preview
             var width = this.width;
             var height = this.height;

             if (width > maxWidth || height > maxHeight) {
                 var ratio = Math.min(maxWidth / width, maxHeight / height);
                 width *= ratio;
                 height *= ratio;
             }

             $('#preview-container').html('<img src="' + event.target.result + '" class="img-fluid" alt="Image Preview" style="max-width:' + width + 'px; max-height:' + height + 'px;">');
         };
     };
     reader.readAsDataURL(file);
 });

 $(document).off("click", ".close, .btn-cancel").on("click", ".close, .btn-cancel", function (e) {
     /*ถ้าคลิกปุ่ม Close ให้รีเซ็ตฟรอร์ม และเคลียร์ validated*/
     $('body').find('.was-validated').removeClass();
     $('form').each(function () {
         this.reset()
     });
 });

 $(document).off("click", ".chk-remove").on("click", ".chk-remove", function (e) {
    var imagePath = 'dist/img/SCGJWDLogo.png';
    var imagePreview = document.getElementById('image-preview');
    imagePreview.src = imagePath;
 });

 $(document).off('click', '.btn-submit-vehicle').on("click", ".btn-submit-vehicle", function () {

     event.preventDefault();
     $('#action').val('addData');
     var formAdd = document.getElementById('needs-validation');
     var frm_Data = new FormData($('form#needs-validation')[0]);

     if (formAdd.checkValidity() === false) {
         event.preventDefault();
         event.stopPropagation();
     } else {
         $.ajax({
             url: "app/Views/vehicleconfig/vehicle/f-ajax.php",
             type: "POST",
             data: frm_Data,
             processData: false,
             contentType: false,
             beforeSend: function () {},
             success: function (data) {
                 console.log(data);
                //  return false;
                 if (data == 0) {
                     sweetAlert("ผิดพลาด!", "เลขทะเบียน '" + $("#vehicle").val() + "' ถูกใช้แล้ว", "error");
                     return false;
                 } else {
                     sweetAlert("สำเร็จ...", "บันทึกข้อมูลเรียบร้อยแล้ว", "success"); //The error will display
                     $('#vehicle_table').DataTable().ajax.reload();
                     $("#modal-vehicle").modal("hide");
                     $(".modal-backdrop").hide().fadeOut();
                     sweetAlert("สำเร็จ...", "บันทึกข้อมูลเรียบร้อยแล้ว", "success"); //The error will display
                     $("#id_vehicle").val('');
                     $('body').find('.was-validated').removeClass();
                     $('form').each(function () {
                         this.reset()
                     });
                     $('#action').val('');
                     $('#preview-container').html('<img src="dist/img/SCGJWDLogo.png" id="image-preview" class="border p-2 w-50 d-block" alt="Image Preview" style="max-width:300px; max-height:300px;">');
                 }
                 event.preventDefault();
                 event.stopPropagation();
             },
             error: function (jXHR, textStatus, errorThrown) {
                 //console.log(data);
                 alert(errorThrown);
                 sweetAlert("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้", "error");
             }
         });
         event.preventDefault();
     }
     //alert('Ajax'); return false;
     formAdd.classList.add('was-validated');
     return false;
 });
</script>