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

    document.addEventListener("DOMContentLoaded", function () {
        var inputPassword = document.getElementById("l_token");
        var toggleVisibilityBtn = document.getElementById("toggleVisibilityBtn");
        var eyeIcon = document.getElementById("eyeIcon");

        toggleVisibilityBtn.addEventListener("click", function () {
            if (inputPassword.type === "password") {
                inputPassword.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                inputPassword.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        });
    });

    <?php if ($_SESSION['car_class_user'] == 2) { ?>
    document.addEventListener("DOMContentLoaded", function () {
        var inputPassword = document.getElementById("l_token_main");
        var toggleVisibilityBtn = document.getElementById("toggleVisibilityBtn2");
        var eyeIcon = document.getElementById("eyeIcon2");

        toggleVisibilityBtn.addEventListener("click", function () {
            if (inputPassword.type === "password") {
                inputPassword.type = "text";
                eyeIcon.classList.remove("fa-eye-slash");
                eyeIcon.classList.add("fa-eye");
            } else {
                inputPassword.type = "password";
                eyeIcon.classList.remove("fa-eye");
                eyeIcon.classList.add("fa-eye-slash");
            }
        });
    });
    <?php } ?>

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
                        // console.log(data);return;
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