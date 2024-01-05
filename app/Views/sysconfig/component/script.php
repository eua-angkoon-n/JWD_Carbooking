<script>
    $(document).ready(function () {

      
        //ปุ่มต่างๆ///////////////////////////////////////////////////////////////////////
        $(document).off("click", ".btn-confirm").on("click", ".btn-confirm", function (e) {

            var form = document.getElementById('configForm');
            var formData = new FormData(form);

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                show_reservation()
            }
            form.classList.add('was-validated');
            return false;
        });


        $(document).off("click", ".btn-submit").on("click", ".btn-submit", function () {

            var form = document.getElementById('configForm');
            var formData = new FormData(form);

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                save_config()
            }
            form.classList.add('was-validated');
            return false;

            

        });

    });

    //จบ ปุ่มต่างๆ///////////////////////////////////////////////////////////////////////
    //ฟังก์ชัน    ///////////////////////////////////////////////////////////////////////

    function save_config(){
        swal({
                title: "บันทึก ?",
                text: "บันทึกการเปลี่ยนแปลง.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ไม่, ยกเลิก",
                closeOnConfirm: false
            }, function () {
                var frmData = $('#configForm').serialize();
                $.ajax({
                    url: "app/Views/sysconfig/functions/f-ajax.php",
                    type: "POST",
                    data: {
                        "frmData": frmData,
                        "action": "save"
                    },
                    beforeSend: function () {},
                    success: function (data) {
                        if(data == 1){
                            swal({
                                    title: "บันทึกสำเร็จ !!",
                                    text: "บันทึกสำเร็จ",
                                    type: "success",
                                },
                                function () {
                                    window.location.href = "?<?php echo PageSetting::$prefixController."=".PageSetting::$AppPage['sysconfig']['href']?>";
                                })
                        } else {
                            console.log(data);
                            sweetAlert("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้", "error");
                        }
                        

                    },
                    error: function (jXHR, textStatus, errorThrown) {
                        //console.log(data);
                        alert(errorThrown);
                        sweetAlert("ผิดพลาด!", "ไม่สามารถบันทึกข้อมูลได้", "error");
                    }
                });
                event.preventDefault();
            });
    }

</script>