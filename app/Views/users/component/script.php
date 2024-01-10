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
</script>