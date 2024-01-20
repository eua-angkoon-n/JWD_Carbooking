<script>
    $(document).on('click', '.check-status', function () {
        var chk_box = $(this).parent().find('input[type="checkbox"]');
        var id_row = $(this).parent().find('input[type="checkbox"]').data("id");

        if (chk_box.is(":checked") == true) {
            chk_box_text = "ระงับการใช้งาน";
            chk_box_value = 2;
        } else {
            chk_box_text = "ใช้งานรายการนี้";
            chk_box_value = 1;
        }

        swal({
                title: "ยืนยันการทำงาน !",
                text: "คุณต้องการ" + chk_box_text + ". ใช่หรือไม่ ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ใช่, ทำรายการ!",
                cancelButtonText: "ไม่, ยกเลิก!",
                closeOnConfirm: false,
                closeOnCancel: true
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        url: "app/Views/users/functions/f-ajax.php",
                        data: {
                            action: "update-status",
                            chk_box_value: chk_box_value,
                            id_row: id_row
                        },
                        success: function (data) {
                            // console.log(data); //return false;
                            if (data == 1) {
                                swal("สำเร็จ!", "บันทึกข้อมูลเรียบร้อยแล้ว.", "success");
                                if (chk_box.is(":checked") == true) {
                                    ///alert("checked");
                                    chk_box.prop('checked', false);
                                } else {
                                    //alert("ไม่ได้ checked");
                                    chk_box.prop('checked', true);
                                }
                            } else {
                                swal("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้.", "error");
                            }
                        },
                        error: function (data) {
                            swal("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้.", "error");
                        }
                    });
                } else {
                    return true;
                }
            });
        return false;
    });

    $(document).on("click", ".close, .btn-cancel", function (e){ /*ถ้าคลิกปุ่ม Close ให้รีเซ็ตฟรอร์ม และเคลียร์ validated*/
        $('body').find('.was-validated').removeClass();
        $('form').each(function() { this.reset() });
    });    

    $(document).off('click', '.edit-user').on('click', '.edit-user', function () {
      var id_row = $(this).data("id");
      $.ajax({
        type: 'POST',
        url: "app/Views/users/functions/f-ajax.php",
        data: {
          action: "getUser",
          id: id_row
        },
        success: function (data) {
          // console.log(data);
        //   return;
          if (data) {
            var jsonParse = JSON.parse(data);
            if (jsonParse.status == 1) {
              $('#status_use').prop('checked', true);
              $('#status_hold').prop('checked', false);
            } else {
              $('#status_use').prop('checked', false);
              $('#status_hold').prop('checked', true);
            }
            $('#id_row').val(id_row);
            $('#no_user').val(jsonParse.no_user);
            $('#fullname').val(jsonParse.fullname);
            $('#email').val(jsonParse.email);
            $('#div_class').html(jsonParse.class_user);
            $('#div_site').html(jsonParse.site);
            $('#div_dept').html(jsonParse.dept);
            

            // $('#exampleModalLabel span').html("แก้ไขประเภทยานพาหนะ: " + jsonParse.vehicle_type);
          } else {
            swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ", "error");
          }
        },
        error: function (data) {
          swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ.", "error");
        }
      });
    });

    $(document).off('click', '.btn-save_user').on('click', '.btn-save_user', function () {
          var form = document.getElementById('needs-validation');
          var formData = new FormData(form);

          if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
          } else {
              save_user()
          }
          form.classList.add('was-validated');
          return false;
      
    });

    function save_user(){
      var frmData = $('#needs-validation').serialize();
      $.ajax({
        type: 'POST',
        url: "app/Views/users/functions/f-ajax.php",
        data: {
          action: "save_user",
          data: frmData
        },
        success: function (data) {
          // console.log(data);
          // return;
          if (data == 1) {
            sweetAlert("สำเร็จ...", "บันทึกข้อมูลเรียบร้อยแล้ว", "success"); 
            $('#user_table').DataTable().ajax.reload();
            $("#modal-default").modal("hide"); 
            $(".modal-backdrop").hide().fadeOut();
            $("#id_row").val('');
            $('body').find('.was-validated').removeClass();
            $('form').each(function() { this.reset() });
        } else {
          sweetAlert("ผิดพลาด!", "เกิดข้อผิดพลาดในการบันทึกข้อมูล", "error");
          return false;
        }
        },
        error: function (data) {
          swal("ผิดพลาด!", "ไม่พบข้อมูลที่ระบุ.", "error");
        }
      });
    }
</script>