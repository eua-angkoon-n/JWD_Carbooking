<script>
    $(document).ready(function () {

        getImg('condition_inFile', 'condition_inPreview', 'condition_inErrMsg', 3);
        getImg('condition_outFile', 'condition_outPreview', 'condition_outErrMsg', 3);
        getImg('fuelFile', 'fuelPreview', 'fuelErrMsg', 1);
        // getImg('expressFile', 'expressPreview', 'expressErrMsg', 1);
        $('#conditionInWarning').hide();
        $('#conditionOutWarning').hide();
        $('#fuelWarning').hide();
        //input ต่างๆ////////////////////////////////////////////////////////////////
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


        $('#res_status, #res_vehicle, #res_date').change(function () {
            $('#reservation_table').DataTable().ajax.reload();
        });


        <?php if($id != ''){ ?>
            var id = <?php echo $id?>;
            show_reservation(id);
            $('#carouselPage').carousel('next');
            window.scrollTo(0, 0);
        <?php } ?>


        $(document).off("click", ".detailReservation").on("click", ".detailReservation", function (e) {
            var id = $(this).data('id');
            show_reservation(id);
            $('#carouselPage').carousel('next');
            window.scrollTo(0, 0);
            return false;
        });

        $(document).off("click", ".backPage").on("click", ".backPage", function (e) {
            $('.carousel').carousel('prev');
            $('#reservation_table').DataTable().ajax.reload();
        });
            
        $(document).off("click", ".btn-cancel").on("click", ".btn-cancel", function (e) {
            swal({
                title: "ยกเลิก ?",
                text: "ต้องการยกเลิกหรือไม่",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ไม่, ยกเลิก",
                closeOnConfirm: true
            }, function () {
                $('.carousel').carousel('prev');
                $('#reservation_table').DataTable().ajax.reload();
                $('body').find('.was-validated').removeClass();
                $('form').each(function () {
                    this.reset()
                });
                $('#map_olv').html("");
                $(".div-expense .expense-row").remove();
                updateRemoveButtonVisibility()

            });

        });

        $(document).off("click", ".btn-submit").on("click", ".btn-submit", function (e) {

            var form = document.getElementById('showForm');
            var formData = new FormData(form);

            
            if (form.checkValidity() === false) {
                swal({
                        title: "เกิดข้อผิดพลาด!",
                        text: "กรอกรายละเอียดไม่ครบถ้วน",
                        type: "warning",
                        button: {
                            text: "ตกลง",
                        }
                    },
                    function () {
                        event.preventDefault();
                        event.stopPropagation(); 
                    })
            } else {
                swal({
                title: "ส่งมอบ ?",
                text: "ต้องการส่งมอบรถหรือไม่",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "ตกลง",
                cancelButtonText: "ไม่, ยกเลิก",
                closeOnConfirm: true
                }, function () {
                    save_handover();
                });
            }
            form.classList.add('was-validated');
            return false;
        });

    });

     //ฟังก์ชัน    ///////////////////////////////////////////////////////////////////////
     function save_handover(){
        // var frmData = $('#showForm').serialize();

        var formData = new FormData($('form#showForm')[0]);
        
        var expenseArr = expenses(formData);
        var id = $('#id_res').val();

        // เพิ่มข้อมูลจาก expenseArr ลงใน formData
        expenseArr.forEach(function (item, index) {
            formData.append('expenses[' + index + '][expense]', item.expense);
            formData.append('expenses[' + index + '][expenseAmount]', item.expenseAmount);
        });
        
        // console.log(files);
        // return;
        $.ajax({
                url: "app/Views/handover/functions/f-ajax.php",
                type: "POST",
                processData: false,
                contentType: false,
                data: formData,
                beforeSend: function () {},
                success: function (data) {
                    var js = JSON.parse(data);
                    console.log(js);
                    // return;
                    if(js.trim() === "success"){
                        swal({
                                    title: "บันทึกสำเร็จ!",
                                    text: "ทำการส่งมอบเรียบร้อย",
                                    type: "success",
                                },
                                function () {
                                    event.preventDefault();
                                    event.stopPropagation();
                                    window.location.href = '?app=reservationList&id='+id;
                                })
                    } else {
                        sweetAlert("ผิดพลาด!", "เกิดข้อผิดพลาดบางอย่างระหว่างบันทึกข้อมูล", "error");
                        return false;
                    }
                   

                   
                }
            });
     }

     function expenses(){
        var expenseArr = [];

        // สมมติว่าคุณมี wrapper สำหรับแต่ละกลุ่มอินพุต
        $('.expense-group').each(function () {
            var expense = $(this).find('select[name="expense"]').val();
            var expenseAmount = $(this).find('input[name="expenseAmount"]').val();
            var expenseFiles = $(this).find('input[name="expenseFile[]"]')[0].files;

            // สร้างออบเจกต์และเพิ่มเข้าไปในอาร์เรย์
            var expenseObj = {
                expense: expense,
                expenseAmount: expenseAmount,
                expenseFile: expenseFiles
            };
            expenseArr.push(expenseObj);
        });
        return expenseArr;
     }
     
     function show_reservation(id) {
            $.ajax({
                url: "app/Views/handover/functions/f-ajax.php",
                type: "POST",
                data: {
                    "id": id,
                    "action": "detail"
                },
                beforeSend: function () {},
                success: function (data) {
                    var js = JSON.parse(data);
                    console.log(js);
                    // return false;
                    <?php if($_SESSION['car_class_user'] != 1 && $_SESSION['car_class_user'] != 2){ ?>
                        if(js.id_user != <?php echo $_SESSION['car_id_user']?>){
                            window.location.href = '?app=reservationList';
                        }
                    <?php }?>
                    $('.show_vehicle').text(js.vehicle_name);
                    show_date(js.start, js.end);
                    $('#show_user').text(js.userName);
                    $('.show_place').text(js.place_Name);
                    show_vehicle_img(js.attachment, js.date_attachment, 'show_img');
                    show_ribbon(js.status);
                    if (js.lat != '' && js.lat != null) {
                        createStaticMap(js.lat, js.lng, js.zm)
                    } else {
                        $('#map_olv').html("");
                    }
                    $('#id_res').val(js.res_id);
                   
                }
            });
        }


        function show_date(start, end) {
            var months = [
                "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
                "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
            ];

            var startDate = new Date(start);
            var endDate = new Date(end);

            var startDay = startDate.getDate();
            var startMonth = months[startDate.getMonth()];
            var startYear = startDate.getFullYear()

            var startHours = startDate.getHours().toString().padStart(2, '0');
            var startMinutes = startDate.getMinutes().toString().padStart(2, '0');

            var endDay = endDate.getDate();
            var endMonth = months[endDate.getMonth()];
            var endYear = endDate.getFullYear()

            var endHours = endDate.getHours().toString().padStart(2, '0');
            var endMinutes = endDate.getMinutes().toString().padStart(2, '0');

            var showDate =
                `${startDay} ${startMonth} ${startYear} ${startHours}.${startMinutes} น. ถึง ${endDay} ${endMonth} ${endYear} ${endHours}.${endMinutes} น.`;

            $('#show_date').text(showDate);
        }

        function show_vehicle_img(img, date, ID) {
            if (img) {
                var imageName = img;
                var imagePath = 'dist/temp_img/' + date.split('-').join("") + '/';
                var ImageShow = imagePath + imageName;
            } else {
                var ImageShow = 'dist/img/SCGJWDLogo.png';
            }
            var imagePreview = document.getElementById(ID);
            imagePreview.src = ImageShow;
        }

        function show_ribbon(status) {
            $('#Show_Ribbon').removeClass('bg-warning bg-success bg-secondary bg-info');
            var cls;
            var txt;
            switch (status) {
                case '0':
                    cls = "bg-warning";
                    txt = "<?php echo Setting::$reservationStatus[0] ?>";
                    break;
                case '1':
                    cls = "bg-success";
                    txt = "<?php echo Setting::$reservationStatus[1] ?>";
                    break;
                case '2':
                    cls = "bg-danger";
                    txt = "<?php echo Setting::$reservationStatus[2] ?>";
                    break;
                case '3':
                    cls = "bg-info";
                    txt = "<?php echo Setting::$reservationStatus[3] ?>";
                    break;
                case '4':
                    cls = "bg-success";
                    txt = "<?php echo Setting::$reservationStatus[4] ?>";
                    break;
                case '5':
                    cls = "bg-secondary";
                    txt = "<?php echo Setting::$reservationStatus[5] ?>";
                    break;
            }
            $('#Show_Ribbon').text(txt);
            $('#Show_Ribbon').addClass(cls);
        }

        function createStaticMap(lat, lng, zoom) {
            var mapOlv = document.getElementById('map_olv');
            var apiKey = 'AIzaSyD_3uR-M8yPx3Tv8DAgbenP2-vJfxzxSD8';

            var imageUrl = `https://maps.googleapis.com/maps/api/staticmap?center=${lat},${lng}&zoom=${zoom}&size=600x300&maptype=roadmap&markers=color:red%7C${lat},${lng}&key=${apiKey}`;

            var img = document.createElement('img');
            img.src = imageUrl;
            img.alt = 'Static Map';
            img.className = 'w-100 h-100';

            mapOlv.innerHTML = ''; // Clear previous content
            mapOlv.appendChild(img); // Append the image to the map_olv div
        }

        function getImg(inputFile, previewFile, err, max) {
            const input = document.getElementById(inputFile);
            const preview = document.getElementById(previewFile);
            const errMsg = document.getElementById(err);
            var maxFiles = max;

            input.addEventListener('change', function (e) {
                preview.innerHTML = '';
                const files = e.target.files;

                if (files.length > maxFiles) {
                    errMsg.innerHTML = 'คุณสามารถเลือกไฟล์ได้สูงสุด '+max+' ไฟล์เท่านั้น';
                    clearInput(this); // ล้างไฟล์ที่เลือกถ้าเกินจำนวนที่กำหนด
                    return false;
                }

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function (event) {
                        const img = document.createElement('img');
                        img.classList.add('col-md-3', 'img-thumbnail');
                        img.src = event.target.result;
                        img.style.maxWidth = '100%';
                        preview.appendChild(img);
                    };

                    reader.readAsDataURL(file);
                }
            });
        }

        function clearInput(input) {
            input.value = ''; // ล้างไฟล์ที่ถูกเลือก
        }
</script>