<div class="modal fade" id="modal-vehicle_brand" tabindex="-1" role="dialog" aria-labelledby="dataformLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel"><i class="fas fa-angle-double-right"></i> <span>เพิ่มชื่อยี่ห้อยานพาหนะ</span></h5>
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
                                        <input type="radio" class="custom-control-input" id="status_use-vehicle_brand" name="brand_status" value="1" aria-describedby="inputGroupPrepend" required>
                                        <label class="custom-control-label text-success" for="status_use-vehicle_brand">ใช้งาน</label>
                                    </div>
                                </div>
                                <div class="form-check-inline">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" id="status_hold-vehicle_brand" name="brand_status" value="0" aria-describedby="inputGroupPrepend" required>
                                        <label class="custom-control-label text-danger w-auto d-inline" for="status_hold-vehicle_brand">ระงับใช้งาน</label>
                                        <div class="invalid-feedback float-right w-auto pl-3">เลือกสถานะการใช้งาน</div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        </div><!--row-1-->

                        <div class="row row-4">
                            <div class="col-sm-6 col-md-6 col-xs-6">  
                                <div class="form-group">  
                                    <label for="firstname">ยี่ห้อยานพาหนะ <span class="text-red font-size-sm">(**ต้องไม่ซ้ำกับที่มีในระบบ)</span></label>  
                                    <input type="text" id="vehicle_brand" name="vehicle_brand" maxlength="60" placeholder="ยี่ห้อยานพาหนะ" class="form-control" aria-describedby="inputGroupPrepend" required />
                                    <div class="invalid-feedback">กรอกยี่ห้อยานพาหนะ</div>
                                </div>
                            </div>
   
                        </div><!--row-4-->

                    </div><!--card-body id_mt_type, name_mt_type, ref_id_dept, mt_type_remark, status_mt_type-->
                </div><!--card-->
            </div>                

            </div><!--row-->
        </div><!--container-->
            <input type="hidden" value="" name="id_vehicle_brand" id="id_vehicle_brand" />
        </form>
        <!--FORM 1-->

    </div><!--modal-body-->
    <div class="modal-footer justify-content-between">
        <input type="submit" class="btn btn-primary btn-submit-vehicle_brand btn-success" value="บันทึก" />
        <input type="reset" class="btn btn-cancel btn-danger" data-dismiss="modal" value="ยกเลิก" />
    </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal-default -->

<script type="text/javascript"> 


    $(document).on("click", ".close, .btn-cancel", function (e){ /*ถ้าคลิกปุ่ม Close ให้รีเซ็ตฟรอร์ม และเคลียร์ validated*/
        $('body').find('.was-validated').removeClass();
        $('form').each(function() { this.reset() });
    });    

    $(document).off('click', '.btn-submit-vehicle_brand').on("click", ".btn-submit-vehicle_brand", function (){
    var formAdd = document.getElementById('needs-validation');  
    var frmData = $("form#needs-validation").serialize();
 
    if(formAdd.checkValidity()===false) {  
        event.preventDefault();  
        event.stopPropagation();
    }else{
        //alert('Send Ajax'); return false;
        $.ajax({
            url: "app/Views/vehicleconfig/vehicle_brand/f-ajax.php",
            type: "POST",
            data:{"data":frmData, "action":"addData"},
            beforeSend: function () {
            },
            success: function (data) {
            console.log(data);
            // return false;
            if(data==0){
                sweetAlert("ผิดพลาด!", "ชื่อยี่ห้อยานพาหนะ '"+$("#vehicle_brand").val()+"' ถูกใช้แล้ว", "error");
                return false;
            }else{
                sweetAlert("สำเร็จ...", "บันทึกข้อมูลเรียบร้อยแล้ว", "success"); //The error will display
                $('#vehicle_brand_table').DataTable().ajax.reload();
                $("#modal-vehicle_brand").modal("hide"); 
                $(".modal-backdrop").hide().fadeOut();
                sweetAlert("สำเร็จ...", "บันทึกข้อมูลเรียบร้อยแล้ว", "success"); //The error will display
                $("#id_vehicle_brand").val('');
                $('body').find('.was-validated').removeClass();
                $('form').each(function() { this.reset() });
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